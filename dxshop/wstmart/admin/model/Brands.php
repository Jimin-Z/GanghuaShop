<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\Brands as validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 品牌业务处理
 */
class Brands extends Base{
	protected $pk = 'brandId';
	/**
	 * 分页
	 */
	public function pageQuery(){
		$key = input('key');
		$id = input('id/d');
		$where[] = ['b.dataFlag','=',1];
		if($key!='')$where[] = ['b.brandName','like','%'.$key.'%'];
		if($id>0)$where[] = ['gcb.catId','=',$id];
		$total = Db::name('brands')->alias('b');
		if($id>0){
		    $total->join('__CAT_BRANDS__ gcb','b.brandId = gcb.brandId','left');
		}
		$page = $total->where($where)
		->field('b.brandId,b.brandName,b.brandImg,b.brandDesc,b.sortNo')
		->order('b.brandId', 'desc')
		->paginate(input('limit/d'))->toArray();
		if(count($page['data'])>0){
			foreach ($page['data'] as $key => $v){
				$page['data'][$key]['brandDesc'] = strip_tags(htmlspecialchars_decode($v['brandDesc']));
			}
		}
		return $page;
	}

    /**
     * 获取品牌下的商家分页
     */
	public function shopPageQuery(){
        $key = input('key');
        $brandId = input('brandId');
        $where[] = ['b.dataFlag','=',1];
        $where[] = ['b.applyStatus','=',1];
        $where[] = ['b.brandId','=',$brandId];
        if($key!='')$where[] = ['s.shopName','like','%'.$key.'%'];
        $page = Db::name('brand_applys')->alias('b')
            ->join('__SHOPS__ s','b.shopId = s.shopId','left')
            ->where($where)
            ->field('b.applyId,b.brandId,b.createTime,s.shopName')
            ->order('b.applyId', 'asc')
            ->paginate(input('limit/d'))->toArray();
        return $page;
    }

	/**
	 * 获取指定对象
	 */
	public function getById($id){
		$result = $this->where(['brandId'=>$id])->find();
        $result['brandDesc'] = htmlspecialchars_decode($result['brandDesc']);
		//获取关联的分类
		$result['catIds'] = Db::name('cat_brands')->where(['brandId'=>$id])->column('catId');
		return $result;
	}

	/**
	 * 新增
	 */
	public function add(){
		$data = input('post.');
		WSTUnset($data,'brandId,dataFlag');
		$data['createTime'] = date('Y-m-d H:i:s');
		$idsStr = explode(',',$data['catId']);
		if($idsStr!=''){
			foreach ($idsStr as $v){
				if((int)$v>0)$ids[] = (int)$v;
			}
		}
		Db::startTrans();
        try{
        	$validate = new validate();
		    if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
			$result = $this->allowField(true)->save($data);
			if(false !== $result){
				WSTClearAllCache();
				//启用上传图片
			    WSTUseResource(1, $this->brandId, $data['brandImg']);
				//商品描述图片
				WSTEditorImageRocord(1, $this->brandId, '',$data['brandDesc']);
				foreach ($ids as $key =>$v){
					$d = array();
					$d['catId'] = $v;
					$d['brandId'] = $this->brandId;
					Db::name('cat_brands')->insert($d);
				}
				Db::commit();
				return WSTReturn("新增成功", 1);
			}
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('新增失败',-1);
	}

	/**
	 * 编辑
	 */
	public function edit(){
		$brandId = input('post.id/d');
		$data = input('post.');
		$idsStr = explode(',',$data['catId']);
		if($idsStr!=''){
			foreach ($idsStr as $v){
				if((int)$v>0)$ids[] = (int)$v;
			}
		}
		$filter = array();
		//获取品牌的关联分类
		$catBrands = Db::name('cat_brands')->where(['brandId'=>$brandId])->select();
		foreach ($catBrands as $key =>$v){
			if(!in_array($v['catId'],$ids))$filter[] = $v['catId'];
		}
		Db::startTrans();
        try{
			WSTUseResource(1, $brandId, $data['brandImg'], 'brands', 'brandImg');
			// 品牌描述图片
			$desc = $this->where('brandId',$brandId)->value('brandDesc');
			WSTEditorImageRocord(1, $brandId, $desc, $data['brandDesc']);
			$validate = new validate();
		    if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
			$result = $this->allowField(['brandName','brandImg','brandDesc','sortNo'])->save($data,['brandId'=>$brandId]);
			if(false !== $result){
				WSTClearAllCache();
				foreach ($catBrands as $key =>$v){
					Db::name('cat_brands')->where('brandId',$brandId)->delete();
				}
				foreach ($ids as $key =>$v){
					$d = array();
					$d['catId'] = $v;
					$d['brandId'] = $brandId;
					Db::name('cat_brands')->insert($d);
				}
				Db::commit();
				return WSTReturn("修改成功", 1);
			}
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('修改失败',-1);
	}

	/**
	 * 删除
	 */
	public function del(){
		$id = input('post.id/d');
		$data = [];
		$data['dataFlag'] = -1;
        $joinIds = Db::name('brand_applys')->where(['brandId'=>$id])->column('applyId');
		Db::startTrans();
        try{
			$result = $this->where(['brandId'=>$id])->update($data);
            Db::name('brand_applys')->where(['brandId'=>$id])->update($data);
		    WSTUnuseResource('brands','brandImg',$id);
			// 品牌描述图片
			$desc = $this->where('brandId',$id)->value('brandDesc');
			WSTEditorImageRocord(1, $id, $desc,'');
            // 将加盟的品牌的品牌授权书图片设置成无效
            for($i=0;$i<count($joinIds);$i++){
                WSTUnuseResource('brand_applys','accreditImg',$joinIds[$i]);
            }
			if(false !== $result){
				WSTClearAllCache();
				//删除推荐品牌
				Db::name('recommends')->where(['dataSrc'=>2,'dataId'=>$id])->delete();
				//删除品牌和分类的关系
				Db::name('cat_brands')->where(['brandId'=>$id])->delete();
				Db::commit();
				return WSTReturn("删除成功", 1);
			}
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('删除失败',-1);
	}

	/**
	 * 获取品牌
	 */
	public function searchBrands(){
		$goodsCatatId = (int)input('post.goodsCatId');
		if($goodsCatatId<=0)return [];
		$key = input('post.key');
		$where[] = ['dataFlag','=',1];
		$where[] = ['catId','=',$goodsCatatId];
		if($key!='')$where[] = ['brandName','like','%'.$key.'%'];
		return $this->alias('s')->join('__CAT_BRANDS__ cb','s.brandId=cb.brandId','inner')
		            ->where($where)->field('brandName,s.brandId')->select();
	}
	/**
	 * 排序字母
	 */
	public function letterObtain(){
		$areaName =  input('code');
		if($areaName =='')return WSTReturn("", 1);
		$areaName = WSTGetFirstCharter($areaName);
		if($areaName){
			return WSTReturn($areaName, 1);
		}else{
			return WSTReturn("", 1);
		}
	}

	/**
	* 修改品牌排序
	*/
	public function changeSort(){
		$id = (int)input('id');
		$sortNo = (int)input('sortNo');
		$result = $this->setField(['brandId'=>$id,'sortNo'=>$sortNo]);
		if(false !== $result){
        	return WSTReturn("操作成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
}

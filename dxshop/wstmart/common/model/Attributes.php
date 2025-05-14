<?php
namespace wstmart\common\model;
use wstmart\common\validate\Attributes as validate;
use wstmart\common\model\GoodsCats as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品属性分类
 */
use \think\Db;
class Attributes extends Base{
	/**
	 * 获取可供筛选的商品属性
	 */
	public function listQueryByFilter($catId){
		$m = new M();
		$ids = $m->getParentIs($catId);
		if(!empty($ids)){
			$catIds = [];
			foreach ($ids as $key =>$v){
				$catIds[] = $v;
			}
			// 取出分类下有设置的属性。
			$attrs = Db::name('attributes')->where(['isShow'=>1,'dataFlag'=>1,'shopId'=>0])
					  ->where([['goodsCatId','in',$catIds],['attrType','<>',0]])
			          ->field('attrId,attrName,attrVal')->order('attrSort asc')->select();
			foreach ($attrs as $key =>$v){
			    $attrs[$key]['attrVal'] = explode(',',$v['attrVal']);
			}
			return $attrs;
		}
		return [];
	}
	/**
	* 根据商品id获取可供选择的属性
	*/
	public function getAttribute($goodsId){
		if(empty($goodsId))return [];
		$attrs = Db::name('attributes')->alias('a')
					  ->join('__GOODS_ATTRIBUTES__ ga','ga.attrId=a.attrId','inner')
					  ->field('ga.attrId,GROUP_CONCAT(distinct ga.attrVal) attrVal,a.attrName')
					  ->where(['a.isShow'=>1,'a.dataFlag'=>1])
					  	->where([['ga.goodsId','in',$goodsId],['a.attrType','<>',0]])
					  ->group('ga.attrId')
					  ->order('a.attrSort asc')
					  ->select();
		if(empty($attrs))return [];
		foreach ($attrs as $key =>$v){
			    $attrs[$key]['attrVal'] = explode(',',$v['attrVal']);
		}
		return $attrs;
	}





	/**
	 * 新增
	 */
	public function add($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$data = input('post.');
		WSTUnset($data, 'attrId,dataFlag');
		$data['createTime'] = date('Y-m-d H:i:s');
		$data['attrVal'] = str_replace('，',',',$data['attrVal']);
		$data["dataFlag"] = 1;
		$data["shopId"] = $shopId;
		$data["attrSort"] = (int)$data["attrSort"];
		$goodsCats = model('GoodsCats')->getParentIs($data['goodsCatId']);
		krsort($goodsCats);
		if(!empty($goodsCats))$data['goodsCatPath'] = implode('_',$goodsCats)."_";
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(true)->save($data);
        if(false !== $result){
        	return WSTReturn("新增成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
    /**
	 * 编辑
	 */
	public function edit($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$attrId = input('post.attrId/d');
		$data = input('post.');
		$data["attrSort"] = (int)$data["attrSort"];
		WSTUnset($data, 'attrId,dataFlag,createTime');
        $attrType = (int)$data["attrType"];
		$attrVal = str_replace('，',',',$data['attrVal']);
        $data['attrVal'] = $attrVal;
        $flag = false;//属性类型，属性值是否改变标识
        $oattr = Db::name("attributes")->where(['attrId'=>$attrId,'shopId'=>$shopId])->find();
        //判断属性类型是否改变
        if($attrType!=$oattr['attrType'] || $attrVal!=$oattr['attrVal']){
            $flag = true;
        }

		$goodsCats = model('GoodsCats')->getParentIs($data['goodsCatId']);
		krsort($goodsCats);
		if(!empty($goodsCats))$data['goodsCatPath'] = implode('_',$goodsCats)."_";
		$validate = new validate();
		if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
	    $result = $this->allowField(true)->save($data,['attrId'=>$attrId,'shopId'=>$shopId]);
        if(false !== $result){
            if($flag){
                $where = [];
                $where['shopId'] = $shopId;
                $where['attrId'] = $attrId;
                Db::name('goods_attributes')->where($where)->delete();
            }
        	return WSTReturn("编辑成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 删除
	 */
    public function del($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
	    $attrId = input('post.attrId/d');
	    $data["dataFlag"] = -1;
	  	$result = $this->save($data,['attrId'=>$attrId,'shopId'=>$shopId]);
        if(false !== $result){
        	$where = [];
        	$where['shopId'] = $shopId;
        	$where['attrId'] = $attrId;
        	Db::name('goods_attributes')->where($where)->delete();
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}

	/**
	 *
	 * 根据ID获取
	 */
	public function getById($attrId,$sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$obj = null;
		if($attrId>0){
			$obj = $this->get(['attrId'=>$attrId,'dataFlag'=>1,'shopId'=>$shopId]);
		}else{
			$obj = self::getEModel("attributes");
		}
		return $obj;
	}

	/**
	 * 显示隐藏
	 */
	public function setToggle($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$attrId = input('post.attrId/d');
		$isShow = input('post.isShow/d');

		$result = $this->where(['attrId'=>$attrId,'shopId'=>$shopId,"dataFlag"=>1])->setField("isShow", $isShow);
		if(false !== $result){
			return WSTReturn("设置成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}

	/**
	 * 分页
	 */
	public function pageQuery($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$attrSrc = (int)input('attrSrc');
		$keyName = input('keyName');
		$goodsCatPath = input('goodsCatPath');
		$dbo = $this->field(true);
		$map[] = ['dataFlag','=',1];
		if($attrSrc==1){
			$map[] = ['shopId','=',0];
		}else if($attrSrc==2){
			$map[] = ['shopId','=',$shopId];
		}else{
			$map[] = ['shopId','in',[0,$shopId]];
		}
		if($keyName!="")$map[] = ['attrName',"like","%".$keyName."%"];
		if($goodsCatPath!='')$map[] = ['goodsCatPath',"like",$goodsCatPath."_%"];
		$page = $dbo->field(true)->where($map)->order('shopId desc,attrId desc')->paginate(input('limit/d'))->toArray();
	    if(count($page['data'])>0){
			$keyCats = model('GoodsCats')->listKeyAll();
			foreach ($page['data'] as $key => $v){
				$goodsCatPath = $page['data'][$key]['goodsCatPath'];
				$page['data'][$key]['goodsCatNames'] = self::getGoodsCatNames($goodsCatPath,$keyCats);
				$page['data'][$key]['children'] = [];
				$page['data'][$key]['isextend'] = false;
			}
		}
		return $page;
	}

    public function getGoodsCatNames($goodsCatPath, $keyCats){
		$catIds = explode("_",$goodsCatPath);
		$catNames = array();
		for($i=0,$k=count($catIds);$i<$k;$i++){
			if($catIds[$i]=='')continue;
			if(isset($keyCats[$catIds[$i]]))$catNames[] = $keyCats[$catIds[$i]];
		}
		return implode("→",$catNames);
	}

	/**
	 * 列表
	 */
	public function listQuery(){
		$catId = input("post.catId/d");
		$rs = $this->field("attrId id, attrId, catId, attrName name,  '' goodsCatNames")->where(["dataFlag"=>1,"catId"=>$catId])->sort('attrSort asc,attrId asc')->select();
		return $rs;
	}
}

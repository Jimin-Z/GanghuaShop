<?php
namespace wstmart\common\model;
use wstmart\common\validate\SpecCats as validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 规格分类业务处理
 */
class SpecCats extends Base{

	/**
	 * 新增
	 */
	public function add($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$isExistAllowImg = false;
		$msg = '';
		$data = input('post.');
		if($data['isAllowImg']==1){
			if($this->checkExistAllowImg((int)$data['goodsCatId'],0)){
				return WSTReturn("同一分类下已存在允许上传图片规格类型，请先修改之后再新增");
			}
		}
		$data['createTime'] = date('Y-m-d H:i:s');
		$data["dataFlag"] = 1;
		$data["shopId"] = $shopId;
		$goodsCats = model('GoodsCats')->getParentIs($data['goodsCatId']);
		if(!empty($goodsCats))$data['goodsCatPath'] = implode('_',$goodsCats)."_";
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(['catName','isShow','isAllowImg','goodsCatPath','goodsCatId','dataFlag','createTime','shopId'])->save($data);
        if(false !== $result){
        	return WSTReturn("新增成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 检测是否存在统一分类下的上传图片分类
	 */
	public function checkExistAllowImg($goodsCatId,$catId){
		$dbo = $this->where(['goodsCatId'=>$goodsCatId,'dataFlag'=>1,'isAllowImg'=>1]);
		if($catId>0)$dbo->where('catId','<>',$catId);
		$rs = $dbo->count();
		if($rs>0)return true;
		return false;
	}
    /**
	 * 编辑
	 */
	public function edit($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$catId = input('post.catId/d');
		$data = input('post.');
	    if($data['isAllowImg']==1){
			if($this->checkExistAllowImg((int)$data['goodsCatId'],$catId)){
				return WSTReturn("同一分类下已存在允许上传图片规格类型，请先修改之后再保存");
			}
		}
		$goodsCats = model('GoodsCats')->getParentIs($data['goodsCatId']);
		if(!empty($goodsCats))$data['goodsCatPath'] = implode('_',$goodsCats)."_";
		$validate = new validate();
		if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
	    $result = $this->allowField(['catName','goodsCatPath','goodsCatId','isShow','isAllowImg'])
	    ->save($data,['catId'=>$catId,"dataFlag"=>1,'shopId'=>$shopId]);
        if(false !== $result){
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
	    $catId = input('post.catId/d');
	    $data["dataFlag"] = -1;
	  	$result = $this->save($data,['catId'=>$catId,'shopId'=>$shopId]);
        if(false !== $result){
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}

	/**
	 * 显示隐藏
	 */
	public function setToggle($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$catId = input('post.catId/d');
		$isShow = input('post.isShow/d');
		$result = $this->where(['shopId'=>$shopId,'catId'=>$catId,"dataFlag"=>1])->setField("isShow", $isShow);
		if(false !== $result){
			return WSTReturn("设置成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}

	/**
	 *
	 * 根据ID获取
	 */
	public function getById($catId,$sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$obj = null;
		if($catId>0){
			$obj = $this->get(['shopId'=>$shopId,'catId'=>$catId,"dataFlag"=>1]);
		}else{
			$obj = self::getEModel("spec_cats");
		}
		return $obj;
	}


	/**
	 * 分页
	 */
	public function pageQuery($sId=0){
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$specSrc = (int)input('specSrc');
		$keyName = input('keyName');
		$goodsCatPath = input('goodsCatPath');
		$dbo = $this->field(true);
		$map = array();
		$map[] = ['dataFlag','=',1];
		if($specSrc==1){
			$map[] = ['shopId','=',0];
		}else if($specSrc==2){
			$map[] = ['shopId','=',$shopId];
		}else{
			$map[] = ['shopId','in',[0,$shopId]];
		}
		if($keyName!="")$map[] = ['catName',"like","%".$keyName."%"];
		if($goodsCatPath!='')$map[] = ['goodsCatPath',"like",$goodsCatPath."_%"];
		$dbo = $dbo->field("catName name, catId id, isShow ,isAllowImg")->where($map);
		$page = $dbo->order('shopId desc,catId desc')->paginate(input('limit/d'))->toArray();
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
}

<?php
namespace wstmart\shop\model;
use wstmart\common\model\Express as CExpress;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 门店管理员类
 */
class Express extends CExpress{

	public function toggleSet(){
		$shopId = (int)session('WST_USER.shopId');
		$expressId = (int)input("expressId");
		$spExpress = Db::name("shop_express")->where(["shopId"=>$shopId,"expressId"=>$expressId,"dataFlag"=>1])->find();
		if(empty($spExpress) || $spExpress['isEnable']==0){
			return WSTReturn("无效操作", -1);
		}else{
			Db::startTrans();
			try{
				Db::name("shop_express")->where(["shopId"=>$shopId,"dataFlag"=>1])->update(['isDefault'=>0]	);
				Db::name("shop_express")->where(["shopId"=>$shopId,"expressId"=>$expressId,"dataFlag"=>1])->update(['isDefault'=>1]);
				Db::commit();
				return WSTReturn("设置成功", 1);
			}catch (\Exception $e) {
	        	Db::rollback();
	        }
		}
	}

	public function getById(){
		$id = (int)input("id");
		$rs = $this->where(["id"=>$id,'isShow'=>1])->find();
		return $rs;
	}

}

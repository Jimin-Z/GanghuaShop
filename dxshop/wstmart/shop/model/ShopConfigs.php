<?php
namespace wstmart\shop\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 门店配置类
 */
use think\Db;
class ShopConfigs extends Base{
    /**
    * 店铺设置
    */
     public function getShopCfg($id){
        $rs = $this->where("shopId=".$id)->find();
        if($rs != ''){
            //图片
            $rs['shopAds'] = ($rs['shopAds']!='')?explode(',',$rs['shopAds']):null;
            //图片的广告地址
            $rs['shopAdsUrl'] = ($rs['shopAdsUrl']!='')?explode(',',$rs['shopAdsUrl']):null;
            return $rs;
        }
     }

     /**
      * 修改店铺设置
      */
     public function editShopCfg($shopId){
        $data = input('post.');
        //加载商店信息
        Db::startTrans();
		try{
	        $shopcg = $this->where('shopId='.$shopId)->find();
	        $scdata = array();
	        $scdata["shopTitleWords"] =  input("shopTitleWords");
            $scdata["shopKeywords"] =  input("shopKeywords");
	        $scdata["shopBanner"] =  input("shopBanner");
            $scdata["shopMoveBanner"] =  input("shopMoveBanner");
	        $scdata["shopDesc"] =  input("shopDesc");
	        $scdata["shopAds"] =  input("shopAds");
	        $scdata["shopAdsUrl"] =  input("shopAdsUrl");
            $scdata["shopHotWords"] =  input("shopHotWords");
	        $scdata["shopStreetImg"] =  input("shopStreetImg");
            WSTUseResource(0, $shopcg['configId'], $scdata['shopStreetImg'],'shop_configs','shopStreetImg');
	        WSTUseResource(0, $shopcg['configId'], $scdata['shopBanner'],'shop_configs','shopBanner');
	        WSTUseResource(0, $shopcg['configId'], $scdata['shopAds'],'shop_configs','shopAds');
	        $rs = $this->where("shopId=".$shopId)->update($scdata);
	        if($rs!==false){
	        	Db::commit();
	            return WSTReturn('操作成功',1);
	        }
		}catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('操作失败',-1);
     }
     /**
      * 获取商城搜索关键字
      */
     public function searchShopkey($shopId){
     	$rs = $this->where('shopId='.$shopId)->field('configId,shopHotWords')->find();
     	$keys = [];
     	if($rs['shopHotWords']!='')$keys = explode(',',$rs['shopHotWords']);
     	return $keys;
     }
}

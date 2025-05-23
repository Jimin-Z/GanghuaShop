<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 自提点
 */
class Stores extends Base{

    protected $pk = 'storeId';

    public function checkSupportStores($userId){
      $list = Db::name("carts c")->join("goods g","c.goodsId=g.goodsId")
                ->where(["userId"=>$userId,"isCheck"=>1])
                ->field("g.shopId")
                ->group("g.shopId")
                ->select();
      $shopIds = [];
      foreach ($list as $k => $v) {
        $shopIds[] = $v["shopId"];
      }
      $where = [];
      $where[] = ["shopId","in",$shopIds];
      $where[] = ["dataFlag","=",1];
      $where[] = ["storeStatus","=",1];
      $rs = Db::name("stores")->where($where)->field("shopId")->group("shopId")->select();
      $storeMap = [];
      foreach ($rs as $k => $v) {
        $storeMap[$v["shopId"]] = 1;
      }
      return $storeMap;
    }

    /**
    * 获取列表
    */
    public function shopStores($userId){
        $addressId = input("addressId");
        $address = Db::name("user_address")->where(["userId"=>$userId,"addressId"=>$addressId])->field("areaId")->find();
        $rs = [];
        $where = [];
        $where2 = [];
        $shopId = (int)input("shopId");
        $areaId = (int)$address['areaId'];
        $areaId2 = (int)input("areaId",0);
        $where[] = ["shopId","=",$shopId];
        $where[] = ["dataFlag","=",1];
        $where[] = ["storeStatus","=",1];
        $field = "storeId,shopId,areaIdPath,storeName,storeTel,storeAddress";
        if(!empty($address)){
            // 用户有收货地址
            if($areaId2>0){
                $where2[] = ["areaId","=",$areaId2];
            }else{
                $where2[] = ["areaId","=",$areaId];
            }
            $rs = Db::name("stores")->where($where)->where($where2)->field($field)->limit(100)->select();
            // 用户的收货地址没有自提点，则取店铺的一个自提点
            if(empty($rs)){
                $condition = [];
                if($areaId2>0){
                    $condition[] = ["areaId","=",$areaId2];
                }
                $rs = Db::name("stores")->where($where)->where($condition)->field($field)->limit(1)->select();
            }
        }else{
            // 用户没有收货地址
            if($areaId2>0)$where2[] = ["areaId","=",$areaId2];
            $rs = Db::name("stores")->where($where)->where($where2)->field($field)->limit(100)->select();
        }
        return $rs;
    }

    /**
    * 获取列表
    */
    public function listQuery(){
      $where = [];
      $shopId = (int)input("shopId");
      $areaId = (int)input("areaId");
      $where[] = ["areaId","=",$areaId];
      $where[] = ["shopId","=",$shopId];
      $where[] = ["dataFlag","=",1];
      $where[] = ["storeStatus","=",1];
      $rs = Db::name("stores")->where($where)->field("storeId,shopId,areaIdPath,storeName,storeTel,storeAddress")->limit(100)->select();
      return $rs;
    }

}

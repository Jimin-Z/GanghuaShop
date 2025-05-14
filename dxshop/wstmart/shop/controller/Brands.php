<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Brands as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 品牌控制器
 */
class Brands extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
     * 获取品牌列表
     */
    public function listQuery(){
        $m = new M();
        $shopId = (int)session('WST_USER.shopId');
        return ['status'=>1,'list'=>$m->shopBrandListQuery($shopId,input('post.catId/d'))];
    }
}

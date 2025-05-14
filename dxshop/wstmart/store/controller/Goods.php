<?php
namespace wstmart\store\controller;
use wstmart\store\model\Goods as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品控制器
 */
class Goods extends Base{
    protected $beforeActionList = ['checkAuth'];

    /**
     *  上架商品列表
     */
    public function index(){
        $this->assign("p",(int)input("p"));
        return $this->fetch('goods/list_sale');
    }
    /**
     * 获取上架商品列表
     */
    public function saleByPage(){
        $m = new M();
        $shopId = (int)session('WST_STORE.shopId');
        $rs = $m->saleByPage($shopId,1);
        $rs['status'] = 1;
        return WSTLayGrid($rs);
    }

}

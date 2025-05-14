<?php
namespace wstmart\shop\controller;
use wstmart\common\model\GoodsAppraises as M;
use wstmart\shop\model\GoodsAppraises as N;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 评价控制器
 */
class GoodsAppraises extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
     * 获取评价列表 商家
     */
    public function index(){
        return $this->fetch('goodsappraises/list');
    }
    // 获取评价列表 商家
    public function queryByPage(){
        $m = new N();
        return WSTReturn('',1,$m->queryByPage());
    }

    /**
     * 商家回复评价
     */
    public function shopReply(){
        $m = new M();
        return $m->shopReply();
    }

    /**
     * 商家举报评价
     */
    public function shopReport(){
        $m = new M();
        return $m->shopReport();
    }
}

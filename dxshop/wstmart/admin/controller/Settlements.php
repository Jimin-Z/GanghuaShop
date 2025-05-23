<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Settlements as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 结算控制器
 */
class Settlements extends Base{
    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch('list');
    }

    /**
     * 获取列表
     */
    public function pageQuery(){
    	$m = new M();
    	return WSTLayGrid($m->pageQuery());
    }

    /**
     *  跳去结算详情
     */
    public function toView(){
    	$m = new M();
    	$object = $m->getById();
        $this->assign("p",(int)input("p"));
    	$this->assign("object",$object);
    	return $this->fetch('view');
    }

    /**
     * 获取订单商品
     */
    public function pageGoodsQuery(){
        $m = new M();
        return WSTLayGrid($m->pageGoodsQuery());
    }

    /*************************************************
     *          以下是平台主动生成结算单
     ************************************************/
    /**
     * 进入平台结算
     */
    public function toShopIndex(){
        $this->assign("areaList",model('areas')->listQuery(0));
        $this->assign("p",(int)input("p"));
        return $this->fetch('list_shop');
    }

    /**
     * 获取待结算的商家列表
     */
    public function pageShopQuery(){
        $m = new M();
        return WSTLayGrid($m->pageShopQuery());
    }
    /**
     * 进入订单列表页面
     */
    public function toOrders(){
        $this->assign("id",(int)input('id'));
        $this->assign("p",(int)input("p"));
        return $this->fetch('list_order');
    }
    /**
     * 获取商家的待结算订单列表
     */
    public function pageShopOrderQuery(){
        $m = new M();
        return WSTLayGrid($m->pageShopOrderQuery());
    }

    /**
     * 导出
     */
    public function toExport(){
        $m = new M();
        $rs = $m->toExport();
        $this->assign('rs',$rs);
    }

    /**
     * 结算佣金统计
     */
    public function statPageQuery(){
        $m = new M();
        return WSTLayGrid($m->statPageQuery());
    }
}

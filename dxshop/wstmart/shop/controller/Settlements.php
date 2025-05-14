<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Settlements as CM;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 结算控制器
 */
class Settlements extends Base{
    protected $beforeActionList = ['checkAuth'];
    public function index(){
        $this->assign("p",(int)input("p"));
        return $this->fetch('settlements/list');
    }

    /**
     * 获取结算单
     */
    public function pageQuery(){
        $m = new CM();
        $rs = $m->pageQuery();
        return WSTLayGrid($rs);
    }
    /**
     * 获取待结算订单
     */
    public function pageUnSettledQuery(){
        $m = new CM();
        $rs = $m->pageUnSettledQuery();
        return WSTLayGrid($rs);
    }

    /**
     * 获取已结算订单
     */
    public function pageSettledQuery(){
        $m = new CM();
        $rs = $m->pageSettledQuery();
        return WSTLayGrid($rs);
    }
    /**
     * 查看结算详情
     */
    public function view(){
        $m = new CM();
        $rs = $m->getById();
        $this->assign('object',$rs);
        return $this->fetch('settlements/view');
    }
}

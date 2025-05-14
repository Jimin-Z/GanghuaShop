<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogMoneys as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 资金流水日志控制器
 */
class Logmoneys extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch("list");
    }

    /**
     * 获取用户分页
     */
    public function pageQueryByUser(){
    	$m = new M();
    	return WSTLayGrid($m->pageQueryByUser());
    }
    /**
     * 获取商分页
     */
    public function pageQueryByShop(){
        $m = new M();
        return WSTLayGrid($m->pageQueryByShop());
    }
    /**
     * 获取供货商分页
     */
    public function pageQueryBySupplier(){
        $m = new M();
        return WSTLayGrid($m->pageQueryBySupplier());
    }
    /**
     * 获取指定记录
     */
    public function tologmoneys(){
        $m = new M();
        $object = $m->getUserInfoByType();
        $this->assign("p",(int)input("p"));
        $this->assign("src",input("src"));
        $this->assign("object",$object);
        return $this->fetch("list_log");
    }
    /**
     * 获取资金记录
     */
    public function pageQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery());
    }

    /**
     * 获取充值记录
     */
    public function charge(){
        $m = new M();
        $this->assign("p",(int)input("p"));
        return $this->fetch("list_charge");
    }

    /**
     * 获取资金记录
     */
    public function pageQueryByCharge(){
        $m = new M();
        return WSTLayGrid($m->pageQuery(4));
    }

    /**
     * 跳去新增界面
     */
    public function toAdd(){
        $m = new M();
        $object = $m->getUserInfoByType();
        $this->assign("object",$object);
        return $this->fetch("box");
    }

    /**
     * 新增
     */
    public function add(){
        $m = new M();
        return $m->addByAdmin();
    }

    /**
     * 阶段汇总
     */
    public function phaseSummary(){
        $m = new M();
        $rs = $m->phaseSummary();
        return WSTReturn("",1,$rs);
    }

    /**
     * 财务统计
     */
    public function financeIndex(){
        $m = new M();
        $data = $m->phaseSummary();
        $this->assign("data",$data);
        $this->assign("p",(int)input("p"));

        return $this->fetch("finance/list");
    }

    /**
     * 获取资金记录
     */
    public function rechangePageQuery(){
        $m = new M();
        return WSTLayGrid($m->rechangePageQuery());
    }
}

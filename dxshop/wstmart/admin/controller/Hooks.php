<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Hooks as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 广告控制器
 */
class Hooks extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery());
    }

    /**
     * 调整顺序
     */
    public function changgeHookOrder(){
        $m = new M();
        return $m->changgeHookOrder();
    }

}

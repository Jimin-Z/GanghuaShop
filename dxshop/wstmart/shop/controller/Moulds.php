<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Moulds as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 规格模板控制器
 */
class Moulds extends Base{

    /**
     * 获取分页
     */
    public function getMouldList(){
        $m = new M();
        $rs = $m->getMouldList();
        return WSTReturn("",1,$rs);
    }

    
    /**
     * 获取数据
     */
    public function get(){
        $m = new M();
        return $m->getById();
    }
    /**
     * 新增
     */
    public function addMould(){
        $m = new M();
        return $m->add();
    }
    /**
    * 修改
    */
    public function edit(){
        $m = new M();
        return $m->edit();
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        return $m->del();
    }

    public function editMouldName(){
        $m = new M();
        $rs = $m->editMouldName();
        return $rs;
    }
    
    public function checkMouldName(){
    	$m = new M();
    	$rs = $m->checkMouldName();
   	 	return $rs;
    }
    
}

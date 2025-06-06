<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Switchs as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 页面转换控制器
 */
class Switchs extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        $rs = $m->pageQuery();
        return WSTLayGrid($rs);
    }
    /*
    * 获取数据
    */
    public function get(){
        $m = new M();
        $rs = $m->getById(Input("id/d",0));
        return $rs;
    }
    /**
     * 新增
     */
    public function add(){
        $m = new M();
        $rs = $m->add();
        return $rs;
    }
    /**
    * 修改
    */
    public function edit(){

        $m = new M();
        $rs = $m->edit();
        return $rs;
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        $rs = $m->del();
        return $rs;
    }


}

<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LimitWords as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 系统禁用关键字控制器
 */
class Limitwords extends Base{

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
     * 获取禁用关键字内容
     */
    public function get(){
        $m = new M();
        return $m->get((int)Input("post.id"));
    }

    /**
     * 新增
     */
    public function add(){
        $m = new M();
        return $m->add();
    }

    /**
     * 编辑
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
}

<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Ads as M;
use wstmart\admin\model\AdPositions as AdPositions;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 广告控制器
 */
class Ads extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch("list");
    }
    public function index2(){
    	$m = new AdPositions();
        $this->assign("p",(int)input("p"));
    	$data = $m->getById((int)input("id"));
    	$this->assign("data",$data);
    	return $this->fetch("list2");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery());
    }
    /**
     * 跳去编辑页面
     */
    public function toEdit(){
        $m = new M();
        $data = $m->getById(Input("id/d",0));
        $this->assign("p",(int)input("p"));
        return $this->fetch("edit",['data'=>$data]);
    }
    /**
     * 跳去编辑页面
     */
    public function toEdit2(){
    	$m = new M();
    	$data = $m->getById(Input("id/d",0));
    	$m = new AdPositions();
    	$position = $m->getById((int)input("adPositionId"));
        $this->assign("p",(int)input("p"));
    	return $this->fetch("edit2",['data'=>$data,'position'=>$position]);
    }
    /*
    * 获取数据
    */
    public function get(){
        $m = new M();
        return $m->getById(Input("id/d",0));
    }
    /**
     * 新增
     */
    public function add(){
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
    /**
    * 修改广告排序
    */
    public function changeSort(){
        $m = new M();
        return $m->changeSort();
    }


}

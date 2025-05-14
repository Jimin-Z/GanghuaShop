<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Attributes as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 属性控制器
 */
class Attributes extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	$this->assign('catId', input("catId/d"));
    	return $this->fetch("attributes/list");
    }

    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        $rs = $m->pageQuery();
        return WSTLayGrid($rs);
    }
  
    /**
     * 获取分页
     */
    public function listQuery(){
    	$m = new M();
    	$rs = $m->listQuery();
    	return $rs;
    }
    /**
     * 跳去编辑页面
     */
    public function toEdit(){
        //获取该记录信息
        $this->assign('data', $this->get());
        $m = new M();
        $this->assign('catId', input("catId/d",0));
        return $this->fetch("attributes/edit");
    }
    /**
     * 获取数据
     */
    public function get(){
        $m = new M();
        $rs = $m->getById(input("attrId/d"));
        return $rs;
    }
    /**
     * 显示隐藏
     */
    public function setToggle(){
        $m = new M();
        $rs = $m->setToggle();
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

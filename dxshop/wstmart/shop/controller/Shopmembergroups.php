<?php
namespace wstmart\shop\controller;
use wstmart\common\model\ShopMemberGroups as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 会员分组控制器
 */
class Shopmembergroups extends Base{
    /**
     * 跳去列表页面
     */
    public function index(){
        $this->assign("p",(int)input("p"));
        return $this->fetch("shopmembergroups/list");
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
     * 获取品牌
     */
    public function get(){
        $m = new M();
        $rs = $m->getById((int)input("post.id"));
        return $rs;
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        return $m->del();
    }
    /**
     * 列表查询
     */
    public function pageQuery(){
    	$m = new M();
    	$list = $m->pageQuery();
    	return WSTLayGrid($list);
    }
}

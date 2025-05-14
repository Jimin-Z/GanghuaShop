<?php
namespace wstmart\shop\controller;
use wstmart\common\model\ShopMembers as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 店铺客户控制器
 */
class ShopMembers extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
     * 跳去列表页
     */
    public function index(){
        $this->assign("p",(int)input("p"));
        $this->assign('groups',model('shop/ShopMemberGroups')->listQuery());
        return $this->fetch("shopmembers/list");
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
     * 修改分组
     */
    public function setgroup(){
        $m = new M();
        $rs = $m->setgroup();
        return $rs;
    }

}

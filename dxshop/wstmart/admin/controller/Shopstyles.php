<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\ShopStyles as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 店铺风格控制器
 */
class Shopstyles extends Base{
    public function index(){
        $m = new M();
        $rs = $m->getCats();
        $m->initStyles();
        $this->assign('cats',$rs);
        return $this->fetch();
    }
    /**
     * 获取风格列表
     */
    public function listQueryBySys(){
        $m = new M();
        $rs = $m->listQuery();
        return WSTReturn('',1,$rs);
    }

    /**
     * 保存
     */
    public function changeStyleShow(){
        $m = new M();
        return $m->changeStyleShow();
    }

    /*
     * 设置店铺风格的分类
     */
    public function changeStyleCat(){
        $m = new M();
        return $m->changeStyleCat();
    }
}

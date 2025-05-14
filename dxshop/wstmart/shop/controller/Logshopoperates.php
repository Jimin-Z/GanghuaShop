<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\LogShopOperates as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 操作日志控制器
 */
class Logshopoperates extends Base{
	
    public function index(){
    	return $this->fetch("logshopoperates/list");
    }
    
    /**
     * 获取分页
     */
    public function pageQuery(){
    	$m = new M();
    	return WSTLayGrid($m->pageQuery());
    }
    /**
     * 获取指定记录
     */
    public function get(){
    	$m = new M();
    	return $m->getById(input('id/d',0));
    }
}

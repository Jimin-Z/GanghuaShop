<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\LogSms as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 登录日志控制器
 */
class Logsms extends Base{

    public function index(){

    	return $this->fetch("list");
    }

    /**
     * 获取分页
     */
    public function pageQuery(){
    	$m = new M();
    	return WSTLayGrid($m->pageQuery());
    }
}

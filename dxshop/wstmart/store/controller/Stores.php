<?php
namespace wstmart\store\controller;
use wstmart\store\model\Stores as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 门店控制器
 */

class Stores extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
    * 店铺公告页
    */
    public function index(){
       
    }
    
}

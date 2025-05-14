<?php
namespace wstmart\admin\behavior;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 初始化基础数据
 */
class InitConfig 
{
    public function run($params){
        WSTConf('listenUrl',WSTVisitPrivilege());
    }
}
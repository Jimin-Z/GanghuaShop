<?php
namespace wstmart\home\behavior;
/**
 * ============================================================================
 * * WWWMark商城
 * 版权所有 2016-2066 香港城，并保留所有权利。
 * 官网地址:http://hk-city.com
 * 交流社区:http://bbs.shangtaosoft.com
 * 联系QQ:153289970
 * ----------------------------------------------------------------------------
 * 
 * 
 * ============================================================================
 * 初始化基础数据
 */
class InitConfig 
{
    public function run($params){
        WSTConf('protectedUrl',model('HomeMenus')->getMenusUrl());
        hook('initConfigHook',['getParams'=>input()]);
    }
}
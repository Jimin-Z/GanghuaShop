<?php
namespace wstmart\store\controller;
use wstmart\common\model\Areas as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 地区控制器
 */
class Areas extends Base{
	

    /**
     * 列表查询
     */
    public function listQuery(){
    	$m = new M();
    	$list = $m->listQuery(Input("post.parentId/d",0));
    	return WSTReturn("", 1,$list);
    }
}

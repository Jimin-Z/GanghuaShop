<?php
namespace wstmart\shop\controller;
use wstmart\common\model\GoodsCats as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品分类控制器
 */
class Goodscats extends Base{
	protected $beforeActionList = ['checkAuth'];
    /**
     * 获取列表
     */
    public function listQuery(){
        $m = new M();
        $rs = $m->listQuery(input('parentId/d',0));
        return WSTReturn("", 1,$rs);
    }

}
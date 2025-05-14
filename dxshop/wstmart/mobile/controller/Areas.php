<?php
namespace wstmart\mobile\controller;
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
        $rs = $m->listQuery();
        return WSTReturn('', 1,$rs);
    }
    /**
     * 列表查询-按字母分组
     */
    public function listQueryWithAreaKey(){
        $m = new M();
        $rs = $m->listQueryWithAreaKey();
        return WSTReturn('', 1,$rs);
    }
}

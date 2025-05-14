<?php
namespace wstmart\home\controller;
use wstmart\common\model\OrderRefunds as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 订单退款控制器
 */
class Orderrefunds extends Base{
	protected $beforeActionList = ['checkAuth'];
    /**
	 * 用户申请退款
	 */
	public function refund(){
		$m = new M();
		$rs = $m->refund();
		return $rs;
	}
}

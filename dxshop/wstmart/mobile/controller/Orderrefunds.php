<?php
namespace wstmart\mobile\controller;
use wstmart\common\model\OrderRefunds as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 订单退款控制器
 */
class Orderrefunds extends Base{
    /**
	 * 用户申请退款
	 */
	public function refund(){
		$m = new M();
		$rs = $m->refund();
		return $rs;
	}
	/**
	 * 商家处理是否同意
	 */
	public function shopRefund(){
		$m = new M();
		$rs = $m->shopRefund();
		return $rs;
	}
}

<?php
namespace wstmart\shop\model;
use think\Db;
use think\Log;
use wstmart\common\model\Invoices as CInvoices;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 发票信息类
 */
class Invoices extends CInvoices{
	/**
	* 列表查询
	*/
	public function shopPageQuery(){
		$userId = (int)session('WST_USER.userId');
		$where = [];
		$type = input('invoiceType',-1);
		if($type>-1)$where['invoiceType'] = $type;
		return $this->where(['userId'=>$userId,'dataFlag'=>1])->where($where)->paginate(input('pagesize/d',20));
	}


}

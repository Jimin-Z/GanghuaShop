<?php
namespace wstmart\common\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 银行业务处理
 */
class Banks extends Base{
	protected $pk = 'bankId';
	/**
	 * 列表
	 */
	public function listQuery(){
		$data = WSTCache('WST_BANKS');
		if(!$data){
			$data = $this->where(['dataFlag'=>1,'isShow'=>1])->field('bankId,bankName,bankImg')->select();
			WSTCache('WST_BANKS',$data,31536000);
		}
		return $data;
	}
}

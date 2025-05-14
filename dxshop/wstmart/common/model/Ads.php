<?php
namespace wstmart\common\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 广告类
 */
class Ads extends Base{
	protected $pk = 'adId';
	public function recordClick(){
		$id = (int)input('id');
		return $this->where("adId=$id")->setInc('adClickNum');
	}
}

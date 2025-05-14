<?php
namespace wstmart\home\controller;
use wstmart\common\model\Ads as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 广告控制器
 */
class Ads extends Base{
	/**
	* 记录点击次数
	*/
    public function recordClick(){
        $m = new M();
        return $m->recordClick();
    }
}

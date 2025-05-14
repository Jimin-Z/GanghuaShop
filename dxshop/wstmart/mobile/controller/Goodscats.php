<?php
namespace wstmart\mobile\controller;
use wstmart\mobile\model\GoodsCats as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品分类控制器
 */
class GoodsCats extends Base{
	/**
     * 列表
     */
    public function index(){
    	$m = new M();
    	$goodsCatList = $m->getGoodsCats();
    	$this->assign('list',$goodsCatList);
    	return $this->fetch('goods_category');
    }  
}

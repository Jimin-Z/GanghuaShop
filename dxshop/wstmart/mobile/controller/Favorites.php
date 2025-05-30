<?php
namespace wstmart\mobile\controller;
use wstmart\common\model\Favorites as M;
use wstmart\common\model\ShopMembers as SM;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 收藏控制器
 */
class Favorites extends Base{
	// 前置方法执行列表
    protected $beforeActionList = [
        'checkAuth',
    ];
	/**
	 * 关注的商品
	 */
	public function goods(){
		return $this->fetch('users/favorites/list_goods');
	}
	/**
	 * 关注的店铺
	 */
	public function shops(){
		return $this->fetch('users/favorites/list_shops');
	}
	/**
	 * 关注的商品列表
	 */
	public function listGoodsQuery(){
		$m = new M();
		$data = $m->listGoodsQuery();
		foreach($data['data'] as $k=>$v){
			$data['data'][$k]['goodsImg'] = WSTImg($v['goodsImg'],3,'goodsLogo');
		}
		return WSTReturn("", 1,$data);
	}
	/**
	 * 关注的店铺列表
	 */
	public function listShopQuery(){
		$m = new SM();
		$data = $m->listShopQuery();
		foreach($data['data'] as $k=>$v){
			$data['data'][$k]['shopImg'] = WSTImg($v['shopImg'],3,'shopLogo');
			if(!empty($v['goods'])){
				foreach($v['goods'] as $k1=>$v1){
					$v[$k1]['goodsImg'] = WSTImg($v1['goodsImg'],3,'goodsLogo');
				}
			}
		}
		return WSTReturn("", 1,$data);
	}
	/**
	 * 取消关注
	 */
	public function cancel(){
		if((int)input("param.type")==0){
			$m = new M();
			return $m->del();
		}else{
            $m = new SM();
			return $m->del();
		}
	}
	/**
	 * 增加关注
	 */
	public function add(){
		if((int)input("param.type")==0){
			$m = new M();
			return $m->add();
		}else{
            $m = new SM();
			return $m->add();
		}
	}
}

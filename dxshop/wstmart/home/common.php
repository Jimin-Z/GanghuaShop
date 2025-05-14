<?php
use think\Db;
use think\Session;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 */
/**
* 根据商品id,返回是否已关注商品
*/
function WSTCheckFavorite($goodsId){
	$userId = (int)session('WST_USER.userId');
	if($userId>0){
		return model('common/favorites')->checkFavorite($goodsId);
	}
	return false;
}

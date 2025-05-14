<?php
namespace wstmart\store\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 操作日志业务处理
 */
class LogOperates extends Base{

	
	/**
	 * 新增操作权限
	 */
	public function add($param){
		$data = [];
		$data['userId'] = (int)session('WST_STORE.userId');
		$data['operateTime'] = date('Y-m-d H:i:s');
		$data['menuId'] = $param['menuId'];
		$data['operateDesc'] = $param['operateDesc'];
		$data['content'] = $param['content'];
		$data['operateUrl'] = $param['operateUrl'];
		$data['operateIP'] = $param['operateIP'];
		$data['shopId'] = (int)session('WST_STORE.shopId');
		Db::name("log_shop_operates")->insert($data);
	}

}

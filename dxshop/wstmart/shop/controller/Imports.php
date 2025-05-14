<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Imports as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 默认控制器
 */
class Imports extends Base{
	protected $beforeActionList = ['checkAuth'];
	/**
	 * 数据导入首页
	 */
	public function index(){
        $express = model('Express')->shopExpressList();
        $this->assign('express',$express);
		return $this->fetch('import');
	}
	
    /**
     * 上传商品数据
     */
    public function importGoods(){
    	$rs = WSTUploadFile();	
    	if(json_decode($rs)->status==1){
			$m = new M();
    	    $rss = $m->importGoods($rs);
    	    return $rss;
		}
    	return $rs;
    }
    /**
     * 跳到导入发货单页面
     */
    public function toDeliverExport(){
        $express = model('Express')->shopExpressList();
        $this->assign('express',$express);
        return $this->fetch('orders/import');
    }

    /**
     * 上传订单发货数据
     */
    public function importOrders(){
    	$rs = WSTUploadFile();	
    	if(json_decode($rs)->status==1){
			$m = new M();
    	    $rss = $m->importOrders($rs);
    	    return $rss;
		}
    	return $rs;
    }
}

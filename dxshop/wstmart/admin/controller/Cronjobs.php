<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\CronJobs as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 定时任务控制器
 */
class Cronjobs extends Base{
	/**
	 * 降价提醒
	 */
	public function autoNotifyGoodsPriceReduction(){
		$m = new M();
		$rs = $m->autoNotifyGoodsPriceReduction();
		return json($rs);
	}
	/**
	 * 处理售后单
	 */
	public function autoDealOrderService(){
		$rs = model('common/OrderServices')->crontab();
		if (WSTConf('CONF.isOpenSupplier')==1){
			$rs = model('common/SupplierOrderServices')->crontab();
		}
		return json($rs);
	}
	/**
	 * 取消未付款订单
	 */
	public function autoCancelNoPay(){
		$m = new M();
        $rs = $m->autoCancelNoPay();
        if (WSTConf('CONF.isOpenSupplier')==1){
			$rs = model('SupplierCronJobs')->autoCancelNoPay();
		}
        return json($rs);
	}
	/**
	 * 自动好评
	 */
	public function autoAppraise(){
        $m = new M();
        $rs = $m->autoAppraise();
        if (WSTConf('CONF.isOpenSupplier')==1){
			$rs = model('SupplierCronJobs')->autoAppraise();
		}
        return json($rs);
	}
	/**
	 * 自动确认收货
	 */
	public function autoReceive(){
	 	$m = new M();
        $rs = $m->autoReceive();
        if (WSTConf('CONF.isOpenSupplier')==1){
			$rs = model('SupplierCronJobs')->autoReceive();
		}
        return json($rs);
	}

	/**
	 * 发送队列消息
	 */
	public function autoSendMsg(){
	 	$m = new M();
        $rs = $m->autoSendMsg();
        return json($rs);
	}
	/**
	 * 生成sitemap.xml
	 */
	public function autoFileXml(){
		$m = new M();
		$rs = $m->autoFileXml();
		return json($rs);
	}

	/**
	 * 商家订单自动结算
	 */
	public function autoShopSettlement(){
		$m = new M();
		$rs = $m->autoShopSettlement();
		if (WSTConf('CONF.isOpenSupplier')==1){
			$rs = model('SupplierCronJobs')->autoSupplierSettlement();
		}
		return json($rs);
	}

	public  function clearPoster($value=''){
		$m = new M();
		$rs = $m->clearPoster();
		return json($rs);
	}

    /**
     * 店铺到期后自动修改店铺为停止状态
     */
    public function autoChangeShopStatus(){
        $m = new M();
        $rs = $m->autoChangeShopStatus();
        return json($rs);
    }

    /**
     * 供货商到期后自动修改供货商为停止状态
     */
    public function autoChangeSupplierStatus(){
    	if (WSTConf('CONF.isOpenSupplier')==1){
	        $m = new M();
	        $rs = $m->autoChangeSupplierStatus();
	        return json($rs);
	    }
    }

    /**
     * 自动处理商家退款订单
     */
    public function autoHandleShopRefund(){
        $m = new M();
        $rs = $m->autoHandleShopRefund();
        return json($rs);
    }

    /**
     * 自动处理供货商退款订单
     */
    public function autoHandleSupplierRefund(){
    	if (WSTConf('CONF.isOpenSupplier')==1){
	        $m = new M();
	        $rs = $m->autoHandleSupplierRefund();
	        return json($rs);
   		 }
    }
}

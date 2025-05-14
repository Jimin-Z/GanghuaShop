<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Orders as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 订单控制器
 */
class Orders extends Base{

	/**
	 * 商家-拒收自提订单
	 */
	public function toReject(){
		$this->checkAuth();
		return $this->fetch('orders/box_reject');
	}
	/**
	 * 商家拒收订单
	 */
	public function reject(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->shopReject();
		return $rs;
	}



    /**
     * 商家-操作退款
     */
    public function toShopRefund(){
        $this->checkAuth();
        $rs = model('OrderRefunds')->getRefundMoneyByOrder((int)input('id'));
        $this->assign('object',$rs);
        return $this->fetch('orders/box_refund');
    }
	/**
	 * 等待处理订单
	 */
	public function waitDelivery(){
		$this->checkAuth();
        $this->assign("p",(int)input("p"));
		$express = model('Express')->shopExpressList();
		$this->assign('express',$express);
        //获取省份
        $areas = model('Areas')->listQuery();
        $this->assign('areaList',$areas);
		return $this->fetch('orders/list_wait_delivery');
	}
	/**
	 * 待处理订单
	 */
	public function waitDeliveryByPage(){
		$this->checkAuth();
		$m = new M();
		$shopId = (int)session('WST_USER.shopId');
		$rs = $m->shopOrdersByPage([0],$shopId,1);
		return WSTReturn("", 1,$rs);
	}

	/**
	 * 等待自提订单
	 */
	public function waitSelfTake(){
		$this->checkAuth();
        $this->assign("p",(int)input("p"));
		return $this->fetch('orders/list_wait_self_take');
	}
	/**
	 * 待处理订单
	 */
	public function waitSelfTakeByPage(){
		$this->checkAuth();
		$m = new M();
		$shopId = (int)session('WST_USER.shopId');
		$rs = $m->shopOrdersByPage([0],$shopId,2);
		return WSTReturn("", 1,$rs);
	}

    /**
     * 获取单条订单的商品信息
     */
    public function waitDeliverById(){
        $this->checkAuth();
        $m = new M();
        $rs = $m->waitDeliverById();
        return WSTReturn("", 1,$rs);
    }

	/**
	* 商家-已发货订单
	*/
	public function delivered(){
		$this->checkAuth();
        $this->assign("p",(int)input("p"));
		$express = model('Express')->shopExpressList();
		$this->assign('express',$express);
		return $this->fetch('orders/list_delivered');
	}
	/**
	 * 待处理订单
	 */
	public function deliveredByPage(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->shopOrdersByPage(1);
		return WSTReturn("", 1,$rs);
	}

    /**
	 * 商家发货
	 */
	public function deliver(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->deliver();
		return $rs;
	}
	/**
	 * 商家-已完成订单
	 */
    public function finished(){
    	$this->checkAuth();
    	$this->assign("p",(int)input("p"));
    	$this->assign('userId',(int)input('userId'));
		return $this->fetch('orders/list_finished');
	}
	/**
	 * 商家-已完成订单
	 */
	public function finishedByPage(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->shopOrdersByPage(2);
		$rs= WSTReturn("", 1,$rs);
		return $rs;
	}
    /**
	 * 商家-取消/拒收订单
	 */
    public function failure(){
    	$this->checkAuth();
    	$this->assign("p",(int)input("p"));
		return $this->fetch('orders/list_failure');
	}
	/**
	 * 商家-取消/拒收订单
	 */
	public function failureByPage(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->shopOrdersByPage([-1,-3]);
		return WSTReturn("", 1,$rs);
	}
    /**
     * 商家-退款订单
     */
    public function refund(){
        $this->checkAuth();
        $this->assign("p",(int)input("p"));
        return $this->fetch('orders/list_refund');
    }
    /**
     * 商家-退款订单
     */
    public function refundByPage(){
        $this->checkAuth();
        $m = new M();
        $rs = $m->shopOrdersByPage([-1,-3]);
        return WSTReturn("", 1,$rs);
    }
	/**
	 * 获取订单信息方便修改价格
	 */
	public function getMoneyByOrder(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->getMoneyByOrder();
		return WSTReturn("", 1,$rs);
	}
	/**
	 * 商家修改订单价格
	 */
	public function editOrderMoney(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->editOrderMoney();
		return $rs;
	}
	/**
	 * 商家-订单详情
	 */
	public function view(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs);
        $this->assign("p",(int)input("p"));
        $this->assign("src",input("src"));
		return $this->fetch('orders/view');
	}
	/**
	 * 订单打印
	 */
	public function orderPrint(){
		$this->checkAuth();
        $m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs);
		return $this->fetch('orders/print');
	}

    /**
	 * 用户-订单详情
	 */
	public function detail(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->getByView((int)input('id'));
		$this->assign('object',$rs);

		return $this->fetch('users/orders/view');
	}

   /**
	* 用户-评价页
	*/
	public function orderAppraise(){
		$this->checkAuth();
		$m = new M();
		//根据订单id获取 商品信息跟商品评价
		$data = $m->getOrderInfoAndAppr();
		$this->assign(['data'=>$data['data'],
					   'count'=>$data['count'],
					   'alreadys'=>$data['alreadys']
						]);
		return $this->fetch('users/orders/list_order_appraise');
	}
	/**
	* 设置完成评价
	*/
	public function complateAppraise($orderId){
		$this->checkAuth();
		$m = new M();
		return $m->complateAppraise($orderId);
	}
	/**
	 * 商家-待付款订单
	 */
	public function waituserPay(){
		$this->checkAuth();
        $this->assign("p",(int)input("p"));
		return $this->fetch('orders/list_wait_pay');
	}
	/**
	 * 商家-获取待付款列表
	 */
	public function waituserPayByPage(){
		$this->checkAuth();
		$m = new M();

		$rs = $m->shopOrdersByPage(-2);
			$rs= WSTReturn("", 1,$rs);
				put_msg('line 268 waituserPayByPage======');
		
		return $rs;
	}
	/**
	 * 导出订单
	 */
	public function toExport(){
		$this->checkAuth();
		$m = new M();
		$rs = $m->toExport();
		$this->assign('rs',$rs);
	}

	/**
	 * 订单核销
	 */
	public function verificat(){
		return $this->fetch('orders/verificat');
	}
	/**
	 * 核销验证
	 */
	public function getVerificatOrder(){
		$m = new M();
		$shopId = (int)session('WST_USER.shopId');
		$rs = $m->getVerificatOrder($shopId);
        if(isset($rs['goods'])) {
            // 优惠券钩子
            hook('shopDocumentOrderSummaryView', ['order' => &$rs, 'isOrderVerificat' => 1]);
            // 满就送钩子
            hook('shopDocumentOrderViewGoodsPromotion', ['order' => &$rs, 'isOrderVerificat' => 1]);
        }
		if(empty($rs)){
			return WSTReturn("无效的核验码");
		}else{
			return WSTReturn("", 1,$rs);
		}
	}
	/**
	 * 核销验证
	 */
	public function orderVerificat(){
		$m = new M();
		$shopId = (int)session('WST_USER.shopId');
		$rs = $m->orderVerificat($shopId);
		return $rs;
	}

	/**
	 * 导出待发货订单模板
	 */
	public function toDeliverTemplate(){
		$m = new M();
		$rs = $m->toDeliverTemplate();
		return $rs;
	}

    /*
     * 获取订单收货信息
     */
    public function getOrderReceiveInfo(){
        $m = new M();
        $rs = $m->getOrderReceiveInfo();
        return WSTReturn("", 1,$rs);
    }

    /*
     * 修改订单收货信息
     */
    public function editOrderReceiveInfo(){
        $m = new M();
        return $m->editOrderReceiveInfo();
    }

    /*
     * 获取订单物流信息
     */
    public function getOrderExpressInfo(){
        $m = new M();
        $rs = $m->getOrderExpressInfo();
        return WSTReturn("", 1,$rs);
    }

    /*
     * 修改订单物流信息
     */
    public function editOrderExpressInfo(){
        $m = new M();
        return $m->editOrderExpressInfo();
    }

    /**
     * 获取订单备注
     */
    public function getShopRemarks(){
        $m = new M();
        $rs = $m->getShopRemarks();
        return $rs;
    }

    /**
     * 修改订单备注
     */
    public function editShopRemarks(){
        $m = new M();
        $rs = $m->editShopRemarks();
        return $rs;
    }
}

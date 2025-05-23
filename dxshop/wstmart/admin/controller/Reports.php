<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Reports as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 报表控制器
 */
class Reports extends Base{
	/**
	 * 商品销售排行
	 */
	public function toTopSaleGoods(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
		return $this->fetch("/reports/top_sale_goods");
	}
    /**
     * 获取商品排行数据
     */
    public function topSaleGoodsByPage(){
        $m = new M();
        return WSTLayGrid($m->topSaleGoodsByPage());
    }
	/**
     * 店铺销售排行
     */
    public function toTopShopSales(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/top_sale_shop");
    }
    /**
     * 获取店铺排行数据
     */
    public function topShopSalesByPage(){
        $m = new M();
        return WSTLayGrid($m->topShopSalesByPage());
    }
    /**
     * 获取销售额
     */
    public function toStatSales(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/stat_sales");
    }
    public function statSales(){
        $m = new M();
        return $m->statSales();
    }
    /**
     * 获取订单统计
     */
    public function toStatOrders(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/stat_orders");
    }
    /*
     *
     */
    public function getOrders(){
    	$m = new M();
        return $m->getOrders();
    }
    public function statOrders(){
        $m = new M();
       return $m->statOrders();
    }


    /**
     * 获取每日新增用户
     */
    public function toStatNewUser(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/stat_new_user");
    }
    public function statNewUser(){
        $m = new M();
        return $m->statNewUser();
    }
    /*
     * 首页获取新增用户
     */
    public function getNewUser(){
    	$m = new M();
    	$data = WSTCache('userNumData');
    	if(empty($data)){
    	  $rdata = $m->statNewUser();
    	  WSTCache('userNumData',$rdata,7200);
    	}else{
    	  $rdata = WSTCache('userNumData');
    	}
        return $rdata;
    }
    /**
     * 会员登录统计
     */
    public function toStatUserLogin(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/stat_user_login");
    }
    public function statUserLogin(){
        $m = new M();
        return $m->statUserLogin();
    }



    /**
     * 订单销售额统计
     */
    public function ordereSaleMoney(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/ordere_sale_money");
    }
    /**
     * 订单销售额统计
     */
    public function ordereSaleMoneyByPage(){
        $m = new M();
        return WSTLayGrid($m->ordereSaleMoneyByPage());
    }


    /**
     * 充值统计报表
     */
    public function rechargeMoney(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/recharge_money");
    }
    /**
     * 充值统计报表
     */
    public function rechargeMoneyByPage(){
        $m = new M();
        return WSTLayGrid($m->rechargeMoneyByPage());
    }

    /**
     * 提现统计报表
     */
    public function cashDrawalMoney(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/cash_drawal_money");
    }
    /**
     * 提现统计报表
     */
    public function cashDrawalMoneyByPage(){
        $m = new M();
        return WSTLayGrid($m->cashDrawalMoneyByPage());
    }


     /**
     * 积分抵扣报表
     */
    public function scoreConsume(){
        $this->assign("p",(int)input("p"));
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch("/reports/score_consume");
    }
    /**
     * 积分抵扣报表
     */
    public function scoreConsumeByPage(){
        $m = new M();
        return WSTLayGrid($m->scoreConsumeByPage());
    }

    /**
     * 商家到期报表
     */
    public function shopExpire(){
        $this->assign("p",(int)input("p"));
        $this->assign("areaList",model('areas')->listQuery(0));
        return $this->fetch("/reports/shop_expire");
    }
    /**
     * 商家到期报表
     */
    public function shopExpireByPage(){
        $m = new M();
        return WSTLayGrid($m->shopExpireByPage());
    }


    /**
     * 导出店铺统计excel
     */
    public function toExportShopSales(){
        $m = new M();
        $rs = $m->toExportShopSales();
        $this->assign('rs',$rs);
    }
    /**
     * 导出商品统计excel
     */
    public function toExportSaleGoods(){
        $m = new M();
        $rs = $m->toExportSaleGoods();
        $this->assign('rs',$rs);
    }
    /**
     * 导出销售额统计excel
     */
    public function toExportStatSales(){
        $m = new M();
        $rs = $m->toExportStatSales();
        $this->assign('rs',$rs);
    }
    /**
     * 导出订单统计excel
     */
    public function toExportStatOrders(){
        $m = new M();
        $rs = $m->toExportStatOrders();
        $this->assign('rs',$rs);
    }


    /**
     * 导出订单销售额统计excel
     */
    public function toExportOrdereSaleMoney(){
        $m = new M();
        $rs = $m->toExportOrdereSaleMoney();
        $this->assign('rs',$rs);
    }

    /**
     * 导出充值统计报表excel
     */
    public function toExportRechargeMoney(){
        $m = new M();
        $rs = $m->toExportRechargeMoney();
        $this->assign('rs',$rs);
    }

    /**
     * 导出提现统计报表excel
     */
    public function toExportCashDrawalMoney(){
        $m = new M();
        $rs = $m->toExportCashDrawalMoney();
        $this->assign('rs',$rs);
    }

    /**
     * 导出积分抵扣报表统计excel
     */
    public function toExportScoreConsume(){
        $m = new M();
        $rs = $m->toExportScoreConsume();
        $this->assign('rs',$rs);
    }

    /**
     * 导出商家到期报表统计excel
     */
    public function toExportShopExpire(){
        $m = new M();
        $rs = $m->toExportShopExpire();
        $this->assign('rs',$rs);
    }
}

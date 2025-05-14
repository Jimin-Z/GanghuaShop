<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\Reports as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 报表控制器
 */
class Reports extends Base{
    protected $beforeActionList = ['checkAuth'];
	/**
     * 商品销售排行
     */
    public function topSaleGoods(){
    	$this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
    	return $this->fetch('reports/top_sale_goods');
    }
    public function getTopSaleGoods(){
    	$n = new M();
        return WSTLayGrid($n->getTopSaleGoods());
    }
    /**
     * 获取销售额
     */
    public function statSales(){
    	$this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch('reports/stat_sales');
    }
    public function getStatSales(){
        put_msg('getStatSale line 33====');
    	$m = new M();
        return $m->getStatSales();
    }

    /**
     * 获取销售订单
     */
    public function statOrders(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch('reports/stat_orders');
    }
    public function getStatOrders(){
        $m = new M();
        return $m->getStatOrders();
    }

    /**
     * 导出商品销售排行Excel
     */
    public function toExportTopSaleGoods(){
        $m = new M();
        $rs = $m->toExportTopSaleGoods();
        $this->assign('rs',$rs);
    }
    /**
     * 导出销售额Excel
     */
    public function toExportStatSales(){
        $m = new M();
        $rs = $m->toExportStatSales();
        $this->assign('rs',$rs);
    }
    /**
     * 导出销售订单统计Excel
     */
    public function toExportStatOrders(){
        $m = new M();
        $rs = $m->toExportStatOrders();
        $this->assign('rs',$rs);
    }

    /**
     * 购物车统计
     */
    public function statCarts(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch('reports/stat_carts');
    }
    public function getStatCarts(){
        $m = new M();
        $rs = $m->getStatCarts();
        return WSTReturn('',1,$rs);
    }
    public function getStatCartGoods(){
        $n = new M();
        return WSTLayGrid($n->getStatCartGoods());
    }


    /**
     * 收藏统计
     */
    public function statFavorites(){
        $this->assign("startDate",date('Y-m-d',strtotime("-1month")));
        $this->assign("endDate",date('Y-m-d'));
        return $this->fetch('reports/stat_favorites');
    }

    public function getStatFavorites(){
        $m = new M();
        $rs = $m->getStatFavorites();
        return WSTReturn('',1,$rs);
    }

    public function getStatFavoriteGoods(){
        $n = new M();
        return WSTLayGrid($n->getStatFavoriteGoods());
    }
}

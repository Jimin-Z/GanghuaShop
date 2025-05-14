<?php
namespace wstmart\home\controller;
use wstmart\common\model\OrderServices as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 售后控制器
 */
class Orderservices extends Base{
    protected $beforeActionList = ['checkAuth'];
    /**
     * 用户确认收货
     */
    public function userReceive(){
        $m = new M();
        return $m->userReceive();
    }
    /**
     * 用户发货
     */
    public function userExpress(){
        $m = new M();
        return $m->userExpress();
    }
    /**
     * 售后详情
     */
    public function detail(){
        $m = new M();
        $detail = $m->getDetail();
        $log = $m->getLog();
        // 等待买家发货
        if($detail['serviceStatus']==1){
            // 取出快递公司
            $express = model('Express')->shopExpressList($detail['shopId']);
		    $this->assign('express',$express);
        }
        return $this->fetch('users/orderservices/detail',['detail'=>$detail,'log'=>$log,'id'=>(int)input('id')]);
    }
    /**
	* 售后列表查询
	*/
    public function pagequery(){
        return WSTReturn('ok',1,(new M())->pageQuery());
    }
    /**
	* 售后申请页
	*/
    public function oslist(){
        $m = new M();
        $rs = $m->getGoods();
        return $this->fetch('users/orderservices/list',['p'=>(int)input('p')]);
    }
	/**
	* 售后申请页
	*/
    public function index(){
        $m = new M();
        $rs = $m->getGoods();
        // 商品类型，虚拟商品在订单中只能有一款
        $goodsType = $rs[0]['goodsType'];
        // 退换货原因
        $reasons = WSTDatas('ORDER_SERVICES');
        return $this->fetch('users/orderservices/apply',[
            // 是否为固定搭配订单
            'isFixedCombination'=>$m->isFixedCombination(input('orderId')),
            'rs'=>$rs,
            'reasons'=>$reasons,
            'orderId'=>(int)input('orderId'),
            'goodsType'=>$goodsType
            ]);
    }

    /**
     * 提交售后申请
     */
    public function commit(){
        $m = new M();
        return $m->commit();
    }
    /**
     * 获取当前可退款金额
     */
    public function getRefundableMoney(){
        $m = new M();
        return $m->getRefundableMoney();
    }
}

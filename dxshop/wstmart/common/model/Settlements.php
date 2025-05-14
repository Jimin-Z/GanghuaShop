<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 结算类
 */
class Settlements extends Base{
	protected $pk = 'settlementId';
	/**
     * 即时计算 
     */
    public function speedySettlement($orderId){
        hook('beforeShopSettlement',['orderId'=>$orderId]);
        $order = model('common/orders')->get(['orderId'=>$orderId]);
        $shops = model('common/shops')->get(['shopId'=>$order->shopId]);
        if(empty($shops))return WSTReturn('结算失败，商家不存在');
        $backMoney = 0;

        $realTotalMoney = $order["realTotalMoney"];
        $commissionFee = $order["commissionFee"];
        $payType = $order["payType"];
        $refundedPayMoney = $order["refundedPayMoney"];
        $refundedScoreMoney = $order["refundedScoreMoney"];
        $refundedScore = $order["refundedScore"];
        $refundedGetScore = $order["refundedGetScore"];
        $refundedGetScoreMoney = $order["refundedGetScoreMoney"];
        $orderScore = $order["orderScore"];
        $useScore = $order["useScore"];
        $scoreMoney = $order['scoreMoney'];
        $settlementMoney = $scoreMoney;
        if($payType==1){//线上支付
            if($realTotalMoney<=0 ){//线上支付，纯积分支付
                $scoreRat = 0;
                $surplusMoney = 0;
                if($scoreMoney>0){
                    $scoreRat = $scoreMoney/$useScore;
                    // 失效积分抵扣金额 = 失效的获得积分数 * 比例
                    $surplusMoney = $refundedGetScore * $scoreRat;
                    // 退还积分抵扣金额 = $refundedScore * 比例
                    $refundedScoreMoney =  $refundedScore * $scoreRat;
                }
                $settlementMoney = $settlementMoney- $refundedPayMoney - $refundedScoreMoney - $surplusMoney;
                //在线支付的返还金额=实付金额+积分抵扣金额-已退款支付金额-已退款积分抵扣金额-下单获得积分抵扣金额-佣金
                $backMoney = $scoreMoney -$refundedPayMoney - $refundedScoreMoney - $surplusMoney - $commissionFee;
            }else{
                $settlementMoney=$settlementMoney+$realTotalMoney-$refundedPayMoney- $refundedScoreMoney - $refundedGetScoreMoney;
                //在线支付的返还金额=实付金额+积分抵扣金额-已退款支付金额-已退款积分抵扣金额 - 失效获得积分换算的金额 -佣金
                $backMoney = $realTotalMoney + $scoreMoney - $refundedPayMoney - $refundedScoreMoney - $refundedGetScoreMoney - $commissionFee;
            }

        }else{//货到付款
            //货到付款的返还金额=积分抵扣金额-佣金
            $backMoney = $scoreMoney - $commissionFee;
        }
        $tmpBackMoney = WSTBCMoney($backMoney, $commissionFee);
        $settlementMoney = WSTBCMoney($settlementMoney, 0);
        $backMoney = WSTBCMoney($backMoney, 0);

        $settlementId =$this->saveSettlements($order,$settlementMoney,$backMoney);
        if($settlementId>0){
            $settlementNo =$settlementId.(fmod($settlementId,7));
            Db::name('settlements')->where('settlementId',$settlementId)->update(['settlementNo'=>$settlementNo]);
            $order->settlementId = $settlementId;
            $order->isClosed = 1;
            $order->save();
            //修改商家钱包
            $shops->noSettledOrderFee = $shops['noSettledOrderFee']+$order->commissionFee;//减少未结算佣金
            $shops->noSettledOrderNum = $shops['noSettledOrderNum']-1;//减少未结算订单数
            $shops->shopMoney = $shops['shopMoney']+$backMoney;
            $shops->save();
            //返还金额
            $lmarr = [];
            //货到付款处理
            if($order->payType==0){
                //如果有积分支付的话，还要补上一个积分支付的资金流水记录，不然流水上金额不对。
                if($order->scoreMoney >0){
                    $remark = '结算订单申请【'.$settlementNo.'】返还积分支付金额¥'.$order->scoreMoney;
                    $lmarr[] =$this->saveData($order,1,$order->scoreMoney,$remark);
                }
            }else{
                //在线支付的话，记录商家应得的钱的流水
                if($tmpBackMoney>0){
                    $remark='结算订单申请【'.$settlementNo.'】返还金额¥'.$tmpBackMoney;
                    $lmarr[] =$this->saveData($order,1,$tmpBackMoney,$remark);
                }
            }
            //收取佣金
            if($order->commissionFee>0){
                $remark= '结算订单申请【'.$settlementNo.'】收取订单佣金¥'.$order->commissionFee;
                $lmarr[] =$this->saveData($order,0,$order->commissionFee,$remark);
            }
            if(!empty($lmarr)){
                model('common/LogMoneys')->saveAll($lmarr);
            }
        }
        return WSTReturn('结算失败');
    }

    function saveSettlements($order,$settlementMoney,$backMoney){
        $data = [];
        $data['settlementType'] = 1;
        $data['shopId'] = $order->shopId;
        $data['settlementMoney'] = $settlementMoney;
        $data['commissionFee'] = $order->commissionFee;
        $data['backMoney'] = $backMoney;
        $data['settlementStatus'] = 1;
        $data['settlementTime'] = date('Y-m-d H:i:s');
        $data['createTime'] = date('Y-m-d H:i:s');
        $data['settlementNo'] = '';
        return  Db::name('settlements')->insertGetId($data);
    }

    function saveData($order,$mType,$money,$remark){
        $lm = [];
        $lm['remark'] = $remark;//'结算订单申请【'.$settlementNo.'】收取订单佣金¥'.$order->commissionFee;
        $lm['moneyType'] = $mType;
        $lm['money'] =$money;// $order->commissionFee;
        $lm['targetType'] = 1;
        $lm['targetId'] = $order->shopId;
        $lm['dataId'] = $order->settlementId;
        $lm['dataSrc'] = 2;
        $lm['payType'] = 0;
        $lm['createTime'] = date('Y-m-d H:i:s');
        return $lm;
    }
    /*********************************** 商家结算 ***********************************/

    /**
     * 获取已结算的结算单列表
     */
    public function pageQuery($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $where = [];
        $where[] = ['shopId',"=",$shopId];
        if(input('settlementNo')!='')$where[] = ['settlementNo','like','%'.input('settlementNo').'%'];
        if((int)input('isFinish',-1)>=0)$where[] = ['settlementStatus',"=",(int)input('isFinish')];
        return Db::name('settlements')->alias('s')->where($where)->order('settlementId', 'desc')
            ->paginate(input('limit/d'))->toArray();
    }
    /**
     *  获取未结算订单列表,待
     */
    public function pageUnSettledQuery($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $para=getParameter();
        $where = [];
        if(input('orderNo')!='')$where[] = ['orderNo','like','%'.input('orderNo').'%'];
        $where[] = ['dataFlag',"=",1];
        $where[] = ['orderStatus',"=",2];
        $where[] = ['settlementId',"=",0];
        $where[] = ['shopId',"=", $shopId];
        $page =  Db::name('orders')->where($where)->order('orderId', 'desc')
                   ->field('orderId,orderNo,createTime,payType,goodsMoney,deliverMoney,totalMoney,commissionFee,realTotalMoney,
                            refundedPayMoney,refundedScoreMoney,refundedGetScoreMoney,afterSaleEndTime')
                   ->paginate(input('limit/d'))->toArray();
        if(count($page['data'])){
            foreach ($page['data'] as $key => $v) {
                $page['data'][$key]['payTypeNames'] = WSTLangPayType($v['payType']);
                $page['data'][$key]['afterSaleEndTime'] = date('Y-m-d',strtotime($v['afterSaleEndTime']));
            }
        }
        return $page;
    }


    /**
     * 获取已结算订单
     */
    public function pageSettledQuery($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $where = [];
        if(input('settlementNo')!='')$where[] = ['settlementNo','like','%'.input('settlementNo').'%'];
        if(input('orderNo')!='')$where[] = ['orderNo','like','%'.input('orderNo').'%'];
        if((int)input('isFinish',-1)>=0)$where[] = ['settlementStatus',"=",(int)input('isFinish')];
        $where[] = ['dataFlag',"=",1];
        $where[] = ['orderStatus',"=",2];
        $where[] = ['o.shopId',"=",$shopId];
        $page = Db::name('orders')->alias('o')->join('__SETTLEMENTS__ s','o.settlementId=s.settlementId')
        ->where($where)
        ->field('orderId,orderNo,payType,goodsMoney,deliverMoney,totalMoney,o.commissionFee,realTotalMoney,
                 s.settlementTime,s.settlementNo,refundedPayMoney,refundedScoreMoney,refundedGetScoreMoney')
        ->order('s.settlementTime desc')
        ->paginate(input('limit/d'))->toArray();
        if(count($page['data'])){
            foreach ($page['data'] as $key => $v) {
                $page['data'][$key]['commissionFee'] = abs($v['commissionFee']);
                $page['data'][$key]['payTypeNames'] = WSTLangPayType($v['payType']);
            }
        }
        return $page;
    }

    /**
     * 获取结算订单详情
     */
    public function getById($sId=0){
        $shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $settlementId = (int)input('id');
        $object =  Db::name('settlements')->alias('st')->where(['settlementId'=>$settlementId,'st.shopId'=>$shopId])->join('__SHOPS__ s','s.shopId=st.shopId','left')->field('s.shopName,st.*')->find();
        if(!empty($object)){
            $object['list'] = Db::name('orders')->where(['settlementId'=>$settlementId])
                      ->field('orderId,orderNo,payType,goodsMoney,deliverMoney,realTotalMoney,totalMoney,scoreMoney,commissionFee,createTime')
                      ->order('payType desc,orderId desc')->select();
        }
        return $object;
    }
    /*********************************** 商家结算 ***********************************/
}

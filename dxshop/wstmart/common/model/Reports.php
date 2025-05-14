<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 报表模型类
 */
class Reports extends Base{
	/**
	 * 获取商品销售排行
	 */
	public function getTopSaleGoods($sId=0){
		$start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
    	$end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
    	$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
    	$prefix = config('database.prefix');
    	$rs = Db::table($prefix.'order_goods')->alias([$prefix.'order_goods'=>'og',$prefix.'orders'=>'o',$prefix.'goods'=>'g'])
    	  ->join($prefix.'orders','og.orderId=o.orderId')
    	  ->join($prefix.'goods','og.goodsId=g.goodsId')
    	  ->order('goodsNum desc')
    	  ->whereTime('o.createTime','between',[$start,$end])
          ->where([['o.orderStatus','>=',0]])
          ->where('(payType=0 or (payType=1 and isPay=1)) and o.dataFlag=1 and o.shopId='.$shopId)->group('og.goodsId')
          ->field('og.goodsId,g.goodsName,g.goodsSn,sum(og.goodsNum) goodsNum,g.goodsImg')
          ->limit(10)->select();
        return WSTReturn('',1,$rs);
	}
	/**
	 * 获取销售额统计
     * 【注意】商家电脑端统计报表及导出excel有引用
	 */
	public function getStatSales($sId=0){
     	$start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $payType = (int)input('payType',-1);
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $rs = Db::field('left(createTime,10) createTime,sum(totalMoney) totalMoney,count(orderId) orderNum')
                ->name('orders')
                ->whereTime('createTime','between',[$start,$end])
                ->where('shopId',$shopId)
                ->where('(payType=0 or (payType=1 and isPay=1)) and dataFlag=1 '.(in_array($payType,[0,1])?" and payType=".$payType:''))
                ->order('createTime asc')
                ->group('left(createTime,10)')->select();
        $rdata = [];
        if(count($rs)>0){
            //取消订单
            $cancelMaps = [];
            $cancelRs = Db::field('left(createTime,10) createTime,sum(totalMoney) totalMoney')
                ->name('orders')
                ->whereTime('createTime','between',[$start,$end])
                ->where('shopId',$shopId)
                ->where('(payType=0 or (payType=1 and isPay=1)) and dataFlag=1 '.(in_array($payType,[0,1])?" and payType=".$payType:''))
                ->where(['orderStatus'=>-1])
                ->order('createTime asc')
                ->group('left(createTime,10)')->select();
            foreach($cancelRs as $v){
                $cancelMaps[$v['createTime']] = $v['totalMoney'];
            }
            //拒收订单
            $rejectMaps = [];
            $rejectRs = Db::field('left(createTime,10) createTime,sum(totalMoney) totalMoney')
                ->name('orders')
                ->whereTime('createTime','between',[$start,$end])
                ->where('shopId',$shopId)
                ->where('(payType=0 or (payType=1 and isPay=1)) and dataFlag=1 '.(in_array($payType,[0,1])?" and payType=".$payType:''))
                ->where(['orderStatus'=>-3])
                ->order('createTime asc')
                ->group('left(createTime,10)')->select();
            foreach($rejectRs as $v){
                $rejectMaps[$v['createTime']] = $v['totalMoney'];
            }
            $days = [];
            $tmp = [];
            foreach($rs as $key => $v){
                $days[] = $v['createTime'];
                $rdata['dayVals'][] = $v['totalMoney'];
                $cancelVal = isset($cancelMaps[$v['createTime']])?$cancelMaps[$v['createTime']]:0;
                $rejectVal = isset($rejectMaps[$v['createTime']])?$rejectMaps[$v['createTime']]:0;
                $rdata['list'][] = ['day'=>$v['createTime'],'val'=>$v['totalMoney'],'cancelVal'=>$cancelVal,'rejectVal'=>$rejectVal,'num'=>$v['orderNum']];
            }
            $rdata['days'] = $days;
        }
        return WSTReturn('',1,$rdata);
	}

    /**
     * 获取商家订单情况
     *【注意】商家电脑端统计报表及导出excel有引用
     */
    public function getStatOrders($sId=0){
        $start = date('Y-m-d 00:00:00',strtotime(input('startDate')));
        $end = date('Y-m-d 23:59:59',strtotime(input('endDate')));
        $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
        $rs = Db::field('left(createTime,10) createTime,orderStatus,count(orderId) orderNum')->name('orders')->whereTime('createTime','between',[$start,$end])
                ->where('shopId',$shopId)
                ->order('createTime asc')
                ->group('left(createTime,10),orderStatus')->select();
       $rdata = ['list'=>[]];
       if(count($rs)>0){
            $days = [];
            $tmp = [];
            $map = ['-3'=>0,'-1'=>0,'1'=>0,'-2'=>0];
            foreach($rs as $key => $v){
                if(!in_array($v['createTime'],$days))$days[] = $v['createTime'];
                $tmp[$v['orderStatus'].'_'.$v['createTime']] = $v['orderNum'];
            }
            foreach($days as $v){
                $total = 0;
                $ou = 0;
                $o_3 = isset($tmp['-3_'.$v])?$tmp['-3_'.$v]:0;
                $o_1 = isset($tmp['-1_'.$v])?$tmp['-1_'.$v]:0;
                $o_f2 = isset($tmp['-2_'.$v])?$tmp['-2_'.$v]:0;
                if(isset($tmp['0_'.$v]))$ou += $tmp['0_'.$v];
                if(isset($tmp['1_'.$v]))$ou += $tmp['1_'.$v];
                if(isset($tmp['2_'.$v]))$ou += $tmp['2_'.$v];
                if(isset($tmp['-2_'.$v]))$ou += $tmp['-2_'.$v];
                $rdata['-2'][] = $o_f2;
                $rdata['-3'][] = $o_3;
                $rdata['-1'][] = $o_1;
                $rdata['1'][] = $ou;
                $map['-2']  += $o_f2;
                $map['-3']  += $o_3;
                $map['-1']  += $o_1;
                $map['1']  += $ou;
                $total += $o_f2;
                $total += $o_3;
                $total += $o_1;
                $total += $ou;
                $rdata['total'][] = $total;
                $rdata['list'][] = ['day'=>$v,'o3'=>$o_3,'of2'=>$o_f2,'o1'=>$o_1,'ou'=>$ou,'total'=>$total];
            }
            $rdata['days'] = $days;
            $rdata['map'] = $map;
       }
       return WSTReturn('',1,$rdata);
    }
}

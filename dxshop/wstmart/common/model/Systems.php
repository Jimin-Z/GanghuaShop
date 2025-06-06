<?php
namespace wstmart\common\model;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 某些较杂业务处理类
 */
use think\Db;
class Systems extends Base{
	/**
	 * 获取定时任务
	 */
	public function getSysMessages(){
		$tasks = strtolower(input('post.tasks'));
		$tasks = explode(',',$tasks);
		$userId = (int)session('WST_USER.userId');
		$shopId = (int)session('WST_USER.shopId');
		$data = [];
		if(in_array('message',$tasks)){
		    //获取用户未读消息
		    $data['message']['num'] = Db::name('messages')->where(['receiveUserId'=>$userId,'msgStatus'=>0,'dataFlag'=>1])->count();
		    $data['message']['id'] = 49;
		    $data['message']['sid'] = 120;
		}
		if($shopId>0){
			//获取商家待处理订单
			if(in_array('shoporder24',$tasks)){
			    $data['shoporder']['24'] = Db::name('orders')->where(['shopId'=>$shopId,'orderStatus'=>0,'dataFlag'=>1])->count();
			}
			if(in_array('shoporder25',$tasks)){
			    $data['shoporder']['25'] = Db::name('order_complains')->where(['respondTargetId'=>$shopId,'complainStatus'=>1])->count();
			}
			if(in_array('shoporder55',$tasks)){
			    $data['shoporder']['55'] = Db::name('orders')->where(['shopId'=>$shopId,'orderStatus'=>-2,'dataFlag'=>1])->count();
			}
			if(in_array('shoporder45',$tasks)){
			    //在线支付的退款单
			    $data['shoporder']['45'] = Db::name('orders')->alias('o')->join('order_refunds orf','orf.orderId=o.orderId')->where(['shopId'=>$shopId,'orf.refundStatus'=>0,'o.dataFlag'=>1])->count();
			}
			//售后信息
			if(in_array('shoporder306',$tasks)){
                $data['shoporder']['306'] = Db::name('orders')->alias('o')->join('order_services orf','orf.orderId=o.orderId')->where([['o.shopId','=',$shopId], ['orf.isClose', "=", 0], ['orf.serviceStatus','in',[0,2,3]],['o.dataFlag','=',1]])->count();
			}
			if(in_array('shoporder54',$tasks)){
			    //获取库存预警数量
			    $goodsn = Db::name('goods')->where('shopId ='.$shopId.' and dataFlag = 1 and goodsStock <= warnStock and isSpec = 0 and warnStock>0')->count();
			    $specsn = Db::name('goods_specs')->where('shopId ='.$shopId.' and dataFlag = 1 and specStock <= warnStock and warnStock>0')->count();
			    $data['shoporder']['54'] = $goodsn+$specsn;
			}
		}
		//获取用户订单状态
	    if(in_array('userorder',$tasks)){
		    $data['userorder']['3'] = Db::name('orders')->where(['userId'=>$userId,'orderStatus'=>-2,'dataFlag'=>1])->count();
		    $data['userorder']['5'] = Db::name('orders')->where([['orderStatus','in',[0,1]],['userId','=',$userId],['dataFlag','=',1]])->count();
		    $data['userorder']['6'] = Db::name('orders')->where(['userId'=>$userId,'orderStatus'=>2,'isAppraise'=>0,'dataFlag'=>1])->count();
		}
		//获取用户购物车数量
		if(in_array('cart',$tasks)){
			$cartNum = 0;
			$cartGoodsNum = 0;
			$rs = Db::name('carts')->field('cartNum')->where(['userId'=>$userId])->select();
			foreach($rs as $key => $v){
				$cartGoodsNum++;
				$cartNum = $cartNum + $v['cartNum'];
			}
			$data['cart']['goods'] = $cartGoodsNum;
			$data['cart']['num'] = $cartNum;
		}
		return $data;
	}
}

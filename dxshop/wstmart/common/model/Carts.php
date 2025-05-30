<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 购物车业务处理类
 */

class Carts extends Base{
	protected $pk = 'cartId';
	/**
	 * 加入购物车
	 */
	public function addCart($uId = 0){
		$userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
		$goodsId = (int)input('post.goodsId');
		$goodsSpecId = (int)input('post.goodsSpecId');
		$cartNum = (int)input('post.buyNum',1);
		$cartNum = ($cartNum>0)?$cartNum:1;
		$type = (int)input('post.type');
		if($userId==0)return WSTReturn('加入购物车失败，请先登录',-2);
		//验证传过来的商品是否合法
		$chk = $this->checkGoodsSaleSpec($goodsId,$goodsSpecId);
		if($chk['status']==-1)return $chk;
		//检测库存是否足够
		if($chk['data']['stock']<$cartNum)return WSTReturn("加入购物车失败，商品库存不足", -1);
		//添加实物商品
		if($chk['data']['goodsType']==0){
			$goodsSpecId = $chk['data']['goodsSpecId'];
			$goods = $this->where(['userId'=>$userId,'goodsId'=>$goodsId,'goodsSpecId'=>$goodsSpecId])->select();
			if(count($goods)==0){
				$data = array();
				$data['userId'] = $userId;
				$data['goodsId'] = $goodsId;
				$data['goodsSpecId'] = $goodsSpecId;
				$data['isCheck'] = 1;
                $data['cartNum'] = $cartNum;
                $data['createTime'] = date("Y-m-d H:i:s");
				$rs = $this->save($data);
			}else{
				$rs = $this->where(['userId'=>$userId,'goodsId'=>$goodsId,'goodsSpecId'=>$goodsSpecId])->setInc('cartNum',$cartNum);
			}
			if(false !==$rs){
				if($type==1){
					$cartId = $this->where(['userId'=>$userId,'goodsId'=>$goodsId,'goodsSpecId'=>$goodsSpecId])->value('cartId');
					$this->where("cartId = ".$cartId." and userId=".$userId)->setField('isCheck',1);
					$this->where("cartId != ".$cartId." and userId=".$userId)->setField('isCheck',0);
					$this->where(['cartId' =>$cartId,'userId'=>$userId])->setField('cartNum',$cartNum);
				}
				return WSTReturn("添加成功", 1);
			}
		}else{
			//非实物商品
            $carts = [];
            $carts['goodsId'] = $goodsId;
            $carts['cartNum'] = $cartNum;
            session('TMP_CARTS',$carts);
            return WSTReturn("添加成功", 1,['forward'=>'quickSettlement']);
		}
		return WSTReturn("加入购物车失败", -1);
	}
	/**
	 * 验证商品是否合法
	 */
	public function checkGoodsSaleSpec($goodsId,$goodsSpecId){
		$goods = model('Goods')->where(['goodsStatus'=>1,'dataFlag'=>1,'isSale'=>1,'goodsId'=>$goodsId])->field('goodsId,isSpec,goodsStock,goodsType')->find();
		if(empty($goods))return WSTReturn("添加失败，无效的商品信息", -1);
		$goodsStock = (int)$goods['goodsStock'];
		//有规格的话查询规格是否正确
		if($goods['isSpec']==1){
			$specs = Db::name('goods_specs')->where(['goodsId'=>$goodsId,'dataFlag'=>1])->field('id,isDefault,specStock')->select();
			if(count($specs)==0){
				return WSTReturn("添加失败，无效的商品信息", -1);
			}
			$defaultGoodsSpecId = 0;
			$defaultGoodsSpecStock = 0;
			$isFindSpecId = false;
			foreach ($specs as $key => $v){
				if($v['isDefault']==1){
					$defaultGoodsSpecId = $v['id'];
					$defaultGoodsSpecStock = (int)$v['specStock'];
				}
				if($v['id']==$goodsSpecId){
					$goodsStock = (int)$v['specStock'];
					$isFindSpecId = true;
				}
			}

			if($defaultGoodsSpecId==0)return WSTReturn("添加失败，无效的商品信息", -1);//有规格却找不到规格的话就报错
			if(!$isFindSpecId)return WSTReturn("", 1,['goodsSpecId'=>$defaultGoodsSpecId,'stock'=>$defaultGoodsSpecStock,'goodsType'=>$goods['goodsType']]);//如果没有找到的话就取默认的规格
			return WSTReturn("", 1,['goodsSpecId'=>$goodsSpecId,'stock'=>$goodsStock,'goodsType'=>$goods['goodsType']]);
		}else{
			return WSTReturn("", 1,['goodsSpecId'=>0,'stock'=>$goodsStock,'goodsType'=>$goods['goodsType']]);
		}
	}
	/**
	 * 删除购物车里的商品
	 */
	public function delCart($uId = 0){
		$userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
		$id = input('post.id');
		$id = explode(',',WSTFormatIn(",",$id));
		$id = array_filter($id);
		$this->where("userId = ".$userId." and cartId in(".implode(',', $id).")")->delete();
		return WSTReturn("删除成功", 1);
	}
	/**
	 * 取消购物车商品选中状态
	 */
	public function disChkGoods($goodsId,$goodsSpecId,$userId){
		$this->save(['isCheck'=>0],['userId'=>$userId,'goodsId'=>$goodsId,'goodsSpecId'=>$goodsSpecId]);
	}

	/**
	 * 获取session中购物车列表
	 */
	public function getQuickCarts($uId=0){
		$userId = ($uId==0)?(int)session('WST_USER.userId'):$uId;
		$tmp_carts = session('TMP_CARTS');
		$where = [];
		$where['goodsId'] = $tmp_carts['goodsId'];
		$rs = Db::name('goods')->alias('g')
		           ->join('__SHOPS__ s','s.shopId=g.shopId','left')
		           ->where($where)
		           ->field('g.goodsSn, g.productNo,s.userId,s.shopId,s.shopName,g.goodsId,s.shopQQ,shopWangWang,g.goodsName,g.shopPrice,g.shopPrice defaultShopPrice,g.goodsStock,g.goodsImg,g.goodsCatId,g.isFreeShipping,s.isInvoice,g.goodsType')
		           ->find();
		if(empty($rs))return ['carts'=>[],'goodsTotalMoney'=>0,'goodsTotalNum'=>0];
        $reduceMoney = WSTGetMemberGoodsReduceMoney($rs['goodsId'],$userId,$rs['shopId']);
        if($reduceMoney>0)$rs['shopPrice'] = WSTBCMoney($rs['shopPrice'],-$reduceMoney);
		$rs['cartNum'] = $tmp_carts['cartNum'];
		$carts = [];
		$cartShop = [];
		$goodsTotalNum = 1;
		$goodsTotalMoney = 0;
		//勿删！为插件促销活动做准备接口
		$rs['promotion'] = [];//商品要优惠的活动
		$cartShop['promotion'] = [];//店铺要优惠的活动
		$cartShop['promotionMoney'] = 0;//店铺要优惠的金额
		//---------------------------
		$cartShop['isFreeShipping'] = true;
		$cartShop['shopId'] = $rs['shopId'];
		$cartShop['isInvoice'] = $rs['isInvoice'];
		$cartShop['shopName'] = $rs['shopName'];
		$cartShop['shopQQ'] = $rs['shopQQ'];
		$cartShop['userId'] = $rs['userId'];
		$cartShop['shopWangWang'] = $rs['shopWangWang'];
		//判断能否购买，预设allowBuy值为10，为将来的各种情况预留10个情况值，从0到9
		$rs['allowBuy'] = 10;
		if($rs['goodsStock']<=0){
			$rs['allowBuy'] = 0;//库存不足
		}else if($rs['goodsStock']<$tmp_carts['cartNum']){
			//$rs['allowBuy'] = 1;//库存比购买数小
            $rs['cartNum'] = $rs['goodsStock'];
		}
		$cartShop['goodsMoney'] = $rs['shopPrice'] * $rs['cartNum'];
		$goodsTotalMoney = $goodsTotalMoney + $rs['shopPrice'] * $rs['cartNum'];
		$rs['specNames'] = [];
		$rs['cartId'] = $rs['goodsId'];
		unset($rs['shopName']);
		$cartShop['list'][] = $rs;
		$carts[$cartShop['shopId']] = $cartShop;
		$cartData = ['carts'=>$carts,'shopId'=>$cartShop['shopId'],'goodsTotalMoney'=>$goodsTotalMoney,'goodsTotalNum'=>$goodsTotalNum,'promotionMoney'=>0];
		//店铺优惠活动监听
		hook("afterQueryCarts",["carts"=>&$cartData,'isSettlement'=>true,'isVirtual'=>true,'uId'=>$userId]);
		return $cartData;
	}

	/**
	 * 获取购物车列表
	 */
	public function getCarts($isSettlement = false, $uId=0){
		$userId = ($uId==0)?(int)session('WST_USER.userId'):$uId;
		$where = [];
		$where['c.userId'] = $userId;
        $prefix = config('database.prefix');
		if($isSettlement)$where['c.isCheck'] = 1;
		$rs = Db::table($prefix.'carts')
		           ->alias([$prefix.'carts'=>'c',$prefix.'goods' => 'g',$prefix.'shops' => 's',$prefix.'goods_specs' => 'gs'])
		           ->join($prefix.'goods','c.goodsId=g.goodsId','inner')
		           ->join($prefix.'shops','s.shopId=g.shopId','left')
		           ->join($prefix.'goods_specs','c.goodsSpecId=gs.id','left')
		           ->where($where)
		           ->field('g.goodsSn, g.productNo, gs.productNo specProductNo, c.goodsSpecId,c.cartId,s.userId,s.shopId,s.shopName,g.goodsId,g.shippingFeeType,g.shopExpressId,s.shopQQ,shopWangWang,g.goodsName,g.shopPrice,g.shopPrice defaultShopPrice,g.goodsStock,g.goodsWeight,g.goodsVolume,g.isSpec,gs.specPrice,gs.specStock,gs.specWeight,gs.specVolume,g.goodsImg,c.isCheck,gs.specIds,c.cartNum,g.goodsCatId,g.isFreeShipping,s.isInvoice,g.goodsType')
		           ->select();
		$carts = [];
		$goodsIds = [];
		$goodsTotalNum = 0;
		$goodsTotalMoney = 0;
		foreach ($rs as $key =>$v){
			if(!isset($carts[$v['shopId']]['goodsMoney']))$carts[$v['shopId']]['goodsMoney'] = 0;
			if(!isset($carts[$v['shopId']]['isFreeShipping']))$carts[$v['shopId']]['isFreeShipping'] = true;
            $reduceMoney = WSTGetMemberGoodsReduceMoney($v['goodsId'],$userId,$v['shopId']);
            if($reduceMoney>0)$v['shopPrice'] = WSTBCMoney($v['shopPrice'],-$reduceMoney);
            //勿删！为插件促销活动做准备接口
			$v['promotion'] = [];//商品优惠活动
			$carts[$v['shopId']]['promotion'] = [];//店铺优惠活动
			$carts[$v['shopId']]['promotionMoney'] = 0;//店铺要优惠的金额
			//----------------------------
			$carts[$v['shopId']]['shopId'] = $v['shopId'];
			$carts[$v['shopId']]['shopName'] = $v['shopName'];
			$carts[$v['shopId']]['shopQQ'] = $v['shopQQ'];
			$carts[$v['shopId']]['userId'] = $v['userId'];
			$carts[$v['shopId']]['isInvoice'] = $v['isInvoice'];
			//如果店铺一旦不包邮了，那么就不用去判断商品是否包邮了
			if($v['isFreeShipping']==0 && $carts[$v['shopId']]['isFreeShipping'])$carts[$v['shopId']]['isFreeShipping'] = false;
			$carts[$v['shopId']]['shopWangWang'] = $v['shopWangWang'];
			if($v['isSpec']==1){
				$v['shopPrice'] = ($reduceMoney>0)?WSTBCMoney($v['specPrice'],-$reduceMoney):$v['specPrice'];
				$v['specPrice'] = ($reduceMoney>0)?WSTBCMoney($v['specPrice'],-$reduceMoney):$v['specPrice'];
				$v['defaultShopPrice'] = $v['specPrice'];
				$v['goodsStock'] = $v['specStock'];
				$v['goodsWeight'] = $v['specWeight'];
				$v['goodsVolume'] = $v['specVolume'];
				$v['productNo'] = $v['specProductNo'];
			}
			//判断能否购买，预设allowBuy值为10，为将来的各种情况预留10个情况值，从0到9
			$v['allowBuy'] = 10;
			if($v['goodsStock']<=0){
				$v['allowBuy'] = 0;//库存不足
			}else if($v['goodsStock']<$v['cartNum']){
				//$v['allowBuy'] = 1;//库存比购买数小
				$v['cartNum'] = $v['goodsStock'];
			}
			//如果是结算的话，则要过滤了不符合条件的商品
			if($isSettlement && $v['allowBuy']!=10){
				$this->disChkGoods($v['goodsId'],(int)$v['goodsSpecId'],(int)session('WST_USER.userId'));
				continue;
			}
			if($v['isCheck']==1){
				$carts[$v['shopId']]['goodsMoney'] = WSTBCMoney($carts[$v['shopId']]['goodsMoney'] , $v['shopPrice'] * $v['cartNum']);
				$goodsTotalMoney = $goodsTotalMoney + $v['shopPrice'] * $v['cartNum'];
				$goodsTotalNum++;
			}
			$v['specNames'] = [];
			unset($v['shopName']);
			// app端处理
			if($uId>0 && isset($v['goodsName'])){
				$v['goodsName'] = htmlspecialchars_decode($v['goodsName']);
			}

			$carts[$v['shopId']]['list'][] = $v;
			if(!in_array($v['goodsId'],$goodsIds))$goodsIds[] = $v['goodsId'];
		}

		//加载规格值
		if(count($goodsIds)>0){
		    $specs = DB::name('spec_items')->alias('s')->join('__SPEC_CATS__ sc','s.catId=sc.catId','left')
		        ->where([['s.goodsId','in',$goodsIds],['s.dataFlag','=',1]])->field('catName,itemId,itemName')->select();
		    if(count($specs)>0){
		    	$specMap = [];
		    	foreach ($specs as $key =>$v){
		    		$specMap[$v['itemId']] = $v;
		    	}
			    foreach ($carts as $key =>$shop){
			    	foreach ($shop['list'] as $skey =>$v){
			    		$strName = [];
			    		if($v['specIds']!=''){
			    			$str = explode(':',$v['specIds']);
			    			foreach ($str as $vv){
			    				if(isset($specMap[$vv]))$strName[] = $specMap[$vv];
			    			}
			    		}
			    		$carts[$key]['list'][$skey]['specNames'] = $strName;
			    	}
			    }
		    }
		}
		//过滤无效店铺
		foreach($carts as $key => $v){
            if(!isset($v['list']))unset($carts[$key]);
		}
		$cartData = ['carts'=>$carts,'goodsTotalMoney'=>WSTBCMoney($goodsTotalMoney,0),'goodsTotalNum'=>$goodsTotalNum,'promotionMoney'=>0];
		//店铺优惠活动监听
		hook("afterQueryCarts",["carts"=>&$cartData,'isSettlement'=>$isSettlement,'isVirtual'=>false,'uId'=>$userId]);
		return $cartData;
	}

	/**
	 * 获取购物车商品列表
	 */
	public function getCartInfo($isSettlement = false,$uId = 0){
		$userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
		$where = [];
		$where['c.userId'] = $userId;
		if($isSettlement)$where['c.isCheck'] = 1;
		$rs = $this->alias('c')->join('__GOODS__ g','c.goodsId=g.goodsId','inner')
		           ->join('__GOODS_SPECS__ gs','c.goodsSpecId=gs.id','left')
		           ->where($where)
		           ->field('c.goodsSpecId,c.cartId,g.goodsId,g.goodsName,g.shopPrice,g.goodsStock,g.isSpec,gs.specPrice,gs.specStock,g.goodsImg,c.isCheck,gs.specIds,c.cartNum,g.shopId')
		           ->select();
		$goodsIds = [];
		$goodsTotalMoney = 0;
		$goodsTotalNum = 0;
		foreach ($rs as $key =>$v){
			if(!in_array($v['goodsId'],$goodsIds))$goodsIds[] = $v['goodsId'];
            $reduceMoney = WSTGetMemberGoodsReduceMoney($v['goodsId'],$userId,$v['shopId']);
            if($reduceMoney>0)$rs[$key]['shopPrice'] = WSTBCMoney($v['shopPrice'],-$reduceMoney);
			if($v['isSpec']==1){
				$v['shopPrice'] = ($reduceMoney>0)?($v['specPrice'] - $reduceMoney):$v['specPrice'];
				$v['goodsStock'] = $v['specStock'];
			}
			if($v['goodsStock']<$v['cartNum']){
				$v['cartNum'] = $v['goodsStock'];
			}
			$goodsTotalMoney = $goodsTotalMoney + $v['shopPrice'] * $v['cartNum'];
			$rs[$key]['goodsImg'] = WSTImg($v['goodsImg']);
		}
	    //加载规格值
		if(count($goodsIds)>0){
		    $specs = DB::name('spec_items')->alias('s')->join('__SPEC_CATS__ sc','s.catId=sc.catId','left')
		        ->where([['s.goodsId','in',$goodsIds],['s.dataFlag','=',1]])->field('itemId,itemName')->select();
		    if(count($specs)>0){
		    	$specMap = [];
		    	foreach ($specs as $key =>$v){
		    		$specMap[$v['itemId']] = $v;
		    	}
			    foreach ($rs as $key =>$v){
			    	$strName = [];
			    	if($v['specIds']!=''){
			    		$str = explode(':',$v['specIds']);
			    		foreach ($str as $vv){
			    			if(isset($specMap[$vv]))$strName[] = $specMap[$vv]['itemName'];
			    		}
			    	}
			    	$rs[$key]['specNames'] = $strName;
			    }
		    }
		}
		$goodsTotalNum = count($rs);
		return ['list'=>$rs,'goodsTotalMoney'=>sprintf("%.2f", $goodsTotalMoney),'goodsTotalNum'=>$goodsTotalNum];
	}

	/**
	 * 修改购物车商品状态
	 */
	public function changeCartGoods($uId = 0){
		$isCheck = Input('post.isCheck/d',-1);
		$buyNum = Input('post.buyNum/d',1);
		if($buyNum<1)$buyNum = 1;
		$id = Input('post.id/d');
		$userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
		$data = [];
		if($isCheck!=-1)$data['isCheck'] = $isCheck;
		$data['cartNum'] = $buyNum;
		$this->where(['userId'=>$userId,'cartId'=>$id])->update($data);
		return WSTReturn("操作成功", 1);
	}

	/**
	 * 批量修改购物车商品状态
	 */
	public function batchChangeCartGoods($uId = 0){
		$ids = input('ids');
		if($ids=='')return WSTReturn("操作失败");
        $ids = explode(',',WSTFormatIn(',',$ids));
        $userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
        $isCheck = ((int)input('post.isCheck/d',-1)==1)?1:0;
        $this->where([['cartId','in',$ids],['userId','=',$userId]])->update(['isCheck'=>$isCheck]);
		return WSTReturn("操作成功", 1);
	}
	/**
	 * 计算订单金额
	 */
	public function getCartMoney($uId=0){
		$data = ['shops'=>[],'totalMoney'=>0,'totalGoodsMoney'=>0,'orderScore'=>0];
        $areaId = input('post.areaId2/d',-1);
		//计算各店铺运费及金额

		$carts = $this->getCarts(true,$uId);
		foreach ($carts['carts'] as $key =>$v){
			$shopFreight = 0;
			if($v['isFreeShipping']){
                $data['shops'][$v['shopId']]['freight'] = 0;
			}else{
				$deliverType = (int)input('deliverType_'.$v['shopId']);
				if($areaId>0){
					$shopFreight = ($deliverType==1)?0:WSTOrderFreight($v['shopId'],$areaId,$v);
				}else{
					$shopFreight = 0;
				}
                $data['shops'][$v['shopId']]['freight'] = $shopFreight;
			}
			$data['shops'][$v['shopId']]['oldGoodsMoney'] = WSTBCMoney($v['goodsMoney'],0);
			$data['shops'][$v['shopId']]['goodsMoney'] = WSTBCMoney($v['goodsMoney']+$shopFreight-$v['promotionMoney'],0);
			$data['shops'][$v['shopId']]['orderScore'] = WSTMoneyGiftScore($data['shops'][$v['shopId']]['goodsMoney']);
			$data['totalGoodsMoney'] += $v['goodsMoney']-$v['promotionMoney'];
			$data['totalMoney'] += $v['goodsMoney'] + $shopFreight-$v['promotionMoney'];
			$data['orderScore'] += $data['shops'][$v['shopId']]['orderScore'];
		}
		//此处放钩子计算商家使用优惠券后的金额-根据优惠券ID计算
		hook("afterCalculateCartMoney",["data"=>&$data,'carts'=>$carts,'isVirtual'=>false,'uId'=>$uId]);
        $data['totalMoney'] = WSTBCMoney($data['totalMoney'],0);
        $data['totalGoodsMoney'] = WSTBCMoney($data['totalGoodsMoney'],0);
		$data['totalGoodsMoney'] = ($data['totalGoodsMoney']>$data['totalMoney'])?$data['totalMoney']:$data['totalGoodsMoney'];
		//判断是否使用积分
		$isUseScore = (int)input('isUseScore');
		$useScore = (int)input('useScore');
		$orderUsableScore = WSTOrderUsableScore($data['totalGoodsMoney'],$uId);
		$data['maxScore'] = $orderUsableScore['score'];
		$data['maxScoreMoney'] = WSTBCMoney($orderUsableScore['money'],0);
		$data['useScore'] = 0;
		$data['scoreMoney'] = 0;
		if($isUseScore==1){
			//不能比用户积分还多
			if($useScore>$data['maxScore'])$useScore = $data['maxScore'];
			$data['useScore'] = $useScore;
            $data['scoreMoney'] = WSTScoreToMoney($useScore);
		}
		$data['realTotalMoney'] = WSTPositiveNum($data['totalMoney'] - $data['scoreMoney']);
		return WSTReturn('',1,$data);
	}

	public function getQuickCartMoney($uId=0){
		$data = ['shops'=>[],'totalMoney'=>0,'totalGoodsMoney'=>0,'orderScore'=>0];
        $areaId = input('post.areaId2/d',-1);
		//计算各店铺运费及金额
		$carts = $this->getQuickCarts($uId);
		$cart = current($carts['carts']);
		$data['shops'][$cart['shopId']]['freight'] = 0;
		$data['shops'][$cart['shopId']]['goodsMoney'] = $cart['goodsMoney'];
		$data['shops'][$cart['shopId']]['orderScore'] = WSTMoneyGiftScore($cart['goodsMoney']);
		$data['totalGoodsMoney'] = $cart['goodsMoney'];
		$data['totalMoney'] += $cart['goodsMoney'];
		$data['orderScore'] += WSTMoneyGiftScore($cart['goodsMoney']);
		//此处放钩子计算商家使用优惠券后的金额-根据优惠券ID计算
		hook("afterCalculateCartMoney",["data"=>&$data,'carts'=>$carts,'isVirtual'=>true,'uId'=>$uId]);
		$data['totalGoodsMoney'] = ($data['totalGoodsMoney']>$data['totalMoney'])?$data['totalMoney']:$data['totalGoodsMoney'];
		//判断是否使用积分
		$isUseScore = (int)input('isUseScore');
        $useScore = (int)input('useScore');
		$orderUsableScore = WSTOrderUsableScore($carts['goodsTotalMoney']-$carts['promotionMoney'],$uId);
        $data['maxScore'] = $orderUsableScore['score'];
		$data['maxScoreMoney'] = $orderUsableScore['money'];;
		$data['useScore'] = 0;
		$data['scoreMoney'] = 0;
		if($isUseScore==1){
			//不能比用户积分还多
			if($useScore>$data['maxScore'])$useScore = $data['maxScore'];
			$data['useScore'] = $useScore;
            $data['scoreMoney'] = WSTScoreToMoney($useScore);
		}
		$data['realTotalMoney'] = WSTPositiveNum($data['totalMoney'] - $data['scoreMoney']);
		return WSTReturn('',1,$data);
	}

	/**
	 * 删除购物车商品
	 */
	public function delCartByUpdate($goodsId){
		if(is_array($goodsId)){
            $this->where([['goodsId','in',$goodsId]])->delete();
		}else{
			$this->where('goodsId',$goodsId)->delete();
		}

	}

   function getfreight($shopId,$shopExpressId,$cityId){
   	    $where = [];
		$where[] = ["shopId",'=',$shopId];
		$where[] = ["shopExpressId",'=',$shopExpressId];
		$where[] = ["tempType",'=',1];
		$where[] = ["dataFlag",'=',1];
		$table= Db::name("shop_freight_template");
		$freightTemp =$table->where($where)->where("FIND_IN_SET(".$cityId.",cityIds)")->find();
		if(empty($freightTemp)){
			$where[] = ["tempType",'=',0];
			$freightTemp =$table->where($where)->find();
			if(empty($freightTemp)){
			   $freightTemp["buyNumStart"]=1;
			   $freightTemp["buyNumStartPrice"]=0;
			   $freightTemp["buyNumContinue"]=1;
			   $freightTemp["buyNumContinuePrice"]=0;
 		       $freightTemp["weightStart"]=0;
			   $freightTemp["weightStartPrice"]=1;
			   $freightTemp["weightContinue"]=0;
			   $freightTemp["weightContinuePrice"]=1;
			   $freightTemp["volumeStart"]=1;
			   $freightTemp["volumeStartPrice"]=1;
			   $freightTemp["volumeContinue"]=1;
			   $freightTemp["volumeContinuePrice"]=1;
		    }
		}
		return  $freightTemp;
   }
	/**
	 * 计算运费价格
	 */
    public function getShopFreight($shopId,$cityId,$carts=[]){
        $calculatePrice = 0;
        if(isset($carts['list'])){
            $tempFreightList = [];
            foreach ($carts['list'] as $key => $v) {
                if (!isset($v['isFreeShipping']) || (int)$v['isFreeShipping'] == 0) {
                    $fNum = 0;
                    if ($v['shippingFeeType'] == 1) {//计件
                        $fNum = $v['cartNum'];
                    } else if ($v['shippingFeeType'] == 2) {//重量
                        $fNum = $v['goodsWeight'] * $v['cartNum'];
                    } else if ($v['shippingFeeType'] == 3) {//体积
                        $fNum = $v['goodsVolume'] * $v['cartNum'];
                    }
                    $bNum = 0;
                    if (isset($tempFreightList[ $v['shopExpressId'] . '_' . $v['shippingFeeType']])) {
                        $bNum = $tempFreightList[ $v['shopExpressId'] . '_' . $v['shippingFeeType']];
                    }
                    $tempFreightList[$v['shopExpressId'] . '_' . $v['shippingFeeType']] = $fNum + $bNum;
                }
            }
        	foreach ($tempFreightList as $key => $cartNum) {
                $arr = explode("_",$key);
	        	$shopExpressId = (int)$arr[0];
		        $shippingFeeType = (int)$arr[1];
		        $freightTemp=$this->getfreight($shopId,$shopExpressId,$cityId);
		     
		       	if($shippingFeeType==1){//计件
		       		$buyNumStart = (int)$freightTemp["buyNumStart"];
			       	$buyNumStartPrice = $freightTemp["buyNumStartPrice"];
			       	$buyNumContinue = (int)$freightTemp["buyNumContinue"];
			       	$buyNumContinuePrice = $freightTemp["buyNumContinuePrice"];
					$calculatePrice += $buyNumStartPrice;
			       	if($cartNum>$buyNumStart){
			       		$moreBuyNum = $cartNum-$buyNumStart;
			       		$times = 0;
			       		if($buyNumContinue>0){
			       			$times = ceil($moreBuyNum/$buyNumContinue);
			       		}
			       		$calculatePrice +=  $buyNumContinuePrice*$times;
			       	}
		       	}else if($shippingFeeType==2){//重量
		       		$weightStart = (float)$freightTemp["weightStart"];
			       	$weightStartPrice = (float)$freightTemp["weightStartPrice"];
			       	$weightContinue = (float)$freightTemp["weightContinue"];
			       	$weightContinuePrice = (float)$freightTemp["weightContinuePrice"];
			       	$goodsWeight = $cartNum;
			       	$calculatePrice += $weightStartPrice;
			       	if($goodsWeight>$weightStart){
			       		$moreWeight = $goodsWeight-$weightStart;
			       		$times = 0;
			       		if($weightContinue>0){
			       			$times = ceil($moreWeight/$weightContinue);
			       		}
			       		$calculatePrice +=  $weightContinuePrice*$times;
			       	}
		       	}else if($shippingFeeType==3){//体积
		       		$volumeStart = (float)$freightTemp["volumeStart"];
			       	$volumeStartPrice = (float)$freightTemp["volumeStartPrice"];
			       	$volumeContinue = (float)$freightTemp["volumeContinue"];
			       	$volumeContinuePrice = (float)$freightTemp["volumeContinuePrice"];
		       		$goodsVolume = $cartNum;
		       		$calculatePrice += $volumeStartPrice;
			       	if($goodsVolume>$volumeStart){
			       		$moreVolume = $goodsVolume-$volumeStart;
			       		$times = 0;
			       		if($volumeContinue>0){
			       			$times = ceil($moreVolume/$volumeContinue);
			       		}
			       		$calculatePrice += $volumeContinuePrice*$times;
			       	}
			
		       	}
	        }
        }
        return WSTBCMoney($calculatePrice,0);
    }

    /**
     * 将购物车里选择的商品移入我的关注
     */
    public function moveToFavorites($uId = 0){
        $userId = ($uId>0)?$uId:(int)session('WST_USER.userId');
        $goodsIds = input('post.goodsIds');
        $goodsIds = explode(',',WSTFormatIn(",",$goodsIds));
        $goodsIds = array_filter($goodsIds);
        $cartIds = input('post.cartIds');
        $cartIds = explode(',',WSTFormatIn(",",$cartIds));
        $cartIds = array_filter($cartIds);
        Db::startTrans();
        try{
            for($i=0;$i<count($goodsIds);$i++){
                $favoriteId = Db::name('favorites')->where(['userId'=>$userId,'goodsId'=>$goodsIds[$i]])->value('favoriteId');
                if(empty($favoriteId)){
                    $data = [
                        'userId'=>$userId,
                        'goodsId'=>$goodsIds[$i],
                        'createTime'=>date('Y-m-d H:i:s')
                    ];
                    Db::name('favorites')->insert($data);
                }
            }
            $this->where("userId = ".$userId." and cartId in(".implode(',', $cartIds).")")->delete();
            Db::commit();
            return WSTReturn("关注成功", 1);
        }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('关注失败',-1);
        }
    }
}

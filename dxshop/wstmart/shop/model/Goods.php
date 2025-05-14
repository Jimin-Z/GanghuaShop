<?php
namespace wstmart\shop\model;
use wstmart\common\model\Goods as CGoods;
use wstmart\common\model\Carts;
use wstmart\common\validate\Goods as Validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品类
 */
class Goods extends CGoods{

	/*
     * 在商品列表编辑商品规格
     */
	public function editSpecGoods(){
        $goodsId = input('post.goodsId');
        $specsIds = input('post.specsIds');
        $data = input('post.');
        WSTUnset($data,'goodsId,dataFlag,createTime');
        $goods = $this->where(['goodsId'=>$goodsId,'dataFlag'=>1])->field('goodsType')->find();
        if(empty($goods))return WSTReturn('商品不存在');
        //不允许修改商品类型
        $data['goodsType'] = $goods['goodsType'];
        Db::startTrans();
        try{
            $validate = new Validate();
            if(!$validate->scene('editSpec')->check($data))return WSTReturn($validate->getError());
            /**
             * 编辑的时候如果不想影响商品销售规格的销量，那么就要在保存的时候区别对待已经存在的规格和销售规格记录。
             * $specNameMap的保存关系是：array('页面上生成的规格值ID'=>数据库里规则值的ID)
             * $specIdMap的保存关系是:array('页面上生成的销售规格ID'=>数据库里销售规格ID)
             */
            $specNameMapTmp = explode(',',input('post.specmap'));
            $specIdMapTmp = explode(',',input('post.specidsmap'));
            $specNameMap = [];//规格值对应关系
            $specIdMap = [];//规格和表对应关系
            foreach ($specNameMapTmp as $key =>$v){
                if($v=='')continue;
                $v = explode(':',$v);
                $specNameMap[$v[1]] = $v[0];   //array('页面上的规则值ID'=>数据库里规则值的ID)
            }
            foreach ($specIdMapTmp as $key =>$v){
                if($v=='')continue;
                $v = explode(':',$v);
                $specIdMap[$v[1]] = $v[0];     //array('页面上的销售规则ID'=>数据库里销售规格ID)
            }
            //如果是实物商品并且有销售规格则保存销售和规格值
            if($data['goodsType'] ==0 && $specsIds!=''){
                //把之前之前的销售规格
                $specsIds = explode(',',$specsIds);
                $specsArray = [];
                foreach ($specsIds as $v){
                    $vs = explode('-',$v);
                    foreach ($vs as $vv){
                        if(!in_array($vv,$specsArray))$specsArray[] = $vv;//过滤出不重复的规格值
                    }
                }
                //先标记作废之前的规格值
                Db::name('spec_items')->where(['goodsId'=>$goodsId])->update(['dataFlag'=>-1]);
                //保存规格名称
                $specMap = [];
                foreach ($specsArray as $v){
                    $vv = explode('_',$v);
                    $specNumId = $vv[0]."_".$vv[1];
                    $sitem = [];
                    $sitem['itemName'] = input('post.specName_'.$specNumId);
                    $sitem['itemImg'] = input('post.specImg_'.$specNumId);
                    //如果已经存在的规格值则修改，否则新增
                    if(isset($specNameMap[$specNumId]) && (int)$specNameMap[$specNumId]!=0){
                        $sitem['dataFlag'] = 1;
                        WSTUseResource(0, (int)$specNameMap[$specNumId], $sitem['itemImg'],'spec_items','itemImg');
                        Db::name('spec_items')->where(['itemId'=>(int)$specNameMap[$specNumId]])->update($sitem);
                        $specMap[$v] = (int)$specNameMap[$specNumId];
                    }else{
                        $sitem['goodsId'] = $goodsId;
                        $sitem['catId'] = (int)$vv[0];
                        $sitem['dataFlag'] = 1;
                        $sitem['createTime'] = date('Y-m-d H:i:s');
                        $itemId = Db::name('spec_items')->insertGetId($sitem);
                        if($sitem['itemImg']!='')WSTUseResource(0, $itemId, $sitem['itemImg']);
                        $specMap[$v] = $itemId;
                    }
                }
                //删除已经作废的规格值
                Db::name('spec_items')->where(['goodsId'=>$goodsId,'dataFlag'=>-1])->delete();
                //保存销售规格
                $defaultPrice = 0;//默认价格
                $totalStock = 0;//总库存
                $gspecArray = [];
                //把之前的销售规格值标记删除
                Db::name('goods_specs')->where(['goodsId'=>$goodsId])->update(['dataFlag'=>-1,'isDefault'=>0]);
                $isFindDefaultSpec = false;
                $defaultSpec = input('post.defaultSpec');
                foreach ($specsIds as $v){
                    $vs = explode('-',$v);
                    $goodsSpecIds = [];
                    foreach ($vs as $gvs){
                        $goodsSpecIds[] = $specMap[$gvs];
                    }
                    $gspec = [];
                    $gspec['specIds'] = implode(':',$goodsSpecIds);
                    $gspec['productNo'] = input('productNo_'.$v);
                    $gspec['marketPrice'] = (float)input('marketPrice_'.$v);
                    $gspec['specPrice'] = (float)input('specPrice_'.$v);
                    $gspec['costPrice'] = (float)input('costPrice_'.$v);
                    $gspec['specStock'] = (int)input('specStock_'.$v);
                    $gspec['warnStock'] = (int)input('warnStock_'.$v);
                    $gspec['specWeight'] = (float)Input('specWeight_'.$v);
                    $gspec['specVolume'] = (float)Input('specVolume_'.$v);
                    //设置默认规格
                    if($defaultSpec==$v){
                        $gspec['isDefault'] = 1;
                        $isFindDefaultSpec = true;
                        $defaultPrice = $gspec['specPrice'];
                    }else{
                        $gspec['isDefault'] = 0;
                    }
                    //如果是已经存在的值就修改内容，否则新增
                    if(isset($specIdMap[$v]) && $specIdMap[$v]!=''){
                        $gspec['dataFlag'] = 1;
                        Db::name('goods_specs')->where(['id'=>(int)$specIdMap[$v]])->update($gspec);
                    }else{
                        $gspec['goodsId'] = $goodsId;
                        $gspecArray[] = $gspec;
                    }
                    //获取总库存
                    $totalStock = $totalStock + $gspec['specStock'];
                }
                if(!$isFindDefaultSpec)return WSTReturn("请选择推荐规格");
                //删除作废的销售规格值
                Db::name('goods_specs')->where(['goodsId'=>$goodsId,'dataFlag'=>-1])->delete();
                if(count($gspecArray)>0){
                    Db::name('goods_specs')->insertAll($gspecArray);
                }
                //更新推荐规格和总库存
                $this->where('goodsId',$goodsId)->update(['isSpec'=>1,'shopPrice'=>$defaultPrice,'goodsStock'=>$totalStock]);
            }else if($specsIds==''){
                Db::name('spec_items')->where(['goodsId'=>$goodsId])->delete();
                Db::name('goods_specs')->where(['goodsId'=>$goodsId])->delete();
            }
            //删除购物车里的商品
            $c = new Carts;
            $c->delCartByUpdate($goodsId);
            Db::commit();
            return WSTReturn("编辑成功", 1,['id'=>$goodsId]);
        }catch (\Exception $e) {
            Db::rollback();
            return WSTReturn('编辑失败',-1);
        }
    }



	/**
	* 修改商品状态
	*/
	public function changSaleStatus(){
		$shopId = (int)session('WST_USER.shopId');
		$allowArr = ['isHot','isNew','isBest','isRecom'];
		$is = input('post.is');
		if(!in_array($is,$allowArr))return WSTReturn('非法操作',-1);
		$status = (input('post.status',1)==1)?0:1;
		$id = (int)input('post.id');
		$rs = $this->where(["shopId"=>$shopId,'goodsId'=>$id])->setField($is,$status);
		if($rs!==false){
			return WSTReturn('设置成功',1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}
	/**
	 * 批量修改商品状态
	 */
	public function changeGoodsStatus(){
		$shopId = (int)session('WST_USER.shopId');
		//设置为什么 hot new best rec
		$allowArr = ['isHot','isNew','isBest','isRecom'];
		$is = input('post.is');
		if(!in_array($is,$allowArr))return WSTReturn('非法操作',-1);
		//设置哪一个状态
		$status = input('post.status',1);
		$ids = input('post.ids/a');
		$rs = $this->where([['goodsId','in',$ids],['shopId','=',$shopId]])->setField($is, $status);
		if($rs!==false){
			return WSTReturn('设置成功',1);
		}else{
			return WSTReturn($this->getError(),-1);
		}

	}

	/**
	 * 修改商品库存/价格
	 */
	public function editGoodsBase(){
		$goodsId = (int)Input("goodsId");
		$post = input('post.');
		$data = [];
		if(isset($post['goodsStock'])){
			$data['goodsStock'] = (int)input('post.goodsStock',0);
			if($data['goodsStock']<0)return WSTReturn('操作失败，库存不能为负数');
		}elseif(isset($post['shopPrice'])){
			$data['shopPrice'] = (float)input('post.shopPrice',0);
			if($data['shopPrice']<0.01)return WSTReturn('操作失败，价格必须大于0.01');
		}else{
			return WSTReturn('操作失败',-1);
		}
		$rs = $this->update($data,['goodsId'=>$goodsId,'shopId'=>(int)session('WST_USER.shopId')]);
		if($rs!==false){
			return WSTReturn('操作成功',1);
		}else{
			return WSTReturn('操作失败',-1);
		}
	}

	/**
	 *  预警修改预警库存
	 */
	public function editwarnStock(){
		$id = input('post.id/d');
		$type = input('post.type/d');
		$number = (int)input('post.number');
		$shopId = (int)session('WST_USER.shopId');
		$data = $data2 = [];
		$data['shopId'] =  $data2['shopId'] = $shopId;
		$datat=array('1'=>'specStock','2'=>'warnStock','3'=>'goodsStock','4'=>'warnStock');
		if(!empty($type)){
			$data[$datat[$type]] = $number;
			if($type==1 || $type==2){
				$data['goodsId'] = $goodsId = input('post.goodsId/d');
				$rss = Db::name("goods_specs")->where('id', $id)->update($data);
				//更新商品库存
				$goodsStock = 0;
				if($rss!==false){
					$specStocks = Db::name("goods_specs")->where(['shopId'=>$shopId,'goodsId'=>$goodsId,'dataFlag'=>1])->field('specStock')->select();
					foreach ($specStocks as $key =>$v){
						$goodsStock = $goodsStock+$v['specStock'];
					}
					$data2['goodsStock'] = $goodsStock;
					$rs = $this->update($data2,['goodsId'=>$goodsId]);
				}else{
					return WSTReturn('操作失败',-1);
				}
			}
			if($type==3 || $type==4){
				$rs = $this->update($data,['goodsId'=>$id]);
			}
			if($rs!==false){
				return WSTReturn('操作成功',1);
			}else{
				return WSTReturn('操作失败',-1);
			}
		}
		return WSTReturn('操作失败',-1);
	}

	public function checkExportGoods(){
		$shopId = (int)session('WST_USER.shopId');
		$where = [];
		$where[] = ['shopId',"=",$shopId];
		$where[] = ['goodsStatus',"=",1];
		$where[] = ['dataFlag',"=",1];
		$where[] = ['isSale',"=",1];
		$ids = input('post.ids/a');
		if(is_array($ids) && count($ids)>0){
			$where[] = ['goodsId','in',$ids];
		}else{

			$goodsAttr = (int)input('goodsAttr',-1);
			if(in_array($goodsAttr,[0,1,2,3])){
				$types = ['isRecom','isHot','isBest','isNew'];
				$where[] = [$types[$goodsAttr],"=",1];
			}
			$goodsType = input('goodsType');
			if($goodsType!='')$where[] = ['goodsType',"=",(int)$goodsType];
			$c1Id = (int)input('cat1');
			$c2Id = (int)input('cat2');
			$goodsName = input('goodsName');
			if($goodsName != ''){
				$where[] = ['goodsName|goodsSn','like',"%$goodsName%"];
			}
			if($c2Id!=0 && $c1Id!=0){
				$where[] = ['shopCatId2',"=",$c2Id];
			}else if($c1Id!=0){
				$where[] = ['shopCatId1',"=",$c1Id];
			}
		}
		$rs = $this->where($where)
				->field('goodsId,goodsName,goodsSn')
				->select();
		return $rs;
	}
}

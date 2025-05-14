<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\GoodsAppraises as validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品评价业务处理
 */
class GoodsAppraises extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
	    $isReport = (int)input('isReport',-1);
		$where = 'p.shopId=g.shopId and gp.goodsId=g.goodsId and o.orderId=gp.orderId';
		$shopName = input('shopName');
     	$goodsName = input('goodsName');

     	if($isReport==-1){
            $areaId1 = (int)input('areaId1');
            if($areaId1>0){
                $where.=" and p.areaIdPath like '".$areaId1."%'";

                $areaId2 = (int)input("areaId1_".$areaId1);
                if($areaId2>0)
                    $where.=" and p.areaIdPath like '".$areaId1."_".$areaId2."%'";

                $areaId3 = (int)input("areaId1_".$areaId1."_".$areaId2);
                if($areaId3>0)
                    $where.=" and p.areaId = $areaId3";
            }
        }else{
            $areaId1 = (int)input('areaId2');
            if($areaId1>0){
                $where.=" and p.areaIdPath like '".$areaId1."%'";

                $areaId2 = (int)input("areaId2_".$areaId1);
                if($areaId2>0)
                    $where.=" and p.areaIdPath like '".$areaId1."_".$areaId2."%'";

                $areaId3 = (int)input("areaId2_".$areaId1."_".$areaId2);
                if($areaId3>0)
                    $where.=" and p.areaId = $areaId3";
            }
        }

	 	if($shopName!='')
	 		$where.=" and (p.shopName like '%".$shopName."%' or p.shopSn like '%".$shopName."%')";
	 	if($goodsName!='')
	 		$where.=" and (g.goodsName like '%".$goodsName."%' or g.goodsSn like '%".$goodsName."%')";
	 	if($isReport!=-1){
	 	    $where.= " and gp.isReport=1";
        }else{
            $where.= " and gp.isReport=0 and gp.dataFlag=1";
        }
	 	$sort = input('sort');
		$order = [];
		if($sort!=''){
			$sortArr = explode('.',$sort);
			$order = $sortArr[0].' '.$sortArr[1];
		}
		$rs = $this->alias('gp')->field('gp.*,g.goodsName,g.goodsImg,o.orderNo,u.loginName')
					->join('__GOODS__ g ','gp.goodsId=g.goodsId','left')
		         	->join('__ORDERS__ o','gp.orderId=o.orderId','left')
		         	->join('__USERS__ u','u.userId=gp.userId','left')
		         	->join('__SHOPS__ p','p.shopId=gp.shopId','left')
		         	->where($where)
		         	->order($order)
		         	->order('id desc')
		         	->paginate(input('limit/d'))->toArray();
		return $rs;
	}
	public function getById($id){
		return $this->alias('gp')->field('gp.*,o.orderNo,u.loginName,g.goodsName,g.goodsImg')
					->join('__GOODS__ g ','gp.goodsId=g.goodsId','left')
		         	->join('__ORDERS__ o','gp.orderId=o.orderId','left')
		         	->join('__USERS__ u','u.userId=gp.userId','left')
		         	->where('gp.id',$id)->find();
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$Id = input('post.id/d',0);
		$data = input('post.');
		$data['isShow'] = ((int)$data['isShow']==1)?1:0;
		WSTUnset($data,'createTime');
		Db::startTrans();
        try{
        	$validate = new validate();
		    if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
		    $result = $this->allowField(true)->save($data,['id'=>$Id]);
	        if(false !== $result){
	        	$goodsAppraises = $this->get($Id);
	        	$this->statGoodsAppraises($goodsAppraises->goodsId,$goodsAppraises->shopId);
	        	Db::commit();
	        	return WSTReturn("编辑成功", 1);
	        }else{
	        	return WSTReturn($this->getError(),-1);
	        }
	    }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn("编辑失败");
	}
	/**
	 * 删除
	 */
    public function del(){
	    $id = input('post.id/d',0);
	    Db::startTrans();
        try{
		    $goodsAppraises = $this->get($id);
		    $goodsAppraises->dataFlag = -1;
		    $result = $goodsAppraises->save();
	        if(false !== $result){
	        	$this->statGoodsAppraises($goodsAppraises->goodsId,$goodsAppraises->shopId);
	        	Db::commit();
	        	return WSTReturn("删除成功", 1);
	        }else{
	        	return WSTReturn($this->getError(),-1);
	        }
	    }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn("删除失败");
	}

	/**
	 * 重新统计商品
	 */
	public function statGoodsAppraises($goodsId,$shopId){
        $rs = Db::name('goods_appraises')->where(['goodsId'=>$goodsId,'isShow'=>1,'dataFlag'=>1])
               ->field('count(id) userNum,sum(goodsScore) goodsScore,sum(serviceScore) serviceScore, sum(timeScore) timeScore')
               ->find();
        $data = [];
        //商品评价数
        Db::name('goods')->where('goodsId',$goodsId)->update(['appraiseNum'=>$rs['userNum']]);
        //商品评价统计
        $data['totalScore'] = (int)$rs['goodsScore']+$rs['serviceScore']+$rs['timeScore'];
        $data['totalUsers'] = (int)$rs['userNum'];
        $data['goodsScore'] = (int)$rs['goodsScore'];
        $data['goodsUsers'] = (int)$rs['userNum'];
        $data['serviceScore'] = (int)$rs['serviceScore'];
        $data['serviceUsers'] = (int)$rs['userNum'];
        $data['timeScore'] = (int)$rs['serviceScore'];
        $data['timeUsers'] = (int)$rs['userNum'];
        Db::name('goods_scores')->where('goodsId',$goodsId)->update($data);
        //商家评价
        $rs = Db::name('goods_appraises')->where(['shopId'=>$shopId,'isShow'=>1,'dataFlag'=>1])
               ->field('count(userId) userNum,sum(goodsScore) goodsScore,sum(serviceScore) serviceScore, sum(timeScore) timeScore')
               ->find();
        $data['totalScore'] = (int)$rs['goodsScore']+$rs['serviceScore']+$rs['timeScore'];
        $data['totalUsers'] = (int)$rs['userNum'];
        $data['goodsScore'] = (int)$rs['goodsScore'];
        $data['goodsUsers'] = (int)$rs['userNum'];
        $data['serviceScore'] = (int)$rs['serviceScore'];
        $data['serviceUsers'] = (int)$rs['userNum'];
        $data['timeScore'] = (int)$rs['serviceScore'];
        $data['timeUsers'] = (int)$rs['userNum'];
        Db::name('shop_scores')->where('shopId',$shopId)->update($data);
	}

    /*
     * 处理评论举报
     */
    public function handle(){
        $id = (int)input('post.id',0);
        $reportStatus = (int)input('reportStatus');
        $reportDesc = input('reportDesc','');
        if($reportStatus == -1 && $reportDesc==''){
            return WSTReturn("请输入举报失败原因");
        }
        Db::startTrans();
        try{
            $goodsAppraises = $this->get($id);
            if($reportStatus==1){
                // 举报成功，评价状态为删除
                $goodsAppraises->dataFlag = -1;
                $goodsAppraises->appraisesStatus = -1;
            }else{
                // 举报失败，评价状态为无效
                $goodsAppraises->appraisesStatus = 0;
            }
            $result = $goodsAppraises->save();
            if(false !== $result){
                $orderId = $goodsAppraises->orderId;
                $order = Db::name('orders')->where(['orderId'=>$orderId])->field('shopId,orderNo')->find();
                if($reportStatus==1){
                    $this->statGoodsAppraises($goodsAppraises->goodsId,$goodsAppraises->shopId);
                    // 发送商城消息
                    $tpl = WSTMsgTemplates('SHOP_REPORT_APPRAISE_SUCCESS');
                    if( $tpl['tplContent']!='' && $tpl['status']=='1'){
                        $find = ['${ORDER_NO}'];
                        $replace = [$order['orderNo']];
                        $msg = array();
                        $msg["shopId"] = $order["shopId"];
                        $msg["tplCode"] = $tpl["tplCode"];
                        $msg["msgType"] = 1;
                        $msg["content"] = str_replace($find,$replace,$tpl['tplContent']);
                        $msg["msgJson"] = ['from'=>1,'dataId'=>$orderId];
                        model("common/MessageQueues")->add($msg);
                    }
                }else{
                    $tpl = WSTMsgTemplates('SHOP_REPORT_APPRAISE_FAIL');
                    if( $tpl['tplContent']!='' && $tpl['status']=='1'){
                        $find = ['${ORDER_NO}','${REASON}'];
                        $replace = [$order['orderNo'],$reportDesc];
                        $msg = array();
                        $msg["shopId"] = $order["shopId"];
                        $msg["tplCode"] = $tpl["tplCode"];
                        $msg["msgType"] = 1;
                        $msg["content"] = str_replace($find,$replace,$tpl['tplContent']);
                        $msg["msgJson"] = ['from'=>1,'dataId'=>$orderId];
                        model("common/MessageQueues")->add($msg);
                    }
                }
                Db::commit();
                return WSTReturn("操作成功", 1);
            }else{
                return WSTReturn($this->getError(),-1);
            }
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn("操作失败");
    }
}

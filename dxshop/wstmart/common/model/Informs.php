<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 收藏类
 */
class Informs extends Base{
	protected $pk = 'informId';
	/**
	 * 举报处理状态
	 */
	public function informStatus(){
		$data = [
			["dataVal"=>"0", "dataName"=>"等待处理"],
			["dataVal"=>"1", "dataName"=>"无效举报"],
			["dataVal"=>"2", "dataName"=>"有效举报"],
			["dataVal"=>"3", "dataName"=>"恶意举报"]
		];
		return WSTReturn("ok", 1, $data);
	}

	/**
	 * 举报须知
	 */
	public function tips(){
		$content = "
		<ul>
          <li> 1.请提供充分的证据以确保举报成功，请珍惜您的会员权利，帮助商城更好地管理网站；</li>
          <li> 2.被举报待处理的商品不能反复进行违规提交，处理下架后的商品不能再次举报，商家如重新上架后仍存在违规现象，可再次对该商品进行违规举报；</li>
          <li> 3.举报仅针对商品或商家本身，如需处理交易中产生的纠纷，请选择投诉；</li>
          <li> 4.举报时依次选择举报类型及举报主题(必填)，填写违规描述(必填，不超过200字)，上传5张以内的举证图片(选填)，详细的举报内容有助于平台对该条举报的准确处理。</li>
        </ul>
		";
		return $content;
	}

	/**
	 * 跳到举报列表
	 */
	public function inform($uId=0){
		$id = input('id');
		$type = input('type');
		$userId = $uId==0?(int)session('WST_USER.userId'):$uId;
		//判断用户是否拥有举报权利
		    $s = Db::name('users')->where("userId=$userId")->find();
		    if($s['isInform']==0)return WSTReturn("你已被禁止举报！", -1);
		//判断记录是否存在
		$isFind = false;
			$c = Db::name('goods')->field('goodsId,goodsImg,goodsName,shopId')->where(['goodsStatus'=>1,'dataFlag'=>1,'goodsId'=>$id])->find();
			$isFind = ($c>0);
		if(!$isFind)return WSTReturn("举报失败，无效的举报对象", -1);
		    $shopId = $c['shopId'];
			$s = Db::name('shops')->where(['shopStatus'=>1,'dataFlag'=>1,'shopId'=>$shopId])->field('shopName,shopId')->find();
			$c = array_merge($c,$s, ['types'=>WSTDatas('INFORMS_TYPE')]);
		return WSTReturn('',1,$c);
	} 
	
	/**
	  * 获取用户举报列表
	  */
	public function queryUserInformByPage($uId=0){
		$userId = $uId==0?(int)session('WST_USER.userId'):$uId;
		$informStatus = (int)Input('informStatus', -1);

		$where['oc.informTargetId'] = $userId;
		if($informStatus>=0){
			$where['oc.informStatus'] = $informStatus;
		}
		$rs = $this->alias('oc')
		           ->join('__SHOPS__ s','oc.shopId=s.shopId','left')
				   ->join('__GOODS__ o','oc.goodId=o.goodsId and o.dataFlag=1','inner')
				   ->order('oc.informId asc')
				   ->field('oc.*, s.shopName,o.goodsId,o.goodsImg,o.goodsName,o.shopId')
				   ->where($where)
				   ->paginate(input('pagesize/d',20))->toArray();

		foreach($rs['data'] as $k=>$v){
			$rs['data'][$k]['informStatus'] = $this->getText($v['informStatus']);
			$rs['data'][$k]['goodsImg'] = WSTImg($v['goodsImg'], 1);
		}
		if($rs !== false){
			return WSTReturn('',1,$rs);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}
	// 判断是否已经举报过
	public function alreadyInform($goodsId,$userId){
		return $this->field('informId')->where("goodId=$goodsId and informTargetId=$userId")->find();
	}
	/**
	 * 保存订单举报信息
	 */
	public function saveInform($uId=0){
		$userId = $uId==0?(int)session('WST_USER.userId'):$uId;
		$data = [];
        $data['goodId'] = (int)input('goodsId');
		//判断是否提交过举报
		$rs = $this->alreadyInform($data['goodId'],$userId);
		if((int)$rs['informId']>0){
			return WSTReturn("该商品已进行过举报,请勿重复提交举报信息",-1);
		}
		$informType = (int)input('informType');
		if($informType==0 || (WSTDatas("INFORMS_TYPE", $informType)=='')){
			return WSTReturn("非法的举报类型");
		}
		$informContent = input('informContent', '');
		if($informContent==""){
			return WSTReturn("举报内容不能为空");
		}
		if(strlen($informContent)<3 || strlen($informContent)>200){
			return WSTReturn("举报内容应为3-200字");
		}
		$shopId = (int)Db::name('goods')->where('goodsId', $data['goodId'])->value('shopId');
		Db::startTrans();
		try{
			$data['informTargetId'] = $userId;
			$data['shopId'] = $shopId;
			$data['informStatus'] = 0;
			$data['informType'] = $informType;
			$data['informTime'] = date('Y-m-d H:i:s');
			$data['informAnnex'] = input('informAnnex');
			$data['informContent'] = $informContent;
			$rs = $this->save($data);
			if($rs !==false){
				Db::commit();
				return WSTReturn('举报成功',1);
			}else{
				return WSTReturn($this->getError(),-1);
			}
		}catch (\Exception $e) {
		    Db::rollback();
	    }
	    return WSTReturn('举报失败',-1);
	}
	
    /**
	 * 获取举报详情
	 */
	public function getUserInformDetail($userType = 0, $uId=0){
		$userId = $uId==0?(int)session('WST_USER.userId'):$uId;
		$id = (int)Input('id');
		if($userId==0){
			$where['informTargetId']=$userId;
		}

		//获取举报信息
		$where['informId'] = $id;
		$rs = Db::name('informs')->alias('oc')
		           ->field('oc.*,o.goodsId ,o.goodsName, o.goodsImg , s.shopId , s.shopName')
		           ->join('__SHOPS__ s','oc.shopId=s.shopId','left')
				   ->join('__GOODS__ o','oc.goodId=o.goodsId and o.dataFlag=1','inner')
				   ->where($where)->find();
		if(!empty($rs)){
			if($rs['informAnnex']!='')$rs['informAnnex'] = explode(',',$rs['informAnnex']);
		}else{
			return [];
		}
		// 获取举报类型
		$rs['types'] = WSTDatas('INFORMS_TYPE', $rs['informType']);
		// 投诉状态
		$rs['status'] = $this->getText($rs['informStatus']);
        return $rs;
	}
	/**
	 * 投诉处理状态对应文字
	 */
	public function getText($v){
		switch($v){
			case 0:return '等待处理';
			case 1:return '无效举报';
			case 2:return '有效举报';
			case 3:return '恶意举报';
		}

	}
}

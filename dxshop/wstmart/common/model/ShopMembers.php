<?php
namespace wstmart\common\model;
use think\Db;
use wstmart\common\model\Shops;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商家会员类
 */
class ShopMembers extends Base{
    /**
     * 分页
     */
    public function pageQuery($sId=0){
		$shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $key = input('key');
        $isOrder = (int)input('isOrder',1);
        $where[] = ['sm.isOrder','=',$isOrder];
        $where[] = ['sm.shopId','=', $shopId];
        if($key!='')$where[] = ['u.loginName|u.userName','like','%'.$key.'%'];
        $page = Db::name('shop_members')->alias('sm')
            ->join('__USERS__ u','u.userId=sm.userId','inner')
            ->join('__SHOP_MEMBER_GROUPS__ sg','sg.id=sm.groupId','left')
            ->where($where)
            ->field('u.loginName,u.userName,sm.*,sg.groupName')
            ->order('sm.createTime', 'desc')
            ->paginate(input('limit/d'))->toArray();
        return $page;
    }

    /**
     * 设置分组
     */
    public function setGroup($sId=0){
		$shopId = $sId==0?(int)session('WST_USER.shopId'):$sId;
        $ids = WSTFormatIn(',',input('ids'),false);
        $groupId = (int)input('groupId');
        $result = $this->where([['shopId','=',$shopId],['userId','in',$ids]])->update(['groupId'=>$groupId]);
        if($result!==false){
            return WSTReturn('操作成功',1);
        }else{
            return WSTReturn('操作失败');
        }
    }
	/**************************************** 商家end ****************************************/


	/**
	 * 关注的店铺列表
	 */
	public function listShopQuery($userId = 0){
		$pagesize = input("param.pagesize/d");
		$userId = ($userId>0)?$userId:(int)session('WST_USER.userId');
		$page = Db::name("shop_members")->alias('f')
				->join('__SHOPS__ s','s.shopId = f.shopId','left')
				->field('f.id favoriteId,f.shopId,s.shopName,s.shopImg')
				->where(['f.userId'=> $userId])
				->order('f.id desc')
				->paginate($pagesize)->toArray();
		foreach ($page['data'] as $key =>$v){
            // 店铺评分
			$score = Db::name('shop_scores')->field('totalScore,totalUsers')->where(['shopId'=>$v['shopId']])->find();
			$page['data'][$key]['totalScore'] = WSTScore($score["totalScore"]/3, $score["totalUsers"]);
			// 店铺分类
			$page['data'][$key]['shopCat'] = Db::name('cat_shops')->alias('cs')
														  ->join('__GOODS_CATS__ gc','cs.catId=gc.catId and gc.dataFlag=1','left')
			               								  ->where([['shopId','in',$v['shopId']]])
			               								  ->value('gc.catName');
			//商品列表
			$goods = Db::name('goods')->where(['dataFlag'=> 1,'isSale'=>1,'goodsStatus'=> 1,'shopId'=> $v["shopId"]])
								->field('goodsId,goodsName,shopPrice,goodsImg')
								->limit(10)->order('saleTime desc')
								->select();
			$page['data'][$key]['goods'] = $goods;
		}
		return $page;
	}
	/**
	 * 取消关注
	 */
	public function del($userId = 0){
		$id = input("param.id");
		$userId = ($userId>0)?$userId:(int)session('WST_USER.userId');
		$ids = explode(',',$id);

		if(empty($ids))return WSTReturn("取消失败", -1);
		$shopIds = $this->where([['id','in',$ids],['userId','=',$userId]])->column('shopId');
		$rs = $this->where([['id','in',$ids],['userId','=',$userId]])->delete();
		$rs2 = Db::name('shop_member_user_consumes')->where([['shopId','in',$shopIds],['userId','=',$userId]])->delete();
		if(false !== $rs && false !== $rs2){
			return WSTReturn("取消成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}


	/**
	 * 新增关注
	 */
	public function add($userId = 0){
	    $id = input("param.id/d");
		$userId = ($userId>0)?$userId:(int)session('WST_USER.userId');
		if($userId==0)return WSTReturn('关注失败，请先登录',-2);
		//判断记录是否存在
		$isFind = false;
		$c = Db::name('shops')->where(['shopStatus'=>1,'dataFlag'=>1,'shopId'=>$id])->count();
		$isFind = ($c>0);
		if(!$isFind)return WSTReturn("关注失败，无效的关注对象", -1);
		$data = [];
		$data['userId'] = $userId;
		$data['shopId'] = $id;
		//判断是否已关注
		$rc = $this->where($data)->count();
		if($rc>0)return WSTReturn("关注成功", 1);
		$data['createTime'] = date('Y-m-d H:i:s');
        $rs = $this->save($data);
        // 计算用户在商家的有效消费金额
        WSTCalcUserValidConsumption($userId,$id);
        // 更新商家会员表的信息
        $where = [];
        $where[] = ['userId','=',$userId];
        $where[] = ['orderStatus','=',2];
        $where[] = ['shopId','=',$id];
        $realTotalMoney = Db::name('orders')->where($where)->sum('realTotalMoney');
        $groupId = WSTGetMemberGroupId($userId,$id);
        $memberData = [];
        $memberData['groupId'] = $groupId;
        if($realTotalMoney>0){
            $totalOrderNum = Db::name('orders')->where($where)->count();
            $lastOrderTime = Db::name('orders')->where($where)->order('createTime desc')->value('createTime');
            $memberData['isOrder'] = 1;
            $memberData['totalOrderNum'] = $totalOrderNum;
            $memberData['totalOrderMoney'] = $realTotalMoney;
            $memberData['lastOrderTime'] = $lastOrderTime;
        }
        Db::name('shop_members')->where(['userId'=>$userId,'shopId'=>$id])->update($memberData);
        if(false !== $rs){
			return WSTReturn("关注成功", 1,['fId'=>$this->id]);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}
	/**
	 * 判断是否已关注
	 */
	public function checkFavorite($id,$uId=0){
		$userId = ($uId==0)?(int)session('WST_USER.userId'):$uId;
		$rs = $this->where(['userId'=>$userId,'shopId'=>$id])->find();
		return empty($rs)?0:$rs['id'];
	}
	/**
	 * 关注数
	 */
	public function followNum($id){
		$rs = $this->where(['shopId'=>$id])->count();
		return $rs;
	}

    /*
     * 检查是否为店铺会员
     */
    public function checkIsShopMember($userId,$shopId){
        $rs = Db::name('shop_members')->where(['userId'=>$userId,'shopId'=>$shopId])->find();
        return (!empty($rs))?true:false;
    }
}

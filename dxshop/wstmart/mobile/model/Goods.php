<?php
namespace wstmart\mobile\model;
use wstmart\common\model\Goods as CGoods;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品类
 */
class Goods extends CGoods{
	/**
	 * 获取列表
	 */
    public function pageQuery($goodsCatIds = []){
        //查询条件
        $keyword = input('keyword');
        $brandId = input('brandId/d');
        $isFreeShipping = input('isFreeShipping/d');
        $words = $where2 = $where3 = $where4 = [];
        $where[] = ['goodsStatus','=',1];
        $where[] =['g.dataFlag','=',1];
        $where[] =['isSale','=',1];
        $recommendWhere = [];
        $recommendOrder = [];
        if($keyword!=''){
            $where2 = $this->getKeyWords($keyword);
            $recommendGoodsId = [];
            hook('userSearchWordsCondition',['recommendGoodsId'=>&$recommendGoodsId,'keyword'=>$keyword]);
            if($recommendGoodsId!=''){
                foreach($recommendGoodsId as $v){
                    $recommendWhere[] = "find_in_set(g.goodsId,'".$v."')";
                    $recommendOrder[] = "find_in_set(g.goodsId,'".$v."') desc";
                }
            }
        }
        if($brandId>0)$where[] = ['g.brandId','=',$brandId];
        // 是否第一次进来
        $isDefault = input('condition','');
        $isDefault = ($isDefault=='' || $isDefault==5)?1:0;
        //排序条件
        $orderBy = input('condition',5);
		if($orderBy==""){
			$orderBy = 5;
		}
		$orderBy = (int)$orderBy;
        $orderBy = ($orderBy>=0 && $orderBy<=5)?$orderBy:0;
        $order = (input('desc/d',0)==1)?1:0;
        $pageBy = ['saleNum','shopPrice','visitNum','saleTime'];
        $pageOrder = ['desc','asc'];
        if($isFreeShipping==1)$where[] = ['isFreeShipping','=',1];
        //属性筛选
        $goodsIds = $this->filterByAttributes();
        if(!empty($goodsIds))$where[] = ['g.goodsId','in',$goodsIds];
        //处理价格
        $minPrice = input("param.minPrice/d");//开始价格
        $maxPrice = input("param.maxPrice/d");//结束价格
        if($minPrice!="")$where3 = "g.shopPrice >= ".(float)$minPrice;
        if($maxPrice!="")$where4 = "g.shopPrice <= ".(float)$maxPrice;
        if(!empty($goodsCatIds))$where[] = ['goodsCatIdPath','like',implode('_',$goodsCatIds).'_%'];
        $list = Db::name('goods')->alias('g')->join("__SHOPS__ s","g.shopId = s.shopId")->join('__GOODS_SCORES__ gs','gs.goodsId=g.goodsId')
                ->where($where)
                ->where(function ($query) use($where2) {
			    	$query->whereOr($where2);
				})
                ->where($where3)
                ->where($where4);
        foreach($recommendWhere as $v){
            $list->whereOrRaw($v);
        }
        $list = $list->field('g.goodsId,goodsName,saleNum,shopPrice,marketPrice,isSpec,goodsImg,appraiseNum,visitNum,s.shopId,shopName,isSelf,isFreeShipping,gallery,gs.totalScore,gs.totalUsers');
        if($isDefault==1){
            foreach($recommendOrder as $v){
                $list->orderRaw($v);
            }
        }
		if($orderBy==5){//综合排序
        	$list = $list->orderRaw(WSTGoodsListDefaultOrder())->paginate(input('pagesize/d',16))->toArray();
        }else{
			$list = $list->order($pageBy[$orderBy]." ".$pageOrder[$order].",goodsId desc")
            ->paginate(input('pagesize/d',16))->toArray();
		}
        return $list;
    }

	/**
	 * 关键字
	 */
	public function getKeyWords($name){
		$words = WSTAnalysis($name);
		if(!empty($words)){
			$str = [];
			if(count($words)==1){
				$str[] = ['g.goodsSerachKeywords','LIKE','%'.$words[0].'%'];
			}else{
				foreach ($words as $v){
					$str[] = ['g.goodsSerachKeywords','LIKE','%'.$v.'%'];
				}
			}
			return $str;
		}
		return "";
	}
	/**
	 * 获取商品资料在前台展示
	 */
	public function getBySale($goodsId){
		$key = input('key');
		// 浏览量
		$this->where('goodsId',$goodsId)->setInc('visitNum',1);
		$rs = Db::name('goods')->where(['goodsId'=>$goodsId,'dataFlag'=>1])->find();
		if(!empty($rs)){
			$rs['read'] = false;
			$rs['goodsDesc'] = htmlspecialchars_decode($rs['goodsDesc']);
			$rs['goodsDesc'] = str_replace('${DOMAIN}',WSTConf('CONF.resourcePath'),$rs['goodsDesc']);
			//判断是否可以公开查看
			$viKey = WSTShopEncrypt($rs['shopId']);
			if(($rs['isSale']==0 || $rs['goodsStatus']==0) && $viKey != $key)return [];
			if($key!='')$rs['read'] = true;
            // 获取会员分组信息
            $rs['shopMemberGroups'] = Db::name('shop_member_groups')->where(['shopId'=>(int)$rs['shopId']])->select();
            $userId = (int)session('WST_USER.userId');
            $reduceMoney = 0;
            if($userId>0 ){
                $reduceMoney = WSTGetMemberGoodsReduceMoney($goodsId,$userId,$rs['shopId']);
            }
            if($reduceMoney>0)$rs['shopPrice'] = WSTBCMoney($rs['shopPrice'],-$reduceMoney);
			//获取店铺信息
			$rs['shop'] = model('shops')->getShopInfo((int)$rs['shopId']);
			if(empty($rs['shop']))return [];
			$goodsCats = Db::name('cat_shops')->alias('cs')->join('__GOODS_CATS__ gc','cs.catId=gc.catId and gc.dataFlag=1','left')->join('__SHOPS__ s','s.shopId = cs.shopId','left')
			->where('cs.shopId',$rs['shopId'])->field('cs.shopId,s.shopTel,gc.catId,gc.catName')->select();
			$rs['shop']['catId'] = $goodsCats[0]['catId'];
			$rs['shop']['shopTel'] = $goodsCats[0]['shopTel'];

			$cat = [];
			foreach ($goodsCats as $v){
				$cat[] = $v['catName'];
			}
			$rs['shop']['cat'] = implode('，',$cat);
			if(empty($rs['shop']))return [];
			$gallery = [];
			$gallery[] = $rs['goodsImg'];
			if($rs['gallery']!=''){
				$tmp = explode(',',$rs['gallery']);
				$gallery = array_merge($gallery,$tmp);
			}
			$rs['gallery'] = $gallery;
			//获取规格值
			$specs = Db::name('spec_cats')->alias('gc')->join('__SPEC_ITEMS__ sit','gc.catId=sit.catId','inner')
			->where(['sit.goodsId'=>$goodsId,'gc.isShow'=>1,'sit.dataFlag'=>1])
			->field('gc.isAllowImg,gc.catName,sit.catId,sit.itemId,sit.itemName,sit.itemImg')
			->order('gc.isAllowImg desc,gc.catSort asc,gc.catId asc,sit.itemId')->select();
			$rs['spec']=[];
			foreach ($specs as $key =>$v){
				$rs['spec'][$v['catId']]['name'] = $v['catName'];
				$rs['spec'][$v['catId']]['list'][] = $v;
			}
			//获取销售规格
			$sales = Db::name('goods_specs')->where('goodsId',$goodsId)->field('id,isDefault,productNo,specIds,marketPrice,specPrice,specStock')->select();
			if(!empty($sales)){
                if($reduceMoney>0){
                    foreach ($sales as $key =>$v) {
                        $sales[$key]['specPrice'] =  WSTBCMoney($v['specPrice'],-$reduceMoney);
                    }
                }
				foreach ($sales as $key =>$v){
					$str = explode(':',$v['specIds']);
					sort($str);
					unset($v['specIds']);
					$rs['saleSpec'][implode(':',$str)] = $v;
				}
			}
			//获取商品属性
			$rs['attrs'] = Db::name('attributes')->alias('a')->join('goods_attributes ga','a.attrId=ga.attrId','inner')
			->where(['a.isShow'=>1,'dataFlag'=>1,'goodsId'=>$goodsId])->field('a.attrName,ga.attrVal')
			->order('attrSort asc')->select();
			//获取商品评分
			$rs['scores'] = Db::name('goods_scores')->where('goodsId',$goodsId)->field('totalScore,totalUsers')->find();
			$rs['scores']['totalScores'] = ($rs['scores']['totalScore']==0)?5:WSTScore($rs['scores']['totalScore'],$rs['scores']['totalUsers'],5,0,3);
			WSTUnset($rs, 'totalUsers');
			//关注
			$f = model('common/Favorites');
            $sm = model('common/ShopMembers');
			$rs['favShop'] = $sm->checkFavorite($rs['shopId']);
			$rs['favGood'] = $f->checkFavorite($goodsId);
		}
		return $rs;
	}


	public function historyQuery(){
		$ids = cookie("mo_history_goods");
		if(empty($ids))return [];
	    $where = [];
	    $where[] = ['isSale','=',1];
	    $where[] = ['goodsStatus','=',1];
	    $where[] = ['dataFlag','=',1];
	    $where[] = ['goodsId','in',$ids];
	    $orderBy = "field(`goodsId`,".implode(',',$ids).")";
        return Db::name('goods')
                   ->where($where)->field('goodsId,goodsName,goodsImg,saleNum,shopPrice')
                   ->orderRaw($orderBy)
                   ->paginate((int)input('pagesize'))->toArray();
	}
    /**
     * 获取符合筛选条件的商品ID
     */
    public function filterByAttributes(){
    	$vs = input('vs');
    	if($vs=='')return [];
    	$vs = explode(',',$vs);
    	$goodsIds = [];
    	$prefix = config('database.prefix');
		//循环遍历每个属性相关的商品ID
	    foreach ($vs as $v){
	    	$goodsIds2 = [];
	    	$attrVal = input('v_'.(int)$v);
	    	if($attrVal=='')continue;
		    	$sql = "select goodsId from ".$prefix."goods_attributes 
		    	where attrId=".(int)$v." and find_in_set('".$attrVal."',attrVal) ";
				$rs = Db::query($sql);
				if(!empty($rs)){
					foreach ($rs as $vg){
						$goodsIds2[] = $vg['goodsId'];
					}
				}
			//如果有一个属性是没有商品的话就不需要查了
			if(empty($goodsIds2))return [-1];
			//第一次比较就先过滤，第二次以后的就找集合
			$goodsIds2[] = -1;
			if(empty($goodsIds)){
				$goodsIds = $goodsIds2;
			}else{
				$goodsIds = array_intersect($goodsIds,$goodsIds2);
			}
		}
		return $goodsIds;
    }
}

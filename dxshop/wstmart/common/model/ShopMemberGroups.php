<?php
namespace wstmart\common\model;
use think\Db;
use wstmart\common\validate\ShopMemberGroups as Validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商家会员业务类
 */
class ShopMemberGroups extends Base{
	/**
	 * 获取分页
	 */
	public function pageQuery($sId=0){
		$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$groupName = input('groupName');
		$where = [];
		if($groupName!='')$where[] = ['groupName','like','%'.$groupName.'%'];
		$where[] = ['shopId','=',$shopId];
        return Db::name('shop_member_groups')->where($where)->order('groupOrder asc,id desc')->paginate(input('limit/d'))->toArray();
    }
    /**
	 * 获取列表
	 */
	public function listQuery($sId=0){
	   $shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
       return Db::name('shop_member_groups')->where('shopId',$shopId)->order('groupOrder asc,id desc')->select();
    }
	/**
	 * 新增
	 */
	public function add($sId=0){
		$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$data = input('post.');
		if($data['groupName']=='')return WSTReturn('请输入分组名称');
		$data['groupOrder'] = (int)$data['groupOrder'];
		$data['shopId'] = $shopId;
        $validate = new Validate();
        if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(true)->save($data);
		if(false !== $result){
			return WSTReturn("新增成功", 1);
		}
        return WSTReturn('新增失败',-1);
	}

	/**
	 * 编辑
	 */
	public function edit($sId=0){
		$id = input('post.id/d');
		$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$data = input('post.');
		if($data['groupName']=='')return WSTReturn('请输入分组名称');
		$data['groupOrder'] = (int)$data['groupOrder'];
        $validate = new Validate();
        if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(['groupName','groupOrder','minMoney','maxMoney'])->save($data,['id'=>$id,'shopId'=>$shopId]);
		if(false !== $result){
			return WSTReturn("修改成功", 1);
		}
        return WSTReturn('修改失败',-1);
	}

	/**
	 * 获取数据
	 */
	public function getById($id, $sId=0){
		$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		return $this->where(['id'=>$id,'shopId'=>$shopId])->find();
	}

	/**
	 * 删除
	 */
	public function del($sId=0){
		$shopId = ($sId==0)?(int)session('WST_USER.shopId'):$sId;
		$id = input('post.id/d');
		Db::startTrans();
        try{
			$result = $this->where(['id'=>$id,'shopId'=>$shopId])->delete();
			if(false !== $result){
				//清除用户分组
				Db::name('shop_members')->where(['groupId'=>$id,'shopId'=>$shopId])->update(['groupId'=>0]);
				Db::commit();
				return WSTReturn("删除成功", 1);
			}
        }catch (\Exception $e) {
            Db::rollback();
        }
        return WSTReturn('删除失败',-1);
	}

}

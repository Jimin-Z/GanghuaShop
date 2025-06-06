<?php
namespace wstmart\common\model;
use wstmart\common\validate\UserAddress as Validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 用户地址
 */
class UserAddress extends Base{

    protected $pk = 'addressId';
     /**
      * 获取列表
      */
      public function listQuery($userId){
         $where = ['userId'=>(int)$userId,'dataFlag'=>1];
         $rs = $this->order('isDefault asc, addressId desc')->where($where)->select();
         $areaIds = [];
         $areaMaps = [];
         foreach ($rs as $key => $v){
         	 $tmp = explode('_',$v['areaIdPath']);
         	 foreach ($tmp as $vv){
         		if($vv=='')continue;
         	    if(!in_array($vv,$areaIds))$areaIds[] = $vv;
         	 }
         	 $rs[$key]['areaId2'] = $tmp[1];
         }
         if(!empty($areaIds)){
	         $areas = Db::name('areas')->where([['areaId','in',$areaIds],['isShow','=',1],['dataFlag','=',1]])->field('areaId,areaName')->select();
	         foreach ($areas as $v){
	         	 $areaMaps[$v['areaId']] = $v['areaName'];
	         }
	         foreach ($rs as $key => $v){
	         	$tmp = explode('_',$v['areaIdPath']);
	         	$areaNames = [];
                $isFind = true;
		        foreach ($tmp as $vv){
	         		if($vv=='')continue;
                    if(!isset($areaMaps[$vv])){
                        $isFind = false;
                        continue;
                    }
	         	    $areaNames[] = $areaMaps[$vv];
	            }
                if($isFind){
    	         	$rs[$key]['areaName'] = implode('',$areaNames);
    	         	$rs[$key]['areaName1'] = $areaMaps[$v['areaId2']];
                }
	         }
             $tmp = [];
             for($i=count($rs)-1;$i>=0;$i--){
                if(isset($rs[$i]['areaName']))$tmp[] = $rs[$i];
             }
             $rs = $tmp;
         }
         return $rs;
      }
    /**
    *  获取用户信息
    */
    public function getById($id, $uId=0){
        $userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
    	$rs = $this->get(['addressId'=>$id,'userId'=>$userId,'dataFlag'=>1]);
        if(empty($rs))return [];
        $areaIds = [];
        $areaMaps = [];
        $tmp = explode('_',$rs['areaIdPath']);
        $rs['areaId2'] = $tmp[1];
        foreach ($tmp as $vv){
         	if($vv=='')continue;
         	if(!in_array($vv,$areaIds))$areaIds[] = $vv;
        }
        if(!empty($areaIds)){
	         $areas = Db::name('areas')->where([['areaId','in',$areaIds],['isShow','=',1],['dataFlag','=',1]])->field('areaId,areaName')->select();
	         foreach ($areas as $v){
	         	 $areaMaps[$v['areaId']] = $v['areaName'];
	         }
	         $tmp = explode('_',$rs['areaIdPath']);
	         $areaNames = [];
		     foreach ($tmp as $vv){
	         	 if($vv=='')continue;
                 if(!isset($areaMaps[$vv]))return [];
	         	 $areaNames[] = $areaMaps[$vv];
	         	 $rs['areaName'] = implode('',$areaNames);
	         }
         }
        return $rs;
    }
    /**
     * 新增
     */
    public function add($uId=0){
        $data = input('post.');
        unset($data['addressId']);
        $data['userId'] = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
        //先判断一下用户已经创建了多少个地址，限制不能超过20个
        $count = $this->where('userId='.$data['userId'].' and dataFlag=1')->count();
        if($count>=20)return WSTReturn('请勿新增超过20个收货地址');
        $data['createTime'] = date('Y-m-d H:i:s');
        if($data['userId']==0)return WSTReturn('新增失败，请先登录');
        // 检测是否存在下级地区
        $hasChild = model('Areas')->hasChild(input('areaId'));
        if($hasChild)return WSTReturn('请选择完整的地区信息',-1);

        $areaIds = model('Areas')->getParentIs((int)input('areaId'));
        if(!empty($areaIds))$data['areaIdPath'] = implode('_',$areaIds)."_";
        $validate = new Validate;
        if (!$validate->scene('add')->check($data)) {
        	return WSTReturn($validate->getError());
        }else{
        	$result = $this->allowField(true)->save($data);
        }
        if(false !== $result){
            //修改默认地址
            if((int)input('post.isDefault')==1){
            	$this->where("addressId != $this->addressId and userId=".$data['userId'])->setField('isDefault',0);
            }
            return WSTReturn("新增成功", 1,['addressId'=>$this->addressId]);
        }else{
            return WSTReturn($this->getError(),-1);
        }
    }
    /**
     * 编辑资料
     */
    public function edit($uId=0){
        $userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
        $id = (int)input('post.addressId');
        $data = input('post.');
        unset($data['addressId']);
        // 检测是否存在下级地区
        $hasChild = model('Areas')->hasChild(input('areaId'));
        if($hasChild)return WSTReturn('请选择完整的地区信息',-1);

        $areaIds = model('Areas')->getParentIs((int)input('areaId'));
        if(!empty($areaIds))$data['areaIdPath'] = implode('_',$areaIds)."_";
        $validate = new Validate;
        if (!$validate->scene('edit')->check($data)) {
        	return WSTReturn($validate->getError());
        }else{
        	$result = $this->allowField(true)->save($data,['addressId'=>$id,'userId'=>$userId]);
        }
        //修改默认地址
        if((int)input('post.isDefault')==1)
          $this->where("addressId != $id and userId=".$userId)->setField('isDefault',0);
        if(false !== $result){
            return WSTReturn("编辑成功", 1);
        }else{
            return WSTReturn($this->getError(),-1);
        }
    }
    /**
     * 删除
     */
    public function del($uId=0){
        $userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
        $id = input('post.id/d');
        $data = [];
        $data['dataFlag'] = -1;
        $result = $this->update($data,['addressId'=>$id,'userId'=>$userId]);
        if(false !== $result){
            return WSTReturn("删除成功", 1);
        }else{
            return WSTReturn($this->getError(),-1);
        }
    }

    /**
    * 设置为默认地址
    */
    public function setDefault($uId=0){
        $userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
        $id = (int)input('post.id');
        $this->where([['addressId','<>',$id],['userId','=',$userId]])->setField('isDefault',0);
        $rs = $this->where("addressId = $id and userId=".$userId)->setField('isDefault',1);
        if(false !== $rs){
            return WSTReturn("设置成功", 1);
        }else{
            return WSTReturn($this->getError(),-1);
        }
    }
    /**
     * 获取默认地址
     */
    public function getDefaultAddress($uId=0){
    	$userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
    	$where = ['userId'=>$userId,'dataFlag'=>1];
        $rs = $this->where($where)->order('isDefault desc,addressId desc')->find();
        if(empty($rs))return [];
        $areaIds = [];
        $areaMaps = [];
        $tmp = explode('_',$rs['areaIdPath']);
        $rs['areaId2'] = $tmp[1];
        foreach ($tmp as $vv){
         	if($vv=='')continue;
         	if(!in_array($vv,$areaIds))$areaIds[] = $vv;
        }
        if(!empty($areaIds)){
	         $areas = Db::name('areas')->where([['areaId','in',$areaIds],['isShow','=',1],['dataFlag','=',1]])->field('areaId,areaName')->select();
	         foreach ($areas as $v){
	         	 $areaMaps[$v['areaId']] = $v['areaName'];
	         }
	         $tmp = explode('_',$rs['areaIdPath']);
	         $areaNames = [];
		     foreach ($tmp as $vv){
	         	 if($vv=='')continue;
                 if(!isset($areaMaps[$vv]))return [];
	         	 $areaNames[] = $areaMaps[$vv];
	         	 $rs['areaName'] = implode('',$areaNames);
	         }
         }
         return $rs;
    }

    /*
     * 获取用户微信地址
     */
    public function addWechatAddress($uId=0){
        $userId = ((int)$uId==0)?(int)session('WST_USER.userId'):$uId;
        $data = input('post.');
        // 将微信地址的地区转成对应的areaId
        $provinceAreaId = model('common/areas')->getAreaIdByName($data['province']);
        $cityAreaId = model('common/areas')->getAreaIdByName($data['city']);
        $countyAreaId = model('common/areas')->getAreaIdByName($data['county']);
        if($provinceAreaId==''||$cityAreaId==''||$countyAreaId=='')return WSTReturn("新增失败，没有对应的地区信息");
        $areaIdPath = $provinceAreaId.'_'.$cityAreaId.'_'.$countyAreaId;
        // 开发者工具提交的测试数据，电话是020-81167888，为了防止触发validate的规则，这里做截取字符串处理。微信上添加的用户地址，电话是11位的手机号。
        if(strpos($data['userPhone'],'-')!==false)$data['userPhone'] = substr(strrchr($data['userPhone'],"-"),1);
        $where = [
            'userId'=>$userId,
            'dataFlag'=>1,
            'userName'=>$data['userName'],
            'userPhone'=>$data['userPhone'],
            'userAddress'=>$data['userAddress'],
            'areaIdPath'=>$areaIdPath
        ];
        $rs = $this->where($where)->find();
        if($rs)return WSTReturn("该收货地址已存在");
        $data['userId'] = $userId;
        $data['createTime'] = date('Y-m-d H:i:s');
        $data['isDefault'] = 0;
        $data['areaIdPath'] = $areaIdPath;
        $data['areaId'] = $countyAreaId;
        $validate = new Validate;
        if (!$validate->scene('add')->check($data)) {
            return WSTReturn($validate->getError());
        }else{
            $result = $this->allowField(true)->save($data);
        }
        if(false !== $result){
            return WSTReturn("新增成功", 1,['addressId'=>$this->addressId]);
        }else{
            return WSTReturn($this->getError(),-1);
        }
    }
}

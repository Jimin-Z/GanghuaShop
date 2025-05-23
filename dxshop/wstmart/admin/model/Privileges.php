<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\Privileges as validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 权限业务处理
 */
class Privileges extends Base{
    protected $pk = 'privilegeId';
	/**
	 * 加载指定菜单的权限
	 */
	public function listQuery($parentId){
		$rs = $this->where([['menuId','=',$parentId],['dataFlag','=',1]])->order('privilegeId', 'asc')->paginate(input('limit/d'));
		return $rs;
	}

	/**
	 * 获取指定权限
	 */
    public function getById($id){
		return $this->get(['privilegeId'=>$id,'dataFlag'=>1]);
	}

    /**
	 * 新增
	 */
	public function add(){
		$data = input('post.');
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(true)->save($data);
        if(false !== $result){
        	WSTClearAllCache();
        	return WSTReturn("新增成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
    /**
	 * 编辑
	 */
	public function edit(){
		$id = input('post.id/d');
		$data = input('post.');
		$validate = new validate();
		if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
	    $result = $this->allowField(true)->save($data,['privilegeId'=>$id]);
        if(false !== $result){
        	WSTClearAllCache();
        	return WSTReturn("编辑成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 删除
	 */
	public function del(){
	    $id = input('post.id/d');
	    $result = $this->where('privilegeId','=',$id)->delete();
        if(false !== $result){
        	WSTClearAllCache();
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}

	/**
	 * 检测权限代码是否存在
	 */
	public function checkPrivilegeCode(){
		$privilegeId = input('privilegeId/d',0);
		$code = input('code');
		if($code=='')return WSTReturn("", 1);
		$where = [];
		$where[] = ["privilegeCode",'=',$code];
		$where[] = ["dataFlag",'=',1];
		if($privilegeId>0){
			$where[] = ["privilegeId","<>",$privilegeId];
		}
		$rs = $this->where($where)->Count();
		if($rs==0)return WSTReturn("", 1);
		return WSTReturn("该权限代码已存在!", -1);
	}

	/**
	 * 加载权限并且标用户的权限
	 */
	public function listQueryByRole(){
		$mrs = Db::name('menus')->alias('m')->join('privileges p','m.menuId= p.menuId and isMenuPrivilege=1 and p.dataFlag=1','left')
			->where([
				['m.dataFlag','=',1],
			])
			->field('m.menuId id,m.menuName name,p.privilegeCode,1 as isParent,parentId pId,1 as menus,true as open')
			->order('parentId asc,menuSort asc')
			->select();

		 $prs = $this->alias('p')
		 ->join('menus sm','p.menuId=sm.menuId','inner')
		 ->where([
			 ['p.dataFlag','=',1],
			 ['sm.dataFlag','=',1],
			])
		 ->field('p.privilegeId id,p.privilegeName name,p.privilegeCode,0 as isParent,p.menuId pId, 0 as menus')->select()->toArray();
         $mrs = array_merge($prs,$mrs);
        return $mrs;
	}
	/**
	 * 加载全部权限
	 */
	public function getAllPrivileges(){
		return $this->where('dataFlag','=',1)->field('menuId,privilegeName,privilegeCode,privilegeUrl,otherPrivilegeUrl')->select();
	}
}

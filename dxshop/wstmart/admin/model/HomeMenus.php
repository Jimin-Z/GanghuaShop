<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\HomeMenus as validate;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 前台菜单业务处理
 */
class HomeMenus extends Base{	
	protected $insert = ['dataFlag'=>1]; 
	
	/**
	 * 获取菜单
	 */
	public function getById($id){
		return $this->get(['dataFlag'=>1,'menuId'=>$id]);
	}
	
	/**
	 * 新增菜单
	 */
	public function add(){
		$data = input('post.');
		$data['createTime'] = date('Y-m-d H:i:s');
		$data["dataFlag"] = 1;
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(true)->save($data);
        if(false !== $result){
        	cache('WST_HOME_MENUS',null);
        	return WSTReturn("新增成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
    /**
	 * 编辑菜单
	 */
	public function edit(){
		$data = input('post.');
		$menuId = input('post.menuId/d',0);
		$validate = new validate();
		if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
	    $result = $this->allowField(['menuName','menuSort','menuType','isShow','menuUrl','menuOtherUrl'])->save($data,['menuId'=>$menuId]);
        if(false !== $result){
        	cache('WST_HOME_MENUS',null);
        	$parentId = input('post.parentId');
        	if($parentId==0){
        		// 获取其子集id
        		$ids = $this->getChildId($menuId);
        		$menuType = input('post.menuType/d');
        		$result = $this->where([['menuId','in',$ids],['dataFlag','=',1]])->setField("menuType", $menuType);
        	}
        	return WSTReturn("编辑成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 删除菜单
	 */
	public function del(){
	    $menuId = input('post.menuId/d',0);
		$data = [];
		$data['dataFlag'] = -1;
	    $result = $this->update($data,['menuId'=>$menuId]);
	    $this->update($data,['parentId'=>$menuId]);
        if(false !== $result){
        	cache('WST_HOME_MENUS',null);
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	
	/**
	 * 分页
	 */
	public function pageQuery(){
		$where = [];
		$menuType = (int)input('menuType',-1);
		if($menuType!=-1)$where['a.menuType'] = $menuType;
		$where['a.parentId'] = (int)input('menuId',0);
		$where['a.dataFlag'] = 1;
		$rs = $this->alias('a')->join('__HOME_MENUS__ b','a.parentId = b.menuId','left')
			->field("a.menuId,a.menuType, a.parentId, a.menuName, a.menuUrl, a.menuOtherUrl, a.isShow, a.menuSort, b.menuName parentName")
			->where($where)
			->order('a.menuSort asc')
			->paginate(1000);
		return $rs;
	}
	
	/**
	 * 显示隐藏
	 */
	public function setToggle(){
		$menuId = input('post.menuId',0);
		// 获取其子集id
		$ids = $this->getChildId($menuId);
		$isShow = input('post.isShow/d');
		$result = $this->where([['menuId','in',$ids],['dataFlag','=',1]])->setField("isShow", $isShow);
		if(false !== $result){
			cache('WST_HOME_MENUS',null);
			return WSTReturn("设置成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}
	/**
	* 获取子集id
	*/
	private function getChildId($mId){
		$data = $this->field('menuId,parentId')->where('dataFlag=1')->select();
		$ids = $this->_getChildId($data,$mId,true);
		$ids[]=(int)$mId;
		return $ids;
	}
	private function _getChildId($data,$pId,$isClear=false){
		static $ids = [];
		if($isClear)$ids=[];
		foreach($data as $k=>$v){
			if($v['parentId']==$pId){
				$ids[] = $v['menuId'];
				$this->_getChildId($data,$v['menuId']);
			}
		}
		return $ids;
	}

	
	/**
	 * 获取菜单列表
	 */
	public function getMenus($parentId = -1){
		$rs = $this->where(['parentId'=>$parentId,'dataFlag'=>1])->field('menuId, parentId, menuName, menuUrl,menuOtherUrl')->order('menuSort', 'asc')->select();
		if(count($rs)>0){
			foreach ($rs as $key =>$v){
				$children = self::getMenus($rs[$key]['menuId']);
				if(!empty($children)){
					$rs[$key]["children"] = $children;
				}
			}
		};
		return $rs;
	}
	
	/**
    * 修改排序
    */ 
    public function changeSort(){
    	$id = (int)input('id');
    	$menuSort = (int)input('menuSort');
        $rs = $this->where('menuId',$id)->setField('menuSort',$menuSort);
        if($rs!==false){
        	cache('WST_HOME_MENUS',null);
        	return WSTReturn('修改成功',1);
        }
        return WSTReturn('修改失败',-1);
    }
}

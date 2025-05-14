<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\Areas as validate;
use \think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 地区业务处理
 */
class Areas extends Base{
	/**
	 * 设置热门城市
	 */
	public function setHotCity(){
		$ids = input("ids");
		Db::name("sys_configs")->where(['fieldCode'=>'hotCityIds'])->update(["fieldValue"=>$ids]);
		return WSTReturn("操作成功", 1);
	}
	/**
	 * 获取地级市
	 */
	public function getCity(){
		// 筛选出非一级地区数据
		$areaIds = $this->where([
			["parentId","<>",0],
			["isShow","=",1]
		])->column("areaId");
		// 筛选出一级地区数据
		$citys = $this->whereIn("areaId", $areaIds)->whereNotIn("parentId", $areaIds)->select();
		return $citys;
	}

	/**
	 * 分页
	 */
	public function pageQuery(){
		$parentId = input('get.parentId/d',0);
		return $this->where(['dataFlag'=>1,'parentId'=>$parentId])->order('areaId desc')->paginate(input('limit/d'));
	}

	/**
	 * 获取指定对象
	 */
	public function getById($id){
		return $this->get(['dataFlag'=>1,'areaId'=>$id]);
	}

	/**
	 * 获取地区
	 */
	public function getFieldsById($id,$fileds){
		return $this->where(['dataFlag'=>1,'areaId'=>$id])->field($fileds)->find();
	}

	/**
	 * 显示是否显示/隐藏
	 */
	public function editiIsShow(){
		//获取子集
		$ids = array();
        $id = input('post.id/d',0);
		$ids[] = $id;
        Db::startTrans();
        try{
            $isShow = input('post.isShow/d',0)?0:1;
            if($isShow==0){
                $where = [];
                $where[] = ['dataFlag','=',1];
                $where2 = "((areaIdPath like '".$id."\_%') or (areaIdPath like '%\_".$id."\_%')) ";
                Db::name("user_address")->where($where)->where($where2)->update(['dataFlag'=>-1]);
            }
            $ids = $this->getChild($ids,$ids);
            $result = $this->where("areaId in(".implode(',',$ids).")")->update(['isShow' => $isShow]);
            if(false !== $result){
                Db::commit();
                return WSTReturn("操作成功", 1);
            }
        }catch(\Exception $e){
            Db::rollback();
        }
        return WSTReturn("操作失败");
	}

	/**
	 * 迭代获取下级
	 */
	public function getChild($ids = array(),$pids = array()){
		$result = $this->where("dataFlag=1 and parentId in(".implode(',',$pids).")")->select();
		if(count($result)>0){
			$cids = array();
			foreach ($result as $key =>$v){
				$cids[] = $v['areaId'];
			}
			$ids = array_merge($ids,$cids);
			return $this->getChild($ids,$cids);
		}else{
			return $ids;
		}
	}

    /**
	 * 根据子分类获取其父级分类
	 */
	public function getParentIs($id,$data = array()){
		$data[] = $id;
		$parentId = $this->where('areaId',$id)->value('parentId');
		if($parentId==0){
			krsort($data);
			return $data;
		}else{
			return $this->getParentIs($parentId, $data);
		}
	}

	/**
	 * 获取自己以及父级的地区名称
	 */
	public function getParentNames($id,$data = array()){
		$areas = $this->where('areaId',$id)->field('parentId,areaName')->find();
		$data[] = $areas['areaName'];
		if((int)$areas['parentId']==0){
			krsort($data);
			return $data;
		}else{
			return $this->getParentNames((int)$areas['parentId'], $data);
		}
	}


	/**
	 * 排序字母
	 */
	public function letterObtain(){
		$areaName =  input('code');
		if($areaName =='')return WSTReturn("", 1);
		$areaName = WSTGetFirstCharter($areaName);
		if($areaName){
			return WSTReturn($areaName, 1);
		}else{
			return WSTReturn("", 1);
		}
	}

	/**
	 * 新增
	 */
	public function add(){
		$areaType = 0;
		$parentId = input('post.parentId/d',0);
		if($parentId>0){
			$prs = $this->getFieldsById($parentId,['areaType']);
			$areaType = $prs['areaType']+1;
		}
		$data = input('post.');
		WSTUnset($data,'areaId,dataFlag');
		$data['areaType'] = $areaType;
		$data['createTime'] = date('Y-m-d H:i:s');
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(true)->save($data);
		if(false !== $result){
			return WSTReturn("新增成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}

	/**
	 * 编辑
	 */
	public function edit(){
		$areaId = input('post.areaId/d');
		$data = input('post.');
		$validate = new validate();
		if(!$validate->scene('edit')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(['areaName','isShow','areaSort','areaKey'])->save($data,['areaId'=>$areaId]);
		$ids = array();
		$ids[] = $areaId;
		$ids = $this->getChild($ids,$ids);
		$this->where("areaId in(".implode(',',$ids).")")->update(['isShow' => input('post.')['isShow']]);
		if(false !== $result){
			return WSTReturn("修改成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}

	/**
	 * 删除
	 */
	public function del(){
		$ids = array();
        $id = input('post.id/d');
		$ids[] = $id;
        Db::startTrans();
        try{
            $where = [];
            $where[] = ['dataFlag','=',1];
            $where2 = "((areaIdPath like '".$id."\_%') or (areaIdPath like '%\_".$id."\_%')) ";
            Db::name("user_address")->where($where)->where($where2)->update(['dataFlag'=>-1]);

            $ids = $this->getChild($ids,$ids);
            $data = [];
            $data['dataFlag'] = -1;
            $result = $this->where("areaId in(".implode(',',$ids).")")->update($data);
            if(false !== $result){
                Db::commit();
                return WSTReturn("删除成功", 1);
            }
        }catch(\Exception $e){
            Db::rollback();
        }
        return WSTReturn("删除失败");
	}

	/**
	 *  获取地区列表
	 */
	public function listQuery($parentId){
		return $this->where(['dataFlag'=>1,'parentId'=>$parentId,'isShow'=>1])->field('areaId,areaName,parentId')->order('areaSort desc')->select();
	}
}

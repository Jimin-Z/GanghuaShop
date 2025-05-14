<?php
namespace wstmart\admin\model;
use wstmart\admin\validate\Express as validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 快递业务处理
 */
class Express extends Base{
	/**
	 * 分页
	 */
	public function pageQuery(){
		return $this->where('dataFlag',1)->field('expressId,expressName,expressCode,isShow')->order('expressId desc')->paginate(input('limit/d'));
	}
	public function getById($id){
		return $this->get(['expressId'=>$id,'dataFlag'=>1]);
	}
	/**
	 * 新增
	 */
	public function add(){
		$data = ['expressName'=>input('post.expressName'),'expressCode'=>input('post.expressCode'),'isShow'=>(int)input('post.isShow')];
		$validate = new validate();
		if(!$validate->scene('add')->check($data))return WSTReturn($validate->getError());
		$result = $this->allowField(['expressName','expressCode'])->save($data);
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
		$expressId = input('post.expressId/d',0);
		$validate = new validate();
		if(!$validate->scene('edit')->check(['expressName'=>input('post.expressName')]))return WSTReturn($validate->getError());
	    $result = $this->allowField(['expressName','expressCode','isShow'])->save(['expressName'=>input('post.expressName'),'expressCode'=>input('post.expressCode'),'isShow'=>(int)input('post.isShow')],['expressId'=>$expressId]);

        if(false !== $result){
        	return WSTReturn("编辑成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}
	/**
	 * 删除
	 */
    public function del(){
	    $id = (int)input('post.id/d',0);
		$data = [];
		$data['dataFlag'] = -1;
	    $result = $this->update($data,['expressId'=>$id]);
        if(false !== $result){
        	return WSTReturn("删除成功", 1);
        }else{
        	return WSTReturn($this->getError(),-1);
        }
	}

	/**
	 * 显示是否显示/隐藏
	 */
	public function editiIsShow(){
		//获取子集
		$id = (int)input('post.id/d',0);
		$isShow = (int)input('post.isShow/d',0)?0:1;
		$result = $this->where("expressId = ".$id)->update(['isShow' => $isShow]);
		if(false !== $result){
			return WSTReturn("操作成功", 1);
		}else{
			return WSTReturn($this->getError(),-1);
		}
	}
	
}

<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\Users as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 会员控制器
 */
class Users extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        $rs=WSTLayGrid($m->pageQuery());
        put_msg('line 22',$rs);
        return  $rs;
    }
    /**
     * 跳去编辑页面
     */
    public function toEdit(){
        $m = new M();
        if((int)Input("id")>0){
            $data = $this->get();
        }else{
            $data = $m->getEModel('users');
        }
        $assign = ['data'=>$data];
        $this->assign("p",(int)input("p"));
        return $this->fetch("edit",$assign);
    }
    /*
    * 获取数据
    */
    public function get(){
        $m = new M();
        return $m->getById((int)Input("id"));
    }
    /**
     * 新增
     */
    public function add(){
        $m = new M();
        return $m->add();
    }
    /**
    * 修改
    */
    public function edit(){
        $m = new M();
        return $m->edit();
    }
    /**
     * 删除
     */
    public function del(){
        $m = new M();
        return $m->del();
    }
    public function getUserByKey(){
        $m = new M();
        return $m->getUserByKey();
    }

      /**********************************************************************************************
      *                                             账号管理                                                                                                                              *
      **********************************************************************************************/
    /**
    * 账号管理页面
    */
    public function accountIndex(){
        //$this->assign("p",(int)input("p"));
       // return $this->fetch("account_list");
           $this->assign("p",(int)input("p"));
        return $this->fetch("list");
    }


    public function editAccount(){
        $m = new M();
        return $m->edit();
    }

    /**
    * 重置支付密码
    */
    public function resetPayPwd(){
        $m = new M();
        return $m->resetPayPwd();
    }

    /**
     * 判断账号是否存在
     */
    public function checkLoginKey(){
        $rs = WSTCheckLoginKey(Input('post.loginName'),Input('post.userId/d',0));
        if($rs['status']==1){
            return ['ok'=>$rs['msg']];
        }else{
            return ['error'=>$rs['msg']];
        }
    }
    /**
    * 是否启用
    */
    public function changeUserStatus($id, $status){
        $m = new M();
        return $m->changeUserStatus($id, $status);
    }
    /**
    * 获取所有用户id
    */
    public function getAllUserId()
    {
        $m = new M();
        return $m->getAllUserId();
    }

    /**
     * 导出会员信息
     */
    public function toExport(){
        $m = new M();
        $rs = $m->toExport();
        $this->assign('rs',$rs);
    }


    public function cancelIndex(){
        $this->assign("p",(int)input("p"));
        return $this->fetch("cancel_list");
    }
    /**
     * 获取分页
     */
    public function cancelPageQuery(){
        $m = new M();
        return WSTLayGrid($m->cancelPageQuery());
    }

    /**
     * 注销审核通过
     */
    public function cancelAllow(){
        $m = new M();
        $rs = $m->cancelAllow();
        return $rs;
    }

    /**
     * 注销审核不通过
     */
    public function cancelIllegal(){
        $m = new M();
        $rs = $m->cancelIllegal();
        return $rs;
    }
}

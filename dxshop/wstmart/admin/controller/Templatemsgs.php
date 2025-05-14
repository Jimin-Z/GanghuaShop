<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\TemplateMsgs as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 消息模板控制器
 */
class Templatemsgs extends Base{

    public function index(){
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
    	return $this->fetch("list");
    }
    /**
     * 获取分页
     */
    public function pageMsgQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery(0,'TEMPLATE_SYS'));
    }
     /**
     * 设置是否显示/隐藏
     */
    public function editiIsShow(){
    	$m = new M();
    	$rs = $m->editiIsShow();
    	return $rs;
    }
    /**
     * 跳转去新增页面
     */
    public function toEditMsg(){
        $id = (int)input('id');
        $m = new M();
        if($id>0){
            $data = $m->getById($id);
        }else{
            $data = $m->getEModel('template_msgs');
        }
        $this->assign('object',$data);
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("edit_msg");
    }
    /**
     * 跳转去新增页面
     */
    public function toEditEmail(){
        $id = (int)input('id');
        $m = new M();
        if($id>0){
            $data = $m->getById($id);
        }else{
            $data = $m->getEModel('template_email');
        }
        $this->assign('object',$data);
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("edit_email");
    }
    /**
     * 跳转去新增页面
     */
    public function toEditSMS(){
        $id = (int)input('id');
        $m = new M();
        if($id>0){
            $data = $m->getById($id);
        }else{
            $data = $m->getEModel('template_sms');
        }
        $this->assign('object',$data);
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("edit_sms");
    }

    /**
    * 发送消息
    */
    public function edit(){
        $m = new M();
        return $m->edit();
    }

    /**
     * 获取分页
     */
    public function pageEmailQuery(){
        $m = new M();
        return WSTLayGrid($m->pageEmailQuery());
    }
    /**
     * 获取分页
     */
    public function pageSMSQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery(2,'TEMPLATE_SMS'));
    }

}

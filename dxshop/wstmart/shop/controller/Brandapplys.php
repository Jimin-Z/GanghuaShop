<?php
namespace wstmart\shop\controller;
use wstmart\shop\model\BrandApplys as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 品牌申请控制器
 */
class Brandapplys extends Base{
    protected $beforeActionList = ['checkAuth'];
    public function index(){
        $this->assign("p",(int)input("p"));
        $this->assign('type',input('type','new'));
        return $this->fetch("brandapplys/list");
    }

    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        $rs = $m->pageQuery();
        return WSTLayGrid($rs);
    }

    /**
     * 获取品牌
     */
    public function get(){
        $m = new M();
        $rs = $m->get((int)Input("post.id"));
        return $rs;
    }

    /**
     * 跳去新增/编辑页面
     */
    public function toEdit(){
        $id = Input("get.id/d",0);
        $isNew = input('isNew',0);
        $m = new M();
        if($id>0){
            $object = $m->getById($id);
        }else{
            $object = $m->getEModel('brand_applys');
        }
        $this->assign("p",(int)input("p"));
        $this->assign('object',$object);
        $this->assign('gcatList',model('GoodsCats')->listQuery(0));
        $type = ($isNew==1)?'new':'join';
        $this->assign('type',$type);
        if($isNew){
            return $this->fetch("brandapplys/edit");
        }
        return $this->fetch("brandapplys/join_edit");
    }

    /*
     * 查看品牌下的商家
     */
    public function toView(){
        $this->assign("brandId",(int)input("id"));
        $this->assign("p",(int)input("p"));
        return $this->fetch("brandapplys/view");
    }

    /**
     * 获取品牌下的商家分页
     */
    public function shopPageQuery(){
        $m = new M();
        $rs = $m->shopPageQuery();
        return WSTLayGrid($rs);
    }

    /**
     * 新增
     */
    public function add(){
        $m = new M();
        $rs = $m->add();
        return $rs;
    }


    /**
     * 编辑
     */
    public function edit(){
        $m = new M();
        $rs = $m->edit();
        return $rs;
    }

    /**
     * 删除
     */
    public function del(){
        $m = new M();
        $rs = $m->del();
        return $rs;
    }

    /**
     * 根据品牌名称模糊查找品牌信息
     */
    public function getBrandByKey(){
        $m = new M();
        $rs = $m->getBrandByKey();
        return $rs;
    }

    /**
     * 获取品牌信息
     */
    public function getBrandInfo(){
        $m = new M();
        $rs = $m->getBrandInfo();
        return $rs;
    }
}

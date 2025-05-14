<?php
namespace wstmart\admin\controller;
use wstmart\admin\model\GoodsAppraises as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商品评价控制器
 */
class Goodsappraises extends Base{

    public function index(){
        //获取地区
        $area1 = model('areas')->listQuery(0);
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("list",['area1'=>$area1,]);
    }
    /**
     * 获取分页
     */
    public function pageQuery(){
        $m = new M();
        return WSTLayGrid($m->pageQuery());
    }
    /**
     * 跳去编辑页面
     */
    public function toEdit(){
        $m = new M();
        $data = $m->getById(input("get.id/d",0));
        if($data['images']!='')
            $data['images'] = explode(',',$data['images']);
        $assign = ['data'=>$data];
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("edit",$assign);
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

    /**
     * 跳去处理评论举报页面
     */
    public function toHandle(){
        $m = new M();
        $data = $m->getById(input("get.id/d",0));
        if($data['images']!='')
            $data['images'] = explode(',',$data['images']);
        $assign = ['data'=>$data];
        $this->assign("p",(int)input("p"));
        $tabType = (int)input("tabType");
        $tabType = $tabType>0?$tabType:1;
        $this->assign("tabType",$tabType);
        return $this->fetch("handle",$assign);
    }

    /*
     * 处理评论举报
     */
    public function handle(){
        $m = new M();
        return $m->handle();
    }
}

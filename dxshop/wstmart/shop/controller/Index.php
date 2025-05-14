<?php
namespace wstmart\shop\controller;
use wstmart\common\model\Users as MUsers;
use wstmart\common\model\LogSms;
use wstmart\shop\model\HomeMenus as HM;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 默认控制器
 */
class Index extends Base{
    protected $beforeActionList = ['checkAuth'=>['only'=>'index,main,getsysmessages,clearcache,main,closeguide']];
    /**
     * 店铺主页
     */
    public function index(){
       $m = new HM();
       $ms = $m->getShopMenus();
       $this->assign("sysMenus",$ms[1]);
       return $this->fetch('/index');
    }

  /**
   * 去登录
   */
  public function login(){
    $USER = session('WST_USER');
    //如果已经登录了则直接跳去用户中心
    if(!empty($USER) && $USER['userId']!='' && $USER['userType']==1)return $this->index();
    $loginName = cookie("loginName");
    if(!empty($loginName)){
        $this->assign('loginName',cookie("loginName"));
    }else{
        $this->assign('loginName','');
    }
    return $this->fetch('/login');
  }

  /**
     * 获取用户信息
     */
  public function getSysMessages(){
      $rs = model('Systems')->getSysMessages();
      return $rs;
  }

  public function clearCache(){
      model('common/shops')->clearCache((int)session('WST_USER.shopId'));
      return WSTReturn("清除成功", 1);
  }

  /**
   * 验证登录
   *
   */
  public function checkLogin(){
    $m = new MUsers();
    $rs = $m->checkLogin();
    return $rs;
  }

  /**
   * 用户退出
   */
  public function logout(){
     $rs = model('Users')->logout();
     session('WST_USER',null);
     return WSTReturn("退出成功，正在跳转页面", 1);
  }

  /**
     * 系统预览
     */
    public function main(){
      $s = model('shop/shops');
      $data = $s->getShopSummary((int)session('WST_USER.shopId'));
      $this->assign('data',$data);
      return $this->fetch("/main");
    }

    /**
     * 关闭指引
     */
    public function closeGuide(){
      $user = session('WST_USER');
      $user['isGuide'] = 1;
      session('WST_USER',$user);
      $m = model('shop/shops');
      $m->closeGuide();
    }
  
}

<?php
namespace wstmart\admin\controller;
use think\Db;
use wstmart\admin\model\Staffs;
use wstmart\admin\model\Menus;
use wstmart\admin\model\Index as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 首页控制器
 */
class Index extends Base{
	/**
	 * 跳去登录页
	 */
	public function login(){
        model('CronJobs')->autoByAdmin();
        if (WSTConf('CONF.isOpenSupplier')==1){
            model('SupplierCronJobs')->autoByAdmin();
        }
		return $this->fetch("/login");
	}
	
    public function index(){
    	$m = new Menus();
    	$ms = $m->getMenus();
    	$this->assign("sysMenus",$ms);
    	return $this->fetch("/index");
    }
    
    /**
     * 登录验证
     */
    public function checkLogin(){
    	$m = new Staffs();
    	return $m->checkLogin();
    }
    
    /**
     * 退出系统
     */
    public function logout(){
    	session('WST_STAFF',null);
    	return WSTReturn("退出成功，正在跳转页面", 1);
    }
    
    /**
     * 系统预览
     */
    public function main(){
    	$m = new M();
    	$rs = $m->summary();
    	$this->assign("object",$rs);
    	return $this->fetch("/main");
    }
    
    /**
     * 获取用户权限
     */
    public function getGrants(){
    	$rs = session('WST_STAFF');
    	if(empty($rs))return WSTReturn("您未登录，请先登录系统",-1);
    	$rs = $rs['privileges'];
    	$grants = [];
    	foreach ($rs as $v){
    		$grants[$v] = true;
    	}
    	return WSTReturn("权限加载成功",1, $grants);
    }
    /**
     * 清除缓存
     */
    public function clearcache(){
    	WSTClearAllCache();
    	return WSTReturn("清除成功!", 1);
    }
    
    /**
     * 获取最新版本提示
     */
    public function getVersion(){
    	$version = WSTConf("CONF.wstVersion");
    	$key = WSTConf("CONF.wstMd5");
    	$license = WSTConf("CONF.mallLicense");
    	$host = request()->root(true);
    	$url = base64_encode('version='.$version.'&version_md5='.$key."&license=".$license."&host=".$host);
    	//$content = file_get_contents('http://hk-city.com/index.php?m=Api&c=Download&a=getLastVersion&key='.$url);
    	$json = json_decode($content,true);
        if($json['version'] ==  $version){
    		$json['version'] = "same";
        }
		return $json;
    }
    
    /**
     * 输入授权码
     */
    public function enterLicense(){
    	return $this->fetch("/enter_license");
    }
    /**
     * 验证授权码
     */
    public function verifyLicense(){
    	$license = input('license');
    	$host = request()->root(true);
    	$key = base64_encode('host='.request()->root(true).'&license='.$license);
    	$content = file_get_contents('http://hk-city.com/index.php?m=Api&c=License&a=verifyLicense&key='.$key);
    	$json = json_decode($content,true);
    	$rs = array('status'=>1);
    	if(isset($json['status']) && $json['status']==1){
    		$m = new M();
    		$rs = $m->saveLicense();
    	}
    	$rs['license'] = $json;
		return $rs;
    }

    /**
     * 系统预览
     */
    public function getSysMessages(){
        $m = new M();
        $rs = $m->getSysMessages();
        return WSTReturn("", 1,$rs);
    }
    
}

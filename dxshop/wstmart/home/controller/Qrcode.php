<?php
namespace wstmart\home\controller;
use wstmart\common\model\Users as M;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 扫码控制器
 */
class Qrcode extends Base{

    /**
     * 二维码扫描状态检查
     */
    public function qrScannerCheck(){
        // 传递的token
        $passToken = input("token");
        // 缓存中的token
        $cacheToken = cache('WSTMART_QR_TOKEN'.$passToken);
        // 是否已扫描
        $tStatus = cache('WSTMART_QR_TOKEN_STATUS'.$passToken);
        $data = [];
        if(empty($cacheToken) || $passToken!=$cacheToken){
            // 二维码已失效
            $data['status'] = -2;
            $data['msg'] = "二维码已失效";
        }else if($tStatus=="scanner"){
            // 已扫描，等待确认登录
            $data['status'] = 0;
            $data['msg'] = "已扫描，等待确认登录";
        }else if($tStatus=="success"){
            // 执行登录
            $data['status'] = 1;
            $data['msg'] = "执行登录";
            $userId = cache('WSTMART_QR_TOKEN_USERID'.$passToken);
            $rs = (new M())->qrCodeLogin($userId);
            if($rs['status']!=1){
                // 登录异常
                $data['status'] = -3;
                $data['msg'] = rs['msg'];
            }
            // 清空扫码登录相关缓存
            cookie('WSTMART_CURRENT_QR_TOKEN', null);
            cache('WSTMART_QR_TOKEN'.$passToken, null);
            cache('WSTMART_QR_TOKEN_STATUS'.$passToken, null);
            // 执行调用登录
        }else if($tStatus=="fail"){
            // 用户取消登录
            $data['status'] = -3;
            $data['msg'] = "登录失败";
        }else{
            // 等待扫描
            $data['status'] = -1;
            $data['msg'] = "等待扫描";
        }
        return jsonp($data)->options(['default_jsonp_handler' => 'wstjsonp']);

    }

    /**
     * 获取token接口
     */
    public function getToken(){
        // 是否有扫码登录
        $token = "";
        // 清除旧token
        $prevToken = cookie('WSTMART_CURRENT_QR_TOKEN');
        if(!empty($prevToken)){
            cookie('WSTMART_CURRENT_QR_TOKEN', null);
            cache('WSTMART_QR_TOKEN'.$prevToken, null);
            cache('WSTMART_QR_TOKEN_STATUS'.$prevToken, null);
        }
        if(in_array(3, explode(',',WSTConf('CONF.loginType')))){
            $token = uniqid("WST", true);
            // 缓存token,有效期为2分钟
            cookie('WSTMART_CURRENT_QR_TOKEN', $token, 0);
            cache('WSTMART_QR_TOKEN'.$token, $token, 2 * 60);
            cache('WSTMART_QR_TOKEN_STATUS'.$token, 'waiting', 0);
        }
        return WSTReturn('ok', 1, ['token'=>$token]);
    }

    /**
     * 扫描登录二维码后的处理
     */
    public function qr(){
        // 传递的token
        $passToken = input("token");
        // 缓存中的token
        $cacheToken = cache('WSTMART_QR_TOKEN'.$passToken);
        
        // 是否已扫描
        $tStatus = cache('WSTMART_QR_TOKEN_STATUS'.$passToken);
      
        if(empty($cacheToken) || empty($tStatus) || $passToken!=$cacheToken){
            // 二维码已失效
            return json_encode(WSTReturn('二维码已失效', -2));
        }
        // 1:已扫描 2:执行登录
        $type = (int)input('type');
        
        if($type==1){
            // 将状态改为已扫描
            cache('WSTMART_QR_TOKEN_STATUS'.$passToken, "scanner");
            $rs = WSTReturn('ok', 1);
        }else if($type==2){
            // 将状态改为已确认登录
            cache('WSTMART_QR_TOKEN_STATUS'.$passToken, "success");
            // 获取用户id
            try {
                // 用户端app模块
                $userId = model('app/index')->getUserId();
            } catch (\Throwable $th) {
                // 商家端app模块
                $userId = model('shopapp/index')->getUserId();
            }
            cache('WSTMART_QR_TOKEN_USERID'.$passToken, $userId);
            $rs = WSTReturn('登录成功', 1);
        }else if($type==3){
            // 将状态改为已取消登录
            cache('WSTMART_QR_TOKEN_STATUS'.$passToken, "fail");
            $rs = WSTReturn('取消登录', 1);
        }else {
            $rs = WSTReturn('缺少参数', -1);
        }
        return json_encode($rs);
    }
}
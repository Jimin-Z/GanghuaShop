<?php
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 */
/**
 * 微信配置
 */
function WXAdmin(){
	$wechat = new \wechat\WSTWechat(WSTConf('CONF.wxAppId'),WSTConf('CONF.wxAppKey'));
	return $wechat;
}

/**
 * 密码规则检测
 */
function WSTCheckPwdRule($pwd){
	$reg = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[1-9])(?=.*[\W|_]).{8,}$/";
    $rs = Validate::regex($pwd,$reg);
    return $rs?true:'密码必须是包含大小写字母、数字、符号,且长度为8-20位';
}
<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 新闻通 同一科技有限公司，并保留所有权利。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author: 新闻通  4035172988@qq.com
 * Date: 2024-06-18
 */
//error_reporting(0);关闭
error_reporting(E_ALL);//打开
header("Content-type:text/html;charset=utf-8");
// [ 应用入口文件 ]
if (extension_loaded('zlib')){
    try{
        ob_end_clean();
    } catch(Exception $e) {

    }
    ob_start('ob_gzhandler');
}
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.4.0','<')) {
    die('本系统要求PHP版本 >= 5.4.0，当前PHP版本为：'.PHP_VERSION . '，请到虚拟主机控制面板里切换PHP版本，或联系空间商协助切换。(<font color="red">注：部分虚拟主机存在缓存，切换版本后请等待半小时左右再重试安装</font>)&nbsp;<a href="https://www.hkshop.com/help/azwt/2020/1012/11028.html" target="_blank">点击查看智讯通安装教程</a>');
}
// error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
error_reporting(E_ERROR | E_WARNING | E_PARSE);//报告运行时错误

// 检测是否已安装EyouCMS系统
if(file_exists("./install/") && !file_exists("./install/install.lock")){
    $url='./install/index.php';
    if (preg_match('/^s=\/(.+)/i', $_SERVER['QUERY_STRING'])) {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
    }
    header('Location:'.$url);
    exit();
}
error_reporting(E_ALL);//打开
// 缓存时间
define('EYOUCMS_CACHE_TIME', 86400);
// 数据绝对路径
define('DATA_PATH', __DIR__ . '/data/');
// 运行缓存
define('RUNTIME_PATH', DATA_PATH . 'runtime/');
// 安装程序定义
define('DEFAULT_INSTALL_DATE',1525756440);
// 序列号
define('DEFAULT_SERIALNUMBER','20180508131400oCWIoa');
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 加载框架引导文件
require __DIR__ . '/core/start.php';
 
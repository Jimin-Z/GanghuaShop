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

// 加载系统语言包
/*\think\Lang::load([
    APP_PATH . 'admin' . DS . 'lang' . DS . request()->langset() . EXT,
]);*/

$api_config = array(

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件 
    //'exception_tmpl'         => ROOT_PATH.'public/errpage/404.html',
    // errorpage 错误页面
    //'error_tmpl'         => ROOT_PATH.'public/errpage/404.html',

    // 过滤不需要登录的操作
    'filter_login_action' => array(
        // 'Admin@login', // 登录
        // 'Admin@logout', // 退出
        // 'Admin@vertify', // 验证码
    ),
    
    // 无需验证权限的操作
    'uneed_check_action' => array(
        'Base@*', // 基类
        'Index@*', // 后台首页
        'Ajax@*', // 所有ajax操作
        'Ueditor@*', // 编辑器上传
        'Uploadify@*', // 图片上传
    ),
);

$html_config = include_once 'html.php';
return array_merge($api_config, $html_config);
?>
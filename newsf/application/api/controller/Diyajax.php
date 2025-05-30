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

namespace app\api\controller;

use think\Db;

class Diyajax extends Base
{
    /*
     * 初始化操作
     */
    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 检验会员登录
     */
    public function check_userinfo()
    {
        if (IS_AJAX) {
            \think\Session::pause(); // 暂停session，防止session阻塞机制
            $ajaxLogic = new \app\api\logic\AjaxLogic;
            $result = $ajaxLogic->check_userinfo();
            if (!empty($result['data']['ey_is_login'])) {
                $assignData = [
                    'users' => $result['users'],
                ];
                $this->assign($assignData);

                $filename = './template/'.THEME_STYLE_PATH.'/'.'system/users_info.htm';
                if (file_exists($filename)) {
                    $html = $this->fetch($filename); // 渲染模板标签语法
                } else {
                    $html = '缺少模板文件：'.ltrim($filename, '.');
                }
                $result['data']['html'] = $html;
            }
            respose(['code'=>1, 'msg'=>'请求成功', 'data'=>$result['data']]);
        }
        abort(404);
    }
}
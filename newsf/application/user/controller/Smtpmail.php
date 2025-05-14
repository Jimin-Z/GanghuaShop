<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 2016-2028 智讯通 同一科技有限公司。。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author: 新闻通  4035172988@qq.com
 * Date: 2024-06-18
 */
namespace app\user\controller;

use think\Config;
use app\user\logic\SmtpmailLogic;

// 用于邮箱验证
class Smtpmail extends Base
{
    public $smtpmailLogic;

    /**
     * 构造方法
     */
    public function __construct(){
        parent::__construct();
        $this->smtpmailLogic = new SmtpmailLogic;
    }

    /**
     * 发送邮件
     */
    public function send_email($email = '', $title = '', $type = 'reg', $scene = 2, $data = [])
    {
        \think\Session::pause(); // 暂停session，防止session阻塞机制
        // 超时后，断掉邮件发送
        function_exists('set_time_limit') && set_time_limit(5);
        $data = !empty($data) && !is_array($data) ? json_decode(htmlspecialchars_decode(htmlspecialchars_decode($data)), true) : $data;
        $data = $this->smtpmailLogic->send_email($email, $title, $type, $scene, $data);
        if (1 == $data['code']) {
            $this->success($data['msg']);
        } else {
            $this->error($data['msg']);
        }
    }
}
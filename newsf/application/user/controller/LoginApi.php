<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 新闻通 同一科技有限公司，并保留所有权利。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author:
	unset
 * Date: 2019-2-25
 */

namespace app\user\controller;

use think\Db;
// use think\Session;
use think\Config;

class LoginApi extends Base
{
    public $oauth;

    public function _initialize() {
        parent::_initialize();
        session('?users_id');
        $this->oauth = input('param.oauth/s');
        if (!$this->oauth) {
            $this->error('非法操作', url('user/Users/login'));
        }
    }

    public function login(){
        $this->error('该功能尚未开放', url('user/Users/login'));
    }

    public function callback()
    {

    }
}
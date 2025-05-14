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

namespace app\plugins\controller;

use think\Db;

class Sample extends Base
{
    /**
     * 构造方法
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * index
     */
    public function index()
    {
        return $this->fetch('Sample/'.THEME_STYLE.'/index');
    }
}
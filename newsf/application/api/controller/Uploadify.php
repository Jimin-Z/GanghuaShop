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
use common\util\File;
use think\Image;
use think\Request;

class Uploadify extends Base
{
    private $sub_name = array('date', 'Ymd');
    private $savePath = 'allimg/';
    private $image_type = '';
    
    public function __construct()
    {
        parent::__construct();
        exit; // 目前没用到这个api接口
    }
}
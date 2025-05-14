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

namespace app\home\validate;
use think\Validate;

class Guestbook extends Validate
{
    // 验证规则
    protected $rule = array(
        'typeid'    => 'require|token',
    );

    protected $message = array(
        'typeid.require' => '表单缺少标签属性{$field.hidden}',
    );
}
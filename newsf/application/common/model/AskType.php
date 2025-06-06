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
namespace app\common\model;

use think\Db;
use think\Model;

/**
 * 模型
 */
class AskType extends Model
{
    /**
     * 数据表名，不带前缀
     */
    public $name = 'ask_type';

    /**
     * 插件标识
     */
    public $code = 'Askr';

    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }
}
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

namespace app\home\model;

use think\Model;

/**
 * 美化编辑
 */
class UiConfig extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * @author 小虎哥 by 2024-06-18
     */
    public function getInfo($theme_style, $page, $type, $name)
    {
        $md5key = md5($theme_style.$page.$name);
        $map = array(
            'md5key'    => $md5key,
            'type'  => $type,
        );
        $result = M('ui_config')->where($map)->cache(true,EYOUCMS_CACHE_TIME,"ui_config")->find();

        return $result;
    }
}
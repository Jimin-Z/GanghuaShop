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

/**
 * 只作用于网站前台页面，指定需要缓存的页面
 * 参数规则：
 *     mca ：plugins_控制器_操作名
 *     filename ：生成在/data/runtime目录下的指定路径，建议参考以下
 *     p ：当前url控制器的操作方法传入的全部参数变量名
 *     cache : 页面缓存有效时间，单位是秒
 */
return array(
    // array('mca'=>'plugins_Sample_index', 'filename'=>'channel/sample/index', 'cache'=>1),  
    // array('mca'=>'plugins_Sample_lists', 'filename'=>'articlelist/sample/list', 'p'=>array('tid','page'), 'cache'=>1), 
    // array('mca'=>'plugins_Sample_view', 'filename'=>'detail/sample/view', 'p'=>array('aid'), 'cache'=>1), 
);

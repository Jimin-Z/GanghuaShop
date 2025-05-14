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

namespace app\admin\model;

use think\Db;
use think\Model;

/**
 * 单页
 */
class Single extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * 后置操作方法
     * 自定义的一个函数 用于数据保存后做的相应处理操作, 使用时手动调用
     * @param int $aid 产品id
     * @param array $post post数据
     * @param string $opt 操作
     */
    public function afterSave($aid, $post, $opt)
    {
        $post['aid'] = $aid;
        $addonFieldExt = !empty($post['addonFieldExt']) ? $post['addonFieldExt'] : array();
        model('Field')->dealChannelPostData(6, $post, $addonFieldExt);
    }

    /**
     * 删除的后置操作方法
     * 自定义的一个函数 用于数据删除后做的相应处理操作, 使用时手动调用
     * @param int $aid
     */
    public function afterDel($typeidArr = array())
    {
        if (is_string($typeidArr)) {  $typeidArr = explode(',', $typeidArr); }
        $w1=array('typeid'=>array('IN', $typeidArr));
        // 同时删除单页文档表
       Db::name('archives')->where($w1)->delete();
        // 同时删除内容
       Db::name('single_content')->where($w1)->delete();
        // 清除缓存
     //   \think\Cache::clear("arctype");
      //  extra_cache('admin_all_menu', NULL);
    }
}
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
use think\Db;

/**
 * 简介
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
     * 获取单条记录
     * @author wengxianhu by 2017-7-26
     */
    public function getInfoByTypeid($typeid)
    {
       // $cacheKey = md5("home_model_Single_getInfoByTypeid_{$typeid}");
       // $result = '';//cache($cacheKey);
        //if (empty($result)) {
            $field = 'c.*, b.*, a.*, b.aid, a.id as typeid';
            $result = M('arctype')->field($field)
                ->alias('a')
                ->join('__ARCHIVES__ b', 'b.typeid = a.id', 'LEFT')
                ->join('__SINGLE_CONTENT__ c', 'c.aid = b.aid', 'LEFT')
                ->where('b.channel', 6)
                ->find($typeid);

          //  cache($cacheKey, $result, null, "arctype");
        //}

        return $result;
    }
}
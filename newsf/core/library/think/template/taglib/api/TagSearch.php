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

namespace think\template\taglib\api;

use think\Db;

/**
 * 搜索
 */
class TagSearch extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取热搜关键词
     */
    public function apiHotSearch($pagesize = 10,$keyword = '')
    {
        $where['is_hot'] = 1;
        if (!empty($keyword)){
            $where['word'] = ['LIKE',"%{$keyword}%"];
        }
        $list = Db::name('search_word')
            ->where($where)
            ->order('is_hot desc, searchNum desc')
            ->limit($pagesize)
            ->select();

        return $list;
    }
}
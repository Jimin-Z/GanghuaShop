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

namespace think\template\taglib\eyou;

/**
 * SQL万能标签
 */
class TagSql extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取记录集
     * @author wengxianhu by 2018-4-20
     */
    public function getSql($sql = '', $cachetime = '')
    {
        if (empty($sql)) {
            echo '标签sql报错：缺少属性 sql 值。';
            return false;
        } else if (stristr($sql, 'delete') || stristr($sql, 'truncate')) {
            echo '标签sql报错：不支持禁用词 delete 或 truncate';
            return false;
        }
 
        if ($cachetime === '') {
            $cachetime = EYOUCMS_CACHE_TIME;
        }

        $sql = str_replace(' eq ', ' = ', $sql); // 等于
        $sql = str_replace(' neq  ', ' != ', $sql); // 不等于            
        $sql = str_replace(' gt ', ' > ', $sql);// 大于
        $sql = str_replace(' egt ', ' >= ', $sql);// 大于等于
        $sql = str_replace(' lt ', ' < ', $sql);// 小于
        $sql = str_replace(' elt ', ' <= ', $sql);// 小于等于
        $sql = str_replace('__PREFIX__', config('database.prefix'), $sql); // 替换前缀
        $sql = str_replace('#@__', config('database.prefix'), $sql); // 兼容语法

        $cacheKey = "tagSql_".md5($sql);
        $result = cache($cacheKey);
        if (empty($result)) {
            $result = \think\Db::query($sql);
            cache($cacheKey, $result, $cachetime);
        }

        return $result;
    }
}
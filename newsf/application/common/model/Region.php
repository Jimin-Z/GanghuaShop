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
 * 区域分类
 */
class Region extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * 获取单条地区
     * @author wengxianhu by 2017-7-26
     */
    public function getInfo($id, $field = '*')
    {
        $result = Db::name('region')->field($field)->find($id);

        return $result;
    }

    /**
     * 获取多个地区
     * @author wengxianhu by 2017-7-26
     */
    public function getListByIds($ids = array(), $field = '*', $index_key = '')
    {
        $map = array(
            'id'   => array('IN', $ids),
        );
        $result = Db::name('region')->field($field)
            ->where($map)
            ->select();

        if (!empty($index_key)) {
            $result = convert_arr_key($result, $index_key);
        }

        return $result;
    }

    /**
     * 获取子地区
     * @author wengxianhu by 2017-7-26
     */
    public function getList($parent_id = 0, $field = '*', $index_key = '',$level = 0)
    {
        $result = $this->getAll($parent_id, $field, $index_key,$level);

        return $result;
    }

    /**
     * 获取全部地区
     * @author wengxianhu by 2017-7-26
     */
    public function getAll($parent_id = false, $field = '*', $index_key = '',$level = 0)
    {
        // $args = [$parent_id, $field, $index_key, $level];
        // $cacheKey = 'region-'.md5(__CLASS__.__FUNCTION__.json_encode($args));
        // $result = cache($cacheKey);
        // if (empty($result)) {
            $map = [];
            if (false !== $parent_id) {
                if (is_array($parent_id)) {
                    $map['parent_id'] = ['IN', $parent_id];
                } else {
                    $map['parent_id'] = $parent_id;
                }
            }
            if (0 !== $level) {
                $map['level'] = $level;
            }
            $result = Db::name('region')->field($field)
                ->where($map)
                ->select();

            if (!empty($index_key)) {
                $result = convert_arr_key($result, $index_key);
            }

            // cache($cacheKey, $result, null, "region");
        // }

        return $result;
    }

    /**
     * 获取级别的地区
     * @author wengxianhu by 2017-7-26
     */
    public function getListByLevel($level = 1, $field = '*', $index_key = '')
    {
        $map = array(
            'level' => $level,
        );

        $result = Db::name('region')->field($field)
            ->where($map)
            ->select();

        if (!empty($index_key)) {
            $result = convert_arr_key($result, $index_key);
        }

        return $result;
    }
}
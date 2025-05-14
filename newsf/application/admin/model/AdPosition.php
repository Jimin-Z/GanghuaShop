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
 * 广告分类
 */
class AdPosition extends Model
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
    public function getInfo($id, $field = '*')
    {
        $result = Db::name('AdPosition')->field($field)->find($id);

        return $result;
    }

    /**
     * 获取多条记录
     * @author wengxianhu by 2017-7-26
     */
    public function getListByIds($ids, $field = '*')
    {
        $map = array(
            'id'   => array('IN', $ids),
            'lang'  => get_admin_lang(),
        );
        $result = Db::name('AdPosition')->field($field)
            ->where($map)
            ->select();

        return $result;
    }

    /**
     * 默认获取广告分类，包括有效、无效等分类
     * @author wengxianhu by 2017-7-26
     */
    public function getAll($field = '*', $index_key = '')
    {
        $result = Db::name('AdPosition')->field($field)
            ->where([
                'lang'  => get_admin_lang(),
            ])->select();

        if (!empty($index_key)) {
            $result = convert_arr_key($result, $index_key);
        }

        return $result;
    }
}
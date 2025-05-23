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
 * 会员级别
 */
class UsersLevel extends Model
{
    private $lang = 'cn';
    private $main_lang = 'cn';

    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        $this->lang = get_current_lang();
        $this->main_lang = get_main_lang();
    }

    /**
     * 校验唯一性
     * @author wengxianhu by 2017-7-26
     */
    public function isRequired($id_name='',$id_value='',$field='',$value='')
    {
        $return = true;
        if ('ask_is_release' == $field || 'ask_is_review' == $field) return $return;
        $value = trim($value);
        if (!empty($value)) {
            $field == 'level_value' && $value = intval($value);

            $count = $this->where([
                    $field      => $value,
                    $id_name    => ['NEQ', $id_value],
                ])->count();
            if (!empty($count)) {
                $return = [
                    'msg'   => '数据不可重复',
                ];
            }
        }

        return $return;
    }

    public function getList($field = '*', $where = [], $index_key = '')
    {
        $map = [];
        if (!empty($where)) {
            $map = array_merge($map, $where);
        }
        if (!isset($map['lang'])) {
            $map['lang'] = $this->main_lang;
        }
        $result = Db::name('users_level')->field($field)->where($map)->cache(true, EYOUCMS_CACHE_TIME, "users_level")->order('level_value asc, level_id asc')->select();
        if (!empty($index_key)) {
            $result = convert_arr_key($result, $index_key);
        }
        
        return $result;
    }
}
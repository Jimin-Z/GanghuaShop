<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 2016-2028 智讯通 同一科技有限公司。。
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
 * 公共会员模型
 */
class EyouUsers extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    // 更新会员级别信息
    public function UpUsersLevelData($users_id = null)
    {
        if (!empty($users_id)) {
            $LevelData = [];
            /*查询系统初始的默认级别*/
            $LevelWhere = [
                'level_id'  => 1,
                'is_system' => 1,
            ];
            $level = Db::name('users_level')->where($LevelWhere)->field('level_id,level_name,level_value')->find();
            if (empty($level)) $level = ['level'=>1, 'level_name'=>'注册会员', 'level_value'=>10];
            /* END */

            /*更新信息*/
            $LevelData = [
                'level'           => $level['level_id'],
                'open_level_time' => 0,
                'level_maturity_days' => 0,
                'update_time'     => getTime(),
            ];
            $return = Db::name('users')->where('users_id', $users_id)->update($LevelData);
            /* END */

            if (!empty($return)) {
                $LevelData['level_name']  = $level['level_name'];
                $LevelData['level_value'] = $level['level_value'];
                return $LevelData;
            }
        }
        return [];
    }

    // 会员登录之后的业务逻辑
    public function loginAfter($users)
    {
        session('users', $users);
        session('users_id', $users['users_id']);
        session('users_login_expire', getTime()); // 登录有效期
        cookie('users_id', $users['users_id']);

        $data = [
            // 'last_ip'     => clientIP(),
            'last_ip'     => getClientIP(),
            'last_login'  => getTime(),
            'login_count' => Db::raw('login_count+1'),
        ];
        Db::name('users')->where('users_id', $users['users_id'])->update($data);
    }
}
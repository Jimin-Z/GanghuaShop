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
 * 后台微信登录
 */
class AdminWxlogin extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    public function save_data($admin_id = 0, $type = 0, $data =[])
    {
        $row = Db::name('admin_wxlogin')->where(['admin_id'=>$admin_id, 'type'=>$type])->find();
         $saveData = [
                'admin_id'   => $admin_id,
                'nickname'   => '',
                'headimgurl' => '',
                'openid'    => $data['openid'],
                'unionid'    => empty($data['unionid']) ? '' : $data['unionid'],
                'update_time'=> getTime(),
            ];
        if (!empty($row)) {
            $r = Db::name('admin_wxlogin')->where(['wx_id' => $row['wx_id']])->update($saveData);
        } else {
            $saveData['add_time'] =getTime();
            $r = Db::name('admin_wxlogin')->insert($saveData);
        }

        return ($r !== false) ? true : false;
    }
}
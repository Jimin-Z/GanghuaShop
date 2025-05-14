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
 * 文档喜欢(点赞)信息
 */
class TagLike extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取文档收藏信息
     * @author wengxianhu by 2018-4-20
     */
    public function getLike($aid = '', $type = 'default', $users = [])
    {
        if (empty($aid)) {
            return false;
        }

        $is_like = 0;
        if (!empty($users['users_id'])) {
            $result = Db::name("users_like")
                ->where(['aid' => $aid, 'users_id' => $users['users_id']])
                ->find();
            if (!empty($result)){
                $is_like = 1;
            }
        }

        return [
            'is_like'=>$is_like
        ];
    }
}
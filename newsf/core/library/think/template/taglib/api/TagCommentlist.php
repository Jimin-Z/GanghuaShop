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
 * 文档评论列表
 */
class TagCommentlist extends Base
{
    public $users_id = 0;

    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取文档评论列表
     */
    public function getCommentlist($param = array(), $aid = '')
    {
        if (!is_dir('./weapp/Comment/')){
            $redata = [
                'data'=> '请先安装评论插件',
            ];
            return $redata;
        }

        if (empty($aid)) {
            return false;
        }

        $page = empty($param['page']) ? 1 : $param['page'];
        $limit = empty($param['limit']) ? 10 : $param['limit'];
//        $orderway = empty($param['orderway']) ? 'desc' :$param['orderway'];
//        $orderby = empty($param['orderby']) ? 'add_time' :$param['orderby'];
//        $order = $orderby.' '.$orderway;
        $where_str['a.aid'] = $aid;
        $where_str['a.is_review'] = 1;
        $where_str['a.provider'] = $param['provider'];
        $where_str['b.users_id'] = ['gt', 0];
        $paginate = array(
            'page'  => $page,
        );

        $pages = Db::name('weapp_comment')
            ->alias('a')
            ->field('a.*,b.head_pic,b.nickname,b.sex')
            ->join('users b','a.users_id = b.users_id','left')
            ->where($where_str)
            ->order('comment_id desc')
            ->paginate($limit, false, $paginate);
        $result = $pages->toArray();
        foreach ($result['data'] as $key => $val) {
            $val['head_pic'] = $this->get_head_pic($val['head_pic'], false, $val['sex']);
            $val['add_time_format'] = $this->time_format($val['add_time']);
            $val['add_time'] = date('Y-m-d', $val['add_time']);
            $result['data'][$key] = $val;
        }

        $redata = [
            'data'=> !empty($result) ? $result : false,
        ];
        return $redata;
    }
}
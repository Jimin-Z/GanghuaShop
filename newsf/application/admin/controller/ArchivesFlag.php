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

namespace app\admin\controller;

use think\Db;
use think\Page;
use think\Cache;

class ArchivesFlag extends Base
{
    public function index()
    {
        $list = array();
        $keywords = input('keywords/s');
        $keywords = addslashes(trim($keywords));

        $condition = array();
        if (!empty($keywords)) {
            $condition['flag_name'] = array('LIKE', "%{$keywords}%");
        }

        $archivesflagM =  Db::name('archives_flag');
        $count = $archivesflagM->where($condition)->count('id');// 查询满足要求的总记录数
        $Page = $pager = new Page($count, config('paginate.list_rows'));// 实例化分页类 传入总记录数和每页显示的记录数
        $list = $archivesflagM->where($condition)->order('sort_order asc, id asc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $show = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('list',$list);// 赋值数据集
        $this->assign('pager',$pager);// 赋值分页对象
        return $this->fetch();
    }
}
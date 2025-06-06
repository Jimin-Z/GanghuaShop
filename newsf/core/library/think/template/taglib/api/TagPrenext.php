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
use think\Request;

/**
 * 内容页上下篇
 */
class TagPrenext extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取内容页上下篇
     * @author wengxianhu by 2018-4-20
     */
    public function getPrenext($aid = '', $typeid = '', $get = 'pre', $titlelen = 100)
    {
        !empty($aid) && $this->aid = $aid;
        if (empty($this->aid)) return false;
        
        !empty($typeid) && $this->tid = $typeid;
        if (empty($this->tid)) {
            $this->tid = Db::name('archives')->where('aid', $this->aid)->value('typeid');
        }

        $result = [];
        if ($get == 'pre' || $get == 'all') { // 上一篇
            $detail = Db::name('archives')->field('a.aid, a.typeid, a.title, a.litpic, a.click, a.channel')
                ->alias('a')
                ->where([
                    'a.typeid'  => $this->tid,
                    'a.aid'     => ['LT', $this->aid],
                    'a.arcrank' => ['EGT', 0],
                    'a.status'  => 1,
                    'a.is_del'  => 0,
                    'a.lang'    => self::$home_lang,
                ])
                ->order('a.aid desc')
                ->find();
            if (!empty($detail)) {
                $detail['title'] = text_msubstr($detail['title'], 0, $titlelen, false);
                $detail['litpic'] = $this->get_default_pic($detail['litpic']);
                // $detail['arcurl'] = '/pages/article/view?aid='.$detail['aid'];
                // $detail['typeurl'] = '/pages/article/list?typeid='.$detail['typeid'];
                $result['preDetail'] = $detail;
            }
        }
        if ($get == 'next' || $get == 'all') { // 下一篇
            $detail = Db::name('archives')->field('a.aid, a.typeid, a.title, a.litpic, a.click, a.channel')
                ->alias('a')
                ->where([
                    'a.typeid'  => $this->tid,
                    'a.aid'     => ['GT', $this->aid],
                    'a.arcrank' => ['EGT', 0],
                    'a.status'  => 1,
                    'a.is_del'  => 0,
                    'a.lang'    => self::$home_lang,
                ])
                ->order('a.aid asc')
                ->find();
            if (!empty($detail)) {
                $detail['title'] = text_msubstr($detail['title'], 0, $titlelen, false);
                $detail['litpic'] = $this->get_default_pic($detail['litpic']);
                // $detail['arcurl'] = '/pages/article/view?aid='.$detail['aid'];
                // $detail['typeurl'] = '/pages/article/list?typeid='.$detail['typeid'];
                $result['nextDetail'] = $detail;
            }
        }

        return !empty($result) ? $result : false;
    }
}
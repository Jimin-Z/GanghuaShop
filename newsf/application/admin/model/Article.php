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

namespace app\admin\model;

use think\Db;
use think\Model;

/**
 * 文章
 */
class Article extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    /**
     * 后置操作方法
     * 自定义的一个函数 用于数据保存后做的相应处理操作, 使用时手动调用
     * @param int $aid 产品id
     * @param array $post post数据
     * @param string $opt 操作
     */
    public function afterSave($aid, $post, $opt)
    {
        $post['aid'] = $aid;
        $addonFieldExt = !empty($post['addonFieldExt']) ? $post['addonFieldExt'] : array();
        $FieldModel = new \app\admin\model\Field;
        $FieldModel->dealChannelPostData($post['channel'], $post, $addonFieldExt);
        
        // 处理外贸链接
        if (is_dir('./weapp/Waimao/')) {
            $waimaoLogic = new \weapp\Waimao\logic\WaimaoLogic;
            $waimaoLogic->update_htmlfilename($aid, $post, $opt);
        }

        // --处理TAG标签
        model('Taglist')->savetags($aid, $post['typeid'], $post['tags'], $post['arcrank'], $opt);

        if ('edit' == $opt) {
            // 清空sql_cache_table数据缓存表 并 添加查询执行语句到mysql缓存表
            Db::name('sql_cache_table')->execute('TRUNCATE TABLE '.config('database.prefix').'sql_cache_table');
            model('SqlCacheTable')->InsertSqlCacheTable(true);
        } else {
            // 处理mysql缓存表数据
            if (isset($post['arcrank']) && -1 == $post['arcrank'] /*&& -1 == $post['old_arcrank']*/ && !empty($post['users_id'])) {
                // 待审核
                model('SqlCacheTable')->UpdateDraftSqlCacheTable($post, $opt);
            } else if (isset($post['arcrank'])) {
                // 已审核
                $post['old_typeid'] = intval($post['attr']['typeid']);
                model('SqlCacheTable')->UpdateSqlCacheTable($post, $opt, 'article');
            }
        }
        model('Arctype')->hand_type_count(['aid'=>[$aid]]);//统计栏目文档数量
    }

    /**
     * 获取单条记录
     * @author wengxianhu by 2017-7-26
     */
    public function getInfo($aid, $field = null, $isshowbody = true)
    {
        $result = array();
        $field = !empty($field) ? $field : '*';
        $result = Db::name('archives')->field($field)
            ->where([
                'aid'   => $aid,
                'lang'  => get_admin_lang(),
            ])
            ->find();
        if ($isshowbody) {
            $tableName = Db::name('channeltype')->where('id','eq',$result['channel'])->getField('table');
            $result['addonFieldExt'] = Db::name($tableName.'_content')->where('aid',$aid)->find();
        }

        // 文章TAG标签
        if (!empty($result)) {
            $typeid = isset($result['typeid']) ? $result['typeid'] : 0;
            $tags = model('Taglist')->getListByAid($aid, $typeid);
            $result['tags'] = $tags['tag_arr'];
            $result['tag_id'] = $tags['tid_arr'];
        }

        // 查询栏目名称
        $result['typename'] = !empty($typeid) ? Db::name('arctype')->where('id', $typeid)->getField('typename') : '';

        return $result;
    }

    /**
     * 删除的后置操作方法
     * 自定义的一个函数 用于数据删除后做的相应处理操作, 使用时手动调用
     * @param int $aid
     */
    public function afterDel($aidArr = array())
    {
        if (is_string($aidArr)) {
            $aidArr = explode(',', $aidArr);
        }
        // 同时删除内容
        Db::name('article_content')->where(array('aid'=>array('IN', $aidArr)))->delete();
        // 同时删除TAG标签
        model('Taglist')->delByAids($aidArr);
        // 减少统计数
        del_statistics_data(7, $aidArr);
    }
}
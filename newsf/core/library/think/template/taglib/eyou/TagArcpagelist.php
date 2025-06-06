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

namespace think\template\taglib\eyou;

use think\Db;

/**
 * arclist列表分页标签
 */
class TagArcpagelist extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     *  获取ajax分页
     *
     * @author wengxianhu by 2018-4-20
     * @access    public
     * @param     string  $tagid  标签id
     * @param     string  $pagesize  分页显示条数
     * @return    array
     */
    public function getArcpagelist($tagid = '', $pagesize = 0, $tips = '', $loading = '', $callback = '', $arclistTag = [])
    {
        if (empty($tagid)) {
            return '标签arcpagelist报错：缺少属性 tagid 。';
        }

        empty($tips) && $tips = '没有数据了';

        $tagidmd5 = $tagid.'_'.md5(serialize($arclistTag));

        if (empty($pagesize)) {
            $arcmulti_db = Db::name('arcmulti');
            $arcmultiRow = $arcmulti_db->field('pagesize')->where(['tagid'=>$tagidmd5])->find();
            $pagesize = $arcmultiRow['pagesize'];
        }

        $arcmulti_db = Db::name('arcmulti');
        $arcmultiRow = $arcmulti_db->field('attstr,querysql')->where(['tagid'=>$tagidmd5])->find();
        if (empty($arcmultiRow)) {
            return [];
        } else {
            // 取出属性并解析为变量
            $attarray = unserialize(stripslashes($arcmultiRow['attstr']));

            $querysql = preg_replace('#LIMIT(\s+)(\d+)(,\d+)?#i', '', $arcmultiRow['querysql']);
            $querysql = preg_replace('#SELECT(\s+)(.*)(\s+)FROM#i', 'SELECT COUNT(*) AS totalNum FROM', $querysql);
            $queryRow = Db::query($querysql);
            $totalNum = !empty($queryRow) ? $queryRow[0]['totalNum'] : 0;
            if (intval($attarray['row']) >= $totalNum) {
                return [];
            }
        }

        $result = [];
        $version = getCmsVersion();
        $keywords = input('param.keywords/s');
        $result['onclick'] = ' data-page="1" data-tips="'.$tips.'" data-loading="'.$loading.'" data-root_dir="'.$this->root_dir.'" data-tagidmd5="'.$tagidmd5.'" data-lang="'.self::$home_lang.'" data-keywords="'.$keywords.'"  onClick="tag_arcpagelist_multi(this,\''.$tagid.'\','.intval($pagesize).',\''.$callback.'\');" ';
        $srcurl = get_absolute_url("{$this->root_dir}/public/static/common/js/tag_arcpagelist.js?v={$version}");
        $result['js'] = <<<EOF
<script language='javascript' type='text/javascript' src='{$srcurl}'></script>
EOF;

        return $result;
    }
}
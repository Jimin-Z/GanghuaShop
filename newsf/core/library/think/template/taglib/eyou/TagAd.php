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

namespace think\template\taglib\eyou;

/**
 * 单个广告信息
 */
class TagAd extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取单个广告信息
     * @author wengxianhu by 2018-4-20
     */
    public function getAd($aid = '')
    {
        if (empty($aid)) {
            echo '标签ad报错：缺少属性 aid 值。';
            return false;
        }

        /*多语言*/
        $aid = model('LanguageAttr')->getBindValue($aid, 'ad');
        if (empty($aid)) {
            echo '标签ad报错：找不到与第一套【'.self::$main_lang.'】语言关联绑定的属性 aid 值。';
            return false;
        } else {
            if (self::$language_split) {
                $this->lang = Db::name('ad')->where(['id'=>$aid])->cache(true, EYOUCMS_CACHE_TIME, 'ad')->value('lang');
                if ($this->lang != self::$home_lang) {
                    $lang_title = Db::name('language_mark')->where(['mark'=>self::$home_lang])->value('cn_title');
                    echo "标签ad报错：【{$lang_title}】语言 aid 值不存在。";
                    return false;
                }
            }
        }
        /*--end*/

        $result = M("ad")->where(['id' => $aid])->cache(true,EYOUCMS_CACHE_TIME,"ad")->find();
        if (empty($result)) {
            echo '标签ad报错：该广告ID('.$aid.')不存在。';
            return false;
        }

        $result['litpic'] = handle_subdir_pic(get_default_pic($result['litpic'])); // 默认无图封面
        $result['intro'] = htmlspecialchars_decode($result['intro']); // 解码内容
        $result['target'] = ($result['target'] == 1) ? 'target="_blank"' : 'target="_self"';

        /*支持子目录*/
        $result['intro'] = handle_subdir_pic($result['intro'], 'html');
        /*--end*/

        return $result;
    }
}
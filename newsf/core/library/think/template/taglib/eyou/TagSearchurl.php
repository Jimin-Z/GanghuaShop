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

use think\Request;

/**
 * 搜索表单
 */
class TagSearchurl extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取搜索表单
     * @author wengxianhu by 2018-4-20
     */
    public function getSearchurl()
    {
        $url = url("home/Search/lists");
        $ey_config = config('ey_config'); // URL模式
        if (2 == $ey_config['seo_pseudo'] || (1 == $ey_config['seo_pseudo'] && 1 == $ey_config['seo_dynamic_format'])) {
            $result = '';
            $result .= $url.'"><input type="hidden" name="m" value="home" />';
            $result .= '<input type="hidden" name="c" value="Search" />';
            $result .= '<input type="hidden" name="a" value="lists';

            /*手机端域名*/
            $goto = input('param.goto/s');
            $goto = trim($goto, '/');
            !empty($goto) && $result .= '" /><input type="hidden" name="goto" value="'.$goto;
            /*--end*/

            /*多语言*/
            $lang = Request::instance()->param('lang/s');
            !empty($lang) && $result .= '" /><input type="hidden" name="lang" value="'.$lang;
            /*--end*/
        } else {
            $result = $url;
        }
        
        return $result;
    }
}
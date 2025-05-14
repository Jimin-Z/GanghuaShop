<?php
/**
 * 新闻通
 * ============================================================================
 * 版权所有 新闻通 同一科技有限公司，并保留所有权利。
 * 
 * ----------------------------------------------------------------------------
，
 * ============================================================================
 * Author:
	unset
 * Date: 2019-5-7
 */

namespace think\template\taglib\eyou;

use think\Request;

/**
 * 搜索表单
 */
class TagSpsearch extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 订单获取搜索
     */
    public function getSpsearch()
    {
        $hidden = '';
        $ey_config = config('ey_config'); // URL模式
        if ('ShopComment' == Request::instance()->controller()) {
            if (2 == $ey_config['seo_pseudo'] || (1 == $ey_config['seo_pseudo'] && 1 == $ey_config['seo_dynamic_format'])) {
                $action = Request::instance()->action() ? Request::instance()->action() : 'index';
                $hidden .= '<input type="hidden" name="m" value="user" />';
                $hidden .= '<input type="hidden" name="c" value="ShopComment" />';
                $hidden .= '<input type="hidden" name="a" value="' . $action . '" />';
                /*多语言*/
                $lang = Request::instance()->param('lang/s');
                !empty($lang) && $hidden .= '<input type="hidden" name="lang" value="'.$lang.'" />';
                /*--end*/
            }

            // 搜索的URL
            $searchurl = url('user/ShopComment/' . $action . '');
        } else if ('after_service' == Request::instance()->action()) {
            if (2 == $ey_config['seo_pseudo'] || (1 == $ey_config['seo_pseudo'] && 1 == $ey_config['seo_dynamic_format'])) {
                $hidden .= '<input type="hidden" name="m" value="user" />';
                $hidden .= '<input type="hidden" name="c" value="Shop" />';
                $hidden .= '<input type="hidden" name="a" value="after_service" />';
                /*多语言*/
                $lang = Request::instance()->param('lang/s');
                !empty($lang) && $hidden .= '<input type="hidden" name="lang" value="'.$lang.'" />';
                /*--end*/
            }

            // 搜索的URL
            $searchurl = url('user/Shop/after_service');
        } else {
            if (2 == $ey_config['seo_pseudo'] || (1 == $ey_config['seo_pseudo'] && 1 == $ey_config['seo_dynamic_format'])) {
                $hidden .= '<input type="hidden" name="m" value="user" />';
                $hidden .= '<input type="hidden" name="c" value="Shop" />';
                $hidden .= '<input type="hidden" name="a" value="shop_centre" />';
                /*多语言*/
                $lang = Request::instance()->param('lang/s');
                !empty($lang) && $hidden .= '<input type="hidden" name="lang" value="'.$lang.'" />';
                /*--end*/
            }

            // 搜索的URL
            $searchurl = url('user/Shop/shop_centre');
        }
        
        $result[0] = array(
            'action'    => $searchurl,
            'hidden'    => $hidden,
        );
        
        return $result;
    }
}
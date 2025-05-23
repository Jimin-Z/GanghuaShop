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
 * 代码编辑
 */
class TagUicode extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    public function getUicode($e_id = '', $e_page = '')
    {
        if (empty($e_id) || empty($e_page)) {
            echo '标签uicode报错：缺少属性 e-id | e-page 。';
            return false;
        }

        $result = false;
        $inc = get_ui_inc_params($e_page);
        $inckey = self::$home_lang."_code_{$e_id}";
        if (empty($inc[$inckey])) {
            $inckey = "code_{$e_id}"; // 兼容v1.2.1之前的数据
        }

        $info = false;
        if ($inc && !empty($inc[$inckey])) {
            $data = json_decode($inc[$inckey], true);
            $info = $data['info'];
        }

        $value = '';
        if (is_array($info) && !empty($info)) {
            $value .= isset($info['value']) ? $info['value'] : '';
            // $value = preg_replace('#<p([^>]*)>(\s*)(<b class="ui_icon"><\/b>|<strong class="ui_icon"><\/strong>)<(\s*)\/p>#', '', $value);
            $value = htmlspecialchars_decode($value);
        }

        $result = array(
            'value'  => $value,
        );

        return $result;
    }
}
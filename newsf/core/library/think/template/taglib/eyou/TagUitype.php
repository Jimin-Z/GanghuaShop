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
 * 栏目编辑
 */
class TagUitype extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 栏目编辑
     * @author wengxianhu by 2018-4-20
     */
    public function getUitype($typeid = '', $e_id = '', $e_page = '')
    {
        if (empty($e_id) || empty($e_page)) {
            echo '标签uitype报错：缺少属性 e-id | e-page 。';
            return false;
        }

        $result = false;
        $inc = get_ui_inc_params($e_page);
        $inckey = self::$home_lang."_type_{$e_id}";
        if (empty($inc[$inckey])) {
            $inckey = "type_{$e_id}"; // 兼容v1.2.1之前的数据
        }

        $info = false;
        if ($inc && !empty($inc[$inckey])) {
            $data = json_decode($inc[$inckey], true);
            $info = $data['info'];
        } else {
            if (!empty($typeid)) {
                $new_typeid = model('LanguageAttr')->getBindValue($typeid, 'arctype');
                !empty($new_typeid) && $typeid = $new_typeid;
            }
            $info['typeid'] = $typeid;
        }

        $result = array(
            'info'  => $info,
        );

        return $result;
    }
}
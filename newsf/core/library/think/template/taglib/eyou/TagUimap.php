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
 * 百度地图
 */
class TagUimap extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    public function getUimap($e_id = '', $e_page = '', $width = '', $height = '')
    {
        if (empty($e_id) || empty($e_page)) {
            echo '标签uimap报错：缺少属性 e-id | e-page 。';
            return false;
        }

        $result = false;
        $inc = get_ui_inc_params($e_page);
        $inckey = self::$home_lang."_map_{$e_id}";
        if (empty($inc[$inckey])) {
            $inckey = "map_{$e_id}"; // 兼容v1.2.1之前的数据
        }

        $info = false;
        if ($inc && !empty($inc[$inckey])) {
            $data = json_decode($inc[$inckey], true);
            $info = $data['info'];
        }

        $zoom = 13;
        $coordinate = '110.34678620675,20.001944329655';
        if (is_array($info) && !empty($info)) {
            if (isset($info['value'])) {
                $coordinate = trim($info['value']);
            }
            $zoom = !empty($info['zoom']) ? intval($info['zoom']) : $zoom;
        }
        
        if (stristr($width, '%')) {
            $mapWidth = $width;
        } else {
            $mapWidth = $width - 4;
        }

        if (stristr($height, '%')) {
            $mapHeight = $height;
        } else {
            $mapHeight = $height - 4;
        }
        
        $value = "<iframe class='uimap_baidumap_{$e_id}' src='{$this->root_dir}/public/plugins/Ueditor/dialogs/map/show.html#center={$coordinate}&zoom={$zoom}&width={$mapWidth}&height={$mapHeight}&markers={$coordinate}&markerStyles=l,A' frameborder='0' width='{$width}' height='{$height}'></iframe>";

        $result = array(
            'value'  => $value,
        );

        return $result;
    }
}
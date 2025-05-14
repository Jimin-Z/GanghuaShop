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

$plugins_route = [];

/*引入全部插件的路由配置*/
$weappRow = \think\Db::name('weapp')->field('code')->where([
    'status'    => 1,
])->cache(true, null, "weapp")->select();
foreach ($weappRow as $key => $val) {
    $file = WEAPP_DIR_NAME.DS.$val['code'].DS.'route.php';
    if (file_exists($file)) {
        $route_value = include_once $file;
        if (!empty($route_value) && is_array($route_value)) {
            $plugins_route = array_merge($route_value, $plugins_route);
        }
    }
}
/*--end*/

$route = array(
    '__pattern__' => array(),
    '__alias__' => array(),
    '__domain__' => array(),
);

$route = array_merge($route, $plugins_route);

return $route;

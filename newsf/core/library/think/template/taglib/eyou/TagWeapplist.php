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
 * 网站应用插件列表标签
 */
class TagWeapplist extends Base
{
    public $weappidArr = array();
    
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
        $this->weappidArr = array();
    }

    /**
     * 页面上展示网站应用插件
     * @author wengxianhu by 2018-4-20
     */
    public function getWeapplist($type = 'usersmenu', $currentclass = '')
    {
        $row = false;
        $map = array(
            'tag_weapp' => array('eq',1),
            'status' => array('eq',1),
            'position'  => $type,
        );
        $result = M('weapp')->field('name,code,config')
            ->where($map)
            ->select();
        foreach ($result as $key => $val) {
            $config = json_decode($val['config'], true);
            if (isMobile() && !in_array($config['scene'], [0,1])) {
                continue;
            } else if (!isMobile() && !in_array($config['scene'], [0,2])) {
                continue;
            }

            $code = $val['code'];
            $link = !empty($config['link']) ? $config['link'] : 'user/Users/centre';
            $href = url($link);
            $menutitle = !empty($config['menutitle']) ? $config['menutitle'] : $val['name'];

            /*标记被选中效果*/
            if (stristr($link, MODULE_NAME.'/'.CONTROLLER_NAME.'/')) {
                $tmp_currentclass = $currentclass;
            } else {
                $tmp_currentclass = '';
            }
            /*--end*/

            $row[] = [
                'code'  => $code,
                'href'  => $href,
                'title' => $menutitle,
                'currentclass'  => $tmp_currentclass,
                'currentstyle'  => $tmp_currentclass,
            ];
        }
        return $row;
    }
}
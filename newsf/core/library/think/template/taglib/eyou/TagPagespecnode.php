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
 * 专题节点列表分页代码
 */
class TagPagespecnode extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 专题节点列表分页代码
     * @author wengxianhu by 2018-4-20
     */
    public function getPagespecnode($pages = '', $listitem = '', $listsize = '')
    {
        if (empty($pages)) {
            echo '标签pagespecnode报错：只适用在标签specnode之后。';
            return false;
        }
        $listitem = !empty($listitem) ? $listitem : 'info,index,end,pre,next,pageno';
        $listsize = !empty($listsize) ? $listsize : '3';

        $value = $pages->render($listitem, $listsize);

        return $value;
    }
}
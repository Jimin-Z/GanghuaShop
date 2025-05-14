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
 * 产品参数
 */
class TagAttr extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取每篇文章的属性值
     * @author wengxianhu by 2018-4-20
     */
    public function getAttr($aid = '', $name = '')
    {
        $aid = !empty($aid) ? $aid : $this->aid;

        if (empty($aid)) {
            echo '标签attr报错：缺少属性 aid 值。';
            return false;
        }

        if (empty($name)) {
            echo '标签attr报错：缺少属性 name 值。';
            return false;
        }
        
        $parseStr = false;

        /*当前文档的属性值*/
        $attr_id = intval($name);
        $row = M('product_attr')->alias('a')
            ->field('a.attr_value')
            ->join('__PRODUCT_ATTRIBUTE__ b', 'a.attr_id = b.attr_id', 'LEFT')
            ->where([
                'a.aid'     => $aid,
                'a.attr_id' => $attr_id,
                'b.lang'    => self::$home_lang,
                'b.is_del'  => 0,
            ])
            ->find();
        /*--end*/
        if (empty($row)) {
            return $parseStr;
        } else {
            /*获取多语言关联绑定的值*/
            $row = model('LanguageAttr')->getBindValue($row, 'product_attribute', self::$main_lang); // 多语言
            /*--end*/

            $parseStr = $row['attr_value'];
        }

        return $parseStr;
    }
}
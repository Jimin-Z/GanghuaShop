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

namespace app\admin\model;

use think\Model;
use think\Db;

/**
 * 产品参数
 */
class ProductAttribute extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

    public function getListByTypeid($typeid = 0)
    {
    	$result = Db::name('product_attribute')->where([
    			'typeid'	=> $typeid,
    			'is_del'	=> 0,
    			'lang'		=> get_admin_lang(),
    		])->count();

    	return $result;
    }
}
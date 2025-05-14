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

namespace app\admin\logic;

use think\Model;
use think\Db;
use think\Request;

/**
 * 逻辑定义
 * Class CatsLogic
 * @package admin\Logic
 */
class DiyExtendLogic extends Model
{
    private $request = null; // 当前Request对象实例
    private $admin_lang = 'cn'; // 后台多语言标识

    /**
     * 析构函数
     */
    function  __construct() {
        null === $this->request && $this->request = Request::instance();
        $this->admin_lang = get_admin_lang();
    }

    /**
     * 获取当前页面所在的模型ID
     * @param string $id 模型ID
     */
    public function getChannelid()
    {
        $channeltype = input('param.channeltype/d', 0);
        $channel = input('param.channel/d', $channeltype);
        if (!empty($channel)) {
            return $channel;
        }

        $controller_name = input('param.controller_name/s', '');
        if (empty($controller_name)) {
            $controller_name = $this->request->controller();
        }
        
        if ('Custom' != $controller_name) {
            $channel = Db::name('channeltype')->where([
                    'ctl_name'  => $controller_name,
                ])->getField('id');
        }

        return $channel;
    }
}

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

use think\Db;
use think\Model;
// use app\admin\logic\WeappLogic;

/**
 * 插件模型
 */
class Weapp extends Model
{
    public $weappLogic;
    
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        // $this->weappLogic = new WeappLogic();
    }

    /**
     * 获取插件列表
     */
    public function getList($where = array()){
        $result = Db::name('weapp')->where($where)->getAllWithIndex('code');
        foreach ($result as $key => $val) {
            $config = include WEAPP_PATH.$val['code'].DS.'config.php';
            $val['config'] = json_encode($config);
            $result[$key] = $val;
        }
        return $result;
    }

    /**
     * 清除插件列表的缓存
     */
    public function clearWeappCache()
    {
        \think\Cache::clear('weapp');
        cache('common_weapp_getWeappList', null);
        $weappM = new \app\common\model\Weapp;
        $weappM->getWeappList();
    }

    /**
     * 获取插件列表所有信息，方便系统其它地方使用
     */
    public function getWeappList($code = '')
    {
        $weappM = new \app\common\model\Weapp;
        return $weappM->getWeappList($code);
    }
}
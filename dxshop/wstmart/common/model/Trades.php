<?php
namespace wstmart\common\model;
use think\Db;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 行业类
 */
class Trades extends Base{
	protected $pk = 'tradeId';
	
	/**
     * 获取行业信息
     */
    public function getFieldsById($tradeId,$fields){
        return $this->where(['tradeId'=>$tradeId,'dataFlag'=>1])->field($fields)->find();
    }

    /**
     * 获取行业列表
     */
    public function listQuery($parentId = 0){
    	return $this->where(['dataFlag'=>1,'isShow'=>1,'parentId'=>$parentId])->order('tradeSort asc')->field('tradeName,simpleName,tradeId')->select();
    }


}

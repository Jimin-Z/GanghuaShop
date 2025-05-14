<?php
namespace wstmart\common\validate;
use think\Validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 商家会员分组验证器
 */
class ShopMemberGroups extends Validate{
	protected $rule = [
	    'groupName' => 'require|max:50',
        'minMoney'=> 'checkMoney',
        'maxMoney'=> 'checkMoney'
    ];

    protected $message = [
        'groupName.require' => '请输入分组名称',
        'groupName.max' => '分组名称不能超过50个字符',
    ];

    protected function checkMoney($value){
        $minMoney = input("minMoney");
        $maxMoney = input("maxMoney");
        if((float)$minMoney>(float)$maxMoney)return '最低消费不能大于最高消费';
        return true;
    }

    protected $scene = [
        'add'   =>  ['groupName','minMoney','maxMoney'],
        'edit'  =>  ['groupName','minMoney','maxMoney'],
    ];
}

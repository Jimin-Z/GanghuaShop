<?php 
namespace wstmart\admin\validate;
use think\Validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 银行验证器
 */
class Banks extends Validate{
	protected $rule = [
        'bankName' => 'require|max:150'
    ];
    
    protected $message = [
        'bankName.require' => '请输入银行名称',
        'bankName.max' => '银行名称不能超过50个字符'
    ];
    protected $scene = [
        'add'   =>  ['bankName'],
        'edit'  =>  ['bankName']
    ]; 
}
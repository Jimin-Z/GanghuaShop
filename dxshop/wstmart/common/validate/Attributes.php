<?php
namespace wstmart\common\validate;
use think\Validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 属性验证器
 */
class Attributes extends Validate{
	protected $rule = [
		'attrName' => 'require|max:60',
		'attrType' => 'in:0,1,2',
		'attrVal' => 'checkattrVal:1',
		'isShow' => 'in:0,1',
	];

	protected $message = [
        'attrName.require' => '请输入属性名称',
        'attrName.max' => '属性名称不能超过20个字符',
        'attrType.in' => '请选择属性类型',
        'attrVal.checkattrVal' => '',
        'isShow.in' => '请选择是否显示',
	];
	protected $scene = [
		'add'=>['attrName','attrType','attrVal','isShow'],
		'edit'=>['attrName','attrType','attrVal','isShow'],
	];
	protected function checkattrVal(){
		if(input('post.attrType/d')!=0 && input('post.attrVal')=='')return '请输入属性选项';
		return true;
	}

}

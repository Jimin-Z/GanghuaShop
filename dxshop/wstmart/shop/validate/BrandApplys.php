<?php 
namespace wstmart\shop\validate;
use think\Validate;
/**
 * ============================================================================
//官网地址:http://hk-city.com
 * ============================================================================
 * 品牌申请验证器
 */
class BrandApplys extends Validate{
	protected $rule = [
	    'brandName' => 'require|max:60',
		'brandImg'  => 'require',
		'brandDesc' => 'require',
		'accreditImg' => 'require',
    ];
    
    protected $message = [
        'brandName.require' => '请输入品牌名称',
        'brandName.max' => '品牌名称不能超过20个字符',
        'brandImg.require' => '请上传品牌图标',
        'brandDesc.require' => '请输入品牌介绍',
        'accreditImg.require' => '请上传品牌授权书',
    ];

    protected $scene = [
        'add'   =>  ['brandName','brandImg','brandDesc'],
        'edit'  =>  ['brandName','brandImg','brandDesc'],
        'join_add' => ['brandName','brandImg','brandDesc','accreditImg'],
        'join_edit' => ['brandName','brandImg','brandDesc','accreditImg'],
    ]; 
}
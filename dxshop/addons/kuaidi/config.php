<?php

return array(
	'kd_tips1'=>array(
		'title'=>'快递代码是用于物流查询，<span >请登录<a target="_blank" href="https://api.kuaidi100.com/manager/page/document/kdbm" style="color:blue">快递100企业管理后台</a>(技术文档->快递公司编码)查看</span>',
		'type'=>'hidden',
		'value'=>''
	),
	'kuaidiCode'=>array(
		'title'=>'再到“商城->购物设置->快递管理”中设置物流公司的快递代码',
		'type'=>'hidden',
		'value'=>'',
		'tips'=>''
	),
	'kuaidiDes'=>array(
		'title'=>'<span ><a target="_blank" href="https://www.kuaidi100.com/openapi/applyapi.shtml" style="color:blue">在线申请密匙(Key)【企业版】</a></span><div>因快递100免费版对部分快递公司查询接口进行了限制，导致数据查询不出来，<span style="color:red;font-size:15px;">建议使用企业版</span>！</div>',
		'type'=>'hidden',
		'value'=>'',
		'tips'=>''
	),
	'kuaidiType'=>array(
		'title'=>"快递查询接口类型",
		'type'=>'radio',
		'options'=>array(
			'1'=>'企业版',	
			'2'=>'免费版'
		),
		'value'=>'1',
	),
	'kuaidiKey'=>array(
		'title'=>'快递100授权密匙(Key)',
		'type'=>'text',
		'value'=>'',
		'tips'=>''
	),
	'kuaidiCustomer'=>array(
		'title'=>'快递100实时查询(Customer)<span style="color:red">企业版必填</span>',
		'type'=>'text',
		'value'=>'',
		'tips'=>''
	)
);

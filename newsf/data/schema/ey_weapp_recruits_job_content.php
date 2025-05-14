<?php 
return array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => NULL,
    'primary' => true,
    'autoinc' => true,
  ),
  'aid' => 
  array (
    'name' => 'aid',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'content' => 
  array (
    'name' => 'content',
    'type' => 'longtext',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'gzjy' => 
  array (
    'name' => 'gzjy',
    'type' => 'enum(\'经验不限\',\'1年以下\',\'1-3年\',\'5-10年\',\'10年以上\')',
    'notnull' => false,
    'default' => '经验不限',
    'primary' => false,
    'autoinc' => false,
  ),
  'xbsx' => 
  array (
    'name' => 'xbsx',
    'type' => 'enum(\'不限\',\'男\',\'女\')',
    'notnull' => false,
    'default' => '不限',
    'primary' => false,
    'autoinc' => false,
  ),
  'xlyq' => 
  array (
    'name' => 'xlyq',
    'type' => 'enum(\'学历不限\',\'小学\',\'初中\',\'高中\',\'中技\',\'中专\',\'大专\',\'本科\',\'硕士\',\'博士\',\'博后\')',
    'notnull' => false,
    'default' => '学历不限',
    'primary' => false,
    'autoinc' => false,
  ),
  'birthday' => 
  array (
    'name' => 'birthday',
    'type' => 'varchar(10)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'mobile' => 
  array (
    'name' => 'mobile',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'currents' => 
  array (
    'name' => 'currents',
    'type' => 'enum(\'我目前已离职、可快速到岗\',\'我目前在职、但考虑换个新环境\',\'观望有好的机会再考虑\',\'目前暂无跳槽打算\',\'应届毕业生\')',
    'notnull' => false,
    'default' => '我目前已离职、可快速到岗',
    'primary' => false,
    'autoinc' => false,
  ),
  'wage' => 
  array (
    'name' => 'wage',
    'type' => 'enum(\'1000~1500/月\',\'1500~2000/月\',\'2000~3000/月\',\'3000~5000/月\',\'5000~10000/月\',\'10000以上/月\',\'面议\')',
    'notnull' => false,
    'default' => '1000~1500/月',
    'primary' => false,
    'autoinc' => false,
  ),
  'nature' => 
  array (
    'name' => 'nature',
    'type' => 'enum(\'全职\',\'兼职\',\'实习\')',
    'notnull' => false,
    'default' => '全职',
    'primary' => false,
    'autoinc' => false,
  ),
  'specialty' => 
  array (
    'name' => 'specialty',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'specialitys' => 
  array (
    'name' => 'specialitys',
    'type' => 'set(\'形象好\',\'气质佳\',\'能出差\',\'很幽默\',\'技术精悍\',\'有亲和力\',\'高学历\',\'经验丰富\',\'能加班\',\'海归\',\'会开车\',\'口才好\',\'声音甜美\',\'会应酬\',\'诚实守信\',\'外语好\',\'性格开朗\',\'有上进心\',\'人脉广\',\'知识丰富\',\'才艺多\')',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'birthdy' => 
  array (
    'name' => 'birthdy',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'qwgw' => 
  array (
    'name' => 'qwgw',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'add_time' => 
  array (
    'name' => 'add_time',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'update_time' => 
  array (
    'name' => 'update_time',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
);
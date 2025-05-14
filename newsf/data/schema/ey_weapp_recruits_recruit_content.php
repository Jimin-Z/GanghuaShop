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
    'type' => 'int(11)',
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
  'yuexin' => 
  array (
    'name' => 'yuexin',
    'type' => 'enum(\'1000~1500/月\',\'1500~2000/月\',\'2000~3000/月\',\'3000~5000/月\',\'5000~10000/月\',\'10000以上/月\',\'面议\')',
    'notnull' => false,
    'default' => '1000~1500/月',
    'primary' => false,
    'autoinc' => false,
  ),
  'gzxz' => 
  array (
    'name' => 'gzxz',
    'type' => 'enum(\'全职\',\'兼职\',\'实习\')',
    'notnull' => false,
    'default' => '全职',
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
  'gzjy' => 
  array (
    'name' => 'gzjy',
    'type' => 'enum(\'经验不限\',\'1年以下\',\'1-3年\',\'5-10年\',\'10年以上\')',
    'notnull' => false,
    'default' => '经验不限',
    'primary' => false,
    'autoinc' => false,
  ),
  'jobid' => 
  array (
    'name' => 'jobid',
    'type' => 'set(\'环境好\',\'年终奖\',\'双休\',\'五险一金\',\'加班费\',\'朝九晚五\',\'交通方便\',\'加班补助\',\'包食宿\',\'管理规范\',\'有提成\',\'全勤奖\',\'有年假\',\'专车接送\',\'有补助\',\'晋升快\',\'车贴\',\'房贴\',\'压力小\',\'技术培训\',\'旅游\')',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'lianxi' => 
  array (
    'name' => 'lianxi',
    'type' => 'varchar(500)',
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
  'adress' => 
  array (
    'name' => 'adress',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'xingbie' => 
  array (
    'name' => 'xingbie',
    'type' => 'enum(\'不限\',\'男\',\'女\')',
    'notnull' => false,
    'default' => '不限',
    'primary' => false,
    'autoinc' => false,
  ),
  'nub' => 
  array (
    'name' => 'nub',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '0',
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
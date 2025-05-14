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
  'lianxiren' => 
  array (
    'name' => 'lianxiren',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'telphone' => 
  array (
    'name' => 'telphone',
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
  'qygm' => 
  array (
    'name' => 'qygm',
    'type' => 'enum(\'20人以下\',\'20-99人\',\'100-499人\',\'500-999人\',\'1000-9999人\',\'10000人以上\')',
    'notnull' => false,
    'default' => '20人以下',
    'primary' => false,
    'autoinc' => false,
  ),
  'qyrz' => 
  array (
    'name' => 'qyrz',
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
  'qyfl' => 
  array (
    'name' => 'qyfl',
    'type' => 'set(\'环境好\',\'年终奖\',\'双休\',\'五险一金\',\'加班费\',\'朝九晚五\',\'交通方便\',\'加班补助\',\'包食宿\',\'管理规范\',\'有提成\',\'全勤奖\',\'有年假\',\'专车接送\',\'有补助\',\'晋升快\',\'车贴\',\'房贴\',\'压力小\',\'技术培训\',\'旅游\')',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
);
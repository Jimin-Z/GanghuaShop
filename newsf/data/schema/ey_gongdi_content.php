<?php 
return array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'int(10)',
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
  'house_type' => 
  array (
    'name' => 'house_type',
    'type' => 'enum(\'独栋别墅\',\'联排别墅\',\'平层\',\'跃层\')',
    'notnull' => false,
    'default' => '独栋别墅',
    'primary' => false,
    'autoinc' => false,
  ),
  'area' => 
  array (
    'name' => 'area',
    'type' => 'enum(\'201~350㎡\',\'351~500㎡\',\'501~1000㎡\',\'1001㎡以上\')',
    'notnull' => false,
    'default' => '201~350㎡',
    'primary' => false,
    'autoinc' => false,
  ),
  'istatus' => 
  array (
    'name' => 'istatus',
    'type' => 'enum(\'进行中\',\'已完成\')',
    'notnull' => false,
    'default' => '进行中',
    'primary' => false,
    'autoinc' => false,
  ),
  'name' => 
  array (
    'name' => 'name',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'sj_area' => 
  array (
    'name' => 'sj_area',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'manager' => 
  array (
    'name' => 'manager',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'region' => 
  array (
    'name' => 'region',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'step1' => 
  array (
    'name' => 'step1',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'step1_date' => 
  array (
    'name' => 'step1_date',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'step2' => 
  array (
    'name' => 'step2',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'step2_date' => 
  array (
    'name' => 'step2_date',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'step3' => 
  array (
    'name' => 'step3',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'step3_date' => 
  array (
    'name' => 'step3_date',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'step4' => 
  array (
    'name' => 'step4',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'step4_date' => 
  array (
    'name' => 'step4_date',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'step5' => 
  array (
    'name' => 'step5',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'step5_date' => 
  array (
    'name' => 'step5_date',
    'type' => 'int(11)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'gongditu' => 
  array (
    'name' => 'gongditu',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
);
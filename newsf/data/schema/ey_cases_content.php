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
  'style' => 
  array (
    'name' => 'style',
    'type' => 'enum(\'新中式风格\',\'现代风格\',\'美式风格\',\'欧式风格\',\'法式风格\',\'新古典风格\',\'混搭风格\',\'轻奢风格\',\'极简风格\',\'日式风格\')',
    'notnull' => false,
    'default' => '新中式风格',
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
    'type' => 'enum(\'200㎡以下\',\'201~350㎡\',\'351~500㎡\',\'501~1000㎡\',\'1001㎡以上\')',
    'notnull' => false,
    'default' => '200㎡以下',
    'primary' => false,
    'autoinc' => false,
  ),
  'actual_area' => 
  array (
    'name' => 'actual_area',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'images' => 
  array (
    'name' => 'images',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'design' => 
  array (
    'name' => 'design',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'designer' => 
  array (
    'name' => 'designer',
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
);
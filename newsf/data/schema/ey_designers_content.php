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
    'type' => 'set(\'新中式风格\',\'现代风格\',\'美式风格\',\'欧式风格\',\'法式风格\',\'新古典风格\',\'混搭风格\',\'轻奢风格\',\'极简风格\',\'日式风格\')',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'house_type' => 
  array (
    'name' => 'house_type',
    'type' => 'set(\'独栋别墅\',\'联排别墅\',\'平层\',\'跃层\')',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'level' => 
  array (
    'name' => 'level',
    'type' => 'enum(\'设计院首席设计师\',\'事务所设计师\',\'工作室设计师\',\'资深首席设计师\',\'首席设计师\',\'高级设计师\',\'设计师\')',
    'notnull' => false,
    'default' => '设计院首席设计师',
    'primary' => false,
    'autoinc' => false,
  ),
  'position' => 
  array (
    'name' => 'position',
    'type' => 'text',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'experience' => 
  array (
    'name' => 'experience',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'index' => 
  array (
    'name' => 'index',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '5',
    'primary' => false,
    'autoinc' => false,
  ),
  'qualification' => 
  array (
    'name' => 'qualification',
    'type' => 'longtext',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'award' => 
  array (
    'name' => 'award',
    'type' => 'longtext',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'idea' => 
  array (
    'name' => 'idea',
    'type' => 'longtext',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
);
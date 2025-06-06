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
  'content' => 
  array (
    'name' => 'content',
    'type' => 'longtext',
    'notnull' => false,
    'default' => NULL,
    'primary' => false,
    'autoinc' => false,
  ),
  'department' => 
  array (
    'name' => 'department',
    'type' => 'enum(\'平台支撑部\',\'技术研发部\',\'业务部\')',
    'notnull' => false,
    'default' => '平台支撑部',
    'primary' => false,
    'autoinc' => false,
  ),
  'xinzi' => 
  array (
    'name' => 'xinzi',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'diqu' => 
  array (
    'name' => 'diqu',
    'type' => 'enum(\'南宁\')',
    'notnull' => false,
    'default' => '南宁',
    'primary' => false,
    'autoinc' => false,
  ),
  'sub_title' => 
  array (
    'name' => 'sub_title',
    'type' => 'varchar(500)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
);
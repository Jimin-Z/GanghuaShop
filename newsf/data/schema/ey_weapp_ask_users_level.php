<?php 
return array (
  'level_id' => 
  array (
    'name' => 'level_id',
    'type' => 'int(10) unsigned',
    'notnull' => false,
    'default' => NULL,
    'primary' => true,
    'autoinc' => true,
  ),
  'level_name' => 
  array (
    'name' => 'level_name',
    'type' => 'varchar(30)',
    'notnull' => false,
    'default' => '',
    'primary' => false,
    'autoinc' => false,
  ),
  'level_value' => 
  array (
    'name' => 'level_value',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'ask_count' => 
  array (
    'name' => 'ask_count',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '5',
    'primary' => false,
    'autoinc' => false,
  ),
  'answer_count' => 
  array (
    'name' => 'answer_count',
    'type' => 'int(10)',
    'notnull' => false,
    'default' => '0',
    'primary' => false,
    'autoinc' => false,
  ),
  'ask_is_release' => 
  array (
    'name' => 'ask_is_release',
    'type' => 'tinyint(1)',
    'notnull' => false,
    'default' => '1',
    'primary' => false,
    'autoinc' => false,
  ),
  'ask_is_review' => 
  array (
    'name' => 'ask_is_review',
    'type' => 'tinyint(1)',
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
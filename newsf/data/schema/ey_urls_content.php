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
  'pagePath' => 
  array (
    'name' => 'pagePath',
    'type' => 'enum(\'首页\',\'产品列表\',\'信息公开\',\'企业展播\',\'龙凤美景\',\'分销中心\',\'购物车\',\'个人中心\',\'领取优惠券\',\'新闻资讯\',\'签到中心\',\'地址管理\',\'积分商城\',\'砍价活动\',\'拼团活动\',\'我的收藏\',\'我的优惠券\',\'秒杀活动\',\'我的足迹\')',
    'notnull' => false,
    'default' => '首页',
    'primary' => false,
    'autoinc' => false,
  ),
);
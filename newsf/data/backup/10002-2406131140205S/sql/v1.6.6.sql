ALTER TABLE `ey_product_spec_data_handle` ADD COLUMN `handle_id`  int(10) NOT NULL AUTO_INCREMENT FIRST , ADD PRIMARY KEY (`handle_id`);
ALTER TABLE `ey_product_spec_data_handle` MODIFY COLUMN `spec_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '对应 product_spec_data 数据表' AFTER `spec_mark_id`;
ALTER TABLE `ey_product_spec_data_handle` MODIFY COLUMN `spec_value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '对应 product_spec_data 数据表' AFTER `spec_value_id`;
ALTER TABLE `ey_arctype` ADD COLUMN `total_arc`  int(10) NULL DEFAULT 0 COMMENT '栏目下文档数量' AFTER `page_limit`;
DELETE FROM `ey_channelfield` WHERE `channel_id` = '-99' AND `name` = 'total_arc';
INSERT INTO `ey_channelfield` (`name`, `channel_id`, `title`, `dtype`, `define`, `maxlength`, `dfvalue`, `dfvalue_unit`, `remark`, `is_screening`, `is_release`, `ifeditable`, `ifrequire`, `ifsystem`, `ifmain`, `ifcontrol`, `sort_order`, `status`, `add_time`, `update_time`, `set_type`) VALUES ('total_arc', '-99', '栏目下文档数量', 'int', 'int(10)', '10', '0', '', '', '0', '0', '1', '0', '1', '1', '1', '100', '1', '1711942240', '1711942240', '0');
ALTER TABLE `ey_form` ADD COLUMN `open_reply`  tinyint(1) NULL DEFAULT 0 COMMENT '是否开启回复 0-未开启,1-开启' AFTER `update_time`;
ALTER TABLE `ey_form` ADD COLUMN `open_examine`  tinyint(1) NULL DEFAULT 0 COMMENT '是否开启审核 0-不审核,1-审核' AFTER `open_reply`;
ALTER TABLE `ey_guestbook` ADD COLUMN `reply`  varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '留言回复内容' AFTER `update_time`;
ALTER TABLE `ey_guestbook` ADD COLUMN `admin_id`  int(11) NULL DEFAULT 0 COMMENT '回复管理员ID' AFTER `reply`;
ALTER TABLE `ey_guestbook` ADD COLUMN `reply_time`  int(11) NULL DEFAULT 0 COMMENT '回复时间' AFTER `admin_id`;
ALTER TABLE `ey_guestbook` ADD COLUMN `examine`  tinyint(1) NULL DEFAULT 1 COMMENT '0-未审核 1-审核通过 2-审核不通过' AFTER `reply_time`;
ALTER TABLE `ey_product_spec_data` MODIFY COLUMN `spec_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '规格名称' AFTER `spec_mark_id`;
ALTER TABLE `ey_product_spec_data` MODIFY COLUMN `spec_value`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '规格值' AFTER `spec_value_id`;
ALTER TABLE `ey_product_spec_value_handle` MODIFY COLUMN `spec_crossed_price`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '对应 product_spec_value 数据表' AFTER `spec_price`;
ALTER TABLE `ey_shop_order` ADD COLUMN `is_total_amount`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '订单是否已将实际支付金额(order表order_amount字段)累加到会员累计消费金额(users表order_total_amount字段) (0:未累计; 1:已累计;)' AFTER `order_total_num`;
UPDATE `ey_shop_order` SET `is_total_amount` = 9;
ALTER TABLE `ey_users` ADD COLUMN `order_total_amount`  decimal(10,2) UNSIGNED NULL DEFAULT 0.00 COMMENT '订单累计总额，用于会员自动升级。' AFTER `total_amount`;
ALTER TABLE `ey_users_level` ADD COLUMN `discount_type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '升级条件类型(0:不设置折扣; 1:自定义折扣)' AFTER `down_count`;
ALTER TABLE `ey_users_level` ADD COLUMN `upgrade_type`  tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '升级条件类型(0:不自动升级; 1:订单金额)' AFTER `ask_is_review`;
ALTER TABLE `ey_users_level` ADD COLUMN `upgrade_order_money`  decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '累计完成订单金额满多少自动升级成当前会员等级' AFTER `upgrade_type`;
ALTER TABLE `ey_users_level` ADD COLUMN `status`  tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '会员等级状态(0:禁用; 1:启用)' AFTER `upgrade_order_money`;
UPDATE `ey_users_menu` SET `active_url`='user/Users/index' WHERE `mca`='user/Users/index' AND `version` IN ('v2','v4');
ALTER TABLE `ey_users_menu` MODIFY COLUMN `mca`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '分组/控制器/操作名' AFTER `version`;
ALTER TABLE `ey_users_menu` ADD COLUMN `type`  tinyint(3) NULL DEFAULT 0 COMMENT '左侧菜单类型' AFTER `update_time`;
ALTER TABLE `ey_users_notice` MODIFY COLUMN `title`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '通知标题' AFTER `id`;
ALTER TABLE `ey_users_notice_tpl_content` ADD COLUMN `aid`  int(11) NULL DEFAULT 0 COMMENT '留言id' AFTER `update_time`;
INSERT INTO `ey_users_notice_tpl` (`tpl_name`, `tpl_title`, `tpl_content`, `send_scene`, `is_open`, `lang`, `add_time`, `update_time`) VALUES ('会员升级', '您有新的会员升级提醒！', '${content}', '21', '1', 'cn', '1710472930', '1710472930');

DROP TABLE IF EXISTS `ey_shop_goods_label`;
CREATE TABLE `ey_shop_goods_label` (
  `label_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `label_title` varchar(60) NOT NULL DEFAULT '' COMMENT '标签标题',
  `label_pic` varchar(250) NOT NULL DEFAULT '' COMMENT '标签路径',
  `label_intro` varchar(500) NOT NULL DEFAULT '' COMMENT '标签描述',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态(1:启用; 2:禁用)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`label_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商城商品服务标签';

INSERT INTO `ey_shop_goods_label` (`label_id`, `label_title`, `label_pic`, `label_intro`, `status`, `add_time`, `update_time`) VALUES ('1', '运费险', '/public/static/admin/images/fuwu1.png', '卖家为您购买的商品投保退货运费险（保单生效以确认订单页展示的运费险为准）', '1', '1701250984', '1702626503');
INSERT INTO `ey_shop_goods_label` (`label_id`, `label_title`, `label_pic`, `label_intro`, `status`, `add_time`, `update_time`) VALUES ('2', '货到付款', '/public/static/admin/images/fuwu2.png', '支持送货上门后再收款，支持现金、POS机刷卡等方式', '1', '1701250984', '1702626503');
INSERT INTO `ey_shop_goods_label` (`label_id`, `label_title`, `label_pic`, `label_intro`, `status`, `add_time`, `update_time`) VALUES ('3', '闪电退款', '/public/static/admin/images/fuwu3.png', '闪电退款为会员提供的快速退款服务', '1', '1701250984', '1702626503');
INSERT INTO `ey_shop_goods_label` (`label_id`, `label_title`, `label_pic`, `label_intro`, `status`, `add_time`, `update_time`) VALUES ('4', '7天无理由退货', '/public/static/admin/images/fuwu4.png', '支持7天无理由退货(拆封后不支持)', '1', '1701250984', '1702626503');

DROP TABLE IF EXISTS `ey_shop_goods_label_bind`;
CREATE TABLE `ey_shop_goods_label_bind` (
  `bind_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID(archives 表 aid 字段)',
  `label_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品服务标签ID(shop_goods_label 表 label_id 字段)',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '新增时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`bind_id`),
  KEY `aid` (`aid`) USING BTREE,
  KEY `label_id` (`label_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商城商品服务标签与商品ID关联绑定表';

DROP TABLE IF EXISTS `ey_wx_shipping_info`;
CREATE TABLE `ey_wx_shipping_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `users_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',
  `order_code` varchar(255) NOT NULL DEFAULT '' COMMENT '订单编号',
  `order_source` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单来源(1:会员普通充值订单; 2:会员商城商品订单; 3:会员升级订单; 8:会员视频订单; 20:会员套餐充值订单;)',
  `pay_success` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否支付成功(1:是; 0:否)',
  `pay_config` varchar(500) NOT NULL DEFAULT '' COMMENT '订单支付时所使用的支付配置信息(serialize存入，需unserialize解析)',
  `errcode` varchar(255) NOT NULL DEFAULT '' COMMENT '错误代码',
  `errmsg` varchar(255) NOT NULL DEFAULT '' COMMENT '错误提示',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信发货推送表';

DROP TABLE IF EXISTS `ey_wechat_template`;
CREATE TABLE `ey_wechat_template` (
  `tpl_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tpl_title` varchar(128) NOT NULL DEFAULT '' COMMENT '模板标题',
  `template_title` varchar(100) DEFAULT '' COMMENT '官方模板标题',
  `template_code` varchar(30) DEFAULT '' COMMENT '模板编号',
  `template_id` varchar(100) NOT NULL DEFAULT '' COMMENT '模板ID',
  `tpl_data` text NOT NULL COMMENT '模板内容序列化',
  `send_scene` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送场景',
  `is_open` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启使用这个模板，1为是，0为否。',
  `info` varchar(200) DEFAULT '' COMMENT '发送说明',
  `lang` varchar(50) DEFAULT 'cn' COMMENT '语言标识',
  `add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`tpl_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信公众号消息发送模板';

ALTER TABLE `ey_shop_express` MODIFY COLUMN `express_code`  varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '物流code（快递100）' AFTER `express_id`;
ALTER TABLE `ey_shop_express` ADD COLUMN `wx_delivery_id`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '微信快递编码' AFTER `update_time`;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YTO' WHERE `express_id` = 1;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STO' WHERE `express_id` = 2;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SF' WHERE `express_id` = 3;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YD' WHERE `express_id` = 4;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DBL' WHERE `express_id` = 5;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZTO' WHERE `express_id` = 6;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HTKY' WHERE `express_id` = 7;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YZPY' WHERE `express_id` = 8;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EMS' WHERE `express_id` = 9;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AOL' WHERE `express_id` = 11;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AAE' WHERE `express_id` = 13;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ANE' WHERE `express_id` = 14;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AX' WHERE `express_id` = 15;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AUEXPRESS' WHERE `express_id` = 16;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AXD' WHERE `express_id` = 17;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'AJ' WHERE `express_id` = 18;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ADD' WHERE `express_id` = 19;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'QDANTS' WHERE `express_id` = 21;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ASTEXPRESS' WHERE `express_id` = 22;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_AUSE' WHERE `express_id` = 24;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'APLUSEX' WHERE `express_id` = 26;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BCWELT' WHERE `express_id` = 31;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BALUNZHI' WHERE `express_id` = 32;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BQXHM' WHERE `express_id` = 33;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BFDF' WHERE `express_id` = 34;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BSWL' WHERE `express_id` = 35;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BKWL' WHERE `express_id` = 36;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BQC' WHERE `express_id` = 37;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BTWL' WHERE `express_id` = 39;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BETWL' WHERE `express_id` = 40;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BN' WHERE `express_id` = 41;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BNTWL' WHERE `express_id` = 43;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CUCKOOEXPRESS' WHERE `express_id` = 44;
UPDATE `ey_shop_express` SET `wx_delivery_id` = '360ZEBRA' WHERE `express_id` = 47;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BJXKY' WHERE `express_id` = 48;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BEIJINGFENGYUE' WHERE `express_id` = 49;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BEUROPE' WHERE `express_id` = 50;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BDT' WHERE `express_id` = 56;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BBFZY' WHERE `express_id` = 57;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'COE' WHERE `express_id` = 59;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CITY100' WHERE `express_id` = 61;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CXHY' WHERE `express_id` = 62;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CJKD' WHERE `express_id` = 63;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LJS' WHERE `express_id` = 64;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CKY' WHERE `express_id` = 65;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'NJSBWL' WHERE `express_id` = 66;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CG' WHERE `express_id` = 67;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CBO' WHERE `express_id` = 68;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CFWL' WHERE `express_id` = 74;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CUNTO' WHERE `express_id` = 75;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PARCELCHINA' WHERE `express_id` = 79;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CND' WHERE `express_id` = 81;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DHL_C' WHERE `express_id` = 84;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DHL_GLB' WHERE `express_id` = 85;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DHL_DE' WHERE `express_id` = 86;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DTWL' WHERE `express_id` = 87;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'D4PX' WHERE `express_id` = 88;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DYWL' WHERE `express_id` = 89;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DCWL' WHERE `express_id` = 90;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DSWL' WHERE `express_id` = 91;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'IDFWL' WHERE `express_id` = 93;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SAGAWA' WHERE `express_id` = 96;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YBWL' WHERE `express_id` = 100;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XYGJSD' WHERE `express_id` = 101;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DGYKD' WHERE `express_id` = 102;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DLG' WHERE `express_id` = 105;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DDWL' WHERE `express_id` = 107;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'DEKUN' WHERE `express_id` = 108;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EST365' WHERE `express_id` = 112;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EMS' WHERE `express_id` = 115;
UPDATE `ey_shop_express` SET `wx_delivery_id` = '007EX' WHERE `express_id` = 116;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EWE' WHERE `express_id` = 117;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EASYEX' WHERE `express_id` = 118;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FEDEX' WHERE `express_id` = 121;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'RFD' WHERE `express_id` = 124;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FKD' WHERE `express_id` = 125;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FBKD' WHERE `express_id` = 126;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FYPS' WHERE `express_id` = 128;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FCWL' WHERE `express_id` = 133;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CRAZY' WHERE `express_id` = 134;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FX' WHERE `express_id` = 135;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FTD' WHERE `express_id` = 136;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FZGJ' WHERE `express_id` = 137;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_LBZY' WHERE `express_id` = 138;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FREAKYQUICK' WHERE `express_id` = 139;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BEEBIRD' WHERE `express_id` = 142;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_FY' WHERE `express_id` = 143;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PANEX' WHERE `express_id` = 145;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GATICN' WHERE `express_id` = 146;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GTSEXPRESS' WHERE `express_id` = 147;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'NEDA' WHERE `express_id` = 149;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GSD' WHERE `express_id` = 150;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GTKD' WHERE `express_id` = 151;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STWL' WHERE `express_id` = 152;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GKSD' WHERE `express_id` = 153;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GTSD' WHERE `express_id` = 154;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GE2D' WHERE `express_id` = 158;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GTKY' WHERE `express_id` = 159;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CHTWL' WHERE `express_id` = 161;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SUNSHINE' WHERE `express_id` = 165;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TDHY' WHERE `express_id` = 166;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HLWL' WHERE `express_id` = 167;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HLYSD' WHERE `express_id` = 168;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HBJH' WHERE `express_id` = 169;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HQKY' WHERE `express_id` = 170;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HSWL' WHERE `express_id` = 171;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HHKD' WHERE `express_id` = 173;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_UCS' WHERE `express_id` = 175;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HJWL' WHERE `express_id` = 176;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SXHMJ' WHERE `express_id` = 178;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HFHW' WHERE `express_id` = 179;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HQSY' WHERE `express_id` = 184;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_HTONG' WHERE `express_id` = 185;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HPTEX' WHERE `express_id` = 186;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HHAIR56' WHERE `express_id` = 199;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HIVEWMS' WHERE `express_id` = 202;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HTWL' WHERE `express_id` = 203;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HSGTSD' WHERE `express_id` = 204;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_HDB' WHERE `express_id` = 207;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TCATCN' WHERE `express_id` = 209;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'IPARCEL' WHERE `express_id` = 212;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JIAJI' WHERE `express_id` = 213;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JYWL' WHERE `express_id` = 214;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JYM' WHERE `express_id` = 215;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JXD' WHERE `express_id` = 216;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JGSD' WHERE `express_id` = 217;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JYKD' WHERE `express_id` = 218;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JD' WHERE `express_id` = 219;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JTKD' WHERE `express_id` = 220;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JYSD' WHERE `express_id` = 221;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JIUYE' WHERE `express_id` = 222;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JGWL' WHERE `express_id` = 227;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KERRYLOGISTICS' WHERE `express_id` = 230;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JCEX' WHERE `express_id` = 232;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JAD' WHERE `express_id` = 235;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JFGJ' WHERE `express_id` = 237;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JXYKD' WHERE `express_id` = 238;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KLWL' WHERE `express_id` = 253;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KYSY' WHERE `express_id` = 254;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KYDSD' WHERE `express_id` = 255;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KSDWL' WHERE `express_id` = 257;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KFW' WHERE `express_id` = 259;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KBSY' WHERE `express_id` = 260;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'KUAIDAWULIU' WHERE `express_id` = 261;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FEDEX' WHERE `express_id` = 262;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LHT' WHERE `express_id` = 263;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LB' WHERE `express_id` = 264;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LJD' WHERE `express_id` = 265;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LHKD' WHERE `express_id` = 266;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LTIAN' WHERE `express_id` = 267;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LEDII' WHERE `express_id` = 269;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LYT' WHERE `express_id` = 273;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'BLUESKYEXPRESS' WHERE `express_id` = 274;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LHKDS' WHERE `express_id` = 276;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LHKDS' WHERE `express_id` = 279;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MHKD' WHERE `express_id` = 283;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'USEX' WHERE `express_id` = 284;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MDM' WHERE `express_id` = 285;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MLWL' WHERE `express_id` = 286;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MB' WHERE `express_id` = 287;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MSKD' WHERE `express_id` = 288;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MK' WHERE `express_id` = 291;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'VALUEWAY' WHERE `express_id` = 292;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'MRDY' WHERE `express_id` = 294;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'NFCM' WHERE `express_id` = 301;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EUASIA' WHERE `express_id` = 304;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PCA' WHERE `express_id` = 306;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PADTF' WHERE `express_id` = 307;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PXWL' WHERE `express_id` = 308;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'PAPA' WHERE `express_id` = 311;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UAPEX' WHERE `express_id` = 314;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'QRT' WHERE `express_id` = 315;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'QCKD' WHERE `express_id` = 316;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'QXT' WHERE `express_id` = 319;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CHINZ56' WHERE `express_id` = 321;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'VENUCIA' WHERE `express_id` = 322;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'IQTWL' WHERE `express_id` = 328;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'RLWL' WHERE `express_id` = 334;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'RFEX' WHERE `express_id` = 335;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'RRS' WHERE `express_id` = 336;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'RRS' WHERE `express_id` = 338;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GDRZ58' WHERE `express_id` = 339;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SURE' WHERE `express_id` = 342;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SDHH' WHERE `express_id` = 343;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SHWL' WHERE `express_id` = 344;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SFWL' WHERE `express_id` = 345;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SYKD' WHERE `express_id` = 346;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SDWL' WHERE `express_id` = 347;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STSD' WHERE `express_id` = 348;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SAD' WHERE `express_id` = 349;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SAWL' WHERE `express_id` = 351;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SXHMJ' WHERE `express_id` = 352;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SJWL' WHERE `express_id` = 353;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SYJHE' WHERE `express_id` = 354;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LDXPRESS' WHERE `express_id` = 355;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SUBIDA' WHERE `express_id` = 358;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SENDCN' WHERE `express_id` = 361;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STONG' WHERE `express_id` = 363;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'CHINASQK' WHERE `express_id` = 369;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SDSY' WHERE `express_id` = 373;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SCZPDS' WHERE `express_id` = 374;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GT' WHERE `express_id` = 375;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STO_INTL' WHERE `express_id` = 376;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SXEXPRESS' WHERE `express_id` = 378;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SQWL' WHERE `express_id` = 379;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SUPEROZ' WHERE `express_id` = 383;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FASTGO' WHERE `express_id` = 384;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SNWL' WHERE `express_id` = 386;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SDTO' WHERE `express_id` = 388;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ST' WHERE `express_id` = 389;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SX' WHERE `express_id` = 391;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'STKD' WHERE `express_id` = 392;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TNT' WHERE `express_id` = 393;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_TTHT' WHERE `express_id` = 394;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WHTZX' WHERE `express_id` = 396;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TAILAND138' WHERE `express_id` = 398;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TJS' WHERE `express_id` = 403;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_TM' WHERE `express_id` = 407;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_TY' WHERE `express_id` = 410;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'THAIZTO' WHERE `express_id` = 415;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'THAIZTO' WHERE `express_id` = 416;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'TAIMEK' WHERE `express_id` = 420;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UPS' WHERE `express_id` = 422;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UC' WHERE `express_id` = 423;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'USPS' WHERE `express_id` = 424;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UEQ' WHERE `express_id` = 425;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UEX' WHERE `express_id` = 426;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WTP' WHERE `express_id` = 429;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WJWL' WHERE `express_id` = 430;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'GSWTKD' WHERE `express_id` = 434;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WJK' WHERE `express_id` = 436;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WPE' WHERE `express_id` = 437;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'WTWL' WHERE `express_id` = 442;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XBWL' WHERE `express_id` = 446;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XFEX' WHERE `express_id` = 447;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XLYT' WHERE `express_id` = 449;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XLKD' WHERE `express_id` = 451;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XSRD' WHERE `express_id` = 452;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZY_XF' WHERE `express_id` = 456;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SUNSPEEDY' WHERE `express_id` = 457;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XYJ' WHERE `express_id` = 458;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XJ' WHERE `express_id` = 460;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'HQSY' WHERE `express_id` = 466;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XKGJ' WHERE `express_id` = 468;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'XDEXPRESS' WHERE `express_id` = 475;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YTKD' WHERE `express_id` = 476;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YCWL' WHERE `express_id` = 477;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YFSD' WHERE `express_id` = 478;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YSH' WHERE `express_id` = 479;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YFEX' WHERE `express_id` = 480;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YAD' WHERE `express_id` = 481;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YFHEX' WHERE `express_id` = 482;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YJSD' WHERE `express_id` = 483;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YTFH' WHERE `express_id` = 484;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YXWL' WHERE `express_id` = 485;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YTD' WHERE `express_id` = 486;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YBJ' WHERE `express_id` = 487;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YSKY' WHERE `express_id` = 489;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YLSY' WHERE `express_id` = 490;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YMWL' WHERE `express_id` = 492;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'LEOPARDSCHINA' WHERE `express_id` = 493;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YCSY' WHERE `express_id` = 504;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YZTSY' WHERE `express_id` = 507;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YUNDX' WHERE `express_id` = 511;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YBG' WHERE `express_id` = 512;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YLJY' WHERE `express_id` = 513;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'EKM' WHERE `express_id` = 514;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'UBONEX' WHERE `express_id` = 515;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YMSY' WHERE `express_id` = 516;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YTKD' WHERE `express_id` = 526;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YJD' WHERE `express_id` = 530;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YFSUYUN' WHERE `express_id` = 531;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'YMDD' WHERE `express_id` = 532;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZJS' WHERE `express_id` = 550;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZTWL' WHERE `express_id` = 551;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZTWL' WHERE `express_id` = 552;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZYWL' WHERE `express_id` = 553;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZZJH' WHERE `express_id` = 555;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZTWY' WHERE `express_id` = 557;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZWYSD' WHERE `express_id` = 559;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZENY' WHERE `express_id` = 560;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'SJ' WHERE `express_id` = 561;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZYQS' WHERE `express_id` = 566;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZO' WHERE `express_id` = 567;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZSKY' WHERE `express_id` = 568;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'A4PX' WHERE `express_id` = 571;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ESDEX' WHERE `express_id` = 574;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZHWL' WHERE `express_id` = 578;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'COSCO' WHERE `express_id` = 579;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZTOKY' WHERE `express_id` = 581;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZO' WHERE `express_id` = 582;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZYZOOM' WHERE `express_id` = 586;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZHONGHUAN' WHERE `express_id` = 590;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'ZHONGHUAN' WHERE `express_id` = 591;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'JTSD' WHERE `express_id` = 596;
UPDATE `ey_shop_express` SET `wx_delivery_id` = 'FWX' WHERE `express_id` = 599;

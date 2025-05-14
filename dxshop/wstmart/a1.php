 ADD COLUMN 
ALTER TABLE `ws_shop_users`

 ADD COLUMN  `privilegeMsgTypes` varchar(50) DEFAULT '',
 ADD COLUMN  `privilegeMsgs` varchar(200) DEFAULT '',
 ADD COLUMN  `privilegePhoneMsgs` varchar(200) DEFAULT ''
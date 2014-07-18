/*
Last edited on 2014/07/18 by Matt (matt@plantrbot.com)

SQL initialize database code to create MySQL table on the raspberrypi hosting the desktop application.

*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `DATA`
-- ----------------------------
DROP TABLE IF EXISTS `DATA`;
CREATE TABLE `DATA` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CREATED_ON` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `TEMP` decimal(4,2) DEFAULT NULL,
  `HUMIDITY` decimal(4,2) DEFAULT NULL,
  `LIGHT` int(11) DEFAULT NULL,
  `PUMPSTATE` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56989 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;

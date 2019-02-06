/*
 Navicat MySQL Data Transfer

 Source Server         : GNX Master DB - 1
 Source Server Type    : MySQL
 Source Server Version : 50535
 Source Host           : 37.235.32.75
 Source Database       : botretargeter

 Target Server Type    : MySQL
 Target Server Version : 50535
 File Encoding         : utf-8

 Date: 01/22/2016 00:33:42 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` varchar(100) NOT NULL DEFAULT '',
  `session_data` text NOT NULL,
  `expires` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `user_data`
-- ----------------------------
DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `added` varchar(20) DEFAULT NULL,
  `user_id` int(20) NOT NULL,
  `affiliate_id` varchar(10) NOT NULL,
  `account_type` varchar(20) DEFAULT 'standard',
  `allowed_sites` varchar(11) DEFAULT NULL,
  `avatar` varchar(300) DEFAULT 'img/avatar.png',
  PRIMARY KEY (`id`),
  KEY `index_userid` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

SET FOREIGN_KEY_CHECKS = 1;

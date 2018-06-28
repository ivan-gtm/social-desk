/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50635
 Source Host           : localhost
 Source Database       : instagram

 Target Server Type    : MySQL
 Target Server Version : 50635
 File Encoding         : utf-8

 Date: 06/09/2018 17:30:05 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `accounts`
-- ----------------------------
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `instagram_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `proxy` varchar(255) DEFAULT NULL,
  `login_required` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `accounts`
-- ----------------------------
BEGIN;
INSERT INTO `accounts` VALUES ('1', '1', '2147483647', 'outfit.expert', 'def502008ebf2f554977cee73a47fcd55c69a5fac09f21775c559c477d65d3a44cd40b0c25d2e96ff7a162102e16c01d95465b8e2c9961f1a7de676d42cfeda5c6ced1f046199b78d41afcbbd3106755d6e4e69f49868781d2fc795201a6', '', '0', '2018-06-09 22:00:11', '2018-06-09 00:00:00');
COMMIT;

-- ----------------------------
--  Table structure for `auto_comment_log`
-- ----------------------------
DROP TABLE IF EXISTS `auto_comment_log`;
CREATE TABLE `auto_comment_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `media_code` varchar(50) NOT NULL,
  `data` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  KEY `media_code` (`media_code`),
  CONSTRAINT `aclg_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `aclg_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auto_comment_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `auto_comment_schedule`;
CREATE TABLE `auto_comment_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `target` text NOT NULL,
  `comments` text NOT NULL,
  `speed` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `schedule_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `last_action_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `acschdl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `acschdl_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auto_like_log`
-- ----------------------------
DROP TABLE IF EXISTS `auto_like_log`;
CREATE TABLE `auto_like_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `data` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `allg_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `allg_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auto_like_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `auto_like_schedule`;
CREATE TABLE `auto_like_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `target` text NOT NULL,
  `speed` varchar(20) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `schedule_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `last_action_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `alschdl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `alschdl_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `captions`
-- ----------------------------
DROP TABLE IF EXISTS `captions`;
CREATE TABLE `captions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `captions`
-- ----------------------------
BEGIN;
INSERT INTO `captions` VALUES ('1', '1', 'Hi', 'SSS', '2018-06-09 18:15:34');
COMMIT;

-- ----------------------------
--  Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `info` text NOT NULL,
  `filename` varchar(200) NOT NULL,
  `filesize` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `general_data`
-- ----------------------------
DROP TABLE IF EXISTS `general_data`;
CREATE TABLE `general_data` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `options`
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `options`
-- ----------------------------
BEGIN;
INSERT INTO `options` VALUES ('1', 'np_video_processing', '1'), ('2', 'np_search_in_caption', '2');
COMMIT;

-- ----------------------------
--  Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data` varchar(1000) DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `paid` float DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `packages`
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `is_public` bit(1) DEFAULT NULL,
  `monthly_price` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `packages`
-- ----------------------------
BEGIN;
INSERT INTO `packages` VALUES ('1', 'Primero', b'1', '10');
COMMIT;

-- ----------------------------
--  Table structure for `plugins`
-- ----------------------------
DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idname` varchar(11) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `plugins`
-- ----------------------------
BEGIN;
INSERT INTO `plugins` VALUES ('1', 'auto-like', b'1'), ('3', 'auto-commen', b'1');
COMMIT;

-- ----------------------------
--  Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `is_scheduled` bit(1) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `schedule_date` datetime DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `first_comment` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `is_hidden` varchar(255) DEFAULT NULL,
  `remove_media` varchar(255) DEFAULT NULL,
  `media_ids` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `posts`
-- ----------------------------
BEGIN;
INSERT INTO `posts` VALUES ('1', '1', b'0', 'published', '2018-06-09 19:18:54', '1', '2018-06-09 19:19:13', '2018-06-09 19:18:54', 'timeline', '#tropical #dailyoutfit #outfitoftheday #outfits #inspiration #stylish #fashionable #trending #outfitideas #model #gree #green', '', '', '{\"upload_id\":\"1528571934296\",\"pk\":\"1798114298398399791\",\"id\":\"1798114298398399791_5887362383\",\"code\":\"Bj0L211ll0v\"}', '0', '0', '1');
COMMIT;

-- ----------------------------
--  Table structure for `proxies`
-- ----------------------------
DROP TABLE IF EXISTS `proxies`;
CREATE TABLE `proxies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proxy` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `use_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `package_subscription` varchar(255) DEFAULT NULL,
  `settings` varchar(500) DEFAULT NULL,
  `preferences` varchar(255) DEFAULT NULL,
  `is_active` bit(1) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'dagtok@gmail.com', 'Daniel', 'Gutierrez', null, 'user_5b1c027119ebf', 'admin', '$2y$10$1yj6YWpknkolmE1FHR58wuG.8Lrg85Q0KuP/y6uw0TTPBCinF3MnG', '1', '0', '{\"storage\":{\"total\":100,\"file\":100},\"max_accounts\":1,\"file_pickers\":{\"dropbox\":1,\"onedrive\":1,\"google_drive\":1},\"post_types\":{\"timeline_photo\":1,\"timeline_video\":1,\"story_photo\":1,\"story_video\":1,\"album_photo\":1,\"album_video\":1},\"spintax\":1,\"modules\":\"\"}', '{\"timezone\":\"America\\/Mexico_City\",\"dateformat\":\"Y-m-d\",\"timeformat\":\"24\"}', b'1', '2018-06-20 16:38:08', '2018-06-09 16:38:09', '{}');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;

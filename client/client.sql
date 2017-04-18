/*
Navicat MySQL Data Transfer

Source Server         : LocalHost
Source Server Version : 50548
Source Host           : localhost:3306
Source Database       : client

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2017-04-18 10:43:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `access_token`
-- ----------------------------
DROP TABLE IF EXISTS `access_token`;
CREATE TABLE `access_token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires_in` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of access_token
-- ----------------------------
INSERT INTO `access_token` VALUES ('1', 'rTfmW73KSwj6MyWgvS3EGGntPktKXeBBzFypJa3O', 'bearer', '1488184584', '3600', 'oW56O042lYnEqgtwxjoyiINwUI34HeXHWN6deyNP', '2017-02-25 22:13:13', '2017-02-27 15:36:25');
INSERT INTO `access_token` VALUES ('2', 'iLTvyTWbTrD6bfcnwi9pJj4Vc7bxbmmcBuZVMCRY', 'bearer', '1488035628', '3600', 'lM2kfHptbCCLZZ1YNV4MDMyYp5lVzS491hNPLrSq', '2017-02-25 22:13:49', '2017-02-25 22:13:49');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2017_02_25_211339_create_access_token_table', '1');

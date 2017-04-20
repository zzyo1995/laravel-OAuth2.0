-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-03-21 03:15:00
-- 服务器版本: 5.5.46-0ubuntu0.14.04.2
-- PHP 版本: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `oauthdb`
--

-- --------------------------------------------------------

--
-- 表的结构 `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applier_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `company`
--

INSERT INTO `company` (`id`, `name`, `email`, `address`, `phone`, `state`, `created_at`, `updated_at`, `reason`, `applier_id`) VALUES
(10, '中国科学院软件研究所总体部', 'iscas@iscas.ac.cn', '北京海淀区中关村南四街4号', '1', 1, '2016-01-20 18:15:18', '2016-01-20 18:15:18', '', 472),
(19, '总体部', 'zongtibu@iscas.ac.cn', '海淀中关村', '62668888', 1, '2016-01-25 11:42:19', '2016-01-25 11:42:19', '', 491),
(20, '上海中心', 'shanghai@iscas.ac.cn', '上海', '88886266', 2, '2016-01-25 12:29:55', '2016-01-25 12:29:55', '', 491),
(21, '55555555', 'jinxia@iscas.ac.cn', 'localhost', '100086', 1, '2016-01-27 16:30:45', '2016-01-27 16:30:45', '', 469),
(22, 'test', 'test@iacas.com', 'beijing', '010', 1, '2016-01-28 14:38:57', '2016-01-28 14:38:57', '', 4),
(23, 'liujinxiatest', 'jinxia@iscas.ac.cn', 'liujinxiat', '010-', 1, '2016-01-29 09:31:23', '2016-01-29 09:31:23', 'ok', 4),
(24, 'test224', '444@qq.com', 'bj', '2222', 1, '2016-02-24 10:55:54', '2016-02-24 10:55:54', 'test', 4),
(25, '2244', '2244@qq.com', '2244', '2244', 1, '2016-02-24 13:53:30', '2016-02-24 13:53:30', '', 4),
(26, 'gittt', 'gitt@qq.com', 'bj', '000', 1, '2016-02-24 14:08:10', '2016-02-24 14:08:10', '', 4),
(27, 'git', '7777@qq.com', 'bj', '010', 1, '2016-02-24 14:10:07', '2016-02-24 14:10:07', '', 4),
(28, 'git1414', '111@qq.com', 'bj', '010', 1, '2016-02-24 14:15:53', '2016-02-24 14:15:53', '', 4),
(29, 'gtilab1442', '1111@qq.com', 'beijing', '010', 1, '2016-02-24 14:42:39', '2016-02-24 14:42:39', '0', 4),
(30, 'jj', 'jj@qq.com', 'bb', '000', 1, '2016-02-24 16:40:16', '2016-02-24 16:40:16', '', 4),
(31, 'sdfdsf', '00@ee.com', '编辑', '123', 1, '2016-02-25 17:39:53', '2016-02-25 17:39:53', '', 498),
(32, 'gweg', 'admin@test.com', 'feeeee', '3232323', 1, '2016-02-26 09:17:11', '2016-02-26 09:17:11', '', 4),
(33, '111', '1111@qq.com', '111', '11', 1, '2016-02-29 16:43:49', '2016-02-29 16:43:49', '', 4),
(34, '即时通讯组', 'xiquan@iscas.ac.cn', '', '', 1, '2016-03-01 16:41:06', '2016-03-01 16:41:06', '', 467),
(35, '我的组织', 'weihong@iscas.ac.cn', '我的组织地址', '', 0, '2016-03-16 15:13:09', '2016-03-16 15:13:09', NULL, 817),
(36, '组の织', 'weihong@iscas.ac.cn', '组の织地址', '组の织Ｃｏｎ', 0, '2016-03-16 15:14:24', '2016-03-16 15:14:24', NULL, 817);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

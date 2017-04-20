-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016-02-01 15:23:13
-- 服务器版本: 5.5.47-0ubuntu0.14.04.1
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
-- 表的结构 `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `user_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `persistent` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`,`device_id`),
  KEY `active_users_device_id_foreign` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_apply`
--

CREATE TABLE IF NOT EXISTS `admin_apply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `state` int(11) DEFAULT '0',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `admin_user_id_foreign` (`user_id`),
  KEY `admin_company_id_foreign` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `client`
--

INSERT INTO `client` (`id`, `name`) VALUES
(1, 'secfile'),
(2, 'github');

-- --------------------------------------------------------

--
-- 表的结构 `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` int(11) DEFAULT '0',
  `reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `applier_id` int(10) unsigned NOT NULL,
  `phone` int(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name_unique` (`name`),
  KEY `company_applier_id_foreign` (`applier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `company_users`
--

CREATE TABLE IF NOT EXISTS `company_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `state` int(11) DEFAULT '0',
  `type` int(11) DEFAULT '0',
  `position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cu_user_id_foreign` (`user_id`),
  KEY `cu_company_id_foreign` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `secret` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `devices`
--

INSERT INTO `devices` (`id`, `secret`, `description`, `created_at`, `updated_at`) VALUES
(1, '$2y$10$DNy3qxkbXmvmM/M5R4OffuIezlNZn6HNjl5XTE9GDMc8l8aCtMf/G', 'Test device', '2014-02-17 21:08:02', '2014-02-17 21:08:02');

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `privileges` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `groups`
--

INSERT INTO `groups` (`id`, `name`, `privileges`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ordinary', 'basic', 'Normal users', '2014-02-17 21:08:02', '2014-02-17 21:08:02'),
(2, 'admin', 'basic|user|admin', 'administrators', '2014-02-25 02:47:50', '2014-02-25 02:47:50');

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_01_20_054001_create_users_table', 1),
('2014_02_13_025457_create_session_table', 1),
('2014_02_13_063706_create_groups_table', 1),
('2014_02_13_064636_create_active_users_table', 1),
('2014_02_13_070246_create_devices_table', 1),
('2014_02_13_074904_add_foreignkeys_to_users_table', 1),
('2014_02_13_074914_add_foreignkeys_to_active_users_table', 1),
('2013_07_24_132419_create_oauth_clients_table', 2),
('2013_07_24_133032_create_oauth_client_endpoints_table', 2),
('2013_07_24_133359_create_oauth_sessions_table', 2),
('2013_07_24_133833_create_oauth_session_access_tokens_table', 2),
('2013_07_24_134209_create_oauth_session_authcodes_table', 2),
('2013_07_24_134437_create_oauth_session_redirects_table', 2),
('2013_07_24_134700_create_oauth_session_refresh_tokens_table', 2),
('2013_07_24_135036_create_oauth_scopes_table', 2),
('2013_07_24_135250_create_oauth_session_token_scopes_table', 2),
('2013_07_24_135634_create_oauth_session_authcode_scopes_table', 2),
('2013_08_07_112010_create_oauth_grants_table', 2),
('2013_08_07_112252_create_oauth_client_grants_table', 2),
('2013_08_07_183251_create_oauth_client_scopes_table', 2),
('2013_08_07_183635_create_oauth_grant_scopes_table', 2),
('2013_08_07_183636_create_oauth_client_metadata_table', 2),
('2014_02_27_081311_create_password_reminders_table', 3),
('2014_12_24_112024_add_userinfo_to_users_table', 4);

-- --------------------------------------------------------

--
-- 表的结构 `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `oauth_clients_id_unique` (`id`),
  UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `created_at`, `updated_at`) VALUES
('1', '', 'secfile', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('asdf', 'JT0yctw0kMgYPneJ', 'asdf', '2014-05-26 00:39:35', '2014-05-26 00:39:35');

-- --------------------------------------------------------

--
-- 表的结构 `oauth_client_endpoints`
--

CREATE TABLE IF NOT EXISTS `oauth_client_endpoints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_endpoints_client_id_foreign` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_client_grants`
--

CREATE TABLE IF NOT EXISTS `oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_grants_client_id_foreign` (`client_id`),
  KEY `oauth_client_grants_grant_id_foreign` (`grant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_client_metadata`
--

CREATE TABLE IF NOT EXISTS `oauth_client_metadata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_client_metadata_cid_key_unique` (`client_id`,`key`),
  KEY `oauth_client_metadata_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_client_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_client_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_scopes_client_id_foreign` (`client_id`),
  KEY `oauth_client_scopes_scope_id_foreign` (`scope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `oauth_client_scopes`
--

INSERT INTO `oauth_client_scopes` (`id`, `client_id`, `scope_id`, `created_at`, `updated_at`) VALUES
(6, 'asdf', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `oauth_grants`
--

CREATE TABLE IF NOT EXISTS `oauth_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_grants_grant_unique` (`grant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_grant_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_grant_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_grant_scopes_grant_id_foreign` (`grant_id`),
  KEY `oauth_grant_scopes_scope_id_foreign` (`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `scope` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_scopes_scope_unique` (`scope`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `oauth_scopes`
--

INSERT INTO `oauth_scopes` (`id`, `scope`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'basic', 'basic scope', 'for test', '2014-02-18 05:11:47', '2014-02-18 05:11:47'),
(2, 'user', 'user scope', 'user operations', '2014-02-18 05:12:14', '2014-02-18 05:12:14');

-- --------------------------------------------------------

--
-- 表的结构 `oauth_sessions`
--

CREATE TABLE IF NOT EXISTS `oauth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1063 ;

--
-- 转存表中的数据 `oauth_sessions`
--

INSERT INTO `oauth_sessions` (`id`, `client_id`, `owner_type`, `owner_id`, `created_at`, `updated_at`) VALUES
(1062, 'asdf', 'client', 'asdf', '2014-09-22 01:13:35', '2014-09-22 01:13:35');

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_session_access_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_expires` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_session_access_tokens_access_token_session_id_unique` (`access_token`,`session_id`),
  KEY `oauth_session_access_tokens_session_id_index` (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1063 ;

--
-- 转存表中的数据 `oauth_session_access_tokens`
--

INSERT INTO `oauth_session_access_tokens` (`id`, `session_id`, `access_token`, `access_token_expires`, `created_at`, `updated_at`) VALUES
(1062, 1062, 'yPj7hCoAyQEiAxkK88zEOnbu6mzjn2lDKQhUJgWr', 1411352015, '2014-09-22 01:13:35', '2014-09-22 01:13:35');

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_authcodes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_authcodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `auth_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `auth_code_expires` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_session_authcodes_session_id_index` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_authcode_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_authcode_scopes` (
  `oauth_session_authcode_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `oauth_session_authcode_scopes_oauth_session_authcode_id_index` (`oauth_session_authcode_id`),
  KEY `oauth_session_authcode_scopes_scope_id_index` (`scope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_redirects`
--

CREATE TABLE IF NOT EXISTS `oauth_session_redirects` (
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_session_refresh_tokens` (
  `session_access_token_id` int(10) unsigned NOT NULL,
  `refresh_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `refresh_token_expires` int(11) NOT NULL,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`session_access_token_id`),
  KEY `oauth_session_refresh_tokens_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `oauth_session_token_scopes`
--

CREATE TABLE IF NOT EXISTS `oauth_session_token_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_access_token_id` int(10) unsigned NOT NULL,
  `scope_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_session_token_scopes_satid_sid_unique` (`session_access_token_id`,`scope_id`),
  KEY `oauth_session_token_scopes_scope_id_index` (`scope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1063 ;

--
-- 转存表中的数据 `oauth_session_token_scopes`
--

INSERT INTO `oauth_session_token_scopes` (`id`, `session_access_token_id`, `scope_id`, `created_at`, `updated_at`) VALUES
(1062, 1062, 1, '2014-09-22 01:13:35', '2014-09-22 01:13:35');

-- --------------------------------------------------------

--
-- 表的结构 `password_reminders`
--

CREATE TABLE IF NOT EXISTS `password_reminders` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reminders_email_index` (`email`),
  KEY `password_reminders_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `project_group`
--

CREATE TABLE IF NOT EXISTS `project_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `enname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `super_id` int(10) unsigned DEFAULT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name_unique` (`name`),
  KEY `group_company_id_foreign` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `project_group_member`
--

CREATE TABLE IF NOT EXISTS `project_group_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `project_group_id` int(10) unsigned NOT NULL,
  `type` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `member_user_id_foreign` (`user_id`),
  KEY `member_group_id_foreign` (`project_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `resource_servers`
--

CREATE TABLE IF NOT EXISTS `resource_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) DEFAULT '0',
  `reason` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `resource_servers`
--

INSERT INTO `resource_servers` (`id`, `name`, `password`, `status`, `reason`, `created_at`, `updated_at`) VALUES
(9, 'test1', '$2y$10$fAHkkqlgCnBMQBABmUXQD.8asJyIwtE.Dv03hgx1rzrHatCpUXvhO', 1, '测试资源服务器', '2014-09-17 16:50:24', '2014-09-17 16:50:24'),
(10, 'drivercenterserver', '$2y$10$CwLLem7lx0OAVFgUKbBirucB2dNq5XuiThF6KZOfOhYg0Q6GatbTG', 1, '', '2014-12-26 13:55:46', '2014-12-26 13:55:46');

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `sessions`
--

INSERT INTO `sessions` (`id`, `payload`, `last_activity`) VALUES
('9f1d34c0e452dbbcfdcc63440813b1e100db00ed', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaEp0TjlpVUhOTkY4U0g0ZEY4WFhGbDZjZGJ6SXpjRmhIcEdCcHAxNSI7czo1OiJmbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czozODoibG9naW5fODJlNWQyYzU2YmRkMDgxMTMxOGYwY2YwNzhiNzhiZmMiO3M6MToiNyI7czo5OiJfc2YyX21ldGEiO2E6Mzp7czoxOiJ1IjtpOjE0NTQzMTA3OTY7czoxOiJjIjtpOjE0NTMxNzQxNjc7czoxOiJsIjtzOjE6IjAiO319', 1454310796);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sex` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `portrait` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_group_id_foreign` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `group_id`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `sex`, `address`, `phone`, `portrait`) VALUES
(5, 2, 'Admin', 'admin', 'admin@test.com', '$2y$10$djVXPEP.mSDSrA0V/By4tuaMa/tcQ51ZBJrqSXHYe3xJHGVM8Ntj6', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, 'b6f69e2aa1a3a8c195d6ac1febde9fb0');

--
-- 限制导出的表
--

--
-- 限制表 `active_users`
--
ALTER TABLE `active_users`
  ADD CONSTRAINT `active_users_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`),
  ADD CONSTRAINT `active_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 限制表 `admin_apply`
--
ALTER TABLE `admin_apply`
  ADD CONSTRAINT `admin_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `admin_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 限制表 `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_applier_id_foreign` FOREIGN KEY (`applier_id`) REFERENCES `users` (`id`);

--
-- 限制表 `company_users`
--
ALTER TABLE `company_users`
  ADD CONSTRAINT `cu_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  ADD CONSTRAINT `cu_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 限制表 `oauth_client_endpoints`
--
ALTER TABLE `oauth_client_endpoints`
  ADD CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `oauth_client_grants`
--
ALTER TABLE `oauth_client_grants`
  ADD CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_client_metadata`
--
ALTER TABLE `oauth_client_metadata`
  ADD CONSTRAINT `oauth_client_metadata_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE;

--
-- 限制表 `oauth_client_scopes`
--
ALTER TABLE `oauth_client_scopes`
  ADD CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_grant_scopes`
--
ALTER TABLE `oauth_grant_scopes`
  ADD CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_sessions`
--
ALTER TABLE `oauth_sessions`
  ADD CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `oauth_session_access_tokens`
--
ALTER TABLE `oauth_session_access_tokens`
  ADD CONSTRAINT `oauth_session_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_session_authcodes`
--
ALTER TABLE `oauth_session_authcodes`
  ADD CONSTRAINT `oauth_session_authcodes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE;

--
-- 限制表 `oauth_session_authcode_scopes`
--
ALTER TABLE `oauth_session_authcode_scopes`
  ADD CONSTRAINT `oauth_session_authcode_scopes_oauth_session_authcode_id_foreign` FOREIGN KEY (`oauth_session_authcode_id`) REFERENCES `oauth_session_authcodes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_session_authcode_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE;

--
-- 限制表 `oauth_session_redirects`
--
ALTER TABLE `oauth_session_redirects`
  ADD CONSTRAINT `oauth_session_redirects_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_session_refresh_tokens`
--
ALTER TABLE `oauth_session_refresh_tokens`
  ADD CONSTRAINT `oauth_session_refresh_tokens_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `oauth_session_refresh_tokens_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `oauth_session_token_scopes`
--
ALTER TABLE `oauth_session_token_scopes`
  ADD CONSTRAINT `oauth_session_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `oauth_session_token_scopes_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- 限制表 `project_group`
--
ALTER TABLE `project_group`
  ADD CONSTRAINT `group_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

--
-- 限制表 `project_group_member`
--
ALTER TABLE `project_group_member`
  ADD CONSTRAINT `member_group_id_foreign` FOREIGN KEY (`project_group_id`) REFERENCES `project_group` (`id`),
  ADD CONSTRAINT `member_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 限制表 `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

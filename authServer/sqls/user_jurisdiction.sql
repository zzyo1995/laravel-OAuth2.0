--创建表 user_jurisdiction

CREATE TABLE IF NOT EXISTS `user_jurisdiction` (
  `user_id` int(10) NOT NULL,
  `miji` int(10) NOT NULL DEFAULT '1',
  `userstatus` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'active',
  `addadmin` int(5) NOT NULL DEFAULT '0',
  `usersjuris` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'user',
  `codejuris` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'guest',
  `users_jira_juris` varchar(32) CHARACTER SET latin1 NOT NULL DEFAULT 'user',
  `user_miji` int(10) NOT NULL DEFAULT '1',
  `secfile_type` int(32) NOT NULL DEFAULT '0',
  `gitlab_type` int(32) NOT NULL DEFAULT '0',
  `riochat_type` int(32) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--与表users保持一致性
INSERT INTO `user_jurisdiction`(`user_id`)  SELECT `id` FROM `users` ;



-- 已创建的表users
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--在表users后增加触发器，使之与表user_jurisdiction保持插入一致
--
DROP TRIGGER IF EXISTS `user_trigger` ;

CREATE TRIGGER `user_trigger` AFTER INSERT ON `users`
FOR EACH ROW INSERT INTO user_jurisdiction( user_id )
VALUES (new.id)
--

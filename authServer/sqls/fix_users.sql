
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_category` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'employee',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1458 ;


--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `delete_user_trigger`;
DELIMITER //
CREATE TRIGGER `delete_user_trigger` BEFORE DELETE ON `users`
 FOR EACH ROW BEGIN
DELETE FROM user_jurisdiction WHERE user_jurisdiction.user_id=old.id;
DELETE FROM project_group_member WHERE project_group_member.user_id=old.id;
DELETE FROM company_users WHERE company_users.user_id=old.id;
DELETE FROM admin_apply WHERE admin_apply.user_id=old.id;
DELETE FROM active_users WHERE active_users.user_id=old.id;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `user_trigger`;
DELIMITER //
CREATE TRIGGER `user_trigger` AFTER INSERT ON `users`
 FOR EACH ROW INSERT INTO user_jurisdiction( user_id )
VALUES (new.id)
//
DELIMITER ;



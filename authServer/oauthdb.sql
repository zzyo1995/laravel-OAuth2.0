CREATE TABLE `active_users` (
`user_id` int(10) NOT NULL,
`device_id` int(10) NOT NULL,
`persistent` tinyint(1) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`user_id`, `device_id`) ,
INDEX `active_users_device_id_foreign` (`device_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `admin_apply` (
`id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`company_id` int(10) NOT NULL,
`state` int(1) NOT NULL DEFAULT 0,
`reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `api_group` (
`id` int(11) NOT NULL,
`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`description` varchar(512) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `api_info` (
`id` int(11) NOT NULL,
`group_id` int(11) NOT NULL,
`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`url` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`method` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`params` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`success_response` varchar(512) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
`fail_response` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `company` (
`id` int(10) NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`state` int(1) NOT NULL DEFAULT 0,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`applier_id` int(10) NOT NULL,
PRIMARY KEY (`id`) ,
UNIQUE INDEX `company_name_unique` (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `company_users` (
`id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`company_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`state` int(1) NOT NULL DEFAULT 0,
`reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`position` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`type` int(1) NOT NULL DEFAULT 0,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `devices` (
`id` int(10) NOT NULL,
`secret` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`description` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `groups` (
`id` int(10) NOT NULL,
`name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`privileges` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`description` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `migrations` (
`migration` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`batch` int(11) NOT NULL
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_clients` (
`id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`secret` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`user_id` int(32) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
UNIQUE INDEX `oauth_clients_id_unique` (`id`),
UNIQUE INDEX `oauth_clients_id_secret_unique` (`id`, `secret`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_client_endpoints` (
`id` int(10) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`redirect_uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_client_endpoints_client_id_foreign` (`client_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_client_grants` (
`id` int(10) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`grant_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_client_grants_client_id_foreign` (`client_id`),
INDEX `oauth_client_grants_grant_id_foreign` (`grant_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_client_metadata` (
`id` int(10) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`key` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `oauth_client_metadata_cid_key_unique` (`client_id`, `key`),
INDEX `oauth_client_metadata_client_id_index` (`client_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_client_scopes` (
`id` int(10) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`scope_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_client_scopes_client_id_foreign` (`client_id`),
INDEX `oauth_client_scopes_scope_id_foreign` (`scope_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_grants` (
`id` int(10) NOT NULL,
`grant` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `oauth_grants_grant_unique` (`grant`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_grant_scopes` (
`id` int(10) NOT NULL,
`grant_id` int(10) NOT NULL,
`scope_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_grant_scopes_grant_id_foreign` (`grant_id`),
INDEX `oauth_grant_scopes_scope_id_foreign` (`scope_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_project_roles` (
`id` int(10) NOT NULL,
`value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NULL DEFAULT NULL,
`updated_at` timestamp NULL DEFAULT NULL,
PRIMARY KEY (`id`) ,
UNIQUE INDEX `name` (`value`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_roles` (
`id` int(10) NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`status` int(10) NOT NULL DEFAULT 1,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `name` (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_scopes` (
`id` int(10) NOT NULL,
`scope` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`status` int(10) NOT NULL DEFAULT 1,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `oauth_scopes_scope_unique` (`scope`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_scope_role` (
`id` int(10) NOT NULL,
`scope_id` int(10) NOT NULL,
`role_id` int(10) NOT NULL,
`status` int(10) NOT NULL DEFAULT 1,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `oauth_sessions` (
`id` int(10) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`owner_type` enum('client','user') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
`owner_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`, `owner_type`, `owner_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_access_tokens` (
`id` int(10) NOT NULL,
`session_id` int(10) NOT NULL,
`access_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`access_token_expires` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `oauth_session_access_tokens_access_token_session_id_unique` (`access_token`, `session_id`),
INDEX `oauth_session_access_tokens_session_id_index` (`session_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_authcodes` (
`id` int(10) NOT NULL,
`session_id` int(10) NOT NULL,
`auth_code` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`auth_code_expires` int(11) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
INDEX `oauth_session_authcodes_session_id_index` (`session_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_authcode_scopes` (
`oauth_session_authcode_id` int(10) NOT NULL,
`scope_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
INDEX `oauth_session_authcode_scopes_oauth_session_authcode_id_index` (`oauth_session_authcode_id`),
INDEX `oauth_session_authcode_scopes_scope_id_index` (`scope_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_redirects` (
`session_id` int(10) NOT NULL,
`redirect_uri` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`session_id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_refresh_tokens` (
`session_access_token_id` int(10) NOT NULL,
`refresh_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`refresh_token_expires` int(11) NOT NULL,
`client_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`session_access_token_id`) ,
INDEX `oauth_session_refresh_tokens_client_id_index` (`client_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `oauth_session_token_scopes` (
`id` int(10) NOT NULL,
`session_access_token_id` int(10) NOT NULL,
`scope_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) ,
UNIQUE INDEX `oauth_session_token_scopes_satid_sid_unique` (`session_access_token_id`, `scope_id`),
INDEX `oauth_session_token_scopes_scope_id_index` (`scope_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `password_reminders` (
`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
INDEX `password_reminders_email_index` (`email`),
INDEX `password_reminders_token_index` (`token`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `project_group` (
`id` int(10) NOT NULL,
`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`enname` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`englishname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`company_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`super_id` int(10) NULL DEFAULT NULL,
`leaf` int(10) NOT NULL DEFAULT 1,
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `project_group_member` (
`id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`project_group_id` int(10) NOT NULL,
`type` int(1) NOT NULL DEFAULT 0,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `resource_servers` (
`id` int(11) NOT NULL,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`status` int(11) NULL DEFAULT 0,
`reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
PRIMARY KEY (`id`) ,
UNIQUE INDEX `name` (`name`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `sessions` (
`id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`payload` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`last_activity` int(11) NOT NULL,
UNIQUE INDEX `sessions_id_unique` (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `task` (
`id` int(11) NOT NULL,
`code` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`enname` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`keyword` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`type` int(10) NOT NULL,
`description` varchar(225) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `task_company` (
`id` int(10) NOT NULL,
`task_id` int(10) NOT NULL,
`company_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `task_member` (
`id` int(10) NOT NULL,
`task_id` int(10) NOT NULL,
`user_id` int(10) NOT NULL,
`task_role` int(10) NOT NULL DEFAULT 0,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `task_project` (
`id` int(10) NOT NULL,
`task_id` int(10) NOT NULL,
`project_id` int(10) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT 'CURRENT_TIMESTAMP',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `users` (
`id` int(10) NOT NULL,
`group_id` int(10) NOT NULL,
`name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`username` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`user_category` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'employee',
`email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`sex` int(11) NULL DEFAULT NULL,
`address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`portrait` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
`remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`room_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
`extension_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (`id`) ,
UNIQUE INDEX `users_email_unique` (`email`),
INDEX `users_group_id_foreign` (`group_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_jurisdiction` (
`user_id` int(10) NOT NULL,
`miji` int(10) NOT NULL DEFAULT 1,
`userstatus` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'active',
`addadmin` int(5) NOT NULL DEFAULT 0,
`usersjuris` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user',
`codejuris` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'guest',
`users_jira_juris` varchar(32) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user',
`user_miji` int(10) NOT NULL DEFAULT 1,
`secfile_type` int(32) NOT NULL DEFAULT 0,
`gitlab_type` int(32) NOT NULL DEFAULT 0,
`riochat_type` int(32) NOT NULL DEFAULT 0,
PRIMARY KEY (`user_id`) ,
UNIQUE INDEX `user_id` (`user_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `active_users` ADD CONSTRAINT `active_users_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`);
ALTER TABLE `active_users` ADD CONSTRAINT `active_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `oauth_client_endpoints` ADD CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_client_grants` ADD CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_client_grants` ADD CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`);
ALTER TABLE `oauth_client_metadata` ADD CONSTRAINT `oauth_client_metadata_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_client_scopes` ADD CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_client_scopes` ADD CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`);
ALTER TABLE `oauth_grant_scopes` ADD CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`);
ALTER TABLE `oauth_grant_scopes` ADD CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`);
ALTER TABLE `oauth_sessions` ADD CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_session_access_tokens` ADD CONSTRAINT `oauth_session_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`);
ALTER TABLE `oauth_session_authcode_scopes` ADD CONSTRAINT `oauth_session_authcode_scopes_oauth_session_authcode_id_foreign` FOREIGN KEY (`oauth_session_authcode_id`) REFERENCES `oauth_session_authcodes` (`id`);
ALTER TABLE `oauth_session_authcode_scopes` ADD CONSTRAINT `oauth_session_authcode_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`);
ALTER TABLE `oauth_session_redirects` ADD CONSTRAINT `oauth_session_redirects_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`);
ALTER TABLE `oauth_session_refresh_tokens` ADD CONSTRAINT `oauth_session_refresh_tokens_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`);
ALTER TABLE `oauth_session_refresh_tokens` ADD CONSTRAINT `oauth_session_refresh_tokens_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`);
ALTER TABLE `oauth_session_token_scopes` ADD CONSTRAINT `oauth_session_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`);
ALTER TABLE `oauth_session_token_scopes` ADD CONSTRAINT `oauth_session_token_scopes_session_access_token_id_foreign` FOREIGN KEY (`session_access_token_id`) REFERENCES `oauth_session_access_tokens` (`id`);
ALTER TABLE `users` ADD CONSTRAINT `users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);


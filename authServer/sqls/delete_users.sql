
-- 数据库中与表users关联的表有user_jurisdiction,project_group_member,company_users,admin_apply,active_users.创建触发器,使之删除同步.

DROP TRIGGER IF EXISTS `delete_user_trigger` ;
CREATE TRIGGER `delete_user_trigger` BEFORE DELETE ON `users` FOR EACH ROW 
BEGIN 
DELETE FROM user_jurisdiction WHERE user_jurisdiction.user_id = old.id;
DELETE FROM project_group_member WHERE project_group_member.user_id = old.id;
DELETE FROM company_users WHERE company_users.user_id = old.id;
DELETE FROM admin_apply WHERE admin_apply.user_id = old.id;
DELETE FROM active_users WHERE active_users.user_id = old.id;
END

-- 删除表users中无关用户
DELETE FROM users WHERE (group_id <> 2 AND email NOT LIKE '%iscas.ac.cn');



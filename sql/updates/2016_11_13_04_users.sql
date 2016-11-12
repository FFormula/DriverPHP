-- ----------------------------
-- Check for update sequence
-- ----------------------------
ALTER TABLE `db_version`
CHANGE COLUMN `required_2016_11_13_03_db_version` `required_2016_11_13_04_users` bit;

-- ----------------------------
-- Updates for users
-- ----------------------------
LOCK TABLES `users` WRITE;
ALTER TABLE `users`
ADD COLUMN `failed_logins` int(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `park`;
UNLOCK TABLES;

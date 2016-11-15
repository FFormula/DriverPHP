-- ----------------------------
-- Check for update sequence
-- ----------------------------
ALTER TABLE `db_version`
CHANGE COLUMN `required_2016_11_13_04_users` `required_2016_11_16_01_users` bit;

-- ----------------------------
-- Updates for users
-- ----------------------------
LOCK TABLES `users` WRITE;
INSERT INTO `users` (`name`, `email`, `password`, `status`) VALUES
('superadmin', 'superadmin@gmail.com', 'qwas', 3),
('guest', 'guest@gmail.com', 'qwas', 0);
UNLOCK TABLES;

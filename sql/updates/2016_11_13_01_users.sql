-- ----------------------------
-- Updates for users
-- ----------------------------
LOCK TABLES `users` WRITE;
ALTER TABLE `users`
ADD COLUMN `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `password`,
ADD COLUMN `park` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `phone`;
UNLOCK TABLES;


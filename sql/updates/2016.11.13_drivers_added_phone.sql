-- ----------------------------
-- Updates for drivers
-- ----------------------------
LOCK TABLES `drivers` WRITE;
ALTER TABLE `drivers`
ADD COLUMN `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `passport_number`;
UNLOCK TABLES;

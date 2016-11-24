-- ----------------------------
-- Check for update sequence
-- ----------------------------
ALTER TABLE `db_version`
CHANGE COLUMN `required_2016_11_16_01_users` `required_2016_11_17_drivers` bit;

-- ----------------------------
-- Updates for drivers
-- ----------------------------
LOCK TABLES `drivers` WRITE;
ALTER TABLE `drivers`
ADD COLUMN `license_serial` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `passport_number`,
ADD COLUMN `license_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `license_serial`;
UNLOCK TABLES;

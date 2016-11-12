-- ----------------------------
-- Drop tables in correct sequence if exists
-- ----------------------------
DROP TABLE IF EXISTS `db_version`;

-- ----------------------------
-- Table structure for `db_version`
-- ----------------------------
CREATE TABLE `db_version` (
  `required_2016_11_13_03_db_version` bit(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=FIXED COMMENT='Последний добавленный в БД файл sql';

-- ----------------------------
-- Records of db_version
-- ----------------------------
LOCK TABLES `db_version` WRITE;
INSERT INTO `db_version` VALUES (NULL);
UNLOCK TABLES;

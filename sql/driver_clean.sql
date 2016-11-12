-- ----------------------------
-- Drop tables in correct sequence if exists
-- ----------------------------
DROP TABLE IF EXISTS `docs`;
DROP TABLE IF EXISTS `drivers`;
DROP TABLE IF EXISTS `users`;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Список пользователей системы';

-- ----------------------------
-- Table structure for `drivers`
-- ----------------------------
CREATE TABLE `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `passport_serial` varchar(255) DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 - drop, 1 - to check, 2 - approved',
  `info` text,
  PRIMARY KEY (`id`),
  KEY `FK_drivers_users` (`user_id`),
  CONSTRAINT `FK_drivers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Список водителей';

-- ----------------------------
-- Table structure for `docs`
-- ----------------------------
CREATE TABLE `docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `info` text COMMENT 'Тип документа и комментарий',
  PRIMARY KEY (`id`),
  KEY `FK_docs_drivers` (`driver_id`),
  CONSTRAINT `FK_docs_drivers` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Список прикреплённых файлов-документов';

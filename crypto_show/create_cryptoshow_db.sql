SET FOREIGN_KEY_CHECKS=0;
DROP DATABASE IF EXISTS cryptoshow_db;
CREATE DATABASE cryptoshow_db;
USE cryptoshow_db;

GRANT SELECT, INSERT, UPDATE, DELETE on cryptoshow_db.* TO cryptoshowuser@localhost IDENTIFIED BY 'cryptoshowpass';

-- ----------------------------
-- Table structure for `registered_user`
-- ----------------------------
DROP TABLE IF EXISTS `registered_user`;
CREATE TABLE `registered_user` (
   `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `user_nickname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `user_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `user_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `user_hashed_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
   `user_machine_count` tinyint(3) unsigned NOT NULL DEFAULT '0',
   `user_registered_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `crypto_machine`
-- ----------------------------
DROP TABLE IF EXISTS `crypto_machine`;
CREATE TABLE `crypto_machine` (
  `crypto_machine_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fk_user_id` int(10) unsigned NOT NULL,
  `crypto_machine_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_machine_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_machine_description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_machine_image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_machine_country_of_origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `crypto_machine_record_visible` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`crypto_machine_id`),
  KEY `fk_user_id` (`fk_user_id`),
  CONSTRAINT `crypto_machine_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `registered_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for `cryptoshow_error_log`
-- ----------------------------
DROP TABLE IF EXISTS `cryptoshow_error_log`;
CREATE TABLE `cryptoshow_error_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_message` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

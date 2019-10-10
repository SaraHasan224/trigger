-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_street` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_state` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_zip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_street` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_state` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_zip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_emp` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line_of_business` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `claim_desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `AddedBy` int(11) DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2019-07-25 16:08:58

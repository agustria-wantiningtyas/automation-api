-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5445
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for elabram_payroll
CREATE DATABASE IF NOT EXISTS `elabram_payroll` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `elabram_payroll`;

-- Dumping structure for table elabram_payroll.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_code` varchar(50) NOT NULL,
  `cus_name` varchar(100) NOT NULL,
  `cus_pic` varchar(50) DEFAULT NULL,
  `cus_address` text,
  `cus_city` varchar(50) DEFAULT NULL,
  `cus_phone` varchar(20) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `cus_status` enum('Y','N') DEFAULT 'Y',
  `cus_description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table elabram_payroll.customer: ~0 rows (approximately)
DELETE FROM `customer`;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table elabram_payroll.employee
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table elabram_payroll.employee: ~12 rows (approximately)
DELETE FROM `employee`;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` (`id`, `name`, `gender`, `no_telp`, `email`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
	(1, 'user one', 'M', '081221986259', 'user@mail.com', 'Y', '2019-01-07 14:37:35', NULL, NULL, NULL, NULL, NULL),
	(2, 'gfh', '', 'vcb', 'vcbn', 'N', '2019-01-09 15:10:26', NULL, NULL, NULL, '2019-01-09 15:11:39', 1),
	(3, 'aku', 'M', '0811111111111', 'aku@mail.com', 'Y', '2019-01-09 16:45:20', NULL, NULL, NULL, NULL, NULL),
	(4, 'DiaKamu', 'F', '08888888888883', 'diaKamu@mail.com', 'Y', '2019-01-09 16:50:45', NULL, '2019-01-10 09:37:11', 1, NULL, NULL),
	(5, 'dfgvf', 'F', '8765r4', 'ffff@mail.com', 'N', '2019-01-09 16:59:54', NULL, NULL, NULL, '2019-01-09 17:28:18', 1),
	(6, 'sss', 'M', '0987654', 'sss@mail.com', 'Y', '2019-01-10 16:23:58', NULL, NULL, NULL, NULL, NULL),
	(7, 'sss', 'M', '0987654', 'sss@mail.com', 'N', '2019-01-10 16:27:03', NULL, NULL, NULL, '2019-01-10 16:41:56', 1),
	(8, 'sss', 'M', '08111112226', 'sss@mail.com', 'N', '2019-01-10 16:32:30', NULL, NULL, NULL, '2019-01-10 16:41:53', 1),
	(9, 'ss', 'M', '098765', 'ss@mail.com', 'N', '2019-01-10 16:38:37', NULL, NULL, NULL, '2019-01-10 16:41:47', 1),
	(10, 'ssss', 'M', '0987654', 'ssss@mail.com', 'N', '2019-01-10 16:39:49', NULL, NULL, NULL, '2019-01-10 16:41:44', 1),
	(11, 'wwww', 'M', '098765', 'wwww@mail.com', 'N', '2019-01-10 16:40:50', NULL, NULL, NULL, '2019-01-10 16:41:41', 1),
	(12, 'yyyyyy', 'M', '081221986259', 'yyyyy@mail.com', 'Y', '2019-01-10 16:42:27', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

-- Dumping structure for table elabram_payroll.menu_access
CREATE TABLE IF NOT EXISTS `menu_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(55) NOT NULL,
  `menu_id` int(55) NOT NULL,
  `access_add` int(11) DEFAULT '1' COMMENT '0: inactive, 1: active',
  `active` int(11) DEFAULT '0' COMMENT '0: inactive, 1: active',
  `access_edit` int(11) DEFAULT '1' COMMENT '0: inactive, 1: active',
  `access_view` int(11) DEFAULT '1' COMMENT '0: inactive, 1: active',
  `access_delete` int(11) DEFAULT '1' COMMENT '0: inactive, 1: active',
  `access_approve` int(11) DEFAULT '1' COMMENT '0: inactive, 1: active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table elabram_payroll.menu_access: 3 rows
DELETE FROM `menu_access`;
/*!40000 ALTER TABLE `menu_access` DISABLE KEYS */;
INSERT INTO `menu_access` (`id`, `user_id`, `menu_id`, `access_add`, `active`, `access_edit`, `access_view`, `access_delete`, `access_approve`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
	(1, 1, 2, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:16', NULL, NULL),
	(2, 1, 3, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(3, 1, 4, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL);
/*!40000 ALTER TABLE `menu_access` ENABLE KEYS */;

-- Dumping structure for table elabram_payroll.menu_setting
CREATE TABLE IF NOT EXISTS `menu_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0: inactive : 1: active',
  `order` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `routerLinkActive` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mMenuLinkRedirect` varchar(50) COLLATE utf8_unicode_ci DEFAULT '1',
  `mMenuSubmenuToggle` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table elabram_payroll.menu_setting: 4 rows
DELETE FROM `menu_setting`;
/*!40000 ALTER TABLE `menu_setting` DISABLE KEYS */;
INSERT INTO `menu_setting` (`id`, `parent_id`, `status`, `order`, `path`, `title`, `icon`, `class`, `routerLinkActive`, `mMenuLinkRedirect`, `mMenuSubmenuToggle`, `created_at`, `updated_at`) VALUES
	(1, 0, '1', 2, '/dashboard', 'Dashboard', 'dashboard', 'm-menu__item', 'm-menu__item--active', '1', '', NULL, NULL),
	(2, 0, '1', 1, '', 'Master Data', 'master_data', 'm-menu__item  m-menu__item--submenu', 'm-menu__item--open', '1', '', NULL, NULL),
	(3, 2, '0', 1, '/master-data/employee', 'Employee', '', '', 'm-menu__item--active', '1', '', NULL, NULL),
	(4, 2, '1', 2, '/master-data/customer', 'Customer configuration', '', '', 'm-menu__item--active', '1', '', NULL, NULL);
/*!40000 ALTER TABLE `menu_setting` ENABLE KEYS */;

-- Dumping structure for table elabram_payroll.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `token` varchar(100) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'N:Non Active, Y: Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table elabram_payroll.user: ~2 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `emp_id`, `email`, `password`, `token`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'user@mail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '1KQPW7LL7pG6k6ZvHhP4PMKXAwsWYmJ7b1t7HzSXY', 'Y', '2019-01-10 16:39:24', '2019-01-07 21:53:29'),
	(2, 12, 'yyyyy@mail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '', 'Y', '2019-01-10 16:42:27', '2019-01-10 16:42:27');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

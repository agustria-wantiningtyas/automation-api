-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for db_automation
CREATE DATABASE IF NOT EXISTS `db_automation` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_automation`;

-- Dumping structure for table db_automation.customer
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

-- Dumping data for table db_automation.customer: ~0 rows (approximately)
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;

-- Dumping structure for table db_automation.employee
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.employee: ~12 rows (approximately)
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
	(12, 'yyyyyy', 'M', '081221986259', 'yyyyy@mail.com', 'Y', '2019-01-10 16:42:27', NULL, NULL, NULL, NULL, NULL),
	(13, 'Agustria W', 'M', '', 'agustriatyas@gmail.com', 'Y', '2019-04-14 10:05:30', NULL, NULL, NULL, NULL, NULL),
	(14, 'sdgsg', 'M', '', 'sdf@mail.com', 'Y', '2019-04-14 10:13:44', NULL, NULL, NULL, NULL, NULL),
	(15, 'nama', 'M', '', 'email', 'Y', '2019-06-23 14:01:18', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;

-- Dumping structure for table db_automation.menu_access
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_automation.menu_access: 7 rows
/*!40000 ALTER TABLE `menu_access` DISABLE KEYS */;
INSERT INTO `menu_access` (`id`, `user_id`, `menu_id`, `access_add`, `active`, `access_edit`, `access_view`, `access_delete`, `access_approve`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
	(1, 1, 2, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:16', NULL, NULL),
	(2, 1, 3, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(3, 1, 4, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(4, 1, 5, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(5, 1, 6, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(6, 1, 7, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL),
	(7, 1, 8, 1, 1, 1, 1, 1, 1, NULL, '2019-01-07 15:17:24', NULL, NULL);
/*!40000 ALTER TABLE `menu_access` ENABLE KEYS */;

-- Dumping structure for table db_automation.menu_setting
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_automation.menu_setting: 8 rows
/*!40000 ALTER TABLE `menu_setting` DISABLE KEYS */;
INSERT INTO `menu_setting` (`id`, `parent_id`, `status`, `order`, `path`, `title`, `icon`, `class`, `routerLinkActive`, `mMenuLinkRedirect`, `mMenuSubmenuToggle`, `created_at`, `updated_at`) VALUES
	(1, 0, '1', 2, '/dashboard', 'Dashboard', 'dashboard', 'm-menu__item', 'm-menu__item--active', '1', '', NULL, NULL),
	(2, 0, '1', 2, '', 'Setting', 'master_data', 'm-menu__item  m-menu__item--submenu', 'm-menu__item--open', '1', '', NULL, NULL),
	(3, 0, '1', 1, '/run-test', 'Run Test', 'task_assignment', 'm-menu__item', 'm-menu__item--active', '1', '', NULL, NULL),
	(4, 2, '0', 1, '/setting/user', 'User', '', '', 'm-menu__item--active', '1', '', NULL, NULL),
	(5, 2, '1', 3, '/setting/test-case', 'Test Case', '', '', 'm-menu__item--active', '1', '', NULL, NULL),
	(6, 2, '0', 2, '/setting/feature', 'Feature', '', '', 'm-menu__item--active', '1', '', NULL, NULL),
	(7, 0, '1', 4, '/report', 'Report', 'report', 'm-menu__item', 'm-menu__item--active', '1', '', NULL, NULL),
	(8, 0, '0', 5, '/logout', 'Logout', 'logout', 'm-menu__item', 'm-menu__item--active', '1', '', NULL, NULL);
/*!40000 ALTER TABLE `menu_setting` ENABLE KEYS */;

-- Dumping structure for table db_automation.tm_feature
CREATE TABLE IF NOT EXISTS `tm_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.tm_feature: ~2 rows (approximately)
/*!40000 ALTER TABLE `tm_feature` DISABLE KEYS */;
INSERT INTO `tm_feature` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Kupon', 'Y', '2019-04-09 21:19:15', NULL),
	(2, 'Tiket', 'Y', '2019-04-09 21:19:51', NULL),
	(3, 'hihii', 'N', '2019-04-09 14:47:38', '2019-04-09 22:05:31');
/*!40000 ALTER TABLE `tm_feature` ENABLE KEYS */;

-- Dumping structure for table db_automation.tm_role
CREATE TABLE IF NOT EXISTS `tm_role` (
  `id` int(11) DEFAULT NULL,
  `name` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.tm_role: ~0 rows (approximately)
/*!40000 ALTER TABLE `tm_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_role` ENABLE KEYS */;

-- Dumping structure for table db_automation.tm_test_case
CREATE TABLE IF NOT EXISTS `tm_test_case` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `feature_id` int(11) DEFAULT NULL,
  `path_env` varchar(100) DEFAULT 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/',
  `path_url` varchar(100) DEFAULT 'http://localhost:81/automation-app/automation-rf/Tests/Web/',
  `status` enum('Y','N') DEFAULT 'Y',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.tm_test_case: ~15 rows (approximately)
/*!40000 ALTER TABLE `tm_test_case` DISABLE KEYS */;
INSERT INTO `tm_test_case` (`id`, `user_id`, `name`, `feature_id`, `path_env`, `path_url`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'lalala', 1, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-04-11 21:30:58', NULL),
	(2, 1, 'fdfdf', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-04-13 03:31:20', NULL),
	(3, 1, 'hyyhrfrw', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'N', '2019-04-13 03:35:09', '2019-04-13 10:40:33'),
	(4, 1, 'Coupon Search by Location', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-04-14 02:38:47', '2019-04-14 09:43:20'),
	(5, 3, 'Login', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-04-14 03:57:31', '2019-06-23 13:47:36'),
	(6, 1, 'Login', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-22 13:28:52', NULL),
	(7, 3, 'Coupon Search', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:47:50', NULL),
	(8, 3, 'Coupon Search by Location', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:48:05', '2019-06-23 13:48:36'),
	(9, 3, 'Product Category', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:48:15', '2019-06-23 13:49:42'),
	(10, 3, 'Best Seller', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:49:49', NULL),
	(11, 3, 'Popular Merchant', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:50:07', NULL),
	(12, 3, 'Filter', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:50:14', NULL),
	(13, 3, 'Transaction', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:50:21', NULL),
	(14, 3, 'All Test', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 06:50:36', NULL),
	(15, 1, 'Kupon', NULL, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/', 'http://localhost:81/automation-app/automation-rf/Tests/Web/', 'Y', '2019-06-23 09:50:49', NULL);
/*!40000 ALTER TABLE `tm_test_case` ENABLE KEYS */;

-- Dumping structure for table db_automation.tm_user
CREATE TABLE IF NOT EXISTS `tm_user` (
  `id` int(11) DEFAULT NULL,
  `name` int(11) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `email` int(11) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `token` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.tm_user: ~0 rows (approximately)
/*!40000 ALTER TABLE `tm_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `tm_user` ENABLE KEYS */;

-- Dumping structure for table db_automation.t_feature_access
CREATE TABLE IF NOT EXISTS `t_feature_access` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feature_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.t_feature_access: ~0 rows (approximately)
/*!40000 ALTER TABLE `t_feature_access` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_feature_access` ENABLE KEYS */;

-- Dumping structure for table db_automation.t_run_history
CREATE TABLE IF NOT EXISTS `t_run_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_case_id` int(11) DEFAULT NULL,
  `path_url` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.t_run_history: ~23 rows (approximately)
/*!40000 ALTER TABLE `t_run_history` DISABLE KEYS */;
INSERT INTO `t_run_history` (`id`, `test_case_id`, `path_url`, `created_at`, `updated_at`) VALUES
	(1, 1, 'file:///E:/TYAS/Phoenix/Tests/Web/a_Login/report.html', '2019-04-13 11:21:24', NULL),
	(2, 2, 'https://onlineradiobox.com/id/genjakarta/?cs=id.genjakarta&played=1', '2019-04-27 12:02:30', NULL),
	(3, 4, 'gfdg', '2019-04-27 12:02:42', NULL),
	(4, 4, '', '2019-04-28 01:13:18', NULL),
	(5, 4, '', '2019-04-28 05:15:24', NULL),
	(6, 0, '', '2019-04-28 06:48:45', NULL),
	(7, 1, '', '2019-04-28 06:49:11', NULL),
	(8, 1, '', '2019-04-28 06:50:02', NULL),
	(9, 5, NULL, '2019-05-02 21:56:34', NULL),
	(10, 6, '', '2019-06-23 09:42:14', NULL),
	(11, 6, '', '2019-06-23 09:44:36', NULL),
	(12, 6, '', '2019-06-23 09:47:28', NULL),
	(13, 4, '', '2019-06-23 10:00:53', NULL),
	(14, 15, '', '2019-06-23 10:15:40', NULL),
	(15, 6, '', '2019-06-23 10:23:01', NULL),
	(16, 1, '', '2019-06-23 10:42:15', NULL),
	(17, 15, '', '2019-06-23 10:45:35', NULL),
	(18, 2, 'jeje_abdul_tria', '2019-06-23 11:32:42', NULL),
	(19, 4, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/fdsgrt/report.html', '2019-06-23 11:33:35', NULL),
	(20, 4, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report.html', '2019-06-23 11:34:20', NULL),
	(21, 4, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report.html', '2019-06-23 11:58:23', NULL),
	(22, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report.html', '2019-06-23 12:27:48', NULL),
	(23, 4, 'C:/xampp/htdocs/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report.html', '2019-06-23 12:42:51', NULL),
	(24, 6, 'http://localhost:81/automation-app/automation-rf/Tests/Web/login/report.html', '2019-06-23 13:03:28', NULL),
	(25, 6, 'http://localhost:81/automation-app/automation-rf/Tests/Web/login/report.html', '2019-06-23 13:09:07', NULL),
	(26, 6, 'http://localhost:81/automation-app/automation-rf/Tests/Web/login/report_26/report.html', '2019-06-23 13:30:30', NULL),
	(27, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_27/report.html', '2019-06-23 13:33:54', NULL),
	(28, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_28/report.html', '2019-06-23 13:36:49', NULL),
	(29, 6, 'http://localhost:81/automation-app/automation-rf/Tests/Web/login/report_29/report.html', '2019-06-23 13:42:24', NULL),
	(30, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_30/report.html', '2019-06-23 13:46:53', NULL),
	(31, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_31/report.html', '2019-06-23 13:55:11', NULL),
	(32, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_32/report.html', '2019-06-23 13:58:10', NULL),
	(33, 4, 'http://localhost:81/automation-app/automation-rf/Tests/Web/coupon_search_by_location/report_33/report.html', '2019-06-23 13:59:52', NULL);
/*!40000 ALTER TABLE `t_run_history` ENABLE KEYS */;

-- Dumping structure for table db_automation.user
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_automation.user: ~4 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `emp_id`, `email`, `password`, `token`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'user@mail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '1KQPW7LL7pG6k6ZvHhP4PMKXAwsWYmJ7b1t7HzSXY', 'Y', '2019-01-10 16:39:24', '2019-01-07 21:53:29'),
	(2, 12, 'yyyyy@mail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '', 'Y', '2019-01-10 16:42:27', '2019-01-10 16:42:27'),
	(3, 13, 'agustriatyas@gmail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '30PBUSahV6UyQCQ1DBnazYVGH430IdvPVxQwopRRA', 'Y', '2019-04-14 10:05:31', '2019-04-14 17:50:49'),
	(4, 14, 'sdf@mail.com', 'c0f098d04b5662bf202ea6f72d79f3bf', '4yg2HeYM1DbfSVzuo0DPLLK3Bv9GsPYG56bNFHyAs', 'Y', '2019-04-14 10:13:45', '2019-04-14 17:14:10'),
	(5, 15, 'email', 'c0f098d04b5662bf202ea6f72d79f3bf', '', 'Y', '2019-06-23 14:01:18', '2019-06-23 14:01:18');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

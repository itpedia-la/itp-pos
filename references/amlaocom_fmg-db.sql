-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2015 at 12:32 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `amlaocom_fmg-db`
--
DROP DATABASE `amlaocom_fmg-db`;
CREATE DATABASE IF NOT EXISTS `amlaocom_fmg-db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `amlaocom_fmg-db`;

-- --------------------------------------------------------

--
-- Table structure for table `application_log`
--

DROP TABLE IF EXISTS `application_log`;
CREATE TABLE IF NOT EXISTS `application_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_type` varchar(145) DEFAULT NULL,
  `detail` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_log_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

DROP TABLE IF EXISTS `company_profile`;
CREATE TABLE IF NOT EXISTS `company_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(145) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `address` varchar(245) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `company_name`, `logo`, `address`, `telephone`, `fax`, `mobile`, `email`) VALUES
(1, 'ບໍລິສັດ 1 ພຶດສະພາກຣຸບ ຈຳກັດຜູ້ດຽວ <br/>(First May Group Sole Co.,Ltd)', '', 'KM 10 Thadeua Rd, P.O.Box 3151Vientiane Capital, Lao PDR', '(856-21) 314 890', '(856-21) 313 418', '(858-20) 2323 7878', 'firstmaygroup@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(145) DEFAULT NULL,
  `contact_name` varchar(145) DEFAULT NULL COMMENT 'Manager, Director or owner name',
  `transaction_prefix` varchar(45) DEFAULT NULL COMMENT 'Code will use on transaction Ex: AA_, BB_, CC_',
  `address` varchar(145) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `send_location` varchar(245) DEFAULT NULL COMMENT 'Product send location or site',
  `dept_duration` int(11) DEFAULT NULL COMMENT 'Number of days for dept',
  `overpaid_charge_percentage` int(5) DEFAULT NULL COMMENT 'Charge (%) rate if customer not paid within dept_duration',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remove` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_name` (`company_name`),
  KEY `contact_name` (`contact_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `company_name`, `contact_name`, `transaction_prefix`, `address`, `telephone`, `fax`, `mobile`, `email`, `send_location`, `dept_duration`, `overpaid_charge_percentage`, `created_at`, `updated_at`, `remove`) VALUES
(1, 'IT Pedia Sole.,Ltd', 'Somwang', 'ITP_', 'Suite 408, Level 4, Press Club Building 59A Ly Thai To st, Hoan Kiem dist, Hanoi, VN', '+85620 59998848', '+85621251458', '+856 20 2222 6543', 'dsouksavatd@gmail.com', 'Skymediator', 45, 3, '2015-01-23 12:21:10', '2015-02-28 12:32:30', 1),
(2, 'ລູກຄ້າທົ່ວໄປ', '', 'GEN_', '', '', '', '', '', NULL, 0, 0, '2015-02-08 06:48:01', '2015-02-28 12:32:34', 1),
(3, 'AbsoluteIt Outsource Co., Ltd', 'ສົມສັກ ຫົງສຸວັນ', 'AOC_', '511/15 Prachauthit Rd.,Trungkru,Bangkok Thailand 10140', '020 9747 5999', '021 555 8888', '+856 20 5999 8848', 'info@thaipointofsale.com', NULL, 30, 3, '2015-02-20 23:12:18', '2015-02-28 12:32:38', 1),
(4, 'ບໍລິສັດ ດາວທຽມ ຈຳກັດ (ອ້າຍເຈ)', 'Peter', 'ດທ_', '', '', '', '', '', NULL, 0, 0, '2015-02-28 12:34:49', '2015-02-28 12:34:49', 0),
(5, 'ໂຄງການວຽງຈັນເນລະມິດ (Jimmy)', '', 'ນລມ_', '', '', '', '', '', NULL, 0, 0, '2015-02-28 12:36:08', '2015-02-28 12:36:08', 0),
(6, 'ບໍລິສັດ ຊຽງຕູ່ (ຈັນທີ)', '', 'ຊຕ8', '', '', '', '', '', NULL, 0, 0, '2015-02-28 12:39:02', '2015-02-28 12:42:43', 1),
(7, 'ບໍລິສັດ ຊຽງຕູ່ (ຈັນທີ)', 'ຈັນທີ', 'ຊຕ_', 'ຫຼັກ6', '', '', '', '', NULL, 0, 0, '2015-02-28 12:42:28', '2015-02-28 12:42:28', 0),
(8, 'ໂຮງແຮມ 35 ຊັ້ນ ( ຈັນທີ )', '', 'ຮ35_', '', '', '', '', '', NULL, 0, 0, '2015-02-28 12:44:46', '2015-02-28 12:44:46', 0);

--
-- Triggers `customer`
--
DROP TRIGGER IF EXISTS `customer_BEFORE_INSERT`;
DELIMITER //
CREATE TRIGGER `customer_BEFORE_INSERT` BEFORE INSERT ON `customer`
 FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
SET new.remove = 0;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `exchange_rate`
--

DROP TABLE IF EXISTS `exchange_rate`;
CREATE TABLE IF NOT EXISTS `exchange_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `USD` decimal(10,2) DEFAULT NULL,
  `LAK` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `exchange_rate`
--

INSERT INTO `exchange_rate` (`id`, `USD`, `LAK`, `created_at`, `updated_at`) VALUES
(8, NULL, '250.00', '2015-02-11 15:20:23', '2015-02-11 15:20:23'),
(9, NULL, '250.00', '2015-02-21 00:00:08', '2015-02-21 00:00:08'),
(10, NULL, '250.00', '2015-02-21 10:27:17', '2015-02-21 10:27:17'),
(11, '31.00', '250.00', '2015-02-28 13:16:38', '2015-02-28 13:16:38'),
(12, '31.00', '250.00', '2015-02-28 13:16:42', '2015-02-28 13:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(145) DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `cement_1_kg` decimal(10,2) DEFAULT NULL,
  `cement_2_kg` decimal(10,2) DEFAULT NULL,
  `cement_3_kg` decimal(10,2) DEFAULT NULL,
  `cement_4_kg` decimal(10,2) DEFAULT NULL,
  `cement_5_kg` decimal(10,2) DEFAULT NULL,
  `cement_6_kg` decimal(10,2) DEFAULT NULL,
  `sand_kg` decimal(10,2) DEFAULT NULL,
  `crashed_stone_kg` decimal(10,2) DEFAULT NULL,
  `water_litre` decimal(10,2) DEFAULT NULL,
  `admixture_1_cc` decimal(10,2) DEFAULT NULL,
  `admixture_2_cc` decimal(10,2) DEFAULT NULL,
  `admixture_3_cc` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `remark_note` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50410 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `unit`, `cement_1_kg`, `cement_2_kg`, `cement_3_kg`, `cement_4_kg`, `cement_5_kg`, `cement_6_kg`, `sand_kg`, `crashed_stone_kg`, `water_litre`, `admixture_1_cc`, `admixture_2_cc`, `admixture_3_cc`, `price`, `currency`, `remark_note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(50301, 'ສູດປູນ 15 Mpa', 'm3', '250.00', NULL, '0.00', '0.00', '0.00', '0.00', '780.00', '1218.00', '155.00', '750.00', '0.00', '0.00', '2050.00', 'thb', NULL, '2015-02-20 00:41:08', '2015-02-20 21:52:29', NULL),
(50303, 'ສູດປູນ 20 Mpa', 'm3', '325.00', NULL, '0.00', '0.00', '0.00', '0.00', '764.00', '1202.00', '150.00', '900.00', '0.00', '0.00', '2150.00', 'thb', NULL, '2015-02-20 00:42:25', '2015-02-20 00:42:25', NULL),
(50305, 'ສູດປູນ 25 Mpa', 'm3', '350.00', NULL, '0.00', '0.00', '0.00', '0.00', '733.00', '1194.00', '150.00', '1068.00', '0.00', '0.00', '2200.00', 'thb', NULL, '2015-02-20 00:43:08', '2015-02-20 00:43:08', NULL),
(50307, 'ສູດປູນ 30 Mpa', 'm3', '375.00', '0.00', '0.00', '0.00', '0.00', '0.00', '722.00', '1189.00', '148.00', '1144.00', '0.00', '0.00', '2350.00', 'thb', NULL, '2015-02-20 00:43:54', '2015-02-20 00:43:54', NULL),
(50308, 'ສູດປູນ 32 Mpa', 'm3', '400.00', '0.00', '0.00', '0.00', '0.00', '0.00', '712.00', '1186.00', '145.00', '1240.00', '0.00', '0.00', '2400.00', 'thb', NULL, '2015-02-20 00:44:32', '2015-02-20 00:44:32', NULL),
(50318, 'ສູດປູນ 40 Mpa', 'm3', '460.00', '0.00', '0.00', '0.00', '0.00', '0.00', '690.00', '1120.00', '169.00', '460.00', '3680.00', '0.00', '2900.00', 'thb', NULL, '2015-02-20 00:46:28', '2015-02-20 00:46:28', NULL),
(50319, 'ສູດປູນ 45 Mpa', 'm3', '500.00', '0.00', '0.00', '0.00', '0.00', '0.00', '670.00', '1120.00', '169.00', '525.00', '3575.00', '0.00', '3100.00', 'thb', NULL, '2015-02-20 00:47:07', '2015-02-20 00:47:07', NULL),
(50329, 'ສູດປູນ 35 Mpa', 'm3', '425.00', '0.00', '0.00', '0.00', '0.00', '0.00', '702.00', '1180.00', '145.00', '1336.00', '0.00', '0.00', '2450.00', 'thb', NULL, '2015-02-20 00:45:04', '2015-02-20 00:45:04', NULL),
(50399, 'ສູດປູນ 10 Mpa', 'm3', '225.00', '0.00', '0.00', '0.00', '0.00', '0.00', '772.00', '1234.00', '160.00', '525.00', '0.00', '0.00', '1900.00', 'thb', NULL, '2015-02-20 00:40:29', '2015-02-28 12:58:22', NULL),
(50400, 'ສູດປູນ 10 Mpa ( ສູດກັນຊິມ )', 'm3', '225.00', '0.00', '0.00', '0.00', '0.00', '0.00', '772.00', '1234.00', '160.00', '525.00', '0.00', '0.00', '2000.00', 'thb', NULL, '2015-02-20 00:40:29', '2015-03-04 08:57:25', NULL),
(50401, 'ສູດປູນ 15 Mpa ( ສູດກັນຊິມ )', 'm3', '250.00', NULL, '0.00', '0.00', '0.00', '0.00', '780.00', '1218.00', '155.00', '750.00', '0.00', '0.00', '2150.00', 'thb', NULL, '2015-02-20 00:41:08', '2015-02-20 21:52:29', NULL),
(50402, 'ສູດປູນ 20 Mpa ( ສູດກັນຊິມ )', 'm3', '325.00', NULL, '0.00', '0.00', '0.00', '0.00', '764.00', '1202.00', '150.00', '900.00', '0.00', '0.00', '2250.00', 'thb', NULL, '2015-02-20 00:42:25', '2015-02-20 00:42:25', NULL),
(50403, 'ສູດປູນ 25 Mpa ( ສູດກັນຊິມ )', 'm3', '350.00', NULL, '0.00', '0.00', '0.00', '0.00', '733.00', '1194.00', '150.00', '1068.00', '0.00', '0.00', '2300.00', 'thb', NULL, '2015-02-20 00:43:08', '2015-02-20 00:43:08', NULL),
(50404, 'ສູດປູນ 30 Mpa ( ສູດກັນຊິມ )', 'm3', '375.00', '0.00', '0.00', '0.00', '0.00', '0.00', '722.00', '1189.00', '148.00', '1144.00', '0.00', '0.00', '2450.00', 'thb', NULL, '2015-02-20 00:43:54', '2015-02-20 00:43:54', NULL),
(50405, 'ສູດປູນ 32 Mpa ( ສູດກັນຊິມ )', 'm3', '400.00', '0.00', '0.00', '0.00', '0.00', '0.00', '712.00', '1186.00', '145.00', '1240.00', '0.00', '0.00', '2500.00', 'thb', NULL, '2015-02-20 00:44:32', '2015-02-20 00:44:32', NULL),
(50406, 'ສູດປູນ 40 Mpa ( ສູດກັນຊິມ )', 'm3', '460.00', '0.00', '0.00', '0.00', '0.00', '0.00', '690.00', '1120.00', '169.00', '460.00', '3680.00', '0.00', '3000.00', 'thb', NULL, '2015-02-20 00:46:28', '2015-02-20 00:46:28', NULL),
(50407, 'ສູດປູນ 45 Mpa ( ສູດກັນຊິມ )', 'm3', '500.00', '0.00', '0.00', '0.00', '0.00', '0.00', '670.00', '1120.00', '169.00', '525.00', '3575.00', '0.00', '3200.00', 'thb', NULL, '2015-02-20 00:47:07', '2015-02-20 00:47:07', NULL),
(50408, 'ສູດປູນ 35 Mpaa ( ສູດກັນຊິມ )', 'm3', '425.00', '0.00', '0.00', '0.00', '0.00', '0.00', '702.00', '1180.00', '145.00', '1336.00', '0.00', '0.00', '2550.00', 'thb', NULL, '2015-02-20 00:45:04', '2015-02-20 00:45:04', NULL),
(50409, 'ສູດປູນ 35 Mpa ( ຮ35 )', 'm3', '425.00', '0.00', '0.00', '0.00', '0.00', '0.00', '702.00', '1180.00', '145.00', '1336.00', '0.00', '0.00', '2380.00', 'thb', NULL, '2015-02-20 00:45:04', '2015-02-20 00:45:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(545) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `unit` varchar(45) NOT NULL,
  `remark` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remove` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id`, `service_name`, `price`, `currency`, `unit`, `remark`, `created_at`, `updated_at`, `remove`) VALUES
(1, 'ຄ່າລົດປ້ຳໃຫຍ່', '150.00', 'THB', 'm3', 'ຕໍ່ຫນື່ງແມັດກ້ອນ', '2015-02-08 09:37:47', '2015-02-28 13:05:39', 1),
(2, 'Concret Fomular 1234', '50.00', 'THB', 'm3', '', '2015-02-19 21:22:11', '2015-02-28 13:05:35', 1),
(3, 'ຄ່າລົດປ້ຳໃຫຍ່ (50m3)', '15000.00', 'THB', 'm3', '', '2015-02-28 13:08:36', '2015-02-28 13:08:36', 0),
(4, 'ລົດປ້ຳນ້ອຍ ( 30m3)', '5000.00', 'THB', 'm3', '', '2015-02-28 13:10:09', '2015-02-28 13:10:09', 0),
(5, 'ລົດປ້ຳນ້ອຍ ( 50m3)', '10000.00', 'THB', 'm3', '', '2015-02-28 13:11:06', '2015-02-28 13:11:06', 0),
(6, 'ລົດປ້ຳໃຫຍ່ ( 100m3)', '15000.00', 'THB', 'm3', 'ຕັງຈະເລີນ', '2015-02-28 13:13:41', '2015-02-28 13:13:41', 0),
(7, 'ລົດປ້ຳໃຫຍ່ ( 50m3)', '10000.00', 'THB', 'm3', '', '2015-02-28 13:14:52', '2015-02-28 13:14:52', 0);

--
-- Triggers `service`
--
DROP TRIGGER IF EXISTS `service_BEFORE_INSERT`;
DELIMITER //
CREATE TRIGGER `service_BEFORE_INSERT` BEFORE INSERT ON `service`
 FOR EACH ROW BEGIN
SET new.remove=0;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_child`
--

DROP TABLE IF EXISTS `transaction_child`;
CREATE TABLE IF NOT EXISTS `transaction_child` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_parent_id` int(11) NOT NULL,
  `issue_slip_id` varchar(45) DEFAULT NULL,
  `issue_date` datetime DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `quality` decimal(10,2) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `remark` varchar(145) DEFAULT NULL,
  `truck_number` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_child_transaction_parent1_idx` (`transaction_parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `transaction_child`
--

INSERT INTO `transaction_child` (`id`, `transaction_parent_id`, `issue_slip_id`, `issue_date`, `product_id`, `service_id`, `quality`, `price`, `total`, `remark`, `truck_number`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(81, 1033, 'BF254888', '2015-02-02 12:00:00', 50314, NULL, '20.00', NULL, 44000, NULL, NULL, '2015-02-28 09:05:27', '2015-02-28 09:12:27', '2015-02-28 09:12:27', NULL),
(82, 1033, 'BF54888', '2015-02-10 12:00:00', 50319, NULL, '20.00', 3100, 62000, NULL, NULL, '2015-02-28 09:06:46', '2015-02-28 09:10:57', '2015-02-28 09:10:57', NULL),
(83, 1034, 'BF1544', '2015-02-11 12:00:00', 50313, NULL, '10.00', NULL, 21500, NULL, NULL, '2015-02-28 09:07:20', '2015-02-28 09:11:07', '2015-02-28 09:11:07', NULL),
(84, 1034, 'BF558844', '2015-01-02 12:00:00', 50314, NULL, '10.00', NULL, 22000, NULL, NULL, '2015-02-28 09:11:23', '2015-02-28 13:30:57', '2015-02-28 13:30:57', NULL),
(85, 1035, 'BF', NULL, 50303, NULL, '10.00', 2150, 21500, NULL, NULL, '2015-02-28 13:20:12', '2015-02-28 13:31:15', '2015-02-28 13:31:15', NULL),
(86, 1036, 'BF005515', '2015-01-02 12:00:00', 50329, NULL, '9.00', 2450, 22050, NULL, '10', '2015-02-28 13:35:13', '2015-02-28 13:35:13', NULL, NULL),
(87, 1036, 'BF005516', '2015-01-02 09:57:00', 50329, NULL, '9.00', 2450, 22050, NULL, '04', '2015-02-28 13:37:58', '2015-02-28 13:37:58', NULL, NULL),
(88, 1036, 'BF005518', '2015-01-02 10:18:00', 50329, NULL, '8.00', 2450, 19600, NULL, '05', '2015-02-28 13:38:48', '2015-02-28 13:38:48', NULL, NULL),
(89, 1036, 'BF005519', '2015-01-02 10:26:00', 50329, NULL, '8.00', 2450, 19600, '', '08', '2015-02-28 13:39:20', '2015-02-28 13:42:12', NULL, NULL),
(90, 1036, 'BF005520', '2015-01-02 10:34:00', 50329, NULL, '8.00', 2450, 19600, '', '01', '2015-02-28 13:39:40', '2015-02-28 13:42:25', NULL, NULL),
(91, 1036, 'BF005527', '2015-01-02 13:27:00', 50329, NULL, '9.00', 2450, 22050, '', '05', '2015-02-28 13:40:09', '2015-02-28 13:42:43', NULL, NULL),
(92, 1036, 'BF005528', '2015-01-02 10:34:00', 50329, NULL, '9.00', 2450, 22050, NULL, '08', '2015-02-28 13:40:34', '2015-02-28 13:40:34', NULL, NULL),
(93, 1036, 'BF005529', '2015-01-02 13:47:00', 50329, NULL, '8.00', 2450, 19600, NULL, '09', '2015-02-28 13:40:53', '2015-02-28 13:40:53', NULL, NULL),
(94, 1036, 'BF005530', '2015-01-02 10:34:00', 50329, NULL, '8.00', 2450, 19600, '', '01', '2015-02-28 13:41:11', '2015-02-28 13:42:55', NULL, NULL),
(95, 1036, 'BF005531', '2015-01-02 14:06:00', 50329, NULL, '8.00', 2450, 19600, '', '06', '2015-02-28 13:41:27', '2015-02-28 13:43:09', NULL, NULL),
(96, 1037, 'BF005517', '2015-01-02 10:08:00', 50307, NULL, '4.50', 2350, 10575, NULL, NULL, '2015-02-28 13:49:54', '2015-02-28 13:49:54', NULL, NULL),
(97, 1040, 'BF005523', '2015-01-02 11:09:00', 50305, NULL, '6.00', 2200, 13200, NULL, NULL, '2015-02-28 13:53:04', '2015-02-28 13:53:04', NULL, NULL),
(98, 1042, 'BF005521', '2015-01-02 10:47:00', 50307, NULL, '10.00', 2350, 23500, NULL, NULL, '2015-02-28 15:48:18', '2015-02-28 15:48:18', NULL, NULL),
(99, 1042, 'BF005522', '2015-01-02 10:57:00', 50307, NULL, '9.50', 2350, 22325, NULL, NULL, '2015-02-28 15:49:08', '2015-02-28 15:49:08', NULL, NULL),
(100, 1042, 'BF005524', '2015-01-02 11:19:00', 50307, NULL, '10.00', 2350, 23500, NULL, NULL, '2015-02-28 15:49:39', '2015-02-28 15:49:39', NULL, NULL),
(101, 1042, 'BF005525', '2015-01-02 11:51:00', 50307, NULL, '10.00', 2350, 23500, NULL, NULL, '2015-02-28 15:49:58', '2015-02-28 15:49:58', NULL, NULL),
(102, 1042, 'BF005526', '2015-01-02 12:00:00', 50307, NULL, '9.50', 2350, 22325, NULL, NULL, '2015-02-28 15:50:25', '2015-02-28 15:50:25', NULL, NULL),
(103, 1042, 'BF005532', '2015-01-02 16:54:00', 50307, NULL, '5.00', 2350, 11750, NULL, NULL, '2015-02-28 15:50:58', '2015-02-28 15:50:58', NULL, NULL),
(104, 1042, 'BF005533', '2015-01-02 12:00:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:51:27', '2015-02-28 15:51:27', NULL, NULL),
(105, 1042, 'BF005534', '2015-01-02 18:17:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:51:51', '2015-02-28 15:51:51', NULL, NULL),
(106, 1042, 'BF005535', '2015-01-02 18:28:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:52:18', '2015-02-28 15:52:18', NULL, NULL),
(107, 1042, 'BF005536', '2015-01-02 18:38:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:52:42', '2015-02-28 15:52:42', NULL, NULL),
(108, 1042, 'BF005537', '2015-01-02 18:52:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:53:09', '2015-02-28 15:53:09', NULL, NULL),
(109, 1042, 'BF005538', '2015-01-02 19:45:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:53:50', '2015-02-28 15:53:50', NULL, NULL),
(110, 1042, 'BF005539', '2015-01-02 20:00:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:54:17', '2015-02-28 15:54:17', NULL, NULL),
(111, 1042, 'BF005540', '2015-01-02 20:09:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:54:50', '2015-02-28 15:54:50', NULL, NULL),
(112, 1042, 'BF005541', '2015-01-02 20:21:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:55:16', '2015-02-28 15:55:16', NULL, NULL),
(113, 1042, 'BF005542', '2015-01-02 20:30:00', 50404, NULL, '9.50', 2450, 23275, NULL, NULL, '2015-02-28 15:55:51', '2015-02-28 15:55:51', NULL, NULL),
(114, 1042, 'BF005543', '2015-01-02 21:17:00', 50404, NULL, '7.00', 2450, 17150, NULL, NULL, '2015-02-28 15:56:18', '2015-02-28 15:56:18', NULL, NULL),
(115, 1043, 'BF005884', '2015-03-12 12:00:00', 50408, NULL, '10.00', 2550, 25500, NULL, 'FMG-10', '2015-03-04 09:01:08', '2015-03-04 09:01:33', '2015-03-04 09:01:33', NULL),
(116, 1043, 'BF005884', '2015-03-12 12:00:00', 50408, NULL, '10.00', 2550, 25500, NULL, 'FMG-10', '2015-03-04 09:01:08', '2015-03-04 09:01:27', '2015-03-04 09:01:27', NULL),
(117, 1042, 'BF2555', '2015-03-20 12:00:00', 50409, NULL, '9.00', 2380, 21420, NULL, 'FMG-555', '2015-03-04 09:09:51', '2015-03-04 09:10:12', '2015-03-04 09:10:12', NULL),
(118, 1043, NULL, NULL, NULL, 4, '2.50', 5000, 12500, '', NULL, '2015-03-04 11:46:19', '2015-03-04 12:31:40', '2015-03-04 12:31:40', 1),
(119, 1042, NULL, NULL, NULL, 3, '2.00', 15000, 30000, '', NULL, '2015-03-04 11:51:05', '2015-03-04 12:01:49', '2015-03-04 12:01:49', 1),
(120, 1040, NULL, NULL, NULL, 3, '2.00', 15000, 30000, '', NULL, '2015-03-04 12:00:21', '2015-03-04 12:01:59', '2015-03-04 12:01:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_parent`
--

DROP TABLE IF EXISTS `transaction_parent`;
CREATE TABLE IF NOT EXISTS `transaction_parent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_number` varchar(45) DEFAULT NULL COMMENT 'AA_1001',
  `transaction_date` date DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `company_name` varchar(245) DEFAULT NULL,
  `contact_name` varchar(145) DEFAULT NULL,
  `contact_telephone` varchar(145) DEFAULT NULL,
  `overpaid_charge_percentage` int(5) DEFAULT NULL,
  `dept_duration` int(11) DEFAULT NULL,
  `send_location` varchar(245) DEFAULT NULL,
  `exchange_rate_id` int(11) NOT NULL,
  `grand_total` decimal(10,2) DEFAULT '0.00' COMMENT 'Sum value of transaction_child.total',
  `transaction_status` tinyint(5) DEFAULT NULL COMMENT '0 = Pending / Waiting for Approve\n1 = Approved / Print\n2 = Waiting for payment',
  `created_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `quotation_expired_at` date DEFAULT NULL,
  `due_paid_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1045 ;

--
-- Dumping data for table `transaction_parent`
--

INSERT INTO `transaction_parent` (`id`, `transaction_number`, `transaction_date`, `customer_id`, `company_name`, `contact_name`, `contact_telephone`, `overpaid_charge_percentage`, `dept_duration`, `send_location`, `exchange_rate_id`, `grand_total`, `transaction_status`, `created_by`, `approved_by`, `quotation_expired_at`, `due_paid_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1033, 'ITP_1033', '2015-02-28', 1, 'IT Pedia Sole.,Ltd', 'Somwang', '+85620 59998848', 3, 45, '', 10, '44000.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 09:04:56', '2015-02-28 09:12:27', '2015-02-28 09:12:27'),
(1034, 'ITP_1034', '2015-01-08', 1, 'IT Pedia Sole.,Ltd', 'Somwang', '+85620 59998848', 3, 45, '', 10, '22000.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 09:06:13', '2015-02-28 13:30:57', '2015-02-28 13:30:57'),
(1035, 'ດທ_1035', '2015-02-28', 4, 'ບໍລິສັດ ດາວທຽມ ຈຳກັດ (ອ້າຍເຈ)', 'Peter', '', 0, 0, '', 12, '21500.00', 1, 1, NULL, '2015-03-15', '2015-02-28', '2015-02-28 13:18:46', '2015-02-28 13:31:15', '2015-02-28 13:31:15'),
(1036, 'ຮ35_1036', '2015-01-02', 8, 'ໂຮງແຮມ 35 ຊັ້ນ ( ຈັນທີ )', '', '', 3, 15, 'ໂພນສີນວນ', 12, '205800.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 13:29:15', '2015-02-28 13:43:09', NULL),
(1037, 'ດທ_1037', '2015-01-02', 4, 'ບໍລິສັດ ດາວທຽມ ຈຳກັດ (ອ້າຍເຈ)', 'Peter', '', 3, 30, 'ນາໄຮ່', 12, '10575.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 13:49:11', '2015-02-28 13:49:54', NULL),
(1038, 'ນລມ_1038', '2015-02-28', 5, 'ໂຄງການວຽງຈັນເນລະມິດ (Jimmy)', '', '', 3, 30, 'ດົງພູສີ', 12, '0.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 13:50:45', '2015-02-28 13:50:54', '2015-02-28 13:50:54'),
(1039, 'ນລມ_1039', '2015-02-28', 5, 'ໂຄງການວຽງຈັນເນລະມິດ (Jimmy)', '', '', 3, 30, 'ດົງພູສີ', 12, '0.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 13:51:20', '2015-02-28 13:51:26', '2015-02-28 13:51:26'),
(1040, 'ນລມ_1040', '2015-01-02', 5, 'ໂຄງການວຽງຈັນເນລະມິດ (Jimmy)', '', '', 3, 30, 'ດົງໂພສິ', 12, '13200.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 13:52:08', '2015-03-04 12:01:59', NULL),
(1041, 'ຊຕ_1041', '2015-01-02', 7, 'ບໍລິສັດ ຊຽງຕູ່ (ຈັນທີ)', 'ຈັນທີ', '', 3, 30, '', 12, '0.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 15:46:25', '2015-02-28 15:47:17', '2015-02-28 15:47:17'),
(1042, 'ຊຕ_1042', '2015-01-02', 7, 'ບໍລິສັດ ຊຽງຕູ່ (ຈັນທີ)', 'ຈັນທີ', '', 3, 30, 'ຫລັກ 6', 12, '376800.00', 1, 1, NULL, '1970-01-01', NULL, '2015-02-28 15:47:40', '2015-03-04 12:01:49', NULL),
(1043, 'ດທ_1043', '2015-03-04', 4, 'ບໍລິສັດ ດາວທຽມ ຈຳກັດ (ອ້າຍເຈ)', 'Peter', '', 0, 0, '', 12, '12500.00', 1, 1, NULL, '1970-01-01', NULL, '2015-03-04 08:59:55', '2015-03-04 12:31:40', '2015-03-04 12:31:40'),
(1044, 'ນລມ_1044', '2015-03-04', 5, 'ໂຄງການວຽງຈັນເນລະມິດ (Jimmy)', '', '', 0, 0, '', 12, '0.00', 0, 1, NULL, '2015-03-19', NULL, '2015-03-04 09:27:37', '2015-03-04 09:29:15', '2015-03-04 09:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_payment`
--

DROP TABLE IF EXISTS `transaction_payment`;
CREATE TABLE IF NOT EXISTS `transaction_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_parent_id` int(11) DEFAULT NULL,
  `transaction_number_sub` varchar(145) DEFAULT NULL,
  `payment_type` varchar(45) DEFAULT NULL COMMENT 'Cheque\nBank Transfer\nCash',
  `amount` decimal(15,2) DEFAULT NULL,
  `amount_usd` decimal(20,2) DEFAULT NULL,
  `amount_lak` decimal(20,2) DEFAULT NULL,
  `exchange_rate_id` int(11) DEFAULT NULL,
  `paid_at` date DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL COMMENT '0 = Pending\n1 = Received\n2 = Cancelled',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_payment_transaction_parent1_idx` (`transaction_parent_id`),
  KEY `fk_transaction_payment_exchange_rate1_idx` (`exchange_rate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `transaction_payment`
--

INSERT INTO `transaction_payment` (`id`, `transaction_parent_id`, `transaction_number_sub`, `payment_type`, `amount`, `amount_usd`, `amount_lak`, `exchange_rate_id`, `paid_at`, `status`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 1037, 'ດທ_1037_1', 'Cheque', '10575.00', '341.13', '2643750.00', 12, NULL, 0, '2015-02-28 15:59:32', '2015-02-28 15:59:32', NULL, 1),
(2, 1042, 'ຊຕ_1042_1', 'Cheque', '376800.00', '12154.84', '94200000.00', 12, NULL, 0, '2015-02-28 16:09:39', '2015-02-28 16:09:39', NULL, 1),
(3, 1040, 'ນລມ_1040_1', 'Cash', '13200.00', '425.81', '3300000.00', 12, NULL, 0, '2015-02-28 16:12:42', '2015-02-28 16:12:42', NULL, 1),
(4, 1036, 'ຮ35_1036_1', 'Bank Transfer', '205800.00', '6638.71', '51450000.00', 12, NULL, 0, '2015-02-28 16:13:30', '2015-02-28 16:13:30', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `login` varchar(145) NOT NULL,
  `password` varchar(145) NOT NULL,
  `firstname` varchar(145) NOT NULL,
  `lastname` varchar(145) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `systemUser` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remove` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_user_group1_idx` (`user_group_id`),
  KEY `login` (`login`),
  KEY `password` (`password`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_group_id`, `login`, `password`, `firstname`, `lastname`, `remember_token`, `systemUser`, `created_at`, `updated_at`, `remove`) VALUES
(1, 1, 'dsouksavatd@gmail.com', '$2y$10$ZwFV0oThP7bFnAGcftHgROKF2WHzYqpQbZEwGqc0xhoIoBJqslAOy', 'Somwang', 'Souksavatd', 'RHRtLfvnmt8NhN3lqIKqouhv1akaalSSUxJlinzcXqz0imqNLAuJPyEdiZgp', 1, '2015-02-28 00:00:00', '2015-02-28 17:05:31', 0),
(12, 7, '23237878', '$2y$10$ONOF9ikRfZHzUDsItdeqm..Gbt7NjupfZBgeGUhxDfxx/ZN2Ad2fG', 'Soukthakone', 'Souvannkham', '8ySgP8bnOtWsBidUK6cILvHIWxhijlpq9idEEmay7f1QVvFHm0X3T1AXxGYf', 0, '2015-02-28 17:03:32', '2015-02-28 17:06:35', 0),
(13, 8, '23456926', '$2y$10$f6Vp/B4kX7MRcDe34jYoVuGE8L/Yn1xhTi65t7/56PowTVJEcC2RW', 'Vilaiphone', 'Bounthongsouk', 'sBYmMH0KEzpdKnEjbxViBay3gNOhYQQwYpRTUI7ymuSaJO9O6sd51aigXxJC', 0, '2015-02-28 17:04:28', '2015-02-28 17:06:56', 0),
(14, 8, '58871577', '$2y$10$E2fUK6foPIrtn/bTv.o.ReZyR8qXtW7GzZU6GjDhkuEbj5oFF9RYW', 'Anousone', 'Sivilay', NULL, 0, '2015-02-28 17:05:05', '2015-02-28 17:05:05', 0);

--
-- Triggers `user`
--
DROP TRIGGER IF EXISTS `user_BEFORE_INSERT`;
DELIMITER //
CREATE TRIGGER `user_BEFORE_INSERT` BEFORE INSERT ON `user`
 FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
SET new.remove = 0;
SET new.systemUser = 0;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(145) NOT NULL,
  `permissionList` text,
  `invisible` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `name`, `permissionList`, `invisible`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, 1, NULL, NULL),
(2, 'ຜູ້ອຳນວຍການ', '{"1":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0e9c\\u0eb9\\u0ec9\\u0ec3\\u0e8a\\u0ec9\\u0e87\\u0eb2\\u0e99 ( User Add )","2":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87 ( User Remove )","3":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 ( User List )","4":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82\\u0ea5\\u0eb0\\u0eab\\u0eb1\\u0e94\\u0e9c\\u0ec8\\u0eb2\\u0e99 ( Change User Password )","13":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0eaa\\u0ebb\\u0ec8\\u0e87","15":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e9c\\u0eb0\\u0ea5\\u0eb4\\u0e94\\u0ec1\\u0e8d\\u0e81\\u0e95\\u0eb2\\u0ea1\\u0ea5\\u0eb9\\u0e81\\u0e84\\u0ec9\\u0eb2 (Material Report by Cust.)","17":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction Report)"}', 0, '2015-01-20 00:00:00', '2015-02-21 10:24:49'),
(7, 'ບັນຊີລວມ', '{"5":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 ( Customer List )","6":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 ( Customer Add )","7":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82 ( Customer Edit )","8":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87 ( Customer Remove )","11":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82\\u0ead\\u0eb1\\u0e94\\u0e95\\u0eb2\\u0ec1\\u0ea5\\u0e81\\u0e9b\\u0ec8\\u0ebd\\u0e99 ( Update Exchange Rate )","12":"\\u0e95\\u0eb1\\u0ec9\\u0e87\\u0e84\\u0ec8\\u0eb2\\u0e97\\u0ebb\\u0ec8\\u0ea7\\u0ec4\\u0e9b ( General Setting )","13":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0eaa\\u0ebb\\u0ec8\\u0e87","15":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e9c\\u0eb0\\u0ea5\\u0eb4\\u0e94\\u0ec1\\u0e8d\\u0e81\\u0e95\\u0eb2\\u0ea1\\u0ea5\\u0eb9\\u0e81\\u0e84\\u0ec9\\u0eb2 (Material Report by Cust.)","17":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction Report)","19":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","20":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","21":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","38":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","22":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","23":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82","24":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87","39":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","25":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 \\u0ec3\\u0e9a\\u0eaa\\u0eb0\\u0ec0\\u0eab\\u0e99\\u0eb5\\u0ea5\\u0eb2\\u0e84\\u0eb2","26":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d","27":"\\u0ec2\\u0ead\\u0e99\\u0ec0\\u0e9b\\u0eb1\\u0e99 ","28":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 ","29":"\\u0e8d\\u0ebb\\u0e81\\u0ec0\\u0ea5\\u0eb5\\u0e81 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","30":"\\u0e9e\\u0eb4\\u0ea1 ","31":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","33":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","34":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","40":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction)","42":"\\u0e8d\\u0ebb\\u0e81\\u0ec0\\u0ea5\\u0eb4\\u0e81 ","43":"\\u0e9e\\u0eb4\\u0ea1 "}', 0, NULL, '2015-02-28 17:01:19'),
(8, 'ບັນຊີີລາຍວັນ', '{"5":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 ( Customer List )","6":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 ( Customer Add )","7":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82 ( Customer Edit )","8":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87 ( Customer Remove )","11":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82\\u0ead\\u0eb1\\u0e94\\u0e95\\u0eb2\\u0ec1\\u0ea5\\u0e81\\u0e9b\\u0ec8\\u0ebd\\u0e99 ( Update Exchange Rate )","13":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0eaa\\u0ebb\\u0ec8\\u0e87","15":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e9c\\u0eb0\\u0ea5\\u0eb4\\u0e94\\u0ec1\\u0e8d\\u0e81\\u0e95\\u0eb2\\u0ea1\\u0ea5\\u0eb9\\u0e81\\u0e84\\u0ec9\\u0eb2 (Material Report by Cust.)","17":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction Report)","19":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","20":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","21":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","38":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2","22":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1\\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","23":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82","24":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87","39":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","25":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 \\u0ec3\\u0e9a\\u0eaa\\u0eb0\\u0ec0\\u0eab\\u0e99\\u0eb5\\u0ea5\\u0eb2\\u0e84\\u0eb2","26":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d","27":"\\u0ec2\\u0ead\\u0e99\\u0ec0\\u0e9b\\u0eb1\\u0e99 ","28":"\\u0eaa\\u0ec9\\u0eb2\\u0e87 ","29":"\\u0e8d\\u0ebb\\u0e81\\u0ec0\\u0ea5\\u0eb5\\u0e81 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99","30":"\\u0e9e\\u0eb4\\u0ea1 ","31":"\\u0ec0\\u0e9e\\u0eb5\\u0ec8\\u0ea1 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","33":"\\u0ec1\\u0e81\\u0ec9\\u0ec4\\u0e82 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","34":"\\u0ea5\\u0ebb\\u0e9a\\u0ea5\\u0ec9\\u0eb2\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99 \\u0eaa\\u0eb4\\u0e99\\u0e84\\u0ec9\\u0eb2 \\/ \\u0e81\\u0eb2\\u0e99\\u0e9a\\u0ecd\\u0ea5\\u0eb4\\u0e81\\u0eb2\\u0e99","40":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction)","42":"\\u0e8d\\u0ebb\\u0e81\\u0ec0\\u0ea5\\u0eb4\\u0e81 ","43":"\\u0e9e\\u0eb4\\u0ea1 "}', 0, NULL, '2015-02-28 17:01:09'),
(9, 'ການເງິນ', '{"13":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0eaa\\u0ebb\\u0ec8\\u0e87","15":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e9c\\u0eb0\\u0ea5\\u0eb4\\u0e94\\u0ec1\\u0e8d\\u0e81\\u0e95\\u0eb2\\u0ea1\\u0ea5\\u0eb9\\u0e81\\u0e84\\u0ec9\\u0eb2 (Material Report by Cust.)","17":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0ea5\\u0eb0\\u0ead\\u0ebd\\u0e94\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction Report)","40":"\\u0eaa\\u0eb0\\u0ec1\\u0e94\\u0e87 \\u0ea5\\u0eb2\\u0e8d\\u0e81\\u0eb2\\u0e99\\u0e82\\u0eb2\\u0e8d (Transaction)","41":"\\u0eae\\u0eb1\\u0e9a\\u0ec0\\u0e87\\u0eb4\\u0e99 \\u0e88\\u0eb2\\u0e81 ","43":"\\u0e9e\\u0eb4\\u0ea1 "}', 0, NULL, '2015-02-28 17:01:57');

--
-- Triggers `user_group`
--
DROP TRIGGER IF EXISTS `user_group_BINS`;
DELIMITER //
CREATE TRIGGER `user_group_BINS` BEFORE INSERT ON `user_group`
 FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
SET new.invisible = 0;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_group_permission`
--

DROP TABLE IF EXISTS `user_group_permission`;
CREATE TABLE IF NOT EXISTS `user_group_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissionZone` varchar(145) NOT NULL,
  `permissionTitle` varchar(145) NOT NULL,
  `permissionDescription` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `user_group_permission`
--

INSERT INTO `user_group_permission` (`id`, `permissionZone`, `permissionTitle`, `permissionDescription`) VALUES
(1, 'ການບໍລິຫານຜູ້ໃຊ້ງານ', 'ເພີ່ມຜູ້ໃຊ້ງານ ( User Add )', 'ອະນຸຍາດໃນການເພີ່ມຜູ້ໃຊ້ງານ'),
(2, 'ການບໍລິຫານຜູ້ໃຊ້ງານ', 'ລົບລ້າງ ( User Remove )', 'ອະນຸຍາດໃຫ້ລົບລ້າງຜູ້ໃຊ້ງານ'),
(3, 'ການບໍລິຫານຜູ້ໃຊ້ງານ', 'ສະແດງລາຍການ ( User List )', 'ອະນຸຍາດໃຫ້ສະແດງລາຍການຜູ້ໃຊ້ງານ'),
(4, 'ການບໍລິຫານຜູ້ໃຊ້ງານ', 'ແກ້ໄຂລະຫັດຜ່ານ ( Change User Password )', 'ອະນຸຍາດໃຫ້ແກ້ໄຂລະຫັດຜ່ານຂອງຜູ້ໃຊ້ງານ'),
(5, 'ການບໍລິຫານລາຍການລູກຄ້າ', 'ສະແດງລາຍການ ( Customer List )', 'ອະນຸຍາດໃຫ້ສະແດງລາຍການຂໍ້ມູນລູກຄ້າ'),
(6, 'ການບໍລິຫານລາຍການລູກຄ້າ', 'ເພີ່ມລາຍການ ( Customer Add )', 'ອະນຸຍາດໃຫ້ເພິ້ມລາຍການລູກຄ້າ'),
(7, 'ການບໍລິຫານລາຍການລູກຄ້າ', 'ແກ້ໄຂ ( Customer Edit )', 'ອະນຸຍາດໃຫ້ແກ້ໄຂລາຍການລູກຄ້າ'),
(8, 'ການບໍລິຫານລາຍການລູກຄ້າ', 'ລົບລ້າງ ( Customer Remove )', 'ອະນຸຍາດໃຫ້ລົບລ້າງລາຍການລູກຄ້າ'),
(10, 'ການບໍລິຫານຜູ້ໃຊ້ງານ', 'ກຳໜົດສິດກຸ່ມຜູ້ໃຊ້ງານ ( Set Group Permission )', 'ອະນຸຍາດໃຫ້ກຳໜົດສິດກຸ່ມຜູ້ໃຊ້ງານ'),
(11, 'ຕັ້ງຄ່າ', 'ແກ້ໄຂອັດຕາແລກປ່ຽນ ( Update Exchange Rate )', 'ອະນຸຍາດໃຫ້ແກ້ໄຂອັດຕາແລກປ່ຽນ'),
(12, 'ຕັ້ງຄ່າ', 'ຕັ້ງຄ່າທົ່ວໄປ ( General Setting )', 'ອະນຸຍາດໃຫ້ແກ້ໄຂຄ່າຂໍ້ມູນພື້ນຖານທົ່ວໄປ'),
(13, 'ລາຍງານ', 'ສະແດງ ລາຍລະອຽດການສົ່ງ', 'ອະນຸຍາດໃຫ້ ສະແດງ ລາຍການລາຍລະອຽດການສົ່ງ'),
(15, 'ລາຍງານ', 'ສະແດງ ລາຍການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.)', 'ອະນຸຍາດໃຫ້ ສະແດງ ລາຍການຜະລິດແຍກຕາມລູກຄ້າ (Material Report by Cust.)'),
(17, 'ລາຍງານ', 'ສະແດງ ລາຍລະອຽດການຂາຍ (Transaction Report)', 'ອະນຸຍາດໃຫ້ ສະແດງ  ລາຍລະອຽດການຂາຍ (Transaction Report)'),
(19, 'ລາຍການ ສິນຄ້າ', 'ເພີ່ມລາຍການ', 'ອະນຸຍາດໃຫ້ເພີ່ມລາຍການສິນຄ້າ'),
(20, 'ລາຍການ ສິນຄ້າ', 'ແກ້ໄຂລາຍການ ສິນຄ້າ', 'ອະນຸຍາດໃຫ້ແກ້ໄຂລາຍການສິນຄ້າ'),
(21, 'ລາຍການ ສິນຄ້າ', 'ລົບລ້າງລາຍການ ສິນຄ້າ', 'ອະນຸຍາດໃຫ້ລົບລ້າງລາຍການສິນຄ້າ'),
(22, 'ລາຍການ ການບໍລິການ', 'ເພີ່ມລາຍການ', 'ອະນຸຍາດໃຫ້ເພີ່ມລາຍການ ການບໍລິການ'),
(23, 'ລາຍການ ການບໍລິການ', 'ແກ້ໄຂ', 'ອະນຸຍາດໃຫ້ແກ້ໄຂ ລາຍການ ການບໍລິການ'),
(24, 'ລາຍການ ການບໍລິການ', 'ລົບລ້າງ', 'ອະນຸຍາດໃຫ້ລົບລ້າງ ລາຍການ ການບໍລິການ'),
(25, 'ລາຍການຂາຍ (Transaction)', 'ສ້າງ ໃບສະເຫນີລາຄາ', 'ອະນຸຍາດຍາດໃຫ້ ສ້າງ ໃບສະເຫນີລາຄາ'),
(26, 'ລາຍການຂາຍ (Transaction)', 'ສ້າງ ລາຍການຂາຍ', 'ອະນຸຍາດໃຫ້ ສ້າງ ລາຍການຂາຍ'),
(27, 'ລາຍການຂາຍ (Transaction)', 'ໂອນເປັນ "ລາຍການຂາຍ"', 'ອະນຸຍາດໃຫ້ ໂອນເປັນ "ໃບສະເຫນີລາຄາ" ເປັນ "ລາຍການຂາຍ"'),
(28, 'ລາຍການຂາຍ (Transaction)', 'ສ້າງ "ໃບຮຽກເກັບເງິນ"', 'ອະນຸຍາດໃຫ້ ສ້າງ "ໃບຮຽກເກັບເງິນ"'),
(29, 'ລາຍການຂາຍ (Transaction)', 'ຍົກເລີກ ລາຍການ', 'ອະນຸຍາດໃຫ້ ຍົກເລີກ "ລາຍການຂາຍ" ຫລືື "ໃບສະເຫນີລາຄາ"'),
(30, 'ລາຍການຂາຍ (Transaction)', 'ພິມ "ໃບສະເຫນີລາຄາ"', 'ອະນຸຍາດໃຫ້ ພິມ "ໃບສະເຫນີລາຄາ"'),
(31, 'ລາຍການຂາຍ (Transaction)', 'ເພີ່ມ ລາຍການ ສິນຄ້າ / ການບໍລິການ', 'ອະນຸຍາດ ໃຫ້ເພີ່ມ ສິນຄ້າ / ການບໍລິການ ເຂົ້າໃນ "ລາຍການຂາຍ" ຫລືື "ໃບສະເຫນີລາຄາ"'),
(33, 'ລາຍການຂາຍ (Transaction)', 'ແກ້ໄຂ ລາຍການ ສິນຄ້າ / ການບໍລິການ', 'ອະນຸຍາດໃຫ້ ລາຍການ ສິນຄ້າ / ການບໍລິການ'),
(34, 'ລາຍການຂາຍ (Transaction)', 'ລົບລ້າງ ລາຍການ ສິນຄ້າ / ການບໍລິການ', 'ອະນຸຍາດໃຫ້ ລົບລ້າງ ລາຍການ ສິນຄ້າ / ການບໍລິການ'),
(38, 'ລາຍການ ສິນຄ້າ', 'ສະແດງ ລາຍການ ສິນຄ້າ', 'ອະນຸຍາດໃຫ້ ສະແດງລາຍການ ສິນຄ້າ'),
(39, 'ລາຍການ ການບໍລິການ', 'ສະແດງ ລາຍການ ການບໍລິການ', 'ອະນຸຍາດໃຫ້ ສະແດງລາຍການ ລາຍການສິນຄ້າ'),
(40, 'ລາຍການຂາຍ (Transaction)', 'ສະແດງ ລາຍການຂາຍ (Transaction)', 'ອະນຸຍາດໃຫ້ ສະແດງ ລາຍການຂາຍ (Transaction)'),
(41, 'ລາຍການຂາຍ (Transaction)', 'ຮັບເງິນ ຈາກ "ໃບຮຽກເກັບເງິນ"', 'ອະນຸຍາດໃ້ຫ ຮັບເງິນ ຈາກ "ໃບຮຽກເກັບເງິນ"'),
(42, 'ລາຍການຂາຍ (Transaction)', 'ຍົກເລິກ "ໃບຮຽກເກັບເງິນ"', 'ອະນຸຍາດໃ້ຫ ຍົກເລິກ "ໃບຮຽກເກັບເງິນ"'),
(43, 'ລາຍການຂາຍ (Transaction)', 'ພິມ "ໃບຮຽກເກັບເງິນ"', 'ອະນຸຍາດໃຫ້ ພິມ "ໃບຮຽກເກັບເງິນ"');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application_log`
--
ALTER TABLE `application_log`
  ADD CONSTRAINT `fk_transaction_log_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction_child`
--
ALTER TABLE `transaction_child`
  ADD CONSTRAINT `fk_transaction_child_transaction_parent1` FOREIGN KEY (`transaction_parent_id`) REFERENCES `transaction_parent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction_payment`
--
ALTER TABLE `transaction_payment`
  ADD CONSTRAINT `fk_transaction_payment_exchange_rate1` FOREIGN KEY (`exchange_rate_id`) REFERENCES `exchange_rate` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transaction_payment_transaction_parent1` FOREIGN KEY (`transaction_parent_id`) REFERENCES `transaction_parent` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_user_group1` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

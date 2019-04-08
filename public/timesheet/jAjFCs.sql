-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 02, 2016 at 03:05 AM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prestigevalet`
--

-- --------------------------------------------------------

--
-- Table structure for table `allowancededuction`
--

CREATE TABLE IF NOT EXISTS `allowancededuction` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(32) NOT NULL,
  `type` enum('allowance','deduction') NOT NULL DEFAULT 'allowance',
  `name` varchar(100) NOT NULL,
  `enableProrated` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `allowancededuction`
--

INSERT INTO `allowancededuction` (`id`, `company`, `type`, `name`, `enableProrated`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, '10', 'allowance', 'Transport Allowances', 'yes', 'active', 'admin', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(2, '10', 'allowance', 'Meal Allowances', 'yes', 'active', 'admin', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(3, '10', 'allowance', 'Shift Allowances', 'yes', 'active', 'admin', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(4, '10', 'allowance', 'Accommodation', 'yes', 'active', 'admin', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(5, '10', 'deduction', '2 Week''s Advance', 'no', 'active', 'admin', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(6, '10', 'allowance', 'Attendance Bonus', 'no', 'active', 'admin', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(7, '02', 'allowance', 'Static & Shift ', 'yes', 'active', 'admin', '2016-06-01 18:19:19', '2016-06-02 16:45:19'),
(8, '02', 'allowance', 'Attendance Bonus', 'no', 'active', 'admin', '2016-06-01 18:19:38', '2016-06-01 18:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `allowancedeductionmeta`
--

CREATE TABLE IF NOT EXISTS `allowancedeductionmeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fieldId` int(11) NOT NULL,
  `workPass` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `allowancedeductionmeta`
--

INSERT INTO `allowancedeductionmeta` (`id`, `fieldId`, `workPass`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '500.00', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(2, 1, 2, '0.00', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(3, 1, 3, '0.00', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(4, 1, 4, '0.00', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(5, 1, 5, '0.00', '2016-06-01 11:53:51', '2016-06-01 11:53:51'),
(6, 2, 1, '500.00', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(7, 2, 2, '0.00', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(8, 2, 3, '0.00', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(9, 2, 4, '0.00', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(10, 2, 5, '0.00', '2016-06-01 11:54:12', '2016-06-01 11:54:12'),
(11, 3, 1, '400.00', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(12, 3, 2, '0.00', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(13, 3, 3, '0.00', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(14, 3, 4, '0.00', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(15, 3, 5, '0.00', '2016-06-01 11:54:43', '2016-06-01 11:54:43'),
(16, 4, 1, '1000.00', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(17, 4, 2, '0.00', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(18, 4, 3, '0.00', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(19, 4, 4, '0.00', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(20, 4, 5, '0.00', '2016-06-01 11:55:20', '2016-06-01 11:55:20'),
(21, 5, 1, '2450.00', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(22, 5, 2, '0.00', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(23, 5, 3, '0.00', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(24, 5, 4, '0.00', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(25, 5, 5, '0.00', '2016-06-01 11:56:09', '2016-06-01 11:56:09'),
(26, 6, 1, '0.00', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(27, 6, 2, '0.00', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(28, 6, 3, '0.00', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(29, 6, 4, '0.00', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(30, 6, 5, '50.00', '2016-06-01 16:31:36', '2016-06-01 16:31:36'),
(45, 7, 5, '200.00', '2016-06-02 16:45:19', '2016-06-02 16:45:19'),
(44, 7, 4, '0.00', '2016-06-02 16:45:19', '2016-06-02 16:45:19'),
(43, 7, 3, '0.00', '2016-06-02 16:45:19', '2016-06-02 16:45:19'),
(42, 7, 2, '0.00', '2016-06-02 16:45:19', '2016-06-02 16:45:19'),
(41, 7, 1, '0.00', '2016-06-02 16:45:19', '2016-06-02 16:45:19'),
(36, 8, 1, '0.00', '2016-06-01 18:19:38', '2016-06-01 18:19:38'),
(37, 8, 2, '0.00', '2016-06-01 18:19:38', '2016-06-01 18:19:38'),
(38, 8, 3, '0.00', '2016-06-01 18:19:38', '2016-06-01 18:19:38'),
(39, 8, 4, '0.00', '2016-06-01 18:19:38', '2016-06-01 18:19:38'),
(40, 8, 5, '50.00', '2016-06-01 18:19:38', '2016-06-01 18:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `applyleavemeta`
--

CREATE TABLE IF NOT EXISTS `applyleavemeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applyLeaveId` int(11) NOT NULL,
  `leaveDate` date NOT NULL,
  `leaveYear` year(4) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `leaveType` int(11) NOT NULL,
  `status` enum('pending','approved','canceled') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `applyleaves`
--

CREATE TABLE IF NOT EXISTS `applyleaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `leaveType` int(11) NOT NULL,
  `leaveFrom` date NOT NULL,
  `leaveTo` date NOT NULL,
  `leaveYear` year(4) NOT NULL,
  `totalDays` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','canceled') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  `updatedBy` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cdacformula`
--

CREATE TABLE IF NOT EXISTS `cdacformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('less','between','greater') NOT NULL DEFAULT 'less',
  `amountFrom` decimal(10,2) NOT NULL,
  `amountTo` decimal(10,2) NOT NULL,
  `cdacAmount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `cdacformula`
--

INSERT INTO `cdacformula` (`id`, `type`, `amountFrom`, `amountTo`, `cdacAmount`, `created_at`, `updated_at`) VALUES
(33, 'less', '2000.00', '0.00', '0.50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'between', '2000.00', '3500.00', '1.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'between', '3500.00', '5000.00', '1.50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'between', '5000.00', '7500.00', '2.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'greater', '7500.00', '0.00', '3.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `claims`
--

CREATE TABLE IF NOT EXISTS `claims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(100) NOT NULL,
  `lable` varchar(100) NOT NULL,
  `priceType` varchar(100) NOT NULL,
  `minimumHours` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `claimsdetails`
--

CREATE TABLE IF NOT EXISTS `claimsdetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `claimsId` varchar(16) NOT NULL,
  `company` varchar(16) NOT NULL,
  `paymentFrom` date NOT NULL,
  `paymentTo` date NOT NULL,
  `paymentDate` date NOT NULL,
  `totalWorkingLimit` float NOT NULL,
  `employee` varchar(16) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `status` enum('draft','issued') NOT NULL DEFAULT 'draft',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `claimsdetailsbasics`
--

CREATE TABLE IF NOT EXISTS `claimsdetailsbasics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `claimsId` varchar(16) NOT NULL,
  `employee` varchar(16) NOT NULL,
  `paymentFrom` date NOT NULL,
  `paymentTo` date NOT NULL,
  `paymentDate` date NOT NULL,
  `company` varchar(16) NOT NULL,
  `calculatedBy` enum('month','day','hour') NOT NULL DEFAULT 'month',
  `perRate` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('basics','draft','completed') NOT NULL DEFAULT 'basics',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `claimsdetailsmeta`
--

CREATE TABLE IF NOT EXISTS `claimsdetailsmeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `claimsTableId` int(11) NOT NULL,
  `workDate` date DEFAULT NULL,
  `fieldId` varchar(10) NOT NULL,
  `timeIn` int(11) DEFAULT NULL,
  `timeOut` int(11) DEFAULT NULL,
  `totalTime` int(11) DEFAULT NULL,
  `fieldValue` decimal(10,2) NOT NULL,
  `claimType` enum('perday','permonth') NOT NULL DEFAULT 'perday',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payslipId` (`claimsTableId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `claimsdetailsmeta`
--

INSERT INTO `claimsdetailsmeta` (`id`, `claimsTableId`, `workDate`, `fieldId`, `timeIn`, `timeOut`, `totalTime`, `fieldValue`, `claimType`, `created_at`, `updated_at`) VALUES
(1, 1, '2016-04-01', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(2, 1, '2016-04-01', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(3, 1, '2016-04-02', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(4, 1, '2016-04-02', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(5, 1, '2016-04-03', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(6, 1, '2016-04-03', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(7, 1, '2016-04-04', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(8, 1, '2016-04-04', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(9, 1, '2016-04-05', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(10, 1, '2016-04-05', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(11, 1, '2016-04-06', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(12, 1, '2016-04-06', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(13, 1, '2016-04-07', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(14, 1, '2016-04-07', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(15, 1, '2016-04-08', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(16, 1, '2016-04-08', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(17, 1, '2016-04-09', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(18, 1, '2016-04-09', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(19, 1, '2016-04-10', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(20, 1, '2016-04-10', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(21, 1, '2016-04-11', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(22, 1, '2016-04-11', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(23, 1, '2016-04-12', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(24, 1, '2016-04-12', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(25, 1, '2016-04-13', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(26, 1, '2016-04-13', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(27, 1, '2016-04-14', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(28, 1, '2016-04-14', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(29, 1, '2016-04-15', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(30, 1, '2016-04-15', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(31, 1, '2016-04-16', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(32, 1, '2016-04-16', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(33, 1, '2016-04-17', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(34, 1, '2016-04-17', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(35, 1, '2016-04-18', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(36, 1, '2016-04-18', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(37, 1, '2016-04-19', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(38, 1, '2016-04-19', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(39, 1, '2016-04-20', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(40, 1, '2016-04-20', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(41, 1, '2016-04-21', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(42, 1, '2016-04-21', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(43, 1, '2016-04-22', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(44, 1, '2016-04-22', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(45, 1, '2016-04-23', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(46, 1, '2016-04-23', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(47, 1, '2016-04-24', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(48, 1, '2016-04-24', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(49, 1, '2016-04-25', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(50, 1, '2016-04-25', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(51, 1, '2016-04-26', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(52, 1, '2016-04-26', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(53, 1, '2016-04-27', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(54, 1, '2016-04-27', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(55, 1, '2016-04-28', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(56, 1, '2016-04-28', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(57, 1, '2016-04-29', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(58, 1, '2016-04-29', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(59, 1, '2016-04-30', '4', 39600, 79200, 39600, '10.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(60, 1, '2016-04-30', '5', 39600, 79200, 39600, '5.00', 'perday', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(61, 1, NULL, '6', NULL, NULL, NULL, '120.00', 'permonth', '2016-04-27 10:18:52', '2016-04-27 10:18:52'),
(62, 2, '2016-04-01', '11', NULL, NULL, 27000, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(63, 2, '2016-04-02', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(64, 2, '2016-04-03', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(65, 2, '2016-04-04', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(66, 2, '2016-04-05', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(67, 2, '2016-04-06', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(68, 2, '2016-04-07', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(69, 2, '2016-04-08', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(70, 2, '2016-04-09', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(71, 2, '2016-04-10', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(72, 2, '2016-04-11', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(73, 2, '2016-04-12', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(74, 2, '2016-04-13', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(75, 2, '2016-04-14', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(76, 2, '2016-04-15', '11', NULL, NULL, 16200, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(77, 2, '2016-04-16', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(78, 2, '2016-04-17', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(79, 2, '2016-04-18', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(80, 2, '2016-04-19', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(81, 2, '2016-04-20', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(82, 2, '2016-04-21', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(83, 2, '2016-04-22', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(84, 2, '2016-04-23', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(85, 2, '2016-04-24', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(86, 2, '2016-04-25', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(87, 2, '2016-04-26', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(88, 2, '2016-04-27', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(89, 2, '2016-04-28', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(90, 2, '2016-04-29', '11', NULL, NULL, 28800, '20.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(91, 2, '2016-04-30', '11', NULL, NULL, NULL, '0.00', 'perday', '2016-05-09 17:32:59', '2016-05-09 17:32:59'),
(92, 2, NULL, '10', NULL, NULL, NULL, '200.00', 'permonth', '2016-05-09 17:32:59', '2016-05-09 17:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(32) NOT NULL,
  `cpfAccountNo` varchar(32) NOT NULL,
  `authorisedPersonName` varchar(32) NOT NULL,
  `authorisedPersonDesignation` varchar(32) NOT NULL,
  `organisationIdType` enum('7','8','A','I','U') DEFAULT NULL,
  `organisationIdNo` varchar(10) NOT NULL,
  `address` varchar(52) NOT NULL,
  `city` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `contactPerson` varchar(100) NOT NULL,
  `email` varchar(52) NOT NULL,
  `startDate` tinyint(4) unsigned NOT NULL,
  `startMonth` tinyint(4) unsigned NOT NULL,
  `endDate` tinyint(4) unsigned NOT NULL,
  `endMonth` tinyint(4) unsigned NOT NULL,
  `companyLogo` text NOT NULL,
  `followingYear` enum('yes','no') NOT NULL DEFAULT 'no',
  `status` enum('active','inactive','deleted') NOT NULL,
  `createdBy` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `code`, `name`, `cpfAccountNo`, `authorisedPersonName`, `authorisedPersonDesignation`, `organisationIdType`, `organisationIdNo`, `address`, `city`, `state`, `postalCode`, `phone`, `fax`, `contactPerson`, `email`, `startDate`, `startMonth`, `endDate`, `endMonth`, `companyLogo`, `followingYear`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'GH', 'Genting Hotel Pay roll', '1234567890', 'Parthasarathi', 'HR Manager', '7', '12345678', '2 Town Hall Link', 'Singapore', 'Singapore', '608516', '+65 6577 8899', '+65 6577 8899', 'Parthasarathi', 'admin@gentinghotel.com', 1, 1, 31, 12, '', 'no', 'active', 'admin', '2016-04-18 14:16:50', '2016-04-18 14:25:44'),
(2, 'HC', 'HERTZ CARSHOWROOM', '1234567890', 'Parthasarathi', 'HR Manager', '7', '12345678', '2 Town Hall Link', 'Singapore', 'Singapore', '608516', '+65 6577 8899', '+65 6577 8899', 'Parthasarathi', 'admin@hertzcarshowroom.com', 1, 1, 31, 12, '', 'no', 'active', 'admin', '2016-04-18 14:19:14', '2016-04-18 14:19:14'),
(3, 'RWS', 'RWS', '1234', 'mohan', 'md', '7', '1234', '', '', '', '', '', '', '', '', 1, 1, 31, 12, '', 'no', 'deleted', 'admin', '2016-05-09 16:49:56', '2016-05-10 16:58:13'),
(4, '02', 'MBS', '1234', 'SATHYA', 'ADMIN', '8', '5678', 'MARINA BAY SANDS', 'SINGAPORE', 'SINGAPORE', '520625', '62502118', '62502117', 'PRABHA', 'admin@prestigevalet.com.sg', 1, 1, 31, 12, '', 'no', 'active', 'admin', '2016-05-10 17:04:41', '2016-05-10 17:04:41'),
(5, 'vw(Alex)', 'vw(Alex)', '123', 'lim', 'manager', 'A', '3214', '', '', '', '', '', '', '', '', 1, 1, 31, 12, '', 'no', 'active', 'admin', '2016-05-10 18:11:55', '2016-05-10 18:11:55'),
(6, '10', 'RWS', '1234', 'SATHYA', 'ADMIN', 'A', '5678', 'RESORT WORLD SENTOSA', 'SINGAPORE', 'SINGAPORE', '520625', '', '', '', '', 1, 1, 31, 12, '', 'no', 'active', 'admin', '2016-05-12 17:28:35', '2016-05-12 17:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `companyusers`
--

CREATE TABLE IF NOT EXISTS `companyusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(20) NOT NULL,
  `userName` varchar(32) NOT NULL,
  `password` varchar(100) NOT NULL,
  `createdBy` varchar(20) NOT NULL,
  `status` enum('active','inactive','deleted') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companyworkingdays`
--

CREATE TABLE IF NOT EXISTS `companyworkingdays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `month` tinyint(4) NOT NULL,
  `totalWorkingDays` tinyint(4) NOT NULL,
  `weeklyWorkingDays` float NOT NULL,
  `workingDays` float NOT NULL,
  `offDays` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `companyworkingdays`
--

INSERT INTO `companyworkingdays` (`id`, `year`, `month`, `totalWorkingDays`, `weeklyWorkingDays`, `workingDays`, `offDays`) VALUES
(1, 2016, 1, 31, 5, 21, 10),
(2, 2016, 1, 31, 5.5, 23.5, 7.5),
(3, 2016, 1, 31, 6, 26, 5),
(4, 2016, 2, 29, 5, 21, 8),
(5, 2016, 2, 29, 5.5, 23, 6),
(6, 2016, 2, 29, 6, 25, 4),
(7, 2016, 3, 31, 5, 23, 8),
(8, 2016, 3, 31, 5.5, 25, 6),
(9, 2016, 3, 31, 6, 27, 4),
(10, 2016, 4, 30, 5, 21, 9),
(11, 2016, 4, 30, 5.5, 23.5, 6.5),
(12, 2016, 4, 30, 6, 26, 4),
(13, 2016, 5, 31, 5, 22, 9),
(14, 2016, 5, 31, 5.5, 24, 7),
(15, 2016, 5, 31, 6, 26, 5),
(16, 2016, 6, 30, 5, 22, 8),
(17, 2016, 6, 30, 5.5, 24, 6),
(18, 2016, 6, 30, 6, 26, 4),
(19, 2016, 7, 31, 5, 21, 10),
(20, 2016, 7, 31, 5.5, 23.5, 7.5),
(21, 2016, 7, 31, 6, 26, 5),
(22, 2016, 8, 31, 5, 23, 8),
(23, 2016, 8, 31, 5.5, 25, 6),
(24, 2016, 8, 31, 6, 27, 4),
(25, 2016, 9, 30, 5, 22, 8),
(26, 2016, 9, 30, 5.5, 24, 6),
(28, 2016, 9, 30, 6, 26, 4),
(29, 2016, 10, 31, 5, 21, 10),
(30, 2016, 10, 31, 5.5, 23.5, 7.5),
(31, 2016, 10, 31, 6, 26, 5),
(32, 2016, 11, 30, 5, 22, 8),
(33, 2016, 11, 30, 5.5, 24, 6),
(34, 2016, 11, 30, 6, 26, 4),
(35, 2016, 12, 31, 5, 22, 9),
(36, 2016, 12, 31, 5.5, 24.5, 6.5),
(37, 2016, 12, 31, 6, 27, 4);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(101, 'BELGIUM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'DENMARK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'FRANCE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'GERMANY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'GREECE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'IRELAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'ITALY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'LUXEMBOURG', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'NETHERLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'UNITED KINGDOM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'PORTUGAL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'SPAIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'AUSTRIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 'FINLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 'ICELAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 'NORWAY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 'SVALBARD JAN MAYEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 'SWEDEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'SWITZERLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 'LIECHSTENSTEIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'BOUVET ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'FAEROE ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'GREENLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 'MONACO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'SAN MARINO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'VATICAN CITY STATE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'TURKEY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'ANDORRA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'GIBRALTAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 'MALTA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'ALBANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 'BULGARIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 'CZECHOSLOVAKIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 'HUNGARY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 'POLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 'ROMANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 'YUGOSLAVIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 'BELARUS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 'UKRAINE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 'ESTONIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 'LATVIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 'LITHUANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 'GEORGIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 'ARMENIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'AZERBAIJAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'KYRGYZSTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 'KAZAKHSTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'MOLDOVA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'RUSSIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'TAJIKISTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'TURKMENISTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'UZBEKISTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 'CROATIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'SLOVENIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'CZECH REPUBLIC', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 'SLOVAK REPUBLIC', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(301, 'SINGAPORE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(302, 'BRUNEI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(303, 'INDONESIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(304, 'MALAYSIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(305, 'PHILIPPINES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(306, 'THAILAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(307, 'EAST TIMOR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(311, 'MYANMAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(312, 'CAMBODIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(313, 'LAOS PEO DEM REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(314, 'VIETNAM SOC REP OF', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(319, 'O C IN S E ASIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(331, 'JAPAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(332, 'HONG KONG', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(333, 'REP OF KOREA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(334, 'TAIWAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(335, 'MACAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(336, ' PEOPLE''S REPUBLIC OF CHINA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(337, 'KOREA NORTH DEM PEO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(338, 'MONGOLIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(351, 'AFGHANISTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(352, 'BANGLADESH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(353, 'BHUTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(354, 'INDIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(355, 'MALDIVES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(356, 'NEPAL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(357, 'PAKISTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(358, 'SRI LANKA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(371, 'BAHRAIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(372, 'CYPRUS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(373, 'ISLAMIC REP OF IRAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(374, 'IRAQ', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(375, 'ISRAEL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(376, 'JORDAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(377, 'KUWAIT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(378, 'LEBANON', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(379, 'OMAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(380, 'QATAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(381, 'SAUDI ARABIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(382, 'SYRIAN ARAB REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(383, 'UNITED ARAB EMIRATES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(384, 'YEMEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(385, 'DEMOCRATIC YEMEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(386, 'PALESTINE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(401, 'ALGERIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(402, 'EGYPT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(403, 'LIBYA A JAMAHIRIYA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(404, 'MOROCCO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(405, 'SUDAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(406, 'TUNISIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(407, 'DJIBOUTI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(408, 'ETHIOPIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(409, 'DEM REP OF SOMALI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(410, 'ERITREA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(421, 'GHANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(422, 'COTE DIVOIRE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(423, 'KENYA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(424, 'LIBERIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(425, 'MADAGASCAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(426, 'MAURITIUS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(427, 'MOZAMBIQUE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(428, 'NIGERIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(429, 'REUNION ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(430, 'TANZANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(431, 'UGANDA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(432, 'ZAMBIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(451, 'ANGOLA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(452, 'BENIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(453, 'BOTSWANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(454, 'BURKINA FASO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(455, 'BURUNDI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(456, 'CAMEROON UNITED REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(457, 'CAPE VERDE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(458, 'CENTRAL AFRICAN REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(459, 'CHAD', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(460, 'COMOROS ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(461, 'CONGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(462, 'EQUATORIAL GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(463, 'GABON', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(464, 'GAMBIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(465, 'GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(466, 'GUINES BISSAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(467, 'LESOTHO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(468, 'MALAWI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(469, 'MALI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(470, 'MAURITANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(471, 'NAMIBIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(472, 'NIGER', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(473, 'RWANDA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(474, 'SAO TOME PRINCIPE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(475, 'SENEGAL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(476, 'SEYCHELLES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(477, 'SIERRA LEONE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(478, 'SOUTH AFRICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(479, 'WESTERN SAHARA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(480, 'SWAZILAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(481, 'TOGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(482, 'REP OF ZAIRE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(483, 'ZIMBABWE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(484, 'ST HELENA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(499, 'O C IN OTHER AFRICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(501, 'CANADA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(502, 'PUERTO RICO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(503, 'UNITED STATES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(504, 'U S MINOR ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(505, 'ST PIERRE MIQUELON', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(509, 'OC NORTH AMERICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(601, 'ARGENTINA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(602, 'BRAZIL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(603, 'CHILE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(604, 'COLOMBIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(605, 'ECUADOR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(606, 'MEXICO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(607, 'PARAGUAY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(608, 'PERU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(609, 'URUGUAY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(610, 'VENEZUELA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(621, 'CUBA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(622, 'DOMINICAN REPUBLIC', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(623, 'NETHERLANDS ANTILLES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(624, 'PANAMA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(625, 'ARUBA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(641, 'ANTIGUA AND BARBUDA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(642, 'BAHAMAS ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(643, 'BARBADOS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(644, 'BELIZE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(645, 'BERMUDA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(646, 'BOLIVIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(647, 'CAYMAN ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(648, 'COSTA RICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(649, 'DOMINICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(650, 'EL SALVADOR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(651, 'FALKLAND IS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(652, 'FRENCH GUIANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(653, 'GRENADA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(654, 'GUADELOUPE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(655, 'GUATEMALA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(656, 'GUYANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(657, 'HAITI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(658, 'HONDURAS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(659, 'JAMAICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(660, 'NICARAGUA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(661, 'MARTINIQUE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(662, 'MONTSERRAT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(663, 'SAINT KITTS NEVIS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(664, 'SAINT LUCIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(665, 'SAINT VINCENT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(666, 'SURINAM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(667, 'TRINIDAD AND TOBAGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(668, 'TURKS AND CAICOS IS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(669, 'VIRGIN ISLANDS US', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(670, 'ANGUILLA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(671, 'BRITISH VIRGIN ISLND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(672, 'ISLE OF MAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(699, 'OC CTRL STH AMERICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(701, 'AUSTRALIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(702, 'FIJI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(703, 'NAURU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(704, 'NEW CALEDONIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(705, 'NEW ZEALAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(706, 'PAPUA NEW GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(707, 'SAMOA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(708, 'BRITISH INDIAN OCEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(709, 'CHRISTMAS ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(710, 'COCOS KEELING ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(711, 'FRENCH SOUTHERN TERR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(712, 'HEARD MCDONALD ISLND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(713, 'NORFOLK ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(721, 'AMERICAN SAMOA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(722, 'COOK ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(723, 'FRENCH POLYNESIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(724, 'GUAM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(725, 'KIRIBATI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(726, 'NIUE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(727, 'PITCAIRN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(728, 'SOLOMON ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(729, 'TOKELAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(730, 'TONGA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(731, 'TUVALU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(732, 'NEW HERBRIDES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(733, 'WALLIS AND FUTUNA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(734, 'NORTHERN MARIANA ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(735, 'MARSHALL ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(736, 'MICRONESIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(737, 'PALAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(799, 'OC OCEANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(999, 'OTHERS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1000, 'South Sudan', 'active', 'US0001', '2016-04-13 13:26:16', '2016-04-13 13:26:16'),
(1001, 'Kosovo', 'active', 'US0001', '2016-04-13 13:26:41', '2016-04-13 13:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `cpf`
--

CREATE TABLE IF NOT EXISTS `cpf` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpfYear` year(4) NOT NULL,
  `ageSignFirst` tinyint(4) NOT NULL,
  `ageFrom` tinyint(3) unsigned NOT NULL,
  `ageSignSecond` tinyint(4) DEFAULT NULL,
  `ageTo` tinyint(3) unsigned DEFAULT NULL,
  `wagesSignFirst` tinyint(4) NOT NULL,
  `wagesFrom` decimal(10,2) NOT NULL,
  `wagesSignSecond` tinyint(4) DEFAULT NULL,
  `wagesTo` decimal(10,2) DEFAULT NULL,
  `spryear` enum('1','2','3') NOT NULL DEFAULT '3',
  `employeeMax` decimal(10,2) NOT NULL,
  `employerMax` decimal(10,2) NOT NULL,
  `totalMax` decimal(10,2) NOT NULL,
  `employeeCpf` enum('yes','no') NOT NULL DEFAULT 'no',
  `employerCpf` enum('yes','no') NOT NULL DEFAULT 'no',
  `employeeCpfFormula` varchar(50) NOT NULL,
  `employerCpfFormula` varchar(50) NOT NULL,
  `totalCpfFormula` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

--
-- Dumping data for table `cpf`
--

INSERT INTO `cpf` (`id`, `cpfYear`, `ageSignFirst`, `ageFrom`, `ageSignSecond`, `ageTo`, `wagesSignFirst`, `wagesFrom`, `wagesSignSecond`, `wagesTo`, `spryear`, `employeeMax`, `employerMax`, `totalMax`, `employeeCpf`, `employerCpf`, `employeeCpfFormula`, `employerCpfFormula`, `totalCpfFormula`, `created_at`, `updated_at`) VALUES
(1, 2016, 2, 55, 0, 0, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(2, 2016, 2, 55, 0, 0, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '17% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(3, 2016, 2, 55, 0, 0, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.6 (TW - 500)', '17% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(4, 2016, 2, 55, 0, 0, 4, '750.00', 0, '0.00', '3', '1200.00', '1020.00', '2220.00', 'yes', 'yes', '20% (OW) + 20% (AW)', '17% (OW) + 17% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(5, 2016, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(6, 2016, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '13% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(7, 2016, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.39 (TW - 500)', '13% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(8, 2016, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '3', '780.00', '780.00', '1560.00', 'yes', 'yes', '13% (OW) + 13% (AW)', '13% (OW) + 13% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(9, 2016, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(10, 2016, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(11, 2016, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.225 (TW - 500)', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(12, 2016, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '3', '450.00', '540.00', '990.00', 'yes', 'yes', '7.5% (OW) + 7.5% (AW)', '9% (OW) + 9% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(13, 2016, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(14, 2016, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '7.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(15, 2016, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '7.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(16, 2016, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '3', '300.00', '450.00', '750.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '7.5% (OW) + 7.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(17, 2016, 2, 55, 0, 0, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(18, 2016, 2, 55, 0, 0, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(19, 2016, 2, 55, 0, 0, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(20, 2016, 2, 55, 0, 0, 4, '750.00', 0, '0.00', '1', '300.00', '240.00', '540.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '4% (OW) + 4% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(21, 2016, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(22, 2016, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(23, 2016, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(24, 2016, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '1', '300.00', '240.00', '540.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '4% (OW) + 4% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(25, 2016, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(26, 2016, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(27, 2016, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(28, 2016, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '1', '300.00', '210.00', '510.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(29, 2016, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(30, 2016, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(31, 2016, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(32, 2016, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '1', '300.00', '210.00', '510.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(33, 2016, 2, 55, 0, 0, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(34, 2016, 2, 55, 0, 0, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(35, 2016, 2, 55, 0, 0, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.45 (TW - 500)', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(36, 2016, 2, 55, 0, 0, 4, '750.00', 0, '0.00', '2', '900.00', '540.00', '1440.00', 'yes', 'yes', '15% (OW) + 15% (AW)', '9% (OW) + 9% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(37, 2016, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(38, 2016, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '6% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(39, 2016, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.375 (TW - 500)', '6% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(40, 2016, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '2', '750.00', '360.00', '1110.00', 'yes', 'yes', '12.5% (OW) + 12.5% (AW)', '6% (OW) + 6% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(41, 2016, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(42, 2016, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(43, 2016, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.225 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(44, 2016, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '2', '450.00', '210.00', '660.00', 'yes', 'yes', '7.5% (OW) + 7.5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(45, 2016, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(46, 2016, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(47, 2016, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(48, 2016, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '2', '300.00', '210.00', '510.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(115, 2015, 2, 50, 0, 0, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(116, 2015, 2, 50, 0, 0, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '17% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(117, 2015, 2, 50, 0, 0, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.6 (TW - 500)', '17% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(118, 2015, 2, 50, 0, 0, 4, '750.00', 0, '0.00', '3', '1000.00', '850.00', '1850.00', 'yes', 'yes', '20% (AW) + 20% (OW)', '17% (OW) + 17% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(119, 2015, 3, 50, 2, 55, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(120, 2015, 3, 50, 2, 55, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '16% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(121, 2015, 3, 50, 2, 55, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.57 (TW - 500)', '16% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(122, 2015, 3, 50, 2, 55, 4, '750.00', 0, '0.00', '3', '950.00', '800.00', '1750.00', 'yes', 'yes', '19% (OW) + 19% (AW)', '16% (OW) + 16% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(123, 2015, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(124, 2015, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '12% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(125, 2015, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.39 (TW - 500)', '12% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(126, 2015, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '3', '650.00', '600.00', '1250.00', 'yes', 'yes', '13% (OW) + 13% (AW)', '12% (OW) + 12% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(127, 2015, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(128, 2015, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '12% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(129, 2015, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.225 (TW - 500)', '8.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(130, 2015, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '3', '375.00', '425.00', '800.00', 'yes', 'yes', '7.5% (OW) + 7.5% (AW)', '8.5% (OW) + 8.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(131, 2015, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '3', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(132, 2015, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '3', '0.00', '0.00', '0.00', 'no', 'yes', '', '7.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(133, 2015, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '3', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '7.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(134, 2015, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '3', '250.00', '375.00', '625.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '7.5% (OW) + 7.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(135, 2015, 2, 50, 0, 0, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(136, 2015, 2, 50, 0, 0, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(137, 2015, 2, 50, 0, 0, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(138, 2015, 2, 50, 0, 0, 4, '750.00', 0, '0.00', '1', '250.00', '200.00', '450.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '4% (OW) + 4% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(139, 2015, 3, 50, 2, 55, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(140, 2015, 3, 50, 2, 55, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(141, 2015, 3, 50, 2, 55, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(142, 2015, 3, 50, 2, 55, 4, '750.00', 0, '0.00', '1', '250.00', '200.00', '450.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '4% (OW) + 4% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(143, 2015, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(144, 2015, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(145, 2015, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '4% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(146, 2015, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '1', '250.00', '200.00', '450.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '4% (OW) + 4% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(147, 2015, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(148, 2015, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(149, 2015, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(150, 2015, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '1', '250.00', '175.00', '425.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(151, 2015, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '1', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(152, 2015, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '1', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(153, 2015, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '1', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(154, 2015, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '1', '250.00', '175.00', '425.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(155, 2015, 2, 50, 0, 0, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(156, 2015, 2, 50, 0, 0, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(157, 2015, 2, 50, 0, 0, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.45 (TW - 500)', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(158, 2015, 2, 50, 0, 0, 4, '750.00', 0, '0.00', '2', '750.00', '450.00', '1200.00', 'yes', 'yes', '15% (OW) + 15% (AW)', '9% (OW) + 9% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(160, 2015, 3, 50, 2, 55, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(161, 2015, 3, 50, 2, 55, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(162, 2015, 3, 50, 2, 55, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.45 (TW - 500)', '9% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(163, 2015, 3, 50, 2, 55, 4, '750.00', 0, '0.00', '2', '750.00', '450.00', '1200.00', 'yes', 'yes', '15% (OW) + 15% (AW)', '9% (OW) + 9% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(164, 2015, 3, 55, 2, 60, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(165, 2015, 3, 55, 2, 60, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '6% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(166, 2015, 3, 55, 2, 60, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.375 (TW - 500)', '6% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(167, 2015, 3, 55, 2, 60, 4, '750.00', 0, '0.00', '2', '625.00', '300.00', '925.00', 'yes', 'yes', '12.5% (OW) + 12.5% (AW)', '6% (OW) + 6% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(168, 2015, 3, 60, 2, 65, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(169, 2015, 3, 60, 2, 65, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(170, 2015, 3, 60, 2, 65, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.225 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(171, 2015, 3, 60, 2, 65, 4, '750.00', 0, '0.00', '2', '375.00', '175.00', '550.00', 'yes', 'yes', '7.5% (OW) + 7.5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(172, 2015, 3, 65, 0, 0, 2, '50.00', 0, '0.00', '2', '0.00', '0.00', '0.00', 'no', 'no', '', '', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(174, 2015, 3, 65, 0, 0, 3, '50.00', 2, '500.00', '2', '0.00', '0.00', '0.00', 'no', 'yes', '', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(175, 2015, 3, 65, 0, 0, 3, '500.00', 1, '750.00', '2', '0.00', '0.00', '0.00', 'yes', 'yes', '0.15 (TW - 500)', '3.5% (TW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(176, 2015, 3, 65, 0, 0, 4, '750.00', 0, '0.00', '2', '250.00', '175.00', '425.00', 'yes', 'yes', '5% (OW) + 5% (AW)', '3.5% (OW) + 3.5% (AW)', '', '2016-04-06 06:20:20', '2016-04-06 06:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `cpfformula`
--

CREATE TABLE IF NOT EXISTS `cpfformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpfId` int(10) unsigned NOT NULL,
  `wages` enum('tw','aw','ow','previous') DEFAULT 'tw',
  `wagesSign` enum('plus','minus','multiply','percentage') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,3) NOT NULL,
  `type` enum('employee','employer','total') NOT NULL DEFAULT 'employee',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=218 ;

--
-- Dumping data for table `cpfformula`
--

INSERT INTO `cpfformula` (`id`, `cpfId`, `wages`, `wagesSign`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 'tw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(2, 3, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(3, 3, 'previous', 'multiply', '0.600', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(4, 3, 'tw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(5, 4, 'ow', 'percentage', '20.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(6, 4, 'aw', 'percentage', '20.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(7, 4, 'ow', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(8, 4, 'aw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(9, 6, 'tw', 'percentage', '13.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(10, 7, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(11, 7, 'previous', 'multiply', '0.390', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(12, 7, 'tw', 'percentage', '13.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(13, 8, 'ow', 'percentage', '13.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(14, 8, 'aw', 'percentage', '13.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(15, 8, 'ow', 'percentage', '13.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(16, 8, 'aw', 'percentage', '13.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(17, 10, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(18, 11, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(19, 11, 'previous', 'multiply', '0.225', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(20, 11, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(21, 12, 'ow', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(22, 12, 'aw', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(23, 12, 'ow', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(24, 12, 'aw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(25, 14, 'tw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(26, 15, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(27, 15, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(28, 15, 'tw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(29, 16, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(30, 16, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(31, 16, 'ow', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(32, 16, 'aw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(33, 18, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(34, 19, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(35, 19, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(36, 19, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(37, 20, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(38, 20, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(39, 20, 'ow', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(40, 20, 'aw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(41, 22, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(42, 23, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(43, 23, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(44, 23, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(45, 24, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(46, 24, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(47, 24, 'ow', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(48, 24, 'aw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(49, 26, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(50, 27, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(51, 27, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(52, 27, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(53, 28, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(54, 28, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(55, 28, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(56, 28, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(57, 30, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(58, 31, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(59, 31, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(60, 31, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(61, 32, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(62, 32, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(63, 32, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(64, 32, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(65, 34, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(66, 35, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(67, 35, 'previous', 'multiply', '0.450', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(68, 35, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(69, 36, 'ow', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(70, 36, 'aw', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(71, 36, 'ow', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(72, 36, 'aw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(73, 38, 'tw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(74, 39, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(75, 39, 'previous', 'multiply', '0.375', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(76, 39, 'tw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(77, 40, 'ow', 'percentage', '12.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(78, 40, 'aw', 'percentage', '12.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(79, 40, 'ow', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(80, 40, 'aw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(81, 42, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(82, 43, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(83, 43, 'previous', 'multiply', '0.225', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(84, 43, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(85, 44, 'ow', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(86, 44, 'aw', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(87, 44, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(88, 44, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(89, 46, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(90, 47, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(91, 47, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(92, 47, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(93, 48, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(94, 48, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(95, 48, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(96, 48, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(97, 116, 'tw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(98, 117, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(99, 117, 'previous', 'multiply', '0.600', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(100, 117, 'tw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(101, 118, 'aw', 'percentage', '20.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(102, 118, 'ow', 'percentage', '20.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(103, 118, 'ow', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(104, 118, 'aw', 'percentage', '17.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(105, 120, 'tw', 'percentage', '16.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(106, 121, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(107, 121, 'previous', 'multiply', '0.570', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(108, 121, 'tw', 'percentage', '16.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(109, 122, 'ow', 'percentage', '19.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(110, 122, 'aw', 'percentage', '19.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(111, 122, 'ow', 'percentage', '16.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(112, 122, 'aw', 'percentage', '16.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(113, 124, 'tw', 'percentage', '12.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(114, 125, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(115, 125, 'previous', 'multiply', '0.390', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(116, 125, 'tw', 'percentage', '12.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(117, 126, 'ow', 'percentage', '13.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(118, 126, 'aw', 'percentage', '13.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(119, 126, 'ow', 'percentage', '12.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(120, 126, 'aw', 'percentage', '12.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(121, 128, 'tw', 'percentage', '12.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(122, 129, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(123, 129, 'previous', 'multiply', '0.225', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(124, 129, 'tw', 'percentage', '8.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(125, 130, 'ow', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(126, 130, 'aw', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(127, 130, 'ow', 'percentage', '8.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(128, 130, 'aw', 'percentage', '8.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(129, 132, 'tw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(130, 133, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(131, 133, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(132, 133, 'tw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(133, 134, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(134, 134, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(135, 134, 'ow', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(136, 134, 'aw', 'percentage', '7.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(137, 136, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(138, 137, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(139, 137, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(140, 137, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(141, 138, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(142, 138, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(143, 138, 'ow', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(144, 138, 'aw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(145, 140, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(146, 141, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(147, 141, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(148, 141, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(149, 142, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(150, 142, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(151, 142, 'ow', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(152, 142, 'aw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(153, 144, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(154, 145, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(155, 145, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(156, 145, 'tw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(157, 146, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(158, 146, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(159, 146, 'ow', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(160, 146, 'aw', 'percentage', '4.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(161, 148, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(162, 149, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(163, 149, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(164, 149, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(165, 150, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(166, 150, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(167, 150, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(168, 150, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(169, 152, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(170, 153, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(171, 153, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(172, 153, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(173, 154, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(174, 154, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(175, 154, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(176, 154, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(177, 156, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(178, 157, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(179, 157, 'previous', 'multiply', '0.450', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(180, 157, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(181, 158, 'ow', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(182, 158, 'aw', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(183, 158, 'ow', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(184, 158, 'aw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(185, 161, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(186, 162, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(187, 162, 'previous', 'multiply', '0.450', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(188, 162, 'tw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(189, 163, 'ow', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(190, 163, 'aw', 'percentage', '15.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(191, 163, 'ow', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(192, 163, 'aw', 'percentage', '9.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(193, 165, 'tw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(194, 166, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(195, 166, 'previous', 'multiply', '0.375', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(196, 166, 'tw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(197, 167, 'ow', 'percentage', '12.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(198, 167, 'aw', 'percentage', '12.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(199, 167, 'ow', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(200, 167, 'aw', 'percentage', '6.000', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(201, 169, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(202, 170, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(203, 170, 'previous', 'multiply', '0.225', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(204, 170, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(205, 171, 'ow', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(206, 171, 'aw', 'percentage', '7.500', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(207, 171, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(208, 171, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(210, 174, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(211, 175, 'tw', 'minus', '500.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(212, 175, 'previous', 'multiply', '0.150', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(213, 175, 'tw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(214, 176, 'ow', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(215, 176, 'aw', 'percentage', '5.000', 'employee', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(216, 176, 'ow', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20'),
(217, 176, 'aw', 'percentage', '3.500', 'employer', '2016-04-06 06:20:20', '2016-04-06 06:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `ecfformula`
--

CREATE TABLE IF NOT EXISTS `ecfformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('less','between','greater') NOT NULL DEFAULT 'less',
  `amountFrom` decimal(10,2) NOT NULL,
  `amountTo` decimal(10,2) NOT NULL,
  `ecfAmount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `ecfformula`
--

INSERT INTO `ecfformula` (`id`, `type`, `amountFrom`, `amountTo`, `ecfAmount`, `created_at`, `updated_at`) VALUES
(50, 'less', '1000.00', '0.00', '2.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'between', '1000.00', '1500.00', '4.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'between', '1500.00', '2500.00', '6.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'between', '2500.00', '4000.00', '9.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'between', '4000.00', '7000.00', '12.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'between', '7000.00', '10000.00', '16.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'greater', '10000.00', '0.00', '20.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(12, 'Diploma', 'active', 'admin', '2016-04-02 18:10:41', '2016-04-02 18:10:41'),
(15, 'UG', 'active', 'admin', '2016-04-13 13:15:32', '2016-04-13 13:15:32');

-- --------------------------------------------------------

--
-- Table structure for table `employeeconfiguration`
--

CREATE TABLE IF NOT EXISTS `employeeconfiguration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee` varchar(32) NOT NULL,
  `type` enum('allowance','deduction','contribution') NOT NULL DEFAULT 'allowance',
  `configurationId` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `isChecked` enum('yes','no') NOT NULL DEFAULT 'no',
  `createdBy` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=225 ;

--
-- Dumping data for table `employeeconfiguration`
--

INSERT INTO `employeeconfiguration` (`id`, `employee`, `type`, `configurationId`, `amount`, `isChecked`, `createdBy`, `created_at`, `updated_at`) VALUES
(184, 'GH0002', 'allowance', 48, '150.00', 'no', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(185, 'GH0002', 'allowance', 49, '120.00', 'no', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(186, 'GH0002', 'deduction', 52, '0.00', 'no', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(187, 'GH0002', 'deduction', 53, '150.00', 'no', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(188, 'GH0002', 'contribution', 44, '0.00', 'yes', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(189, 'GH0002', 'contribution', 45, '0.00', 'yes', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(190, 'GH0002', 'contribution', 46, '0.00', 'yes', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(191, 'GH0002', 'contribution', 47, '0.00', 'yes', 'admin', '2016-04-18 14:50:52', '2016-04-18 14:50:52'),
(192, 'GH0001', 'allowance', 48, '150.00', 'no', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(193, 'GH0001', 'allowance', 49, '100.00', 'no', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(194, 'GH0001', 'deduction', 52, '0.00', 'no', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(195, 'GH0001', 'deduction', 53, '200.00', 'no', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(196, 'GH0001', 'contribution', 44, '0.00', 'yes', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(197, 'GH0001', 'contribution', 45, '0.00', 'yes', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(198, 'GH0001', 'contribution', 46, '0.00', 'yes', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(199, 'GH0001', 'contribution', 47, '0.00', 'yes', 'admin', '2016-04-18 14:51:02', '2016-04-18 14:51:02'),
(208, 'HC0001', 'allowance', 50, '80.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(209, 'HC0001', 'allowance', 51, '100.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(210, 'HC0001', 'deduction', 54, '120.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(211, 'HC0001', 'deduction', 55, '50.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(212, 'HC0001', 'contribution', 44, '0.00', 'yes', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(213, 'HC0001', 'contribution', 45, '0.00', 'yes', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(214, 'HC0001', 'contribution', 46, '0.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(215, 'HC0001', 'contribution', 47, '0.00', 'no', 'admin', '2016-04-18 16:02:15', '2016-04-18 16:02:15'),
(216, '2661722', 'allowance', 56, '50.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(217, '2661722', 'allowance', 58, '0.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(218, '2661722', 'deduction', 57, '0.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(219, '2661722', 'deduction', 59, '30.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(220, '2661722', 'contribution', 44, '0.00', 'yes', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(221, '2661722', 'contribution', 45, '0.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(222, '2661722', 'contribution', 46, '0.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(223, '2661722', 'contribution', 47, '0.00', 'no', 'admin', '2016-05-09 17:07:48', '2016-05-09 17:07:48'),
(224, '3169252', 'allowance', 60, '0.00', 'no', 'admin', '2016-05-26 15:56:08', '2016-05-26 15:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `employeecontactdetails`
--

CREATE TABLE IF NOT EXISTS `employeecontactdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` varchar(50) NOT NULL,
  `houseNo` varchar(20) NOT NULL,
  `levelNo` varchar(20) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `mobileNo` varchar(15) NOT NULL,
  `workEmail` varchar(50) NOT NULL,
  `streetName` varchar(255) NOT NULL,
  `unitNo` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL,
  `homeTelephone` varchar(15) NOT NULL,
  `otherEmail` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `employeecontactdetails`
--

INSERT INTO `employeecontactdetails` (`id`, `employeeId`, `houseNo`, `levelNo`, `postalCode`, `mobileNo`, `workEmail`, `streetName`, `unitNo`, `country`, `homeTelephone`, `otherEmail`, `created_at`, `updated_at`, `createdBy`) VALUES
(4, 'GH0001', '1 RIVERVALE LINK', '545118', '545118', '', '', '#02-16 RIVERVALE', 'THE SINGAP', '301', '', '', '2016-04-18 14:48:50', '2016-04-18 14:48:50', 0),
(5, 'HC0001', '1 RIVERVALE LINK', '545118', '545118', '', '', '#02-16 RIVERVALE', 'THE SINGAP', '301', '', '', '2016-04-18 14:52:26', '2016-04-18 14:52:26', 0),
(6, 'HC0002', '1 RIVERVALE LINK', '545118', '545118', '', '', '#02-16 RIVERVALE', 'THE SINGAP', '301', '', '', '2016-04-18 14:53:11', '2016-04-18 14:53:11', 0),
(7, 'GH0002', '1 RIVERVALE LINK', '545118', '545118', '', '', '#02-16 RIVERVALE', 'THE SINGAP', '301', '', '', '2016-04-18 14:53:50', '2016-04-18 14:53:50', 0),
(8, '2351277', '12', '8', '570265', '2053698', 'ag@gmail.com', 'sin ming ave', '37', '304', '6253214', 'fe@gmail.com', '2016-04-27 14:41:44', '2016-05-26 10:50:18', 0),
(9, '3000917', '11', '3', '570265', '2053698', 'ag@gmail.com', 'sin ming', '37', '301', '6253214', 'nil', '2016-05-09 10:39:55', '2016-05-09 10:39:55', 0),
(10, '7316991', '11', '3', '570266', '2053698', '', 'sin ming', '37', '301', '6253214', '', '2016-05-10 17:10:16', '2016-05-10 17:10:16', 0),
(11, '2678199', '12', '4', '60005', '849865', '', 'kang ching', '', '', '', '', '2016-05-10 18:21:03', '2016-05-10 18:21:03', 0),
(12, '35092297', '12', '5', '520369', '523698', 'ag@gmail.com', 'bishan', '35', '301', '625389', 'nil', '2016-05-12 10:05:55', '2016-05-12 10:05:55', 0),
(13, '3084593', '15', '7', '520368', '548792', '', 'ANG MO KIO', '38', '354', '625481', '', '2016-05-12 17:39:19', '2016-05-12 17:39:19', 0),
(14, '3162165', ' 731  ', '#13 ', '520731', '', '', 'TAMPINES STREET 71', '129 ', '301', '', '', '2016-05-13 16:17:06', '2016-05-13 16:17:06', 0),
(15, '3006595', '502', '11', '570236', '', '', 'ang mo kio', '236', '301', '', '', '2016-05-26 10:46:06', '2016-05-26 10:46:06', 0),
(16, '2644005', '363', '12', '456789', '', '', 'Bishan', '435', '301', '', '', '2016-05-26 10:53:32', '2016-05-26 10:53:32', 0),
(17, '2633859', '582', '9', '123456', '', '', 'hougang', '125', '301', '', '', '2016-05-26 10:56:39', '2016-05-26 10:56:39', 0),
(18, '7408543', '562', '12', '570425', '', '', 'tekka', '265', '301', '', '', '2016-05-27 11:32:28', '2016-05-27 11:32:28', 0),
(19, '6075753', '567', '2', '570236', '', '', 'ang mo kio', '102', '301', '', '', '2016-05-27 14:39:18', '2016-05-27 14:39:18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employeecontributions`
--

CREATE TABLE IF NOT EXISTS `employeecontributions` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `employeecontributions`
--

INSERT INTO `employeecontributions` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(44, 'SINDA', 'active', 'admin', '2016-04-07 16:13:48', '2016-04-07 16:13:48'),
(45, 'CDAC', 'active', 'admin', '2016-04-07 16:14:22', '2016-04-07 16:14:22'),
(46, 'ECF', 'active', 'admin', '2016-04-08 19:55:41', '2016-04-08 19:55:41'),
(47, 'MBMF', 'active', 'admin', '2016-04-08 19:55:47', '2016-04-08 19:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `employeeemploymentdetails`
--

CREATE TABLE IF NOT EXISTS `employeeemploymentdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `jobTitle` tinyint(4) NOT NULL,
  `employmentStatus` tinyint(4) NOT NULL,
  `jobCategory` tinyint(4) NOT NULL,
  `joinedDate` date NOT NULL,
  `subUnit` tinyint(4) NOT NULL,
  `location` tinyint(4) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `directorFees` decimal(10,2) NOT NULL,
  `directorFeesApprovalDate` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employeeId` (`employeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `employeeemploymentdetails`
--

INSERT INTO `employeeemploymentdetails` (`id`, `employeeId`, `jobTitle`, `employmentStatus`, `jobCategory`, `joinedDate`, `subUnit`, `location`, `startDate`, `endDate`, `directorFees`, `directorFeesApprovalDate`, `created_at`, `updated_at`) VALUES
(1, 2351277, 0, 0, 0, '1970-01-01', 0, 0, '1970-01-01', '0000-00-00', '0.00', NULL, '2016-05-09 16:11:58', '2016-05-09 16:11:58'),
(2, 7316991, 26, 1, 9, '2016-03-25', 0, 0, '2016-03-20', '0000-00-00', '0.00', NULL, '2016-05-10 17:11:33', '2016-05-10 17:11:33'),
(3, 2678199, 26, 2, 9, '2016-03-23', 0, 0, '2016-03-18', '0000-00-00', '0.00', NULL, '2016-05-10 18:22:37', '2016-05-10 18:22:37'),
(4, 35092297, 27, 2, 9, '2015-05-25', 0, 0, '2015-05-28', '0000-00-00', '0.00', NULL, '2016-05-12 10:06:46', '2016-05-12 10:06:46'),
(5, 3084593, 20, 0, 2, '2016-01-14', 1, 1, '2016-01-15', '0000-00-00', '0.00', NULL, '2016-05-12 17:40:50', '2016-05-27 11:02:29'),
(6, 3000917, 6, 0, 2, '1970-01-01', 0, 0, '2014-05-07', '0000-00-00', '0.00', NULL, '2016-05-12 17:57:02', '2016-06-01 11:52:46'),
(7, 3162165, 34, 0, 2, '2015-05-04', 0, 3, '2015-04-29', '0000-00-00', '0.00', NULL, '2016-05-13 16:23:34', '2016-05-27 11:01:42'),
(8, 3006595, 29, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-26 10:46:45', '2016-05-27 10:34:28'),
(9, 2644005, 26, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-26 10:54:06', '2016-06-01 16:56:40'),
(10, 76639515, 26, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-26 15:41:16', '2016-05-28 12:50:57'),
(11, 3169252, 0, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-27 11:03:09', '2016-05-27 11:03:09'),
(12, 7408543, 28, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-27 11:33:48', '2016-05-27 11:33:48'),
(13, 6075753, 11, 0, 0, '0000-00-00', 0, 0, '0000-00-00', '0000-00-00', '0.00', NULL, '2016-05-27 14:40:13', '2016-05-27 14:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `employeeexperience`
--

CREATE TABLE IF NOT EXISTS `employeeexperience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` varchar(100) NOT NULL,
  `previousCompany` varchar(100) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `message` text NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employeequalification`
--

CREATE TABLE IF NOT EXISTS `employeequalification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `level` smallint(6) NOT NULL,
  `institute` varchar(100) NOT NULL,
  `majorSpecification` varchar(100) NOT NULL,
  `yearofPass` varchar(10) NOT NULL,
  `gpa` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employeereportto`
--

CREATE TABLE IF NOT EXISTS `employeereportto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reportToType` enum('leave','claim') DEFAULT NULL,
  `supervisorId` varchar(32) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `company` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('active','deleted') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `middleName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `reason` varchar(200) NOT NULL,
  `employeeCompany` varchar(100) NOT NULL,
  `workPass` int(11) NOT NULL,
  `employmentStart` date DEFAULT NULL,
  `employmentEnd` date DEFAULT NULL,
  `terminatedStatus` enum('yes','no') NOT NULL DEFAULT 'no',
  `note` text NOT NULL,
  `basicPay` decimal(10,2) NOT NULL,
  `icType` enum('1','2','3','4','5','6') NOT NULL,
  `icNo` varchar(50) NOT NULL,
  `maritalStatus` smallint(6) NOT NULL,
  `prStatus` varchar(3) NOT NULL,
  `prDate` date DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `race` varchar(32) NOT NULL,
  `nationality` int(4) NOT NULL,
  `gender` smallint(6) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employeeId`, `firstName`, `middleName`, `lastName`, `reason`, `employeeCompany`, `workPass`, `employmentStart`, `employmentEnd`, `terminatedStatus`, `note`, `basicPay`, `icType`, `icNo`, `maritalStatus`, `prStatus`, `prDate`, `dob`, `race`, `nationality`, `gender`, `status`, `created_at`, `updated_at`) VALUES
(8, 'GH0001', 'STEVEN', '', 'CHU', '', 'GH', 2, NULL, NULL, 'no', '', '800.00', '1', '12345678', 1, '1', NULL, '1966-01-13', 'European', 301, 1, 'deleted', '2016-04-18 14:43:58', '2016-05-10 16:57:20'),
(9, 'GH0002', 'NAVIN', '', 'M-SIA', '', 'GH', 2, NULL, NULL, 'no', '', '800.00', '1', '123456789', 1, '1', NULL, '1934-01-31', 'INDIAN', 301, 1, 'deleted', '2016-04-18 14:44:44', '2016-05-10 16:57:20'),
(10, 'HC0001', 'HENG', '', 'MONG', '', 'HC', 3, NULL, NULL, 'no', '', '800.00', '1', '12345678', 1, '1', NULL, '1966-01-02', 'CHINESE', 301, 1, 'deleted', '2016-04-18 14:45:13', '2016-05-10 16:57:20'),
(11, 'HC0002', 'HENG', 'MONG', 'KIAT', '', 'HC', 3, NULL, NULL, 'no', '', '800.00', '1', '123456789', 1, '1', NULL, '1955-01-01', 'CHINESE', 301, 1, 'deleted', '2016-04-18 14:45:40', '2016-05-10 16:57:15'),
(12, 'GH0003', 'RYES ALEXANDER ', 'FELIX ', 'MICIANO', '', 'GH', 0, NULL, NULL, 'no', '', '4500.00', '1', '69875826', 1, '1', NULL, '1980-11-30', '', 305, 1, 'deleted', '2016-04-26 21:20:21', '2016-05-10 16:57:20'),
(13, 'GH0004', 'KARANWAL ', '', 'PANKAJ', '', 'GH', 0, NULL, NULL, 'no', '', '4500.00', '1', '69875202', 2, '1', NULL, '1982-11-30', '', 103, 1, 'deleted', '2016-04-26 21:21:01', '2016-05-10 16:57:20'),
(14, 'GH0005', 'REMOLINO FEL ', 'IAN ', 'SALLAVE', '', 'GH', 0, NULL, NULL, 'no', '', '5500.00', '1', '2012563', 1, '1', NULL, '1986-08-27', '', 0, 1, 'deleted', '2016-04-26 21:21:29', '2016-05-10 16:57:20'),
(15, 'HC0003', 'RIFE CARRIE ', 'MAE ', 'PERUCHO', '', 'HC', 0, NULL, NULL, 'no', '', '0.00', '1', '', 0, '', NULL, NULL, '', 0, 0, 'deleted', '2016-04-26 21:22:30', '2016-05-10 16:57:15'),
(16, 'HC0004', 'AMIRTHALINGAM ', '', 'VIJAYAN', '', 'HC', 0, NULL, NULL, 'no', '', '0.00', '1', '', 0, '', NULL, NULL, '', 0, 0, 'deleted', '2016-04-26 21:22:52', '2016-05-10 16:57:15'),
(17, 'HC0005', 'KALEEKKAL ', 'BABU ', 'JOHN', '', 'HC', 0, NULL, NULL, 'no', '', '0.00', '1', '', 0, '', NULL, NULL, '', 0, 0, 'deleted', '2016-04-26 21:23:28', '2016-05-10 16:57:15'),
(18, '2351277', 'LIMGAM', '', 'A/L SUBRAMANIUM', '', '10', 4, NULL, NULL, 'no', '', '800.00', '2', 'G2351277M', 2, '1', NULL, '1974-10-09', 'Indian', 304, 1, 'deleted', '2016-04-27 14:36:41', '2016-05-26 10:50:45'),
(20, '3007194', 'Remo', 'fel', 'lian salvae', '', 'GH', 0, NULL, NULL, 'no', '', '0.00', '1', '', 0, '', NULL, NULL, '', 0, 0, 'deleted', '2016-05-09 10:09:14', '2016-05-09 10:17:42'),
(22, '2661722', 'Yap', ' chong ', 'beng', '', 'RWS', 4, NULL, NULL, 'no', '', '800.00', '1', 'F876554H', 1, '2', '2016-01-01', '2001-11-22', 'Indian', 354, 1, 'deleted', '2016-05-09 17:02:21', '2016-05-10 16:57:20'),
(23, '7316991', 'Keivin', '  lum kok ', 'leong ', '', '02', 5, '1970-01-01', NULL, 'no', '', '800.00', '1', 'S7316991G', 2, '1', '1970-01-01', '1975-07-25', 'chinese', 301, 1, 'active', '2016-05-10 17:07:05', '2016-06-01 18:23:50'),
(24, '2678199', 'Ahmad', 'Hilmi Bin', 'Idrus', '', 'vw(Alex)', 0, NULL, NULL, 'no', '', '800.00', '2', '', 2, '1', '1970-01-01', '1980-11-25', '', 304, 1, 'active', '2016-05-10 18:18:09', '2016-05-12 17:37:46'),
(25, '35092297', 'Naviin ', '', 'Jeevanamtham ', '', 'vw(Alex)', 0, NULL, NULL, 'no', '', '800.00', '2', '', 1, '1', NULL, '1988-05-02', '', 0, 1, 'active', '2016-05-12 10:02:00', '2016-05-12 10:04:57'),
(26, '3084593', 'Lalit ', '', 'Thakur ', '', '10', 2, '2016-01-16', NULL, 'no', '', '1200.00', '2', 'G3084593K', 1, '1', NULL, '1990-12-24', 'Indian', 0, 1, 'active', '2016-05-12 17:32:55', '2016-05-27 11:02:29'),
(27, '3000917', 'Kalleekkal ', 'Babu', ' John', '', '10', 1, '2016-03-10', NULL, 'no', '', '2500.00', '2', 'G3000917M', 2, '1', '1970-01-01', '1983-07-31', '', 354, 1, 'active', '2016-05-12 17:54:39', '2016-06-01 11:52:22'),
(28, '3162165', 'Jobil ', '', 'ninan', '', '10', 2, '2015-05-15', NULL, 'no', '', '1200.00', '2', 'G3162165N', 2, '1', NULL, '1979-08-14', 'Indian', 354, 1, 'active', '2016-05-13 16:12:39', '2016-05-27 11:01:42'),
(29, '3006595', 'REMOLINO ', 'FEL IAN ', 'SALLAVE', '', '10', 1, '2013-12-27', NULL, 'no', '', '2500.00', '2', 'G3006595L', 2, '1', NULL, '1987-02-16', '', 354, 1, 'active', '2016-05-26 10:34:39', '2016-05-26 10:46:45'),
(30, '3169252', 'RAMACHANDRAN ', '', 'MARIMUTHU', '', '10', 2, '2015-06-08', NULL, 'no', '', '1200.00', '2', 'G3169252R', 1, '1', NULL, '1990-05-02', '', 354, 1, 'active', '2016-05-26 10:35:24', '2016-05-27 11:03:09'),
(31, '2633859', 'LUI YUO', '', 'YUO', '', '10', 3, NULL, NULL, 'no', '', '800.00', '2', 'G2633859Q', 1, '1', NULL, '1979-03-15', '', 336, 1, 'deleted', '2016-05-26 10:36:26', '2016-05-26 15:38:47'),
(32, '2351277', 'LINGAM', '', ' A/L SUPRAMANIAM', '', '10', 0, NULL, NULL, 'no', '', '0.00', '1', '', 0, '', NULL, NULL, '', 0, 0, 'active', '2016-05-26 10:37:18', '2016-05-26 10:37:18'),
(33, '2644005', 'TAN', ' CHAN ', 'CHAI', '', '10', 5, '2016-03-27', NULL, 'no', '', '800.00', '1', 'S2644005Z', 2, '1', '1970-01-01', '1956-10-26', 'Chinesw', 301, 1, 'active', '2016-05-26 10:38:29', '2016-06-01 16:56:18'),
(34, '76639515', 'Liu ', '', 'You', '', '10', 3, '2015-05-02', NULL, 'no', '', '800.00', '2', 'G2633859Q', 2, '1', NULL, '1979-03-15', '', 336, 1, 'active', '2016-05-26 15:39:26', '2016-05-28 12:50:48'),
(35, '7408543', 'Vijay', '', 'Jaya ramin', '', 'vw(Alex)', 5, '2015-08-12', NULL, 'no', '', '800.00', '1', 'S7408543A', 2, '1', NULL, '1974-01-06', '', 301, 1, 'active', '2016-05-27 11:28:59', '2016-05-27 11:33:48'),
(36, '6075753', 'Katherine', 'Ko', 'Cruz', '', '10', 1, '2014-04-07', NULL, 'no', '', '2500.00', '2', 'G6075753X', 2, '1', NULL, '1982-05-19', '', 111, 2, 'active', '2016-05-27 14:37:21', '2016-05-27 14:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `employeetimesheet`
--

CREATE TABLE IF NOT EXISTS `employeetimesheet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(32) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `workDate` date NOT NULL,
  `dayType` enum('ND','OD','ODW','PH','NSL','AL','ML','PHW') DEFAULT NULL,
  `totalWorkHours` varchar(50) NOT NULL,
  `basicHours` float NOT NULL,
  `basicMinutes` tinyint(4) NOT NULL,
  `overtimeHours` float NOT NULL,
  `overtimeMinutes` tinyint(4) NOT NULL,
  `basicSeconds` varchar(10) NOT NULL,
  `otSeconds` varchar(10) NOT NULL,
  `entryType` enum('pending','completed') NOT NULL DEFAULT 'completed',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=178 ;

--
-- Dumping data for table `employeetimesheet`
--

INSERT INTO `employeetimesheet` (`id`, `company`, `employee`, `workDate`, `dayType`, `totalWorkHours`, `basicHours`, `basicMinutes`, `overtimeHours`, `overtimeMinutes`, `basicSeconds`, `otSeconds`, `entryType`, `created_at`, `updated_at`) VALUES
(43, '10', '3000917', '2016-05-19', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(42, '10', '3000917', '2016-05-18', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(41, '10', '3000917', '2016-05-17', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(40, '10', '3000917', '2016-05-16', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(39, '10', '3000917', '2016-05-15', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(38, '10', '3000917', '2016-05-14', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(37, '10', '3000917', '2016-05-13', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(36, '10', '3000917', '2016-05-12', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(35, '10', '3000917', '2016-05-11', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(34, '10', '3000917', '2016-05-10', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(33, '10', '3000917', '2016-05-09', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(32, '10', '3000917', '2016-05-08', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(31, '10', '3000917', '2016-05-07', 'ND', '46800', 13, 0, 0, 0, '46800', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(30, '10', '3000917', '2016-05-06', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(29, '10', '3000917', '2016-05-05', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(28, '10', '3000917', '2016-05-04', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(27, '10', '3000917', '2016-05-03', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(26, '10', '3000917', '2016-05-02', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(25, '10', '3000917', '2016-05-01', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(24, '10', '3000917', '2016-04-30', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(44, '10', '3000917', '2016-05-20', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(45, '10', '3000917', '2016-05-21', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(46, '10', '3000917', '2016-05-22', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(47, '10', '3000917', '2016-05-23', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(48, '10', '3000917', '2016-05-24', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(49, '10', '3000917', '2016-05-25', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(50, '10', '3000917', '2016-05-26', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(51, '10', '3000917', '2016-05-27', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(52, '10', '3000917', '2016-05-28', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(53, '10', '3000917', '2016-05-29', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(54, '10', '3000917', '2016-05-30', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(55, '10', '3000917', '2016-05-31', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(56, '10', '3006595', '2016-05-01', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(57, '10', '3006595', '2016-05-02', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(58, '10', '3006595', '2016-05-03', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(59, '10', '3006595', '2016-05-04', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(60, '10', '3006595', '2016-05-05', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(61, '10', '3006595', '2016-05-06', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(62, '10', '3006595', '2016-05-07', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(63, '10', '3006595', '2016-05-08', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(64, '10', '3006595', '2016-05-09', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(65, '10', '3006595', '2016-05-10', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(66, '10', '3006595', '2016-05-11', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(67, '10', '3006595', '2016-05-12', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(68, '10', '3006595', '2016-05-13', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(69, '10', '3006595', '2016-05-14', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(70, '10', '3006595', '2016-05-15', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(71, '10', '3006595', '2016-05-16', 'ND', '41400', 11, 30, 0, 0, '41400', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(72, '10', '3006595', '2016-05-17', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(73, '10', '3006595', '2016-05-18', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(74, '10', '3006595', '2016-05-19', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(75, '10', '3006595', '2016-05-20', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(76, '10', '3006595', '2016-05-21', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(77, '10', '3006595', '2016-05-22', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(78, '10', '3006595', '2016-05-23', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(79, '10', '3006595', '2016-05-24', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(80, '10', '3006595', '2016-05-25', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(81, '10', '3006595', '2016-05-26', 'ND', '43200', 12, 0, 0, 0, '43200', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(82, '10', '3006595', '2016-05-27', 'ND', '39600', 11, 0, 0, 0, '39600', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(83, '10', '3006595', '2016-05-28', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(84, '10', '3006595', '2016-05-29', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(85, '10', '3006595', '2016-05-30', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(86, '10', '3006595', '2016-05-31', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(87, '10', '2644005', '2016-05-01', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(88, '10', '2644005', '2016-05-02', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(89, '10', '2644005', '2016-05-03', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(90, '10', '2644005', '2016-05-04', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(91, '10', '2644005', '2016-05-05', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(92, '10', '2644005', '2016-05-06', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(93, '10', '2644005', '2016-05-07', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(94, '10', '2644005', '2016-05-08', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(95, '10', '2644005', '2016-05-09', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(96, '10', '2644005', '2016-05-10', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(97, '10', '2644005', '2016-05-11', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(98, '10', '2644005', '2016-05-12', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(99, '10', '2644005', '2016-05-13', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(100, '10', '2644005', '2016-05-14', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(101, '10', '2644005', '2016-05-15', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(102, '10', '2644005', '2016-05-16', 'ND', '37800', 8, 0, 2, 30, '28800', '9000', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(103, '10', '2644005', '2016-05-17', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(104, '10', '2644005', '2016-05-18', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(105, '10', '2644005', '2016-05-19', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(106, '10', '2644005', '2016-05-20', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(107, '10', '2644005', '2016-05-21', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(108, '10', '2644005', '2016-05-22', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(109, '10', '2644005', '2016-05-23', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(110, '10', '2644005', '2016-05-24', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(111, '10', '2644005', '2016-05-25', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(112, '10', '2644005', '2016-05-26', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(113, '10', '2644005', '2016-05-27', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(114, '10', '2644005', '2016-05-28', 'ND', '41400', 8, 0, 3, 30, '28800', '12600', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(115, '10', '2644005', '2016-05-29', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(116, '10', '2644005', '2016-05-30', 'ND', '39600', 8, 0, 3, 0, '28800', '10800', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(117, '10', '2644005', '2016-05-31', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(173, '02', '7316991 ', '2016-05-18', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(172, '02', '7316991 ', '2016-05-17', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(171, '02', '7316991 ', '2016-05-16', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(170, '02', '7316991 ', '2016-05-15', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(169, '02', '7316991 ', '2016-05-14', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(168, '02', '7316991 ', '2016-05-13', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(167, '02', '7316991 ', '2016-05-12', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(166, '02', '7316991 ', '2016-05-11', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(165, '02', '7316991 ', '2016-05-10', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(164, '02', '7316991 ', '2016-05-09', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(163, '02', '7316991 ', '2016-05-08', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(162, '02', '7316991 ', '2016-05-07', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(161, '02', '7316991 ', '2016-05-06', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(160, '02', '7316991 ', '2016-05-05', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(159, '02', '7316991 ', '2016-05-04', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(158, '02', '7316991 ', '2016-05-03', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(157, '02', '7316991 ', '2016-05-02', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(156, '02', '7316991 ', '2016-05-01', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(155, '02', '7316991 ', '2016-04-30', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(154, '02', '7316991 ', '2016-04-29', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(153, '02', '7316991 ', '2016-04-28', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(152, '02', '7316991 ', '2016-04-27', 'NSL', '-3600', 23, 0, 0, 0, '-3600', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(151, '02', '7316991 ', '2016-04-26', 'OD', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(150, '02', '7316991 ', '2016-04-25', 'ND', '-54000', 9, 0, 0, 0, '-54000', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(149, '02', '7316991 ', '2016-04-24', 'ND', '-54000', 9, 0, 0, 0, '-54000', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(148, '02', '7316991 ', '2016-04-23', 'ND', '-54000', 9, 0, 0, 0, '-54000', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(174, '02', '7316991 ', '2016-05-19', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(175, '02', '7316991 ', '2016-05-20', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(176, '02', '7316991 ', '2016-05-21', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(177, '02', '7316991 ', '2016-05-22', 'NSL', '0', 0, 0, 0, 0, '0', '0', 'completed', '2016-06-02 15:23:33', '2016-06-02 15:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `employeetimesheetmeta`
--

CREATE TABLE IF NOT EXISTS `employeetimesheetmeta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(32) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `workDate` date NOT NULL,
  `dayType` enum('ND','OD','ODW','PH','NSL','PHW') NOT NULL,
  `record` int(11) NOT NULL,
  `recordType` enum('in','out') DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=272 ;

--
-- Dumping data for table `employeetimesheetmeta`
--

INSERT INTO `employeetimesheetmeta` (`id`, `company`, `employee`, `workDate`, `dayType`, `record`, `recordType`, `created_at`, `updated_at`) VALUES
(84, '10', '3000917', '2016-05-21', 'ND', 79380, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(83, '10', '3000917', '2016-05-21', 'ND', 35100, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(82, '10', '3000917', '2016-05-20', 'ND', 79200, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(81, '10', '3000917', '2016-05-20', 'ND', 35460, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(80, '10', '3000917', '2016-05-19', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(79, '10', '3000917', '2016-05-19', 'ND', 39660, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(78, '10', '3000917', '2016-05-18', 'ND', 82020, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(77, '10', '3000917', '2016-05-18', 'ND', 39600, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(76, '10', '3000917', '2016-05-17', 'ND', 81960, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(75, '10', '3000917', '2016-05-17', 'ND', 39780, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(74, '10', '3000917', '2016-05-16', 'ND', 82080, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(73, '10', '3000917', '2016-05-16', 'ND', 39600, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(72, '10', '3000917', '2016-05-15', 'ND', 82380, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(71, '10', '3000917', '2016-05-15', 'ND', 39720, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(70, '10', '3000917', '2016-05-14', 'ND', 82140, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(69, '10', '3000917', '2016-05-14', 'ND', 39600, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(68, '10', '3000917', '2016-05-13', 'ND', 82380, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(67, '10', '3000917', '2016-05-13', 'ND', 39840, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(66, '10', '3000917', '2016-05-12', 'ND', 81960, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(65, '10', '3000917', '2016-05-11', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(64, '10', '3000917', '2016-05-11', 'ND', 39840, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(63, '10', '3000917', '2016-05-10', 'ND', 81720, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(62, '10', '3000917', '2016-05-10', 'ND', 39600, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(61, '10', '3000917', '2016-05-09', 'ND', 82260, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(60, '10', '3000917', '2016-05-09', 'ND', 37800, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(59, '10', '3000917', '2016-05-08', 'ND', 78600, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(58, '10', '3000917', '2016-05-08', 'ND', 43200, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(57, '10', '3000917', '2016-05-07', 'ND', 78600, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(56, '10', '3000917', '2016-05-07', 'ND', 37020, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(55, '10', '3000917', '2016-05-06', 'ND', 78540, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(54, '10', '3000917', '2016-05-06', 'ND', 36000, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(53, '10', '3000917', '2016-05-05', 'ND', 78660, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(52, '10', '3000917', '2016-05-05', 'ND', 37860, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(51, '10', '3000917', '2016-05-04', 'ND', 78600, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(50, '10', '3000917', '2016-05-04', 'ND', 39600, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(49, '10', '3000917', '2016-05-03', 'ND', 78600, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(48, '10', '3000917', '2016-05-02', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(47, '10', '3000917', '2016-05-02', 'ND', 37800, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(46, '10', '3000917', '2016-05-01', 'ND', 78300, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(45, '10', '3000917', '2016-05-01', 'ND', 36000, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(44, '10', '3000917', '2016-04-30', 'ND', 78540, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(85, '10', '3000917', '2016-05-22', 'ND', 35520, 'in', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(86, '10', '3000917', '2016-05-22', 'ND', 80160, 'out', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(87, '10', '3000917', '2016-05-23', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(88, '10', '3000917', '2016-05-24', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(89, '10', '3000917', '2016-05-25', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(90, '10', '3000917', '2016-05-26', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(91, '10', '3000917', '2016-05-27', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(92, '10', '3000917', '2016-05-28', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(93, '10', '3000917', '2016-05-29', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(94, '10', '3000917', '2016-05-30', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(95, '10', '3000917', '2016-05-31', 'OD', 0, '', '2016-06-01 13:20:22', '2016-06-01 13:20:22'),
(96, '10', '3006595', '2016-05-01', 'ND', 37860, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(97, '10', '3006595', '2016-05-01', 'ND', 82860, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(98, '10', '3006595', '2016-05-02', 'ND', 38220, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(99, '10', '3006595', '2016-05-02', 'ND', 83280, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(100, '10', '3006595', '2016-05-03', 'ND', 38460, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(101, '10', '3006595', '2016-05-03', 'ND', 82800, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(102, '10', '3006595', '2016-05-04', 'ND', 77820, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(103, '10', '3006595', '2016-05-05', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(104, '10', '3006595', '2016-05-05', 'ND', 78300, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(105, '10', '3006595', '2016-05-06', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(106, '10', '3006595', '2016-05-06', 'ND', 78480, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(107, '10', '3006595', '2016-05-07', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(108, '10', '3006595', '2016-05-07', 'ND', 78060, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(109, '10', '3006595', '2016-05-08', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(110, '10', '3006595', '2016-05-08', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(111, '10', '3006595', '2016-05-09', 'ND', 35220, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(112, '10', '3006595', '2016-05-09', 'ND', 79380, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(113, '10', '3006595', '2016-05-10', 'ND', 35400, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(114, '10', '3006595', '2016-05-10', 'ND', 79200, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(115, '10', '3006595', '2016-05-11', 'ND', 77700, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(116, '10', '3006595', '2016-05-12', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(117, '10', '3006595', '2016-05-12', 'ND', 78120, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(118, '10', '3006595', '2016-05-13', 'ND', 39780, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(119, '10', '3006595', '2016-05-13', 'ND', 77880, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(120, '10', '3006595', '2016-05-14', 'ND', 39600, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(121, '10', '3006595', '2016-05-14', 'ND', 77820, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(122, '10', '3006595', '2016-05-15', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(123, '10', '3006595', '2016-05-15', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(124, '10', '3006595', '2016-05-16', 'ND', 78240, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(125, '10', '3006595', '2016-05-17', 'ND', 37080, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(126, '10', '3006595', '2016-05-17', 'ND', 78120, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(127, '10', '3006595', '2016-05-18', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(128, '10', '3006595', '2016-05-18', 'ND', 78540, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(129, '10', '3006595', '2016-05-19', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(130, '10', '3006595', '2016-05-19', 'ND', 78180, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(131, '10', '3006595', '2016-05-20', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(132, '10', '3006595', '2016-05-20', 'ND', 79380, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(133, '10', '3006595', '2016-05-21', 'ND', 36000, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(134, '10', '3006595', '2016-05-21', 'ND', 79320, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(135, '10', '3006595', '2016-05-22', 'ND', 39600, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(136, '10', '3006595', '2016-05-22', 'ND', 78540, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(137, '10', '3006595', '2016-05-23', 'ND', 39660, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(138, '10', '3006595', '2016-05-23', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(139, '10', '3006595', '2016-05-24', 'ND', 77700, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(140, '10', '3006595', '2016-05-25', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(141, '10', '3006595', '2016-05-25', 'ND', 78120, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(142, '10', '3006595', '2016-05-26', 'ND', 39780, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(143, '10', '3006595', '2016-05-26', 'ND', 77880, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(144, '10', '3006595', '2016-05-27', 'ND', 39600, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(145, '10', '3006595', '2016-05-27', 'ND', 77820, 'in', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(146, '10', '3006595', '2016-05-28', 'ND', 36060, 'out', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(147, '10', '3006595', '2016-05-28', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(148, '10', '3006595', '2016-05-29', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(149, '10', '3006595', '2016-05-30', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(150, '10', '3006595', '2016-05-31', 'OD', 0, '', '2016-06-01 16:20:38', '2016-06-01 16:20:38'),
(151, '10', '2644005', '2016-05-01', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(152, '10', '2644005', '2016-05-02', 'ND', 36900, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(153, '10', '2644005', '2016-05-02', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(154, '10', '2644005', '2016-05-03', 'ND', 39780, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(155, '10', '2644005', '2016-05-03', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(156, '10', '2644005', '2016-05-04', 'ND', 38460, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(157, '10', '2644005', '2016-05-04', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(158, '10', '2644005', '2016-05-05', 'ND', 38880, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(159, '10', '2644005', '2016-05-05', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(160, '10', '2644005', '2016-05-06', 'ND', 39180, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(161, '10', '2644005', '2016-05-06', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(162, '10', '2644005', '2016-05-07', 'ND', 39000, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(163, '10', '2644005', '2016-05-07', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(164, '10', '2644005', '2016-05-08', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(165, '10', '2644005', '2016-05-09', 'ND', 37560, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(166, '10', '2644005', '2016-05-09', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(167, '10', '2644005', '2016-05-10', 'ND', 39060, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(168, '10', '2644005', '2016-05-10', 'ND', 82440, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(169, '10', '2644005', '2016-05-11', 'ND', 37440, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(170, '10', '2644005', '2016-05-11', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(171, '10', '2644005', '2016-05-12', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(172, '10', '2644005', '2016-05-13', 'ND', 38640, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(173, '10', '2644005', '2016-05-13', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(174, '10', '2644005', '2016-05-14', 'ND', 37800, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(175, '10', '2644005', '2016-05-14', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(176, '10', '2644005', '2016-05-15', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(177, '10', '2644005', '2016-05-16', 'ND', 40320, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(178, '10', '2644005', '2016-05-16', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(179, '10', '2644005', '2016-05-17', 'ND', 39360, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(180, '10', '2644005', '2016-05-17', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(181, '10', '2644005', '2016-05-18', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(182, '10', '2644005', '2016-05-19', 'ND', 38400, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(183, '10', '2644005', '2016-05-19', 'ND', 82620, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(184, '10', '2644005', '2016-05-20', 'ND', 40020, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(185, '10', '2644005', '2016-05-20', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(186, '10', '2644005', '2016-05-21', 'ND', 39360, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(187, '10', '2644005', '2016-05-21', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(188, '10', '2644005', '2016-05-22', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(189, '10', '2644005', '2016-05-23', 'ND', 37740, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(190, '10', '2644005', '2016-05-23', 'ND', 82440, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(191, '10', '2644005', '2016-05-24', 'ND', 37560, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(192, '10', '2644005', '2016-05-24', 'ND', 82440, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(193, '10', '2644005', '2016-05-25', 'ND', 39060, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(194, '10', '2644005', '2016-05-25', 'ND', 82440, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(195, '10', '2644005', '2016-05-26', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(196, '10', '2644005', '2016-05-27', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(197, '10', '2644005', '2016-05-28', 'ND', 37440, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(198, '10', '2644005', '2016-05-28', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(199, '10', '2644005', '2016-05-29', 'ND', 38400, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(200, '10', '2644005', '2016-05-29', 'ND', 82620, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(201, '10', '2644005', '2016-05-30', 'ND', 40020, 'in', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(202, '10', '2644005', '2016-05-30', 'ND', 82500, 'out', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(203, '10', '2644005', '2016-05-31', 'OD', 0, '', '2016-06-01 16:34:07', '2016-06-01 16:34:07'),
(265, '02', '7316991 ', '2016-05-16', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(264, '02', '7316991 ', '2016-05-15', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(263, '02', '7316991 ', '2016-05-14', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(262, '02', '7316991 ', '2016-05-13', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(261, '02', '7316991 ', '2016-05-12', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(260, '02', '7316991 ', '2016-05-11', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(259, '02', '7316991 ', '2016-05-10', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(258, '02', '7316991 ', '2016-05-09', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(257, '02', '7316991 ', '2016-05-08', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(256, '02', '7316991 ', '2016-05-07', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(255, '02', '7316991 ', '2016-05-06', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(254, '02', '7316991 ', '2016-05-05', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(253, '02', '7316991 ', '2016-05-04', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(252, '02', '7316991 ', '2016-05-03', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(251, '02', '7316991 ', '2016-05-02', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(250, '02', '7316991 ', '2016-05-01', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(249, '02', '7316991 ', '2016-04-30', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(248, '02', '7316991 ', '2016-04-29', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(247, '02', '7316991 ', '2016-04-28', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(246, '02', '7316991 ', '2016-04-27', 'NSL', 0, 'out', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(245, '02', '7316991 ', '2016-04-27', 'NSL', 0, 'in', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(244, '02', '7316991 ', '2016-04-26', 'OD', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(243, '02', '7316991 ', '2016-04-25', 'ND', 3600, 'out', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(242, '02', '7316991 ', '2016-04-25', 'ND', 54000, 'in', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(241, '02', '7316991 ', '2016-04-24', 'ND', 3600, 'out', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(240, '02', '7316991 ', '2016-04-24', 'ND', 54000, 'in', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(239, '02', '7316991 ', '2016-04-23', 'ND', 3600, 'out', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(238, '02', '7316991 ', '2016-04-23', 'ND', 54000, 'in', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(266, '02', '7316991 ', '2016-05-17', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(267, '02', '7316991 ', '2016-05-18', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(268, '02', '7316991 ', '2016-05-19', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(269, '02', '7316991 ', '2016-05-20', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(270, '02', '7316991 ', '2016-05-21', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33'),
(271, '02', '7316991 ', '2016-05-22', 'NSL', 0, '', '2016-06-02 15:23:33', '2016-06-02 15:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `employmentstatus`
--

CREATE TABLE IF NOT EXISTS `employmentstatus` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employmentstatus`
--

INSERT INTO `employmentstatus` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'Singaporeans', 'active', 'admin', '2016-04-25 14:18:58', '2016-04-25 14:18:58'),
(2, 'Malaysians', 'active', 'admin', '2016-05-09 10:26:38', '2016-05-09 10:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `entitlement`
--

CREATE TABLE IF NOT EXISTS `entitlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(32) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `leaveType` tinyint(3) unsigned NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `entitlement` decimal(10,2) NOT NULL,
  `previousBalance` decimal(10,2) NOT NULL,
  `totalEntitlement` decimal(10,2) NOT NULL,
  `period` year(4) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(16) NOT NULL,
  `employee` varchar(16) DEFAULT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `merchant` varchar(100) NOT NULL,
  `splitExpenses` enum('yes','no') NOT NULL DEFAULT 'no',
  `gstPercentage` decimal(10,2) NOT NULL,
  `gstAmount` decimal(10,2) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `paidWith` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `project` varchar(100) NOT NULL,
  `comments` varchar(256) NOT NULL,
  `reimbursable` enum('yes','no') NOT NULL DEFAULT 'no',
  `invoice` enum('yes','no') NOT NULL DEFAULT 'no',
  `invoiceNumber` varchar(64) DEFAULT NULL,
  `createdBy` varchar(16) NOT NULL,
  `approvedBy` varchar(16) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` enum('pending','approved','rejected','deleted') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `company`, `employee`, `fromDate`, `toDate`, `merchant`, `splitExpenses`, `gstPercentage`, `gstAmount`, `totalAmount`, `paidWith`, `category`, `project`, `comments`, `reimbursable`, `invoice`, `invoiceNumber`, `createdBy`, `approvedBy`, `created_at`, `updated_at`, `status`) VALUES
(1, '', '', '1970-01-01', '1970-01-01', '', 'no', '0.00', '0.00', '0.00', 0, 0, '', '', 'no', 'no', NULL, 'admin', NULL, '2016-05-09 13:29:26', '2016-05-09 13:29:26', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `expensespaymenttype`
--

CREATE TABLE IF NOT EXISTS `expensespaymenttype` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `expensessplit`
--

CREATE TABLE IF NOT EXISTS `expensessplit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `expenseId` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `invoiceNumber` varchar(64) DEFAULT NULL,
  `comments` varchar(256) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `expensestype`
--

CREATE TABLE IF NOT EXISTS `expensestype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(16) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableId` varchar(32) NOT NULL,
  `path` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE IF NOT EXISTS `holidays` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `holiday` date NOT NULL,
  `description` varchar(256) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holiday`, `description`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(15, '2016-08-09', 'National Day', 'deleted', 'admin', '2016-04-18 14:24:23', '2016-04-18 14:24:23'),
(16, '2016-09-12', 'Hari Raya Haji', 'deleted', 'admin', '2016-04-18 14:24:48', '2016-04-18 14:24:48'),
(17, '2016-10-29', 'Deepavali', 'deleted', 'admin', '2016-04-18 14:25:00', '2016-04-18 14:25:00'),
(18, '2016-12-25', 'Christmas Day', 'deleted', 'admin', '2016-04-18 14:25:14', '2016-04-18 14:25:14'),
(19, '2016-02-08', 'Chinese New Year', 'deleted', 'admin', '2016-04-18 14:25:34', '2016-04-18 14:25:34'),
(20, '2016-02-09', 'Chinese New Year', 'deleted', 'admin', '2016-04-18 14:25:41', '2016-04-18 14:25:41'),
(21, '2016-03-25', 'Good Friday', 'deleted', 'admin', '2016-04-18 14:25:51', '2016-04-18 14:25:51'),
(22, '2016-05-01', 'Labour Day', 'deleted', 'admin', '2016-04-18 14:26:00', '2016-06-01 13:19:53'),
(23, '2016-05-21', 'Vesak Day', 'deleted', 'admin', '2016-04-18 14:26:11', '2016-06-01 13:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `jobcategory`
--

CREATE TABLE IF NOT EXISTS `jobcategory` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `jobcategory`
--

INSERT INTO `jobcategory` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'Officials and Managers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Professionals', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Technicians', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Sales Workers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Operatives', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Office and Clerical Workers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Craft Workers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Service Workers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Laborers and Helpers', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'HR Worker', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-11 20:05:31'),
(11, 'Management', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Admin', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'testing', 'deleted', 'admin', '2016-04-06 17:11:50', '2016-04-18 14:06:08'),
(14, 'testingg', 'deleted', 'admin', '2016-04-06 17:47:33', '2016-04-18 14:06:08'),
(15, 'testinggg', 'deleted', 'admin', '2016-04-06 17:47:52', '2016-04-18 14:06:08'),
(16, 'testing1', 'deleted', 'admin', '2016-04-13 13:08:47', '2016-04-13 17:30:01'),
(17, 'Senior software engineer', 'deleted', 'admin', '2016-04-13 13:12:11', '2016-04-18 14:06:08'),
(18, 'new category', 'deleted', 'admin', '2016-04-15 14:00:12', '2016-04-15 14:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitles`
--

CREATE TABLE IF NOT EXISTS `jobtitles` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `jobtitles`
--

INSERT INTO `jobtitles` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'AP CLERK', 'deleted', 'admin', '0000-00-00 00:00:00', '2016-05-09 14:48:47'),
(2, 'ADMINISTRATIVE MANAGER', 'deleted', 'admin', '0000-00-00 00:00:00', '2016-05-09 14:48:47'),
(3, 'SENIOR NETWORK SYSTEMS ENGINEER', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'DATABASE MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'STAFF ACCOUNTANT', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'ACCOUNTS ASSISTANT', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:03:14'),
(7, 'CHATERED ACCOUNTANT', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:00:39'),
(8, 'PRODUCT DEVELOPMENT', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'MATERIALS HANDLER', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 19:58:25'),
(10, 'WAREHOUSE SUPERVISOR', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'CUSTOMER SERVICE EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 19:55:17'),
(12, 'ACCOUNTS EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 19:56:18'),
(13, 'PURCHASING MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'DIRECTOR OF HR', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'PRESIDENT', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'RECEPTIONIST/OFFICE CLERK', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:07:58'),
(17, 'MARKETING HEAD', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:20:42'),
(18, 'MANUFACTURING HEAD', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:21:36'),
(19, 'DIRECTOR', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:24:27'),
(20, 'Management Director', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 21:01:30'),
(21, 'Managing Director', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'General Manager', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'General Manager - Delivery', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'ADMINISTRATIVE EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'ADMINSTRATIVE ACCOUNTS EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'DRIVER', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'CAR JOCKEY', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'VALET OPERATOR', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'OPERATIONS MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'SUPERVISOR', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'CAR VALET ATTENDANT', 'active', 'admin', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'CAR PARK ATTENDANT', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:50:41'),
(33, 'OPERATIONS EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:47:40'),
(34, 'OPERATIONS SUPERVISOR', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:47:07'),
(35, 'ASST OPERATIONS SUPERVISOR', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:26:38'),
(36, 'CUSTOMER SERVICE MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:45:50'),
(37, 'ACCOUNTS MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:45:05'),
(38, 'TRANSPORT MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:44:47'),
(39, 'TECHNICAL SUPPORT MANAGER', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-15 14:44:47'),
(40, 'SENIOR OPERATIONS EXECUTIVE', 'active', 'admin', '0000-00-00 00:00:00', '2016-04-12 20:26:20'),
(41, 'Valet', 'active', 'admin', '2016-04-25 14:17:07', '2016-04-25 14:17:07'),
(42, 'OPERATIONS SUPERVISER', 'active', 'admin', '2016-05-13 16:18:03', '2016-05-13 16:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE IF NOT EXISTS `leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(32) NOT NULL,
  `employee` varchar(32) NOT NULL,
  `leaveType` int(11) NOT NULL,
  `leaveYear` year(4) NOT NULL,
  `initialLeave` int(11) NOT NULL,
  `customizeLeave` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `totalLeaveCount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE IF NOT EXISTS `leavetype` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `payType` enum('paid','unpaid','workingday') NOT NULL DEFAULT 'paid',
  `company` varchar(55) NOT NULL,
  `employee` varchar(55) NOT NULL,
  `description` text NOT NULL,
  `leaveUnit` enum('days','hours') DEFAULT NULL,
  `maximumLeave` int(11) NOT NULL,
  `isHalfDayEnabled` enum('false','true') NOT NULL DEFAULT 'false',
  `isAllowExceedCount` enum('false','true') NOT NULL DEFAULT 'false',
  `isConsiderHoliday` enum('false','true') NOT NULL DEFAULT 'false',
  `isConsiderweek` enum('false','true') NOT NULL DEFAULT 'false',
  `includeHolidayWeekend` enum('false','true') NOT NULL DEFAULT 'false',
  `includeHolidayWeekendValue` int(11) NOT NULL,
  `leaveNoticePeriod` enum('false','true') NOT NULL DEFAULT 'false',
  `leaveNoticePeriodValue` int(11) NOT NULL,
  `maxConsecutiveDays` enum('false','true') NOT NULL DEFAULT 'false',
  `maxConsecutiveDaysValue` int(11) NOT NULL,
  `roundoffTo` enum('false','true') NOT NULL DEFAULT 'false',
  `roundoffToValue` enum('nearest','maximum','minimum') NOT NULL,
  `isMaximumAccumulation` enum('false','true') NOT NULL DEFAULT 'false',
  `isMaximumAccumulationValue` int(11) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) DEFAULT 'NULL',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`id`, `name`, `payType`, `company`, `employee`, `description`, `leaveUnit`, `maximumLeave`, `isHalfDayEnabled`, `isAllowExceedCount`, `isConsiderHoliday`, `isConsiderweek`, `includeHolidayWeekend`, `includeHolidayWeekendValue`, `leaveNoticePeriod`, `leaveNoticePeriodValue`, `maxConsecutiveDays`, `maxConsecutiveDaysValue`, `roundoffTo`, `roundoffToValue`, `isMaximumAccumulation`, `isMaximumAccumulationValue`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'Annual Leave', 'paid', 'GH', '', 'annaul leave', 'days', 14, 'false', 'false', 'false', 'false', 'false', 0, 'false', 0, 'false', 0, 'false', 'nearest', 'false', 0, 'active', NULL, '2016-04-21 21:53:19', '2016-04-21 21:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `mbmfformula`
--

CREATE TABLE IF NOT EXISTS `mbmfformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('less','between','greater') NOT NULL DEFAULT 'less',
  `amountFrom` decimal(10,2) NOT NULL,
  `amountTo` decimal(10,2) NOT NULL,
  `mbmfAmount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `mbmfformula`
--

INSERT INTO `mbmfformula` (`id`, `type`, `amountFrom`, `amountTo`, `mbmfAmount`, `created_at`, `updated_at`) VALUES
(54, 'less', '200.00', '0.00', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'between', '200.00', '1000.00', '2.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'between', '1000.00', '2000.00', '3.50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'between', '2000.00', '3000.00', '5.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'between', '3000.00', '4000.00', '12.50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'greater', '4000.00', '0.00', '16.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE IF NOT EXISTS `nationality` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1002 ;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(101, 'BELGIAN', 'active', 'US0001', '1899-11-01 00:00:00', '0000-00-00 00:00:00'),
(102, 'DANISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'FRENCH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'GERMAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'GREEK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'IRISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'ITALIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'LUXEMBOURG', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'NETHERLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'BRITISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'PORTUGUESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'SPANISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'AUSTRIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 'FINNISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 'ICELAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 'NORWEGIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 'SVALBARD JAN MAYEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 'SWEDISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'SWISS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 'LIECHTENSTEIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'BOUVET ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'FAEROE ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'GREENLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 'MONACO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'SAN MARINO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'VATICAN CITY STATE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'TURK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'ANDORRAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'GIBRALTAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 'MALTESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'ALBANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 'BULGARIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 'CZECHOSLOVAK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 'HUNGARIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 'POLISH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 'ROMANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 'YUGOSLAV', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 'MACEDONIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 'BELARUSSIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 'UKRAINIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 'ESTONIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 'LATVIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 'LITHUANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 'GEORGIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 'ARMENIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'AZERBAIJANI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'KIRGHIZ', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 'KAZAKH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'MOLDOVIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'RUSSIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'TADZHIK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'TURKMEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'UZBEK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 'CROATIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'SLOVENIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'CZECH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 'SLOVAK', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(301, 'SINGAPORE CITIZEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(302, 'BRUNEIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(303, 'INDONESIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(304, 'MALAYSIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(305, 'FILIPINO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(306, 'THAI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(307, 'TIMORENSE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(311, 'MYANMAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(312, 'CAMBODIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(313, 'LAOTIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(314, 'VIETNAMESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(319, 'OC IN S E ASIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(331, 'JAPANESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(332, 'HONG KONG', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(333, 'KOREAN, SOUTH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(334, 'TAIWANESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(335, 'MACAO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(336, 'CHINESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(337, 'KOREAN, NORTH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(338, 'MONGOLIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(351, 'AFGHAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(352, 'BANGLADESHI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(353, 'BHUTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(354, 'INDIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(355, 'MALDIVIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(356, 'NEPALESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(357, 'PAKISTANI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(358, 'SRI LANKAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(371, 'BAHRAINI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(372, 'CYPRIOT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(373, 'IRANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(374, 'IRAQI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(375, 'ISRAELI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(376, 'JORDANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(377, 'KUWAITI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(378, 'LEBANESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(379, 'OMAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(380, 'QATAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(381, 'SAUDI ARABIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(382, 'SYRIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(383, 'UNITED ARAB EM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(384, 'YEMENI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(386, 'PALESTINIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(387, 'YEMEN, SOUTH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(388, 'YEMEN ARAB REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(401, 'ALGERIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(402, 'EGYPTIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(403, 'LIBYAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(404, 'MOROCCAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(405, 'SUDANESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(406, 'TUNISIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(407, 'DJIBOUTI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(408, 'ETHIOPIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(409, 'SOMALI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(410, 'ERITREA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(421, 'GHANAIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(422, 'IVORY COAST', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(423, 'KENYAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(424, 'LIBERIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(425, 'MADAGASCAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(426, 'MAURITIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(427, 'MOZAMBIQUE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(428, 'NIGERIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(429, 'REUNION', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(430, 'TANZANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(431, 'UGANDIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(432, 'ZAMBIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(451, 'ANGOLAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(452, 'BENIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(453, 'BOTSWANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(454, 'BURKINA FASO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(455, 'BURUNDI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(456, 'CAMEROON', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(457, 'CAPE VERDE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(458, 'CENTRAL AFRICAN REP', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(459, 'CHADIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(460, 'COMOROS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(461, 'CONGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(462, 'EQUATORIAL GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(463, 'GABON\r\n', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(464, 'GAMBIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(465, 'GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(466, 'GUINES BISSAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(467, 'LESOTHO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(468, 'MALAWI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(469, 'MALI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(470, 'MAURITANEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(471, 'NAMIBIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(472, 'NIGER', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(473, 'RWANDA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(474, 'SAO TOME PRINCI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(475, 'SENEGALESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(476, 'SEYCHELLES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(477, 'SIERRA LEONE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(478, 'SOUTH AFRICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(479, 'WESTERN SAHARA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(480, 'SWAZI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(481, 'TOGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(482, 'ZAIRAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(483, 'ZIMBABWEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(484, 'ST HELENA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(499, 'OC IN OTHER AFRICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(501, 'CANADIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(502, 'PUERTO RICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(503, 'AMERICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(504, 'U S MINOR ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(505, 'ST PIERRE MIQUELON', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(509, 'OC NORTH AMERICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(601, 'ARGENTINIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(602, 'BRAZILIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(603, 'CHILEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(604, 'COLOMBIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(605, 'ECUADORIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(606, 'MEXICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(607, 'PARAGUAY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(608, 'PERUVIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(609, 'URUGUAY', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(610, 'VENEZUELAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(621, 'CUBAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(622, 'DOMINICAN REPUBLIC', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(623, 'NETHERLANDS ANTIL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(624, 'PANAMANIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(625, 'ARUBA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(641, 'ANTIGUA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(642, 'BAHAMAS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(643, 'BARBADOS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(644, 'BELIZE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(645, 'BERMUDAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(646, 'BOLIVIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(647, 'CAYMANESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(648, 'COSTA RICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(649, 'DOMINICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(650, 'SALVADORAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(651, 'FALKLAND IS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(652, 'FRENCH GUIANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(653, 'GRENADIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(654, 'GUADELOUPE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(655, 'GUATEMALA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(656, 'GUYANA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(657, 'HAITIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(658, 'HONDURAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(659, 'JAMAICAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(660, 'NICARAGUAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(661, 'MARTINIQUE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(662, 'MONTSERRAT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(663, 'SAINT KITTS NEVIS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(664, 'ST LUCIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(665, 'ST VINCENT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(666, 'SURINAME', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(667, 'TRINIDAD AND TOBAGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(668, 'TURKS AND CAICOS IS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(669, 'VIRGIN ISLANDS US', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(670, 'ANGUILLA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(671, 'BRITISH VIRGIN ISLND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(672, 'ISLE OF MAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(673, 'ANTARCTICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(674, 'DEMOCRATIC REP OF THE CONGO', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(675, 'BRITISH DEPENDENT TERR CITIZEN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(676, 'KAMPUCHEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(677, 'KOSOVAR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(678, 'MONTENEGRIN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(679, 'SERBIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(699, 'OC CTRL STH AMERICA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(701, 'AUSTRALIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(702, 'FIJIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(703, 'NAURUAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(704, 'NEW CALEDONIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(705, 'NEW ZEALANDER', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(706, 'PAPUA NEW GUINEA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(707, 'SAMOAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(708, 'BRITISH INDIAN OCEAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(709, 'CHRISTMAS ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(710, 'COCOS KEELING ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(711, 'FRENCH SOUTHERN TERR', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(712, 'HEARD MCDONALD ISLND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(713, 'NORFOLK ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(721, 'AMERICAN SAMOA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(722, 'COOK ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(723, 'FRENCH POLYNESIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(724, 'GUAM', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(725, 'KIRIBATI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(726, 'NIUE ISLAND', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(727, 'PITCAIRN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(728, 'SOLOMON ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(729, 'TOKELAU ISLANDS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(730, 'TONGA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(731, 'TUVALU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(732, 'VANUATU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(733, 'WALLIS AND FUTUNA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(734, 'NORTHERN MARIANA ISL', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(735, 'MARSHELLES', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(736, 'MICRONESIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(737, 'PALAU', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(738, 'BR NAT. OVERSEAS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(799, 'OC OCEANIA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(886, 'BRITISH SUBJECT', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(887, 'EAST TIMORESE', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(889, 'UNKNOWN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(894, 'KYRGYZSTAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(990, 'KYRGHIS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(991, 'DUTCH', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(992, 'TAJIKISTANI', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(993, 'UPPER VOLTA', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(994, 'BOSNIAN', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(995, 'BR OVERSEAS CIT.', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(996, 'BR PROTECTED PERS.', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(998, 'PACIFIC IS TRUST T', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(999, 'OTHERS', 'active', 'US0001', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(1001, 'caribbean', 'deleted', 'US0001', '2016-04-13 13:25:28', '2016-04-13 17:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'siteTitle', 'PRESTIGE VALET HRM', '2016-04-02 18:37:19', '2016-04-21 15:12:04'),
(2, 'portalName', 'PRESTIGE VALET HRM', '2016-04-02 18:37:19', '2016-04-21 15:12:04'),
(3, 'emailNotifications', 'admin@prestigevalet.com', '2016-04-02 18:37:19', '2016-04-21 15:12:04'),
(4, 'siteLogo', 'http://prestigevalet.cloudelabs.com/uploads/RuwH1IWr8t5F.jpg', '2016-04-02 18:37:19', '2016-04-18 14:18:23'),
(5, 'siteFavIcon', 'http://prestigevalet.cloudelabs.com/uploads/raC5BROENG0E.png', '2016-04-02 18:37:19', '2016-04-18 14:17:58'),
(6, 'senderEmail', 'sales@cloudelabs.com', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(7, 'senderName', 'EZ HRM', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(8, 'smtpHost', 'mail.cloudelabs.com', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(9, 'smtpPort', '25', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(10, 'smtpEmail', 'sales@cloudelabs.com', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(11, 'smtpPassword', 'Cloud@123', '2016-04-02 18:38:11', '2016-04-18 13:27:14'),
(12, 'moduleSettings', 'claimModule,payrollModule,timeSheetsModule,leaveModule,adminModule', '2016-04-02 19:56:17', '2016-04-20 20:07:09'),
(13, 'dateFormat', 'd-m-Y', '2016-04-02 20:12:01', '2016-04-21 15:12:04'),
(14, 'logintype', 'email', '2016-04-04 15:12:15', '2016-04-21 15:12:04'),
(15, 'test', 'email', '2016-04-04 00:00:00', '2016-04-04 00:00:00'),
(16, 'receiptFlagAmount', '', '2016-04-04 00:00:00', '2016-04-04 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `otherpayments`
--

CREATE TABLE IF NOT EXISTS `otherpayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(16) NOT NULL,
  `name` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE IF NOT EXISTS `passes` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, 'E - Pass', 'active', 'admin', '2016-05-12 17:13:18', '2016-05-12 17:13:18'),
(2, 'S - Pass', 'active', 'admin', '2016-05-12 17:13:26', '2016-05-12 17:13:26'),
(3, 'China  Work permit', 'active', 'admin', '2016-05-26 10:13:35', '2016-05-26 10:13:35'),
(4, 'Malaysia Work permit', 'active', 'admin', '2016-05-26 10:14:03', '2016-05-26 10:14:03'),
(5, 'Singaporean', 'active', 'admin', '2016-05-26 10:14:24', '2016-05-26 10:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `paydetails`
--

CREATE TABLE IF NOT EXISTS `paydetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(16) NOT NULL,
  `workPass` smallint(5) unsigned NOT NULL,
  `basicPay` decimal(10,2) NOT NULL,
  `overtimeRate` decimal(10,2) NOT NULL,
  `offdayType` enum('fixed','flexible') NOT NULL DEFAULT 'fixed',
  `offdayRate` decimal(10,2) NOT NULL,
  `phType` enum('fixed','flexible') NOT NULL DEFAULT 'fixed',
  `phRate` decimal(10,2) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `paydetails`
--

INSERT INTO `paydetails` (`id`, `company`, `workPass`, `basicPay`, `overtimeRate`, `offdayType`, `offdayRate`, `phType`, `phRate`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(6, 'GH', 1, '800.00', '20.45', 'fixed', '80.00', 'fixed', '100.00', 'active', 'admin', '2016-04-18 14:38:38', '2016-05-12 17:13:53'),
(7, 'HC', 3, '0.00', '20.00', 'fixed', '80.00', 'fixed', '100.00', 'active', 'admin', '2016-04-18 14:39:16', '2016-04-18 14:39:16'),
(8, 'RWS', 4, '0.00', '8.00', 'fixed', '60.00', 'flexible', '10.00', 'deleted', 'admin', '2016-05-09 16:58:54', '2016-05-17 15:44:20'),
(9, '10', 1, '2500.00', '0.00', 'fixed', '0.00', 'fixed', '0.00', 'active', 'admin', '2016-05-17 15:43:36', '2016-06-01 13:06:52'),
(10, '10', 2, '1200.00', '0.00', 'fixed', '0.00', 'fixed', '0.00', 'active', 'admin', '2016-05-17 15:44:04', '2016-05-26 10:22:22'),
(11, '10', 3, '800.00', '5.76', 'fixed', '0.00', 'fixed', '0.00', 'active', 'admin', '2016-05-26 10:24:51', '2016-05-26 10:24:51'),
(12, '10', 4, '800.00', '5.76', 'fixed', '0.00', 'fixed', '0.00', 'active', 'admin', '2016-05-26 10:25:19', '2016-05-26 10:25:19'),
(13, '10', 5, '800.00', '6.82', 'fixed', '0.00', 'fixed', '0.00', 'active', 'admin', '2016-05-26 10:26:36', '2016-05-26 10:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethods`
--

CREATE TABLE IF NOT EXISTS `paymentmethods` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `paymentmethods`
--

INSERT INTO `paymentmethods` (`id`, `name`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(47, 'Cash', 'active', 'admin', '2016-04-13 13:28:47', '2016-04-18 14:08:40'),
(48, 'Cheque', 'active', 'admin', '2016-04-13 17:32:59', '2016-04-13 17:33:03'),
(49, 'Bank Deposit', 'active', 'admin', '2016-04-13 17:32:59', '2016-04-13 17:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `payslipdetails`
--

CREATE TABLE IF NOT EXISTS `payslipdetails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payslipId` varchar(16) NOT NULL,
  `company` varchar(16) NOT NULL,
  `workPass` int(11) NOT NULL,
  `paymentFrom` date NOT NULL,
  `paymentTo` date NOT NULL,
  `paymentDate` date NOT NULL,
  `modeOfPayment` varchar(16) NOT NULL,
  `calculatedBy` enum('month','day','hour') NOT NULL DEFAULT 'month',
  `perRate` decimal(10,2) NOT NULL,
  `totalWorkingLimit` float NOT NULL,
  `employee` varchar(16) NOT NULL,
  `originalPay` decimal(10,2) NOT NULL,
  `basicPay` decimal(10,2) NOT NULL,
  `empWorkingDays` float NOT NULL,
  `unpaidLeave` float NOT NULL,
  `unpaidLeaveAmount` decimal(10,2) NOT NULL,
  `offDayWork` float NOT NULL,
  `offDayRate` decimal(10,2) NOT NULL,
  `offDayAmount` decimal(10,2) NOT NULL,
  `phDayWork` float NOT NULL,
  `phDayRate` decimal(10,2) NOT NULL,
  `phDayAmount` decimal(10,2) NOT NULL,
  `overtimeHours` float NOT NULL,
  `overtimeRate` decimal(10,2) NOT NULL,
  `overtimeAmount` decimal(10,2) NOT NULL,
  `allowance` decimal(10,2) NOT NULL,
  `allowanceIncludeCpf` decimal(10,2) NOT NULL,
  `totalAllowance` decimal(10,2) NOT NULL,
  `deduction` decimal(10,2) NOT NULL,
  `deductionIncludeCpf` decimal(10,2) NOT NULL,
  `totalDeduction` decimal(10,2) NOT NULL,
  `totalOtherPayments` decimal(10,2) NOT NULL,
  `totalPaidLeaves` int(11) NOT NULL,
  `cdac` decimal(10,2) NOT NULL,
  `sinda` decimal(10,2) NOT NULL,
  `ecf` decimal(10,2) NOT NULL,
  `mbmf` decimal(10,2) NOT NULL,
  `sdl` decimal(10,2) NOT NULL,
  `cpfWages` decimal(10,2) NOT NULL,
  `employeeCpf` decimal(10,2) NOT NULL,
  `employerCpf` decimal(10,2) NOT NULL,
  `totalCpf` decimal(10,2) NOT NULL,
  `grossSalary` decimal(10,2) NOT NULL,
  `netSalary` decimal(10,2) NOT NULL,
  `status` enum('draft','issued') NOT NULL DEFAULT 'draft',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payslipdetails`
--

INSERT INTO `payslipdetails` (`id`, `payslipId`, `company`, `workPass`, `paymentFrom`, `paymentTo`, `paymentDate`, `modeOfPayment`, `calculatedBy`, `perRate`, `totalWorkingLimit`, `employee`, `originalPay`, `basicPay`, `empWorkingDays`, `unpaidLeave`, `unpaidLeaveAmount`, `offDayWork`, `offDayRate`, `offDayAmount`, `phDayWork`, `phDayRate`, `phDayAmount`, `overtimeHours`, `overtimeRate`, `overtimeAmount`, `allowance`, `allowanceIncludeCpf`, `totalAllowance`, `deduction`, `deductionIncludeCpf`, `totalDeduction`, `totalOtherPayments`, `totalPaidLeaves`, `cdac`, `sinda`, `ecf`, `mbmf`, `sdl`, `cpfWages`, `employeeCpf`, `employerCpf`, `totalCpf`, `grossSalary`, `netSalary`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, '1464768865', '10', 0, '2016-05-01', '2016-05-31', '2016-06-06', '', 'month', '0.00', 26, '3000917', '2500.00', '2500.00', 19, 7, '673.08', 0, '0.00', '0.00', 0, '0.00', '0.00', 0, '0.00', '0.00', '1753.84', '0.00', '1753.84', '2450.00', '0.00', '2450.00', '0.00', 0, '1.00', '5.00', '6.00', '5.00', '6.25', '3580.76', '0.00', '0.00', '0.00', '3580.76', '1130.76', 'draft', 'admin', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(2, '1464771818', '10', 0, '2016-05-01', '2016-05-31', '2016-06-06', '', 'month', '0.00', 22, '2644005', '800.00', '800.00', 22, 0, '0.00', 1, '90.00', '90.00', 1, '110.00', '110.00', 65, '6.82', '443.18', '50.00', '0.00', '50.00', '0.00', '0.00', '0.00', '0.00', 0, '0.50', '1.00', '2.00', '2.00', '2.00', '1493.18', '194.00', '194.00', '388.00', '1493.18', '1299.18', 'draft', 'admin', '2016-06-01 17:12:19', '2016-06-01 17:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `payslipdetailsbasics`
--

CREATE TABLE IF NOT EXISTS `payslipdetailsbasics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payslipId` varchar(16) NOT NULL,
  `employee` varchar(16) NOT NULL,
  `paymentFrom` date NOT NULL,
  `paymentTo` date NOT NULL,
  `paymentDate` date NOT NULL,
  `company` varchar(16) NOT NULL,
  `workPass` int(11) NOT NULL,
  `calculatedBy` enum('month','day','hour') NOT NULL DEFAULT 'month',
  `perRate` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('basics','draft','completed') NOT NULL DEFAULT 'basics',
  `createdBy` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `payslipdetailsbasics`
--

INSERT INTO `payslipdetailsbasics` (`id`, `payslipId`, `employee`, `paymentFrom`, `paymentTo`, `paymentDate`, `company`, `workPass`, `calculatedBy`, `perRate`, `total`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(1, '1464768865', '3000917', '2016-05-01', '2016-05-31', '2016-06-06', '10', 1, 'month', '0.00', '26.00', 'draft', 'admin', '2016-06-01 16:14:25', '2016-06-01 16:15:52'),
(2, '1464769292', '3006595', '2016-05-01', '2016-05-31', '2016-06-06', '10', 1, 'month', '0.00', '26.00', 'basics', 'admin', '2016-06-01 16:21:32', '2016-06-01 16:21:32'),
(3, '1464770080', '2644005', '2016-05-01', '2016-05-31', '2016-06-06', '10', 5, 'month', '0.00', '22.00', 'basics', 'admin', '2016-06-01 16:34:40', '2016-06-01 16:34:40'),
(4, '1464770802', '3000917', '2016-05-01', '2016-05-31', '2016-06-06', '10', 1, 'month', '0.00', '26.00', 'basics', 'admin', '2016-06-01 16:46:42', '2016-06-01 16:46:42'),
(5, '1464771427', '2644005', '2016-05-01', '2016-05-31', '2016-06-06', '10', 5, 'month', '0.00', '22.00', 'basics', 'admin', '2016-06-01 16:57:07', '2016-06-01 16:57:07'),
(6, '1464771818', '2644005', '2016-05-01', '2016-05-31', '2016-06-06', '10', 5, 'month', '0.00', '22.00', 'draft', 'admin', '2016-06-01 17:03:38', '2016-06-01 17:12:19'),
(7, '1464772501', '3000917', '2016-05-01', '2016-05-31', '2016-06-06', '10', 1, 'month', '0.00', '26.00', 'basics', 'admin', '2016-06-01 17:15:01', '2016-06-01 17:15:01'),
(8, '1464772501', '3006595', '2016-05-01', '2016-05-31', '2016-06-06', '10', 1, 'month', '0.00', '26.00', 'basics', 'admin', '2016-06-01 17:15:01', '2016-06-01 17:15:01'),
(9, '1464776664', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '21.00', 'basics', 'admin', '2016-06-01 18:24:24', '2016-06-01 18:24:24'),
(10, '1464850431', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '20.00', 'basics', 'admin', '2016-06-02 14:53:51', '2016-06-02 14:53:51'),
(11, '1464852242', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '20.00', 'basics', 'admin', '2016-06-02 15:24:02', '2016-06-02 15:24:02'),
(12, '1464854731', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '20.00', 'basics', 'admin', '2016-06-02 16:05:31', '2016-06-02 16:05:31'),
(13, '1464857167', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '21.00', 'basics', 'admin', '2016-06-02 16:46:07', '2016-06-02 16:46:07'),
(14, '1464857241', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '21.00', 'basics', 'admin', '2016-06-02 16:47:21', '2016-06-02 16:47:21'),
(15, '1464857285', '7316991', '2016-04-23', '2016-05-22', '2016-05-30', '02', 5, 'month', '0.00', '21.00', 'basics', 'admin', '2016-06-02 16:48:05', '2016-06-02 16:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `payslipdetailsmeta`
--

CREATE TABLE IF NOT EXISTS `payslipdetailsmeta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payslipTableId` int(11) NOT NULL,
  `type` enum('allowance','contribution','deduction','leave','otherPayments') NOT NULL DEFAULT 'allowance',
  `fieldId` varchar(10) NOT NULL,
  `fieldValue` decimal(10,2) NOT NULL,
  `includeCpf` enum('yes','no') NOT NULL DEFAULT 'no',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payslipId` (`payslipTableId`,`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `payslipdetailsmeta`
--

INSERT INTO `payslipdetailsmeta` (`id`, `payslipTableId`, `type`, `fieldId`, `fieldValue`, `includeCpf`, `created_at`, `updated_at`) VALUES
(1, 1, 'allowance', '1', '365.38', 'no', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(2, 1, 'allowance', '2', '365.38', 'no', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(3, 1, 'allowance', '3', '292.31', 'no', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(4, 1, 'allowance', '4', '730.77', 'no', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(5, 1, 'deduction', '5', '2450.00', 'no', '2016-06-01 16:15:52', '2016-06-01 16:15:52'),
(6, 2, 'allowance', '6', '50.00', 'no', '2016-06-01 17:12:19', '2016-06-01 17:12:19');

-- --------------------------------------------------------

--
-- Table structure for table `sdlformula`
--

CREATE TABLE IF NOT EXISTS `sdlformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `percentage` decimal(10,2) NOT NULL,
  `minimum` decimal(10,2) NOT NULL,
  `maximum` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sdlformula`
--

INSERT INTO `sdlformula` (`id`, `percentage`, `minimum`, `maximum`, `created_at`, `updated_at`) VALUES
(5, '0.25', '2.00', '11.25', '1899-11-01 00:00:00', '1899-11-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sindaformula`
--

CREATE TABLE IF NOT EXISTS `sindaformula` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('less','between','greater') NOT NULL DEFAULT 'less',
  `amountFrom` decimal(10,2) NOT NULL,
  `amountTo` decimal(10,2) NOT NULL,
  `sindaAmount` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `sindaformula`
--

INSERT INTO `sindaformula` (`id`, `type`, `amountFrom`, `amountTo`, `sindaAmount`, `created_at`, `updated_at`) VALUES
(39, 'less', '1000.00', '0.00', '1.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'between', '1000.00', '1500.00', '3.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'between', '1500.00', '2500.00', '5.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'between', '2500.00', '4500.00', '7.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'between', '4500.00', '7500.00', '9.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'between', '7500.00', '10000.00', '12.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'between', '10000.00', '15000.00', '18.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'greater', '15000.00', '0.00', '30.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(256) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL DEFAULT 'active',
  `createdBy` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `description`, `status`, `createdBy`, `created_at`, `updated_at`) VALUES
(5, 'Accounting', 'Accounting skills', 'active', 'admin', '2016-04-02 16:50:42', '2016-04-18 14:06:57'),
(9, 'Administration', 'Administration Skills', 'active', 'admin', '2016-04-15 14:03:11', '2016-04-18 14:07:17'),
(10, 'Service Delivery', 'Service Delivery Management', 'active', 'admin', '2016-04-15 14:06:10', '2016-04-18 14:07:34'),
(11, 'Consulting', 'Consulting Skills', 'active', 'admin', '2016-04-15 14:06:23', '2016-04-18 14:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `terminatedreason`
--

CREATE TABLE IF NOT EXISTS `terminatedreason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `terminatedreason`
--

INSERT INTO `terminatedreason` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Contract Not Renewed', 'active', '2016-04-13 16:38:43', '2016-04-18 14:10:13'),
(4, 'Deceased', 'active', '2016-04-18 14:10:28', '2016-04-18 14:10:28'),
(5, 'Dismissed', 'active', '2016-04-18 14:10:37', '2016-04-18 14:10:37'),
(6, 'Laid-off', 'active', '2016-04-18 14:10:44', '2016-04-18 14:10:44'),
(7, 'Physically Disabled/Compensated', 'active', '2016-04-18 14:10:51', '2016-04-18 14:10:51'),
(8, 'Resigned', 'active', '2016-04-18 14:10:57', '2016-04-18 14:10:57'),
(9, 'Resigned - Company Requested', 'active', '2016-04-18 14:11:02', '2016-04-18 14:11:02'),
(10, 'Resigned - Self Proposed', 'active', '2016-04-18 14:11:07', '2016-04-18 14:11:07'),
(11, 'Retired', 'active', '2016-04-18 14:11:12', '2016-04-18 14:11:12'),
(12, 'Other', 'active', '2016-04-18 14:11:18', '2016-04-18 14:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) NOT NULL,
  `company` varchar(32) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') NOT NULL,
  `privilege` enum('admin','company','employee') NOT NULL DEFAULT 'company',
  `createdBy` varchar(32) NOT NULL,
  `employeeId` varchar(32) DEFAULT NULL,
  `remember_token` varchar(200) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `company`, `password`, `status`, `privilege`, `createdBy`, `employeeId`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '', '$2y$10$InW0AKq5NkVBCcAWh7VW/uqTH04Peu3DVka8eC9JPqZU8G5Iivg7m', 'active', 'admin', 'admin', NULL, 'sKgZp3w5QIp9uELdUsyNHLTrIM8ORmZTq6QrXVa3vN2yBbP7dKhP8y4LyMZ1', '2016-04-19 19:15:22', '2016-06-02 16:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `workingdays`
--

CREATE TABLE IF NOT EXISTS `workingdays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(16) NOT NULL,
  `workPass` int(11) NOT NULL,
  `weeklyWorkingDays` enum('5','5.5','6') NOT NULL DEFAULT '5',
  `sunday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `monday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `tuesday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `wednesday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `thursday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `friday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `saturday` enum('full','half','non') NOT NULL DEFAULT 'full',
  `totalHours` int(11) NOT NULL,
  `basicHours` int(11) NOT NULL,
  `overtimeHours` int(11) NOT NULL,
  `totalMinutes` int(11) NOT NULL,
  `basicMinutes` int(11) NOT NULL,
  `overtimeMinutes` int(11) NOT NULL,
  `basicHoursSeconds` int(11) NOT NULL,
  `overtimeHoursSeconds` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `workingdays`
--

INSERT INTO `workingdays` (`id`, `company`, `workPass`, `weeklyWorkingDays`, `sunday`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `totalHours`, `basicHours`, `overtimeHours`, `totalMinutes`, `basicMinutes`, `overtimeMinutes`, `basicHoursSeconds`, `overtimeHoursSeconds`, `created_at`, `updated_at`) VALUES
(15, 'GH', 5, '5', 'non', 'full', 'full', 'full', 'full', 'full', 'non', 11, 8, 3, 0, 0, 0, 28800, 10800, '2016-04-21 13:35:36', '2016-04-21 13:35:36'),
(13, 'HC', 5, '5', 'non', 'full', 'full', 'full', 'full', 'full', 'non', 11, 8, 8, 0, 0, 0, 28800, 28800, '2016-04-18 14:22:46', '2016-04-18 14:22:46'),
(17, '10', 1, '6', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 11, 11, 0, 0, 0, 0, 39600, 0, '2016-05-26 10:17:08', '2016-05-26 10:17:08'),
(18, '10', 2, '6', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 11, 11, 0, 0, 0, 0, 39600, 0, '2016-05-26 10:18:13', '2016-05-26 10:18:13'),
(19, '10', 3, '6', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 11, 8, 3, 0, 0, 0, 28800, 10800, '2016-05-26 10:19:04', '2016-05-26 10:19:04'),
(20, '10', 4, '6', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 11, 8, 3, 0, 0, 0, 28800, 10800, '2016-05-26 10:20:15', '2016-05-26 10:20:15'),
(21, '10', 5, '5', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 11, 8, 3, 0, 0, 0, 28800, 10800, '2016-05-26 10:21:05', '2016-05-26 10:21:05'),
(22, 'vw(Alex)', 5, '5.5', 'non', 'full', 'full', 'full', 'full', 'full', 'half', 9, 8, 1, 0, 0, 0, 28800, 3600, '2016-05-27 11:42:53', '2016-05-27 11:42:53'),
(23, 'vw(Alex)', 4, '5.5', 'non', 'full', 'full', 'full', 'full', 'full', 'half', 11, 8, 3, 0, 0, 0, 28800, 9000, '2016-05-27 11:43:32', '2016-05-27 11:43:32'),
(24, '02', 5, '5', 'full', 'full', 'full', 'full', 'full', 'full', 'full', 9, 8, 1, 0, 0, 0, 28800, 3600, '2016-06-01 18:21:26', '2016-06-01 18:21:26');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

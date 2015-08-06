-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 18, 2014 at 11:52 AM
-- Server version: 5.0.45
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `device`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `IDCR_IDCR_TBL_ADMIN_INFO`
-- 

CREATE TABLE `IDCR_IDCR_TBL_ADMIN_INFO` (
  `Admin_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `HR_Employee_Id` varchar(20) default NULL,
  `Admin_Info_Full_Name` varchar(30) NOT NULL,
  `Admin_Info_Email` varchar(50) default NULL,
  `Admin_Info_User_Name` varchar(30) NOT NULL,
  `Admin_Info_User_Password` varchar(30) NOT NULL,
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `System_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Admin_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `IDCR_IDCR_TBL_ADMIN_INFO`
-- 

INSERT INTO `IDCR_IDCR_TBL_ADMIN_INFO` (`Admin_Info_Id`, `HR_Employee_Id`, `Admin_Info_Full_Name`, `Admin_Info_Email`, `Admin_Info_User_Name`, `Admin_Info_User_Password`, `Is_Exist`, `Is_Void`, `System_Date_Time`) VALUES 
(1, '06-2013-793', 'Prodip Das', 'prodip.engr@gmail.com', 'prodip', '123456', '1', '1', '2014-09-09 12:48:36');

-- --------------------------------------------------------

-- 
-- Table structure for table `IDCR_TBL_CATEGORY_INFO`
-- 

CREATE TABLE `IDCR_TBL_CATEGORY_INFO` (
  `Category_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Category_Info_Name` varchar(30) NOT NULL,
  `Category_Info_Description` text NOT NULL,
  `Is_Exist` enum('0','1') NOT NULL default '1',
  `Is_Void` enum('0','1') NOT NULL default '1',
  `System_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`Category_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `IDCR_TBL_CATEGORY_INFO`
-- 

INSERT INTO `IDCR_TBL_CATEGORY_INFO` (`Category_Info_Id`, `Category_Info_Name`, `Category_Info_Description`, `Is_Exist`, `Is_Void`, `System_Date_Time`, `F_Admin_Info_Id`) VALUES 
(1, 'Symphoni T8i', 'Symphoni T8i   TAB', '1', '1', '2014-09-09 12:48:51', NULL),
(2, 'GP SIM (Prepaid)', 'GP SIM (Prepaid for tab', '1', '1', '2014-09-09 14:30:49', NULL),
(3, 'GP SIM (Postpaid)', 'GP SIM (Postpaid) for TAB', '1', '1', '2014-09-09 14:31:15', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `IDCR_TBL_PRODUCT_INFO`
-- 

CREATE TABLE `IDCR_TBL_PRODUCT_INFO` (
  `F_Category_Info_Id` mediumint(8) NOT NULL,
  `F_Status_Info_Id` mediumint(8) NOT NULL default '1',
  `Product_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Product_Info_IMEI_1` varchar(30) NOT NULL,
  `Product_Info_IMEI_2` varchar(30) NOT NULL,
  `Product_Info_Description` text NOT NULL,
  `Is_Exist` enum('0','1') NOT NULL default '1',
  `Is_Void` enum('0','1') NOT NULL default '1',
  `System_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`Product_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `IDCR_TBL_PRODUCT_INFO`
-- 

INSERT INTO `IDCR_TBL_PRODUCT_INFO` (`F_Category_Info_Id`, `F_Status_Info_Id`, `Product_Info_Id`, `Product_Info_IMEI_1`, `Product_Info_IMEI_2`, `Product_Info_Description`, `Is_Exist`, `Is_Void`, `System_Date_Time`, `F_Admin_Info_Id`) VALUES 
(3, 1, 1, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(3, 1, 9, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(3, 1, 10, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(2, 1, 11, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:17:08', NULL),
(3, 1, 12, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(3, 1, 13, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(3, 1, 14, '43354756856463467', '01934433547687678', 'dsgfgfdghgfhg', '1', '1', '2014-09-11 14:14:57', NULL),
(1, 2, 15, 'fdfhgfhgfh', 'dfgfdgfdg', '436554656', '1', '1', '2014-09-18 16:40:10', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `IDCR_TBL_PROD_STATUS_INFO`
-- 

CREATE TABLE `IDCR_TBL_PROD_STATUS_INFO` (
  `Status_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Status_Info_Name` varchar(30) NOT NULL,
  `Status_Info_Description` text NOT NULL,
  `Is_Exist` enum('0','1') NOT NULL default '1',
  `Is_Void` enum('0','1') NOT NULL default '1',
  `System_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`Status_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `IDCR_TBL_PROD_STATUS_INFO`
-- 

INSERT INTO `IDCR_TBL_PROD_STATUS_INFO` (`Status_Info_Id`, `Status_Info_Name`, `Status_Info_Description`, `Is_Exist`, `Is_Void`, `System_Date_Time`, `F_Admin_Info_Id`) VALUES 
(1, 'Stock', 'Stock in Office', '1', '1', '2014-09-18 17:01:45', 0),
(2, 'Person', 'Assign to Person', '1', '1', '2014-09-13 16:06:08', 0),
(3, 'Customer Care', 'Assign to Customer Care', '1', '1', '2014-09-13 16:06:08', 0),
(4, 'Damaged', 'Assign to Damage', '1', '1', '2014-09-13 16:15:27', 0),
(5, 'Lost', 'Assign to Lost', '1', '1', '2014-09-13 16:11:57', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `IDCR_TBL_TRANSACTION`
-- 

CREATE TABLE `IDCR_TBL_TRANSACTION` (
  `F_Product_Info_Id` mediumint(8) NOT NULL,
  `F_User_Info_Id` mediumint(8) NOT NULL,
  `F_Status_Info_Id_Fron` mediumint(8) NOT NULL,
  `F_Status_Info_Id_To` mediumint(8) NOT NULL,
  `Transaction_Id` mediumint(8) NOT NULL auto_increment,
  `Transaction_Description` text NOT NULL,
  `Transaction_Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `Return_Date` datetime NOT NULL default '0000-00-00 00:00:00',
  `F_Admin_Info_Id` mediumint(8) NOT NULL,
  `Is_Exist` enum('0','1') NOT NULL default '1',
  `Is_Void` enum('0','1') NOT NULL default '1',
  `System_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`Transaction_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `IDCR_TBL_TRANSACTION`
-- 

INSERT INTO `IDCR_TBL_TRANSACTION` (`F_Product_Info_Id`, `F_User_Info_Id`, `F_Status_Info_Id_Fron`, `F_Status_Info_Id_To`, `Transaction_Id`, `Transaction_Description`, `Transaction_Date`, `Return_Date`, `F_Admin_Info_Id`, `Is_Exist`, `Is_Void`, `System_Date_Time`) VALUES 
(15, 759, 1, 2, 2, 'sdfdsafdasf', '2014-09-18 00:00:00', '2014-09-27 00:00:00', 1, '1', '1', '2014-09-18 16:40:09');

-- --------------------------------------------------------

-- 
-- Table structure for table `TBL_DEPARTMENT_INFO`
-- 

CREATE TABLE `TBL_DEPARTMENT_INFO` (
  `Department_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Parent_F_Department_Info_Id` mediumint(8) unsigned default '0',
  `Department_Info_Name` varchar(255) NOT NULL,
  `Is_Processed` enum('0','1') default '0',
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `Current_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`Department_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=156 ;

-- 
-- Dumping data for table `TBL_DEPARTMENT_INFO`
-- 

INSERT INTO `TBL_DEPARTMENT_INFO` (`Department_Info_Id`, `Parent_F_Department_Info_Id`, `Department_Info_Name`, `Is_Processed`, `Is_Exist`, `Is_Void`, `Current_Date_Time`, `F_Admin_Info_Id`) VALUES 
(1, 0, 'EDUCATION TODAY', '0', '1', '1', '2014-09-11 16:00:55', NULL),
(2, 0, 'VISITOR', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(3, 0, 'ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(4, 0, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(5, 0, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(6, 0, 'Buss Dev Dept', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(7, 0, 'BUSINESS DEVELOPMENT DEPARTMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(8, 0, 'CASH COUNTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(9, 0, 'CASH COUNTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(10, 0, 'CORPORATE AFFAIRS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(11, 0, 'CREATIVE, PLANING, EVETS & ACTIVATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(12, 0, 'CUSTOMER SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(13, 0, 'FINANCE & ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(14, 0, 'GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(15, 0, 'HUMAN RESOURCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(16, 0, 'HUMAN RESOURCE & ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(17, 0, 'IT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(18, 0, 'LEGAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(19, 0, 'MANAGEMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(20, 0, 'MIS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(21, 0, 'MIS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(22, 0, 'MIS, SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(23, 0, 'OPERATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(24, 0, 'OPERATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(25, 0, 'OPERATION & R&D', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(26, 0, 'POST-PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(27, 0, 'POST-PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(28, 0, 'PRODUCT RESEARCH & DEVELOPMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(29, 0, 'PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(30, 0, 'PUBLIC RELATION & BRAND COMMUNICATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(31, 0, 'R&D - COMPUTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(32, 0, 'R&D - COMPUTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(33, 0, 'R&D - GENERAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(34, 0, 'R&D - GENERAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(35, 0, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(36, 0, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(37, 0, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(38, 0, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(39, 0, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(40, 0, 'STORE MANAGEMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(41, 0, 'SUPPLY CHAIN', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(42, 0, 'SUPPLY CHAIN', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(43, 0, 'WAREHOUSE & DISTRIBUTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(44, 1, 'EDUCATION TODAY', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(45, 2, 'VISITOR', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(46, 3, 'ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(47, 4, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(48, 5, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(49, 4, 'FRONT DESK', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(50, 5, 'FRONT DESK', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(51, 6, 'Buss Dev Dept', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(52, 7, 'BUSINESS DEVELOPMENT DEPARTMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(53, 8, 'CASH COUNTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(54, 9, 'CASH COUNTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(55, 10, 'CORPORATE AFFAIRS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(56, 11, 'CREATIVE, PLANING, EVETS & ACTIVATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(57, 12, 'CUSTOMER SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(58, 13, 'FINANCE & ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(59, 14, 'GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(60, 15, 'HUMAN RESOURCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(61, 16, 'HUMAN RESOURCE & ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(62, 17, 'IT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(63, 17, 'HARDWARE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(64, 18, 'LEGAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(65, 19, 'MANAGEMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(66, 20, 'MIS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(67, 21, 'MIS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(68, 22, 'MIS, SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(69, 23, 'OPERATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(70, 24, 'OPERATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(71, 25, 'OPERATION & R&D', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(72, 26, 'POST-PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(73, 27, 'POST-PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(74, 26, 'LAMINATION SECTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(75, 28, 'PRODUCT RESEARCH & DEVELOPMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(76, 29, 'PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(77, 30, 'PUBLIC RELATION & BRAND COMMUNICATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(78, 31, 'COMMERCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(79, 31, 'ARTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(80, 31, 'R&D - COMPUTER', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(81, 31, 'SCIENCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(82, 31, 'ENGLISH', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(83, 32, 'CREATIVE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(84, 33, 'ARTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(85, 33, 'PRE-PRODUCTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(86, 33, 'COMMERCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(87, 33, 'SCIENCE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(88, 33, 'BANGLADESH OPEN UNIVERSITY', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(89, 33, 'ENGLISH', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(90, 33, 'CENTRAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(91, 33, 'R&D - GENERAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(92, 33, 'BANGLA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(93, 34, 'CREATIVE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(94, 33, 'MADRASA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(95, 33, 'CO-ORDINATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(96, 35, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(97, 36, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(98, 37, 'R&D - GRAPHICS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(99, 38, 'D- CTG / SYLHET', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(100, 38, 'C- DHAKA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(101, 38, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(102, 38, 'DHAKA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(103, 38, 'A- RAJSHAHI', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(104, 38, 'SYLHET', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(105, 38, 'B- KHULNA / BARISHAL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(106, 38, 'PIROJPUR', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(107, 38, 'LALMONIRHAT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(108, 39, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(109, 38, 'COMILLA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(110, 38, 'GOPALGONJ', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(111, 40, 'STORE MANAGEMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(112, 41, 'SUPPLY CHAIN', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(113, 42, 'SUPPLY CHAIN', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(114, 43, 'WAREHOUSE & DISTRIBUTION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(115, 0, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(116, 115, 'ADMINISTRATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(117, 0, 'CLIENT SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(118, 117, 'CLIENT SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(119, 21, 'Sales & Marketing', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(120, 17, 'Sales & Marketing', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(121, 0, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(122, 121, 'Cust. & Brnd. Prom.', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(123, 121, 'SALES MONITORING DEPT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(124, 121, 'BANGLADESH OPEN UNIVERSITY', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(125, 121, 'A-RAJSHAHI-L', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(126, 0, 'BUSINESS DEVELOPMENT DEPARTMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(127, 126, 'BUSINESS DEVELOPMENT DEPARTMENT', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(128, 0, 'Mgt Supp Srv', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(129, 128, 'Mgt Supp Srv', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(130, 0, 'CLIENT SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(131, 130, 'CLIENT SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(132, 0, 'R&D - MADRASA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(133, 132, 'R&D - MADRASA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(134, 121, 'SALES & MARKETING', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(135, 4, 'A-RAJSHAHI', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(136, 43, 'QUALITY CONTROL', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(137, 0, 'POST GRAPHIC', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(138, 137, 'POST GRAPHIC', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(139, 0, 'OPERATION & R & D', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(140, 139, 'OPERATION & R & D', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(141, 0, 'FINANCE & ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(142, 141, 'FINANCE & ACCOUNTS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(143, 0, 'Dist & Circla', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(144, 143, 'DISTRIBUTION & CIRCULATION', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(145, 0, 'LOCAL AFFAIRS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(146, 145, 'LOCAL AFFAIRS', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(147, 0, 'Mgt Supp Srv', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(148, 147, 'MANAGEMENT SUPPORT SERVICE', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(149, 0, 'MADRASHA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(150, 149, 'MADRASHA', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(151, 33, 'R&D - English Version', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(152, 33, 'R&D - Madrasah', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(153, 31, 'Computer - R&D Madrasah', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(154, 38, 'S&M - BM', '0', '1', '1', '2014-09-11 16:01:10', NULL),
(155, 38, 'S&M - Madrasah', '0', '1', '1', '2014-09-11 16:01:10', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `TBL_DESIGNATION`
-- 

CREATE TABLE `TBL_DESIGNATION` (
  `Designation_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Designation_Name` varchar(50) NOT NULL,
  `Short_Form_Of_Designation_Name` varchar(25) NOT NULL,
  `Is_Processed` enum('0','1') default '0',
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `Current_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`Designation_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- 
-- Dumping data for table `TBL_DESIGNATION`
-- 

INSERT INTO `TBL_DESIGNATION` (`Designation_Id`, `Designation_Name`, `Short_Form_Of_Designation_Name`, `Is_Processed`, `Is_Exist`, `Is_Void`, `Current_Date_Time`, `F_Admin_Info_Id`) VALUES 
(9, 'Contributer', 'CON', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(10, 'Executive', 'EXE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(11, 'Peon', 'PEO', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(12, 'Cleaner', 'CLE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(13, 'Driver', 'DRI', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(14, 'Sr. Asst. Manager', 'SAM', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(15, 'Office Assistant', 'OFAS', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(16, 'Sr. Executive', 'SREX', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(17, 'Sales Monitoring Officer', 'SMO', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(18, 'Data Entry Operator', 'DEO', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(19, 'Sales Executive', 'SAEX', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(20, 'Deliveryman', 'DEL', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(21, 'Assistant', 'ASS', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(22, 'Sr. Manager', 'SRMA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(23, 'Head Of The Department', 'HOTD', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(24, 'Asst. Manager', 'ASMA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(25, 'Deputy Manager', 'DEMA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(26, 'Legal Advisor', 'LEAD', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(27, 'Managing Director & CEO', 'MD&C', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(28, 'Director', 'DIR', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(29, 'Chairman', 'CHA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(30, 'Chief Operating Officer', 'COO', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(31, 'Manager', 'MAN', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(32, 'Computer Operator', 'COOP', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(33, 'DOP', 'D&CP', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(34, 'Proof Reader & Editor', 'PR&E', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(35, 'Pester', 'PES', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(36, 'Supervisor', 'SUP', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(37, 'Jr. Executive', 'JREX', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(38, 'Pester Incharge', 'PEIN', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(39, 'Guard', 'GUA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(40, 'Store Keeper', 'STKE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(41, 'Deputy General Manager', 'DGM', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(42, 'Sr. Computer Operator', 'SCO', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(43, 'Writer & Editor', 'W&E', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(44, 'Writer & Sr. Editor', 'W&SE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(45, 'Editor', 'EDI', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(46, 'Co-ordinator', 'CO-', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(47, 'Sr. Proof Reader', 'SPR', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(48, 'Sr. Editor', 'SRED', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(49, 'Proof Reader', 'PRRE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(50, 'Graphics Designer', 'GRDE', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(51, 'Asst. Graphics Designer', 'AGD', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(52, 'Head Of Design & Production', 'HOD&P', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(53, 'Divisional Manager', 'DIMA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(54, 'Zonal Manager', 'ZM', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(55, 'Asst. Zonal Manager', 'AZM', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(56, 'Area Manager', 'ARMA', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(57, 'Sr. Zonal Manager', 'SZM', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(58, 'Blank', 'Blank', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(59, 'Asst. Client Service Executive', 'Ass. Clnt ServExc', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(60, 'Sr. Account Executive', 'Sr.AccExc', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(61, 'Jr. Visualizer', 'Jr.Visualizer', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(62, 'Trainee Executive', 'TraineeExc', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(63, 'Guest', 'Guest', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(64, 'Consultant', 'Cons', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(65, 'Software Engineer', 'SoftEng', '1', '1', '1', '2014-09-11 16:00:30', NULL),
(66, 'Sales & Marketing Executive', 'SME', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(67, 'Sr. Editor & Proof Reader', 'Sr.Editor & Proof Reader', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(68, 'Sr. Writer & Editor', 'Sr. W & E', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(70, 'Jr. Writer & Editor', 'Jr.W & E', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(71, 'PA To MD', 'PA TO MD', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(72, 'Sr. Proof Reader &  Editor', 'Sr. Proof Reader & Editor', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(73, 'Electrician', 'ELECTRICIAN', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(74, 'Local Representative', 'LOCAL REPR', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(75, 'Jr. Graphics Designer', 'Jr. GRAPHICS DESIGNER', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(76, 'Jr. Computer Operator', 'Jr. Comp. Operator', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(77, 'Staff Reporter', 'STAFF REPORTER', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(78, 'Executive Assistant', 'EXE. ASST.', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(79, 'Executive Liaison', 'EXECUTIVE LIAISON', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(80, 'Web Content Writer', 'WCW', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(81, 'Sr. Software Engineer', 'SrSoftEng', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(82, 'Zonal coordinator ', '', '0', '1', '1', '2014-09-11 16:00:30', NULL),
(83, 'Business Analyst', 'BUSANLA', '0', '1', '1', '2014-09-11 16:00:30', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `TBL_DIVISION_INFO`
-- 

CREATE TABLE `TBL_DIVISION_INFO` (
  `Division_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Division_Code` varchar(1) NOT NULL,
  `Division_Name_Eng` varchar(30) default NULL,
  `Division_Name_Bng` text character set utf8 collate utf8_unicode_ci,
  `Marketing_Division_Details` text NOT NULL,
  `Divisional_Manager` varchar(250) character set utf8 collate utf8_unicode_ci default NULL,
  `Is_Processed` enum('0','1') default '0',
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `Current_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) unsigned default NULL,
  PRIMARY KEY  (`Division_Info_Id`),
  KEY `TBL_DIVISION_INFO_F_User_Info_Id` (`F_Admin_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `TBL_DIVISION_INFO`
-- 

INSERT INTO `TBL_DIVISION_INFO` (`Division_Info_Id`, `Division_Code`, `Division_Name_Eng`, `Division_Name_Bng`, `Marketing_Division_Details`, `Divisional_Manager`, `Is_Processed`, `Is_Exist`, `Is_Void`, `Current_Date_Time`, `F_Admin_Info_Id`) VALUES 
(1, 'A', 'Rajshahi', 'রাজশাহী', 'Zone-1, Zone-2, Zone-3, Zone-4,Zone-5,Zone-6,Zone-7, Zone-8', 'Md. Bahadur Islam', '0', '1', '1', '2014-09-11 15:59:29', NULL),
(2, 'B', 'Khulna', 'খুলনা', 'Zone-9,  Zone-10, Zone-11, Zone-12,Zone-13,Zone-14,Zone-15,Zone-16,Zone-17', 'Md. Ohabur Rahman', '0', '1', '1', '2014-09-11 15:59:48', NULL),
(3, 'C', 'Dhaka', 'ঢাকা', 'Zone-18, Zone-19, Zone-20, Zone-21, Zone-22, Zone-23, Zone-24, Zone-25,Zone-26,Zone-27,Zone-28', 'Md. Golam Mostafa', '0', '1', '1', '2014-09-11 15:59:48', NULL),
(4, 'D', 'Chittagong', 'চট্টগ্রাম', 'Zone-29,Zone-30,Zone-31,Zone-32,Zone-33,Zone-34,Zone-35,Zone-36,Zone-37,Zone-38', 'Md. Atikur Rahman', '0', '1', '1', '2014-09-11 15:59:48', NULL),
(5, 'E', 'Corporate Sales', 'অফিস', 'Zone-39,Zone-40', 'Managing Director', '0', '1', '1', '2014-09-11 15:59:48', NULL),
(6, 'F', 'Banglabzar', 'অফিস', '', 'Md. Jakir Hossain', '0', '1', '1', '2014-09-11 15:59:48', NULL),
(7, 'G', 'Head Office', 'হেড অফিস', '', 'Managing Director', '0', '1', '1', '2014-09-11 15:59:48', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `TBL_USER_INFO`
-- 

CREATE TABLE `TBL_USER_INFO` (
  `F_Zilla_Info_Id` mediumint(8) default NULL,
  `F_Designation_Id` mediumint(8) default NULL,
  `F_Department_Info_Id` mediumint(8) NOT NULL,
  `User_Info_Id` mediumint(8) NOT NULL auto_increment,
  `HR_Employee_Id` varchar(20) default NULL,
  `User_Info_Full_Name` varchar(40) default NULL,
  `Contact_No` varchar(11) default NULL,
  `Employee_Parent_Id` mediumint(8) default '0',
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `System_Date_Time` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) default NULL,
  PRIMARY KEY  (`User_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=766 ;

-- 
-- Dumping data for table `TBL_USER_INFO`
-- 

INSERT INTO `TBL_USER_INFO` (`F_Zilla_Info_Id`, `F_Designation_Id`, `F_Department_Info_Id`, `User_Info_Id`, `HR_Employee_Id`, `User_Info_Full_Name`, `Contact_No`, `Employee_Parent_Id`, `Is_Exist`, `Is_Void`, `System_Date_Time`, `F_Admin_Info_Id`) VALUES 
(36, 64, 3, 1, '05-2014-915', 'kamal Ahmed', '019e6547657', NULL, '1', '1', '2014-09-13 16:59:07', 1),
(42, 54, 5, 757, '05-2014-918', 'Md. Mynul Islam', '01712405754', 0, '1', '1', '2014-09-13 16:59:54', 1),
(27, 55, 0, 759, '04-2014-900', 'Md. Asadul Islam', '01938855945', 0, '1', '1', '0000-00-00 00:00:00', NULL),
(56, 54, 0, 765, '05-2014-919', 'Md. Monir Hossain', '01553059819', 0, '1', '1', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

-- 
-- Table structure for table `TBL_ZILLA_INFO`
-- 

CREATE TABLE `TBL_ZILLA_INFO` (
  `F_Division_Info_Id` mediumint(8) unsigned default NULL,
  `Zilla_Info_Id` mediumint(8) unsigned NOT NULL auto_increment,
  `Zilla_Code` varchar(3) NOT NULL,
  `Zilla_Name_Eng` varchar(100) default '',
  `Zilla_Name_Bng` text character set utf8 collate utf8_unicode_ci,
  `Is_Processed` enum('0','1') default '0',
  `Is_Exist` enum('0','1') default '1',
  `Is_Void` enum('0','1') default '1',
  `Current_Date_Time` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `F_Admin_Info_Id` mediumint(8) unsigned default NULL,
  `Division` varchar(100) NOT NULL,
  PRIMARY KEY  (`Zilla_Info_Id`),
  KEY `TBL_ZILLA_INFO_F_Division_Info_Id` (`F_Division_Info_Id`),
  KEY `TBL_ZILLA_INFO_F_User_Info_Id` (`F_Admin_Info_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- 
-- Dumping data for table `TBL_ZILLA_INFO`
-- 

INSERT INTO `TBL_ZILLA_INFO` (`F_Division_Info_Id`, `Zilla_Info_Id`, `Zilla_Code`, `Zilla_Name_Eng`, `Zilla_Name_Bng`, `Is_Processed`, `Is_Exist`, `Is_Void`, `Current_Date_Time`, `F_Admin_Info_Id`, `Division`) VALUES 
(1, 1, '001', 'Panchagar', 'পঞ্চগড়', '0', '1', '1', '2014-09-11 15:58:24', NULL, 'Rajshahi'),
(1, 2, '002', 'Thakurgaon', 'ঠাকুরগাঁও', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 3, '003', 'Nilphamari', 'নীলফামারি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 4, '004', 'Lalmonirhat', 'লালমনিরহাট', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 5, '005', 'Dinajpur', 'দিনাজপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 6, '006', 'Rangpur', 'রংপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 7, '007', 'Kurigram', 'কুড়িগ্রাম', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 8, '008', 'Gaibandha', 'গাইবান্ধা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 9, '009', 'Bogra', 'বগুড়া', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 10, '010', 'Joypurhat', 'জয়পুরহাট', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 11, '011', 'Naogaon', 'নওগাঁ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 12, '012', 'Chapainawabganj', 'চাপাইনবাবগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 13, '013', 'Rajshahi', 'রাজশাহী', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 14, '014', 'Natore', 'নাটোর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 15, '015', 'Sirajgonj', 'সিরাজগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(1, 16, '016', 'Pabna', 'পাবনা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Rajshahi'),
(2, 17, '017', 'Kushtia', 'কুষ্টিয়া', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 18, '018', 'Barisal', 'বরিশাল', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 19, '019', 'Pirojpur', 'পিরোজপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 20, '020', 'Jhalakathi', 'ঝালকাঠি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 21, '021', 'Barguna', 'বরগুনা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 22, '022', 'Patuakhali', 'পঠুয়াখালি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 23, '023', 'Bhola', 'ভোলা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(3, 24, '024', 'Tangail', 'টাঙ্গাইল', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 25, '025', 'Jamalpur', 'জামালপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 26, '026', 'Sherpur', 'শেরপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 27, '027', 'Mymensingh', 'ময়মনসিংহ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 28, '028', 'Netrakona', 'নেত্রকোণা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(4, 29, '029', 'Brahamanbaria', 'বাহ্মণবাড়িয়া', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 30, '030', 'Habiganj', 'হবিগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 31, '031', 'Moulavibazar', 'মৌলভীবাজার', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 32, '032', 'Sylhet', 'সিলেট', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 33, '033', 'Sunamganj', 'সুনামগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(3, 34, '034', 'Manikganj', 'মানিকগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 35, '035', 'Dhaka', 'ঢাকা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 36, '036', 'Gazipur', 'গাজিপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 37, '037', 'Munshiganj', 'মুন্সিগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 38, '038', 'Narayanganj', 'নারায়নগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 39, '039', 'Narsingdi', 'নরসিংদী', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(3, 40, '040', 'Kishoreganj', 'কিশোরগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Dhaka'),
(4, 41, '041', 'Chandpur', 'চাঁদপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 42, '042', 'Comilla', 'কুমিল্লা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 43, '043', 'Feni', 'ফেনী', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 44, '044', 'Noakhali', 'নোয়াখালী', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 45, '045', 'Lakshmipur', 'লক্ষ্মীপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(2, 46, '046', 'Magura', 'মাগুরা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 47, '047', 'Jhenaidah', 'ঝিনাইদহ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 48, '048', 'Chuadanga', 'চুয়াডাঙ্গা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 49, '049', 'Meherpur', 'মেহেরপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 50, '050', 'Jessore', 'যশোর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 51, '051', 'Narail', 'নড়াইল', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 52, '052', 'Satkhira', 'সাতক্ষীরা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 53, '053', 'Khulna', 'খুলনা', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 54, '054', 'Bagerhat', 'বাগেরহাট', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(4, 55, '055', 'Chittagong', 'চট্টগ্রাম', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 56, '056', 'Coxs Bazar', 'কক্সবাজার', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 57, '057', 'Khagrachari', 'খাগড়াছড়ি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 58, '058', 'Rangamati', 'রাঙ্গামাটি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(4, 59, '059', 'Bandarban', 'বান্দরবন', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Chittagong'),
(2, 60, '060', 'Faridpur', 'ফরিদপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 61, '061', 'Madaripur', 'মাদারিপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 62, '062', 'Shariatpur', 'শরিয়তপুর', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 63, '063', 'Gopalganj', 'গোপালগঞ্জ', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(2, 64, '064', 'Rajbari', 'রাজবাড়ি', '0', '1', '1', '2014-09-11 15:59:09', NULL, 'Khulna'),
(1, 65, '065', 'NAWABGANJ', NULL, '0', '1', '1', '2014-09-11 15:59:09', NULL, ''),
(7, 100, '100', 'Undefined', NULL, '0', '1', '1', '2014-09-11 15:59:09', NULL, '');

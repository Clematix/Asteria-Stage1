-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 12, 2015 at 03:07 AM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `silvesb0_asteria`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_controller_list`
--

DROP TABLE IF EXISTS `acl_controller_list`;
CREATE TABLE IF NOT EXISTS `acl_controller_list` (
  `acl_controller_id` int(20) NOT NULL AUTO_INCREMENT,
  `controller_action` varchar(100) NOT NULL,
  `controller_name` varchar(100) NOT NULL,
  `module_id` varchar(20) NOT NULL,
  `view` int(5) NOT NULL,
  `create` int(5) NOT NULL,
  `edit` int(5) NOT NULL,
  `approve` int(5) NOT NULL,
  PRIMARY KEY (`acl_controller_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `acl_controller_list`
--

INSERT INTO `acl_controller_list` (`acl_controller_id`, `controller_action`, `controller_name`, `module_id`, `view`, `create`, `edit`, `approve`) VALUES
(1, 'auth/manageemployee', 'Employee Management', 'UM', 1, 1, 1, 1),
(2, 'auth/addgroupdept', 'Department and Designation', 'UM', 1, 1, 1, 1),
(3, 'auth/roles', 'Role Management', 'UM', 1, 1, 1, 1),
(4, 'material/index', 'Material Master', 'MM', 1, 1, 1, 1),
(5, 'material/statusmaster', 'Material Status', 'MM', 1, 1, 1, 0),
(6, 'material/groupcategorymaster', 'Material Major Category', 'MM', 1, 1, 0, 0),
(7, 'material/groupmaster', 'Material Sub Category', 'MM', 1, 1, 1, 1),
(8, 'material/typemaster', 'Material Type', 'MM', 1, 1, 1, 0),
(9, 'submodules/designbase', 'Design Base', 'MM', 1, 1, 1, 0),
(10, 'submodules/position', 'Position Category', 'MM', 1, 1, 1, 0),
(11, 'submodules/final', 'Finish Category', 'MM', 1, 1, 1, 0),
(12, 'material/projectmaster', 'Project', 'MM', 1, 1, 0, 1),
(13, 'bom/index', 'BOM', 'MM', 1, 1, 1, 1),
(14, 'sales/index', 'Sales Order', 'SO', 1, 1, 0, 1),
(15, 'material/shipping', 'Shipping Method', 'MM', 1, 1, 1, 1),
(16, 'vendor/index', 'Vendor List', 'MM', 1, 1, 1, 1),
(17, 'customer/manage', 'Customer List', 'MM', 1, 1, 1, 1),
(18, 'vendor/vendorpo', 'Vendor PO Master', 'PO', 1, 1, 1, 1),
(19, 'grn/index', 'GRN', 'PO', 1, 1, 1, 1),
(20, 'sales/workorder', 'Work Order', 'SO', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_modules`
--

DROP TABLE IF EXISTS `acl_modules`;
CREATE TABLE IF NOT EXISTS `acl_modules` (
  `acl_module_id` int(25) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  PRIMARY KEY (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `acl_modules`
--

INSERT INTO `acl_modules` (`acl_module_id`, `module_name`, `module_id`) VALUES
(1, 'User Management', 'UM'),
(2, 'Master Data', 'MM'),
(3, 'Purchasing', 'PO'),
(4, 'Sales', 'SO');

-- --------------------------------------------------------

--
-- Table structure for table `acl_module_permissions`
--

DROP TABLE IF EXISTS `acl_module_permissions`;
CREATE TABLE IF NOT EXISTS `acl_module_permissions` (
  `acl_module_permission_id` int(25) NOT NULL AUTO_INCREMENT,
  `acl_module_id` varchar(10) NOT NULL,
  `acl_permission_id` char(1) NOT NULL,
  `role_id` char(2) NOT NULL,
  PRIMARY KEY (`acl_module_permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `acl_permissions`
--

DROP TABLE IF EXISTS `acl_permissions`;
CREATE TABLE IF NOT EXISTS `acl_permissions` (
  `acl_permission_id` int(25) NOT NULL AUTO_INCREMENT,
  `acl_permission_name` varchar(25) NOT NULL,
  PRIMARY KEY (`acl_permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `acl_permissions`
--

INSERT INTO `acl_permissions` (`acl_permission_id`, `acl_permission_name`) VALUES
(1, 'Create'),
(2, 'Edit'),
(3, 'View'),
(4, 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `acl_roles`
--

DROP TABLE IF EXISTS `acl_roles`;
CREATE TABLE IF NOT EXISTS `acl_roles` (
  `acl_role_id` int(25) NOT NULL AUTO_INCREMENT,
  `acl_role_name` varchar(255) NOT NULL,
  `acl_module_id` varchar(255) DEFAULT NULL,
  `acl_controller_id` varchar(255) NOT NULL,
  `acl_permission` text NOT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`acl_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `acl_roles`
--

INSERT INTO `acl_roles` (`acl_role_id`, `acl_role_name`, `acl_module_id`, `acl_controller_id`, `acl_permission`, `status`) VALUES
(18, 'Admin', '{"1":"UM","2":"MM","3":"PO","4":"SO"}', '{"UM":{"1":"1","2":"2","3":"3"},"MM":{"4":"4","5":"5","6":"6","7":"7","8":"8","9":"9","10":"10","11":"11","12":"12","13":"13","15":"15","16":"16","17":"17"},"PO":{"18":"18","19":"19"},"SO":{"14":"14","20":"20"}}', '{"1":{"view":"1","create":"1","edit":"1","approve":"1"},"2":{"view":"1","create":"1","edit":"1","approve":"1"},"3":{"view":"1","create":"1","edit":"1","approve":"1"},"4":{"view":"1","create":"1","edit":"1","approve":"1"},"5":{"view":"1","create":"1","edit":"1"},"6":{"view":"1","create":"1"},"7":{"view":"1","create":"1","edit":"1","approve":"1"},"8":{"view":"1","create":"1","edit":"1"},"9":{"view":"1","create":"1","edit":"1"},"10":{"view":"1","create":"1","edit":"1"},"11":{"view":"1","create":"1","edit":"1"},"12":{"view":"1","create":"1","approve":"1"},"13":{"view":"1","create":"1","edit":"1","approve":"1"},"15":{"view":"1","create":"1","edit":"1","approve":"1"},"16":{"view":"1","create":"1","edit":"1","approve":"1"},"17":{"view":"1","create":"1","edit":"1","approve":"1"},"18":{"view":"1","create":"1","edit":"1","approve":"1"},"19":{"view":"1","create":"1","edit":"1","approve":"1"},"14":{"view":"1","create":"1","approve":"1"},"20":{"view":"1","create":"1","edit":"1","approve":"1"}}', 1),
(23, 'AdminTest', '{"1":"UM","2":"MM"}', '{"UM":{"1":"1","3":"3","4":"4"},"MM":{"5":"5","6":"6"}}', '{"1":{"view":"1","edit":"1"},"3":{"view":"1"},"4":{"view":"1","create":"1","edit":"1"},"5":{"view":"1","create":"1","edit":"1"},"6":{"view":"1","create":"1"}}', 1),
(25, 'test3', '{"2":"MM"}', '{"MM":{"5":"5","6":"6","7":"7"}}', '{"5":{"view":"1","create":"1","edit":"1","approve":"1"},"6":{"view":"1"},"7":{"view":"1","create":"1","edit":"1","approve":"1"}}', 1),
(26, 'test', '{"1":"UM"}', '{"UM":{"1":"1","3":"3","4":"4"}}', '{"1":{"view":"1"},"3":{"view":"1"},"4":{"view":"1"}}', 1),
(28, 'TESTTODAY', '{"1":"UM","2":"MM"}', '{"UM":{"1":"1","3":"3","4":"4"},"MM":{"5":"5","6":"6","7":"7","12":"12","13":"13","14":"14","15":"15","16":"16","20":"20"}}', '{"1":{"view":"1","create":"1","edit":"1"},"3":{"view":"1","create":"1","edit":"1","approve":"1"},"4":{"view":"1","create":"1","edit":"1","approve":"1"},"5":{"view":"1"},"6":{"view":"1"},"7":{"view":"1"},"12":{"view":"1"},"13":{"view":"1"},"14":{"view":"1"},"15":{"view":"1"},"16":{"view":"1"},"20":{"view":"1"}}', 1),
(29, 'TESTINGS', '{"1":"UM"}', '{"UM":{"1":"1","3":"3","4":"4"}}', '{"1":{"view":"1"},"3":{"view":"1","approve":"1"},"4":{"view":"1"}}', 1),
(30, 'dfsdf', '{"1":"UM","8":"SO"}', '{"UM":{"1":"1"},"SO":null}', '{"1":{"view":"1"}}', 1),
(31, 'gggg', '{"1":"UM"}', '{"UM":{"1":"1","3":"3","4":"4"}}', '{"1":{"view":"1"},"3":{"view":"1"},"4":{"view":"1"}}', 1),
(32, 'blah', '{"2":"MM"}', '{"MM":{"5":"5"}}', '{"5":{"view":"1","create":"1","edit":"1","approve":"1"}}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_user_roles`
--

DROP TABLE IF EXISTS `acl_user_roles`;
CREATE TABLE IF NOT EXISTS `acl_user_roles` (
  `acl_user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `acl_user_modules` varchar(50) NOT NULL,
  PRIMARY KEY (`acl_user_role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `adminusers`
--

DROP TABLE IF EXISTS `adminusers`;
CREATE TABLE IF NOT EXISTS `adminusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `department` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `adminusers`
--

INSERT INTO `adminusers` (`id`, `status`, `firstname`, `lastname`, `email`, `password`, `role`, `department`, `group`, `created`) VALUES
(5, '1', 'Asteria', 'Admin', 'admin@asteria.com', '5858ea228cc2edf88721699b2c8638e5', '["18"]', '5', '11', '2015-08-01 05:28:03'),
(6, '1', 'sdafasfdfg', 'asdfdsfdsf', 'kumaran.m89@gmail.com', 'e11170b8cbd2d74102651cb967fa28e5', '["31"]', '21', '11', '2015-08-05 09:09:00'),
(8, '1', 'Kumar', 'Goudham', 'asteriaddd@clematix.com', 'e10adc3949ba59abbe56e057f20f883e', '["23"]', '5', '11', '2015-08-05 09:21:23'),
(11, '1', 'PK', 'G', 'PK@DLF.COM', '76d80224611fc919a5d54f0ff9fba446', '["23"]', '9', '12', '2015-10-19 11:34:01'),
(12, '1', 'VIKAS', 'ABBI', 'vikas@ws.com', '098f6bcd4621d373cade4e832627b4f6', '["18","23"]', '12', '20', '2015-10-19 12:04:02'),
(13, '1', 'hari', 'haran', 'hari@df.com', '098f6bcd4621d373cade4e832627b4f6', '["28","29"]', '5', '11', '2015-10-19 12:16:45'),
(14, '1', 'hari', 'haran', 'hari@dlf.com', '098f6bcd4621d373cade4e832627b4f6', '["28"]', '5', '11', '2015-10-19 12:19:57'),
(15, '1', 'arjun', 'm', 'mmm@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '["28"]', '5', '11', '2015-10-19 12:33:05'),
(16, '1', 'KUMAR', 'KUMAR', 'HUJ@WWS.SS', '033bd94b1168d7e4f0d644c3c95e35bf', '["18"]', '5', '11', '2015-10-19 12:58:01'),
(17, '1', 'sachinr', 'sachinram', 'admin@clematix.com', 'd8053f0c8d004e7ffbed19ce57f078ec', '["28"]', '5', '12', '2015-10-20 04:57:06'),
(18, '1', 'sdff', 'sdfsdfggg', 'sdfsdf@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '["18"]', '20', '24', '2015-10-20 05:55:15'),
(19, '1', 'dsads', 'fdsf', 'mm@g.com', '96e79218965eb72c92a549dd5a330112', '["18"]', '19', '23', '2015-10-23 09:49:53'),
(20, '1', 'hjgh', 'jghjhg', 'jghj@g.com', 'e165421110ba03099a1c0393373c5b43', '["23","25"]', '10', '18', '2015-10-26 07:58:07'),
(21, '1', 'dgg', 'dfgdfg', 'dfgdfg@gmail.com', '96e79218965eb72c92a549dd5a330112', '["18"]', '7', '12', '2015-10-26 10:00:07'),
(22, '0', 'sad', 'adf', 'agfagdfagadfhdfa@wrgarhraeh.aga', 'f1b708bba17f1ce948dc979f4d7092bc', '["18"]', '11', '18', '2015-10-30 13:14:19'),
(23, '1', 'blah', 'blah', 'blah@blah.com', 'f1b708bba17f1ce948dc979f4d7092bc', '["32"]', '5', '11', '2015-10-30 13:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

DROP TABLE IF EXISTS `bom`;
CREATE TABLE IF NOT EXISTS `bom` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `bom_rev_id` varchar(150) DEFAULT NULL,
  `bom_project_id` varchar(250) NOT NULL,
  `material_id` int(50) NOT NULL,
  `project_id` varchar(150) NOT NULL,
  `date` varchar(50) NOT NULL,
  `status` int(5) NOT NULL,
  `bom_description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bom_id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`id`, `bom_rev_id`, `bom_project_id`, `material_id`, `project_id`, `date`, `status`, `bom_description`) VALUES
(1, 'E', 'test', 1, '1111', '09/Nov/2015', 1, '1'),
(2, 'A', 'test', 14, '1111', '03/Nov/2015', 1, 'Sample Material'),
(3, 'C', 'test', 13, '1111', '09/Nov/2015', 1, 'pieces'),
(4, 'A', 'test', 17, '1111', '05/Nov/2015', 1, 'METER'),
(5, 'A', 'test', 18, '1111', '05/Nov/2015', 1, 'crate'),
(6, 'A', 'test', 20, '1111', '05/Nov/2015', 1, 'FOOT'),
(7, 'A', 'test', 21, '1111', '05/Nov/2015', 1, 'Grams sample'),
(8, 'H', 'test', 22, '1111', '09/Nov/2015', 1, 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `bom_ref`
--

DROP TABLE IF EXISTS `bom_ref`;
CREATE TABLE IF NOT EXISTS `bom_ref` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `bom_id` int(25) NOT NULL,
  `material_id` int(25) NOT NULL,
  `qty` int(25) NOT NULL,
  `comments` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rev_id` varchar(50) DEFAULT NULL,
  `uom` int(25) NOT NULL,
  `br` varchar(50) DEFAULT NULL,
  `cv` varchar(50) DEFAULT NULL,
  `csp` varchar(50) DEFAULT NULL,
  `fyn` varchar(50) DEFAULT NULL,
  `sbm` varchar(50) DEFAULT NULL,
  `pthrsmt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `bom_ref`
--

INSERT INTO `bom_ref` (`id`, `bom_id`, `material_id`, `qty`, `comments`, `date`, `rev_id`, `uom`, `br`, `cv`, `csp`, `fyn`, `sbm`, `pthrsmt`) VALUES
(11, 8, 13, 100, '', '2015-11-06 07:19:31', 'B', 14, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 8, 13, 50, '', '2015-11-09 07:32:44', 'C', 15, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 8, 13, 454645, '', '2015-11-09 07:35:16', 'H', 10, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `config_mail`
--

DROP TABLE IF EXISTS `config_mail`;
CREATE TABLE IF NOT EXISTS `config_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_server` varchar(225) NOT NULL,
  `mail_port` varchar(225) NOT NULL,
  `mail_username` varchar(225) NOT NULL,
  `mail_password` varchar(225) NOT NULL,
  `admin_mail` varchar(225) NOT NULL,
  `contact_mail` varchar(225) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `config_mail`
--

INSERT INTO `config_mail` (`id`, `mail_server`, `mail_port`, `mail_username`, `mail_password`, `admin_mail`, `contact_mail`, `date`) VALUES
(1, 'mail.gmail.com1', '567', 'kumar@clematix.co.in1', '1234564', 'kumar@clematix.co.in', 'kumar@clematix.co.in', '2014-12-17 20:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(20) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_address` text NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `industry` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `company_name`, `company_address`, `contact_person`, `country`, `region`, `industry`, `email`, `telephone`) VALUES
(5, 'f', 'hosur\r\nhosur', 'test', 'India', 'TN', 'test', 'asteria@clematix.com', '9994729807'),
(6, 'test', 'hosur\r\nhosur', 'Kumar', 'India', 'TN', 'test', 'kumaran.m89@gmail.com', '2147483647'),
(8, 'clematix', 'clematix', 'admin', 'dafds', 'dsfdsf', 'dsfds', 'dfds@gmail.in', '33432'),
(9, 'qwertyuiopasdfghjklzc', 'PANDIT ENGINEERING WORKS\r\nKATRAJ KONDHWA ROAD\r\n\r\nMAHARASHTRA\r\nPIN : 411046\r\nPhone : 020-26962718', 'PANDIT ENGINEERING WORKS', 'KATRAJ KONDHWA ROAD  MAHARASHTRA PIN : 411046 Phone : 020-26962718', 'KATRAJ KONDHWA ROAD  MAHARASHTRA PIN : 411046 Phone : 020-26962718', 'KATRAJ KONDHWA ROAD  MAHARASHTRA PIN : 411046 Phone : 020-26962718', 'PANDIT@hjk.hh', 'KATRAJ KONDHWA ROAD '),
(10, 'IGARASHI', 'IMIL,\r\nPLOT NO:12,\r\nMEPZ-SEZ ZONE,\r\nTAMBARAM,\r\n', 'PRAVIN', 'INDIA', 'SOUTH INDIA', 'AUTOMOTIVE INDUSTRY SECTOR', 'kjhdfkjhas@kjhdskjgh.com', '23232323'),
(11, 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPR', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA', 'PRAVINKUMARCHERMAKAN', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA@gmail.com', 'PRAVINKUMARCHERMAKAN');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `status`) VALUES
(5, 'Account mnagerggg', 1),
(7, 'Testing', 1),
(9, 'PuRcHasE', 1),
(10, 'uideveloper', 1),
(11, 'support', 1),
(12, 'javateam', 1),
(13, 'DBA', 1),
(14, 'ADMIN', 1),
(15, 'DOTNETTEAM', 0),
(17, 'gggg', 0),
(18, 'fffffffffff', 0),
(19, 'test', 0),
(20, 'sdfd', 0),
(21, 'SDFDSFSF', 0),
(22, 'TQ', 0),
(23, 'Warehouse', 0),
(24, 'dsasvdsvdscvdsvb', 0),
(25, 'ddfPOfbfb ggg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `designbase`
--

DROP TABLE IF EXISTS `designbase`;
CREATE TABLE IF NOT EXISTS `designbase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designbase` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `designbase`
--

INSERT INTO `designbase` (`id`, `designbase`, `code`, `desc`, `status`, `date`) VALUES
(1, 'Asteria', 'A', '', 1, '2015-08-28 11:39:11'),
(3, 'Universal', 'U', '', 1, '2015-08-28 11:45:22'),
(4, 'Non-Asteria', 'N', '', 1, '2015-08-28 11:45:21'),
(5, 'Others', 'O', '', 1, '2015-08-31 09:25:03'),
(6, 'Test', 'T', 'Test Sample1', 0, '0000-00-00 00:00:00'),
(7, 'dfgsd', 'sdf', 'sdfsdfsdf', 1, '0000-00-00 00:00:00'),
(8, 'testing', 'testing', 'testing', 1, '0000-00-00 00:00:00'),
(9, 'sds', 'www', '', 1, '0000-00-00 00:00:00'),
(10, 'IOS', 'SoftwarePr', 'SoftwareProductsSoftwareProductsSoftwareProductsSoftwareProductsSoftwareProductsSoftwareProductsSoft', 1, '0000-00-00 00:00:00'),
(11, 'Android', 'SoftwarePr', '', 1, '0000-00-00 00:00:00'),
(12, 'Selenium', 'selenium', 'Selenium', 1, '0000-00-00 00:00:00'),
(13, 'AUTOCAD', 'AUTOCAD', 'AUTOCAD', 1, '0000-00-00 00:00:00'),
(14, 'PRAVINKUMARPRAVINKUM', 'PRAVINKUMA', 'pk', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fnlm`
--

DROP TABLE IF EXISTS `fnlm`;
CREATE TABLE IF NOT EXISTS `fnlm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `fnlm`
--

INSERT INTO `fnlm` (`id`, `descr`, `code`, `desc`, `status`, `date`) VALUES
(1, 'No Special Operation', '00', '', 1, '2015-08-28 10:30:14'),
(2, 'Sandblasted', '01', '', 1, '2015-08-28 10:30:12'),
(3, 'Primer Only', '02', '', 1, '2015-08-28 10:30:13'),
(4, 'KUM', '03', '', 1, '0000-00-00 00:00:00'),
(5, 'LH', '04', '', 1, '2015-09-07 11:02:20'),
(6, 'Ram', '05', 'Ram ', 1, '0000-00-00 00:00:00'),
(7, 'sdfsd', '06', 'sdfsdf', 1, '0000-00-00 00:00:00'),
(8, 'test', '07', 'test', 1, '0000-00-00 00:00:00'),
(9, 'ng', '08', 'gh', 1, '0000-00-00 00:00:00'),
(10, 'Package', '09', '123', 1, '0000-00-00 00:00:00'),
(11, 'Selenium', '10', 'Selenium', 1, '0000-00-00 00:00:00'),
(12, 'PackageqwePackageqwe', '11', 'PackageqwePackageqwePackageqwePackageqwePackageqwePackageqwePackageqwePackageqwePackageqwePackageqwe', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

DROP TABLE IF EXISTS `grn`;
CREATE TABLE IF NOT EXISTS `grn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(10) NOT NULL,
  `vendor_po` varchar(40) NOT NULL,
  `grn_no` varchar(20) NOT NULL,
  `grn_date` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `vendor_name`, `vendor_po`, `grn_no`, `grn_date`, `status`, `date`) VALUES
(3, '3', '5', '2015/0002', '21-10-2015', 0, '2015-10-30 23:45:36'),
(4, '3', '5', '2015/0002', '21-10-2015', 0, '2015-10-30 23:46:34'),
(5, '1', '1', '2015/0003', '01-09-2012', 0, '2015-11-03 23:02:10'),
(6, '4', '3', '2015/0004', '03-11-2015', 0, '2015-11-03 23:05:26'),
(7, '1', '1', '2015/0005', '02-11-2009', 0, '2015-11-03 23:08:25'),
(8, '1', '1', '2015/0006', '03-11-2015', 0, '2015-11-03 23:55:57'),
(9, '1', '2', '2015/0007', '04-11-2015', 0, '2015-11-04 23:00:49'),
(10, '1', '2', '2015/0008', '10-11-2015', 0, '2015-11-04 23:02:15'),
(11, '10', '15', '2015/0009', '05-11-2015', 0, '2015-11-05 23:15:20'),
(12, '10', '16', '2015/0010', '05-11-2015', 0, '2015-11-06 00:31:48'),
(13, '11', '17', '2015/0011', '05-11-2015', 0, '2015-11-06 18:03:00'),
(14, '11', '18', '2015/0012', '06-11-2015', 0, '2015-11-06 19:06:45'),
(15, '11', '19', '2015/0013', '06/11/2015', 0, '2015-11-06 19:51:43'),
(16, '12', '21', '2015/0014', '4545454354543', 0, '2015-11-06 22:13:38'),
(17, '16', '23', '2015/0015', '02/11/2015', 0, '2015-11-12 22:05:37'),
(18, '16', '24', '2015/0016', '12/11/2015', 0, '2015-11-12 22:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `grn_material`
--

DROP TABLE IF EXISTS `grn_material`;
CREATE TABLE IF NOT EXISTS `grn_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `poqty` int(11) NOT NULL,
  `rcvdqty` int(11) NOT NULL,
  `okqty` int(11) NOT NULL,
  `rejectedqty` int(11) NOT NULL,
  `ast_sl` int(11) NOT NULL,
  `mfgdate` varchar(20) NOT NULL,
  `expiry` varchar(20) NOT NULL,
  `serial` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `grn_material`
--

INSERT INTO `grn_material` (`id`, `grn_id`, `item`, `poqty`, `rcvdqty`, `okqty`, `rejectedqty`, `ast_sl`, `mfgdate`, `expiry`, `serial`) VALUES
(3, 3, 1, 11, 1, 10, -9, 11, '', '', 'AA006, AA007, AA008, AA009, AA010, AA011, AA012, AA013, AA014, AA015'),
(4, 4, 1, 11, 1, 10, -9, 11, '', '', 'AA006, AA007, AA008, AA009, AA010, AA011, AA012, AA013, AA014, AA015'),
(5, 5, 1, 500, 500, 1, 0, 0, '', '', ''),
(6, 6, 3, 440, 440, 400, 0, 1212, '', '', '15-11-03-AA'),
(7, 7, 1, 499, -21, -5, 0, 0, '', '', ''),
(8, 8, 1, 504, 232, 232, 0, 0, '', '', ''),
(9, 9, 1, 1000, 8, 7, 0, 0, '', '', ''),
(10, 10, 1, 993, 7, 5, 0, 5, '', '', ''),
(11, 11, 17, 12, 12, 1, 0, 1212, '', '', 'AA001'),
(12, 11, 17, 9, 9, 9, 0, 0, '', '', 'AA001'),
(13, 12, 18, 1, 0, 0, 0, 0, '', '', ''),
(14, 13, 20, 1, 1, 1, 0, 1, '', '', 'AA001'),
(15, 13, 20, 2, 1, 1, 0, 1, '', '', 'AA001'),
(16, 14, 21, 100, 50, 40, 0, 12, '', '', '15-11-06-AA'),
(17, 14, 21, 50, 30, 20, 0, 12, '', '', '15-11-06-AA'),
(18, 15, 22, 1, 1, 1, 0, 1, '', '', '15-11-06-AA'),
(19, 16, 23, 12, 12, 1, 0, 0, '', '', ''),
(20, 17, 24, 1, 1, 1, 0, 0, '', '', 'AA001, AA002'),
(21, 17, 24, 25, 25, 25, 0, 0, '', '', 'AA001, AA002, AA003, AA004, AA005, AA006, AA007, AA008, AA009, AA010, AA011, AA012, AA013, AA014, AA015, AA016, AA017, AA018, AA019, AA020, AA021, AA022, AA023, AA024, AA025, AA026, AA027, AA028, AA029, AA030, AA031, AA032, AA033, AA034, AA035, AA036, AA037, AA038, AA039, AA040, AA041, AA042, AA043, AA044, AA045, AA046, AA047, AA048, AA049, AA050, AA051, AA052, AA053, AA054, AA055, AA056, AA057, AA058, AA059, AA060, AA061, AA062, AA063, AA064, AA065, AA066, AA067, AA068'),
(22, 18, 24, 111113333, 111113333, 111113333, 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `status`) VALUES
(11, 'Manager', 0),
(12, 'Accountant', 0),
(13, 'testZASXAassa', 0),
(14, 'TECHNICALANALYST', 0),
(15, 'QAANALYST', 0),
(16, 'QAMANAGER', 0),
(17, 'TESTLEAD', 0),
(18, 'Engineer', 0),
(19, 'TESTMEMBER', 0),
(20, 'JAVADEVELOPER', 0),
(21, 'DOTNETDEVELOPER', 0),
(22, 'APPLICATIONDEVELOPER', 0),
(23, 'HRMANAGER', 0),
(24, 'HREXECUTIVE', 0),
(25, 'Accountmanager', 0),
(26, 'hhhhh dggggggg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `uniqueid` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `wo_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `grn_id`, `itemid`, `uniqueid`, `status`, `wo_id`) VALUES
(3, 0, 1, 'AA001', 0, 163),
(4, 0, 1, 'AA002', 0, 159),
(5, 0, 1, 'AA003', 0, 160),
(6, 0, 1, 'AA004', 0, 161),
(7, 0, 1, 'AA005', 0, 162),
(8, 3, 1, 'AA006', 0, 0),
(9, 3, 1, 'AA007', 0, 0),
(10, 3, 1, 'AA008', 0, 0),
(11, 3, 1, 'AA009', 0, 0),
(12, 3, 1, 'AA010', 0, 0),
(13, 3, 1, 'AA011', 0, 0),
(14, 3, 1, 'AA012', 0, 0),
(15, 3, 1, 'AA013', 0, 0),
(16, 3, 1, 'AA014', 0, 0),
(17, 3, 1, 'AA015', 0, 0),
(18, 4, 1, 'AA006', 0, 0),
(19, 4, 1, 'AA007', 0, 0),
(20, 4, 1, 'AA008', 0, 0),
(21, 4, 1, 'AA009', 0, 0),
(22, 4, 1, 'AA010', 0, 0),
(23, 4, 1, 'AA011', 0, 0),
(24, 4, 1, 'AA012', 0, 0),
(25, 4, 1, 'AA013', 0, 0),
(26, 4, 1, 'AA014', 0, 0),
(27, 4, 1, 'AA015', 0, 0),
(29, 6, 3, '15-11-03-AA', 0, 0),
(34, 11, 17, 'AA001', 0, 0),
(37, 0, 18, '15-11-05-AA', 0, 166),
(38, 0, 17, 'AA002', 0, 167),
(39, 0, 18, '15-11-05-AB', 0, 164),
(40, 0, 17, 'AA003', 0, 165),
(41, 13, 20, 'AA001', 0, 0),
(42, 13, 20, 'AA001', 0, 0),
(43, 14, 21, '15-11-06-AA', 0, 0),
(44, 14, 21, '15-11-06-AA', 0, 0),
(45, 0, 20, 'AA002', 0, 246),
(46, 0, 20, 'AA003', 0, 265),
(47, 0, 20, 'AA004', 0, 245),
(48, 0, 20, 'AA005', 0, 304),
(49, 0, 20, 'AA006', 0, 244),
(50, 0, 20, 'AA007', 0, 278),
(51, 0, 20, 'AA008', 0, 243),
(52, 0, 20, 'AA009', 0, 243),
(53, 0, 20, 'AA010', 0, 250),
(54, 0, 20, 'AA011', 0, 267),
(55, 0, 20, 'AA012', 0, 242),
(56, 15, 22, '15-11-06-AA', 0, 0),
(57, 0, 1, 'AA016', 0, 380),
(58, 0, 13, 'AA001', 0, 324),
(59, 16, 23, '', 0, 0),
(60, 0, 13, 'AA002', 0, 433),
(61, 17, 24, 'AA001', 0, 0),
(62, 17, 24, 'AA002', 0, 0),
(63, 17, 24, 'AA001', 0, 0),
(64, 17, 24, 'AA002', 0, 0),
(65, 17, 24, 'AA003', 0, 0),
(66, 17, 24, 'AA004', 0, 0),
(67, 17, 24, 'AA005', 0, 0),
(68, 17, 24, 'AA006', 0, 0),
(69, 17, 24, 'AA007', 0, 0),
(70, 17, 24, 'AA008', 0, 0),
(71, 17, 24, 'AA009', 0, 0),
(72, 17, 24, 'AA010', 0, 0),
(73, 17, 24, 'AA011', 0, 0),
(74, 17, 24, 'AA012', 0, 0),
(75, 17, 24, 'AA013', 0, 0),
(76, 17, 24, 'AA014', 0, 0),
(77, 17, 24, 'AA015', 0, 0),
(78, 17, 24, 'AA016', 0, 0),
(79, 17, 24, 'AA017', 0, 0),
(80, 17, 24, 'AA018', 0, 0),
(81, 17, 24, 'AA019', 0, 0),
(82, 17, 24, 'AA020', 0, 0),
(83, 17, 24, 'AA021', 0, 0),
(84, 17, 24, 'AA022', 0, 0),
(85, 17, 24, 'AA023', 0, 0),
(86, 17, 24, 'AA024', 0, 0),
(87, 17, 24, 'AA025', 0, 0),
(88, 17, 24, 'AA026', 0, 0),
(89, 17, 24, 'AA027', 0, 0),
(90, 17, 24, 'AA028', 0, 0),
(91, 17, 24, 'AA029', 0, 0),
(92, 17, 24, 'AA030', 0, 0),
(93, 17, 24, 'AA031', 0, 0),
(94, 17, 24, 'AA032', 0, 0),
(95, 17, 24, 'AA033', 0, 0),
(96, 17, 24, 'AA034', 0, 0),
(97, 17, 24, 'AA035', 0, 0),
(98, 17, 24, 'AA036', 0, 0),
(99, 17, 24, 'AA037', 0, 0),
(100, 17, 24, 'AA038', 0, 0),
(101, 17, 24, 'AA039', 0, 0),
(102, 17, 24, 'AA040', 0, 0),
(103, 17, 24, 'AA041', 0, 0),
(104, 17, 24, 'AA042', 0, 0),
(105, 17, 24, 'AA043', 0, 0),
(106, 17, 24, 'AA044', 0, 0),
(107, 17, 24, 'AA045', 0, 0),
(108, 17, 24, 'AA046', 0, 0),
(109, 17, 24, 'AA047', 0, 0),
(110, 17, 24, 'AA048', 0, 0),
(111, 17, 24, 'AA049', 0, 0),
(112, 17, 24, 'AA050', 0, 0),
(113, 17, 24, 'AA051', 0, 0),
(114, 17, 24, 'AA052', 0, 0),
(115, 17, 24, 'AA053', 0, 0),
(116, 17, 24, 'AA054', 0, 0),
(117, 17, 24, 'AA055', 0, 0),
(118, 17, 24, 'AA056', 0, 0),
(119, 17, 24, 'AA057', 0, 0),
(120, 17, 24, 'AA058', 0, 0),
(121, 17, 24, 'AA059', 0, 0),
(122, 17, 24, 'AA060', 0, 0),
(123, 17, 24, 'AA061', 0, 0),
(124, 17, 24, 'AA062', 0, 0),
(125, 17, 24, 'AA063', 0, 0),
(126, 17, 24, 'AA064', 0, 0),
(127, 17, 24, 'AA065', 0, 0),
(128, 17, 24, 'AA066', 0, 0),
(129, 17, 24, 'AA067', 0, 0),
(130, 17, 24, 'AA068', 0, 0),
(131, 18, 24, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_available`
--

DROP TABLE IF EXISTS `item_available`;
CREATE TABLE IF NOT EXISTS `item_available` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `so_no` int(20) NOT NULL,
  `so_line_item` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `item_available`
--

INSERT INTO `item_available` (`id`, `item_id`, `so_no`, `so_line_item`) VALUES
(1, 2, 18, 15),
(2, 3, 24, 53);

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase`
--

DROP TABLE IF EXISTS `item_purchase`;
CREATE TABLE IF NOT EXISTS `item_purchase` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `so_no` int(20) NOT NULL,
  `so_line_item` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `item_purchase`
--

INSERT INTO `item_purchase` (`id`, `item_id`, `so_no`, `so_line_item`) VALUES
(1, 2, 18, 15),
(2, 2, 18, 47),
(3, 4, 24, 54);

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_no` varchar(20) NOT NULL,
  `material_desc` text NOT NULL,
  `uom` varchar(5) NOT NULL,
  `drawing_no` varchar(20) NOT NULL,
  `revision_no` varchar(20) NOT NULL,
  `material_status` varchar(5) NOT NULL,
  `upload` varchar(50) NOT NULL,
  `material_category` varchar(10) NOT NULL,
  `material_sub_category` varchar(10) NOT NULL,
  `material_type` varchar(10) NOT NULL,
  `design_base` varchar(10) NOT NULL,
  `mech_position` varchar(5) NOT NULL,
  `mech_finish` varchar(5) NOT NULL,
  `oem_name` varchar(20) NOT NULL,
  `oem_pdt_id` varchar(20) NOT NULL,
  `oem_pdt_desc` varchar(20) NOT NULL,
  `oem_lead_time` int(11) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `stock_handling` varchar(10) NOT NULL,
  `moving_price` varchar(50) NOT NULL,
  `manuf_cost` varchar(50) NOT NULL,
  `gen_price` varchar(50) NOT NULL,
  `mat_life` varchar(50) NOT NULL,
  `weight` int(11) NOT NULL,
  `addn_info` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_user` int(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `part_no`, `material_desc`, `uom`, `drawing_no`, `revision_no`, `material_status`, `upload`, `material_category`, `material_sub_category`, `material_type`, `design_base`, `mech_position`, `mech_finish`, `oem_name`, `oem_pdt_id`, `oem_pdt_desc`, `oem_lead_time`, `min_stock`, `stock_handling`, `moving_price`, `manuf_cost`, `gen_price`, `mat_life`, `weight`, `addn_info`, `status`, `created_date`, `created_user`, `updated_date`, `updated_user`) VALUES
(1, 'MRAM-A-00001-0100', 'test', '1', 'MRAM-00001', 'B', '23', 'MRAM-00001-B.jpg', 'M', '2', '4', 'A', '01', '00', '', '112', 'Test', 10, 200, 'Item', '', '', '', '150', 2, 'Material 1', 1, '2015-11-02 10:49:46', 5, '2015-11-02 23:19:08', 5),
(3, 'MADH-U-00003', '3M Sealant tape', '3', 'MADH-00003', 'B', '24', 'MADH-00003-B.jpg', 'M', '19', '10', 'U', '0', '0', 'Ashok Leyland', '4544', 'ujthr', 15, 50, 'Batch', '', '', '', '', 10, '', 1, '2015-11-02 07:38:07', 5, '2015-10-31 01:16:22', 5),
(5, '-A-00005-0100', 'polythene bag', '1', '-00005', 'A', '23', '-00005-A.jpg', 'M', '0', '4', 'A', '01', '00', '', '', '', 5, 1234, 'Item', '', '', '', '', 0, '', 1, '2015-11-12 06:20:23', 5, '2015-11-05 00:41:33', 5),
(13, 'CA-SoftwarePr-00006', 'pieces', '12', '', '', '29', '-A.jpg', 'C', '26', '19', 'SoftwarePr', '0', '0', '', '', '', 0, 123, 'Item', '', '', '', 'sample', 123, '', 1, '2015-11-02 10:07:19', 5, '2015-11-02 22:33:40', 5),
(14, 'MBRS-A-00014', 'Sample Material', '8', 'MBRS-00014', 'A', '0', '', 'M', '1', '4', 'A', '0', '0', '', '', '', 0, 0, 'Batch', '', '', '', '', 0, '', 1, '2015-11-05 12:43:34', 5, '0000-00-00 00:00:00', 0),
(15, 'CA-SoftwarePr-00015', 'Obsolete', '2', '', '', '37', '-A.jpg', 'C', '26', '18', 'SoftwarePr', '0', '0', '', '', '', 0, 0, 'Item', '', '', '', '', 0, '', 1, '2015-11-05 12:43:39', 5, '0000-00-00 00:00:00', 0),
(16, '-A-00016', 'fgfdg', '3', '-00016', 'A', '33', '', 'Q', '0', '19', 'A', '0', '0', '', '', '', 0, 0, 'Item', '', '', '', '', 0, '', 1, '2015-11-05 12:43:44', 5, '0000-00-00 00:00:00', 0),
(17, 'VSEL-selenium-00017', 'METER', '8', '', '', '38', '', 'V', '29', '20', 'selenium', '0', '0', 'QSPIDERS', '123', '2132', 2, 23, 'Item', '', '', '', '', 0, '', 1, '2015-11-05 09:48:05', 5, '2015-11-05 22:17:45', 5),
(18, 'VSEL-selenium-00018', 'crate', '4', '', '', '38', 'tc for email field.docx', 'V', '29', '20', 'selenium', '0', '0', '', '', '', 0, 0, 'Batch', '', '', '', '', 0, '', 1, '2015-11-05 12:43:49', 5, '2015-11-05 23:41:48', 5),
(19, 'MBRS-U-00019', '34', '1', '', '', '23', '', 'M', '1', '9', 'U', '0', '0', '', '', '', 0, 0, 'Item', '', '', '', '', 0, '', 1, '2015-11-12 06:20:25', 5, '0000-00-00 00:00:00', 0),
(20, 'IELE-AUTOCAD-00020', 'FOOT', '6', '', '', '39', 'Lighthouse.jpg', 'I', '30', '21', 'AUTOCAD', '0', '0', '', '', '', 0, 0, 'Item', '', '', '', '', 0, '', 1, '2015-11-06 05:27:24', 5, '2015-11-06 17:56:11', 5),
(21, 'IELE-AUTOCAD-00021', 'Grams sample', '19', '', '', '39', '', 'I', '30', '21', 'AUTOCAD', '0', '0', '', '', '', 0, 0, 'Batch', '', '', '', '', 500, '', 1, '2015-11-06 06:26:07', 5, '2015-11-06 18:55:57', 5),
(22, 'VSEL-selenium-00022', 'sample', '3', '', '', '39', '', 'V', '29', '20', 'selenium', '0', '0', '', '', '', 0, 0, 'Batch', '', '', '', '', 0, '', 1, '2015-11-06 07:18:46', 5, '0000-00-00 00:00:00', 0),
(23, 'MBRS-A-00023-0000', '', '1', 'MBRS-00023', 'A', '23', '', 'M', '1', '4', 'A', '00', '00', 'swift plm', '', '', 0, 12, 'Batch', '', '', '', '', 222, '', 1, '2015-11-06 09:35:50', 5, '0000-00-00 00:00:00', 0),
(24, 'VSEL-PRAVINKUMA-0002', 'package123package123package123package123package123package123package123package123package123package123', '3', '', '', '43', '', 'V', '29', '22', 'PRAVINKUMA', '0', '0', 'PRAVINKUMA CHERMAKAN', '12', '212', 0, 12, 'Item', '', '', '', '12', 12121, '12', 1, '2015-11-12 07:45:35', 5, '2015-11-12 20:15:27', 5),
(25, 'IELE-AUTOCAD-0002', 'new materaial update', '14', '', '', '39', 'Requirements revision summary.xlsx', 'I', '30', '22', 'AUTOCAD', '0', '0', 'PRAVINKUMA CHERMAKAN', '1', '1', 12, 1, 'Item', '', '', '', '', 0, '', 1, '2015-11-12 10:06:47', 5, '2015-11-12 22:36:13', 5);

-- --------------------------------------------------------

--
-- Table structure for table `materialgroup`
--

DROP TABLE IF EXISTS `materialgroup`;
CREATE TABLE IF NOT EXISTS `materialgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `group_char` varchar(20) NOT NULL,
  `group_comp` varchar(20) NOT NULL,
  `group_comp_char` varchar(20) NOT NULL,
  `group_desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `materialgroup`
--

INSERT INTO `materialgroup` (`id`, `category`, `group_char`, `group_comp`, `group_comp_char`, `group_desc`, `status`, `date`) VALUES
(1, 'M', 'M', 'Brush', 'MBRS', 'Brushes5', 1, '2015-09-08 06:44:02'),
(2, 'M', 'M', 'Ram', 'MRAM', 'Sample', 1, '2015-09-08 06:43:56'),
(3, 'E', 'E', 'Diode', 'DIOM', 'Electric Diode', 1, '2015-08-19 06:21:27'),
(4, 'M', 'M', 'Tyre', 'MTYR', 'Test', 1, '2015-09-08 06:43:49'),
(5, 'E', 'E', 'Switch', 'ESWT', '', 1, '2015-08-25 11:34:55'),
(6, 'M', 'M', 'Assembly', 'MASM', 'Assembly', 1, '2015-08-25 12:19:57'),
(7, 'E', 'E', 'Test', 'ETST', 'Test', 1, '2015-09-08 06:43:42'),
(8, 'M', 'M', 'Sample', 'MSMP', 'Test Data', 1, '2015-09-08 06:43:36'),
(9, 'EC', 'EC', 'Capacitor', 'C', 'Capacitor 10um', 0, '2015-10-26 08:02:25'),
(10, 'M', 'M', 'Master', 'MMST', 'Materialss', 1, '2015-09-08 06:43:29'),
(11, 'EC', 'EC', 'Inductance', 'I', 'Inductance', 0, '2015-11-12 19:31:17'),
(12, 'M', 'M', 'Fastener', 'MFAS', '', 0, '2015-10-06 05:18:39'),
(13, 'E', 'E', 'Cables', 'ECAB', '', 1, '2015-10-23 09:33:46'),
(14, 'E', 'E', 'Ram', 'ETFF', 'Test', 1, '2015-10-23 09:33:47'),
(15, 'E', 'E', 'RMA', 'EGHH', 'dfgdfg', 1, '2015-11-04 05:09:52'),
(16, 'E', 'E', 'Murali', 'EMUL', 'Murali Stml', 0, '2015-10-26 08:02:27'),
(17, 'M', 'M', 'System', 'MSDS', 'sdfsdf', 0, '2015-10-06 05:18:38'),
(18, 'A', 'A', 'Arjun', 'ABBB', 'ASSS', 1, '2015-10-06 05:12:34'),
(19, 'M', 'M', 'Adhesive', 'MADH', 'All bonding & sealing materials', 1, '2015-10-20 12:43:34'),
(20, 'M', 'M', 'mngbvnvnbvbvnnnbbbbb', 'MVFD', 'hmn56646', 0, '2015-10-23 20:58:28'),
(21, 'E', 'E', 'bvnf', 'EGFG', 'hfghfgh', 0, '2015-10-23 21:03:54'),
(22, 'M', 'M', 'today', 'MTTT', 'gdfgfd', 0, '2015-10-30 17:47:10'),
(23, 'EC', 'EC', 'chip', 'ECCCC', 'zsfgdfgdfhd', 0, '2015-11-02 18:40:23'),
(24, 'T', 'T', 'test', 'TY', '', 0, '2015-11-02 20:10:04'),
(25, 'T', 'T', 'qa', 'TQA', 'qa', 1, '2015-11-02 07:49:57'),
(26, 'H', 'H', '1234567890', '123', '', 0, '2015-11-12 19:17:36'),
(27, 'C', 'C', 'qwerty', 'CQWE', 'qwerty', 0, '2015-11-04 23:35:28'),
(28, 'Q', 'Q', 'qwerty', 'QCCC', 'was', 0, '2015-11-04 23:36:33'),
(29, 'V', 'V', 'Automation', 'VSEL', 'Selenium', 1, '2015-11-05 09:39:44'),
(30, 'I', 'I', 'ELECTROMECHANICAL', 'IELE', 'CARRIER TO CUSTOMER', 1, '2015-11-06 05:01:42'),
(31, 'O', 'O', '1234567890', 'O123', '1234567890', 0, '2015-11-12 19:17:55'),
(32, 'M', 'M', '1234567890', 'M123', '1234567890', 0, '2015-11-12 19:18:08'),
(33, '1', '1', '1234567890', '1123', 'TRRTR', 0, '2015-11-12 19:18:31'),
(34, 'E', 'E', 'SD', 'WSD', 'GHG', 0, '2015-11-12 19:22:43'),
(35, 'Q', 'Q', 'PRAVINKUMARCHERMAKAN', '1PRA', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAN', 1, '2015-11-12 06:57:08'),
(36, 'I', 'I', 'WE', 'DWEW', 'WQEWQEWQEWQ', 0, '2015-11-12 19:29:14'),
(37, 'C', 'C', 'chip', 'CW', '', 0, '2015-11-12 19:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `materialgroupcategory`
--

DROP TABLE IF EXISTS `materialgroupcategory`;
CREATE TABLE IF NOT EXISTS `materialgroupcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `charac` text NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `materialgroupcategory`
--

INSERT INTO `materialgroupcategory` (`id`, `category`, `charac`, `status`, `date`) VALUES
(1, 'Mechanical', 'M', 1, '2015-08-18 06:51:50'),
(2, 'Electrical', 'E', 1, '2015-09-01 12:42:04'),
(3, 'Electronics', 'EC', 1, '2015-08-31 09:22:50'),
(4, 'Ram', 'R', 0, '0000-00-00 00:00:00'),
(5, 'Major Assembly', 'A', 1, '0000-00-00 00:00:00'),
(6, 'mobile', 'S', 1, '0000-00-00 00:00:00'),
(7, 'Testing', 'T', 1, '0000-00-00 00:00:00'),
(8, 'Pallet', 'P', 1, '0000-00-00 00:00:00'),
(9, 'Clematix', 'C', 1, '0000-00-00 00:00:00'),
(10, 'sample', 'Q', 1, '0000-00-00 00:00:00'),
(11, 'Selenium', 'V', 1, '0000-00-00 00:00:00'),
(12, 'ROBOTICS', 'I', 1, '0000-00-00 00:00:00'),
(13, 'PRAVINKUMARCHERMAKAN', 'H', 1, '0000-00-00 00:00:00'),
(14, 'PRAVINKUMARCHERMAKAN', 'O', 1, '0000-00-00 00:00:00'),
(15, '12345678901234567890', '1', 1, '0000-00-00 00:00:00'),
(16, 'ABC', 'W', 1, '0000-00-00 00:00:00'),
(17, '121', 'D', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `materialstatus`
--

DROP TABLE IF EXISTS `materialstatus`;
CREATE TABLE IF NOT EXISTS `materialstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `charac` varchar(20) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `materialstatus`
--

INSERT INTO `materialstatus` (`id`, `name`, `charac`, `desc`, `status`) VALUES
(23, 'Baseline', 'BS', '', 1),
(24, 'Production', 'Prod', 'All materials used in serial production', 0),
(26, 'Any material status ', 'Any material status ', 'Any material status change from R&D to any other', 1),
(28, 'material', 'material', '', 1),
(29, 'STATUS', 'STATUS', 'STATUS', 0),
(30, 'CHANGE', 'CHANGE', '', 1),
(31, 'REGULAR', 'REGUALR', '', 0),
(32, 'r&d', 'r&d', '', 0),
(33, 'OTHERS', 'OTHERS', '', 0),
(34, 'Processing MATERIAL', 'Processing MATERIAL', '', 0),
(35, 'asdasfdasd', 'asdasdas', 'dasdasdasdasd', 1),
(37, 'Obsolete', 'Obsolete', 'Obsolete', 0),
(38, 'Selenium', 'Selenium', 'Selenium', 0),
(39, 'CARRIER', 'CARRIER TO CUSTOMER', 'CARRIER TO CUSTOMER', 1),
(40, 'SD', 'WQE', '', 0),
(41, 'GFHG', 'GHFGH', '', 1),
(42, 'MATERIAL STATUS LIST', 'MATERIAL STATUS LIST', 'MATERIAL STATUS LISTMATERIAL STATUS LISTMATERIAL STATUS LISTMATERIAL STATUS LISTMATERIAL STATUS LIST', 1),
(43, 'PRAVINKUMARCHERMAKAN', 'PRAVINKUMARCHERMAKAN', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `materialtype`
--

DROP TABLE IF EXISTS `materialtype`;
CREATE TABLE IF NOT EXISTS `materialtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `bom_val` varchar(5) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `materialtype`
--

INSERT INTO `materialtype` (`id`, `type`, `code`, `desc`, `bom_val`, `status`, `date`) VALUES
(3, 'General Consumable', 'V2', 'Ram', 'Yes', 0, '2015-09-28 06:59:58'),
(4, 'SFG', '1', 'gg', 'Yes', 1, '0000-00-00 00:00:00'),
(5, 'Raw Material', 'RM', '', 'Yes', 1, '2015-09-28 06:59:55'),
(8, 'Process Consumable', 'PCon', 'Product usable', 'Yes', 0, '2015-09-28 06:59:50'),
(9, 'Test Ram', 'A', 'Ram', 'Yes', 1, '0000-00-00 00:00:00'),
(10, 'General Cons', 'GCon', 'All consumables', 'No', 1, '0000-00-00 00:00:00'),
(12, 'fghfgh', 'fghgf', 'hfghfgh', 'Yes', 1, '0000-00-00 00:00:00'),
(13, 'jghjghj', 'ghjghj', 'ghjghj', 'No', 1, '0000-00-00 00:00:00'),
(14, 'ghjg', 'jghjhgj', 'ghjghj', 'Yes', 1, '0000-00-00 00:00:00'),
(15, 'dfgfd', 'gfdgdf', 'gdfgfdg', 'Yes', 1, '0000-00-00 00:00:00'),
(16, 'rgf', 'kjk', 'kjhk', 'No', 1, '0000-00-00 00:00:00'),
(18, 'testing', 'testing', 'testing', 'No', 1, '0000-00-00 00:00:00'),
(19, 'SoftwareProducts', 'SoftwareProducts', 'SoftwareProSoftwareProductsSoftwareProductsSoftwar', 'Yes', 1, '0000-00-00 00:00:00'),
(20, 'Automation', 'Automation', 'Automation', 'Yes', 1, '0000-00-00 00:00:00'),
(21, 'GLASS', 'glassdoor', 'glass', 'Yes', 1, '0000-00-00 00:00:00'),
(22, 'PRAVINKUMARPRAVINKUM', 'PRAVINKUMARPRAVINKUM', 'test', 'No', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `material_vendordetails`
--

DROP TABLE IF EXISTS `material_vendordetails`;
CREATE TABLE IF NOT EXISTS `material_vendordetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `vendor` int(11) NOT NULL,
  `vendor_pdt_id` varchar(20) NOT NULL,
  `vendor_pdt_desc` varchar(20) NOT NULL,
  `lead_time` int(11) NOT NULL,
  `vendoruom` varchar(10) NOT NULL,
  `list_price` varchar(20) NOT NULL,
  `moq` int(11) NOT NULL,
  `conv_vend_basic` varchar(10) NOT NULL,
  `conv_vend` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `material_vendordetails`
--

INSERT INTO `material_vendordetails` (`id`, `material_id`, `vendor`, `vendor_pdt_id`, `vendor_pdt_desc`, `lead_time`, `vendoruom`, `list_price`, `moq`, `conv_vend_basic`, `conv_vend`) VALUES
(1, 1, 0, '112', 'Test', 10, '1', '15', 100, '1', '1'),
(2, 1, 0, '', 'TestB', 10, '1', '14', 100, '1', '1'),
(3, 2, 1, '211', 'BA', 15, '2', '10', 100, '1', '1'),
(4, 2, 3, '222', 'BB', 10, '1', '10', 100, '1', '2'),
(5, 3, 0, '4544', 'ujthr', 15, '3', '657', 2, '2', '2'),
(6, 3, 0, '545', 'fghfgh', 65, '10', '676', 4, '', ''),
(7, 4, 0, '', '', 0, '', '', 0, '', ''),
(8, 4, 0, '', '', 0, '', '', 0, '', ''),
(9, 5, 0, '', '', 5, '1', '12', 12, '1', '1'),
(10, 5, 0, '', '', 0, '', '', 0, '', ''),
(11, 6, 0, '', '', 0, '', '', 0, '', ''),
(12, 6, 0, '', '', 0, '', '', 0, '', ''),
(13, 7, 0, '', '', 0, '', '', 0, '', ''),
(14, 7, 0, '', '', 0, '', '', 0, '', ''),
(15, 8, 0, '', '', 0, '', '', 0, '', ''),
(16, 8, 0, '', '', 0, '', '', 0, '', ''),
(17, 9, 0, '', '', 0, '', '', 0, '', ''),
(18, 9, 0, '', '', 0, '', '', 0, '', ''),
(19, 10, 0, '', '', 0, '', '', 0, '', ''),
(20, 10, 0, '', '', 0, '', '', 0, '', ''),
(21, 11, 0, '', '', 0, '', '', 0, '', ''),
(22, 11, 0, '', '', 0, '', '', 0, '', ''),
(23, 12, 0, '', '', 0, '', '', 0, '', ''),
(24, 12, 0, '', '', 0, '', '', 0, '', ''),
(25, 13, 1, '1', 'sample', 1, '13', '1', 1, '1', '1'),
(26, 13, 0, '', '', 0, '', '', 0, '', ''),
(27, 14, 8, '', '', 0, '1', '', 0, '1', '1'),
(28, 14, 0, '', '', 0, '', '', 0, '', ''),
(29, 15, 4, '', '', 0, '2', '', 0, '1', '1'),
(30, 15, 0, '', '', 0, '', '', 0, '', ''),
(31, 16, 0, '', '', 0, '', '', 0, '', ''),
(32, 16, 0, '', '', 0, '', '', 0, '', ''),
(33, 17, 10, '123', '2132', 2, '8', '', 0, '1', '1'),
(34, 17, 0, '', '', 0, '', '', 0, '', ''),
(35, 18, 10, '', '', 0, '5', '', 0, '8', '8'),
(36, 18, 0, '', '', 0, '', '', 0, '', ''),
(37, 19, 10, '', '', 1, '19', '', 0, '1', '1'),
(38, 19, 0, '', '', 0, '', '', 0, '', ''),
(39, 20, 11, '', '', 0, '6', '', 0, '1', '1'),
(40, 20, 11, '', '', 0, '14', '', 0, '8', '9'),
(41, 21, 11, '', '', 0, '1', '', 0, '5', '3'),
(42, 21, 0, '', '', 0, '', '', 0, '', ''),
(43, 22, 11, '', '', 0, '19', '12', 12, '12', '12'),
(44, 22, 0, '', '', 0, '', '', 0, '', ''),
(45, 23, 12, '', '', 0, '19', '1', 0, '2', '1'),
(46, 23, 0, '', '', 0, '', '', 0, '', ''),
(47, 24, 16, '12', '212', 0, '19', '12', 21, '33', '12'),
(48, 24, 0, '', '', 0, '', '', 0, '', ''),
(49, 25, 16, '1', '1', 12, '13', '', 0, '1', '165'),
(50, 25, 0, '', '', 0, '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `descr`, `code`, `desc`, `status`, `date`) VALUES
(1, 'No Dual', '00', '', 1, '2015-08-28 10:29:12'),
(2, 'LH', '01', '', 1, '2015-09-07 10:46:59'),
(3, 'RH', '02', '', 1, '2015-09-07 10:47:04'),
(4, 'Ram', '03', 'Ram', 1, '2015-09-07 10:47:08'),
(5, 'Kumar', '04', 'KUMS', 1, '0000-00-00 00:00:00'),
(6, 'New', '05', 'Value', 1, '0000-00-00 00:00:00'),
(7, 'sdfsdf', '06', 'sdfsdf', 1, '0000-00-00 00:00:00'),
(8, 'testengg', '07', 'testing', 1, '0000-00-00 00:00:00'),
(9, 'were', '08', 'qwerty', 1, '0000-00-00 00:00:00'),
(10, 'iosdeveloper', '09', '', 1, '0000-00-00 00:00:00'),
(11, 'Selenium', '10', 'Selenium', 1, '0000-00-00 00:00:00'),
(12, 'PRAVINKUMARPRAVINKUM', '11', 'PRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVIN', 1, '0000-00-00 00:00:00'),
(13, 'PRAVINKUMARPRAVINKUM', '12', 'PRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVINKUMARPRAVIN', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_code` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_code` (`project_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_code`, `status`) VALUES
(9, 'Proj A', 'AA', 1),
(10, 'Test', 'AB', 1),
(12, 'Clematix', 'AC', 0),
(13, 'sdfdfsfsdfsdf', 'AD', 0),
(14, 'test', 'AE', 0),
(15, 'trgyrty', 'AF', 0),
(16, 'MOTORS', 'AG', 0),
(17, 'INTERGRATED DATA TRANSMISSION SYSTEMS', 'AH', 0),
(18, '          ', 'AI', 0),
(19, 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKAPRAVINKUMARCHERMAKANPRAVINKUMARC', 'AJ', 0),
(20, 'pk', 'AK', 0),
(21, 'Selene', 'AL', 0),
(22, 'Selenewew', 'AM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `so_no` varchar(100) NOT NULL,
  `customer_po` varchar(100) NOT NULL,
  `invoice_date` varchar(150) NOT NULL,
  `supplier` varchar(150) NOT NULL,
  `customer` int(20) NOT NULL,
  `shipping_method` int(20) NOT NULL,
  `status` int(10) NOT NULL,
  `shipping_charges` varchar(100) NOT NULL,
  `vat` varchar(100) NOT NULL,
  `cst` varchar(100) NOT NULL,
  `service_tax` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `so_no`, `customer_po`, `invoice_date`, `supplier`, `customer`, `shipping_method`, `status`, `shipping_charges`, `vat`, `cst`, `service_tax`) VALUES
(26, '2015/0025', 'FFFRR', '28/10/2015', 'Asteria', 6, 13, 1, '86', '7', '6', '9'),
(27, '2015/0022', '90', '05/11/2015', 'Asteria', 5, 13, 1, '2', '2', '2', '22'),
(28, '2015/0024', '1234', '05/11/2015', 'Asteria', 6, 18, 1, '23', '23', '23', '23'),
(29, '2015/0027', '98', '05/11/2015', 'Asteria', 7, 17, 1, '1', '1', '1', '1'),
(30, '2015/0029', '123', '05/11/2015', 'Asteria', 6, 13, 1, '34', '324', '34', '24'),
(31, '2015/0031', '12', '06/11/2015', 'Asteria', 10, 19, 1, '23', '13', '23', '213'),
(32, '2015/0033', '77', '06/11/2015', 'Asteria', 10, 17, 1, '7', '8', '7', '9'),
(33, '2015/0035', '890', '06/11/2015', 'Asteria', 8, 18, 1, '23', '324', '23', '22'),
(34, '2015/0037', 'pk123', '06/11/2015', 'Asteria', 10, 19, 1, '2', '22', '2', '1'),
(35, '2015/0039', '55', '06/11/2015', 'Asteria', 10, 16, 1, '1', '1', '1', '1'),
(38, '2015/0043', '34', '06/11/2015', 'Asteria', 8, 13, 1, '3', '324', '3', '3'),
(40, '2015/0046', '7890', '06/11/2015', 'Asteria', 8, 16, 1, '12', '12', '12', '12'),
(41, '2015/0048', 'q', '11/11/2015', 'Asteria', 8, 16, 1, '', '', '', ''),
(42, '2015/0051', 'PRAVINKUMARCHERMAKAN', '12/11/2015', 'Asteria', 10, 17, 1, '', '', '', ''),
(43, '2015/0053', 'VSEL-PRAVINKUMA-0002', '12/11/2015', 'Asteria', 11, 25, 1, '', '', '', ''),
(44, '2015/0055', '111113333', '12/11/2015', 'Asteria', 11, 23, 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `sales_lineitem`
--

DROP TABLE IF EXISTS `sales_lineitem`;
CREATE TABLE IF NOT EXISTS `sales_lineitem` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_code` int(50) NOT NULL,
  `qty` int(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `unit_price` varchar(150) NOT NULL,
  `sales_id` int(50) NOT NULL,
  `project_id` int(20) NOT NULL,
  `status` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `sales_lineitem`
--

INSERT INTO `sales_lineitem` (`id`, `item_code`, `qty`, `currency`, `unit_price`, `sales_id`, `project_id`, `status`) VALUES
(58, 1, 5, '', '9999999999', 26, 12, 1),
(59, 3, 8, '', '6666', 26, 10, 0),
(60, 16, 7, '', '7', 27, 9, 0),
(61, 17, 12, '', '12', 28, 12, 0),
(62, 18, 1, '', '9', 29, 12, 1),
(63, 18, 1, '', '3', 30, 10, 1),
(64, 20, 1, '', '1', 31, 17, 0),
(65, 3, 5, '', '7', 32, 9, 0),
(66, 21, 12, '', '4', 33, 17, 1),
(67, 21, 4, '', '5', 33, 17, 1),
(68, 17, 1, '', '1', 34, 16, 0),
(69, 13, 20, '', '22', 35, 17, 1),
(72, 3, 4, '', '3', 38, 10, 0),
(74, 13, 11, '', '12', 40, 10, 1),
(75, 23, 2, '', '2.55', 41, 10, 0),
(77, 24, 87, '', '78', 42, 19, 0),
(78, 24, 111113333, '', '999992.33', 43, 19, 0),
(79, 24, 111113333, '', '111113333', 44, 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

DROP TABLE IF EXISTS `shipping_method`;
CREATE TABLE IF NOT EXISTS `shipping_method` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`id`, `name`, `description`, `status`) VALUES
(16, 'UPS', 'UPS A/C # 0000F528A', '1'),
(17, 'yusenlogistics', 'yusenlogistics', '1'),
(20, 'dfd', 'mnm,nlndflnglkreoghrhogm. ', '1'),
(21, 'PRAVINKUMARCH', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKANPRAVINKUMA', '1'),
(22, 'PRAVINKUMar', 'PRAVINKUMARCHERMAKAN', '1'),
(23, 'PRAVIN', 'PRAVINKUMARCHERMAKAN', '1'),
(24, 'qwerty', 'qwerty', '1'),
(25, 'qwerty keyboard', 'qwerty', '1');

-- --------------------------------------------------------

--
-- Table structure for table `so_closed`
--

DROP TABLE IF EXISTS `so_closed`;
CREATE TABLE IF NOT EXISTS `so_closed` (
  `id` int(50) NOT NULL,
  `so_id` int(50) NOT NULL,
  `so_line` int(50) NOT NULL,
  `inventory_id` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

DROP TABLE IF EXISTS `uom`;
CREATE TABLE IF NOT EXISTS `uom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uom` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `uom`
--

INSERT INTO `uom` (`id`, `uom`, `code`) VALUES
(1, 'Bag', 'BG'),
(2, 'Box', 'BOX'),
(3, 'Centimeter', 'CM'),
(4, 'Crate', 'CR'),
(5, 'Dozen', 'DOZ'),
(6, 'Foot', 'FT'),
(7, 'Kilograms', 'KGS'),
(8, 'Meter', 'M'),
(9, 'Package', 'PK'),
(10, 'Packet', 'PA'),
(11, 'Pallet', 'PAL'),
(12, 'Pieces', 'PCS'),
(13, 'Tube', 'TU'),
(14, 'Yard', 'YD'),
(15, 'Milliliters', 'ML'),
(18, 'Millimeters', 'MM'),
(19, 'Grams', 'G');

-- --------------------------------------------------------

--
-- Table structure for table `utilies`
--

DROP TABLE IF EXISTS `utilies`;
CREATE TABLE IF NOT EXISTS `utilies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `utilies`
--

INSERT INTO `utilies` (`id`, `name`, `content`) VALUES
(1, 'shipping_address', 'Asteria Aerospace Private Limited\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\nBangalore, Karnataka, 560008\nTel: +91 80 40955058'),
(2, 'vendorpo', '2015/0029'),
(3, 'grn', '2015/0016'),
(4, 'so_serial', '2015/0055'),
(5, 'wo_serial', '2015/00403');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(20) NOT NULL,
  `vendor_address` varchar(120) NOT NULL,
  `vendor_country` varchar(20) NOT NULL,
  `contact_person` varchar(20) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `pan_no` varchar(25) NOT NULL,
  `tin_no` varchar(25) NOT NULL,
  `vat_no` varchar(25) NOT NULL,
  `cst_no` varchar(25) NOT NULL,
  `st_no` varchar(25) NOT NULL,
  `bank_name` varchar(25) NOT NULL,
  `acc_name` varchar(25) NOT NULL,
  `bank_acc_no` varchar(25) NOT NULL,
  `bank_branch` varchar(25) NOT NULL,
  `bank_ifsc` varchar(25) NOT NULL,
  `mfg_code` varchar(25) NOT NULL,
  `vendor_category` varchar(20) NOT NULL,
  `status` int(25) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`, `vendor_address`, `vendor_country`, `contact_person`, `contact_phone`, `contact_email`, `pan_no`, `tin_no`, `vat_no`, `cst_no`, `st_no`, `bank_name`, `acc_name`, `bank_acc_no`, `bank_branch`, `bank_ifsc`, `mfg_code`, `vendor_category`, `status`, `date`) VALUES
(16, 'PRAVINKUMA CHERMAKAN', 'PRAVINKUMARCHERMAKAN\r\nPRAVINKUMARCHERMAKAN\r\nPRAVINKUMARCHERMAKAN\r\nPRAVINKUMARCHERMAKAN\r\nPRAVINKUMARCHERMAKAN', '17', 'PRAVINKUMARCHERMAKAN', '343243', 'PRAVINKUMARCHERMAKANPRAVINKUMARCHERMAKA@gmail.com', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'PRAVINKUMARCHERMAKANPRAVI', 'qwq', 'NotA', 1, '2015-11-12 07:40:39');

-- --------------------------------------------------------

--
-- Table structure for table `vendorpo`
--

DROP TABLE IF EXISTS `vendorpo`;
CREATE TABLE IF NOT EXISTS `vendorpo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` int(11) NOT NULL,
  `vendor_po` varchar(20) NOT NULL,
  `department` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping` int(11) NOT NULL,
  `delivery_date` varchar(20) NOT NULL,
  `quote` varchar(25) NOT NULL,
  `total_amt` varchar(25) NOT NULL,
  `shipping_charge` varchar(25) NOT NULL,
  `vat_charge` varchar(25) NOT NULL,
  `cst_charge` varchar(25) NOT NULL,
  `st_charge` varchar(25) NOT NULL,
  `addn_req` text NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `vendorpo`
--

INSERT INTO `vendorpo` (`id`, `vendor_name`, `vendor_po`, `department`, `shipping_address`, `shipping`, `delivery_date`, `quote`, `total_amt`, `shipping_charge`, `vat_charge`, `cst_charge`, `st_charge`, `addn_req`, `status`, `date`) VALUES
(1, 1, '2015/0007', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '16-10-2015', 'PO 1', '0', '10', '10', '10', '10', 'PO 1', 0, '2015-11-04 01:26:45'),
(2, 1, '2015/0008', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 16, '27-10-2015', 'PO 2', '15000', '10', '10', '10', '10', 'PO 2', 1, '2015-10-19 10:32:19'),
(3, 4, '2015/0009', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 16, '19-10-2015', 'fddfgfd', '24200', '5', '', '', '', '', 1, '2015-10-23 13:44:01'),
(4, 3, '2015/0010', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '30-10-2015', 'fddfgfd', '100', '1', '1', '2', '0', '', 1, '2015-10-23 13:44:00'),
(5, 3, '2015/0011', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '29-10-2015', 'xcvcxvx', '1133', '4', '34', '4', '4', 'dgfgfdg', 1, '2015-10-23 12:23:18'),
(6, 9, '2015/0012', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 17, '03-11-2015', '12', '', '', '', '', '', '', 0, '2015-11-03 19:39:03'),
(7, 1, '2015/0013', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 17, '03-11-2015', '@#$%', '', '', '', '', '', '', 0, '2015-11-03 21:05:16'),
(8, 1, '2015/0014', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 17, '03-11-2015', '$^$^', '', '1', '1', '11', '1', 'fgfdg', 0, '2015-11-03 21:09:33'),
(9, 1, '2015/0015', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '03-11-2015', '90', 'NaN', '', '', '', '', '', 0, '2015-11-03 23:38:59'),
(10, 1, '2015/0016', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '03-11-2015', '123A444', '1500', '10', '10', '10', '10', '10010', 0, '2015-11-03 23:18:17'),
(11, 1, '2015/0017', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 17, '03-11-2015', '22', '0', '', '', '', '', '', 0, '2015-11-03 23:37:59'),
(12, 1, '2015/0018', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '03-11-2015', 'po', '0', '', '', '', '', '', 0, '2015-11-03 23:54:43'),
(13, 1, '2015/0019', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '05-11-2015', 'ere', '1', '', '', '', '', '', 0, '2015-11-05 17:30:18'),
(14, 1, '2015/0020', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 18, '05-11-2015', '9', '9', '', '', '', '', '', 0, '2015-11-05 17:31:18'),
(15, 10, '2015/0021', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 18, '05-11-2015', '123', '225', '', '', '', '', '', 1, '2015-11-05 09:50:22'),
(16, 10, '2015/0022', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 18, '10-11-2015', '22', '1', '', '', '', '', '', 1, '2015-11-05 11:56:31'),
(17, 11, '2015/0023', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 19, '06-11-2015', '12', '27', '', '', '', '', '', 1, '2015-11-06 05:32:09'),
(18, 11, '2015/0024', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 19, '06-11-2015', '23', '1325', '12', '1', '1', '1', 'sample', 1, '2015-11-06 06:35:53'),
(19, 11, '2015/0025', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 19, '06-11-2015', '54', '1', '6464544', '43434', '324324', '32424', '', 1, '2015-11-06 07:21:05'),
(20, 12, '2015/0028', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 16, '06/11/2015', '900', '144', '1', '1', '11', '1', '', 0, '2015-11-07 00:17:17'),
(21, 12, '2015/0026', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 19, '365356356', '     4543545', '144', '', '', '', '', '', 1, '2015-11-06 09:42:23'),
(22, 10, '2015/0027', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '19-11-2015', '8', '1', '1', '1', '1', '1', '', 0, '2015-11-06 23:26:27'),
(23, 16, '2015/0028', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 16, '12/11/2015', 'package123package123packa', '100.5', '', '', '', '', '', 1, '2015-11-12 07:55:08'),
(24, 16, '2015/0029', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 25, '12/11/2015', '111113333', '108779953007', '', '', '', '', '', 1, '2015-11-12 09:43:11');

-- --------------------------------------------------------

--
-- Table structure for table `vendorpo_materials`
--

DROP TABLE IF EXISTS `vendorpo_materials`;
CREATE TABLE IF NOT EXISTS `vendorpo_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendorpo_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `pdtid` varchar(25) NOT NULL,
  `desc` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  `uom` varchar(20) NOT NULL,
  `price` varchar(25) NOT NULL,
  `linetotal` varchar(25) NOT NULL,
  `pending` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `vendorpo_materials`
--

INSERT INTO `vendorpo_materials` (`id`, `vendorpo_id`, `item`, `pdtid`, `desc`, `qty`, `uom`, `price`, `linetotal`, `pending`) VALUES
(3, 2, 1, '111', 'Test', 1000, 'Bag', '5', '5000', 988),
(4, 2, 2, '211', 'BA', 2000, 'Box', '5', '10000', 2000),
(6, 5, 1, '111', 'Test', 11, 'Bag', '22', '242', 1),
(7, 5, 2, '211', 'BA', 99, 'Box', '9', '891', 99),
(9, 3, 3, '', '', 440, '', '55', '24200', 40),
(10, 4, 1, '', '', 10, '', '10', '100', 10),
(11, 4, 1, '', '', 0, '', '111', '0', 0),
(13, 8, 13, '', '', 0, '', '0.12', '', 0),
(21, 10, 13, '1', 'sample', 100, 'Tube', '10', '1000', 100),
(22, 10, 13, '1', 'sample', 50, 'Tube', '10', '500', 50),
(25, 9, 13, '', '', 1, '', '1', '1', 1),
(26, 9, 13, '', '', 12, '', '12', '144', 12),
(27, 9, 13, '', '', 1, '', '1', '1', 1),
(29, 13, 13, '1', 'sample', 1, 'Tube', '1', '1', 1),
(30, 14, 13, '1', 'sample', 9, 'Tube', '1', '9', 9),
(31, 15, 17, '123', '2132', 12, 'Meter', '12', '144', 0),
(32, 15, 17, '123', '2132', 9, 'Meter', '9', '81', 0),
(33, 16, 18, '', '', 1, '', '1', '1', 1),
(34, 17, 20, 'IELE-AUTOCAD-00020', 'FOOT', 1, 'Foot', '9', '9', 1),
(35, 17, 20, 'IELE-AUTOCAD-00020', 'FOOT', 2, 'Foot', '09', '18', 1),
(36, 18, 21, 'IELE-AUTOCAD-00021', 'Grams sample', 100, 'Bag', '12', '1200', 30),
(37, 18, 21, 'IELE-AUTOCAD-00021', 'Grams sample', 50, 'Bag', '2.5', '125', 30),
(38, 19, 22, 'VSEL-selenium-00022', 'sample', 1, 'Grams', '1', '1', 0),
(40, 21, 23, 'MBRS-A-00023-0000', '', 12, 'Grams', '12', '144', 11),
(43, 22, 18, '', '', 1, '', '1', '1', 1),
(45, 20, 23, '', '', 12, '', '12', '144', 12),
(46, 23, 24, '12', '212', 1, 'Grams', '0.5', '0.5', 0),
(47, 23, 24, '12', '212', 25, 'Grams', '4', '100', 0),
(48, 24, 24, '12', '212', 111113333, 'Grams', '979', '108779953007', 0);

-- --------------------------------------------------------

--
-- Table structure for table `work_order`
--

DROP TABLE IF EXISTS `work_order`;
CREATE TABLE IF NOT EXISTS `work_order` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `wo_no` varchar(150) NOT NULL,
  `so_id` int(50) NOT NULL,
  `so_line_item` int(50) NOT NULL,
  `status` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  `bom_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=474 ;

--
-- Dumping data for table `work_order`
--

INSERT INTO `work_order` (`id`, `item_id`, `wo_no`, `so_id`, `so_line_item`, `status`, `date`, `bom_id`) VALUES
(159, 1, 'WO/2015/00089', 26, 58, 1, '28/Oct/2015', 1),
(160, 1, 'WO/2015/00090', 26, 58, 1, '28/Oct/2015', 1),
(161, 1, 'WO/2015/00091', 26, 58, 1, '28/Oct/2015', 1),
(162, 1, 'WO/2015/00092', 26, 58, 1, '28/Oct/2015', 1),
(163, 1, 'WO/2015/00093', 26, 58, 1, '28/Oct/2015', 1),
(164, 18, 'WO/2015/00094', 29, 62, 1, '05/Nov/2015', 5),
(165, 17, 'WO/2015/00095', 29, 62, 1, '05/Nov/2015', 4),
(166, 18, 'WO/2015/00096', 30, 63, 1, '05/Nov/2015', 5),
(167, 17, 'WO/2015/00097', 30, 63, 1, '05/Nov/2015', 4),
(168, 21, 'WO/2015/00098', 33, 66, 0, '06/Nov/2015', 7),
(169, 21, 'WO/2015/00099', 33, 66, 0, '06/Nov/2015', 7),
(170, 21, 'WO/2015/00100', 33, 66, 0, '06/Nov/2015', 7),
(171, 21, 'WO/2015/00101', 33, 66, 0, '06/Nov/2015', 7),
(172, 21, 'WO/2015/00102', 33, 66, 0, '06/Nov/2015', 7),
(173, 21, 'WO/2015/00103', 33, 66, 0, '06/Nov/2015', 7),
(174, 21, 'WO/2015/00104', 33, 66, 0, '06/Nov/2015', 7),
(175, 21, 'WO/2015/00105', 33, 66, 0, '06/Nov/2015', 7),
(176, 21, 'WO/2015/00106', 33, 66, 0, '06/Nov/2015', 7),
(177, 21, 'WO/2015/00107', 33, 66, 0, '06/Nov/2015', 7),
(178, 20, 'WO/2015/00108', 33, 66, 0, '06/Nov/2015', 6),
(179, 20, 'WO/2015/00109', 33, 66, 0, '06/Nov/2015', 6),
(180, 20, 'WO/2015/00110', 33, 66, 0, '06/Nov/2015', 6),
(181, 20, 'WO/2015/00111', 33, 66, 0, '06/Nov/2015', 6),
(182, 20, 'WO/2015/00112', 33, 66, 0, '06/Nov/2015', 6),
(183, 20, 'WO/2015/00113', 33, 66, 0, '06/Nov/2015', 6),
(184, 20, 'WO/2015/00114', 33, 66, 0, '06/Nov/2015', 6),
(185, 20, 'WO/2015/00115', 33, 66, 0, '06/Nov/2015', 6),
(186, 20, 'WO/2015/00116', 33, 66, 0, '06/Nov/2015', 6),
(187, 20, 'WO/2015/00117', 33, 66, 0, '06/Nov/2015', 6),
(188, 20, 'WO/2015/00118', 33, 66, 0, '06/Nov/2015', 6),
(189, 20, 'WO/2015/00119', 33, 66, 0, '06/Nov/2015', 6),
(190, 20, 'WO/2015/00120', 33, 66, 0, '06/Nov/2015', 6),
(191, 20, 'WO/2015/00121', 33, 66, 0, '06/Nov/2015', 6),
(192, 20, 'WO/2015/00122', 33, 66, 0, '06/Nov/2015', 6),
(193, 20, 'WO/2015/00123', 33, 66, 0, '06/Nov/2015', 6),
(194, 20, 'WO/2015/00124', 33, 66, 0, '06/Nov/2015', 6),
(195, 20, 'WO/2015/00125', 33, 66, 0, '06/Nov/2015', 6),
(196, 20, 'WO/2015/00126', 33, 66, 0, '06/Nov/2015', 6),
(197, 20, 'WO/2015/00127', 33, 66, 0, '06/Nov/2015', 6),
(198, 20, 'WO/2015/00128', 33, 66, 0, '06/Nov/2015', 6),
(199, 20, 'WO/2015/00129', 33, 66, 0, '06/Nov/2015', 6),
(200, 20, 'WO/2015/00130', 33, 66, 0, '06/Nov/2015', 6),
(201, 20, 'WO/2015/00131', 33, 66, 0, '06/Nov/2015', 6),
(202, 20, 'WO/2015/00132', 33, 66, 0, '06/Nov/2015', 6),
(203, 20, 'WO/2015/00133', 33, 66, 0, '06/Nov/2015', 6),
(204, 20, 'WO/2015/00134', 33, 66, 0, '06/Nov/2015', 6),
(205, 20, 'WO/2015/00135', 33, 66, 0, '06/Nov/2015', 6),
(206, 20, 'WO/2015/00136', 33, 66, 0, '06/Nov/2015', 6),
(207, 20, 'WO/2015/00137', 33, 66, 0, '06/Nov/2015', 6),
(208, 20, 'WO/2015/00138', 33, 66, 0, '06/Nov/2015', 6),
(209, 20, 'WO/2015/00139', 33, 66, 0, '06/Nov/2015', 6),
(210, 20, 'WO/2015/00140', 33, 66, 0, '06/Nov/2015', 6),
(211, 20, 'WO/2015/00141', 33, 66, 0, '06/Nov/2015', 6),
(212, 20, 'WO/2015/00142', 33, 66, 0, '06/Nov/2015', 6),
(213, 20, 'WO/2015/00143', 33, 66, 0, '06/Nov/2015', 6),
(214, 20, 'WO/2015/00144', 33, 66, 0, '06/Nov/2015', 6),
(215, 20, 'WO/2015/00145', 33, 66, 0, '06/Nov/2015', 6),
(216, 20, 'WO/2015/00146', 33, 66, 0, '06/Nov/2015', 6),
(217, 20, 'WO/2015/00147', 33, 66, 0, '06/Nov/2015', 6),
(218, 20, 'WO/2015/00148', 33, 66, 0, '06/Nov/2015', 6),
(219, 20, 'WO/2015/00149', 33, 66, 0, '06/Nov/2015', 6),
(220, 20, 'WO/2015/00150', 33, 66, 0, '06/Nov/2015', 6),
(221, 20, 'WO/2015/00151', 33, 66, 0, '06/Nov/2015', 6),
(222, 20, 'WO/2015/00152', 33, 66, 0, '06/Nov/2015', 6),
(223, 20, 'WO/2015/00153', 33, 66, 0, '06/Nov/2015', 6),
(224, 20, 'WO/2015/00154', 33, 66, 0, '06/Nov/2015', 6),
(225, 20, 'WO/2015/00155', 33, 66, 0, '06/Nov/2015', 6),
(226, 20, 'WO/2015/00156', 33, 66, 0, '06/Nov/2015', 6),
(227, 20, 'WO/2015/00157', 33, 66, 0, '06/Nov/2015', 6),
(228, 20, 'WO/2015/00158', 33, 66, 0, '06/Nov/2015', 6),
(229, 20, 'WO/2015/00159', 33, 66, 0, '06/Nov/2015', 6),
(230, 20, 'WO/2015/00160', 33, 66, 0, '06/Nov/2015', 6),
(231, 20, 'WO/2015/00161', 33, 66, 0, '06/Nov/2015', 6),
(232, 20, 'WO/2015/00162', 33, 66, 0, '06/Nov/2015', 6),
(233, 20, 'WO/2015/00163', 33, 66, 0, '06/Nov/2015', 6),
(234, 20, 'WO/2015/00164', 33, 66, 0, '06/Nov/2015', 6),
(235, 20, 'WO/2015/00165', 33, 66, 0, '06/Nov/2015', 6),
(236, 20, 'WO/2015/00166', 33, 66, 0, '06/Nov/2015', 6),
(237, 20, 'WO/2015/00167', 33, 66, 0, '06/Nov/2015', 6),
(238, 20, 'WO/2015/00168', 33, 66, 0, '06/Nov/2015', 6),
(239, 20, 'WO/2015/00169', 33, 66, 0, '06/Nov/2015', 6),
(240, 20, 'WO/2015/00170', 33, 66, 0, '06/Nov/2015', 6),
(241, 20, 'WO/2015/00171', 33, 66, 0, '06/Nov/2015', 6),
(242, 20, 'WO/2015/00172', 33, 66, 1, '06/Nov/2015', 6),
(243, 20, 'WO/2015/00173', 33, 66, 1, '06/Nov/2015', 6),
(244, 20, 'WO/2015/00174', 33, 66, 1, '06/Nov/2015', 6),
(245, 20, 'WO/2015/00175', 33, 66, 1, '06/Nov/2015', 6),
(246, 20, 'WO/2015/00176', 33, 66, 1, '06/Nov/2015', 6),
(247, 20, 'WO/2015/00177', 33, 66, 0, '06/Nov/2015', 6),
(248, 20, 'WO/2015/00178', 33, 66, 0, '06/Nov/2015', 6),
(249, 20, 'WO/2015/00179', 33, 66, 0, '06/Nov/2015', 6),
(250, 20, 'WO/2015/00180', 33, 66, 1, '06/Nov/2015', 6),
(251, 20, 'WO/2015/00181', 33, 66, 0, '06/Nov/2015', 6),
(252, 20, 'WO/2015/00182', 33, 66, 0, '06/Nov/2015', 6),
(253, 20, 'WO/2015/00183', 33, 66, 0, '06/Nov/2015', 6),
(254, 20, 'WO/2015/00184', 33, 66, 0, '06/Nov/2015', 6),
(255, 20, 'WO/2015/00185', 33, 66, 0, '06/Nov/2015', 6),
(256, 20, 'WO/2015/00186', 33, 66, 0, '06/Nov/2015', 6),
(257, 20, 'WO/2015/00187', 33, 66, 0, '06/Nov/2015', 6),
(258, 20, 'WO/2015/00188', 33, 66, 0, '06/Nov/2015', 6),
(259, 20, 'WO/2015/00189', 33, 66, 0, '06/Nov/2015', 6),
(260, 20, 'WO/2015/00190', 33, 66, 0, '06/Nov/2015', 6),
(261, 20, 'WO/2015/00191', 33, 66, 0, '06/Nov/2015', 6),
(262, 20, 'WO/2015/00192', 33, 66, 0, '06/Nov/2015', 6),
(263, 20, 'WO/2015/00193', 33, 66, 0, '06/Nov/2015', 6),
(264, 20, 'WO/2015/00194', 33, 66, 0, '06/Nov/2015', 6),
(265, 20, 'WO/2015/00195', 33, 66, 1, '06/Nov/2015', 6),
(266, 20, 'WO/2015/00196', 33, 66, 0, '06/Nov/2015', 6),
(267, 20, 'WO/2015/00197', 33, 66, 1, '06/Nov/2015', 6),
(268, 20, 'WO/2015/00198', 33, 66, 0, '06/Nov/2015', 6),
(269, 20, 'WO/2015/00199', 33, 66, 0, '06/Nov/2015', 6),
(270, 20, 'WO/2015/00200', 33, 66, 0, '06/Nov/2015', 6),
(271, 20, 'WO/2015/00201', 33, 66, 0, '06/Nov/2015', 6),
(272, 20, 'WO/2015/00202', 33, 66, 0, '06/Nov/2015', 6),
(273, 20, 'WO/2015/00203', 33, 66, 0, '06/Nov/2015', 6),
(274, 20, 'WO/2015/00204', 33, 66, 0, '06/Nov/2015', 6),
(275, 20, 'WO/2015/00205', 33, 66, 0, '06/Nov/2015', 6),
(276, 20, 'WO/2015/00206', 33, 66, 0, '06/Nov/2015', 6),
(277, 20, 'WO/2015/00207', 33, 66, 0, '06/Nov/2015', 6),
(278, 20, 'WO/2015/00208', 33, 66, 1, '06/Nov/2015', 6),
(279, 20, 'WO/2015/00209', 33, 66, 0, '06/Nov/2015', 6),
(280, 20, 'WO/2015/00210', 33, 66, 0, '06/Nov/2015', 6),
(281, 20, 'WO/2015/00211', 33, 66, 0, '06/Nov/2015', 6),
(282, 20, 'WO/2015/00212', 33, 66, 0, '06/Nov/2015', 6),
(283, 20, 'WO/2015/00213', 33, 66, 0, '06/Nov/2015', 6),
(284, 20, 'WO/2015/00214', 33, 66, 0, '06/Nov/2015', 6),
(285, 20, 'WO/2015/00215', 33, 66, 0, '06/Nov/2015', 6),
(286, 20, 'WO/2015/00216', 33, 66, 0, '06/Nov/2015', 6),
(287, 20, 'WO/2015/00217', 33, 66, 0, '06/Nov/2015', 6),
(288, 20, 'WO/2015/00218', 33, 66, 0, '06/Nov/2015', 6),
(289, 20, 'WO/2015/00219', 33, 66, 0, '06/Nov/2015', 6),
(290, 20, 'WO/2015/00220', 33, 66, 0, '06/Nov/2015', 6),
(291, 20, 'WO/2015/00221', 33, 66, 0, '06/Nov/2015', 6),
(292, 20, 'WO/2015/00222', 33, 66, 0, '06/Nov/2015', 6),
(293, 20, 'WO/2015/00223', 33, 66, 0, '06/Nov/2015', 6),
(294, 20, 'WO/2015/00224', 33, 66, 0, '06/Nov/2015', 6),
(295, 20, 'WO/2015/00225', 33, 66, 0, '06/Nov/2015', 6),
(296, 20, 'WO/2015/00226', 33, 66, 0, '06/Nov/2015', 6),
(297, 20, 'WO/2015/00227', 33, 66, 0, '06/Nov/2015', 6),
(298, 21, 'WO/2015/00228', 33, 67, 0, '06/Nov/2015', 7),
(299, 21, 'WO/2015/00229', 33, 67, 0, '06/Nov/2015', 7),
(300, 20, 'WO/2015/00230', 33, 67, 0, '06/Nov/2015', 6),
(301, 20, 'WO/2015/00231', 33, 67, 0, '06/Nov/2015', 6),
(302, 20, 'WO/2015/00232', 33, 67, 0, '06/Nov/2015', 6),
(303, 20, 'WO/2015/00233', 33, 67, 0, '06/Nov/2015', 6),
(304, 20, 'WO/2015/00234', 33, 67, 1, '06/Nov/2015', 6),
(305, 20, 'WO/2015/00235', 33, 67, 0, '06/Nov/2015', 6),
(306, 20, 'WO/2015/00236', 33, 67, 0, '06/Nov/2015', 6),
(307, 20, 'WO/2015/00237', 33, 67, 0, '06/Nov/2015', 6),
(308, 20, 'WO/2015/00238', 33, 67, 0, '06/Nov/2015', 6),
(309, 20, 'WO/2015/00239', 33, 67, 0, '06/Nov/2015', 6),
(310, 20, 'WO/2015/00240', 33, 67, 0, '06/Nov/2015', 6),
(311, 20, 'WO/2015/00241', 33, 67, 0, '06/Nov/2015', 6),
(312, 20, 'WO/2015/00242', 33, 67, 0, '06/Nov/2015', 6),
(313, 20, 'WO/2015/00243', 33, 67, 0, '06/Nov/2015', 6),
(314, 20, 'WO/2015/00244', 33, 67, 0, '06/Nov/2015', 6),
(315, 20, 'WO/2015/00245', 33, 67, 0, '06/Nov/2015', 6),
(316, 20, 'WO/2015/00246', 33, 67, 0, '06/Nov/2015', 6),
(317, 20, 'WO/2015/00247', 33, 67, 0, '06/Nov/2015', 6),
(318, 20, 'WO/2015/00248', 33, 67, 0, '06/Nov/2015', 6),
(319, 20, 'WO/2015/00249', 33, 67, 0, '06/Nov/2015', 6),
(320, 20, 'WO/2015/00250', 33, 67, 0, '06/Nov/2015', 6),
(321, 20, 'WO/2015/00251', 33, 67, 0, '06/Nov/2015', 6),
(322, 20, 'WO/2015/00252', 33, 67, 0, '06/Nov/2015', 6),
(323, 20, 'WO/2015/00253', 33, 67, 0, '06/Nov/2015', 6),
(324, 13, 'WO/2015/00254', 35, 69, 1, '06/Nov/2015', 3),
(325, 13, 'WO/2015/00255', 35, 69, 0, '06/Nov/2015', 3),
(326, 13, 'WO/2015/00256', 35, 69, 0, '06/Nov/2015', 3),
(327, 13, 'WO/2015/00257', 35, 69, 0, '06/Nov/2015', 3),
(328, 13, 'WO/2015/00258', 35, 69, 0, '06/Nov/2015', 3),
(329, 13, 'WO/2015/00259', 35, 69, 0, '06/Nov/2015', 3),
(330, 13, 'WO/2015/00260', 35, 69, 0, '06/Nov/2015', 3),
(331, 13, 'WO/2015/00261', 35, 69, 0, '06/Nov/2015', 3),
(332, 13, 'WO/2015/00262', 35, 69, 0, '06/Nov/2015', 3),
(333, 13, 'WO/2015/00263', 35, 69, 0, '06/Nov/2015', 3),
(334, 13, 'WO/2015/00264', 35, 69, 0, '06/Nov/2015', 3),
(335, 13, 'WO/2015/00265', 35, 69, 0, '06/Nov/2015', 3),
(336, 13, 'WO/2015/00266', 35, 69, 0, '06/Nov/2015', 3),
(337, 13, 'WO/2015/00267', 35, 69, 0, '06/Nov/2015', 3),
(338, 13, 'WO/2015/00268', 35, 69, 0, '06/Nov/2015', 3),
(339, 13, 'WO/2015/00269', 35, 69, 0, '06/Nov/2015', 3),
(340, 13, 'WO/2015/00270', 35, 69, 0, '06/Nov/2015', 3),
(341, 13, 'WO/2015/00271', 35, 69, 0, '06/Nov/2015', 3),
(342, 13, 'WO/2015/00272', 35, 69, 0, '06/Nov/2015', 3),
(343, 13, 'WO/2015/00273', 35, 69, 0, '06/Nov/2015', 3),
(344, 1, 'WO/2015/00274', 35, 69, 0, '06/Nov/2015', 1),
(345, 1, 'WO/2015/00275', 35, 69, 0, '06/Nov/2015', 1),
(346, 1, 'WO/2015/00276', 35, 69, 0, '06/Nov/2015', 1),
(347, 1, 'WO/2015/00277', 35, 69, 0, '06/Nov/2015', 1),
(348, 1, 'WO/2015/00278', 35, 69, 0, '06/Nov/2015', 1),
(349, 1, 'WO/2015/00279', 35, 69, 0, '06/Nov/2015', 1),
(350, 1, 'WO/2015/00280', 35, 69, 0, '06/Nov/2015', 1),
(351, 1, 'WO/2015/00281', 35, 69, 0, '06/Nov/2015', 1),
(352, 1, 'WO/2015/00282', 35, 69, 0, '06/Nov/2015', 1),
(353, 1, 'WO/2015/00283', 35, 69, 0, '06/Nov/2015', 1),
(354, 1, 'WO/2015/00284', 35, 69, 0, '06/Nov/2015', 1),
(355, 1, 'WO/2015/00285', 35, 69, 0, '06/Nov/2015', 1),
(356, 1, 'WO/2015/00286', 35, 69, 0, '06/Nov/2015', 1),
(357, 1, 'WO/2015/00287', 35, 69, 0, '06/Nov/2015', 1),
(358, 1, 'WO/2015/00288', 35, 69, 0, '06/Nov/2015', 1),
(359, 1, 'WO/2015/00289', 35, 69, 0, '06/Nov/2015', 1),
(360, 1, 'WO/2015/00290', 35, 69, 0, '06/Nov/2015', 1),
(361, 1, 'WO/2015/00291', 35, 69, 0, '06/Nov/2015', 1),
(362, 1, 'WO/2015/00292', 35, 69, 0, '06/Nov/2015', 1),
(363, 1, 'WO/2015/00293', 35, 69, 0, '06/Nov/2015', 1),
(364, 1, 'WO/2015/00294', 35, 69, 0, '06/Nov/2015', 1),
(365, 1, 'WO/2015/00295', 35, 69, 0, '06/Nov/2015', 1),
(366, 1, 'WO/2015/00296', 35, 69, 0, '06/Nov/2015', 1),
(367, 1, 'WO/2015/00297', 35, 69, 0, '06/Nov/2015', 1),
(368, 1, 'WO/2015/00298', 35, 69, 0, '06/Nov/2015', 1),
(369, 1, 'WO/2015/00299', 35, 69, 0, '06/Nov/2015', 1),
(370, 1, 'WO/2015/00300', 35, 69, 0, '06/Nov/2015', 1),
(371, 1, 'WO/2015/00301', 35, 69, 0, '06/Nov/2015', 1),
(372, 1, 'WO/2015/00302', 35, 69, 0, '06/Nov/2015', 1),
(373, 1, 'WO/2015/00303', 35, 69, 0, '06/Nov/2015', 1),
(374, 1, 'WO/2015/00304', 35, 69, 0, '06/Nov/2015', 1),
(375, 1, 'WO/2015/00305', 35, 69, 0, '06/Nov/2015', 1),
(376, 1, 'WO/2015/00306', 35, 69, 0, '06/Nov/2015', 1),
(377, 1, 'WO/2015/00307', 35, 69, 0, '06/Nov/2015', 1),
(378, 1, 'WO/2015/00308', 35, 69, 0, '06/Nov/2015', 1),
(379, 1, 'WO/2015/00309', 35, 69, 0, '06/Nov/2015', 1),
(380, 1, 'WO/2015/00310', 35, 69, 1, '06/Nov/2015', 1),
(381, 1, 'WO/2015/00311', 35, 69, 0, '06/Nov/2015', 1),
(382, 1, 'WO/2015/00312', 35, 69, 0, '06/Nov/2015', 1),
(383, 1, 'WO/2015/00313', 35, 69, 0, '06/Nov/2015', 1),
(384, 1, 'WO/2015/00314', 35, 69, 0, '06/Nov/2015', 1),
(385, 1, 'WO/2015/00315', 35, 69, 0, '06/Nov/2015', 1),
(386, 1, 'WO/2015/00316', 35, 69, 0, '06/Nov/2015', 1),
(387, 1, 'WO/2015/00317', 35, 69, 0, '06/Nov/2015', 1),
(388, 1, 'WO/2015/00318', 35, 69, 0, '06/Nov/2015', 1),
(389, 1, 'WO/2015/00319', 35, 69, 0, '06/Nov/2015', 1),
(390, 1, 'WO/2015/00320', 35, 69, 0, '06/Nov/2015', 1),
(391, 1, 'WO/2015/00321', 35, 69, 0, '06/Nov/2015', 1),
(392, 1, 'WO/2015/00322', 35, 69, 0, '06/Nov/2015', 1),
(393, 1, 'WO/2015/00323', 35, 69, 0, '06/Nov/2015', 1),
(394, 1, 'WO/2015/00324', 35, 69, 0, '06/Nov/2015', 1),
(395, 1, 'WO/2015/00325', 35, 69, 0, '06/Nov/2015', 1),
(396, 1, 'WO/2015/00326', 35, 69, 0, '06/Nov/2015', 1),
(397, 1, 'WO/2015/00327', 35, 69, 0, '06/Nov/2015', 1),
(398, 1, 'WO/2015/00328', 35, 69, 0, '06/Nov/2015', 1),
(399, 1, 'WO/2015/00329', 35, 69, 0, '06/Nov/2015', 1),
(400, 1, 'WO/2015/00330', 35, 69, 0, '06/Nov/2015', 1),
(401, 1, 'WO/2015/00331', 35, 69, 0, '06/Nov/2015', 1),
(402, 1, 'WO/2015/00332', 35, 69, 0, '06/Nov/2015', 1),
(403, 1, 'WO/2015/00333', 35, 69, 0, '06/Nov/2015', 1),
(404, 1, 'WO/2015/00334', 35, 69, 0, '06/Nov/2015', 1),
(405, 1, 'WO/2015/00335', 35, 69, 0, '06/Nov/2015', 1),
(406, 1, 'WO/2015/00336', 35, 69, 0, '06/Nov/2015', 1),
(407, 1, 'WO/2015/00337', 35, 69, 0, '06/Nov/2015', 1),
(408, 1, 'WO/2015/00338', 35, 69, 0, '06/Nov/2015', 1),
(409, 1, 'WO/2015/00339', 35, 69, 0, '06/Nov/2015', 1),
(410, 1, 'WO/2015/00340', 35, 69, 0, '06/Nov/2015', 1),
(411, 1, 'WO/2015/00341', 35, 69, 0, '06/Nov/2015', 1),
(412, 1, 'WO/2015/00342', 35, 69, 0, '06/Nov/2015', 1),
(413, 1, 'WO/2015/00343', 35, 69, 0, '06/Nov/2015', 1),
(414, 1, 'WO/2015/00344', 35, 69, 0, '06/Nov/2015', 1),
(415, 1, 'WO/2015/00345', 35, 69, 0, '06/Nov/2015', 1),
(416, 1, 'WO/2015/00346', 35, 69, 0, '06/Nov/2015', 1),
(417, 1, 'WO/2015/00347', 35, 69, 0, '06/Nov/2015', 1),
(418, 1, 'WO/2015/00348', 35, 69, 0, '06/Nov/2015', 1),
(419, 1, 'WO/2015/00349', 35, 69, 0, '06/Nov/2015', 1),
(420, 1, 'WO/2015/00350', 35, 69, 0, '06/Nov/2015', 1),
(421, 1, 'WO/2015/00351', 35, 69, 0, '06/Nov/2015', 1),
(422, 1, 'WO/2015/00352', 35, 69, 0, '06/Nov/2015', 1),
(423, 1, 'WO/2015/00353', 35, 69, 0, '06/Nov/2015', 1),
(424, 13, 'WO/2015/00354', 40, 74, 0, '06/Nov/2015', 3),
(425, 13, 'WO/2015/00355', 40, 74, 0, '06/Nov/2015', 3),
(426, 13, 'WO/2015/00356', 40, 74, 0, '06/Nov/2015', 3),
(427, 13, 'WO/2015/00357', 40, 74, 0, '06/Nov/2015', 3),
(428, 13, 'WO/2015/00358', 40, 74, 0, '06/Nov/2015', 3),
(429, 13, 'WO/2015/00359', 40, 74, 0, '06/Nov/2015', 3),
(430, 13, 'WO/2015/00360', 40, 74, 0, '06/Nov/2015', 3),
(431, 13, 'WO/2015/00361', 40, 74, 0, '06/Nov/2015', 3),
(432, 13, 'WO/2015/00362', 40, 74, 0, '06/Nov/2015', 3),
(433, 13, 'WO/2015/00363', 40, 74, 1, '06/Nov/2015', 3),
(434, 1, 'WO/2015/00364', 40, 74, 0, '06/Nov/2015', 1),
(435, 1, 'WO/2015/00365', 40, 74, 0, '06/Nov/2015', 1),
(436, 1, 'WO/2015/00366', 40, 74, 0, '06/Nov/2015', 1),
(437, 1, 'WO/2015/00367', 40, 74, 0, '06/Nov/2015', 1),
(438, 1, 'WO/2015/00368', 40, 74, 0, '06/Nov/2015', 1),
(439, 1, 'WO/2015/00369', 40, 74, 0, '06/Nov/2015', 1),
(440, 1, 'WO/2015/00370', 40, 74, 0, '06/Nov/2015', 1),
(441, 1, 'WO/2015/00371', 40, 74, 0, '06/Nov/2015', 1),
(442, 1, 'WO/2015/00372', 40, 74, 0, '06/Nov/2015', 1),
(443, 1, 'WO/2015/00373', 40, 74, 0, '06/Nov/2015', 1),
(444, 1, 'WO/2015/00374', 40, 74, 0, '06/Nov/2015', 1),
(445, 1, 'WO/2015/00375', 40, 74, 0, '06/Nov/2015', 1),
(446, 1, 'WO/2015/00376', 40, 74, 0, '06/Nov/2015', 1),
(447, 1, 'WO/2015/00377', 40, 74, 0, '06/Nov/2015', 1),
(448, 1, 'WO/2015/00378', 40, 74, 0, '06/Nov/2015', 1),
(449, 1, 'WO/2015/00379', 40, 74, 0, '06/Nov/2015', 1),
(450, 1, 'WO/2015/00380', 40, 74, 0, '06/Nov/2015', 1),
(451, 1, 'WO/2015/00381', 40, 74, 0, '06/Nov/2015', 1),
(452, 1, 'WO/2015/00382', 40, 74, 0, '06/Nov/2015', 1),
(453, 1, 'WO/2015/00383', 40, 74, 0, '06/Nov/2015', 1),
(454, 1, 'WO/2015/00384', 40, 74, 0, '06/Nov/2015', 1),
(455, 1, 'WO/2015/00385', 40, 74, 0, '06/Nov/2015', 1),
(456, 1, 'WO/2015/00386', 40, 74, 0, '06/Nov/2015', 1),
(457, 1, 'WO/2015/00387', 40, 74, 0, '06/Nov/2015', 1),
(458, 1, 'WO/2015/00388', 40, 74, 0, '06/Nov/2015', 1),
(459, 1, 'WO/2015/00389', 40, 74, 0, '06/Nov/2015', 1),
(460, 1, 'WO/2015/00390', 40, 74, 0, '06/Nov/2015', 1),
(461, 1, 'WO/2015/00391', 40, 74, 0, '06/Nov/2015', 1),
(462, 1, 'WO/2015/00392', 40, 74, 0, '06/Nov/2015', 1),
(463, 1, 'WO/2015/00393', 40, 74, 0, '06/Nov/2015', 1),
(464, 1, 'WO/2015/00394', 40, 74, 0, '06/Nov/2015', 1),
(465, 1, 'WO/2015/00395', 40, 74, 0, '06/Nov/2015', 1),
(466, 1, 'WO/2015/00396', 40, 74, 0, '06/Nov/2015', 1),
(467, 1, 'WO/2015/00397', 40, 74, 0, '06/Nov/2015', 1),
(468, 1, 'WO/2015/00398', 40, 74, 0, '06/Nov/2015', 1),
(469, 1, 'WO/2015/00399', 40, 74, 0, '06/Nov/2015', 1),
(470, 1, 'WO/2015/00400', 40, 74, 0, '06/Nov/2015', 1),
(471, 1, 'WO/2015/00401', 40, 74, 0, '06/Nov/2015', 1),
(472, 1, 'WO/2015/00402', 40, 74, 0, '06/Nov/2015', 1),
(473, 1, 'WO/2015/00403', 40, 74, 0, '06/Nov/2015', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

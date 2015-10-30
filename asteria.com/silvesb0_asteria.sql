-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2015 at 11:35 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

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
(3, 'auth/addgroupdept', 'Add Department or Designation', 'UM', 1, 1, 1, 1),
(4, 'auth/roles', 'Role Management', 'UM', 1, 1, 1, 1),
(5, 'material/index', 'Material Master', 'MM', 0, 0, 0, 0),
(6, 'material/groupcategorymaster', 'Material Major Category', 'MM', 0, 0, 0, 0),
(7, 'material/groupmaster', 'Material Category', 'MM', 0, 0, 0, 0),
(10, 'customer/manage', 'Customer List', 'CM', 0, 0, 0, 0),
(12, 'material/typemaster', 'Material Type Master', 'MM', 0, 0, 0, 0),
(13, 'vendor/index', 'Vendor List', 'MM', 0, 0, 0, 0),
(14, 'material/statusmaster', 'Material StatusMaster', 'MM', 0, 0, 0, 0),
(15, 'material/projectmaster', 'Project Master', 'MM', 0, 0, 0, 0),
(16, 'material/designbase', 'Design Base', 'MM', 0, 0, 0, 0),
(17, 'bom/index', 'Bill Of Material', 'BM', 0, 0, 0, 0),
(18, 'sales/index', 'Sales Order', 'SO', 1, 1, 1, 1),
(19, 'sales/workorder', 'Work Order', 'SO', 1, 1, 1, 1),
(20, 'material/shipping', 'Shipping Method', 'MM', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_modules`
--

CREATE TABLE IF NOT EXISTS `acl_modules` (
  `acl_module_id` int(25) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_id` varchar(50) NOT NULL,
  PRIMARY KEY (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `acl_modules`
--

INSERT INTO `acl_modules` (`acl_module_id`, `module_name`, `module_id`) VALUES
(1, 'User Management', 'UM'),
(2, 'Master Data', 'MM'),
(6, 'Customer Master', 'CM'),
(7, 'Bill of Material', 'BM'),
(8, 'Sales', 'SO');

-- --------------------------------------------------------

--
-- Table structure for table `acl_module_permissions`
--

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

CREATE TABLE IF NOT EXISTS `acl_roles` (
  `acl_role_id` int(25) NOT NULL AUTO_INCREMENT,
  `acl_role_name` varchar(255) NOT NULL,
  `acl_module_id` varchar(255) DEFAULT NULL,
  `acl_controller_id` varchar(255) NOT NULL,
  `acl_permission` text NOT NULL,
  PRIMARY KEY (`acl_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `acl_roles`
--

INSERT INTO `acl_roles` (`acl_role_id`, `acl_role_name`, `acl_module_id`, `acl_controller_id`, `acl_permission`) VALUES
(18, 'Admin', '{"1":"UM","2":"MM","6":"CM","7":"BM","8":"SO"}', '{"UM":{"1":"1","3":"3","4":"4"},"MM":{"5":"5","6":"6","7":"7","12":"12","13":"13","14":"14","15":"15","16":"16","20":"20"},"CM":{"10":"10"},"BM":{"17":"17"},"SO":{"18":"18","19":"19"}}', '{"1":{"view":"1","create":"1","edit":"1","approve":"1"},"3":{"view":"1","create":"1","edit":"1","approve":"1"},"4":{"view":"1","create":"1","edit":"1","approve":"1"},"5":{"view":"1","create":"1","edit":"1","approve":"1"},"6":{"view":"1","create":"1","edit":"1","approve":"1"},"7":{"view":"1","create":"1","edit":"1","approve":"1"},"12":{"view":"1","create":"1","edit":"1","approve":"1"},"13":{"view":"1","create":"1","edit":"1","approve":"1"},"14":{"view":"1","create":"1","edit":"1","approve":"1"},"15":{"view":"1","create":"1","edit":"1","approve":"1"},"16":{"view":"1","create":"1","edit":"1","approve":"1"},"20":{"view":"1","create":"1","edit":"1","approve":"1"},"10":{"view":"1","create":"1","edit":"1","approve":"1"},"17":{"view":"1","create":"1","edit":"1","approve":"1"},"18":{"view":"1","create":"1","edit":"1","approve":"1"},"19":{"view":"1","create":"1","edit":"1","approve":"1"}}'),
(23, 'AdminTest', '{"1":"UM","2":"MM"}', '{"UM":{"1":"1","3":"3","4":"4"},"MM":{"5":"5","6":"6"}}', '{"1":{"view":"1","edit":"1"},"3":{"view":"1"},"4":{"view":"1","create":"1","edit":"1"},"5":{"view":"1","create":"1","edit":"1"},"6":{"view":"1","create":"1"}}'),
(25, 'test3', '{"2":"MM"}', '{"MM":{"5":"5","6":"6","7":"7"}}', '{"5":{"view":"1","create":"1","edit":"1","approve":"1"},"6":{"view":"1"},"7":{"view":"1","create":"1","edit":"1","approve":"1"}}'),
(26, 'test', '{"1":"UM"}', '{"UM":{"1":"1","3":"3","4":"4"}}', '{"1":{"view":"1"},"3":{"view":"1"},"4":{"view":"1"}}');

-- --------------------------------------------------------

--
-- Table structure for table `acl_user_roles`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `adminusers`
--

INSERT INTO `adminusers` (`id`, `status`, `firstname`, `lastname`, `email`, `password`, `role`, `department`, `group`, `created`) VALUES
(5, 'active', 'asteria', 'admin', 'admin@asteria.com', '0192023a7bbd73250516f069df18b500', '["18"]', '5', '11', '2015-08-01 05:28:03'),
(6, 'inactive', 'Kumar', 'Goudham', 'kumaran.m89@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '["23","25"]', '5', '11', '2015-08-05 09:09:00'),
(8, 'inactive', 'Kumar', 'Goudham', 'asteriaddd@clematix.com', 'e10adc3949ba59abbe56e057f20f883e', '["23"]', '5', '11', '2015-08-05 09:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `bom`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bom`
--

INSERT INTO `bom` (`id`, `bom_rev_id`, `bom_project_id`, `material_id`, `project_id`, `date`, `status`, `bom_description`) VALUES
(3, 'A', 'test', 2, '1111', '16/Oct/2015', 1, 'Inductor1 vvv'),
(4, 'A', 'test', 4, '1111', '17/Oct/2015', 1, 'Inductor1 vvv');

-- --------------------------------------------------------

--
-- Table structure for table `bom_ref`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=651 ;

--
-- Dumping data for table `bom_ref`
--

INSERT INTO `bom_ref` (`id`, `bom_id`, `material_id`, `qty`, `comments`, `date`, `rev_id`, `uom`, `br`, `cv`, `csp`, `fyn`, `sbm`, `pthrsmt`) VALUES
(648, 3, 4, 7, 'grggggggg', '2015-10-16 05:34:53', 'A', 3, NULL, NULL, NULL, NULL, NULL, NULL),
(649, 4, 3, 88, 'hhhgg', '2015-10-17 01:57:52', 'A', 3, NULL, NULL, NULL, NULL, NULL, NULL),
(650, 4, 3, 66, 'fvvv', '2015-10-17 01:57:52', 'A', 3, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `config_mail`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `company_name`, `company_address`, `contact_person`, `country`, `region`, `industry`, `email`, `telephone`) VALUES
(5, 'f', 'hosur\r\nhosur', 'test', 'India', 'TN', 'test', 'asteria@clematix.com', '9994729807'),
(6, 'test', 'hosur\r\nhosur', 'Kumar', 'India', 'TN', 'test', 'kumaran.m89@gmail.com', '2147483647'),
(7, 'ts', 'ssss', 'sss', 'India', 'TN', 'dddd', 'asteriffa@clematix.com', '2147483647');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(5, 'Account'),
(6, 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `designbase`
--

CREATE TABLE IF NOT EXISTS `designbase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designbase` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `designbase`
--

INSERT INTO `designbase` (`id`, `designbase`, `code`, `desc`, `status`, `date`) VALUES
(1, 'Asteria', 'A', '', 1, '2015-08-28 11:39:11'),
(3, 'Universal', 'U', '', 1, '2015-08-28 11:45:22'),
(4, 'Non-Asteria', 'N', '', 1, '2015-08-28 11:45:21'),
(5, 'Others', 'O', '', 1, '2015-08-31 09:25:03'),
(6, 'Test', 'T', 'Test Sample1', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `fnlm`
--

CREATE TABLE IF NOT EXISTS `fnlm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `fnlm`
--

INSERT INTO `fnlm` (`id`, `descr`, `code`, `desc`, `status`, `date`) VALUES
(1, 'No Special Operation', '00', '', 1, '2015-08-28 10:30:14'),
(2, 'Sandblasted', '01', '', 1, '2015-08-28 10:30:12'),
(3, 'Primer Only', '02', '', 1, '2015-08-28 10:30:13'),
(4, 'KUM', '03', '', 1, '2015-09-07 11:02:18'),
(5, 'LH', '04', '', 1, '2015-09-07 11:02:20'),
(6, 'Ram', '05', 'Ram ', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `grn`
--

CREATE TABLE IF NOT EXISTS `grn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(10) NOT NULL,
  `vendor_po` varchar(40) NOT NULL,
  `grn_no` varchar(20) NOT NULL,
  `grn_date` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `grn`
--

INSERT INTO `grn` (`id`, `vendor_name`, `vendor_po`, `grn_no`, `grn_date`, `status`, `date`) VALUES
(1, '1', '1', '2015/0001', '20-10-2015', 0, '2015-10-20 08:05:53'),
(2, '1', '1', '2015/0002', '20-10-2015', 0, '2015-10-20 08:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `grn_material`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `grn_material`
--

INSERT INTO `grn_material` (`id`, `grn_id`, `item`, `poqty`, `rcvdqty`, `okqty`, `rejectedqty`, `ast_sl`, `mfgdate`, `expiry`, `serial`) VALUES
(1, 1, 1, 500, 10, 10, 0, 1, '20-10-2015', '20-10-2015', 'AA001, AA002, AA003, AA004, AA005'),
(2, 1, 2, 200, 10, 10, 0, 2, '20-10-2015', '20-10-2015', '15-10-20-AA'),
(3, 2, 1, 490, 10, 5, 5, 3, '20-10-2015', '20-10-2015', 'AA006, AA007'),
(4, 2, 2, 190, 10, 5, 5, 4, '20-10-2015', '20-10-2015', '15-10-20-AB');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`) VALUES
(11, 'Manager'),
(12, 'Accountant');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `uniqueid` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `grn_id`, `itemid`, `uniqueid`, `status`) VALUES
(1, 1, 1, 'AA001', 0),
(2, 1, 1, 'AA002', 0),
(3, 1, 1, 'AA003', 0),
(4, 1, 1, 'AA004', 0),
(5, 1, 1, 'AA005', 0),
(6, 1, 2, '15-10-20-AA', 0),
(7, 2, 1, 'AA006', 0),
(8, 2, 1, 'AA007', 0),
(9, 2, 2, '15-10-20-AB', 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_available`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `part_no`, `material_desc`, `uom`, `drawing_no`, `revision_no`, `material_status`, `upload`, `material_category`, `material_sub_category`, `material_type`, `design_base`, `mech_position`, `mech_finish`, `oem_name`, `oem_pdt_id`, `oem_pdt_desc`, `oem_lead_time`, `min_stock`, `stock_handling`, `moving_price`, `manuf_cost`, `gen_price`, `mat_life`, `weight`, `addn_info`, `status`, `created_date`, `created_user`, `updated_date`, `updated_user`) VALUES
(1, 'MRAM-A-00001-0100', '1', '1', 'MRAM-00001', 'B', '23', 'MRAM-00001-B.pdf', 'M', '2', '4', 'A', '01', '00', 'TVS', '121', 'TestB', 10, 200, 'Item', '', '', '', '150', 2, 'Material 1', 1, '2015-10-27 07:15:12', 5, '2015-10-27 07:10:40', 5),
(2, 'C-U-00002', 'Material 2', '2', 'C-00002', '', '23', '', 'EC', '9', '4', 'U', '0', '0', 'TVS', '222', 'BB', 10, 200, 'Batch', '', '', '', '200', 15, 'Material 2', 1, '2015-10-27 07:55:15', 5, '2015-10-27 07:49:35', 5),
(4, 'DIOM-U-00004', 'New', '1', '', '', '23', 'AsteriaERPSystem.pdf', 'E', '3', '4', 'U', '0', '0', '', '', '', 0, 0, '0', '', '', '', '', 0, '', 0, '2015-10-27 08:00:05', 5, '2015-10-27 08:00:04', 5),
(5, 'DIOM-A-00005', 'Ram1', '1', 'DIOM-00005', 'A', '23', '', 'E', '3', '4', 'A', '0', '0', '', '', '', 0, 0, '0', '', '', '', '', 0, '', 1, '2015-10-27 07:55:10', 5, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `materialgroup`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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
(9, 'EC', 'EC', 'Capacitor', 'C', 'Capacitor 10um', 1, '2015-08-31 09:23:28'),
(10, 'M', 'M', 'Master', 'MMST', 'Materialss', 1, '2015-09-08 06:43:29'),
(11, 'EC', 'EC', 'Inductance', 'I', 'Inductance', 1, '2015-08-31 09:27:18'),
(12, 'M', 'M', 'Fastener', 'MFAS', '', 0, '2015-10-06 05:18:39'),
(13, 'E', 'E', 'Cables', 'ECAB', '', 0, '2015-09-08 06:43:02'),
(14, 'E', 'E', 'Ram', 'ETFF', 'Test', 0, '2015-09-08 06:42:58'),
(15, 'E', 'E', 'RMA', 'EGHH', 'dfgdfg', 0, '2015-10-06 05:12:15'),
(16, 'E', 'E', 'Murali', 'EMUL', 'Murali Stml', 1, '2015-09-08 06:41:58'),
(17, 'M', 'M', 'System', 'MSDS', 'sdfsdf', 0, '2015-10-06 05:18:38'),
(18, 'A', 'A', 'Arjun', 'ABBB', 'ASSS', 1, '2015-10-06 05:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `materialgroupcategory`
--

CREATE TABLE IF NOT EXISTS `materialgroupcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(20) NOT NULL,
  `charac` text NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `materialgroupcategory`
--

INSERT INTO `materialgroupcategory` (`id`, `category`, `charac`, `status`, `date`) VALUES
(1, 'Mechanical', 'M', 1, '2015-08-18 06:51:50'),
(2, 'Electrical', 'E', 1, '2015-09-01 12:42:04'),
(3, 'Electronics', 'EC', 1, '2015-08-31 09:22:50'),
(4, 'Ram', 'R', 0, '0000-00-00 00:00:00'),
(5, 'Major Assembly', 'A', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `materialstatus`
--

CREATE TABLE IF NOT EXISTS `materialstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `charac` varchar(20) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `materialstatus`
--

INSERT INTO `materialstatus` (`id`, `name`, `charac`, `desc`, `status`) VALUES
(23, 'Baseline', 'BS', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `materialtype`
--

CREATE TABLE IF NOT EXISTS `materialtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `code` varchar(20) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `bom_val` varchar(5) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `materialtype`
--

INSERT INTO `materialtype` (`id`, `type`, `code`, `desc`, `bom_val`, `status`, `date`) VALUES
(3, 'General Consumable', 'V2', 'Ram', 'Yes', 0, '2015-09-28 06:59:58'),
(4, 'SFG', '1', '', 'Yes', 1, '2015-09-28 06:59:57'),
(5, 'Raw Material', 'RM', '', 'Yes', 1, '2015-09-28 06:59:55'),
(8, 'Process Consumable', 'PCon', 'Product usable', 'Yes', 0, '2015-09-28 06:59:50'),
(9, 'Test Ram', 'A', 'Ram', 'Yes', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `material_vendordetails`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `material_vendordetails`
--

INSERT INTO `material_vendordetails` (`id`, `material_id`, `vendor`, `vendor_pdt_id`, `vendor_pdt_desc`, `lead_time`, `vendoruom`, `list_price`, `moq`, `conv_vend_basic`, `conv_vend`) VALUES
(1, 1, 1, '111', 'Test', 10, '2', '15', 100, '1', '2'),
(2, 1, 3, '121', 'TestB', 10, '1', '14', 100, '1', '1'),
(3, 2, 1, '211', 'BA', 15, '2', '10', 100, '1', '1'),
(4, 2, 3, '222', 'BB', 10, '1', '10', 100, '1', '2'),
(5, 3, 1, '1', '1', 1, '1', '1', 1, '1', '1'),
(6, 3, 3, '2', '2', 2, '15', '1', 1, '1', '100'),
(7, 4, 0, '', '', 0, '', '', 0, '', ''),
(8, 4, 0, '', '', 0, '', '', 0, '', ''),
(9, 5, 0, '', '', 0, '', '', 0, '', ''),
(10, 5, 0, '', '', 0, '', '', 0, '', ''),
(11, 6, 1, '1', '1', 1, '1', '1', 1, '1', '1'),
(12, 6, 0, '', '', 0, '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(20) NOT NULL,
  `code` varchar(10) NOT NULL,
  `desc` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `descr`, `code`, `desc`, `status`, `date`) VALUES
(1, 'No Dual', '00', '', 1, '2015-08-28 10:29:12'),
(2, 'LH', '01', '', 1, '2015-09-07 10:46:59'),
(3, 'RH', '02', '', 1, '2015-09-07 10:47:04'),
(4, 'Ram', '03', 'Ram', 1, '2015-09-07 10:47:08'),
(5, 'Kumar', '04', 'KUMS', 1, '0000-00-00 00:00:00'),
(6, 'New', '05', 'Value', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_code` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `project_code` (`project_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_code`, `status`) VALUES
(9, 'Proj A', 'AA', 1),
(10, 'Test', 'AB', 1),
(12, 'Clematix', 'AC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `so_no`, `customer_po`, `invoice_date`, `supplier`, `customer`, `shipping_method`, `status`, `shipping_charges`, `vat`, `cst`, `service_tax`) VALUES
(18, '2015/0007', 'test88', '09/10/2015', 'Asteria88', 7, 13, 1, '47', '2100', '80', '900'),
(19, '2015/0010', '777', '08/10/2015', 'Asteria', 7, 13, 1, '8', '7', '5', '6'),
(20, '2015/0011', '99', '09/10/2015', 'Asteria', 7, 16, 1, '47', '2100', '88', '99'),
(21, '2015/0012', '99', '09/10/2015', 'Asteria', 7, 16, 0, '47', '2100', '88', '99'),
(22, '2015/0013', '88', '09/10/2015', 'Asteria', 8, 13, 1, '8', '9', '7', '5'),
(24, '2015/0015', '99', '14/10/2015', 'Asteria', 7, 16, 0, '47', '2100', '88', '99'),
(27, '2015/0018', '87tcc', '19/10/2015', 'Asteria', 6, 13, 1, '4', '8', '9', '7');

-- --------------------------------------------------------

--
-- Table structure for table `sales_lineitem`
--

CREATE TABLE IF NOT EXISTS `sales_lineitem` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_code` int(50) NOT NULL,
  `qty` int(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `unit_price` varchar(150) NOT NULL,
  `sales_id` int(50) NOT NULL,
  `project_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `sales_lineitem`
--

INSERT INTO `sales_lineitem` (`id`, `item_code`, `qty`, `currency`, `unit_price`, `sales_id`, `project_id`) VALUES
(15, 2, 1, '', '9', 18, 3),
(32, 3, 7, '', '10', 19, 3),
(33, 3, 90, '', '100', 18, 1),
(47, 2, 99, '', '10', 18, 2),
(48, 2, 9, '', '9', 20, 3),
(49, 2, 9, '', '9', 20, 4),
(50, 2, 9, '', '9', 21, 1),
(51, 2, 9, '', '9', 21, 2),
(52, 2, 99, '', '80', 22, 3),
(53, 3, 10, '', '77', 24, 3),
(54, 4, 2, '', '82222', 24, 3),
(55, 5, 2, '', '77', 24, 3);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE IF NOT EXISTS `shipping_method` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`id`, `name`, `description`, `status`) VALUES
(13, 'Fedex', 'Fedex A/C # 636541966', '1'),
(16, 'UPS', 'UPS A/C # 0000F528A', '1');

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

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

CREATE TABLE IF NOT EXISTS `utilies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `utilies`
--

INSERT INTO `utilies` (`id`, `name`, `content`) VALUES
(1, 'shipping_address', 'Asteria Aerospace Private Limited\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\nBangalore, Karnataka, 560008\nTel: +91 80 40955058'),
(2, 'vendorpo', '2015/0013'),
(3, 'grn', '2015/0002'),
(4, 'so_serial', '2015/0015');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE IF NOT EXISTS `vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(20) NOT NULL,
  `vendor_address` varchar(120) NOT NULL,
  `vendor_country` varchar(20) NOT NULL,
  `contact_person` varchar(20) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `contact_email` varchar(20) NOT NULL,
  `pan_no` varchar(20) NOT NULL,
  `tin_no` varchar(20) NOT NULL,
  `vat_no` varchar(20) NOT NULL,
  `cst_no` varchar(20) NOT NULL,
  `st_no` varchar(20) NOT NULL,
  `bank_name` varchar(20) NOT NULL,
  `acc_name` varchar(20) NOT NULL,
  `bank_acc_no` varchar(20) NOT NULL,
  `bank_branch` varchar(20) NOT NULL,
  `bank_ifsc` varchar(20) NOT NULL,
  `mfg_code` varchar(10) NOT NULL,
  `status` int(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`, `vendor_address`, `vendor_country`, `contact_person`, `contact_phone`, `contact_email`, `pan_no`, `tin_no`, `vat_no`, `cst_no`, `st_no`, `bank_name`, `acc_name`, `bank_acc_no`, `bank_branch`, `bank_ifsc`, `mfg_code`, `status`, `date`) VALUES
(1, 'Asteria', 'ASTC', '2', 'Gautam', '9952045381', 'kumar@clematix.com', '1', '22', '333', '4444', '55555', 'Axis', '', '123456789', 'Hosur', '9994729807', 'KUMS', 1, '2015-10-05 05:43:21'),
(3, 'TVS', 'as', 'as', 'as', 'as', 'assadas', 'as', 'as', 'as', 'as', 'as', 'as', '', 'as', 'as', 'as', '', 1, '2015-09-03 12:24:36'),
(4, 'Titan', 'as', 'as', 'as', 'as', 'assadas', 'as', 'as', 'as', 'as', 'as', 'as', '', 'as', 'as', 'as', '', 1, '2015-09-03 12:24:35'),
(5, 'Ashok Leyland', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', 'ff', '', 'ff', 'ff', 'ff', '', 1, '2015-08-18 12:11:57'),
(6, 'Clematix', 'Shanthi Nagar', '101', 'Ram', '9994729807', 'ram@clematix.com', '1', '2', '3', '4', '5', '6', '', '7', '8', '9', '222', 1, '2015-08-19 11:50:23'),
(8, 'Kumar Industries', '42/1, Ramprabha Towers,\r\nDenkanikottai Main Road\r\nShanthi Nagar', '101', 'Kumar', '9952045381', 'kumar@clematix.com', 'K1', 'K2', 'K3', 'K4', 'K5', 'Axis', '', '995421322121231', 'Hosur', 'IKHMS5564', 'KUMS', 1, '2015-08-24 09:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `vendorpo`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `vendorpo`
--

INSERT INTO `vendorpo` (`id`, `vendor_name`, `vendor_po`, `department`, `shipping_address`, `shipping`, `delivery_date`, `quote`, `total_amt`, `shipping_charge`, `vat_charge`, `cst_charge`, `st_charge`, `addn_req`, `status`, `date`) VALUES
(1, 1, '2015/0007', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '16-10-2015', 'PO 1', '7000', '10', '10', '10', '10', 'PO 1', 1, '2015-10-14 11:28:39'),
(2, 1, '2015/0008', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 16, '27-10-2015', 'PO 2', '15000', '10', '10', '10', '10', 'PO 2', 1, '2015-10-14 11:28:42'),
(3, 0, '2015/0009', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 0, '', '', '', '', '', '', '', '', 0, '2015-10-16 07:03:17'),
(4, 0, '2015/0010', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 0, '', '', '', '', '', '', '', '', 0, '2015-10-16 07:03:47'),
(5, 0, '2015/0011', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 0, '', '', '', '', '', '', '', '', 0, '2015-10-16 07:04:05'),
(6, 0, '2015/0012', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 0, '', '', '', '', '', '', '', '', 0, '2015-10-16 07:12:03'),
(7, 1, '2015/0013', 'Ram', 'Asteria Aerospace Private Limited\r\n9/1, 2nd Floor, Cambridge Cross Rd, Ulsoor\r\nBangalore, Karnataka, 560008\r\nTel: +91 80 40955058', 13, '19-10-2015', 'A1', '288', '', '', '', '', '', 0, '2015-10-19 12:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `vendorpo_materials`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `vendorpo_materials`
--

INSERT INTO `vendorpo_materials` (`id`, `vendorpo_id`, `item`, `pdtid`, `desc`, `qty`, `uom`, `price`, `linetotal`, `pending`) VALUES
(1, 1, 1, '111', 'Test', 500, 'Bag', '10', '5000', 485),
(2, 1, 2, '211', 'BA', 200, 'Box', '10', '2000', 185),
(3, 2, 1, '111', 'Test', 1000, 'Bag', '5', '5000', 1000),
(4, 2, 2, '211', 'BA', 2000, 'Box', '5', '10000', 2000),
(5, 7, 1, '111', 'Test', 12, 'Box', '12', '144', 12),
(6, 7, 1, '111', 'Test', 12, 'Box', '12', '144', 12);

-- --------------------------------------------------------

--
-- Table structure for table `work_order`
--

CREATE TABLE IF NOT EXISTS `work_order` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `item_id` int(20) NOT NULL,
  `wo_no` varchar(150) NOT NULL,
  `so_id` int(50) NOT NULL,
  `so_line_item` int(50) NOT NULL,
  `status` int(10) NOT NULL,
  `date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `work_order`
--

INSERT INTO `work_order` (`id`, `item_id`, `wo_no`, `so_id`, `so_line_item`, `status`, `date`) VALUES
(63, 3, 'WO/2015/00063', 24, 53, 0, '14/Oct/2015'),
(64, 3, 'WO/2015/00064', 24, 53, 0, '14/Oct/2015'),
(65, 3, 'WO/2015/00065', 24, 53, 0, '14/Oct/2015'),
(66, 3, 'WO/2015/00066', 24, 53, 0, '14/Oct/2015'),
(67, 3, 'WO/2015/00067', 24, 53, 0, '14/Oct/2015'),
(68, 3, 'WO/2015/00068', 24, 53, 0, '14/Oct/2015'),
(69, 3, 'WO/2015/00069', 24, 53, 0, '14/Oct/2015'),
(70, 3, 'WO/2015/00070', 24, 53, 0, '14/Oct/2015');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

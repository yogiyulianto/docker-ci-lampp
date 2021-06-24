# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: ci_slice_v2
# Generation Time: 2020-03-29 06:52:46 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table com_email
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_email`;

CREATE TABLE `com_email` (
  `email_id` varchar(2) NOT NULL,
  `email_name` varchar(100) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `smtp_host` varchar(50) DEFAULT NULL,
  `smtp_port` varchar(5) DEFAULT NULL,
  `smtp_username` varchar(50) DEFAULT NULL,
  `smtp_password` varchar(50) DEFAULT NULL,
  `use_smtp` enum('1','0') DEFAULT '1',
  `use_authorization` enum('1','0') DEFAULT '1',
  `mdb` varchar(10) DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_email` WRITE;
/*!40000 ALTER TABLE `com_email` DISABLE KEYS */;

INSERT INTO `com_email` (`email_id`, `email_name`, `email_address`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `use_smtp`, `use_authorization`, `mdb`, `mdb_name`, `mdd`)
VALUES
	('01','[No Reply] Codeinaja Tools','codeinaja.dev@gmail.com','smtp.gmail.com','465','codeinaja.dev@gmail.com','amikom2019','1','1',NULL,NULL,NULL);

/*!40000 ALTER TABLE `com_email` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_group`;

CREATE TABLE `com_group` (
  `group_id` varchar(2) NOT NULL,
  `group_name` varchar(50) DEFAULT NULL,
  `group_desc` varchar(100) DEFAULT NULL,
  `mdb` varchar(10) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_group` WRITE;
/*!40000 ALTER TABLE `com_group` DISABLE KEYS */;

INSERT INTO `com_group` (`group_id`, `group_name`, `group_desc`, `mdb`, `mdd`, `mdb_name`)
VALUES
	('01','Developer','Group Programmer','1911130001','2020-03-28 11:03:49','admin'),
	('02','Users','User Aplikasi Codeinaja','1911130001','2020-03-28 11:03:25','admin');

/*!40000 ALTER TABLE `com_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_log`;

CREATE TABLE `com_log` (
  `log_id` varchar(50) NOT NULL DEFAULT '',
  `log_message` varchar(50) DEFAULT NULL,
  `action_type` varchar(2) DEFAULT NULL,
  `query_string` text,
  `url` text,
  `user_agent` text,
  `ip_address` varchar(50) DEFAULT NULL,
  `mdb` varchar(50) DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_log` WRITE;
/*!40000 ALTER TABLE `com_log` DISABLE KEYS */;

INSERT INTO `com_log` (`log_id`, `log_message`, `action_type`, `query_string`, `url`, `user_agent`, `ip_address`, `mdb`, `mdb_name`, `mdd`)
VALUES
	('1580041621004390465','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'1000000001\', `nav_title` = \'Activity Logs\', `nav_desc` = \'Activity Logs\', `nav_url` = \'settings/activity_logs\', `nav_no` = \'2\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-26 13:27:01\'\nWHERE `nav_id` = \'1000000008\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-26 13:27:01'),
	('1580041643094310654','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'1000000001\', `nav_title` = \'Profile\', `nav_desc` = \'Profil Halaman\', `nav_url` = \'settings/profile\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'fa fa-user\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-26 13:27:23\'\nWHERE `nav_id` = \'1000000002\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-26 13:27:23'),
	('1580041861074750470','create com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000012\', \'0\', \'Settings\', \'Settings\', \'settings\', \'1\', \'1\', \'0\', \'fa fa-history\', \'1911130001\', \'admin\', \'2020-01-26 13:31:01\')','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-26 13:31:01'),
	('1580041869076714983','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'1000000012\', `nav_title` = \'Profile\', `nav_desc` = \'Profil Halaman\', `nav_url` = \'settings/profile\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'fa fa-user\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-26 13:31:09\'\nWHERE `nav_id` = \'1000000002\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-26 13:31:09'),
	('1580041876088258018','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'1000000012\', `nav_title` = \'Activity Logs\', `nav_desc` = \'Activity Logs\', `nav_url` = \'settings/activity_logs\', `nav_no` = \'2\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-26 13:31:16\'\nWHERE `nav_id` = \'1000000008\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-26 13:31:16'),
	('1580093537014692290','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'1000000012\', `nav_title` = \'Activity Logs\', `nav_desc` = \'Activity Logs\', `nav_url` = \'settings/activity_log\', `nav_no` = \'2\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'fa fa-sync\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-27 03:52:17\'\nWHERE `nav_id` = \'1000000008\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-27 03:52:17'),
	('1580097024099353933','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'0\', `nav_title` = \'Settings\', `nav_desc` = \'Settings\', `nav_url` = \'settings\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'fa fa-history\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-27 04:50:24\'\nWHERE `nav_id` = \'1000000012\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-27 04:50:24'),
	('1580097168009405628','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'0\', `nav_title` = \'Settings\', `nav_desc` = \'Settings\', `nav_url` = \'settings\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'0\', `nav_icon` = \'fa fa-history\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-27 04:52:48\'\nWHERE `nav_id` = \'1000000012\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-27 04:52:48'),
	('1580097174085624514','update com_menu','U','UPDATE `com_menu` SET `parent_id` = \'0\', `nav_title` = \'Settings\', `nav_desc` = \'Settings\', `nav_url` = \'settings\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'0\', `nav_icon` = \'fa fa-history\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-01-27 04:52:54\'\nWHERE `nav_id` = \'1000000012\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-01-27 04:52:54'),
	('1580804153035073633','create com_group','C','INSERT INTO `com_group` (`group_id`, `group_name`, `group_desc`, `mdb`, `mdb_name`, `mdd`) VALUES (\'03\', \'qwe\', \'123\', \'1911160001\', \'aditya5660\', \'2020-02-04 09:15:53\')','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-04 09:15:53'),
	('1580804161076590439','delete com_group','D','DELETE FROM `com_group`\nWHERE `group_id` = \'03\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-04 09:16:01'),
	('1580804399015816615','update com_group','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-04 09:19:59\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-04 09:19:59'),
	('1580962137003924622','create com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000013\', \'0\', \'Control Panel\', \'Control Panel\', \'systems/control_panel\', \'2\', \'1\', \'1\', \'fa fa-server\', \'1911130001\', \'admin\', \'2020-02-06 05:08:57\')','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 05:08:57'),
	('1580985925054219978','Updated com_role','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Karyawan\', `role_desc` = \'\', `default_page` = \'welcome/dashboard_karyawan\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 11:45:25\'\nWHERE `role_id` = \'02002\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:45:25'),
	('1580986392034456568','Updated com_group(Array)','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 11:53:12\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:53:12'),
	('1580986421092235082','Updated com_group(Array)','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 11:53:41\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:53:41'),
	('1580986426010106426','Updated com_group(Array)','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 11:53:46\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:53:46'),
	('1580986520029470049','Updated com_group with ID 02','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 11:55:20\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:55:20'),
	('1580986641039754072','Deleted com_role with ID 02002','D','DELETE FROM `com_role`\nWHERE `role_id` = \'02002\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 11:57:21'),
	('1580989492044057356','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000014\', \'1000000007\', \'User List\', \'User List\', \'systems/users\', \'1\', \'1\', \'1\', \'\', \'1911130001\', \'admin\', \'2020-02-06 12:44:52\')','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 12:44:52'),
	('1580989550021781841','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000015\', \'0\', \'Activity Logs\', \'Activity Logs for User\', \'systems/users/activity_logs\', \'2\', \'1\', \'1\', \'\', \'1911130001\', \'admin\', \'2020-02-06 12:45:50\')','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 12:45:50'),
	('1580989559053232750','Updated com_menu with ID 1000000014','U','UPDATE `com_menu` SET `parent_id` = \'1000000007\', `nav_title` = \'User List\', `nav_desc` = \'User List\', `nav_url` = \'systems/users/users\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 12:45:59\'\nWHERE `nav_id` = \'1000000014\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 12:45:59'),
	('1580989600046562558','Updated com_menu with ID 1000000015','U','UPDATE `com_menu` SET `parent_id` = \'1000000007\', `nav_title` = \'Activity Logs\', `nav_desc` = \'Activity Logs for User\', `nav_url` = \'systems/users/activity_logs\', `nav_no` = \'2\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-06 12:46:40\'\nWHERE `nav_id` = \'1000000015\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911130001','admin','2020-02-06 12:46:40'),
	('1581057567080865658','Updated com_role with ID 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 07:39:27\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-07 07:39:27'),
	('1581058258035936066','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 07:50:58\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-07 07:50:58'),
	('1581058348022689115','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 07:52:28\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-07 07:52:28'),
	('1581058370009434176','Updated com_role with Array 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 07:52:50\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-07 07:52:50'),
	('1581058448050399373','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 07:54:08\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-purple/',NULL,'::1','1911160001','aditya5660','2020-02-07 07:54:08'),
	('1581059348012336194','Updated com_role with role_id 01001','U','UPDATE `com_role` SET `group_id` = \'01\', `role_name` = \'Developer\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-02-07 08:09:08\'\nWHERE `role_id` = \'01001\'','http://localhost/CISLICE/ci-slice-purple/','Chrome 79.0.3945.130 Mac OS X','::1','1911160001','aditya5660','2020-02-07 08:09:08'),
	('1581588810056855518','Updated com_menu with nav_id 1000000007','U','UPDATE `com_menu` SET `parent_id` = \'0\', `nav_title` = \'User Management\', `nav_desc` = \'User Management\', `nav_url` = \'systems/users\', `nav_no` = \'6\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'fa fa-user-alt\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-13 11:13:30\'\nWHERE `nav_id` = \'1000000007\'','http://localhost/CISLICE/ci-slice-purple/','Chrome 80.0.3987.100 Mac OS X','::1','1911130001','admin','2020-02-13 11:13:30'),
	('1581588882033852833','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000016\', \'0\', \'System Settings\', \'System Settings\', \'#\', \'2\', \'1\', \'1\', \'fa fa-cogs\', \'1911130001\', \'admin\', \'2020-02-13 11:14:42\')','http://localhost/CISLICE/ci-slice-purple/','Chrome 80.0.3987.100 Mac OS X','::1','1911130001','admin','2020-02-13 11:14:42'),
	('1582731312054487687','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-02-26 16:35:12\'\nWHERE `group_id` = \'01\'','http://localhost/CISLICE/ci-slice-purple/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-02-26 16:35:12'),
	('1582794761063081575','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000017\', \'1000000016\', \'App Portal\', \'Portal\', \'systems/portal\', \'0\', \'1\', \'1\', \'fa fa-dekstop\', \'1911160001\', \'aditya5660\', \'2020-02-27 10:12:41\')','http://localhost/CISLICE/ci-slice-purple/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-02-27 10:12:41'),
	('1582794873005357072','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000018\', \'1000000016\', \'Email Settings\', \'Email Settings\', \'systems/email\', \'7\', \'1\', \'1\', \'fa fa-mail\', \'1911160001\', \'aditya5660\', \'2020-02-27 10:14:33\')','http://localhost/CISLICE/ci-slice-purple/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-02-27 10:14:33'),
	('1583131327048368282','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-02 07:42:07\'\nWHERE `group_id` = \'01\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Safari\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-02 07:42:07'),
	('1583465713005020243','Created com_group','C','INSERT INTO `com_group` (`group_id`, `group_name`, `group_desc`, `mdb`, `mdb_name`, `mdd`) VALUES (\'03\', \'123\', \'User Aplikasi CARIDOKTER\', \'1911160001\', \'aditya5660\', \'2020-03-06 04:35:12\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 04:35:13'),
	('1583484728045065616','Created com_group','C','INSERT INTO `com_group` (`group_id`, `group_name`, `group_desc`, `mdb`, `mdb_name`, `mdd`) VALUES (\'04\', \'Programmer\', \'Programmer\', \'1911160001\', \'aditya5660\', \'2020-03-06 09:52:08\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 09:52:08'),
	('1583516663008348594','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-06 18:44:22\'\nWHERE `group_id` = \'01\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 18:44:23'),
	('1583516685008160086','Created com_group','C','INSERT INTO `com_group` (`group_id`, `group_name`, `group_desc`, `mdb`, `mdb_name`, `mdd`) VALUES (\'05\', \'q\', \'123qweasd\', \'1911160001\', \'aditya5660\', \'2020-03-06 18:44:45\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 18:44:45'),
	('1583517252075932722','Deleted com_group with group_id 05','D','DELETE FROM `com_group`\nWHERE `group_id` = \'05\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 18:54:12'),
	('1583517461011796319','Deleted com_group with group_id 03','D','DELETE FROM `com_group`\nWHERE `group_id` = \'03\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 18:57:41'),
	('1583517465097978569','Deleted com_group with group_id 04','D','DELETE FROM `com_group`\nWHERE `group_id` = \'04\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-06 18:57:45'),
	('1583519083045976651','Created com_role','C','INSERT INTO `com_role` (`group_id`, `role_id`, `role_name`, `role_desc`, `default_page`, `mdb`, `mdb_name`, `mdd`) VALUES (\'01\', \'01002\', \'Adminss\', \'ABC\', \'lk\', \'1911160001\', \'aditya5660\', \'2020-03-06 19:24:43\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Safari\",\"platform\":\"iOS\"}','::1','1911160001','aditya5660','2020-03-06 19:24:43'),
	('1583519295096125048','Deleted com_role with role_id 01002','D','DELETE FROM `com_role`\nWHERE `role_id` = \'01002\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Safari\",\"platform\":\"iOS\"}','::1','1911160001','aditya5660','2020-03-06 19:28:15'),
	('1583546152084355143','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-07 02:55:52\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-07 02:55:52'),
	('1583603461022134219','Created com_portal','C','INSERT INTO `com_portal` (`portal_id`, `portal_nm`, `portal_title`, `portal_icon`, `site_title`, `site_desc`, `meta_desc`, `meta_keyword`, `mdb`, `mdb_name`, `mdd`) VALUES (\'30\', \'Project Management\', \'Project Management\', \'la la-briefcase\', \'\', \'\', \'\', \'\', \'1911160001\', \'aditya5660\', \'2020-03-07 18:51:01\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Android\"}','::1','1911160001','aditya5660','2020-03-07 18:51:01'),
	('1583604039033866764','Deleted com_portal with portal_id 30','D','DELETE FROM `com_portal`\nWHERE `portal_id` = \'30\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Android\"}','::1','1911160001','aditya5660','2020-03-07 19:00:39'),
	('1583604045059983568','Updated com_portal with portal_id 20','U','UPDATE `com_portal` SET `portal_nm` = \'HRM\', `portal_title` = \'HR\', `portal_icon` = \'la la-sitemap\', `site_title` = \'\', `site_desc` = \'\', `meta_desc` = \'\', `meta_keyword` = \'\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-07 19:00:45\'\nWHERE `portal_id` = \'20\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Android\"}','::1','1911160001','aditya5660','2020-03-07 19:00:45'),
	('1583637165039402965','Updated com_menu with nav_id 1000000010','U','UPDATE `com_menu` SET `portal_id` = \'20\', `parent_id` = \'0\', `nav_title` = \'Dashboard\', `nav_desc` = \'Dashboard Karyawan\', `nav_url` = \'home/welcome_karyawan\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'flaticon-home-2\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-08 04:12:45\'\nWHERE `nav_id` = \'1000000010\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:12:45'),
	('1583637198063526876','Updated com_menu with nav_id 1000000010','U','UPDATE `com_menu` SET `portal_id` = \'20\', `parent_id` = \'0\', `nav_title` = \'Dashboard\', `nav_desc` = \'Dashboard Karyawan\', `nav_url` = \'home/welcome_karyawan\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'flaticon-home-2\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-08 04:13:18\'\nWHERE `nav_id` = \'1000000010\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:13:18'),
	('1583637205052617192','Updated com_menu with nav_id 1000000010','U','UPDATE `com_menu` SET `portal_id` = \'20\', `parent_id` = \'0\', `nav_title` = \'Dashboard\', `nav_desc` = \'Dashboard Karyawan\', `nav_url` = \'home/welcome_karyawan\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'flaticon-home-2\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-08 04:13:25\'\nWHERE `nav_id` = \'1000000010\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:13:25'),
	('1583637216050478417','Updated com_menu with nav_id 1000000010','U','UPDATE `com_menu` SET `portal_id` = \'20\', `parent_id` = \'0\', `nav_title` = \'Dashboard\', `nav_desc` = \'Dashboard Karyawan\', `nav_url` = \'home/welcome_karyawan\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'1\', `nav_icon` = \'flaticon-home-2\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-08 04:13:36\'\nWHERE `nav_id` = \'1000000010\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:13:36'),
	('1583637333026701017','Deleted com_menu with nav_id 1000000011','D','DELETE FROM `com_menu`\nWHERE `nav_id` = \'1000000011\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:15:33'),
	('1583637354013682957','Deleted com_menu with nav_id 1000000010','D','DELETE FROM `com_menu`\nWHERE `nav_id` = \'1000000010\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:15:54'),
	('1583637585020413560','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `portal_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000019\', \'20\', \'20\', \'Transactions\', \'Pasien Saya\', \'settings/activity_log\', \'5\', \'1\', \'1\', \'fa fa-database\', \'1911160001\', \'aditya5660\', \'2020-03-08 04:19:45\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:19:45'),
	('1583637687064269593','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `portal_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000020\', \'20\', \'20\', \'Transactions\', \'Pasien Saya\', \'settings/activity_log\', \'5\', \'1\', \'1\', \'fa fa-database\', \'1911160001\', \'aditya5660\', \'2020-03-08 04:21:27\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 04:21:27'),
	('1583640767030781777','Created com_menu','C','INSERT INTO `com_menu` (`nav_id`, `parent_id`, `portal_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`) VALUES (\'1000000021\', \'20\', \'20\', \'Dashboard\', \'Pasien Saya\', \'settings\', \'5\', \'1\', \'1\', \'fa fa-database\', \'1911160001\', \'aditya5660\', \'2020-03-08 05:12:47\')','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 05:12:47'),
	('1583640863041095584','Updated com_menu with nav_id 1000000012','U','UPDATE `com_menu` SET `portal_id` = \'10\', `parent_id` = \'0\', `nav_title` = \'Settings\', `nav_desc` = \'Settings\', `nav_url` = \'settings\', `nav_no` = \'1\', `active_st` = \'1\', `display_st` = \'0\', `nav_icon` = \'la la-history\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-08 05:14:23\'\nWHERE `nav_id` = \'1000000012\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 05:14:23'),
	('1583641271053826842','Deleted com_menu with nav_id 1000000021','D','DELETE FROM `com_menu`\nWHERE `nav_id` = \'1000000021\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 05:21:11'),
	('1583641329057448550','Deleted com_menu with nav_id 1000000020','D','DELETE FROM `com_menu`\nWHERE `nav_id` = \'1000000020\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-08 05:22:09'),
	('1583743608013116176','Updated com_role with role_id 01001','U','UPDATE `com_role` SET `group_id` = \'01\', `role_name` = \'Developer\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 09:46:48\'\nWHERE `role_id` = \'01001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 09:46:48'),
	('1583744245073966148','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 09:57:25\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 09:57:25'),
	('1583744259028157474','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 09:57:39\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 09:57:39'),
	('1583744598069957785','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'Users\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:03:18\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:03:18'),
	('1583746627007034351','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:37:07\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:37:07'),
	('1583746683017092526','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:38:03\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:38:03'),
	('1583747004089853340','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:43:24\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:43:24'),
	('1583747099030730555','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:44:59\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:44:59'),
	('1583747103017088839','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:45:03\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:45:03'),
	('1583747138063976173','Updated com_role with role_id 02001','U','UPDATE `com_role` SET `group_id` = \'02\', `role_name` = \'Users\', `role_desc` = \'\', `default_page` = \'home/welcome_developer/\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-09 10:45:38\'\nWHERE `role_id` = \'02001\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-09 10:45:38'),
	('1583896493042544587','Updated com_group with group_id 02','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911160001\', `mdb_name` = \'aditya5660\', `mdd` = \'2020-03-11 04:14:53\'\nWHERE `group_id` = \'02\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911160001','aditya5660','2020-03-11 04:14:53'),
	('1583986768032507898','Updated com_portal with portal_id 20','U','UPDATE `com_portal` SET `portal_nm` = \'HRM\', `portal_title` = \'HR\', `portal_icon` = \'la la-sitemap\', `site_title` = \'sliceHR\', `site_desc` = \'sliceHR\', `meta_desc` = \'\', `meta_keyword` = \'\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-12 05:19:27\'\nWHERE `portal_id` = \'20\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-12 05:19:28'),
	('1583986775032579916','Updated com_portal with portal_id 10','U','UPDATE `com_portal` SET `portal_nm` = \'System Settings\', `portal_title` = \'Systems\', `portal_icon` = \'la la-cogs\', `site_title` = \'Cislice\', `site_desc` = \'Codeinaja Systems Settings\', `meta_desc` = \'Codeinaja Systems Settings\', `meta_keyword` = \'Codeinaja Systems Settings\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-12 05:19:35\'\nWHERE `portal_id` = \'10\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-12 05:19:35'),
	('1584601481080980269','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-19 08:04:41\'\nWHERE `group_id` = \'01\'','http://localhost/CISLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-19 08:04:41'),
	('1585388080082464638','Created com_portal','C','INSERT INTO `com_portal` (`portal_id`, `portal_nm`, `portal_title`, `portal_icon`, `site_title`, `site_desc`, `meta_desc`, `meta_keyword`, `mdb`, `mdb_name`, `mdd`) VALUES (\'30\', \'Project Management\', \'Project Management\', \'la la-briefcase\', \'sliceHR\', \'sliceHR\', \'\', \'\', \'1911130001\', \'admin\', \'2020-03-28 10:34:40\')','http://localhost/ciSLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-28 10:34:40'),
	('1585389770059102576','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-28 11:02:50\'\nWHERE `group_id` = \'01\'','http://localhost/ciSLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-28 11:02:50'),
	('1585389799097728623','Updated com_group with group_id 02','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-28 11:03:19\'\nWHERE `group_id` = \'02\'','http://localhost/ciSLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-28 11:03:19'),
	('1585389805056400924','Updated com_group with group_id 02','U','UPDATE `com_group` SET `group_name` = \'Users\', `group_desc` = \'User Aplikasi Codeinaja\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-28 11:03:25\'\nWHERE `group_id` = \'02\'','http://localhost/ciSLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-28 11:03:25'),
	('1585389829035763747','Updated com_group with group_id 01','U','UPDATE `com_group` SET `group_name` = \'Developer\', `group_desc` = \'Group Programmer\', `mdb` = \'1911130001\', `mdb_name` = \'admin\', `mdd` = \'2020-03-28 11:03:49\'\nWHERE `group_id` = \'01\'','http://localhost/ciSLICE/ci-slice-v2/','{\"ip\":\"::1\",\"browser\":\"Chrome\",\"platform\":\"Mac OS X\"}','::1','1911130001','admin','2020-03-28 11:03:49');

/*!40000 ALTER TABLE `com_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_menu`;

CREATE TABLE `com_menu` (
  `nav_id` varchar(11) NOT NULL DEFAULT '',
  `portal_id` varchar(2) DEFAULT '',
  `parent_id` varchar(10) DEFAULT NULL,
  `nav_title` varchar(50) DEFAULT NULL,
  `nav_desc` varchar(100) DEFAULT NULL,
  `nav_url` varchar(100) DEFAULT NULL,
  `nav_no` int(11) unsigned DEFAULT NULL,
  `active_st` enum('1','0') DEFAULT '1',
  `display_st` enum('1','0') DEFAULT '1',
  `nav_icon` varchar(50) DEFAULT NULL,
  `mdb` varchar(10) DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`nav_id`),
  KEY `portal_id` (`portal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_menu` WRITE;
/*!40000 ALTER TABLE `com_menu` DISABLE KEYS */;

INSERT INTO `com_menu` (`nav_id`, `portal_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `active_st`, `display_st`, `nav_icon`, `mdb`, `mdb_name`, `mdd`)
VALUES
	('1000000001','10','0','Dashboard','Dashboard','home/welcome_developer',91,'1','1','fas la-home','1911130001','admin','2019-12-12 07:35:00'),
	('1000000002','10','1000000012','Profile','Profil Halaman','settings/profile',1,'1','1','fas fa-users','1911130001','admin','2020-01-26 13:31:09'),
	('1000000004','10','1000000016','Groups','Groups','systems/groups',3,'1','1','fas fa-users','1911160001','aditya5660','2019-11-21 09:54:50'),
	('1000000005','10','1000000016','Roles','Roles','systems/roles',4,'1','1','fas fa-user-cog',NULL,NULL,'2019-11-20 07:55:23'),
	('1000000006','10','1000000016','Navigation','Navigation','systems/menu',5,'1','1','flaticon-list-2',NULL,NULL,'2019-11-20 07:56:35'),
	('1000000007','10','0','User Management','User Management','systems/users',94,'1','1','fas la-users','1911130001','admin','2020-02-13 11:13:30'),
	('1000000008','10','1000000012','Activity Logs','Activity Logs','settings/activity_log',2,'1','1','flaticon-refresh','1911130001','admin','2020-01-27 03:52:17'),
	('1000000009','10','1000000016','Permissions','Permissions','systems/permissions',6,'1','1','flaticon-lock','1911160001','aditya5660','2019-11-21 11:06:35'),
	('1000000012','10','0','Settings','Settings','settings',1,'1','0','fas la-history','1911160001','aditya5660','2020-03-08 05:14:23'),
	('1000000013','10','0','Control Panel','Control Panel','systems/control_panel',92,'1','1','fas la-server','1911130001','admin','2020-02-06 05:08:57'),
	('1000000014','10','1000000007','User List','User List','systems/users/lists',1,'1','1','','1911130001','admin','2020-02-06 12:45:59'),
	('1000000015','10','1000000007','Activity Logs','Activity Logs for User','systems/users/activity',2,'1','1','','1911130001','admin','2020-02-06 12:46:40'),
	('1000000016','10','0','System Settings','System Settings','#',93,'1','1','fas la-cogs','1911130001','admin','2020-02-13 11:14:42'),
	('1000000017','10','1000000016','App Portal','Portal','systems/portal',0,'1','1','flaticon-imac','1911160001','aditya5660','2020-02-27 10:12:41'),
	('1000000018','10','1000000016','Email Settings','Email Settings','systems/email',7,'1','1','flaticon-email','1911160001','aditya5660','2020-02-27 10:14:33'),
	('1000000019','20','0','Transactions','Pasien Saya','settings/activity_log',5,'1','1','fa fa-database','1911160001','aditya5660','2020-03-08 04:19:45');

/*!40000 ALTER TABLE `com_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_notification
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_notification`;

CREATE TABLE `com_notification` (
  `notification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `notification_value` int(11) DEFAULT NULL,
  `mdd` int(11) DEFAULT NULL,
  `mdb` int(11) DEFAULT NULL,
  `mdb_name` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table com_portal
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_portal`;

CREATE TABLE `com_portal` (
  `portal_id` varchar(2) NOT NULL,
  `portal_nm` varchar(50) DEFAULT NULL,
  `portal_title` varchar(50) DEFAULT NULL,
  `portal_icon` varchar(100) DEFAULT NULL,
  `portal_logo` varchar(100) DEFAULT NULL,
  `site_title` varchar(100) DEFAULT NULL,
  `site_desc` varchar(100) DEFAULT NULL,
  `meta_desc` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `mdb` varchar(11) DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`portal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_portal` WRITE;
/*!40000 ALTER TABLE `com_portal` DISABLE KEYS */;

INSERT INTO `com_portal` (`portal_id`, `portal_nm`, `portal_title`, `portal_icon`, `portal_logo`, `site_title`, `site_desc`, `meta_desc`, `meta_keyword`, `mdb`, `mdb_name`, `mdd`)
VALUES
	('10','System Settings','Systems','las la-cogs',NULL,'Cislice','Codeinaja Systems Settings','Codeinaja Systems Settings','Codeinaja Systems Settings','1911130001','admin','2020-03-12 05:19:35'),
	('20','HRM','HR','fa fa-sitemap',NULL,'sliceHR','sliceHR','','','1911130001','admin','2020-03-12 05:19:27'),
	('30','Project Management','Project Management','la la-briefcase',NULL,'sliceHR','sliceHR','','','1911130001','admin','2020-03-28 10:34:40');

/*!40000 ALTER TABLE `com_portal` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_preferences`;

CREATE TABLE `com_preferences` (
  `pref_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pref_group` varchar(50) DEFAULT NULL,
  `pref_nm` varchar(50) DEFAULT NULL,
  `pref_label` varchar(50) DEFAULT NULL,
  `pref_value` text,
  `mdb` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`pref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_preferences` WRITE;
/*!40000 ALTER TABLE `com_preferences` DISABLE KEYS */;

INSERT INTO `com_preferences` (`pref_id`, `pref_group`, `pref_nm`, `pref_label`, `pref_value`, `mdb`, `mdd`)
VALUES
	(1,'logo','logo_codeinaja',NULL,'assets/images/logo.svg',NULL,NULL),
	(2,'logo_small','logo codeinaja small',NULL,'assets/images/logo_small.svg',NULL,NULL);

/*!40000 ALTER TABLE `com_preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_reset_pass
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_reset_pass`;

CREATE TABLE `com_reset_pass` (
  `data_id` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `request_st` enum('waiting','done') DEFAULT 'waiting',
  `response_by` varchar(10) DEFAULT NULL,
  `response_date` datetime DEFAULT NULL,
  `response_notes` varchar(100) DEFAULT NULL,
  `request_expired` datetime DEFAULT NULL,
  `request_key` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_reset_pass` WRITE;
/*!40000 ALTER TABLE `com_reset_pass` DISABLE KEYS */;

INSERT INTO `com_reset_pass` (`data_id`, `email`, `phone`, `full_name`, `jabatan`, `request_date`, `request_st`, `response_by`, `response_date`, `response_notes`, `request_expired`, `request_key`)
VALUES
	('157477063799','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2019-11-26 13:17:17','',NULL,NULL,NULL,NULL,'7JV4KE'),
	('157477078494','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2019-11-26 13:19:44','',NULL,NULL,NULL,NULL,'37MUS8'),
	('157586167311','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2019-12-09 04:21:13','',NULL,NULL,NULL,NULL,'ZTXD2M'),
	('157586190829','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2019-12-09 04:25:08','',NULL,NULL,NULL,NULL,'5BBHBJ'),
	('157586239372','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2019-12-09 04:33:13','done','BY EMAIL','2019-12-09 04:35:04',NULL,NULL,'METNZI'),
	('158541299751','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:29:57','waiting',NULL,NULL,NULL,NULL,'MXY5NL'),
	('158541301281','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:30:12','waiting',NULL,NULL,NULL,NULL,'AHWWNG'),
	('158541301458','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:30:14','waiting',NULL,NULL,NULL,NULL,'CCQ56R'),
	('158541305348','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:30:53','waiting',NULL,NULL,NULL,NULL,'9H515T'),
	('158541313183','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:32:11','waiting',NULL,NULL,NULL,NULL,'1JRCV8'),
	('158541319167','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:33:11','waiting',NULL,NULL,NULL,NULL,'NJEUTM'),
	('158541319934','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:33:19','waiting',NULL,NULL,NULL,NULL,'HBTL5T'),
	('158541323635','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:33:56','waiting',NULL,NULL,NULL,NULL,'F3556A'),
	('158541390774','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:45:07','waiting',NULL,NULL,NULL,NULL,'CGIM8Z'),
	('158541394238','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:45:42','waiting',NULL,NULL,NULL,NULL,'HEEGQ3'),
	('158541394908','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:45:49','waiting',NULL,NULL,NULL,NULL,'DRCZKN'),
	('158541397388','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:46:13','waiting',NULL,NULL,NULL,NULL,'K85YDL'),
	('158541399838','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:46:38','done','BY EMAIL','2020-03-28 17:48:44',NULL,NULL,'DFTXRP'),
	('158541437805','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:52:58','waiting',NULL,NULL,NULL,NULL,'S91H4C'),
	('158541439721','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:53:17','waiting',NULL,NULL,NULL,NULL,'T7M6TA'),
	('158541439857','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:53:18','waiting',NULL,NULL,NULL,NULL,'85XPJS'),
	('158541439973','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:53:19','waiting',NULL,NULL,NULL,NULL,'5E7ATI'),
	('158541444311','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:54:03','waiting',NULL,NULL,NULL,NULL,'QPAMTL'),
	('158541444733','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:54:07','waiting',NULL,NULL,NULL,NULL,'DS11J1'),
	('158541453117','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:55:31','waiting',NULL,NULL,NULL,NULL,'R25I45'),
	('158541455935','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:55:59','waiting',NULL,NULL,NULL,NULL,'EB6VJX'),
	('158541461922','aditya5660@gmail.com','085335376496','Aditya Putra S',NULL,'2020-03-28 17:56:59','waiting',NULL,NULL,NULL,NULL,'SMWNB3');

/*!40000 ALTER TABLE `com_reset_pass` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_role`;

CREATE TABLE `com_role` (
  `role_id` varchar(5) NOT NULL,
  `group_id` varchar(2) DEFAULT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `role_desc` varchar(100) DEFAULT NULL,
  `default_page` varchar(100) DEFAULT NULL,
  `mdb` varchar(50) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT '',
  PRIMARY KEY (`role_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `com_role_fk_1` FOREIGN KEY (`group_id`) REFERENCES `com_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_role` WRITE;
/*!40000 ALTER TABLE `com_role` DISABLE KEYS */;

INSERT INTO `com_role` (`role_id`, `group_id`, `role_name`, `role_desc`, `default_page`, `mdb`, `mdd`, `mdb_name`)
VALUES
	('01001','01','Developer','','home/welcome_developer/','1911160001','2020-03-09 09:46:48','aditya5660'),
	('02001','02','Users','','home/welcome_developer/','1911160001','2020-03-09 10:45:38','aditya5660');

/*!40000 ALTER TABLE `com_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_role_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_role_menu`;

CREATE TABLE `com_role_menu` (
  `role_id` varchar(5) NOT NULL,
  `nav_id` varchar(10) NOT NULL,
  `role_tp` varchar(4) NOT NULL DEFAULT '1111',
  PRIMARY KEY (`nav_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `com_role_menu_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `com_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `com_role_menu_ibfk_2` FOREIGN KEY (`nav_id`) REFERENCES `com_menu` (`nav_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_role_menu` WRITE;
/*!40000 ALTER TABLE `com_role_menu` DISABLE KEYS */;

INSERT INTO `com_role_menu` (`role_id`, `nav_id`, `role_tp`)
VALUES
	('01001','1000000001','1111'),
	('01001','1000000002','1111'),
	('01001','1000000004','1111'),
	('01001','1000000005','1111'),
	('01001','1000000006','1111'),
	('01001','1000000007','1111'),
	('01001','1000000008','1111'),
	('01001','1000000009','1111'),
	('01001','1000000012','1111'),
	('01001','1000000013','1111'),
	('01001','1000000014','1111'),
	('01001','1000000015','1111'),
	('01001','1000000016','1111'),
	('01001','1000000017','1111'),
	('01001','1000000018','1111');

/*!40000 ALTER TABLE `com_role_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_role_user`;

CREATE TABLE `com_role_user` (
  `user_id` varchar(10) NOT NULL,
  `role_id` varchar(5) NOT NULL,
  `role_default` enum('1','2') DEFAULT '2',
  `role_display` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `com_role_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `com_role_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `com_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_role_user` WRITE;
/*!40000 ALTER TABLE `com_role_user` DISABLE KEYS */;

INSERT INTO `com_role_user` (`user_id`, `role_id`, `role_default`, `role_display`)
VALUES
	('1911130001','01001','2','1'),
	('1911160001','01001','2','1');

/*!40000 ALTER TABLE `com_role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_user`;

CREATE TABLE `com_user` (
  `user_id` varchar(10) NOT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `user_alias` varchar(155) DEFAULT NULL,
  `user_key` varchar(50) DEFAULT NULL,
  `user_mail` varchar(50) DEFAULT NULL,
  `user_st` enum('1','0','2') DEFAULT NULL,
  `examiner_number` varchar(50) DEFAULT NULL COMMENT 'Medex - Nomor Penunjukan Penguji',
  `mdb` varchar(10) DEFAULT NULL,
  `mdd` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_user` WRITE;
/*!40000 ALTER TABLE `com_user` DISABLE KEYS */;

INSERT INTO `com_user` (`user_id`, `user_name`, `user_pass`, `user_alias`, `user_key`, `user_mail`, `user_st`, `examiner_number`, `mdb`, `mdd`)
VALUES
	('1911130001','admin','$2a$08$QzNm594gVtMNhmojxypNDOEKKFfsLesHU.82ffUivIi1DOWfN3MCi',NULL,'2282622326','admin@codeinaja.net','1',NULL,'1911130001','2020-03-12 08:47:04'),
	('1911160001','aditya5660','$2a$08$lzpVwS/4r3fb.D77UlUkRuvbv6PpV6d9mJ7wNX5YNMY8I68oC3e8.',NULL,'','aditya5660@gmail.com','1',NULL,'1911160001','2020-03-28 16:27:13');

/*!40000 ALTER TABLE `com_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_user_login
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_user_login`;

CREATE TABLE `com_user_login` (
  `user_id` varchar(10) NOT NULL,
  `login_date` datetime NOT NULL,
  `logout_date` datetime DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`login_date`),
  CONSTRAINT `com_user_login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_user_login` WRITE;
/*!40000 ALTER TABLE `com_user_login` DISABLE KEYS */;

INSERT INTO `com_user_login` (`user_id`, `login_date`, `logout_date`, `ip_address`)
VALUES
	('1911130001','2019-11-21 17:01:32','2019-11-21 23:01:37','::1'),
	('1911130001','2019-11-22 06:40:01','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:15:16','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:16:51','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:17:16','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:17:35','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:19:09','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:19:12','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:19:22','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:19:29','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:22:05','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:27:45','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:27:57','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:28:18','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:28:54','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:42:05','2019-11-22 14:42:44','::1'),
	('1911130001','2019-11-22 08:42:47',NULL,'::1'),
	('1911130001','2019-11-22 14:28:42',NULL,'::1'),
	('1911130001','2019-11-23 04:34:04','2019-11-23 11:18:50','::1'),
	('1911130001','2019-11-23 05:18:52',NULL,'::1'),
	('1911130001','2019-11-24 02:39:43','2019-11-24 09:10:49','::1'),
	('1911130001','2019-11-24 02:56:34','2019-11-24 09:10:49','::1'),
	('1911130001','2019-11-24 05:43:09',NULL,'::1'),
	('1911130001','2019-11-25 02:27:22',NULL,'::1'),
	('1911130001','2019-11-25 05:46:50',NULL,'::1'),
	('1911130001','2019-11-26 15:12:52',NULL,'::1'),
	('1911130001','2019-12-05 14:36:28','2019-12-05 20:40:47','::1'),
	('1911130001','2019-12-06 03:23:34','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 03:41:48','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 05:14:11','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 05:20:25','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 05:25:13','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 05:27:47','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 09:02:01','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 09:51:42','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 09:51:56','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 09:52:43','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 10:03:24','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 10:35:19','2019-12-06 16:36:00','::1'),
	('1911130001','2019-12-06 10:40:04',NULL,'::1'),
	('1911130001','2019-12-06 14:05:55',NULL,'::1'),
	('1911130001','2019-12-06 14:14:58',NULL,'::1'),
	('1911130001','2019-12-07 04:06:42',NULL,'::1'),
	('1911130001','2019-12-09 02:24:20','2019-12-09 13:27:09','::1'),
	('1911130001','2019-12-09 03:06:58','2019-12-09 13:27:09','::1'),
	('1911130001','2019-12-09 04:47:46','2019-12-09 13:27:09','::1'),
	('1911130001','2019-12-09 04:54:00','2019-12-09 13:27:09','::1'),
	('1911130001','2019-12-09 07:15:27','2019-12-09 13:27:09','::1'),
	('1911130001','2019-12-11 07:28:59','2019-12-11 14:12:47','::1'),
	('1911130001','2019-12-12 06:01:03','2019-12-12 16:43:57','::1'),
	('1911130001','2019-12-12 10:39:29','2019-12-12 16:43:57','::1'),
	('1911130001','2019-12-12 10:44:30',NULL,'::1'),
	('1911130001','2019-12-13 02:34:26','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 02:41:17','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 04:53:16','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 04:58:09','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 05:12:27','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 05:14:04','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 05:14:56','2019-12-13 11:15:52','::1'),
	('1911130001','2019-12-13 08:30:28',NULL,'::1'),
	('1911130001','2019-12-13 10:41:24',NULL,'::1'),
	('1911130001','2019-12-14 03:53:59','2019-12-14 14:37:18','::1'),
	('1911130001','2019-12-14 08:17:04','2019-12-14 14:37:18','::1'),
	('1911130001','2020-01-26 13:23:26','2020-01-26 19:29:06','::1'),
	('1911130001','2020-01-26 13:29:12',NULL,'::1'),
	('1911130001','2020-01-27 03:47:04','2020-01-27 10:19:23','::1'),
	('1911130001','2020-01-27 03:51:14','2020-01-27 10:19:23','::1'),
	('1911130001','2020-01-27 04:48:39',NULL,'::1'),
	('1911130001','2020-01-27 07:51:50',NULL,'::1'),
	('1911130001','2020-01-27 09:32:37',NULL,'::1'),
	('1911130001','2020-02-04 09:24:04','2020-02-04 15:46:17','::1'),
	('1911130001','2020-02-05 12:06:16','2020-02-05 18:06:35','::1'),
	('1911130001','2020-02-05 12:06:57',NULL,'::1'),
	('1911130001','2020-02-05 16:34:29',NULL,'::1'),
	('1911130001','2020-02-06 05:02:12','2020-02-06 20:43:37','::1'),
	('1911130001','2020-02-06 14:54:55',NULL,'::1'),
	('1911130001','2020-02-07 02:52:18',NULL,'::1'),
	('1911130001','2020-02-07 08:22:37',NULL,'::1'),
	('1911130001','2020-02-12 15:57:06',NULL,'::1'),
	('1911130001','2020-02-13 01:56:44','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 10:59:24','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 11:05:18','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 11:08:03','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 11:13:10','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 13:56:28','2020-02-13 19:56:30','::1'),
	('1911130001','2020-02-13 15:34:16',NULL,'::1'),
	('1911130001','2020-02-26 16:07:22',NULL,'::1'),
	('1911130001','2020-03-01 11:42:24','2020-03-01 19:52:55','::1'),
	('1911130001','2020-03-01 12:59:19','2020-03-01 19:52:55','::1'),
	('1911130001','2020-03-01 13:15:48','2020-03-01 19:52:55','::1'),
	('1911130001','2020-03-03 07:06:00',NULL,'::1'),
	('1911130001','2020-03-03 08:09:36',NULL,'::1'),
	('1911130001','2020-03-03 08:26:57',NULL,'::1'),
	('1911130001','2020-03-04 09:00:44','2020-03-04 18:26:23','::1'),
	('1911130001','2020-03-04 11:48:38','2020-03-04 18:26:23','::1'),
	('1911130001','2020-03-06 10:28:40',NULL,'::1'),
	('1911130001','2020-03-08 16:36:01',NULL,'::1'),
	('1911130001','2020-03-12 04:52:26',NULL,'::1'),
	('1911130001','2020-03-15 17:31:42',NULL,'::1'),
	('1911130001','2020-03-19 04:27:02','2020-03-19 13:54:05','::1'),
	('1911130001','2020-03-19 06:42:56','2020-03-19 13:54:05','::1'),
	('1911130001','2020-03-19 07:15:54','2020-03-19 13:54:05','::1'),
	('1911130001','2020-03-19 08:00:52',NULL,'::1'),
	('1911130001','2020-03-26 08:21:00',NULL,'::1'),
	('1911130001','2020-03-26 08:21:23',NULL,'::1'),
	('1911130001','2020-03-26 08:21:49',NULL,'::1'),
	('1911130001','2020-03-26 14:06:06',NULL,'::1'),
	('1911130001','2020-03-27 02:50:53',NULL,'::1'),
	('1911130001','2020-03-27 03:51:04',NULL,'::1'),
	('1911130001','2020-03-27 08:30:02',NULL,'::1'),
	('1911130001','2020-03-27 15:36:16',NULL,'::1'),
	('1911130001','2020-03-28 04:38:01','2020-03-28 23:58:10','::1'),
	('1911130001','2020-03-28 10:36:21','2020-03-28 23:58:10','::1'),
	('1911130001','2020-03-28 15:00:12','2020-03-28 23:58:10','::1'),
	('1911130001','2020-03-28 17:57:16','2020-03-28 23:58:10','::1'),
	('1911130001','2020-03-28 17:57:54','2020-03-28 23:58:10','::1'),
	('1911130001','2020-03-29 08:03:12','2020-03-29 13:03:19','::1'),
	('1911130001','2020-03-29 08:03:25',NULL,'::1'),
	('1911160001','2019-11-22 03:03:42','2019-11-22 14:13:53','::1'),
	('1911160001','2019-11-22 06:50:12','2019-11-22 14:13:53','::1'),
	('1911160001','2019-11-22 08:07:27','2019-11-22 14:13:53','::1'),
	('1911160001','2019-11-22 08:12:00','2019-11-22 14:13:53','::1'),
	('1911160001','2019-11-22 08:13:53','2019-11-22 14:13:53','::1'),
	('1911160001','2019-12-09 04:37:39','2019-12-09 10:42:33','::1'),
	('1911160001','2020-02-04 08:31:37','2020-02-04 15:23:55','::1'),
	('1911160001','2020-02-04 09:11:33','2020-02-04 15:23:55','::1'),
	('1911160001','2020-02-06 17:47:05',NULL,'::1'),
	('1911160001','2020-02-07 07:38:30','2020-02-07 14:22:27','::1'),
	('1911160001','2020-02-13 15:33:51','2020-02-13 21:34:11','::1'),
	('1911160001','2020-02-27 04:31:16',NULL,'::1'),
	('1911160001','2020-02-27 08:31:31',NULL,'::1'),
	('1911160001','2020-03-01 13:53:56','2020-03-01 20:38:47','::1'),
	('1911160001','2020-03-01 14:54:40',NULL,'::1'),
	('1911160001','2020-03-01 15:19:40',NULL,'::1'),
	('1911160001','2020-03-02 00:52:15','2020-03-02 08:38:44','::1'),
	('1911160001','2020-03-02 02:36:30','2020-03-02 08:38:44','::1'),
	('1911160001','2020-03-02 02:38:48',NULL,'::1'),
	('1911160001','2020-03-02 02:38:53',NULL,'::1'),
	('1911160001','2020-03-02 02:38:57',NULL,'::1'),
	('1911160001','2020-03-02 02:39:49',NULL,'::1'),
	('1911160001','2020-03-02 02:43:14',NULL,'::1'),
	('1911160001','2020-03-02 02:47:14',NULL,'::1'),
	('1911160001','2020-03-02 02:47:23',NULL,'::1'),
	('1911160001','2020-03-02 02:47:36',NULL,'::1'),
	('1911160001','2020-03-02 02:49:50',NULL,'::1'),
	('1911160001','2020-03-02 02:50:52',NULL,'::1'),
	('1911160001','2020-03-02 02:52:25',NULL,'::1'),
	('1911160001','2020-03-02 02:52:54',NULL,'::1'),
	('1911160001','2020-03-02 03:01:40',NULL,'::1'),
	('1911160001','2020-03-02 03:03:54',NULL,'::1'),
	('1911160001','2020-03-02 03:47:08',NULL,'::1'),
	('1911160001','2020-03-02 03:57:05',NULL,'::1'),
	('1911160001','2020-03-02 03:59:05',NULL,'::1'),
	('1911160001','2020-03-02 03:59:14',NULL,'::1'),
	('1911160001','2020-03-02 04:03:30',NULL,'::1'),
	('1911160001','2020-03-02 04:09:29',NULL,'::1'),
	('1911160001','2020-03-02 07:17:46',NULL,'::1'),
	('1911160001','2020-03-02 07:38:13',NULL,'::1'),
	('1911160001','2020-03-03 05:27:07',NULL,'::1'),
	('1911160001','2020-03-03 14:18:36',NULL,'::1'),
	('1911160001','2020-03-04 08:34:57','2020-03-04 15:00:37','::1'),
	('1911160001','2020-03-04 12:29:20',NULL,'::1'),
	('1911160001','2020-03-05 02:17:34',NULL,'::1'),
	('1911160001','2020-03-05 06:36:33',NULL,'fe80::14a6:4a09:9ad1:aa3a'),
	('1911160001','2020-03-05 11:43:12',NULL,'::1'),
	('1911160001','2020-03-05 16:15:47',NULL,'::1'),
	('1911160001','2020-03-06 02:44:25',NULL,'::1'),
	('1911160001','2020-03-06 11:04:59',NULL,'::1'),
	('1911160001','2020-03-06 15:44:39',NULL,'::1'),
	('1911160001','2020-03-06 18:38:10',NULL,'::1'),
	('1911160001','2020-03-07 02:09:16',NULL,'::1'),
	('1911160001','2020-03-07 14:17:30',NULL,'::1'),
	('1911160001','2020-03-07 18:33:02',NULL,'::1'),
	('1911160001','2020-03-08 03:53:59','2020-03-08 22:35:31','::1'),
	('1911160001','2020-03-08 05:49:24','2020-03-08 22:35:31','::1'),
	('1911160001','2020-03-08 12:52:32','2020-03-08 22:35:31','::1'),
	('1911160001','2020-03-08 16:04:00','2020-03-08 22:35:31','::1'),
	('1911160001','2020-03-08 16:36:59',NULL,'::1'),
	('1911160001','2020-03-09 09:46:21',NULL,'::1'),
	('1911160001','2020-03-09 11:34:11',NULL,'::1'),
	('1911160001','2020-03-09 15:44:33',NULL,'::1'),
	('1911160001','2020-03-10 05:46:37',NULL,'::1'),
	('1911160001','2020-03-10 14:48:40',NULL,'::1'),
	('1911160001','2020-03-11 04:11:33','2020-03-11 17:11:09','::1'),
	('1911160001','2020-03-11 10:49:37','2020-03-11 17:11:09','::1'),
	('1911160001','2020-03-11 11:11:48',NULL,'::1'),
	('1911160001','2020-03-28 14:26:34','2020-03-28 23:29:53','::1'),
	('1911160001','2020-03-28 15:48:12','2020-03-28 23:29:53','::1'),
	('1911160001','2020-03-28 17:01:34','2020-03-28 23:29:53','::1'),
	('1911160001','2020-03-28 17:26:59','2020-03-28 23:29:53','::1');

/*!40000 ALTER TABLE `com_user_login` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table com_user_super
# ------------------------------------------------------------

DROP TABLE IF EXISTS `com_user_super`;

CREATE TABLE `com_user_super` (
  `user_id` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `com_user_super_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `com_user_super` WRITE;
/*!40000 ALTER TABLE `com_user_super` DISABLE KEYS */;

INSERT INTO `com_user_super` (`user_id`)
VALUES
	('1911130001');

/*!40000 ALTER TABLE `com_user_super` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` char(10) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `address` text,
  `user_img` varchar(100) DEFAULT 'assets/images/users/default.png',
  `gender_st` enum('L','P') DEFAULT NULL,
  `phone` varchar(100) DEFAULT '',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`user_id`, `full_name`, `address`, `user_img`, `gender_st`, `phone`)
VALUES
	('1911130001','Administrator','Condong Catur','assets/images/users/1911130001_20200303103717.jpg','L','085335376496'),
	('1911160001','Aditya Putra S','-','assets/images/users/default.png','L','085335376496');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

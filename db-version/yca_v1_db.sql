-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2021 at 11:54 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yca_v1_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `apps_id` int(1) NOT NULL,
  `apps_name` varchar(50) DEFAULT NULL,
  `apps_logo` varchar(50) DEFAULT NULL,
  `apps_fav` varchar(50) DEFAULT NULL,
  `apps_bg` varchar(50) DEFAULT NULL,
  `apps_mark` varchar(255) DEFAULT NULL,
  `apps_migrate` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1: Active; 2: Non-Active '
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `adv_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `adv_register` datetime DEFAULT current_timestamp(),
  `adv_author` int(11) DEFAULT NULL,
  `adv_sts` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `category_id`, `adv_name`, `adv_register`, `adv_author`, `adv_sts`) VALUES
(27, 22, 'Iklan4', '2021-04-24 09:04:55', NULL, 1),
(28, 23, 'Banner1', '2021-04-24 11:46:48', 20212163, 1);

-- --------------------------------------------------------

--
-- Table structure for table `com_menu`
--

CREATE TABLE `com_menu` (
  `nav_id` int(11) NOT NULL,
  `portal_id` int(11) DEFAULT NULL,
  `parent_id` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `nav_title` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `nav_desc` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `nav_url` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `nav_no` int(11) UNSIGNED DEFAULT NULL,
  `nav_path` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `icon_id` int(11) DEFAULT NULL,
  `client_st` enum('1','0') CHARACTER SET latin1 DEFAULT '0',
  `active_st` enum('1','0') CHARACTER SET latin1 DEFAULT '1',
  `display_st` enum('1','0') CHARACTER SET latin1 DEFAULT '1',
  `mdb` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `mdb_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `mdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `com_menu`
--

INSERT INTO `com_menu` (`nav_id`, `portal_id`, `parent_id`, `nav_title`, `nav_desc`, `nav_url`, `nav_no`, `nav_path`, `icon_id`, `client_st`, `active_st`, `display_st`, `mdb`, `mdb_name`, `mdd`) VALUES
(2, 1, NULL, 'Dashboard', 'Dashboard Admin', 'dashboard', 1, '/admin/index', NULL, '0', '1', '1', NULL, NULL, NULL),
(3, 1, NULL, 'Master Data', 'Master Data', 'master', 2, '/admin/master', NULL, '0', '1', '1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `com_role`
--

CREATE TABLE `com_role` (
  `role_id` int(11) NOT NULL,
  `role_nm` varchar(50) DEFAULT NULL,
  `role_desc` text DEFAULT NULL,
  `mdb` varchar(25) DEFAULT NULL,
  `mdb_name` varchar(50) DEFAULT NULL,
  `mdd` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `com_role`
--

INSERT INTO `com_role` (`role_id`, `role_nm`, `role_desc`, `mdb`, `mdb_name`, `mdd`) VALUES
(1, 'Developer dan Admin', 'developer', NULL, NULL, NULL),
(2, 'User', 'User Mobile', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `com_role_menu`
--

CREATE TABLE `com_role_menu` (
  `role_id` varchar(5) NOT NULL,
  `nav_id` varchar(10) NOT NULL,
  `role_tp` varchar(4) NOT NULL DEFAULT '1111'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `com_role_menu`
--

INSERT INTO `com_role_menu` (`role_id`, `nav_id`, `role_tp`) VALUES
('1', '2', '1111'),
('1', '3', '1111');

-- --------------------------------------------------------

--
-- Table structure for table `com_user`
--

CREATE TABLE `com_user` (
  `user_id` int(25) NOT NULL,
  `role_id` int(11) NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `user_st` enum('1','0','2') CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `api_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `uplink` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `affiliate_kode` varchar(25) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL COMMENT 'Belum digunakan',
  `token` text CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `token_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `aktifasi_number` varchar(50) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `mdb` varchar(25) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `mdb_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `mdd` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `com_user`
--

INSERT INTO `com_user` (`user_id`, `role_id`, `nama`, `email`, `username`, `password`, `user_st`, `api_key`, `uplink`, `affiliate_kode`, `token`, `token_key`, `aktifasi_number`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `mdb`, `mdb_name`, `mdd`) VALUES
(202105195, 1, 'rahmadz@tuta.io', 'rahmadz@tuta.io', NULL, '$2b$10$JUSRf37mwD6S5AIiW0TxFuUgz.UulE7hwO46ZDJiGsNYEayQ8.hd.', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Bandung', '1992-03-02', 'Jalan kali ini aja', NULL, NULL, NULL),
(202106146, 2, 'user', 'user@tuta.io', NULL, '$2b$10$lCzDaBhwRXELUjFU9bPhI.5uuTthaocjTpkUoFEFn9d09eN1lD16W', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Yogyakarta', '1999-06-28', 'RingRoad Utara\r\nCondongcatur ctxx347', NULL, NULL, NULL),
(202106147, 2, 'test', 'yaelahferr@gmail.com', NULL, '$2b$10$QrDF.8XkuwQroEvuJeGhLeoL4fEokhdGZ0adDGvv9IdL6h/anqfOW', '1', NULL, NULL, NULL, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjIwMjEwNjE0NyIsImlhdCI6MTYyMzY0NjY3OCwiZXhwIjoxZSs0MX0.mbvNwu59gR91FrlSm93V4r2wjNVpsFQv1Sv77nMixbk', 'v5NbC1', '3lFWvxGwEBsxBNPWuPBR', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `log_id` int(4) NOT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `aksi` enum('Login','Logout') NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_category0`
--

CREATE TABLE `md_category0` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `cat_code` varchar(30) DEFAULT NULL,
  `cat_note` varchar(500) DEFAULT NULL,
  `cat_register` datetime DEFAULT current_timestamp(),
  `cat_author` int(11) DEFAULT NULL,
  `cat_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_category0`
--

INSERT INTO `md_category0` (`cat_id`, `cat_name`, `cat_code`, `cat_note`, `cat_register`, `cat_author`, `cat_sts`) VALUES
(13, 'Pulsa', 'Pl', 'Kategori Pulsa Indonesia', '2021-04-24 13:15:14', 202105195, 1),
(15, 'Paket Data', 'Pk ', 'Paket Data', '2021-04-24 13:38:33', 202105195, 1),
(16, 'Listrik', 'Lsi', 'Listrik', '2021-05-19 18:51:28', 202105195, 1),
(17, 'BPJS', 'BJ', 'BPJS', '2021-05-19 18:51:38', 202105195, 1);

-- --------------------------------------------------------

--
-- Table structure for table `md_category1_pdc0`
--

CREATE TABLE `md_category1_pdc0` (
  `pdc_id` int(11) NOT NULL,
  `subcat_id` int(11) DEFAULT NULL,
  `prov_id` int(11) DEFAULT NULL,
  `prof_id` int(11) DEFAULT NULL,
  `pdc_name` varchar(255) DEFAULT NULL,
  `pdc_note` varchar(255) DEFAULT NULL,
  `pdc_amount` double DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  `pdc_register` datetime DEFAULT current_timestamp(),
  `pdc_author` int(11) DEFAULT NULL,
  `pdc_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `md_category1_pdc0`
--

INSERT INTO `md_category1_pdc0` (`pdc_id`, `subcat_id`, `prov_id`, `prof_id`, `pdc_name`, `pdc_note`, `pdc_amount`, `doc_id`, `pdc_register`, `pdc_author`, `pdc_sts`) VALUES
(1, 3, 1, NULL, 'Pulsa Im3 10.000', NULL, 10000, NULL, '2021-05-06 03:07:37', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `md_category1_subkat0`
--

CREATE TABLE `md_category1_subkat0` (
  `subcat_id` int(11) NOT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `subcat_name` varchar(255) DEFAULT NULL,
  `subcat_note` varchar(255) DEFAULT NULL,
  `subcat_register` datetime DEFAULT current_timestamp(),
  `subcat_author` int(11) DEFAULT NULL,
  `subcat_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_category1_subkat0`
--

INSERT INTO `md_category1_subkat0` (`subcat_id`, `cat_id`, `subcat_name`, `subcat_note`, `subcat_register`, `subcat_author`, `subcat_sts`) VALUES
(1, 13, 'Pulsa Telkomsel', 'Telkomsel', '2021-04-24 14:53:51', NULL, 1),
(3, 13, 'Pulsa Indosat', 'Pulsa Indosat', '2021-04-24 23:34:55', 20212163, 1),
(4, 13, 'Pulsa Axis', 'Axis', '2021-04-24 23:36:51', 20212163, 0);

-- --------------------------------------------------------

--
-- Table structure for table `md_profit0`
--

CREATE TABLE `md_profit0` (
  `prof_id` int(11) NOT NULL,
  `prof_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `prof_desc` text CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `prof_start` double DEFAULT 0,
  `prof_end` double DEFAULT 0,
  `prof_profit` double DEFAULT 0,
  `prof_register` datetime DEFAULT current_timestamp(),
  `prof_author` int(11) DEFAULT NULL,
  `prof_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_provider0`
--

CREATE TABLE `md_provider0` (
  `prov_id` int(11) NOT NULL,
  `prov_code` varchar(30) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `prov_name` varchar(255) DEFAULT NULL,
  `prov_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `api_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `api_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `prov_register` datetime DEFAULT current_timestamp(),
  `prov_author` int(11) DEFAULT NULL,
  `prov_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `md_provider0`
--

INSERT INTO `md_provider0` (`prov_id`, `prov_code`, `prov_name`, `prov_url`, `api_key`, `api_id`, `prov_register`, `prov_author`, `prov_sts`) VALUES
(1, 'PMK009', 'Mobile Pulsa', 'https://mobilepulsa.com/', '21212', '1212', '2021-04-24 09:44:39', NULL, 0),
(5, 'Tiy', 'Tripay', 'Tripay.com', 'D0212', 'mx2129as2812sz', '2021-04-24 11:16:57', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mg_doc0`
--

CREATE TABLE `mg_doc0` (
  `doc_id` int(11) NOT NULL,
  `doc_reftbl` varchar(255) DEFAULT NULL,
  `doc_refid` int(11) DEFAULT NULL,
  `doc_title` varchar(255) DEFAULT NULL,
  `doc_url` varchar(255) DEFAULT NULL,
  `doc_note` text DEFAULT NULL,
  `doc_files` text DEFAULT NULL,
  `doc_register` datetime DEFAULT current_timestamp(),
  `doc_author` int(11) DEFAULT NULL,
  `doc_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mg_doc0`
--

INSERT INTO `mg_doc0` (`doc_id`, `doc_reftbl`, `doc_refid`, `doc_title`, `doc_url`, `doc_note`, `doc_files`, `doc_register`, `doc_author`, `doc_sts`) VALUES
(22, 'md_advertisement0', NULL, 'Banner Iklan', NULL, NULL, 'file-1619256021712.png', '2021-04-24 09:04:55', NULL, 1),
(23, 'md_advertisement0', 20212163, 'Banner Iklan', NULL, NULL, 'file-1619264808540.jpg', '2021-04-24 11:46:48', 20212163, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mg_payment0`
--

CREATE TABLE `mg_payment0` (
  `py_id` int(11) NOT NULL,
  `py_code` varchar(30) DEFAULT NULL,
  `user_id` int(25) NOT NULL,
  `py_reference` varchar(255) DEFAULT NULL,
  `pdc_id` int(11) DEFAULT NULL,
  `py_payment_method` varchar(255) DEFAULT NULL,
  `py_payment_name` varchar(255) DEFAULT NULL,
  `py_amount` varchar(255) DEFAULT NULL,
  `py_fee_merchant` varchar(255) DEFAULT NULL,
  `py_fee_customer` varchar(255) DEFAULT NULL,
  `py_total_fee` varchar(255) DEFAULT NULL,
  `py_amount_received` varchar(255) DEFAULT NULL,
  `py_checkout_url` varchar(255) DEFAULT NULL,
  `py_register` datetime DEFAULT current_timestamp(),
  `py_author` int(11) DEFAULT NULL,
  `py_sts` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mg_payment1_history`
--

CREATE TABLE `mg_payment1_history` (
  `pyh_id` int(11) NOT NULL,
  `py_id` int(11) DEFAULT NULL,
  `pyh_reference` varchar(255) DEFAULT NULL,
  `pyh_merchant_ref` varchar(255) DEFAULT NULL,
  `pyh_payment_method` varchar(255) DEFAULT NULL,
  `pyh_payment_method_code` varchar(255) DEFAULT NULL,
  `pyh_total_amount` int(11) DEFAULT NULL,
  `pyh_is_closed_payment` int(11) DEFAULT NULL,
  `pyh_paid_at` int(30) DEFAULT NULL,
  `pyh_register` datetime DEFAULT current_timestamp(),
  `pyh_author` int(11) DEFAULT NULL,
  `pyh_sts` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mg_trans0`
--

CREATE TABLE `mg_trans0` (
  `tr_id` int(11) NOT NULL,
  `user_id` int(25) DEFAULT NULL,
  `pdc_id` int(11) DEFAULT NULL,
  `prov_id` int(11) DEFAULT NULL,
  `tr_code` varchar(30) DEFAULT NULL,
  `tr_destination` varchar(255) DEFAULT NULL,
  `tr_amount` varchar(255) DEFAULT NULL,
  `tr_register` datetime DEFAULT current_timestamp(),
  `tr_author` int(11) DEFAULT NULL,
  `tr_sts` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`apps_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `doc_id` (`category_id`);

--
-- Indexes for table `com_menu`
--
ALTER TABLE `com_menu`
  ADD PRIMARY KEY (`nav_id`),
  ADD KEY `portal_id` (`portal_id`);

--
-- Indexes for table `com_role`
--
ALTER TABLE `com_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `com_role_menu`
--
ALTER TABLE `com_role_menu`
  ADD PRIMARY KEY (`nav_id`,`role_id`),
  ADD KEY `role_id` (`role_id`) USING BTREE;

--
-- Indexes for table `com_user`
--
ALTER TABLE `com_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `md_category0`
--
ALTER TABLE `md_category0`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `md_category1_pdc0`
--
ALTER TABLE `md_category1_pdc0`
  ADD PRIMARY KEY (`pdc_id`),
  ADD KEY `cat_id` (`subcat_id`),
  ADD KEY `prov_id` (`prov_id`),
  ADD KEY `prof_id` (`prof_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `md_category1_subkat0`
--
ALTER TABLE `md_category1_subkat0`
  ADD PRIMARY KEY (`subcat_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `md_profit0`
--
ALTER TABLE `md_profit0`
  ADD PRIMARY KEY (`prof_id`);

--
-- Indexes for table `md_provider0`
--
ALTER TABLE `md_provider0`
  ADD PRIMARY KEY (`prov_id`);

--
-- Indexes for table `mg_doc0`
--
ALTER TABLE `mg_doc0`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `mg_payment0`
--
ALTER TABLE `mg_payment0`
  ADD PRIMARY KEY (`py_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `pdc_id` (`pdc_id`);

--
-- Indexes for table `mg_payment1_history`
--
ALTER TABLE `mg_payment1_history`
  ADD PRIMARY KEY (`pyh_id`),
  ADD KEY `tr_id` (`py_id`);

--
-- Indexes for table `mg_trans0`
--
ALTER TABLE `mg_trans0`
  ADD PRIMARY KEY (`tr_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pdc_id` (`pdc_id`),
  ADD KEY `prov_id` (`prov_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `apps_id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `com_menu`
--
ALTER TABLE `com_menu`
  MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `com_role`
--
ALTER TABLE `com_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `log_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_category0`
--
ALTER TABLE `md_category0`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `md_category1_pdc0`
--
ALTER TABLE `md_category1_pdc0`
  MODIFY `pdc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `md_category1_subkat0`
--
ALTER TABLE `md_category1_subkat0`
  MODIFY `subcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `md_profit0`
--
ALTER TABLE `md_profit0`
  MODIFY `prof_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `md_provider0`
--
ALTER TABLE `md_provider0`
  MODIFY `prov_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mg_doc0`
--
ALTER TABLE `mg_doc0`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `mg_payment0`
--
ALTER TABLE `mg_payment0`
  MODIFY `py_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mg_payment1_history`
--
ALTER TABLE `mg_payment1_history`
  MODIFY `pyh_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mg_trans0`
--
ALTER TABLE `mg_trans0`
  MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `com_menu`
--
ALTER TABLE `com_menu`
  ADD CONSTRAINT `com_menu_ibfk_1` FOREIGN KEY (`portal_id`) REFERENCES `portal` (`portal_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `com_user`
--
ALTER TABLE `com_user`
  ADD CONSTRAINT `com_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `com_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mg_payment0`
--
ALTER TABLE `mg_payment0`
  ADD CONSTRAINT `mg_payment0_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mg_trans0`
--
ALTER TABLE `mg_trans0`
  ADD CONSTRAINT `mg_trans0_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `com_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

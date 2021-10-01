-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 01:39 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `konglo-batik`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom-size`
--

CREATE TABLE `custom-size` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order-id` int(11) NOT NULL,
  `part` enum('chest','waist','hip','shoulder','collar-to-hem','sleeve-length') NOT NULL,
  `size` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `design-motif`
--

CREATE TABLE `design-motif` (
  `id` int(4) NOT NULL,
  `title` int(11) NOT NULL,
  `attachment` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `status` enum('draft','publish') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_confirm`
--

CREATE TABLE `email_confirm` (
  `id` int(11) NOT NULL,
  `type` varchar(40) NOT NULL,
  `user_uid` varchar(40) NOT NULL,
  `confirm_code` int(6) NOT NULL,
  `expire_date` datetime NOT NULL,
  `status` enum('unconfirmed','confirmed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uid` varchar(6) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_time` datetime NOT NULL,
  `sleeve-length-type` enum('long','short') NOT NULL,
  `use-custom-size` tinyint(1) NOT NULL DEFAULT 0,
  `size-type` int(4) DEFAULT NULL,
  `custom-size` bigint(20) UNSIGNED DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `estimated_workmanship` int(4) DEFAULT NULL,
  `price` double NOT NULL,
  `payment-status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
  `payment-method` enum('cash','bank-transfer','midtrans') NOT NULL,
  `status` enum('canceled','waiting-for-confirmation','confirmed','rejected','on-progress','finished') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment-confirmation`
--

CREATE TABLE `payment-confirmation` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `attachment` varchar(60) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `status` enum('accept','decline') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment-midtrans`
--

CREATE TABLE `payment-midtrans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `response` text DEFAULT NULL,
  `status` enum('unpaid','paid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `size-detail`
--

CREATE TABLE `size-detail` (
  `id` int(4) NOT NULL,
  `size-type` int(4) NOT NULL,
  `part` enum('chest','waist','hip','shoulder','collar-to-hem','sleeve-length-long','sleeve-length-short') NOT NULL,
  `size` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `size-type`
--

CREATE TABLE `size-type` (
  `id` int(4) NOT NULL,
  `type` enum('man','woman','boy','girl') NOT NULL,
  `code` varchar(20) NOT NULL,
  `show-index` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `whatsapp` varchar(16) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `full_name`, `whatsapp`, `photo`) VALUES
(1, 'agungmasda29@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', NULL, 'user-profile-1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom-size`
--
ALTER TABLE `custom-size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design-motif`
--
ALTER TABLE `design-motif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment-confirmation`
--
ALTER TABLE `payment-confirmation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment-midtrans`
--
ALTER TABLE `payment-midtrans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size-detail`
--
ALTER TABLE `size-detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size-type`
--
ALTER TABLE `size-type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom-size`
--
ALTER TABLE `custom-size`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `design-motif`
--
ALTER TABLE `design-motif`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment-confirmation`
--
ALTER TABLE `payment-confirmation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment-midtrans`
--
ALTER TABLE `payment-midtrans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size-detail`
--
ALTER TABLE `size-detail`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size-type`
--
ALTER TABLE `size-type`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

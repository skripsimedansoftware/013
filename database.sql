-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 10:21 PM
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
-- Database: `spk-pembagian-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternative_data`
--

CREATE TABLE `alternative_data` (
  `id` int(4) NOT NULL,
  `criteria_id` int(4) NOT NULL,
  `user_id` int(2) NOT NULL,
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(4) NOT NULL,
  `name` varchar(60) NOT NULL,
  `weight` double NOT NULL,
  `attribute` enum('cost','benefit') NOT NULL
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
-- Table structure for table `freelancer_project`
--

CREATE TABLE `freelancer_project` (
  `id` int(4) NOT NULL,
  `user_id` int(2) NOT NULL,
  `project_id` int(4) NOT NULL,
  `rating` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(4) NOT NULL,
  `name` varchar(40) NOT NULL,
  `category` int(4) NOT NULL,
  `area` varchar(20) DEFAULT NULL,
  `budget` double NOT NULL,
  `deadline` date DEFAULT NULL,
  `status` enum('search-freelance','canceled','in-progress','not-completed','finished') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project_category`
--

CREATE TABLE `project_category` (
  `id` int(4) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(2) NOT NULL,
  `role` enum('admin','studio','freelancer') NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `role`, `email`, `username`, `password`, `full_name`, `photo`) VALUES
(1, 'admin', 'agungmasda29@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternative_data`
--
ALTER TABLE `alternative_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_category`
--
ALTER TABLE `project_category`
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
-- AUTO_INCREMENT for table `alternative_data`
--
ALTER TABLE `alternative_data`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

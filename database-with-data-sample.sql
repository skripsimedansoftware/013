-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2021 at 11:41 PM
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

--
-- Dumping data for table `alternative_data`
--

INSERT INTO `alternative_data` (`id`, `criteria_id`, `user_id`, `weight`) VALUES
(1, 1, 2, 9),
(2, 2, 2, 1),
(3, 3, 2, 8.5),
(4, 4, 2, 38),
(5, 5, 2, 8),
(6, 1, 3, 8),
(7, 2, 3, 1),
(8, 3, 3, 8),
(9, 4, 3, 43),
(10, 5, 3, 10),
(11, 1, 4, 7.5),
(12, 2, 4, 8.5),
(13, 3, 4, 7.5),
(14, 4, 4, 41),
(15, 5, 4, 10),
(16, 1, 5, 6.5),
(17, 2, 5, 7),
(18, 3, 5, 6.5),
(19, 4, 5, 32),
(20, 5, 5, 8),
(21, 1, 6, 6),
(22, 2, 6, 6),
(23, 3, 6, 8.5),
(24, 4, 6, 40),
(25, 5, 6, 5),
(26, 1, 7, 8),
(27, 2, 7, 6.5),
(28, 3, 7, 8.5),
(29, 4, 7, 31),
(30, 5, 7, 8),
(31, 1, 8, 8.5),
(32, 2, 8, 4.5),
(33, 3, 8, 7.5),
(34, 4, 8, 38),
(35, 5, 8, 5),
(36, 1, 9, 7),
(37, 2, 9, 7.5),
(38, 3, 9, 7),
(39, 4, 9, 35),
(40, 5, 9, 5);

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

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `name`, `weight`, `attribute`) VALUES
(1, 'Penguasaan Aspek teknis', 1.9, 'benefit'),
(2, 'Pengalaman Kerja', 2.1, 'benefit'),
(3, 'Interpersonal Skill', 3, 'benefit'),
(4, 'Usia', 2, 'cost'),
(5, 'Status Perkawinan', 2.5, 'cost');

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
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(4) NOT NULL,
  `role` enum('admin','studio','freelancer') DEFAULT NULL,
  `user_id` int(2) DEFAULT NULL,
  `uri` varchar(100) NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(4) NOT NULL,
  `owner` int(2) NOT NULL,
  `name` varchar(40) NOT NULL,
  `category` int(4) NOT NULL,
  `area` varchar(20) DEFAULT NULL,
  `budget` double NOT NULL,
  `deadline` date DEFAULT NULL,
  `percent` int(3) DEFAULT NULL,
  `temp-change` longtext DEFAULT NULL,
  `status` enum('search-freelance','pending','canceled','in-progress','not-completed','finished') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `owner`, `name`, `category`, `area`, `budget`, `deadline`, `percent`, `temp-change`, `status`) VALUES
(1, 1, 'Cari Freelancer', 1, 'Area apa gitulah', 200000, '2022-02-22', NULL, NULL, 'search-freelance');

-- --------------------------------------------------------

--
-- Table structure for table `project_category`
--

CREATE TABLE `project_category` (
  `id` int(4) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project_category`
--

INSERT INTO `project_category` (`id`, `name`) VALUES
(1, 'Rumah'),
(2, 'Cafe');

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
(1, 'admin', 'agungmasda29@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', NULL),
(2, 'studio', 'OXoqvG@gmai.com', 'studio', '9a12c50f2f23af9f1a313af952aee2b30627ac7b', 'Lina P.', NULL),
(3, 'freelancer', 'QjZLGW@gmai.com', 'GVqYLy', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'A. Alfian', NULL),
(4, 'freelancer', 'En6XlJ@gmai.com', 'u3Bf0R', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'Yuna D.', NULL),
(5, 'freelancer', '8jFXS4@gmai.com', 'GfOXVv', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'M. Tantri ', NULL),
(6, 'freelancer', 'JRXZM4@gmai.com', '4kcPib', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'M. Zaki', NULL),
(7, 'freelancer', 'TPvlEi@gmai.com', 'NtPsUo', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'Bella M.', NULL),
(8, 'freelancer', 'UAXgn7@gmai.com', 'o6948t', '11f6ad8ec52a2984abaafd7c3b516503785c2072', 'James', NULL),
(9, 'freelancer', 'xWau2d@gmai.com', 'freelancer', '9d329da7ff79fae4001abaaace252a11ae9a8e85', 'Nina P.', NULL);

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
-- Indexes for table `freelancer_project`
--
ALTER TABLE `freelancer_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
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
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freelancer_project`
--
ALTER TABLE `freelancer_project`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project_category`
--
ALTER TABLE `project_category`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

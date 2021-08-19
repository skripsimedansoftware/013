-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2021 at 12:57 AM
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
-- Database: `administrasi-skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(2) NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `full_name`, `foto`) VALUES
(1, 'agungmasda29@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_persyaratan`
--

CREATE TABLE `dokumen_persyaratan` (
  `id` int(6) NOT NULL,
  `tujuan` enum('kerja-praktek','tugas-akhir') NOT NULL,
  `mahasiswa` int(4) NOT NULL,
  `jenis_berkas` varchar(60) NOT NULL,
  `berkas` varchar(200) NOT NULL,
  `status` enum('ditinjau','diterima','ditolak') NOT NULL DEFAULT 'ditinjau'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(4) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `nama_lengkap` varchar(40) NOT NULL,
  `nomor_hp` varchar(16) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nik`, `email`, `password`, `nama_lengkap`, `nomor_hp`, `foto`, `jenis_kelamin`, `alamat`) VALUES
(1, '123456', 'dosen@sistem.administrasi-takp.com', 'ce3eaa938d09504bae9458dffb805f2de7c9da4e', 'Dosen', NULL, NULL, 'perempuan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dosen_pembimbing`
--

CREATE TABLE `dosen_pembimbing` (
  `id` int(4) NOT NULL,
  `mahasiswa` int(4) NOT NULL,
  `dosen_kp` int(4) DEFAULT NULL,
  `dosen_ta1` int(4) DEFAULT NULL,
  `dosen_ta2` int(4) DEFAULT NULL
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
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(8) NOT NULL,
  `mahasiswa` int(4) NOT NULL,
  `jadwal` enum('seminar-hasil','sidang-hijau') NOT NULL,
  `waktu` datetime NOT NULL,
  `lokasi` int(2) NOT NULL,
  `penguji1` int(4) DEFAULT NULL,
  `penguji2` int(4) DEFAULT NULL,
  `penguji3` int(4) DEFAULT NULL,
  `status` enum('selesai','dijadwalkan') NOT NULL DEFAULT 'dijadwalkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `judul_mahasiswa`
--

CREATE TABLE `judul_mahasiswa` (
  `id` int(4) NOT NULL,
  `mahasiswa` int(4) NOT NULL,
  `jenis` enum('kerja-praktek','tugas-akhir') NOT NULL,
  `judul` varchar(100) NOT NULL,
  `dokumen` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal_permintaan` datetime NOT NULL,
  `tanggapan_doping_1` enum('proses','revisi','diterima','ditolak') NOT NULL DEFAULT 'proses',
  `tanggapan_doping_2` enum('proses','revisi','diterima','ditolak') NOT NULL DEFAULT 'proses',
  `status` enum('proses','revisi','diterima','ditolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `konsultasi`
--

CREATE TABLE `konsultasi` (
  `id` int(8) NOT NULL,
  `judul_id` int(4) NOT NULL,
  `pengirim` enum('dosen','mahasiswa') NOT NULL,
  `mahasiswa` int(4) NOT NULL,
  `dosen` int(4) NOT NULL,
  `dokumen` varchar(100) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_jadwal`
--

CREATE TABLE `lokasi_jadwal` (
  `id` int(4) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(4) NOT NULL,
  `npm` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `nama_lengkap` varchar(40) NOT NULL,
  `nomor_hp` varchar(16) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `npm`, `email`, `password`, `nama_lengkap`, `nomor_hp`, `foto`, `jenis_kelamin`, `alamat`) VALUES
(1, '123456', 'mahasiswa@sistem.administrasi-takp.com', '1d0dca67fef675f4ccc65570e80a5b7d9ec790ea', 'Mahasiswa', '', NULL, 'laki-laki', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumen_persyaratan`
--
ALTER TABLE `dokumen_persyaratan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa` (`mahasiswa`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa` (`mahasiswa`),
  ADD KEY `dosen_kp` (`dosen_kp`),
  ADD KEY `dosen_ta1` (`dosen_ta1`),
  ADD KEY `dosen_ta2` (`dosen_ta2`);

--
-- Indexes for table `email_confirm`
--
ALTER TABLE `email_confirm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa` (`mahasiswa`),
  ADD KEY `penguji1` (`penguji1`),
  ADD KEY `penguji2` (`penguji2`),
  ADD KEY `penguji3` (`penguji3`);

--
-- Indexes for table `judul_mahasiswa`
--
ALTER TABLE `judul_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa` (`mahasiswa`);

--
-- Indexes for table `konsultasi`
--
ALTER TABLE `konsultasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judul_id` (`judul_id`),
  ADD KEY `mahasiswa` (`mahasiswa`),
  ADD KEY `dosen` (`dosen`);

--
-- Indexes for table `lokasi_jadwal`
--
ALTER TABLE `lokasi_jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokumen_persyaratan`
--
ALTER TABLE `dokumen_persyaratan`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosen_pembimbing`
--
ALTER TABLE `dosen_pembimbing`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_confirm`
--
ALTER TABLE `email_confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `judul_mahasiswa`
--
ALTER TABLE `judul_mahasiswa`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konsultasi`
--
ALTER TABLE `konsultasi`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasi_jadwal`
--
ALTER TABLE `lokasi_jadwal`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

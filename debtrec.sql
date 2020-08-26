-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2019 at 03:00 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `debtrec`
--
CREATE DATABASE IF NOT EXISTS `debtrec` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `debtrec`;

-- --------------------------------------------------------

--
-- Table structure for table `em_adres`
--

CREATE TABLE `em_adres` (
  `idkey` int(11) NOT NULL,
  `ename` varchar(100) DEFAULT '0',
  `email` varchar(100) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `em_adres`
--

INSERT INTO `em_adres` (`idkey`, `ename`, `email`) VALUES
(1, 'Jaco van Basten', 'jaco@softsystems.co.za');

-- --------------------------------------------------------

--
-- Table structure for table `em_dbmsg`
--

CREATE TABLE `em_dbmsg` (
  `idkey` int(11) NOT NULL,
  `dbId` char(10) DEFAULT NULL COMMENT 'Debtor File ID',
  `frm_name` varchar(100) DEFAULT NULL,
  `frm_email` varchar(100) DEFAULT NULL,
  `to_email` varchar(100) DEFAULT NULL,
  `msgdate` datetime DEFAULT NULL,
  `subjct` varchar(100) DEFAULT NULL,
  `msg` longtext DEFAULT NULL,
  `svdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `usrimage` varchar(20) DEFAULT NULL,
  `smtp` varchar(50) DEFAULT NULL,
  `imap` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`, `usrimage`, `smtp`, `imap`) VALUES
(1, 'jaco@softsystems.co.za', '$2y$10$qUX5cssOdw5jM9zhoGRPgugX63P6X4tQUZ.HeAmFcEAo0kcm5OCPu', 'Jaco van Basten', '0826814225', 1, 0, 1, '2018-07-01 18:56:49', 1, '2019-09-18 14:51:45', 'avatar5.png', NULL, NULL),
(2, 'user1@combrinck.co.za', '$2y$10$.s9.FAozWvQgoTZnJdYgqOfwO/sgjsMznvldWPXIrC.f25CaDmQWi', 'User1', '1234567890', 4, 0, 1, '2019-09-18 14:52:50', NULL, NULL, 'avatar5.png', 'mail.combrinck.co.za:587', 'mail.combrinck.co.za:143'),
(3, 'admin1@combrinck.co.za', '$2y$10$CZFgzsLia8XAbSWJciH8eOV2iOD73OVw2Pr..HqCHYtYs27FrhtAS', 'Admin1', '1234567890', 2, 0, 1, '2019-09-18 14:53:22', NULL, NULL, 'avatar5.png', 'mail.combrinck.co.za:587', 'mail.combrinck.co.za:143');

-- --------------------------------------------------------

--
-- Table structure for table `u_last_login`
--

CREATE TABLE `u_last_login` (
  `id` bigint(20) NOT NULL,
  `userId` bigint(20) NOT NULL,
  `sessionData` varchar(2048) NOT NULL,
  `machineIp` varchar(1024) NOT NULL,
  `userAgent` varchar(128) NOT NULL,
  `agentString` varchar(1024) NOT NULL,
  `platform` varchar(128) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `u_roles`
--

CREATE TABLE `u_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `u_roles`
--

INSERT INTO `u_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Supervisor'),
(4, 'Controler'),
(5, 'Client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `em_adres`
--
ALTER TABLE `em_adres`
  ADD PRIMARY KEY (`idkey`);

--
-- Indexes for table `em_dbmsg`
--
ALTER TABLE `em_dbmsg`
  ADD PRIMARY KEY (`idkey`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `u_last_login`
--
ALTER TABLE `u_last_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `u_roles`
--
ALTER TABLE `u_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `em_adres`
--
ALTER TABLE `em_adres`
  MODIFY `idkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `em_dbmsg`
--
ALTER TABLE `em_dbmsg`
  MODIFY `idkey` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `u_last_login`
--
ALTER TABLE `u_last_login`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `u_roles`
--
ALTER TABLE `u_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

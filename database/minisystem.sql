-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 04:30 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minisystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `IdAccess` int(11) NOT NULL,
  `AccessName` varchar(120) NOT NULL,
  `AccessStatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`IdAccess`, `AccessName`, `AccessStatus`) VALUES
(1, 'Admin', 0),
(9, 'admin1121122', 1),
(10, 'Administrator', 1);

-- --------------------------------------------------------

--
-- Table structure for table `access_permissions`
--

CREATE TABLE `access_permissions` (
  `IdAccessPermit` int(11) NOT NULL,
  `AccessId` int(11) NOT NULL,
  `PermitId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access_permissions`
--

INSERT INTO `access_permissions` (`IdAccessPermit`, `AccessId`, `PermitId`) VALUES
(4, 1, 1),
(8, 10, 1),
(9, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `full_name_category` varchar(255) NOT NULL,
  `category_type` varchar(50) NOT NULL,
  `category_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Active',
  `feedback_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `full_name_category`, `category_type`, `category_date`, `status`, `feedback_description`) VALUES
(11, 'samples', 'Neutral', '2025-03-31', 'Active', ''),
(13, 'category', 'Urgent', '2025-04-02', 'Active', 'asap'),
(18, 'TEST', 'Urgent', '2025-04-23', 'Active', 'Di maganda ang kalidad.'),
(19, 'TEST', 'Neutral', '2025-04-02', 'Active', 'Di maganda ang kalidad.'),
(20, 'TEST', 'Neutral', '2025-04-02', 'Active', 'Di maganda ang kalidad.'),
(21, 'sai', 'Neutral', '2025-04-02', 'Active', 'okay naman ang serbisyo, sakto lang.'),
(22, 'justin', 'Urgent', '2025-04-02', 'Active', 'emergency');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `IdPermission` int(11) NOT NULL,
  `PermissionName` varchar(100) NOT NULL,
  `PermissionStatus` int(1) NOT NULL,
  `SubscriptionId` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`IdPermission`, `PermissionName`, `PermissionStatus`, `SubscriptionId`) VALUES
(1, 'Admin - all', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `IdUser` int(11) NOT NULL,
  `FullName` varchar(150) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `TempPass` varchar(100) NOT NULL,
  `UserPass` varchar(100) NOT NULL,
  `AccessId` int(11) NOT NULL,
  `UserStatus` int(1) NOT NULL COMMENT '0-active, 1-inactive\r\n',
  `DateRegistered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`IdUser`, `FullName`, `Username`, `TempPass`, `UserPass`, `AccessId`, `UserStatus`, `DateRegistered`) VALUES
(1, 'admin ', 'admin', '', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1, 0, '2024-03-24 02:57:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`IdAccess`);

--
-- Indexes for table `access_permissions`
--
ALTER TABLE `access_permissions`
  ADD PRIMARY KEY (`IdAccessPermit`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`IdPermission`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `IdAccess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `access_permissions`
--
ALTER TABLE `access_permissions`
  MODIFY `IdAccessPermit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `IdPermission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

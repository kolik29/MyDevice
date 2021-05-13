-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2021 at 03:17 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydevice`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `fullName` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `fullName`, `phone`, `description`) VALUES
(61, '', '', ''),
(62, '', '', ''),
(63, '', '', ''),
(64, 'фывыфвфывфыв', '', ''),
(65, 'ваипатрпьпьнеорт', '', ''),
(66, 'Иван Иван Иванович', '+7 (878) 746 54 56', ''),
(67, '', '', ''),
(68, '', '', ''),
(69, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `clientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `name`, `number`, `clientID`) VALUES
(46, '', '', 61),
(47, '', '', 62),
(48, '', '', 63),
(49, '', '', 64),
(50, '', '', 65),
(51, 'устройство', '2ц213212311', 66),
(52, '', '', 67),
(53, '', '', 68),
(54, '', '', 69);

-- --------------------------------------------------------

--
-- Table structure for table `executers`
--

CREATE TABLE `executers` (
  `id` int(11) NOT NULL,
  `fullName` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `workType` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executerDesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `executers`
--

INSERT INTO `executers` (`id`, `fullName`, `phone`, `workType`, `executerDesc`, `date`) VALUES
(5, '?????? ???? ?????????', '+7 (271) 312 31 23', '0', '', '1620910170'),
(6, 'Иванов Петр Иосифович', '+7 (879) 456 45 64', '0', '', '1620910575');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `executer` int(11) NOT NULL,
  `deviceID` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deviceDesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deviceDefect` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `preliminaryPrice` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `workDesc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalPrice` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateCreate` int(11) NOT NULL,
  `dateFinish` int(11) DEFAULT NULL,
  `createBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client`, `executer`, `deviceID`, `deviceDesc`, `deviceDefect`, `preliminaryPrice`, `status`, `workDesc`, `totalPrice`, `dateCreate`, `dateFinish`, `createBy`) VALUES
(26, 61, 1, '46', '', '', '', 'new', NULL, NULL, 1620909071, NULL, 6),
(27, 62, 1, '47', '', '', '', 'new', NULL, NULL, 1620909128, NULL, 6),
(28, 63, 1, '48', '', '', '', 'new', NULL, NULL, 1620909295, NULL, 6),
(29, 64, 1, '49', '', '', '', 'new', NULL, NULL, 1620909758, NULL, 6),
(30, 65, 1, '50', '', '', '', 'new', NULL, NULL, 1620909763, NULL, 6),
(31, 66, 1, '51', 'Царапины', 'Не работает', '10000', 'new', NULL, NULL, 1620910630, NULL, 6),
(32, 69, 6, '54', '', '', '', 'new', NULL, NULL, 1620911500, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `session` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `workType` int(11) DEFAULT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullName` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`, `session`, `phone`, `workType`, `desc`, `fullName`) VALUES
(6, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '80a49de11e8edb3d6b051b9fbaa20806', NULL, NULL, NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `executers`
--
ALTER TABLE `executers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `executers`
--
ALTER TABLE `executers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

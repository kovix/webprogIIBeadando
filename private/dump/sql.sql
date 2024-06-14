-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 14, 2024 at 01:51 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webprog2beadando`
--

-- --------------------------------------------------------

--
-- Table structure for table `szindarabok`
--

CREATE TABLE `szindarabok` (
  `id` int(11) UNSIGNED NOT NULL,
  `iro` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szindarab` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `rendezo` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `mufaj` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szinpad` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `szindarabok`
--

INSERT INTO `szindarabok` (`id`, `iro`, `szindarab`, `rendezo`, `mufaj`, `szinpad`) VALUES
(1, 'módosított író', 'Módosított színdarab', 'harmadik rendező', 'harmadik műfaj', 'harmadik színpad'),
(2, 'Második író', 'Második színdarab', 'Második rendező', 'Második műfaj', 'Második színpad'),
(3, 'harmadik író', 'harmadik színdarab', 'harmadik rendező', 'harmadik műfaj', 'harmadik színpad');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `szindarabok`
--
ALTER TABLE `szindarabok`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `szindarabok`
--
ALTER TABLE `szindarabok`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

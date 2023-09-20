-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2023 at 11:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza-troskova`
--
CREATE DATABASE IF NOT EXISTS `baza-troskova` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `baza-troskova`;

-- --------------------------------------------------------

--
-- Table structure for table `vrsta_troska`
--

DROP TABLE IF EXISTS `vrsta_troska`;
CREATE TABLE IF NOT EXISTS `vrsta_troska` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(250) NOT NULL,
  `status` enum('aktivan','neaktivan') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `vrsta_troska`:
--

--
-- Dumping data for table `vrsta_troska`
--

INSERT INTO `vrsta_troska` (`id`, `ime`, `status`) VALUES
(1, 'stanarina', 'aktivan'),
(2, 'kupovina', 'aktivan'),
(3, 'hrana', 'aktivan'),
(4, 'lijekovi', 'neaktivan');

-- --------------------------------------------------------

--
-- Table structure for table `troskovi`
--

DROP TABLE IF EXISTS `troskovi`;
CREATE TABLE IF NOT EXISTS `troskovi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iznos` int(11) NOT NULL,
  `datum` date NOT NULL,
  `vrsta_troska_id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `troskovi`:
--

--
-- Dumping data for table `troskovi`
--

INSERT INTO `troskovi` (`id`, `iznos`, `datum`, `vrsta_troska_id`, `korisnik_id`) VALUES
(1, 2333, '2023-08-27', 3, 1),
(2, 5400, '2023-09-16', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `prilivi`
--

DROP TABLE IF EXISTS `prilivi`;
CREATE TABLE IF NOT EXISTS `prilivi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iznos` int(11) NOT NULL,
  `datum` date NOT NULL,
  `vrsta_priliva_id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `prilivi`:
--

--
-- Dumping data for table `prilivi`
--

INSERT INTO `prilivi` (`id`, `iznos`, `datum`, `vrsta_priliva_id`, `korisnik_id`) VALUES
(1, 123213, '2023-09-19', 1, 1),
(2, 15000, '2023-08-27', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vrsta_priliva`
--

DROP TABLE IF EXISTS `vrsta_priliva`;
CREATE TABLE IF NOT EXISTS `vrsta_priliva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(250) NOT NULL,
  `status` enum('aktivan','neaktivan') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `vrsta_priliva`:
--

--
-- Dumping data for table `vrsta_priliva`
--

INSERT INTO `vrsta_priliva` (`id`, `ime`, `status`) VALUES
(1, 'plata', 'aktivan'),
(2, 'dzeparac', 'aktivan');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ime` varchar(255) DEFAULT NULL,
  `prezime` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `rola` enum('administrator','korisnik') DEFAULT 'korisnik',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONSHIPS FOR TABLE `korisnici`:
--

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `password`, `rola`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '202cb962ac59075b964b07152d234b70', 'administrator'),
(2, 'korisnik', 'korisnik', 'korisnik@korisnik.com', '202cb962ac59075b964b07152d234b70', 'korisnik');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

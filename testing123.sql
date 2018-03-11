-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 11, 2018 at 02:45 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing123`
--

-- --------------------------------------------------------

--
-- Table structure for table `stockcontrol`
--

DROP TABLE IF EXISTS `stockcontrol`;
CREATE TABLE IF NOT EXISTS `stockcontrol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Time` time DEFAULT NULL,
  `Item` varchar(45) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Pickup` varchar(4) DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stockcontrol`
--

INSERT INTO `stockcontrol` (`id`, `Time`, `Item`, `Location`, `Pickup`, `Status`) VALUES
(1, '06:11:29', 'Apple', '23', '1', 'DELIVER TO PICKUP POINT'),
(2, '06:19:29', 'Biscuits', '28', '2', 'READY TO COLLECT'),
(3, '06:11:29', 'Bin Liners', '10', '2', 'READY TO COLLECT'),
(4, '06:11:29', 'Bread', '31', '1', 'GOING TO SHELF'),
(5, '06:11:29', 'Pedigree', '11', '2', 'DELIVER TO PICKUP POINT');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

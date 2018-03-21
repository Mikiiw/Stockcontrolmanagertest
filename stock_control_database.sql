-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2018 at 02:06 PM
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
-- Database: `stock control database`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

DROP TABLE IF EXISTS `checkout`;
CREATE TABLE IF NOT EXISTS `checkout` (
  `CheckoutID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `NumberBought` int(11) NOT NULL,
  `CheckoutTime` time(6) NOT NULL,
  `CheckoutDate` date NOT NULL,
  PRIMARY KEY (`CheckoutID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(256) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  `SupplyPrice` float DEFAULT NULL,
  `RetailPrice` float DEFAULT NULL,
  `Barcode` varchar(13) DEFAULT NULL,
  `Location` int(11) DEFAULT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Description`, `SupplyPrice`, `RetailPrice`, `Barcode`, `Location`) VALUES
(1, 'Apple', 'An edible fruit.', 0.5, 1, '5052449769500', 20),
(3, 'Bananas', 'Another type of edible fruit.', 0.6, 1.4, '5010441013137', 21),
(4, 'Biscuits', 'Unhealthy SNack', 0.5, 1, '', 50),
(6, 'sdfsd', NULL, NULL, NULL, NULL, NULL),
(12, 'gdfgdf', '21rwef', NULL, NULL, NULL, 12),
(13, 'sdfstf', 'sdfdfg', NULL, NULL, NULL, 12);

-- --------------------------------------------------------

--
-- Table structure for table `restock`
--

DROP TABLE IF EXISTS `restock`;
CREATE TABLE IF NOT EXISTS `restock` (
  `RestockID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `Status` varchar(11) NOT NULL,
  `TimeRequested` time NOT NULL,
  `DateRequested` date NOT NULL,
  `TimeCompleted` time DEFAULT NULL,
  `DateCompleted` date DEFAULT NULL,
  `QuantityRestocked` int(11) DEFAULT NULL,
  `PickupPoint` int(11) NOT NULL,
  PRIMARY KEY (`RestockID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restock`
--

INSERT INTO `restock` (`RestockID`, `ProductID`, `Status`, `TimeRequested`, `DateRequested`, `TimeCompleted`, `DateCompleted`, `QuantityRestocked`, `PickupPoint`) VALUES
(1, 1, 'LOW STOCK', '08:33:18', '2018-03-14', NULL, NULL, 0, 1),
(2, 3, 'PROCESSING', '13:19:00', '2018-03-14', NULL, NULL, NULL, 0),
(4, 1, 'PROCESSING', '08:33:18', '2018-03-14', NULL, NULL, 0, 0),
(5, 3, 'PROCESSING', '13:19:00', '2018-03-14', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`SupplierID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

DROP TABLE IF EXISTS `supply`;
CREATE TABLE IF NOT EXISTS `supply` (
  `SupplyID` int(11) NOT NULL AUTO_INCREMENT,
  `ProductID` int(11) NOT NULL,
  `CurrentStockLevel` int(11) NOT NULL,
  `StockThreshhold` int(11) NOT NULL,
  PRIMARY KEY (`SupplyID`),
  KEY `ProductID` (`ProductID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`SupplyID`, `ProductID`, `CurrentStockLevel`, `StockThreshhold`) VALUES
(1, 1, 25, 50),
(2, 3, 47, 30),
(3, 6, 0, 0),
(4, 13, 0, 12);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `restock`
--
ALTER TABLE `restock`
  ADD CONSTRAINT `restock_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `supply`
--
ALTER TABLE `supply`
  ADD CONSTRAINT `supply_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

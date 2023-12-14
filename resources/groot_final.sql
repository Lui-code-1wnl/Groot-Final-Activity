-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 14, 2023 at 12:28 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `groot_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `documentID` int NOT NULL AUTO_INCREMENT,
  `requestID` int NOT NULL,
  `userID` int NOT NULL,
  `officeID` int NOT NULL,
  `documentTitle` varchar(50) NOT NULL,
  `referringEntity` varchar(30) NOT NULL,
  `documentType` varchar(50) NOT NULL,
  `numberOfPages` int NOT NULL,
  `document_file` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`documentID`),
  KEY `userID` (`userID`),
  KEY `officeID` (`officeID`),
  KEY `requestID` (`requestID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `requestID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `documentTitle` varchar(30) NOT NULL,
  `dateSubmitted` date NOT NULL,
  `overallStatus` varchar(52) NOT NULL,
  PRIMARY KEY (`requestID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `firstName` varchar(52) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `userRole` varchar(50) NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `firstName`, `lastName`, `password`, `userRole`, `status`) VALUES
(1, 'admin', '', '', '123', 'admin', 'online'),
(2, 'sluograa', 'Office of Global Relations and Academic Affairs', '', '123', 'office', 'offline'),
(3, 'unit', 'SLU Unit', '', '123', 'office', 'offline'),
(4, 'ovpaa', 'SLU Office of the Vice President for Academic Affair', '', '123', 'office', 'offline'),
(5, 'ovpf', 'SLU Office of the Vice President for Finance', '', '123', 'office', 'offline'),
(6, 'ola', 'SLU Office for Legal Affairs', '', '123', 'office', 'offline'),
(7, 'ovpad', 'SLU Office of the Vice President for Administration', '', '123', 'office', 'offline'),
(8, 'adumlao', 'Amore', 'Dumlao', '123456', 'user', 'offline'),
(9, 'gbgalo', 'Greta', 'Galo', '123456', 'user', 'offline');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`officeID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `document_ibfk_3` FOREIGN KEY (`requestID`) REFERENCES `request` (`requestID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

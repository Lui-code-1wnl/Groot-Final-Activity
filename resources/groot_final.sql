-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2023 at 08:50 PM
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
  `documentDescription` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `message` varchar(150) NOT NULL,
  `dateReceived` text NOT NULL,
  `dateReviewed` text,
  `status` varchar(12) NOT NULL,
  PRIMARY KEY (`documentID`),
  KEY `requestID` (`requestID`),
  KEY `officeID` (`officeID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`documentID`, `requestID`, `userID`, `officeID`, `documentTitle`, `referringEntity`, `documentType`, `numberOfPages`, `document_file`, `documentDescription`, `message`, `dateReceived`, `dateReviewed`, `status`) VALUES
(62, 15, 1, 4, 'Test Upload', 'Lebron James', 'Wala lang hehehe', 23, NULL, 'Gumana ka na haup!', '', '2023-12-10 21:56', '', 'Pending'),
(63, 15, 1, 5, 'Test Upload', 'Lebron James', 'Wala lang hehehe', 23, NULL, 'Gumana ka na haup!', '', '2023-12-10 21:56', '', 'Pending'),
(64, 15, 1, 6, 'Test Upload', 'Lebron James', 'Wala lang hehehe', 23, NULL, 'Gumana ka na haup!', '', '2023-12-10 21:56', '', 'Pending'),
(65, 15, 1, 7, 'Test Upload', 'Lebron James', 'Wala lang hehehe', 23, NULL, 'Gumana ka na haup!', '', '2023-12-10 21:56', '', 'Pending'),
(66, 15, 1, 8, 'Test Upload', 'Lebron James', 'Wala lang hehehe', 23, NULL, 'Gumana ka na haup!', '', '2023-12-10 21:56', '', 'Pending'),
(67, 16, 1, 3, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(68, 16, 1, 4, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(69, 16, 1, 5, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(70, 16, 1, 6, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(71, 16, 1, 7, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(72, 16, 1, 8, 'Random', 'James Harden', 'Test File', 3, NULL, '234567', '', '2023-12-10 22:01', '', 'Pending'),
(73, 17, 1, 3, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(74, 17, 1, 4, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(75, 17, 1, 5, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(76, 17, 1, 6, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(77, 17, 1, 7, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(78, 17, 1, 8, 'NBA Apology Form', 'Lebron James Harden', 'Apology Form', 1, NULL, 'Sorry beh', '', '2023-12-10 22:05', '', 'Pending'),
(79, 18, 1, 3, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(80, 18, 1, 4, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(81, 18, 1, 5, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(82, 18, 1, 6, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(83, 18, 1, 7, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(84, 18, 1, 8, 'asdad', 'afasfas', 'asdasd', 0, NULL, 'asdasd', '', '2023-12-10 22:09', '', 'Pending'),
(85, 23, 1, 3, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(86, 23, 1, 4, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(87, 23, 1, 5, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(88, 23, 1, 6, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(89, 23, 1, 7, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(90, 23, 1, 8, '12', 'Lebron James Harden', '123456', 12, NULL, '23rt', '', '2023-12-10 22:19', '', 'Pending'),
(91, 25, 1, 3, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(92, 25, 1, 4, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(93, 25, 1, 5, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(94, 25, 1, 6, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(95, 25, 1, 7, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(96, 25, 1, 8, 'Test Upload', 'James Harden', 'Activity Form', 2, NULL, 'qw234', '', '2023-12-10 22:27', '', 'Pending'),
(97, 26, 1, 3, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(98, 26, 1, 4, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(99, 26, 1, 5, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(100, 26, 1, 6, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(101, 26, 1, 7, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(102, 26, 1, 8, 'Organization Assembly', 'Lebron James Harden', 'None', 2, NULL, 'KJHGF', '', '2023-12-10 22:56', '', 'Pending'),
(103, 27, 1, 3, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(104, 27, 1, 4, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(105, 27, 1, 5, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(106, 27, 1, 6, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(107, 27, 1, 7, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(108, 27, 1, 8, 'Activity Techno', 'Lebron James Harden', 'Test File', 2, NULL, 'Check boss', '', '2023-12-10 23:22', '', 'Pending'),
(109, 28, 1, 3, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(110, 28, 1, 4, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(111, 28, 1, 5, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(112, 28, 1, 6, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(113, 28, 1, 7, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(114, 28, 1, 8, 'Organization Assembly', 'Amore Dumlao', 'Activity Form', 2, '28-1-Organization Assembly.pdf', '434', '', '2023-12-10 23:27', '', 'Pending'),
(115, 30, 1, 3, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '30-1-Test Upload.pdf', 'edf', '', '2023-12-10 23:41', '', 'Pending'),
(116, 31, 1, 3, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(117, 31, 1, 4, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(118, 31, 1, 5, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(119, 31, 1, 6, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(120, 31, 1, 7, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(121, 31, 1, 8, 'Test Upload', 'Amore Dumlao', 'Wala lang hehehe', 2, '31-1-Test Upload.pdf', '12345', '', '2023-12-10 23:43', '', 'Pending'),
(122, 32, 1, 3, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(123, 32, 1, 4, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(124, 32, 1, 5, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(125, 32, 1, 6, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(126, 32, 1, 7, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(127, 32, 1, 8, 'Wack', 'Amore Dumlao', '2', 2, '32-1-Wack.pdf', '123rfdc', '', '2023-12-10 23:49', '', 'Pending'),
(128, 33, 1, 3, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(129, 33, 1, 4, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(130, 33, 1, 5, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, NULL, 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(131, 33, 1, 6, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, NULL, 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(132, 33, 1, 7, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, NULL, 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(133, 33, 1, 8, 'Organization Assembly', 'Pat Bev', 'Wala lang hehehe', 2, NULL, 'QREW', '', '2023-12-10 23:56', '', 'Pending'),
(134, 34, 1, 3, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(135, 34, 1, 4, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(136, 34, 1, 5, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(137, 34, 1, 6, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(138, 34, 1, 7, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(139, 34, 1, 8, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 3, '0-1-Organization Assembly.pdf', '234tyu', '', '2023-12-11 00:00', '', 'Pending'),
(140, 35, 1, 3, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(141, 35, 1, 4, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(142, 35, 1, 5, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(143, 35, 1, 6, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(144, 35, 1, 7, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(145, 35, 1, 8, 'Test Upload', 'Amore Dumlao', 'Activity Form', 2, '0-1-Test Upload.pdf', '13245', '', '2023-12-11 00:11', '', 'Pending'),
(146, 36, 1, 3, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, NULL, 'wersdtf', 'Nigga approved', '2023-12-11 00:18', '2023-12-17 01:36', 'Approved'),
(147, 36, 1, 4, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'wersdtf', '', '2023-12-11 00:18', '', 'Pending'),
(148, 36, 1, 5, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'wersdtf', '', '2023-12-11 00:18', '', 'Pending'),
(149, 36, 1, 6, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'wersdtf', '', '2023-12-11 00:18', '', 'Pending'),
(150, 36, 1, 7, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'wersdtf', '', '2023-12-11 00:18', '', 'Pending'),
(151, 36, 1, 8, 'Organization Assembly', 'James Harden', 'Wala lang hehehe', 2, '0-1-Organization Assembly.pdf', 'wersdtf', '', '2023-12-11 00:18', '', 'Pending'),
(152, 38, 1, 3, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, NULL, 'gyufhgf', 'asdasd', '2023-12-11 00:31', '2023-12-17 01:24', 'Approved'),
(153, 38, 1, 4, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, '0-1-Test Upload.pdf', 'gyufhgf', '', '2023-12-11 00:31', '', 'Pending'),
(154, 38, 1, 5, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, '0-1-Test Upload.pdf', 'gyufhgf', '', '2023-12-11 00:31', '', 'Pending'),
(155, 38, 1, 6, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, '0-1-Test Upload.pdf', 'gyufhgf', '', '2023-12-11 00:31', '', 'Pending'),
(156, 38, 1, 7, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, '0-1-Test Upload.pdf', 'gyufhgf', '', '2023-12-11 00:31', '', 'Pending'),
(157, 38, 1, 8, 'Test Upload', 'Lebron James Harden', 'Activity Form', 3, '0-1-Test Upload.pdf', 'gyufhgf', '', '2023-12-11 00:31', '', 'Pending'),
(158, 39, 1, 3, 'Organization Assembly', 'James Harden', 'Activity Form', 2, NULL, 'werty', 'Nigga approved', '2023-12-11 00:40', ' ', 'Approved'),
(159, 39, 1, 4, 'Organization Assembly', 'James Harden', 'Activity Form', 2, '', 'werty', '', '2023-12-11 00:40', '', 'Pending'),
(160, 39, 1, 5, 'Organization Assembly', 'James Harden', 'Activity Form', 2, NULL, 'werty', '', '2023-12-11 00:40', '', 'Pending'),
(161, 39, 1, 6, 'Organization Assembly', 'James Harden', 'Activity Form', 2, NULL, 'werty', '', '2023-12-11 00:40', '', 'Pending'),
(162, 39, 1, 7, 'Organization Assembly', 'James Harden', 'Activity Form', 2, NULL, 'werty', '', '2023-12-11 00:40', '', 'Pending'),
(163, 39, 1, 8, 'Organization Assembly', 'James Harden', 'Activity Form', 2, NULL, 'werty', '', '2023-12-11 00:40', '', 'Pending'),
(182, 46, 2, 3, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'qerwe', '2023-12-16 23:29', '2023-12-17 02:12', 'Approved'),
(183, 46, 2, 4, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'Yo approve nigga go', '2023-12-17 02:12', '2023-12-17 02:14', 'Approved'),
(184, 46, 2, 5, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'We good go. Approved.', '2023-12-17 02:14', '2023-12-17 02:16', 'Approved'),
(185, 46, 2, 6, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'Approved goo', '2023-12-17 02:16', '2023-12-17 02:17', 'Approved'),
(186, 46, 2, 7, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'wtwerwer', '2023-12-17 02:17', '2023-12-17 02:17', 'Approved'),
(187, 46, 2, 8, 'Test Upload', 'Lebron James Harden', 'NBA Contract', 2, '46-2-Test Upload.pdf', 'wqdewf', 'Go badabim', '2023-12-17 02:17', '2023-12-17 02:40', 'Approved'),
(188, 47, 2, 3, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'MyVirtual Numba wan!', '2023-12-17 04:34', '2023-12-17 02:42', 'Approved'),
(189, 47, 2, 4, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'Dami error lods balik ko.', '2023-12-17 02:42', '2023-12-17 02:43', 'Returned'),
(190, 47, 2, 5, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'Approve sir ASAP', '2023-12-17 02:42', '', 'Waiting'),
(191, 47, 2, 6, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'Approve sir ASAP', '2023-12-17 02:42', '', 'Waiting'),
(192, 47, 2, 7, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'Approve sir ASAP', '2023-12-17 02:42', '', 'Waiting'),
(193, 47, 2, 8, 'Random Paper', 'Greta Belle', 'Test File', 2, '47-2-Random Paper.pdf', 'For testing', 'Approve sir ASAP', '2023-12-17 02:42', '', 'Waiting'),
(194, 48, 1, 3, 'Form ', 'Amore Dumlao', 'JKAAS', 2, '48-1-Form .pdf', 'Ahahahaha', 'Lols', '2023-12-17 03:01', '', ''),
(195, 51, 1, 3, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '51-1-Organization Assembly.pdf', 'QEQFR', '3REGERTEW', '2023-12-17 03:17', '', 'Pending'),
(196, 51, 1, 4, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '', 'QEQFR', '', '2023-12-17 03:17', '', 'Waiting'),
(197, 51, 1, 5, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '', 'QEQFR', '', '2023-12-17 03:17', '', 'Waiting'),
(198, 51, 1, 6, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '', 'QEQFR', '', '2023-12-17 03:17', '', 'Waiting'),
(199, 51, 1, 7, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '', 'QEQFR', '', '2023-12-17 03:17', '', 'Waiting'),
(200, 51, 1, 8, 'Organization Assembly', 'Amore Dumlao', 'Test File', 2, '', 'QEQFR', '', '2023-12-17 03:17', '', 'Waiting'),
(201, 52, 1, 3, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '52-1-Organization Assembly.pdf', 'qsfeqr', 'QETQER', '2023-12-17 03:22', '', 'Waiting'),
(202, 52, 1, 4, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '', '', '', '2023-12-17 03:22', '', 'Waiting'),
(203, 52, 1, 5, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '', '', '', '2023-12-17 03:22', '', 'Waiting'),
(204, 52, 1, 6, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '', '', '', '2023-12-17 03:22', '', 'Waiting'),
(205, 52, 1, 7, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '', '', '', '2023-12-17 03:22', '', 'Waiting'),
(206, 52, 1, 8, 'Organization Assembly', 'Bray Wyatt', 'Activity Form', 2, '', '', '', '2023-12-17 03:22', '', 'Waiting'),
(207, 53, 1, 3, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '53-1-Random Paper.pdf', 'QWE', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(208, 53, 1, 4, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '', '', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(209, 53, 1, 5, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '', '', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(210, 53, 1, 6, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '', '', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(211, 53, 1, 7, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '', '', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(212, 53, 1, 8, 'Random Paper', 'Amore Dumlao', 'Activity Form', 2, '', '', 'ASDAFSASF', '2023-12-17 03:25', '', 'Pending'),
(213, 54, 1, 3, 'Agik', 'Amore Dumlao', 'Map', 1, '54-1-Agik.pdf', 'ewfwer', 'sdfsdfsfd', '2023-12-17 03:30', '', ''),
(214, 54, 1, 4, 'Agik', 'Amore Dumlao', 'Map', 1, '', 'ewfwer', '', '2023-12-17 03:30', '', ''),
(215, 54, 1, 5, 'Agik', 'Amore Dumlao', 'Map', 1, '', 'ewfwer', '', '2023-12-17 03:30', '', ''),
(216, 54, 1, 6, 'Agik', 'Amore Dumlao', 'Map', 1, '', 'ewfwer', '', '2023-12-17 03:30', '', ''),
(217, 54, 1, 7, 'Agik', 'Amore Dumlao', 'Map', 1, '', 'ewfwer', '', '2023-12-17 03:30', '', ''),
(218, 54, 1, 8, 'Agik', 'Amore Dumlao', 'Map', 1, '', 'ewfwer', '', '2023-12-17 03:30', '', ''),
(219, 57, 1, 3, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '57-1-Normal Form.pdf', 'asfaf', 'asfasf', '2023-12-17 03:36', '', ''),
(220, 57, 1, 4, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '', 'asfaf', '', '2023-12-17 03:36', '', ''),
(221, 57, 1, 5, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '', 'asfaf', '', '2023-12-17 03:36', '', ''),
(222, 57, 1, 6, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '', 'asfaf', '', '2023-12-17 03:36', '', ''),
(223, 57, 1, 7, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '', 'asfaf', '', '2023-12-17 03:36', '', ''),
(224, 57, 1, 8, 'Normal Form', 'Amore Dumlao', 'wqeq', 2, '', 'asfaf', '', '2023-12-17 03:36', '', ''),
(225, 58, 1, 3, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '58-1-Test Upload.pdf', 'dtydndn', 'yfjhcf tdx', '2023-12-17 03:40', '', ''),
(226, 58, 1, 4, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '', 'dtydndn', '', '2023-12-17 03:40', '', ''),
(227, 58, 1, 5, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '', 'dtydndn', '', '2023-12-17 03:40', '', ''),
(228, 58, 1, 6, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '', 'dtydndn', '', '2023-12-17 03:40', '', ''),
(229, 58, 1, 7, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '', 'dtydndn', '', '2023-12-17 03:40', '', ''),
(230, 58, 1, 8, 'Test Upload', 'Lebron James Harden', 'Activity Form', 2, '', 'dtydndn', '', '2023-12-17 03:40', '', ''),
(231, 59, 1, 3, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '59-1-ewrwe.pdf', 'asfsgeh', 'werwerwer', '2023-12-17 03:46', '', 'Pending'),
(232, 59, 1, 4, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '', 'asfsgeh', '', '2023-12-17 03:46', '', 'Waiting'),
(233, 59, 1, 5, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '', 'asfsgeh', '', '2023-12-17 03:46', '', 'Waiting'),
(234, 59, 1, 6, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '', 'asfsgeh', '', '2023-12-17 03:46', '', 'Waiting'),
(235, 59, 1, 7, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '', 'asfsgeh', '', '2023-12-17 03:46', '', 'Waiting'),
(236, 59, 1, 8, 'ewrwe', 'Lebron James Harden', 'Test File', 2, '', 'asfsgeh', '', '2023-12-17 03:46', '', 'Waiting');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `requestID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `documentTitle` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `dateSubmitted` date NOT NULL,
  `overallStatus` varchar(52) NOT NULL,
  PRIMARY KEY (`requestID`),
  KEY `requestID` (`requestID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`requestID`, `userID`, `documentTitle`, `dateSubmitted`, `overallStatus`) VALUES
(15, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(16, 1, 'Random', '2023-12-10', 'Pending approval'),
(17, 1, 'NBA Apology Form', '2023-12-10', 'Pending approval'),
(18, 1, 'asdad', '2023-12-10', 'Pending approval'),
(19, 1, 'teryu', '2023-12-10', 'Pending approval'),
(20, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(21, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(22, 1, '3246', '2023-12-10', 'Pending approval'),
(23, 1, '12', '2023-12-10', 'Pending approval'),
(24, 1, 'Organization Assembly', '2023-12-10', 'Pending approval'),
(25, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(26, 1, 'Organization Assembly', '2023-12-10', 'Pending approval'),
(27, 1, 'Activity Techno', '2023-12-10', 'Pending approval'),
(28, 1, 'Organization Assembly', '2023-12-10', 'Pending approval'),
(29, 1, 'Awit', '2023-12-10', 'Pending approval'),
(30, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(31, 1, 'Test Upload', '2023-12-10', 'Pending approval'),
(32, 1, 'Wack', '2023-12-10', 'Pending approval'),
(33, 1, 'Organization Assembly', '2023-12-10', 'Pending approval'),
(34, 1, 'Organization Assembly', '2023-12-11', 'Pending approval'),
(35, 1, 'Test Upload', '2023-12-11', 'Pending approval'),
(36, 1, 'Organization Assembly', '2023-12-11', 'Pending approval'),
(37, 1, 'Test Upload', '2023-12-11', 'Pending approval'),
(38, 1, 'Test Upload', '2023-12-11', 'Pending approval'),
(39, 1, 'Organization Assembly', '2023-12-11', 'Pending approval'),
(46, 2, 'Test Upload', '2023-12-16', 'Approved'),
(47, 2, 'Random Paper', '2023-12-17', 'Pending approval'),
(48, 1, 'Form ', '2023-12-17', 'Pending approval'),
(49, 1, 'Test', '2023-12-17', 'Pending approval'),
(50, 1, 'Random Paper', '2023-12-17', 'Pending approval'),
(51, 1, 'Organization Assembly', '2023-12-17', 'Pending approval'),
(52, 1, 'Organization Assembly', '2023-12-17', 'Pending approval'),
(53, 1, 'Random Paper', '2023-12-17', 'Pending approval'),
(54, 1, 'Agik', '2023-12-17', 'Pending approval'),
(55, 1, 'Test Upload', '2023-12-17', 'Pending approval'),
(56, 1, 'NBA Apology Form', '2023-12-17', 'Pending approval'),
(57, 1, 'Normal Form', '2023-12-17', 'Pending approval'),
(58, 1, 'Test Upload', '2023-12-17', 'Pending approval'),
(59, 1, 'ewrwe', '2023-12-17', 'Pending approval');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL,
  `username` varchar(15) NOT NULL,
  `firstName` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `password` varchar(10) NOT NULL,
  `userRole` varchar(50) NOT NULL,
  `status` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `firstName`, `lastName`, `password`, `userRole`, `status`) VALUES
(1, 'adumlao', 'Amore', 'Dumlao', '123456', 'user', 'offline'),
(2, 'gbgalo', 'Greta Belle', 'Galo', '123456', 'user', 'online'),
(3, 'sluograa', 'Office of Global Relations and Academic Affairs', '', '123456', 'office', 'offline'),
(4, 'unit', 'SLU Unit', '', '123456', 'office', 'offline'),
(5, 'ovpaa', 'SLU Office of the Vice President for Academic Affairs', '', '123456', 'office', 'offline'),
(6, 'ovpf', 'SLU Office of the Vice President for Finance', '', '123456', 'office', 'offline'),
(7, 'ola', 'SLU Office for Legal Affairs', '', '123456', 'office', 'offline'),
(8, 'ovpad', 'SLU Office of the Vice President for Administration', '', '123456', 'office', 'offline');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`requestID`) REFERENCES `request` (`requestID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`officeID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `document_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

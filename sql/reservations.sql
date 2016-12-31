-- phpMyAdmin SQL Dump
-- version 4.0.10.8
-- http://www.phpmyadmin.net
--
-- Host: atria.elkdata.ee
-- Generation Time: Dec 31, 2016 at 04:47 AM
-- Server version: 10.0.27-MariaDB
-- PHP Version: 5.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vhost51562s1`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facility` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `reservationdate` datetime NOT NULL,
  `departuredate` datetime NOT NULL,
  `people` int(11) NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `comments` text CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `facility`, `reservationdate`, `departuredate`, `people`, `name`, `email`, `phone`, `comments`) VALUES
(142, 'Dining', '2016-12-14 10:00:00', '2016-12-14 12:00:00', 1, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(143, 'Dining', '2016-12-28 10:00:00', '2016-12-28 12:00:00', 49, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(144, 'Dining', '2016-12-22 10:00:00', '2016-12-22 12:00:00', 1, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(145, 'Tennis', '2016-12-14 10:00:00', '2016-12-14 11:00:00', 0, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(146, 'Squash', '2016-12-21 10:00:00', '2016-12-21 11:00:00', 0, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(147, 'Football', '2016-12-27 10:00:00', '2016-12-27 11:00:00', 0, 'Donals Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(148, 'Football', '2016-12-08 10:00:00', '2016-12-08 11:00:00', 0, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(149, 'Tennis', '2016-12-27 10:00:00', '2016-12-27 11:00:00', 0, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(150, 'Dining', '2016-12-27 06:00:00', '2016-12-27 12:00:00', 49, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(151, 'Dining', '2016-12-30 10:00:00', '2016-12-30 12:00:00', 1, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(152, 'Dining', '2016-12-22 10:00:00', '2016-12-22 12:00:00', 1, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again'),
(153, 'Dining', '2016-12-28 14:30:00', '2016-12-28 16:30:00', 1, 'Joseph', 'donald@trump.com', '1337420', 'Make America great again'),
(154, 'Dining', '2016-12-27 10:00:00', '2016-12-27 12:00:00', 1, 'Donald Trump', 'donald@trump.com', '1337420', 'Make America great again');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

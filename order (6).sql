-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 01:37 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `userregister` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `userregister` (`ID`, `name`, `email`, `pass`) VALUES
(1, 'gaurav', 'sahilborana.borana@gmail.com', 'sasa'),
(2, 'gaurav', 'gaurav.borana2000@gmail.com', 'dsada'),
(3, 'gaurav', 'gaurav.borana2000@gmail.com', 'dsada'),
(4, 'pawan', 'pawan@gmail.com', 'pawan'),
(5, 'gaurav', 'gaurav.borana2012@gmail.com', 'ssa'),
(6, 'sudh', 'sanchitgagwani44@gmail.com', 'sasa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `register`
--
ALTER TABLE `userregister`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `userregister`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

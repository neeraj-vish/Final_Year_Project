-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2023 at 04:19 AM
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
-- Database: `employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customers` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customers` (`ID`, `Name`, `email`, `pass`) VALUES
(1, '', 'pawan@gmail.com', 'pawan'),
(2, '', 'rohit@gmail.com', 'rohit'),
(3, '', 'pawan@gmail.com', 'pawan'),
(4, '', 'kabaddi@gmail.com', 'kabaddi'),
(12, '', 'kohli@gmail.com', '6639ae1b3e461517930b95418259523b322a6391f8fc6729f1'),
(13, '', 'kohli@gmail.com', '4572e12d9fc5c39451bb96ca11c3583c582921b37cc1138bdf'),
(14, '', 'gau@gmail.com', '44104fcaef8476724152090d6d7bd9afa8ca5b385f6a99d3c6'),
(15, '', 'gau@gmail.com', '4572e12d9fc5c39451bb96ca11c3583c582921b37cc1138bdf'),
(16, '', 'kohli@gmail.com', '6639ae1b3e461517930b95418259523b322a6391f8fc6729f1'),
(17, '', 'kohli@gmail.com', '6639ae1b3e461517930b95418259523b322a6391f8fc6729f1'),
(18, '', 'gaurav.borana2012@gmail.com', 'e7c277e924bea6234f514cfcb3aa8848c178882db17597504a'),
(19, '', 'gau@gmail.com', '49b95077e4e3c58f2b2c3bd5fdaa5b500efa288d5642e6dac8'),
(20, '', 'gau@gmail.com', '49b95077e4e3c58f2b2c3bd5fdaa5b500efa288d5642e6dac8'),
(21, '', 'gaurav.borana2012@gmail.com', '1234'),
(24, '', 'gaurav.borana2012@gmail.com', '49b95077e4e3c58f2b2c3bd5fdaa5b500efa288d5642e6dac84e7554144154e2'),
(25, '', 'kohli@gmail.com', '37cc8f14dad3fb96b56629da27ded83de621b3c97902df8e1be8f68769b5e680'),
(26, '', 'gaurav.borana2012@gmail.com', 'aaa9402664f1a41f40ebbc52c9993eb66aeb366602958fdfaa283b71e64db123'),
(27, '', 'kohli@gmail.com', '8254c329a92850f6d539dd376f4816ee2764517da5e0235514af433164480d7a'),
(29, '', 'gaurav.borana2012@gmail.com', 'e7c277e924bea6234f514cfcb3aa8848c178882db17597504aeabb3c4432aca4'),
(30, '', 'kohli@gmail.com', '9b158b2a6044a976ce5aa322fdb514bd'),
(31, '', 'gau@gmail.com', 'b2f5ff47436671b6e533d8dc3614845d'),
(38, '', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(39, '', 'kohli@gmail.com', '9b158b2a6044a976ce5aa322fdb514bd');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `userlogin` (
  `ID` int(4) NOT NULL,
  `user` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `userlogin` (`ID`, `user`, `pass`) VALUES
(41, 'root', 'gaurav'),
(42, 'root', 'pawan'),
(43, 'root', 'pawan'),
(44, 'root', 'pawan'),
(45, 'root', 'gaurav'),
(46, 'root', 'pawan'),
(47, 'root', 'hi-flyer'),
(48, 'root', 'hi-flyer'),
(49, 'root', 'hi-flyer'),
(50, 'root', 'pawan'),
(51, 'root', 'hi-flyer'),
(52, 'root', 'hi-flyer'),
(53, 'root', 'hi-flyer'),
(54, 'root', 'hi-flyer'),
(55, 'root', 'hi-flyer'),
(56, 'root', 'hi-flyer'),
(57, 'root', 'hi-flyer'),
(58, 'root', 'hi-flyer'),
(59, 'root', 'pawan'),
(60, 'root', 'hi-flyer'),
(61, 'root', 'hi-flyer'),
(62, 'root', 'hi-flyer'),
(63, 'root', 'hi-flyer'),
(64, 'root', 'hi-flyer'),
(65, 'root', 'hello'),
(66, 'root', 'hi-flyer'),
(67, 'root', 'hi-flyer'),
(68, 'root', '18'),
(69, 'root', '18'),
(70, 'root', 'hi-flyer'),
(71, 'root', ''),
(72, 'root', ''),
(73, 'root', ''),
(74, 'root', 'hi-flyer'),
(75, 'root', '12'),
(76, 'root', 'gaurav'),
(77, 'root', 'hi-flyer'),
(78, 'root', 'hi-flyer'),
(79, 'root', 'gaurav'),
(80, 'root', 'hi-flyer'),
(81, 'root', 'koh'),
(82, 'root', 'e3b0c4429'),
(83, 'root', 'e3b0c4429'),
(84, 'root', '49b95077e'),
(85, 'root', '49b95077e'),
(86, 'root', '49b95077e'),
(87, 'root', 'e7c277e92'),
(88, 'root', 'e7c277e92'),
(89, 'root', 'e7c277e92'),
(90, 'root', '49b95077e'),
(91, 'root', 'hi-flyer'),
(92, 'root', 'hi-flyer'),
(93, 'root', '1234'),
(94, 'root', 'hi-flyer'),
(95, 'root', 'kohli'),
(96, 'root', 'kohli'),
(97, 'root', 'hi-flyer'),
(98, 'root', 'hi-flyer'),
(99, 'root', 'koh'),
(100, 'root', 'hi-flyer'),
(101, 'root', 'a'),
(102, 'root', 'ad'),
(103, 'root', 'admin'),
(104, 'root', '123'),
(105, 'root', 'admin'),
(106, 'root', 'admin'),
(107, 'root', 'admin'),
(108, 'root', 'a'),
(109, 'root', 'koh'),
(110, 'root', 'hi-flyer');

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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `register`
--
ALTER TABLE `userregister`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `userlogin`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `userregister`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

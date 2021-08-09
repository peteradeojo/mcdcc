-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 11:49 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maternalchild`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL COMMENT 'primary key',
  `cardnumber` varchar(11) NOT NULL COMMENT 'card number',
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL COMMENT 'phone number',
  `create_time` datetime DEFAULT current_timestamp() COMMENT 'create time',
  `update_time` datetime DEFAULT NULL COMMENT 'update time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `id` int(11) NOT NULL COMMENT 'primary key',
  `create_time` datetime DEFAULT current_timestamp() COMMENT 'create time',
  `update_time` datetime DEFAULT NULL COMMENT 'update time',
  `cardnumber` varchar(11) DEFAULT NULL COMMENT 'card number',
  `email` varchar(40) DEFAULT NULL,
  `religion` varchar(20) DEFAULT NULL,
  `city` varchar(15) DEFAULT NULL,
  `state` varchar(15) DEFAULT NULL,
  `street` varchar(20) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `gender` int(1) NOT NULL DEFAULT 1 COMMENT 'gender'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='patient details table';

-- --------------------------------------------------------

--
-- Stand-in structure for view `patient_view`
-- (See below for the actual view)
--
CREATE TABLE `patient_view` (
`id` int(11)
,`cardnumber` varchar(11)
,`firstname` varchar(20)
,`lastname` varchar(20)
,`phone` varchar(20)
,`create_time` datetime
,`update_time` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(3) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `createdOn` datetime DEFAULT current_timestamp(),
  `officeid` varchar(3) NOT NULL,
  `post` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `username`, `password`, `firstname`, `lastname`, `phone`, `email`, `createdOn`, `officeid`, `post`) VALUES
(1, 'boluwatife', '716b37cbb85ebeaea079d47aae047a3aed6aaa92', 'Boluwatife', 'Ade-Ojo', '08103490675', 'adeojopeter@gmail.com', '2021-08-09 15:47:26', 'ict', 'IT Officer'),
(2, 'ipadeojo', '44a0a65bb2f51e6f86ac1b0f254ac6a3a8188d09', 'Idowu', 'Ade-Ojo', '08033886173', 'ipadeojo@eksu.edu.ng', '2021-08-09 16:32:47', 'cmd', 'Chief Medical Officer'),
(3, 'grace', '716b37cbb85ebeaea079d47aae047a3aed6aaa92', 'Grace', 'Smith', '08035796823', 'gracesmith@maternalchildhosp.com', '2021-08-09 19:53:33', 'rec', 'Records Officer');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` int(11) NOT NULL COMMENT 'primary key',
  `create_time` datetime DEFAULT current_timestamp() COMMENT 'create time',
  `update_time` datetime DEFAULT NULL COMMENT 'update time',
  `cardnumber` varchar(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `patient_view`
--
DROP TABLE IF EXISTS `patient_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `patient_view`  AS   (select `patients`.`id` AS `id`,`patients`.`cardnumber` AS `cardnumber`,`patients`.`firstname` AS `firstname`,`patients`.`lastname` AS `lastname`,`patients`.`phone` AS `phone`,`patients`.`create_time` AS `create_time`,`patients`.`update_time` AS `update_time` from `patients`)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cardnumber` (`cardnumber`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cardnumber` (`cardnumber`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

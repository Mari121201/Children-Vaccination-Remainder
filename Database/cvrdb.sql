-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2024 at 04:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cvrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `doctor_details`
--

CREATE TABLE `doctor_details` (
  `doctor_id` int(11) NOT NULL,
  `dname` varchar(50) DEFAULT NULL,
  `dgender` varchar(10) DEFAULT NULL,
  `specialist` varchar(50) DEFAULT NULL,
  `dcontact` varchar(15) DEFAULT NULL,
  `demail` varchar(100) DEFAULT NULL,
  `dpassword` varchar(50) DEFAULT NULL,
  `hname` varchar(50) DEFAULT NULL,
  `haddress` varchar(100) DEFAULT NULL,
  `hcity` varchar(50) DEFAULT NULL,
  `hstate` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_details`
--

CREATE TABLE `message_details` (
  `message_id` int(11) NOT NULL,
  `message` varchar(200) DEFAULT NULL,
  `appointment` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE `patient_details` (
  `patient_id` int(11) NOT NULL,
  `pname` varchar(50) DEFAULT NULL,
  `pfname` varchar(50) DEFAULT NULL,
  `pmname` varchar(50) DEFAULT NULL,
  `pgender` varchar(10) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `paddress` varchar(100) DEFAULT NULL,
  `pcity` varchar(50) DEFAULT NULL,
  `pstate` varchar(50) DEFAULT NULL,
  `pcontact` varchar(15) DEFAULT NULL,
  `pemail` varchar(100) DEFAULT NULL,
  `ppassword` varchar(50) DEFAULT NULL,
  `pbloodgroup` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctor_details`
--
ALTER TABLE `doctor_details`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `dcontact` (`dcontact`),
  ADD UNIQUE KEY `demail` (`demail`);

--
-- Indexes for table `message_details`
--
ALTER TABLE `message_details`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `pcontact` (`pcontact`),
  ADD UNIQUE KEY `pemail` (`pemail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctor_details`
--
ALTER TABLE `doctor_details`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;

--
-- AUTO_INCREMENT for table `message_details`
--
ALTER TABLE `message_details`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20032;

--
-- AUTO_INCREMENT for table `patient_details`
--
ALTER TABLE `patient_details`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message_details`
--
ALTER TABLE `message_details`
  ADD CONSTRAINT `message_details_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctor_details` (`doctor_id`),
  ADD CONSTRAINT `message_details_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `patient_details` (`patient_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

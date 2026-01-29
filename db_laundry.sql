-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2026 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `laundry_pickups`
--

CREATE TABLE `laundry_pickups` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `pickup_date` datetime DEFAULT current_timestamp(),
  `received_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laundry_transactions`
--

CREATE TABLE `laundry_transactions` (
  `id` int(11) NOT NULL,
  `transaction_date` datetime DEFAULT current_timestamp(),
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `weight` decimal(5,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('Process','Done') DEFAULT 'Process',
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `laundry_transactions`
--

INSERT INTO `laundry_transactions` (`id`, `transaction_date`, `customer_name`, `customer_phone`, `weight`, `price`, `status`, `created_by`) VALUES
(1, '2026-01-30 00:13:57', 'nayla', '0855484', 0.10, 2.00, 'Done', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('Admin','Operator') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `role`, `phone`, `created_at`) VALUES
(1, 'admin', '$2y$10$xHWfqidcLXDlFwnlEz7Cbe2ZLApi1NjAScqS9VVUCsIXvlSVCA.2e', 'Admin', 'Admin', '08728461928194', '2026-01-23 11:48:44'),
(3, 'clarinicious', '$2y$10$yHBWqdLkPXlRWv2FNfzXzOIWA/jj4.g98P5tjUU.iQHweuVfqyNki', 'cla', 'Admin', '08896541398', '2026-01-28 20:13:01'),
(4, 'denisa', '$2y$10$9PCnS4XEYk8uKxG4ZjLRsuNc7rnK8Wc.C.2J7Z6O42/w8cPNy1bQu', 'DENISA', 'Admin', '08555500000', '2026-01-28 20:13:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laundry_pickups`
--
ALTER TABLE `laundry_pickups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `laundry_transactions`
--
ALTER TABLE `laundry_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laundry_pickups`
--
ALTER TABLE `laundry_pickups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laundry_transactions`
--
ALTER TABLE `laundry_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laundry_pickups`
--
ALTER TABLE `laundry_pickups`
  ADD CONSTRAINT `laundry_pickups_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `laundry_transactions` (`id`);

--
-- Constraints for table `laundry_transactions`
--
ALTER TABLE `laundry_transactions`
  ADD CONSTRAINT `laundry_transactions_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

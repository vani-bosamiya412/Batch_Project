-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 10:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_project`
--

CREATE TABLE `batch_project` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `type` enum('Web','Mobile Application') NOT NULL,
  `status` enum('Pending','Complete','On Hold','Continue') NOT NULL DEFAULT 'Pending',
  `members_names` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_project`
--

INSERT INTO `batch_project` (`id`, `client_name`, `title`, `description`, `type`, `status`, `members_names`, `start_date`, `end_date`) VALUES
(2, 'a', 'a', 'abc', 'Mobile Application', 'Complete', 'abc, mno', '2025-11-10', '2026-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `batch_users`
--

CREATE TABLE `batch_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('Designer','Web Developer','App Developer','Tester','Backend') NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_project`
--
ALTER TABLE `batch_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch_users`
--
ALTER TABLE `batch_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_project`
--
ALTER TABLE `batch_project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batch_users`
--
ALTER TABLE `batch_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

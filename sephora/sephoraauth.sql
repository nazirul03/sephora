-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 07:17 PM
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
-- Database: `sephoraauth`
--

-- --------------------------------------------------------

--
-- Table structure for table `failedlogins`
--

CREATE TABLE `failedlogins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `failedlogins`
--

INSERT INTO `failedlogins` (`id`, `user_id`, `failed_attempts`, `locked_until`) VALUES
(1, 1, 0, NULL),
(2, 2, 3, '2024-11-22 11:21:24'),
(3, 3, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mfacodes`
--

CREATE TABLE `mfacodes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `mfa_method` enum('email','sms') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `mfa_method`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', 'hashedpassword123', 'email', '2024-11-22 17:37:38'),
(2, 'nazirul', 'muhammadnazi32@gmail.com', '$2y$10$xAk4bR8x81xfj2Zrlf/WC.8.HK9kcD.sW0Ao9Y0gRkKsr9P0Nxg1a', 'email', '2024-11-22 17:48:24'),
(3, 'ahmad', 'karim76@gmail.com', '$2y$10$7at6I7mt8gNHKiRuqiCWEOmq4TwVZSD4f5i.pjXv6YR/reGYl9l2y', 'email', '2024-11-22 17:53:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failedlogins`
--
ALTER TABLE `failedlogins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mfacodes`
--
ALTER TABLE `mfacodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failedlogins`
--
ALTER TABLE `failedlogins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mfacodes`
--
ALTER TABLE `mfacodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `failedlogins`
--
ALTER TABLE `failedlogins`
  ADD CONSTRAINT `failedlogins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mfacodes`
--
ALTER TABLE `mfacodes`
  ADD CONSTRAINT `mfacodes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

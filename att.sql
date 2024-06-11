-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2024 at 06:39 PM
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
-- Database: `att`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `status` enum('present','absent') DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `device_mac` varchar(17) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `student_id`, `date`, `status`, `event_id`, `student_name`, `device_mac`) VALUES
(76, 6, '2024-05-21', 'present', 29, NULL, '94-E2-3C-50-5D-DE'),
(78, 8, '2024-05-22', 'present', 35, NULL, '94-E2-3C-50-5D-CA'),
(79, 37, '2024-05-22', 'absent', 32, NULL, '02-E2-3C-50-5D-00'),
(80, 37, '2024-05-22', 'present', 35, NULL, '02-E2-3C-50-5D-00'),
(81, 7, '2024-05-22', 'present', 35, NULL, '94-E2-3C-50-5D-CA'),
(82, 16, '2024-05-22', 'absent', 30, NULL, '94-E2-3C-50-5D-CA'),
(83, 12, '2024-05-22', 'present', 35, NULL, '94-E2-3C-50-5D-DE'),
(84, 41, '2024-05-22', 'present', 32, NULL, 'CA:FE:BA:BE:12:34'),
(85, 12, '2024-05-22', 'absent', 39, NULL, '94-E2-3C-50-5D-DE');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL DEFAULT current_timestamp(),
  `event_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `event_time`) VALUES
(32, 'General Assembly', '2024-05-22', '04:09:42'),
(33, 'Eco-Friendly', '2024-05-22', '04:10:13'),
(35, 'Emergency Meeting', '2024-05-22', '04:11:24'),
(36, 'Departmental Election ', '2024-05-22', '04:12:12'),
(39, 'Intramurals', '2024-05-22', '19:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `year_level` int(11) NOT NULL,
  `device_mac` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_name`, `year_level`, `device_mac`) VALUES
(6, 'James Terante', 4, '94-E2-3C-50-5D-DE'),
(7, 'Nissa Malulan', 4, '94-E2-3C-50-5D-CA'),
(8, 'Jessie Boy Plana', 4, '94-E2-3C-50-5D-CA'),
(10, 'Mary Grace Maturan', 4, '94-E2-3C-50-5D-CA'),
(11, 'Justine Palwa', 4, '3E:4B:ED:4F:3R:AE'),
(12, 'Renel Monteza', 4, '94-E2-3C-50-5D-DE'),
(13, 'Johnny Tomboc', 4, '3E:4B:ED:4F:3R:AE'),
(16, 'Kenji Chan', 4, '94-E2-3C-50-5D-CA'),
(37, 'Joseph Maupoy Jr', 4, '02-E2-3C-50-5D-00'),
(38, 'Krisel Ann Gabriento', 3, '00:1A:2B:3C:4D:5E'),
(39, 'Frederick Calagos', 4, '11:22:33:44:55:66'),
(40, 'Michelle Gopio', 3, '12:34:56:78:9A:BC'),
(41, 'Genre Amodia', 3, 'CA:FE:BA:BE:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `password`, `date`) VALUES
(4, 6092398997150508, 'nisa', '$2y$10$EJ36a6V0SlrFlssnagTdnO0skSCgWeXHTPcbjKA9HeuiRMmE82qGi', 2147483647),
(5, 216037922, 'nisang', '$2y$10$zU2541WYklaIJ0M6sVkJzeDytEw7QxEDbxNBNtv/AmrfyDbNDQpLm', 2147483647),
(6, 74540129093100862, 'joseph', '$2y$10$WWlj3cJ473STkEmCsD6VOuphd32P7Vgtu2iftziTJK.P5saeACu5y', 2147483647),
(9, 4983210536600512358, 'admin', '$2y$10$bhSUa29IqIVSDdqigyjA2uS/WX2Gq8JgqpIEZGq4mcHMMdEWHq7J2', 2147483647),
(10, 318952, 'nisa', '$2y$10$MAlE50qlpz8Eq.YsvQH38O3XrvRynewYvmUVyvTpBS5.T9dnHSaXG', 2147483647),
(11, 51166470, 'nisa', '$2y$10$PVXdg6Uu2x6izY5sbQKVEuhdoaqi0WW2gi0saWLrPEFWcno6aAzfa', 2147483647),
(12, 5298042423, 'james', '$2y$10$EIR5uwVQyN1RqEwg5H6r0uzS.zlb3wkw24MEkb0sGjy74VLKvOqh2', 2147483647),
(13, 9115768439, 'ning', '$2y$10$0zug8F0tOB9XYkF3yvHMdeOQhpWWB2cbdVXv9svkHScAaycN1PVnq', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date` (`date`),
  ADD KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

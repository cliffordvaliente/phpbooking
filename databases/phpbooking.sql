-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2023 at 11:28 PM
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
-- Database: `phpbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `assistant`
--

CREATE TABLE `assistant` (
  `assistant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `additional_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `description`) VALUES
(1, 'PHP IS-115', NULL),
(2, 'DATA IS-116', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guidance_sessions`
--

CREATE TABLE `guidance_sessions` (
  `session_id` int(11) NOT NULL,
  `assistant_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `session_theme` varchar(255) DEFAULT NULL,
  `BookingStatus` enum('Pending','Confirmed','Cancelled','Completed') DEFAULT NULL,
  `bookingdate` datetime DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `guidance_sessions`
--

INSERT INTO `guidance_sessions` (`session_id`, `assistant_id`, `course_id`, `length`, `session_theme`, `BookingStatus`, `bookingdate`, `student_id`) VALUES
(17, 9, 1, 20, 'Modul 9', 'Pending', '2023-12-15 11:20:00', NULL),
(20, 9, 1, 15, 'Modul 9', 'Pending', '2023-12-11 10:00:00', NULL),
(22, 9, 2, 45, 'Konkurransebildet', 'Pending', '2023-12-07 14:30:00', NULL),
(23, 8, 2, 15, 'Prøverapport', 'Pending', '2023-12-22 14:15:00', NULL),
(24, 8, 2, 25, 'Konkurransebildet', 'Pending', '2023-12-19 11:00:00', NULL),
(25, 8, 2, 25, 'Verditogbanen', 'Pending', '2023-12-21 10:30:00', NULL),
(26, 8, 2, 50, 'Ølbrygging', 'Pending', '2023-12-27 21:20:00', NULL),
(27, 9, 1, 15, 'Modul 4', 'Pending', '2023-12-19 13:30:00', NULL),
(28, 9, 1, 10, 'Modul 2', 'Pending', '2023-12-13 15:40:00', NULL),
(29, 9, 2, 15, 'Modul 7', 'Pending', '2023-12-24 12:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `mread` tinyint(1) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `additional_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `additional_info`) VALUES
(4, 8, ''),
(5, 9, ''),
(6, 10, ''),
(7, 11, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`student_id`, `course_id`) VALUES
(8, 2),
(9, 1),
(9, 2),
(10, 2),
(11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Student','Assistant') NOT NULL,
  `experience` text DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `availability` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `role`, `experience`, `specialization`, `availability`) VALUES
(8, 'Bark Silas', 'Bark@silas.com', '$2y$10$ShlOoPFG8sRJ404hpPegQO349Zzsz0jai1E0KImjmp.ikyqt1xT8i', 'Assistant', NULL, NULL, NULL),
(9, 'Jon Lilletun', 'Jon@Lilletun.no', '$2y$10$1GFmwju4HL/yc.I6tnM6T.4sOU1fa.m8yrnq6iusD6vXUFh9sEXS.', 'Assistant', NULL, NULL, NULL),
(10, 'Tiger Gutt', 'LilleT@honningmail.com', '$2y$10$w0OEa9svah2ujyHQpeXSHOJWqEeYvWL71f0fnXzr/.NTgg7YIRO8G', 'Student', NULL, NULL, NULL),
(11, 'Ole Brum', 'StoreB@honningmail.com', '$2y$10$sClXZQrSt2/xNNrooParT.oYN2T5Sox4y/SH1gy57RFVl25bqZfHy', 'Student', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assistant`
--
ALTER TABLE `assistant`
  ADD PRIMARY KEY (`assistant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `assistant_id` (`assistant_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `FK_GuidanceSessions_Student` (`student_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assistant`
--
ALTER TABLE `assistant`
  MODIFY `assistant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistant`
--
ALTER TABLE `assistant`
  ADD CONSTRAINT `assistant_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `guidance_sessions`
--
ALTER TABLE `guidance_sessions`
  ADD CONSTRAINT `FK_GuidanceSessions_Student` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `guidance_sessions_ibfk_1` FOREIGN KEY (`assistant_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guidance_sessions_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE SET NULL;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

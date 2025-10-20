-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 19, 2025 at 01:34 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enotice`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` enum('Pending','Resolved') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `title`, `description`, `category`, `department`, `status`, `created_at`) VALUES
(3, 1, 'Projector not working', 'projector of classroom no 345 is not working properly. please fix this complaint immediately', 'Facility Issue', 'Computer Science', 'Pending', '2025-09-13 17:46:54');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_venue` varchar(255) NOT NULL,
  `event_organized_by` varchar(255) NOT NULL,
  `event_target` enum('All','Students','Teachers') NOT NULL DEFAULT 'All',
  `event_department` varchar(100) NOT NULL,
  `event_poster` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `posted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_title`, `event_description`, `event_date`, `event_time`, `event_venue`, `event_organized_by`, `event_target`, `event_department`, `event_poster`, `status`, `posted_at`) VALUES
(1, 'Sample Event', '\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Velit quasi perferendis laboriosam eum magnam quibusdam reiciendis ipsum officiis, dignissimos tenetur maxime accusamus voluptate earum facere quisquam atque, numquam sequi asperiores.', '2025-09-17', '14:57:00', 'MBA seminar Hall', 'UG Department', 'All', 'fashion design', 'uploads/1757878015_Your paragraph text.jpg', 'inactive', '2025-09-14 19:26:55'),
(2, 'Seminar On Topic', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat corporis harum eum velit autem cum, impedit sint vel explicabo amet voluptas itaque ea at nihil deleniti doloribus eligendi rem officiis!', '2025-09-16', '13:00:00', 'Seminar Hall', 'CS Department', 'All', 'Computer Science', 'uploads/1757957398_pexels-kalamar-istvan-norbert-314766-980808.jpg', 'inactive', '2025-09-15 17:29:58'),
(3, 'Tech Fest 2025 – Code Carnival', 'The Department of Computer Science is organizing Tech Fest 2025, featuring coding competitions, hackathons, and project exhibitions. Students are invited to showcase their technical skills.\r\n\r\nDate:', '2025-09-23', '10:35:00', 'College Auditorium', 'Computer Science Association', 'Students', 'Computer Science', 'uploads/1758240088_istockphoto-1164697932-612x612.jpg', 'active', '2025-09-19 00:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
CREATE TABLE IF NOT EXISTS `exams` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_title` varchar(255) DEFAULT NULL,
  `exam_type` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `exam_title`, `exam_type`, `department`, `location`, `created_at`) VALUES
(1, 'term exam', 'Internal', 'Computer Science', 'gfyuvu', '2025-08-25 12:30:21'),
(2, 'term exam', 'Semester', 'Commerce', '102', '2025-09-08 22:33:45'),
(3, 'S3 BCA Exam', 'Internal', 'Computer Science', '102', '2025-09-09 00:19:35'),
(4, 'term exam', 'Internal', 'Computer Science', '102', '2025-09-09 00:29:31'),
(5, 'term exam', 'Internal', 'Computer Science', '102', '2025-09-09 00:30:09'),
(6, 'term exam', 'Internal', 'Computer Science', '102', '2025-09-09 00:31:07'),
(7, 'S3 BCA Exam', 'Internal', 'Computer Science', '102', '2025-09-14 09:31:37'),
(8, 'MCA Semester 3 Internal Examination', 'Internal', 'Computer Science', '102', '2025-09-19 05:28:27'),
(9, 'MCA Semester 3 Internal Examination', 'Internal', 'Computer Science', '102', '2025-09-19 05:29:02'),
(10, 'MCA Semester 3 Internal Examination', 'Internal', 'Computer Science', '102', '2025-09-19 05:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `holiday_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `department` varchar(100) NOT NULL,
  `target` enum('students','teachers','all') NOT NULL DEFAULT 'all',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `posted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `title`, `description`, `holiday_date`, `start_date`, `end_date`, `department`, `target`, `status`, `posted_at`) VALUES
(1, 'Onam Holiday', 'Public holiday', NULL, '2025-09-11', '2025-09-10', 'Computer Science', 'all', 'inactive', '2025-09-13 05:32:37'),
(2, 'Onam Holiday', 'Public holiday', NULL, '2025-09-15', '2025-09-15', 'Computer Science', 'all', 'inactive', '2025-09-12 05:32:44'),
(3, 'Onam Holiday', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi nihil ex doloribus eius enim dolores maxime quia neque, ab culpa qui, consequatur aliquam nemo ipsum, deserunt architecto libero explicabo inventore.', NULL, '2025-09-15', '2025-09-15', 'Computer Science', 'all', 'inactive', '2025-09-13 05:34:49'),
(4, 'Onam Holiday', 'Public holiday', NULL, '2025-09-15', '2025-09-15', 'Computer Science', 'all', 'inactive', '2025-09-13 05:42:11'),
(5, 'onam holiday', 'holiday announcement', '2025-01-13', NULL, NULL, 'Computer Science', 'students', 'inactive', '2025-09-11 05:45:31'),
(6, 'onam holiday', 'holiday announcement', '2025-09-14', NULL, NULL, 'Computer Science', 'students', 'inactive', '2025-01-13 05:51:17'),
(7, 'Gandhi Jayanthi Holiday', 'The college will remain closed on October 2, 2025, in observance of Gandhi Jayanthi. Regular classes will resume on the next working day.', '2025-10-02', NULL, NULL, 'All', 'all', 'active', '2025-09-18 23:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
CREATE TABLE IF NOT EXISTS `notices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `department` varchar(100) DEFAULT NULL,
  `target` enum('students','teachers','all') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'all',
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `posted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `description`, `department`, `target`, `valid_from`, `valid_until`, `status`, `posted_at`) VALUES
(13, 'hello testing', 'test', 'Computer Science', 'students', '2025-09-10', '2025-09-11', 'inactive', '2025-09-08 14:07:04'),
(12, 'hello testing', 'test', 'Computer Science', 'students', '2025-09-10', '2025-09-11', 'inactive', '2025-09-08 13:59:25'),
(26, 'Workshop on Web Development', 'A one-day workshop on Full Stack Web Development will be conducted on October 25, 2025, at the college auditorium. Students interested in web technologies are encouraged to participate. Registration is open at the department office.', 'Computer Science', 'students', '2025-09-19', '2025-09-25', 'active', '2025-09-18 23:51:34'),
(27, 'Library Books Submission', 'Students are reminded to return all library books by September 30, 2025, to avoid late fees. Books can be submitted at the circulation desk during working hours.', 'Computer Science', 'students', '2025-09-19', '2025-09-30', 'active', '2025-09-18 23:54:02'),
(21, 'Targetted all department ', 'asdasasd', 'Business Administration', 'all', '2025-09-15', '2025-09-17', 'inactive', '2025-09-08 15:20:03'),
(23, 'sdnabsdbakssadb', 'asvjhhvasdd', 'Fashion Design', 'all', '2025-09-10', '2025-09-18', 'inactive', '2025-09-08 15:24:25'),
(24, 'Exam Notification', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, veniam architecto molestiae consequuntur aspernatur nulla minima harum quasi iste sunt. Hic nihil illum recusandae numquam a tempora assumenda alias aut.', 'Computer Science', 'students', '2025-09-14', '2025-09-16', 'inactive', '2025-09-13 05:44:07'),
(25, 'Sample text Notice', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deserunt porro modi unde numquam, magni aspernatur odit ipsa ea ex distinctio perspiciatis eius nam officiis enim, deleniti reiciendis voluptatibus? Quidem, obcaecati.', 'Computer Science', 'all', '2025-09-15', '2025-09-17', 'inactive', '2025-09-14 05:27:15'),
(28, 'Campus Placement Drive – Infosys', 'Infosys will conduct a campus recruitment drive on October 12, 2025. Eligible final-year students are requested to register with the placement cell before October 5, 2025.', 'Computer Science', 'all', '2025-09-19', '2025-10-12', 'active', '2025-09-18 23:55:40');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `student_id`, `contact`, `department`) VALUES
(1, 9, '24124', '9946274845', 'Computer Science'),
(2, 3, '24125', '9847114845', 'Psychology'),
(3, 4, '123456', '9847114845', 'Computer Science'),
(4, 6, '566890', '8137902413', 'Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `exam_id` int DEFAULT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `exam_date` date DEFAULT NULL,
  `session` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `exam_id`, `subject_name`, `exam_date`, `session`, `status`) VALUES
(1, 1, 'cloud computing', '2025-08-26', '', 'inactive'),
(2, 2, 'Cloud', '2025-09-09', 'FN', 'inactive'),
(3, 3, 'Data structure', '2025-10-15', 'FN', 'active'),
(4, 4, 'Cloud', '2025-09-10', 'FN', 'inactive'),
(5, 5, 'Data structure', '2025-09-09', 'AN', 'inactive'),
(6, 6, 'Cloud', '2025-09-09', 'AN', 'inactive'),
(7, 7, 'Cloud', '2025-09-16', 'FN', 'inactive'),
(8, 7, 'Data structure', '2025-09-17', 'FN', 'inactive'),
(9, 8, 'Data Structures', '2025-09-23', '9:00 AM - 12:00 PM', 'active'),
(10, 9, 'Database Management Systems', '2025-09-24', '9:00 AM - 12:00 PM', 'active'),
(11, 10, 'Software Engineering', '2025-09-26', '1:00 PM - 4:00 PM', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id` (`employee_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `employee_id`, `contact`, `department`) VALUES
(1, 2, '1001', '9847114845', 'Computer Science'),
(3, 7, '200018', '9846274845', 'Computer Science'),
(4, 8, '200012', '9747721216', 'Computer Science');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` enum('student','teacher','admin') DEFAULT 'student',
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `email_notify` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `role`, `status`, `email_notify`, `created_at`, `updated_at`) VALUES
(9, 'Kannan KB', 'kbkannan2001@gmail.com', '$2y$10$A.Qe61snH62YBVp2FQ5lE.lDukmt168l.XP/R4wNQUDYd0ploLGPG', NULL, 'student', 'approved', 1, '2025-09-04 16:27:10', '2025-09-18 23:23:23'),
(2, 'Jamin', 'jasmin@gmail.com', '$2y$10$zrNM/PCdh3eICsatgMC60uTnlhP85nNkb9x6zQ.9Emnr4xcU1KDdW', NULL, 'teacher', 'pending', 0, '2025-09-05 03:17:39', '2025-09-14 05:22:51'),
(4, 'Fathima', 'fathima@gmail.com', '$2y$10$I7Da25099x.tjD8IhfNjx.WSQNpPCaPfuzMTJn.DMwjZIzus7Qo7W', NULL, 'student', 'approved', 0, '2025-09-05 08:35:28', '2025-09-18 23:22:32'),
(1, 'Admin', 'admin@gmail.com', '$2y$10$HTJx8QK9JB6v8jSfFYA.N.wC7BW6rLuqV/Yg56Z4LGvmM4VeWVVWy', NULL, 'admin', 'approved', 0, '2025-09-05 09:28:02', '2025-09-18 23:23:34'),
(6, 'Adarsh', 'adarsh@gmail.com', '$2y$10$U9jx7KYg38JfkyOcZ.yrxuI4XYUnWKcLboF9KyuhdQbkOPCSuY8zG', NULL, 'student', 'approved', 0, '2025-09-06 10:55:31', '2025-09-18 23:38:05'),
(8, 'Sarah Thomson', 'sarah@gmail.com', '$2y$10$ZwzzhmcrUoeVpsPsIxZr..hKZWPrWCzcQ/r/wRqpNGpj.lGmeud06', NULL, 'teacher', 'approved', 1, '2025-09-14 03:17:55', '2025-09-18 23:22:58');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

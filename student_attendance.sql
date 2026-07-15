-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2026 at 06:47 PM
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
-- Database: `student_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `grading_system_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `category` enum('Written Work','Performance Task','Quarterly Exam','Attendance') NOT NULL,
  `activity_name` varchar(150) NOT NULL,
  `score` decimal(7,2) DEFAULT NULL,
  `highest_possible_score` decimal(7,2) NOT NULL DEFAULT 100.00,
  `date_given` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `grading_system_id`, `teacher_id`, `student_id`, `category`, `activity_name`, `score`, `highest_possible_score`, `date_given`, `remarks`, `created_at`) VALUES
(1, 1, 9, 2, 'Written Work', 'quiz1', 10.00, 20.00, '2026-06-18', '', '2026-06-18 07:50:42'),
(2, 1, 9, 2, 'Performance Task', 'assigment', 38.00, 50.00, '2026-06-18', '', '2026-06-18 08:08:43'),
(3, 1, 9, 2, 'Quarterly Exam', 'exam', 40.00, 50.00, '2026-06-18', '', '2026-06-18 08:10:19');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `description`, `created_at`) VALUES
(1, 1, 'Login', 'User logged in', '2026-05-22 06:25:35'),
(2, 1, 'Teacher Added', 'Added new teacher: Ralph Laurence Garlejo', '2026-05-22 06:26:31'),
(3, 1, 'Student Added', 'Added student: Ralph Laurence Garlejo (STU20269215)', '2026-05-22 06:27:51'),
(4, 1, 'Attendance Scanned', 'Scanned attendance for Ralph Laurence Garlejo - Status: Late', '2026-05-22 06:28:39'),
(5, 1, 'Student Added', 'Added student: Guian Agarrado (STU20264658)', '2026-05-22 08:32:17'),
(6, 1, 'Student Added', 'Added student: test ting (STU20265478)', '2026-05-22 08:57:22'),
(7, 1, 'Attendance Scanned', 'Scanned attendance for test ting - Status: Late', '2026-05-22 08:57:46'),
(8, 1, 'Student Deleted', 'Deleted student: Ralph Laurence Garlejo (STU20269215)', '2026-05-22 09:03:20'),
(9, 1, 'Student Added', 'Added student: Ralph Laurence Garlejo (STU20262647)', '2026-05-22 09:03:41'),
(10, 1, 'Student Deleted', 'Deleted student with ID: 1', '2026-05-22 09:03:41'),
(11, 1, 'Attendance Scanned', 'Scanned attendance for Ralph Laurence Garlejo - Status: Late', '2026-05-22 09:04:08'),
(12, 1, 'Student Added', 'Added student: erich arriola (STU20264713)', '2026-05-22 09:18:47'),
(13, 1, 'Student Added', 'Added student: erich arriola (STU20264436)', '2026-05-22 09:19:01'),
(14, 1, 'Student Added', 'Added student: erich arriola (STU20263966)', '2026-05-22 12:11:11'),
(15, 1, 'Student Deleted', 'Deleted student: Ralph Laurence Garlejo (STU20262647)', '2026-05-22 13:13:12'),
(16, 1, 'Student Added', 'Added student: Ralph Laurence Garlejo (STU20265394)', '2026-05-22 13:13:59'),
(17, 1, 'Student Deleted', 'Deleted student with ID: 4', '2026-05-22 13:13:59'),
(18, 1, 'Student Updated', 'Updated student: erich arriola (ID: STU20263966)', '2026-05-22 13:50:13'),
(19, 1, 'Student Updated', 'Updated student: Guian Agarrado (ID: STU20264658)', '2026-05-22 13:50:34'),
(20, 1, 'Attendance Scanned', 'Scanned: Ralph Laurence Garlejo — Late', '2026-05-22 13:55:04'),
(21, 1, 'Attendance Scanned', 'Scanned: erich arriola — Late', '2026-05-22 13:55:37'),
(22, 1, 'Student Deleted', 'Deleted student: erich arriola (STU20264713)', '2026-05-22 14:10:51'),
(23, 1, 'Student Deleted', 'Deleted student: erich arriola (STU20264436)', '2026-05-22 14:10:55'),
(24, 1, 'Student Deleted', 'Deleted student: erich arriola (STU20263966)', '2026-05-22 14:11:01'),
(25, 1, 'Student Added', 'Added student: erich arriola (STU20267916)', '2026-05-22 14:11:51'),
(26, 1, 'Student Deleted', 'Deleted student with ID: 7', '2026-05-22 14:11:51'),
(27, 1, 'Attendance Scanned', 'Scanned: erich arriola — Late', '2026-05-22 14:12:16'),
(28, 1, 'Student Added', 'Added student: erich arriola (STU20264343)', '2026-05-23 04:09:17'),
(29, 1, 'Student Deleted', 'Deleted student with ID: 7', '2026-05-23 04:09:17'),
(30, 1, 'Student Added', 'Added student: erich arriola (STU20260656)', '2026-05-23 07:38:16'),
(31, 1, 'Student Deleted', 'Deleted student with ID: 7', '2026-05-23 07:38:16'),
(32, 1, 'Teacher Deleted', 'Deleted teacher ID: 2', '2026-05-23 11:44:44'),
(33, 1, 'Teacher Added', 'Added: Ralph Laurence Garlejo (Admin)', '2026-05-23 11:45:32'),
(34, 1, 'Teacher Deleted', 'Deleted teacher ID: 2', '2026-05-23 11:45:32'),
(35, NULL, 'Login', 'User logged in', '2026-05-23 11:46:02'),
(36, NULL, 'Login', 'User logged in', '2026-05-23 11:46:23'),
(37, NULL, 'Login', 'User logged in', '2026-05-23 12:21:52'),
(38, 1, 'Login', 'User logged in', '2026-05-23 12:37:33'),
(39, NULL, 'Login', 'User logged in', '2026-05-23 12:38:02'),
(40, 1, 'Login', 'User logged in', '2026-05-23 12:41:24'),
(41, 1, 'Teacher Deleted', 'Deleted teacher ID: 3', '2026-05-23 12:41:31'),
(42, 1, 'Teacher Added', 'Added: test Teacher (Teacher)', '2026-05-23 12:42:22'),
(43, 1, 'Teacher Deleted', 'Deleted teacher ID: 3', '2026-05-23 12:42:22'),
(44, 4, 'Login', 'User logged in', '2026-05-23 12:42:38'),
(45, 1, 'Login', 'User logged in', '2026-05-23 12:43:40'),
(46, 4, 'Login', 'User logged in', '2026-05-23 14:27:56'),
(47, 1, 'Login', 'User logged in', '2026-06-02 03:24:03'),
(48, 1, 'Attendance Scanned', 'Scanned: Guian Agarrado — Late', '2026-06-02 04:16:05'),
(49, 1, 'Student Updated', 'Updated student: Guian Agarrado (ID: STU20264658)', '2026-06-02 15:19:26'),
(50, 1, 'Teacher Added', 'Added: ako ikw (Teacher)', '2026-06-02 15:51:21'),
(51, 1, 'Login', 'User logged in', '2026-06-04 18:20:40'),
(52, 1, 'Login', 'User logged in', '2026-06-04 18:21:28'),
(53, 1, 'Attendance Scanned', 'Scanned: Guian Agarrado — Present', '2026-06-04 18:22:43'),
(54, 4, 'Login', 'User logged in', '2026-06-04 18:25:28'),
(55, 1, 'Login', 'User logged in', '2026-06-04 18:26:37'),
(56, 9, 'Login', 'User logged in', '2026-06-04 18:27:08'),
(57, 9, 'Attendance Scanned', 'Scanned: erich arriola — Present', '2026-06-04 18:29:00'),
(58, 9, 'Login', 'User logged in', '2026-06-15 16:33:58'),
(59, 9, 'Login', 'User logged in', '2026-06-18 06:37:27'),
(60, 9, 'Attendance Marked', 'Student 2 → Present on 2026-06-18', '2026-06-18 08:10:57'),
(61, 9, 'Login', 'User logged in', '2026-06-20 03:03:18'),
(62, 1, 'Login', 'User logged in', '2026-06-28 07:09:02'),
(63, 1, 'Attendance Scanned', 'Scanned: Guian Agarrado — Late', '2026-06-28 07:14:56'),
(64, 1, 'Login', 'User logged in', '2026-07-11 02:56:16'),
(65, 1, 'Settings Updated', 'Updated school settings', '2026-07-11 03:41:42'),
(66, 1, 'Login', 'User logged in', '2026-07-11 07:34:45'),
(67, 1, 'Login', 'User logged in', '2026-07-11 08:08:45'),
(68, 9, 'Login', 'User logged in', '2026-07-11 08:29:04'),
(69, 9, 'Login', 'User logged in', '2026-07-11 08:42:35'),
(70, 9, 'Attendance Marked', 'Student 2 → Absent on 2026-07-11', '2026-07-11 08:42:49'),
(71, 9, 'Attendance Marked', 'Student 2 → Present on 2026-07-11', '2026-07-11 08:42:55'),
(72, 9, 'Login', 'User logged in', '2026-07-11 08:43:24'),
(73, 1, 'Login', 'User logged in', '2026-07-11 08:45:12'),
(74, 9, 'Login', 'User logged in', '2026-07-12 13:31:14'),
(75, 1, 'Login', 'User logged in', '2026-07-12 13:37:30'),
(76, 1, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:45:54'),
(77, 4, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:45:54'),
(78, 9, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:45:54'),
(79, 1, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:50:19'),
(80, 4, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:50:19'),
(81, 9, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:50:19'),
(82, 1, 'Announcement:  for ', NULL, '2026-07-12 13:50:19'),
(83, 4, 'Announcement:  for ', NULL, '2026-07-12 13:50:19'),
(84, 9, 'Announcement:  for ', NULL, '2026-07-12 13:50:19'),
(85, 1, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:57:01'),
(86, 4, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:57:01'),
(87, 9, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 13:57:01'),
(88, 1, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:07:22'),
(89, 4, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:07:23'),
(90, 9, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:07:23'),
(91, 9, 'Login', 'User logged in', '2026-07-12 14:07:44'),
(92, 9, 'Login', 'User logged in', '2026-07-12 14:15:30'),
(93, 9, 'Login', 'User logged in', '2026-07-12 14:15:31'),
(94, 1, 'Login', 'User logged in', '2026-07-12 14:22:26'),
(95, 1, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:23:14'),
(96, 4, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:23:14'),
(97, 9, 'Announcement: suspended for 2026-07-14', NULL, '2026-07-12 14:23:14'),
(98, 9, 'Login', 'User logged in', '2026-07-12 14:24:02'),
(99, 1, 'Login', 'User logged in', '2026-07-12 14:46:31'),
(100, 1, 'Settings Updated', 'Updated school settings', '2026-07-12 14:53:14'),
(101, 1, 'Settings Updated', 'Updated school settings', '2026-07-12 14:53:31'),
(102, 1, 'Settings Updated', 'Updated school settings', '2026-07-12 14:53:36'),
(103, 1, 'Login', 'User logged in', '2026-07-13 11:26:10'),
(104, 1, 'Login', 'User logged in', '2026-07-13 14:34:15'),
(105, 1, 'Attendance Scanned', 'Scanned: Guian Agarrado — Late', '2026-07-13 14:34:47'),
(106, 9, 'Login', 'User logged in', '2026-07-13 14:38:27'),
(107, 9, 'Attendance Marked', 'Student 2 → Present on 2026-07-13', '2026-07-13 14:38:35'),
(108, 9, 'Attendance Marked', 'Student 2 → Present on 2026-07-13', '2026-07-13 14:39:46'),
(109, 9, 'Login', 'User logged in', '2026-07-13 16:31:35'),
(110, 1, 'Login', 'User logged in', '2026-07-13 16:33:44'),
(111, 1, 'Login', 'User logged in', '2026-07-13 16:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_type` enum('announcement','suspension','holiday','meeting','other') DEFAULT 'announcement',
  `target_audience` enum('all','teachers','students','admin') DEFAULT 'all',
  `is_suspension` tinyint(1) DEFAULT 0,
  `suspension_reason` text DEFAULT NULL,
  `sent_to_teachers` tinyint(1) DEFAULT 0,
  `sent_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `description`, `event_date`, `event_type`, `target_audience`, `is_suspension`, `suspension_reason`, `sent_to_teachers`, `sent_at`, `created_by`, `created_at`, `updated_at`) VALUES
(6, 'suspended', 'ulan', '2026-07-14', 'suspension', 'all', 0, '0', 1, '2026-07-12 22:23:14', 1, '2026-07-12 14:23:14', '2026-07-12 14:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `status` enum('Present','Late','Absent','Early_Dismissal','Excused') NOT NULL DEFAULT 'Present',
  `scan_method` enum('QR_Code','Manual','RFID','Barcode') NOT NULL DEFAULT 'QR_Code',
  `notes` text DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `late_minutes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `check_in_time`, `check_out_time`, `status`, `scan_method`, `notes`, `teacher_id`, `late_minutes`, `created_at`, `updated_at`) VALUES
(2, 2, '2026-05-22', '16:33:18', NULL, 'Late', 'QR_Code', NULL, 1, 513, '2026-05-22 08:33:18', '2026-05-22 08:33:18'),
(3, 3, '2026-05-22', '16:57:42', NULL, 'Late', 'QR_Code', NULL, 1, 538, '2026-05-22 08:57:42', '2026-05-22 08:57:42'),
(5, 8, '2026-05-22', '21:53:55', NULL, 'Late', 'QR_Code', NULL, 1, 834, '2026-05-22 13:53:55', '2026-05-22 13:53:55'),
(7, 9, '2026-05-22', '22:12:12', NULL, 'Late', 'QR_Code', NULL, 1, 852, '2026-05-22 14:12:12', '2026-05-22 14:12:12'),
(8, 2, '2026-06-02', '12:15:56', NULL, 'Late', 'QR_Code', NULL, 1, 256, '2026-06-02 04:15:56', '2026-06-02 04:15:56'),
(9, 2, '2026-06-05', '02:22:24', NULL, 'Present', 'QR_Code', NULL, 1, 0, '2026-06-04 18:22:24', '2026-06-04 18:22:24'),
(10, 9, '2026-06-05', '02:28:56', NULL, 'Present', 'QR_Code', NULL, 9, 0, '2026-06-04 18:28:56', '2026-06-04 18:28:56'),
(11, 2, '2026-06-18', '16:10:57', NULL, 'Present', 'Manual', '', 9, 0, '2026-06-18 08:10:57', '2026-06-18 08:10:57'),
(12, 2, '2026-06-28', '15:14:30', NULL, 'Late', 'QR_Code', NULL, 1, 435, '2026-06-28 07:14:30', '2026-06-28 07:14:30'),
(13, 2, '2026-07-11', '16:42:55', NULL, 'Present', 'Manual', NULL, 9, 0, '2026-07-11 08:42:49', '2026-07-11 08:42:55'),
(14, 2, '2026-07-13', '22:39:46', NULL, 'Present', 'QR_Code', '', 9, 875, '2026-07-13 14:34:35', '2026-07-13 14:39:46');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` int(11) NOT NULL,
  `session_name` varchar(100) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `session_type` enum('Morning','Afternoon','Full_Day') NOT NULL DEFAULT 'Full_Day',
  `grade_levels` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_sessions`
--

INSERT INTO `attendance_sessions` (`id`, `session_name`, `start_time`, `end_time`, `session_type`, `grade_levels`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Morning Session', '07:30:00', '12:00:00', 'Morning', '[\"Grade 1\",\"Grade 2\",\"Grade 3\",\"Grade 4\",\"Grade 5\",\"Grade 6\"]', 1, '2026-05-22 04:38:53', '2026-05-22 04:38:53'),
(2, 'Afternoon Session', '13:00:00', '17:30:00', 'Afternoon', '[\"Grade 7\",\"Grade 8\",\"Grade 9\",\"Grade 10\"]', 1, '2026-05-22 04:38:53', '2026-05-22 04:38:53'),
(3, 'Full Day Session', '07:30:00', '17:30:00', 'Full_Day', '[\"Grade 11\",\"Grade 12\"]', 1, '2026-05-22 04:38:53', '2026-05-22 04:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `grading_system`
--

CREATE TABLE `grading_system` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `grade_level` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `quarter` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-4',
  `written_work_pct` decimal(5,2) NOT NULL DEFAULT 25.00,
  `performance_task_pct` decimal(5,2) NOT NULL DEFAULT 50.00,
  `quarterly_exam_pct` decimal(5,2) NOT NULL DEFAULT 25.00,
  `passing_grade` decimal(5,2) NOT NULL DEFAULT 75.00,
  `school_year` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grading_system`
--

INSERT INTO `grading_system` (`id`, `teacher_id`, `subject_name`, `grade_level`, `section`, `quarter`, `written_work_pct`, `performance_task_pct`, `quarterly_exam_pct`, `passing_grade`, `school_year`, `created_at`, `updated_at`) VALUES
(1, 9, 'All Subjects', 'Grade 11', 'b', 1, 25.00, 50.00, 25.00, 75.00, '2026-2027', '2026-06-18 07:50:03', '2026-06-18 07:50:03');

-- --------------------------------------------------------

--
-- Table structure for table `parent_accounts`
--

CREATE TABLE `parent_accounts` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_accounts`
--

INSERT INTO `parent_accounts` (`id`, `student_id`, `username`, `password`, `full_name`, `email`, `phone`, `created_at`, `last_login`, `status`) VALUES
(1, 2, 'agarradoguian', '184374403537', 'Agarrado, Guian', NULL, NULL, '2026-07-13 14:20:20', '2026-07-13 22:45:29', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `parent_preferences`
--

CREATE TABLE `parent_preferences` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `sms_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `email_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `absence_alerts` tinyint(1) NOT NULL DEFAULT 1,
  `late_alerts` tinyint(1) NOT NULL DEFAULT 1,
  `early_dismissal_alerts` tinyint(1) NOT NULL DEFAULT 1,
  `daily_summary` tinyint(1) NOT NULL DEFAULT 0,
  `opt_out_date` timestamp NULL DEFAULT NULL,
  `opt_out_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parent_preferences`
--

INSERT INTO `parent_preferences` (`id`, `student_id`, `parent_phone`, `sms_enabled`, `email_enabled`, `absence_alerts`, `late_alerts`, `early_dismissal_alerts`, `daily_summary`, `opt_out_date`, `opt_out_reason`, `created_at`, `updated_at`) VALUES
(2, 2, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-22 08:32:17', '2026-05-22 08:32:17'),
(3, 3, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-22 08:57:22', '2026-05-22 08:57:22'),
(8, 8, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-22 13:13:59', '2026-05-22 13:13:59'),
(9, 9, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-22 14:11:51', '2026-05-22 14:11:51'),
(10, 10, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-23 04:09:17', '2026-05-23 04:09:17'),
(11, 11, '+639066341073', 1, 0, 1, 1, 1, 0, NULL, NULL, '2026-05-23 07:38:16', '2026-05-23 07:38:16');

-- --------------------------------------------------------

--
-- Table structure for table `report_visibility`
--

CREATE TABLE `report_visibility` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `report_type` enum('attendance','report_card','activities') NOT NULL,
  `is_visible` tinyint(1) DEFAULT 0,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quarter` int(11) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report_visibility`
--

INSERT INTO `report_visibility` (`id`, `student_id`, `report_type`, `is_visible`, `submitted_by`, `submitted_at`, `quarter`, `school_year`) VALUES
(1, 2, 'activities', 0, 9, '2026-07-13 16:31:51', 1, '2026'),
(2, 2, 'attendance', 0, 9, '2026-07-13 16:31:49', 1, '2026'),
(3, 2, 'report_card', 0, 9, '2026-07-13 16:31:50', 1, '2026');

-- --------------------------------------------------------

--
-- Table structure for table `school_settings`
--

CREATE TABLE `school_settings` (
  `id` int(11) NOT NULL,
  `school_name` varchar(200) NOT NULL DEFAULT 'School Name',
  `school_address` text DEFAULT NULL,
  `school_phone` varchar(20) DEFAULT NULL,
  `school_email` varchar(200) DEFAULT NULL,
  `school_principal` varchar(200) DEFAULT NULL,
  `school_logo` varchar(255) DEFAULT NULL,
  `late_cutoff_time` time NOT NULL DEFAULT '08:00:00',
  `early_dismissal_time` time NOT NULL DEFAULT '15:00:00',
  `attendance_check_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sms_notifications_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sms_template_present` text NOT NULL DEFAULT '[School Name] Attendance Alert: {student_name} ({grade} - {section}) arrived at {time} on {date}. Status: Present. Reply STOP to unsubscribe.',
  `sms_template_late` text NOT NULL DEFAULT '[School Name] Attendance Alert: {student_name} ({grade} - {section}) arrived at {time} on {date}. Status: Late ({late_minutes} minutes). Reply STOP to unsubscribe.',
  `sms_template_absent` text NOT NULL DEFAULT '[School Name] Attendance Alert: {student_name} ({grade} - {section}) was marked absent on {date}. Please contact the school office. Reply STOP to unsubscribe.',
  `sms_template_early_dismissal` text NOT NULL DEFAULT '[School Name] Attendance Alert: {student_name} ({grade} - {section}) left early at {time} on {date}. Reply STOP to unsubscribe.',
  `timezone` varchar(50) NOT NULL DEFAULT 'Asia/Manila',
  `academic_year_start` date NOT NULL,
  `academic_year_end` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_settings`
--

INSERT INTO `school_settings` (`id`, `school_name`, `school_address`, `school_phone`, `school_email`, `school_principal`, `school_logo`, `late_cutoff_time`, `early_dismissal_time`, `attendance_check_enabled`, `sms_notifications_enabled`, `sms_template_present`, `sms_template_late`, `sms_template_absent`, `sms_template_early_dismissal`, `timezone`, `academic_year_start`, `academic_year_end`, `created_at`, `updated_at`) VALUES
(1, 'Lamian National High School', '123 School Street, City, Country', '', '', 'Ralph Garlejo', 'uploads/school_logo.jpg', '08:00:00', '00:00:00', 1, 1, 'Lamian National High School Attendance Alert: {student_name} ({grade} - {section}) arrived at {time} on {date}. Status: Present. Reply STOP to unsubscribe.', 'Lamian National High School Attendance Alert: {student_name} ({grade} - {section}) arrived at {time} on {date}. Status: Late ({late_minutes} minutes). Reply STOP to unsubscribe.', 'Lamian National High School Attendance Alert: {student_name} ({grade} - {section}) was marked absent on {date}. Please contact the school office. Reply STOP to unsubscribe.', 'Lamian National High School Attendance Alert: {student_name} ({grade} - {section}) left early at {time} on {date}. Reply STOP to unsubscribe.', 'Asia/Manila', '2024-06-01', '2025-03-31', '2026-05-22 04:38:51', '2026-07-12 14:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `sms_logs`
--

CREATE TABLE `sms_logs` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `message_type` enum('Check_In','Late','Absent','Early_Dismissal','Custom') NOT NULL,
  `message_content` text NOT NULL,
  `sms_provider` varchar(50) NOT NULL DEFAULT 'AndroidSMSGateway',
  `sms_id` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Sent','Delivered','Failed') NOT NULL DEFAULT 'Pending',
  `error_message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_logs`
--

INSERT INTO `sms_logs` (`id`, `student_id`, `attendance_id`, `parent_phone`, `message_type`, `message_content`, `sms_provider`, `sms_id`, `status`, `error_message`, `sent_at`, `delivered_at`, `created_at`) VALUES
(2, 2, 2, '+639066341073', 'Late', '[School Name] Attendance Alert: Guian Agarrado (Grade 8 - b) arrived at 04:33 PM on May 22, 2026. Status: Late (513 minutes). Reply STOP to unsubscribe.', 'AndroidSMSGateway', NULL, 'Pending', NULL, NULL, NULL, '2026-05-22 08:33:18'),
(3, 3, 3, '+639066341073', 'Late', '[School Name] Attendance Alert: test ting (Grade 10 - A) arrived at 04:57 PM on May 22, 2026. Status: Late (538 minutes). Reply STOP to unsubscribe.', 'AndroidSMSGateway', NULL, 'Failed', '[url] /api/3rdparty/v1/message [http method] POST [status code] 401 [reason phrase] Unauthorized', NULL, NULL, '2026-05-22 08:57:42'),
(5, 8, 5, '+639066341073', 'Late', 'Good day, Lorena Garlejo! Your child Ralph Laurence Garlejo (Grade 10 - A) has arrived LATE at Sample School at 09:53 PM on May 22, 2026 (834 min late). Please remind them to come on time. Thank you!', 'AndroidGateway', NULL, 'Failed', 'Idle timeout reached for \"https://sms.capcom.me/api/3rdparty/v1/message\".', NULL, NULL, '2026-05-22 13:53:55'),
(7, 9, 7, '+639066341073', 'Late', 'Good day, Ralph! Your child erich arriola (Grade 10 - C) has arrived LATE at Sample School at 10:12 PM on May 22, 2026 (852 min late). Please remind them to come on time. Thank you!', 'AndroidGateway', 'syLfwp5zJGokCmNAPZiLl', 'Sent', NULL, '2026-05-22 14:12:16', NULL, '2026-05-22 14:12:12'),
(8, 2, 8, '+639066341073', 'Late', 'Good day, Ralph! Your child Guian Agarrado (Grade 8 - b) has arrived LATE at Sample School at 12:15 PM on June 2, 2026 (256 min late). Please remind them to come on time. Thank you!', 'AndroidGateway', 'gJ2hiLHjx3z_NYAK_18re', 'Sent', NULL, '2026-06-02 04:16:05', NULL, '2026-06-02 04:15:56'),
(9, 2, 9, '+639066341073', 'Check_In', 'Good day, Ralph! Your child Guian Agarrado (Grade 11 - b) has safely arrived at Sample School and is now present as of 02:22 AM on June 5, 2026. Thank you!', 'AndroidGateway', 'ugub6SywgvtmCvV8d7WG9', 'Sent', NULL, '2026-06-04 18:22:43', NULL, '2026-06-04 18:22:24'),
(10, 9, 10, '+639066341073', 'Check_In', 'Good day, Ralph! Your child erich arriola (Grade 10 - C) has safely arrived at Sample School and is now present as of 02:28 AM on June 5, 2026. Thank you!', 'AndroidGateway', '8yrvmThpqc8e1YGUJhzva', 'Sent', NULL, '2026-06-04 18:29:00', NULL, '2026-06-04 18:28:56'),
(11, 2, 12, '+639066341073', 'Late', 'Good day, Ralph! Your child Guian Agarrado (Grade 11 - b) has arrived LATE at Sample School at 03:14 PM on June 28, 2026 (435 min late). Please remind them to come on time. Thank you!', 'AndroidGateway', NULL, 'Failed', 'Failed to connect to sms.capcom.me port 443 after 21497 ms: Couldn\'t connect to server for \"https://sms.capcom.me/api/3rdparty/v1/message\".', NULL, NULL, '2026-06-28 07:14:30'),
(12, 2, 14, '+639066341073', 'Late', 'Good day, Ralph! Your child Guian Agarrado (Grade 11 - b) has arrived LATE at Lamian National High School at 10:34 PM on July 13, 2026 (875 min late). Please remind them to come on time. Thank you!', 'AndroidGateway', 'tm-i8fdab_Fi1wrEqU2Me', 'Sent', NULL, '2026-07-13 14:34:47', NULL, '2026-07-13 14:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` int(11) NOT NULL,
  `provider` varchar(50) NOT NULL DEFAULT 'AndroidSMSGateway',
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `sender_id` varchar(50) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `webhook_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `daily_limit` int(11) NOT NULL DEFAULT 1000,
  `messages_sent_today` int(11) NOT NULL DEFAULT 0,
  `last_reset_date` date NOT NULL DEFAULT curdate(),
  `retry_attempts` int(11) NOT NULL DEFAULT 3,
  `retry_delay_minutes` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `provider`, `username`, `password`, `sender_id`, `api_key`, `webhook_url`, `is_active`, `daily_limit`, `messages_sent_today`, `last_reset_date`, `retry_attempts`, `retry_delay_minutes`, `created_at`, `updated_at`) VALUES
(1, 'AndroidSMSGateway', 'your_username', 'your_password', NULL, NULL, NULL, 1, 1000, 0, '2026-05-22', 3, 5, '2026-05-22 04:38:53', '2026-05-22 04:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id_number` varchar(50) NOT NULL,
  `lrn` varchar(12) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `grade_level` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `track` varchar(50) DEFAULT NULL,
  `strand` varchar(80) DEFAULT NULL,
  `adviser_id` int(11) DEFAULT NULL,
  `parent_name` varchar(200) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `parent_email` varchar(200) DEFAULT NULL,
  `parent_pin` varchar(6) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `extension_name` varchar(10) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `status` enum('Active','Inactive','Graduated','Transferred') NOT NULL DEFAULT 'Active',
  `qr_code_path` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id_number`, `lrn`, `first_name`, `last_name`, `grade_level`, `section`, `track`, `strand`, `adviser_id`, `parent_name`, `parent_phone`, `parent_email`, `parent_pin`, `address`, `date_of_birth`, `gender`, `extension_name`, `enrollment_date`, `status`, `qr_code_path`, `photo`, `created_at`, `updated_at`) VALUES
(2, 'STU20264658', '184374403537', 'Guian', 'Agarrado', 'Grade 11', 'b', 'TVL', 'ICT (Information &amp; Communications Technology)', NULL, 'Ralph', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2018-03-12', 'Male', '', '2026-05-22', 'Active', 'qrcodes/STU20264658.svg', 'student_photos/STU20264658.jpg', '2026-05-22 08:32:17', '2026-06-02 15:19:26'),
(3, 'STU20265478', NULL, 'test', 'ting', 'Grade 10', 'A', NULL, NULL, NULL, 'admin', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2026-05-20', 'Female', NULL, '2026-05-22', 'Active', 'qrcodes/STU20265478.svg', NULL, '2026-05-22 08:57:22', '2026-05-22 08:57:22'),
(8, 'STU20265394', NULL, 'Ralph Laurence', 'Garlejo', 'Grade 10', 'A', NULL, NULL, NULL, 'Lorena Garlejo', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2006-04-03', 'Male', NULL, '2026-05-22', 'Active', 'qrcodes/STU20265394.svg', 'student_photos/STU20265394.jpg', '2026-05-22 13:13:59', '2026-05-22 13:13:59'),
(9, 'STU20267916', NULL, 'erich', 'arriola', 'Grade 10', 'C', NULL, NULL, NULL, 'Ralph', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2005-07-21', 'Female', NULL, '2026-05-22', 'Active', 'qrcodes/STU20267916.svg', 'student_photos/STU20267916.jpg', '2026-05-22 14:11:51', '2026-05-22 14:11:51'),
(10, 'STU20264343', NULL, 'erich', 'arriola', 'Grade 10', 'C', NULL, NULL, NULL, 'Ralph', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2005-07-21', 'Female', NULL, '2026-05-22', 'Active', 'qrcodes/STU20264343.svg', 'student_photos/STU20264343.jpg', '2026-05-23 04:09:17', '2026-05-23 04:09:17'),
(11, 'STU20260656', NULL, 'erich', 'arriola', 'Grade 10', 'C', NULL, NULL, NULL, 'Ralph', '+639066341073', 'ralphgarlejo@gmail.com', NULL, 'N/A', '2005-07-21', 'Female', NULL, '2026-05-22', 'Active', 'qrcodes/STU20260656.svg', 'student_photos/STU20260656.jpg', '2026-05-23 07:38:16', '2026-05-23 07:38:16');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `employee_id` varchar(50) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(100) NOT NULL,
  `assigned_classes` text DEFAULT NULL,
  `adviser_grade` varchar(20) DEFAULT NULL,
  `adviser_section` varchar(20) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  `teacher_type` enum('Adviser','Subject','Both') DEFAULT 'Subject',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Teacher','Staff') NOT NULL DEFAULT 'Teacher',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `first_name`, `last_name`, `email`, `phone`, `employee_id`, `department`, `position`, `assigned_classes`, `adviser_grade`, `adviser_section`, `subject_name`, `teacher_type`, `username`, `password`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'System', 'Administrator', 'admin@school.edu', NULL, 'ADMIN001', NULL, 'System Administrator', NULL, NULL, NULL, NULL, 'Subject', 'admin', '$2y$10$3sZn7s0b/dD6q/wzK.QQoumMTf20JeD2rk5yPux7HqGthRD7gxZKO', 'Admin', 'Active', '2026-07-13 16:35:04', '2026-05-22 04:38:53', '2026-07-13 16:35:04'),
(4, 'test', 'Teacher', 'garlejoralph0@gmail.com', '09066341073', '', 'English', 'Adviser', '[\"Grade 10 - A\",\"Grade 10 - C\",\"Grade 8 - b\"]', NULL, NULL, NULL, 'Subject', 'teacher', '$2y$10$uZ36lHpum.x61NCgsHR76uMexNsy0F0/ZXqx4G4vOjtSBxOOxuxZ2', 'Teacher', 'Active', '2026-06-04 18:25:28', '2026-05-23 12:42:22', '2026-06-04 18:25:28'),
(9, 'ako', 'ikw', 'ako@gmail.com', '090676753451', 'EMP202643247', 'English', 'Adviser', '[]', 'Grade 11', 'b', '', 'Adviser', 'ako', '$2y$10$V5EGF6KtCyjW8.fW89sZxuDPJrdyQc1nuGgwutGMjhZ.DjixTw8ji', 'Teacher', 'Active', '2026-07-13 16:31:35', '2026-06-02 15:51:21', '2026-07-13 16:31:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grading_system_id` (`grading_system_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_action` (`action`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_event_date` (`event_date`),
  ADD KEY `idx_event_type` (`event_type`),
  ADD KEY `idx_target_audience` (`target_audience`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_date` (`student_id`,`date`),
  ADD KEY `idx_date_status` (`date`,`status`),
  ADD KEY `idx_student_date` (`student_id`,`date`);

--
-- Indexes for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grading_system`
--
ALTER TABLE `grading_system`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_teacher_class_quarter` (`teacher_id`,`grade_level`,`section`,`subject_name`,`quarter`),
  ADD UNIQUE KEY `unique_class` (`teacher_id`,`grade_level`,`section`,`quarter`);

--
-- Indexes for table `parent_accounts`
--
ALTER TABLE `parent_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_student_id` (`student_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `parent_preferences`
--
ALTER TABLE `parent_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_student_phone` (`student_id`,`parent_phone`),
  ADD KEY `idx_student_id` (`student_id`);

--
-- Indexes for table `report_visibility`
--
ALTER TABLE `report_visibility`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_report` (`student_id`,`report_type`,`quarter`,`school_year`),
  ADD KEY `submitted_by` (`submitted_by`),
  ADD KEY `idx_student_report` (`student_id`,`report_type`),
  ADD KEY `idx_quarter` (`quarter`),
  ADD KEY `idx_school_year` (`school_year`);

--
-- Indexes for table `school_settings`
--
ALTER TABLE `school_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_student_id` (`student_id`),
  ADD KEY `idx_attendance_id` (`attendance_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id_number` (`student_id_number`),
  ADD KEY `idx_grade_section` (`grade_level`,`section`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_adviser` (`adviser_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grading_system`
--
ALTER TABLE `grading_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parent_accounts`
--
ALTER TABLE `parent_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parent_preferences`
--
ALTER TABLE `parent_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `report_visibility`
--
ALTER TABLE `report_visibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_settings`
--
ALTER TABLE `school_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_logs`
--
ALTER TABLE `sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`grading_system_id`) REFERENCES `grading_system` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_log_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_log_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grading_system`
--
ALTER TABLE `grading_system`
  ADD CONSTRAINT `grading_system_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parent_accounts`
--
ALTER TABLE `parent_accounts`
  ADD CONSTRAINT `parent_accounts_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parent_preferences`
--
ALTER TABLE `parent_preferences`
  ADD CONSTRAINT `parent_preferences_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `report_visibility`
--
ALTER TABLE `report_visibility`
  ADD CONSTRAINT `report_visibility_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `report_visibility_ibfk_2` FOREIGN KEY (`submitted_by`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sms_logs`
--
ALTER TABLE `sms_logs`
  ADD CONSTRAINT `sms_logs_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sms_logs_ibfk_2` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_adviser` FOREIGN KEY (`adviser_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

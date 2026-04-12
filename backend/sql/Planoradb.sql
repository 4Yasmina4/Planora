-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 12, 2026 at 03:35 PM
-- Server version: 12.0.2-MariaDB-ubu2404
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Planoradb`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_description` text NOT NULL,
  `ects` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `study_material` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `user_id`, `course_name`, `course_description`, `ects`, `exam_date`, `study_material`, `created_at`, `updated_at`) VALUES
(1, 11, 'Programmeren 1', 'Beschrijving van het vak', 6, '2026-04-03', 'Online studiemateriaal', '2026-03-15 04:44:05', '2026-03-15 04:44:05'),
(6, 11, 'Programmeren 2', 'Verdieping op de lesstof van het vak Programmeren 1', 4, '2026-05-04', 'Wekelijkse programmeer opdrachten ', '2026-03-22 23:22:45', '2026-03-22 23:22:45'),
(8, 20, 'Interaction Design', 'Website pagina ontwerpen voor een schoolopdracht voor een hobby.', 3, '2026-05-30', 'Figma zie Moodle.', '2026-04-12 15:03:06', '2026-04-12 15:03:06'),
(10, 23, 'Web Design', 'Leert hoe je een gebruiksvriendelijke website ontwerpt.', 4, '2026-05-20', 'Weekelijkse Powerpoint slides op Moodle.', '2026-04-12 15:26:36', '2026-04-12 15:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_description` text NOT NULL,
  `date` date NOT NULL,
  `task_duration` int(11) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `user_id`, `course_id`, `task_name`, `task_description`, `date`, `task_duration`, `is_completed`, `created_at`, `updated_at`) VALUES
(4, 11, 1, 'Flashcards maken ', 'Flashcards maken voor hoofdstuk 1 via Quizlet', '2026-03-31', 90, 0, '2026-03-29 09:56:03', '2026-03-29 09:56:03'),
(7, 11, 1, 'Flashcards maken', 'Flashcards maken voor hoofdstuk 1 en 2', '2026-03-30', 120, 1, '2026-03-29 10:52:03', '2026-03-29 10:52:03'),
(8, 11, 1, 'Flashcards maken', 'Flashcards maken voor hoofdstuk 1 en 2', '2026-03-30', 120, 0, '2026-03-29 10:52:05', '2026-03-29 10:52:05'),
(18, 20, 8, 'Kleurenpalette uitzoeken', 'Kleurenpalette zoeken op internet voor de website ontwerp.', '2026-04-18', 90, 0, '2026-04-12 15:05:18', '2026-04-12 15:05:18'),
(19, 23, 10, 'Hoofdstuk 1 en 2 doornemen', 'Hoofdstuk 1 en 2 van het theorieboek lezen.', '2026-04-18', 120, 0, '2026-04-12 15:29:52', '2026-04-12 15:29:52');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `surname_prefix` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrator','student') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `surname_prefix`, `last_name`, `email`, `password`, `role`) VALUES
(1, 'Amy', '', 'Rose', 'Amy5Rose@outlook.com', '$2y$12$t0WthWzMrFTG1kRvcmCJFujESbVMFXpPR8iLJo.xqiHQdQ1BPYcMK', 'administrator'),
(2, 'Shadow', 'the', 'Hedgehog', 'Shadow7Hedgehog@gmail.com', '$2y$12$qrj0R09IpSZyZeJlW80yiO0mynXG22/1pZ5txiFVkKWVW3ApWLNc6', 'student'),
(3, 'Roland', '', 'Crane', 'Roland7Crane@outlook.com', '$2y$12$BpxiyQWPEdKv3UgqLN8JheTcWi.WOFx12A.SqUAWMC9iLWGmnoA6u', 'student'),
(6, 'Alice', '', 'Smith', 'Alice39Smith@outlook.com', '$2y$12$WYiIKILjesmz77cY408uHeXzM1KlDPTAOtnSgHjdmZFDsAMPdWK2u', 'student'),
(7, 'Emily', NULL, 'Woods', 'Emily4Woods@outlook.com', '$2y$12$pqml7w25oRihi5WTSWDbbupuxGCuFMzfX2ltO/x8RcfWiM9Mu9inq', 'student'),
(8, 'Lloyd', '', 'Greenwall', 'Lloyd9green@outlook.com', '$2y$12$bWy9rbqWprhJPm5k30XpuOXqQgmxbYlxsrzFTwiM.n3ai.ltNyMBi', 'student'),
(9, 'Jan', 'de', 'Vries', 'jan@example.com', '$2y$12$PvFfsTSdAEToQmc45sSguungMOLfoDC.qR2LDI/8hvZEjI0nWfXOm', 'student'),
(11, 'Roxanna', '', 'Ludenburg', 'Roxy4@outlook.com', '$2y$12$/7E4j1ciHkUuxDohgAKPj.tbWlads2TsW9wXkFoNEGmOmqoXfJ7Be', 'student'),
(13, 'Daisy', NULL, 'Flower4', 'Daisy4Flower@gmail.com', '$2y$12$kEnjvtSeK3nPqkB4mOj5qetJQZ3nIZPTu/PrUCNGDwCFL9lsoG..a', 'student'),
(15, 'Adminproberente', NULL, 'verwijderen', 'eigenadminverwijder@gmail.com', '$2y$12$FM5XKH/6JNE7pqKy7ajkCuxXebK7NzCeh5yHZehSl52JWNcavoXRq', 'administrator'),
(20, 'Alice', '', 'Greenwood', 'AliceGreenwood@outlook.com', '$2y$12$UogwHw7d5Zu8nwLPG9zS8.1BQ7QvxVoTK7/g2kO7SdCqBDJU.UPDe', 'student'),
(22, 'Test', NULL, 'Administrator', 'TestAdministrator@outlook.com', '$2y$12$PyD11wyTzNaQpU/wIt0/1.z0BViYAuayLRvk9t8XHdZ.iV/rBTt3O', 'administrator'),
(23, 'Test', NULL, 'Student', 'TestStudent@outlook.com', '$2y$12$/BneVVHEEHgnkPQei0gWe.Ldv5dtKSMxJrYIgNvg/b.gtomoy3jSu', 'student'),
(25, 'Test', '', 'Student2', 'TestStudent2@outlook.com', '$2y$12$12F/lgblqgE2OhTA2MiU0uZcEjI8c6AIJSjXTMk/RiP4p73XsOJly', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

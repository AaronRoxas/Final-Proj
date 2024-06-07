-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 09:07 AM
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
-- Database: `user_record`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(255) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `teacher_id`) VALUES
('CSEL', 'CS Elective', 9684),
('INFOMAN', 'Information Management', 9684),
('RPH', 'PH History', 9684),
('WH', 'World History', 9684);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `course_id` varchar(255) DEFAULT NULL,
  `prelim_grade` decimal(5,2) DEFAULT NULL,
  `midterm_grade` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `overall_grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_fName` varchar(100) NOT NULL,
  `user_lName` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_fName`, `user_lName`, `user_name`, `email`, `user_password`, `user_role`) VALUES
(2001, 'John', 'Doe', 'John Doe', 'john.doe@example.com', 'password123', 's'),
(2002, 'Jane', 'Smith', 'Jane Smith', 'jane.smith@example.com', 'password123', 's'),
(2003, 'Emily', 'Johnson', 'Emily Johnson', 'emily.johnson@example.com', 'password123', 's'),
(2004, 'Michael', 'Brown', 'Michael Brown', 'michael.brown@example.com', 'password123', 's'),
(2005, 'Sarah', 'Davis', 'Sarah Davis', 'sarah.davis@example.com', 'password123', 's'),
(2006, 'James', 'Wilson', 'James Wilson', 'james.wilson@example.com', 'password123', 's'),
(2007, 'Linda', 'Martinez', 'Linda Martinez', 'linda.martinez@example.com', 'password123', 's'),
(2008, 'Robert', 'Anderson', 'Robert Anderson', 'robert.anderson@example.com', 'password123', 's'),
(2009, 'Mary', 'Thomas', 'Mary Thomas', 'mary.thomas@example.com', 'password123', 's'),
(2010, 'William', 'Jackson', 'William Jackson', 'william.jackson@example.com', 'password123', 's'),
(2011, 'Elizabeth', 'White', 'Elizabeth White', 'elizabeth.white@example.com', 'password123', 's'),
(2012, 'David', 'Harris', 'David Harris', 'david.harris@example.com', 'password123', 's'),
(2013, 'Barbara', 'Clark', 'Barbara Clark', 'barbara.clark@example.com', 'password123', 's'),
(2014, 'Richard', 'Lewis', 'Richard Lewis', 'richard.lewis@example.com', 'password123', 's'),
(2015, 'Susan', 'Lee', 'Susan Lee', 'susan.lee@example.com', 'password123', 's'),
(2016, 'Joseph', 'Walker', 'Joseph Walker', 'joseph.walker@example.com', 'password123', 's'),
(2017, 'Patricia', 'Hall', 'Patricia Hall', 'patricia.hall@example.com', 'password123', 's'),
(2018, 'Charles', 'Young', 'Charles Young', 'charles.young@example.com', 'password123', 's'),
(2019, 'Jennifer', 'King', 'Jennifer King', 'jennifer.king@example.com', 'password123', 's'),
(2020, 'Thomas', 'Wright', 'Thomas Wright', 'thomas.wright@example.com', 'password123', 's'),
(2922, 'Student', 'A', 'Student A', 'stud@email.com', 's', 's'),
(4106, 'Sotto', 'Kai', 'Kai Sotto', 'kaisotto@email.com', 's', 's');

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `student_id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`student_id`, `course_id`) VALUES
(2922, 'INFOMAN'),
(2922, 'RPH');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_fName` varchar(100) NOT NULL,
  `user_lName` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_fName`, `user_lName`, `user_name`, `email`, `user_password`, `user_role`) VALUES
(9684, 'Admin', '123', 'Admin 123', 'admin@admin.com', 'a', 't'),
(9998, 'Ray', 'Ray', 'Ray Ray', 'ray@email.com', 'a', 't');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

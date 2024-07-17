-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 09:43 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faculty_evaluation`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `acad_Id` int(11) NOT NULL,
  `year` varchar(100) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Off, 1=On-going',
  `date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`acad_Id`, `year`, `semester`, `status`, `date_created`) VALUES
(15, '2023-2024', '1st Semester', 1, '2024-04-24');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Id` int(11) NOT NULL,
  `evaluated_by` int(11) NOT NULL COMMENT 'students',
  `acad_Id` int(11) NOT NULL COMMENT 'academic year',
  `user_Id` int(11) NOT NULL COMMENT 'faculty',
  `section_Id` int(11) NOT NULL COMMENT 'section ',
  `subject_Id` int(11) NOT NULL,
  `com` varchar(500) NOT NULL,
  `evaluation_status` int(11) NOT NULL COMMENT '0=Verified, 1=Verified',
  `date_evaluated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Id`, `evaluated_by`, `acad_Id`, `user_Id`, `section_Id`, `subject_Id`, `com`, `evaluation_status`, `date_evaluated`) VALUES
(29, 471, 15, 454, 40, 127, 'mabait', 0, ''),
(30, 475, 15, 451, 41, 128, 'mabait', 0, ''),
(31, 476, 15, 454, 40, 127, 'mabait', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `Id` int(11) NOT NULL,
  `evaluated_by` int(11) NOT NULL COMMENT 'students',
  `acad_Id` int(11) NOT NULL COMMENT 'academic year',
  `user_Id` int(11) NOT NULL COMMENT 'faculty',
  `section_Id` int(11) NOT NULL,
  `subject_Id` int(11) NOT NULL,
  `A1` int(11) NOT NULL,
  `A2` int(11) NOT NULL,
  `A3` int(11) NOT NULL,
  `A4` int(11) NOT NULL,
  `A5` int(11) NOT NULL,
  `A_Total` int(11) NOT NULL,
  `B1` int(11) NOT NULL,
  `B2` int(11) NOT NULL,
  `B3` int(11) NOT NULL,
  `B4` int(11) NOT NULL,
  `B5` int(11) NOT NULL,
  `B_Total` int(11) NOT NULL,
  `C1` int(11) NOT NULL,
  `C2` int(11) NOT NULL,
  `C3` int(11) NOT NULL,
  `C4` int(11) NOT NULL,
  `C5` int(11) NOT NULL,
  `C_Total` int(11) NOT NULL,
  `D1` int(11) NOT NULL,
  `D2` int(11) NOT NULL,
  `D3` int(11) NOT NULL,
  `D4` int(11) NOT NULL,
  `D5` int(11) NOT NULL,
  `D_Total` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `com` varchar(500) NOT NULL,
  `evaluation_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Unverified, 1=Verified',
  `date_evaluated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`Id`, `evaluated_by`, `acad_Id`, `user_Id`, `section_Id`, `subject_Id`, `A1`, `A2`, `A3`, `A4`, `A5`, `A_Total`, `B1`, `B2`, `B3`, `B4`, `B5`, `B_Total`, `C1`, `C2`, `C3`, `C4`, `C5`, `C_Total`, `D1`, `D2`, `D3`, `D4`, `D5`, `D_Total`, `grand_total`, `com`, `evaluation_status`, `date_evaluated`) VALUES
(311, 471, 15, 454, 40, 127, 5, 5, 5, 4, 0, 19, 5, 5, 5, 5, 5, 25, 5, 5, 5, 0, 0, 15, 5, 5, 5, 5, 0, 20, 79, '', 1, '2024-04-25 18:35:27'),
(312, 475, 15, 451, 41, 128, 5, 5, 5, 5, 0, 20, 5, 5, 5, 5, 5, 25, 5, 5, 5, 0, 0, 15, 5, 5, 5, 5, 0, 20, 80, '', 1, '2024-04-25 18:37:14'),
(313, 476, 15, 454, 40, 127, 5, 5, 3, 3, 0, 16, 2, 2, 3, 3, 3, 13, 3, 2, 4, 0, 0, 9, 4, 4, 3, 3, 0, 14, 52, '', 1, '2024-04-25 18:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_superior`
--

CREATE TABLE `evaluation_superior` (
  `Id` int(11) NOT NULL,
  `evaluated_by` int(11) NOT NULL,
  `acad_Id` int(11) NOT NULL,
  `user_Id` int(11) NOT NULL,
  `section_Id` int(11) NOT NULL,
  `subject_Id` int(11) NOT NULL,
  `A1` int(11) NOT NULL,
  `A2` int(11) NOT NULL,
  `A3` int(11) NOT NULL,
  `A4` int(11) NOT NULL,
  `A5` int(11) NOT NULL,
  `A6` int(11) NOT NULL,
  `A7` int(11) NOT NULL,
  `A8` int(11) NOT NULL,
  `A9` int(11) NOT NULL,
  `A_Total` int(11) NOT NULL,
  `B10` int(11) NOT NULL,
  `B11` int(11) NOT NULL,
  `B12` int(11) NOT NULL,
  `B13` int(11) NOT NULL,
  `B14` int(11) NOT NULL,
  `B15` int(11) NOT NULL,
  `B16` int(11) NOT NULL,
  `B17` int(11) NOT NULL,
  `B_Total` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL,
  `evaluation_status` int(11) NOT NULL,
  `date_evaluated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation_superior`
--

INSERT INTO `evaluation_superior` (`Id`, `evaluated_by`, `acad_Id`, `user_Id`, `section_Id`, `subject_Id`, `A1`, `A2`, `A3`, `A4`, `A5`, `A6`, `A7`, `A8`, `A9`, `A_Total`, `B10`, `B11`, `B12`, `B13`, `B14`, `B15`, `B16`, `B17`, `B_Total`, `grand_total`, `evaluation_status`, `date_evaluated`) VALUES
(9, 474, 15, 451, 0, 0, 5, 5, 5, 5, 5, 5, 5, 5, 5, 45, 5, 5, 5, 5, 5, 5, 5, 5, 40, 85, 0, '2024-04-25 14:02:51'),
(10, 482, 15, 451, 0, 0, 4, 4, 4, 4, 4, 4, 4, 4, 4, 36, 4, 4, 4, 4, 4, 4, 4, 4, 32, 68, 0, '2024-04-25 18:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_Id` int(11) NOT NULL,
  `yr_level` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `department` varchar(255) NOT NULL,
  `date_created` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_Id`, `yr_level`, `section`, `department`, `date_created`) VALUES
(40, '4', 'A', 'BSIS', '2023-10-22'),
(41, '4', 'B', 'BSIS', '2023-10-22'),
(42, '4', 'A', 'BSAIS', '2023-10-22'),
(43, '4', 'B', 'BSAIS', '2023-10-22'),
(44, '4', 'A', 'BSOM', '2023-10-22'),
(45, '4', 'B', 'BSOM', '2023-11-29'),
(47, '4', 'A', 'BTVTED', '2024-04-11'),
(50, '4', 'B', 'BTVTED', '2024-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `sub_Id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `units` varchar(30) NOT NULL,
  `instructor_Id` varchar(255) NOT NULL,
  `section_Id` varchar(255) NOT NULL,
  `acad_Id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `date_created` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`sub_Id`, `name`, `code`, `units`, `instructor_Id`, `section_Id`, `acad_Id`, `department`, `date_created`) VALUES
(111, 'Capstone Project 2', 'ISCAP2423', '3', '454', '40', 12, '', '2024-04-17'),
(112, 'Call Center', 'ISCC423', '3', '454', '40', 12, '', '2024-04-17'),
(113, 'Principles of Teaching', 'ISPT423', '3', '453', '40', 12, '', '2024-04-17'),
(116, 'Capstone Project 2', 'ISCAP2423', '3', '454', '41', 12, '', '2024-04-18'),
(126, 'Capstone Project 2', 'ISCAP2423', '3', '454', '40', 13, '', '2024-04-24'),
(127, 'Capstone Project 2', 'ISCAP2423', '3', '454', '40', 15, '', '2024-04-24'),
(128, 'Capstone Project 2', 'ISCAP2423', '3', '451', '41', 15, '', '2024-04-25'),
(138, 'Call Center', 'ISCC423', '3', 'Rommel Ocampo', 'BSIS : 4 - A', 15, 'May 09, 2024', '2024-05-09 11:14:39');

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE `subject_list` (
  `Id` int(11) NOT NULL,
  `department` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(50) NOT NULL,
  `units` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject_list`
--

INSERT INTO `subject_list` (`Id`, `department`, `name`, `code`, `units`) VALUES
(1, 'BSIS', 'Capstone Project 2', 'IS-CAP2423', 3),
(2, 'BSIS', 'Call Center', 'IS-CC423', 3),
(3, 'BSIS', 'Principles of Teaching', 'IS-PT423', 3),
(4, 'BSAIS', 'Accounting Information System Internship', 'AIS-AISI423', 3),
(5, 'BSAIS 	', 'Accounting Information System Research', 'AIS-AISR423', 3),
(6, 'BSOM', 'Project Management', 'OM-PM423', 3),
(7, 'BSOM', 'Financial Management', 'OM-FM423', 3),
(8, 'BTVTED', 'Enhancement 1', 'TED-E423', 3),
(9, 'BTVTED', 'Teaching Internship', 'TED-TI423', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_Id` int(11) NOT NULL,
  `stud_type` varchar(20) NOT NULL,
  `student_ID` varchar(100) NOT NULL,
  `year_section` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `acad_rank` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `age` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'profile.png',
  `ID_verification` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'Student',
  `student_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Pending Account, 1=Verified Account, 2=Denied/Deleted',
  `faculty_status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Inactive',
  `superior_status` int(11) NOT NULL COMMENT '0=Active, 1=Inactive',
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0=Not Deleted, 1=Deleted',
  `verification_code` int(11) NOT NULL,
  `date_registered` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_Id`, `stud_type`, `student_ID`, `year_section`, `department`, `acad_rank`, `firstname`, `middlename`, `lastname`, `suffix`, `dob`, `age`, `email`, `gender`, `image`, `ID_verification`, `password`, `user_type`, `student_status`, `faculty_status`, `superior_status`, `is_deleted`, `verification_code`, `date_registered`) VALUES
(66, '', '', 3, '', '', 'BPC', '', 'Admin', '', '2002-08-27', '21 years old', 'admin@gmail.com', 'Male', 'profile.png', '', '0192023a7bbd73250516f069df18b500', 'Admin', 0, 1, 0, 0, 961549, '2022-11-25'),
(451, '', '', 0, '', '', 'Paulo', 'A', 'Victoria', '', '1980-04-02', '', 'pvictoria@gmail.com', 'Male', 'paulo.jpg', '', '85b954cf9565b9c54add85f09281a50b', 'Faculty', 1, 0, 0, 0, 0, '2024-04-04'),
(453, '', '', 0, '', '', 'Lynzel', 'N', 'Valenzuela', '', '1998-08-01', '', 'lvalenzuela@gmail.com', 'Female', 'lynzel.jpg', '', 'a240b2fa7d0c7b5043aca344d3b6cc60', 'Faculty', 1, 0, 0, 0, 0, '2024-04-05'),
(454, '', '', 0, '', '', 'Abel', 'A', 'Palero', '', '1990-11-22', '', 'apalero@gmail.com', 'Male', 'abel.jpg', '', 'a240b2fa7d0c7b5043aca344d3b6cc60', 'Faculty', 1, 0, 0, 0, 0, '2024-04-05'),
(462, 'Regular', 'MA-20011121', 40, 'BSIS', '', 'Hedrian', 'Alagos', 'Cruz', '', '2012-06-12', '', 'hcruz@gmail.com', 'Male', 'profile.png', 'heds.jpg', 'd18cb36236730447bea90aae8e052049', 'Student', 1, 1, 0, 0, 0, '2024-04-12'),
(471, 'Regular', 'MA-20011120', 40, 'BSIS', '', 'Jericho ', 'Sison', 'Padua', '', '2007-05-17', '', 'jerichopadua09@gmail.com', 'Male', 'profile.png', 'jek.jpg', 'd18cb36236730447bea90aae8e052049', 'Student', 1, 1, 0, 0, 0, '2024-04-17'),
(474, '', '', 0, '', '', 'Victoria', 'Martinez', 'Sison', '', '2008-06-18', '', 'vsison@gmail.com', 'Female', 'profiles.png', '', 'd18cb36236730447bea90aae8e052049', 'Superior', 1, 1, 0, 0, 0, '2024-04-18'),
(475, 'Regular', 'MA-20011130', 41, 'BSIS', '', 'Arrian', 'Martinez', 'Tolentino', '', '2012-07-19', '', 'atolentino@gmail.com', 'Male', 'profile.png', 'arrian.jpg', 'd18cb36236730447bea90aae8e052049', 'Student', 1, 1, 0, 0, 0, '2024-04-18'),
(476, 'Regular', 'MA-20011201', 40, 'BSIS', '', 'Janssen', 'Martinez', 'Eulin', '', '2006-10-17', '', 'jeulin@gmail.com', 'Male', 'profile.png', 'sen.jpg', 'd18cb36236730447bea90aae8e052049', 'Student', 1, 1, 0, 0, 0, '2024-04-22'),
(482, '', '', 0, '', '', 'Ericka', '', 'Dumlao', '', '2005-02-24', '', 'edumlao@gmail.com', 'Female', 'profiles.png', '', 'd18cb36236730447bea90aae8e052049', 'Superior', 1, 1, 0, 0, 0, '2024-04-24'),
(483, '', '', 0, '', '', 'Jessica', '', 'Quiambao', '', '1992-06-17', '', 'jquiambao@gmail.com', 'Female', 'profiles.png', '', 'd18cb36236730447bea90aae8e052049', 'Superior', 1, 1, 0, 0, 0, '2024-04-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`acad_Id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `evaluation_superior`
--
ALTER TABLE `evaluation_superior`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_Id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`sub_Id`);

--
-- Indexes for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `acad_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `evaluation_superior`
--
ALTER TABLE `evaluation_superior`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `sub_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `subject_list`
--
ALTER TABLE `subject_list`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

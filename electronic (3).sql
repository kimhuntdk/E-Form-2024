-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2018 at 01:43 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electronic`
--

-- --------------------------------------------------------

--
-- Table structure for table `request_doc`
--

CREATE TABLE `request_doc` (
  `doc_id` int(7) NOT NULL COMMENT 'รหัสหลักเอกสาร',
  `doc_type` int(2) NOT NULL COMMENT 'ประเภทเอกสาร',
  `doc_std_id` varchar(12) NOT NULL COMMENT 'รหัสประจำตัวนิสิต',
  `doc_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_doc_type`
--

CREATE TABLE `request_doc_type` (
  `doc_type_id` int(3) NOT NULL COMMENT 'ประเภทเอกสาร',
  `doc_type_name` varchar(254) NOT NULL COMMENT 'ชื่อประเภทเอกสาร'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_registration_thesis_is`
--

CREATE TABLE `request_registration_thesis_is` (
  `registration_thesis_is_id` int(7) NOT NULL COMMENT 'รหัสลงทะเบียน Thesis is เพิ่ม',
  `std_id` varchar(12) NOT NULL COMMENT 'รหัสนักศึกษา',
  `status_thesis_is` int(1) NOT NULL COMMENT 'thesis หรือ is',
  `subject_code` varchar(8) NOT NULL COMMENT 'รหัสวิชา',
  `credits` int(2) NOT NULL COMMENT 'จำนวนหน่วยกิตที่ลงเพิ่ม',
  `semester` varchar(6) NOT NULL COMMENT 'เทอมที่ผู้ลงทะเบียน Thesis is เพิ่ม',
  `because` varchar(254) NOT NULL COMMENT 'เนื่องจาก',
  `std_signature` varchar(50) NOT NULL COMMENT 'ลายเซ็นดิจิตผู้ลงทะเบียน Thesis is เพิ่ม',
  `std_date_signature` varchar(50) NOT NULL COMMENT 'วันที่เซ็น นิสิต',
  `advisor_chairman` int(5) NOT NULL COMMENT 'รหัสอาจารย์ที่จะให้อนุมัติผู้ลงทะเบียน Thesis is เพิ่ม',
  `advisor_chairman_signature` varchar(50) NOT NULL COMMENT 'ข้อความจากอาจารย์ที่ปรึกษา',
  `advisor_chairman_date` datetime NOT NULL COMMENT 'วันที่อาจารย์ที่ปรึกษาอนุมัติ',
  `staff_grad_node` varchar(254) NOT NULL COMMENT 'ข้อความจากเจ้าหน้าที่บัณฑิตวิทยาล้ัย',
  `staff_grad_approve_disapprove` int(1) NOT NULL COMMENT 'เรื่องทำมาถูกต้องหรือไม่',
  `dean_admin` int(2) NOT NULL COMMENT 'เลือกคนที่จะพิจารณาเรื่อง คณบดี หรือ รอง',
  `dean_admin_approve_disapprove` int(1) NOT NULL COMMENT 'สถานะการอนุมัติ ของคณบดี หรือ รอง',
  `dean_admin_node` varchar(100) NOT NULL COMMENT 'ข้อความจากคณบดีหรือรอง',
  `dean_admin_date` datetime NOT NULL COMMENT 'วันที่พิจารณจากคณบดีหรือรอง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_student`
--

CREATE TABLE `request_student` (
  `std_id` int(7) NOT NULL COMMENT 'รหัสนิสิต atu ตามการใช้งาน',
  `std_id_std` varchar(11) NOT NULL COMMENT 'รหัสประจำตัวนิสิต',
  `std_id_crad` varchar(13) NOT NULL COMMENT 'รหัสบัตรประจำตัวประชาชน',
  `std_fname_th` varchar(40) NOT NULL COMMENT 'ชื่อไทย',
  `std_lname_th` varchar(40) NOT NULL COMMENT 'นามสกุลไทย',
  `std_fname_en` varchar(40) NOT NULL COMMENT 'ชื่ออังกฤษ',
  `std_lname_en` varchar(40) NOT NULL COMMENT 'นามสกุลอังกฤษ',
  `std_province_th` varchar(30) NOT NULL COMMENT 'จังหวัดไทย',
  `std_degree_th` varchar(20) NOT NULL COMMENT 'ระดับไทย',
  `std_faculty_th` varchar(40) NOT NULL COMMENT 'คณะไทย',
  `std_major_th` varchar(40) NOT NULL COMMENT 'สาขาไทย',
  `std_province_en` varchar(40) NOT NULL COMMENT 'จัวหวัดอังกฤษ',
  `std_degree_en` varchar(40) NOT NULL COMMENT 'ระดับอังกฤษ',
  `std_faculty_en` varchar(40) NOT NULL COMMENT 'คณะอังกฤษ',
  `std_major_en` varchar(40) NOT NULL COMMENT 'สาขาอังกฤษ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `request_taking_leave`
--

CREATE TABLE `request_taking_leave` (
  `taking_leave_id` int(7) NOT NULL COMMENT 'รหัสลาพักการเรียน',
  `std_id` varchar(12) NOT NULL COMMENT 'รหัสนักศึกษา',
  `semester` varchar(6) NOT NULL COMMENT 'เทอมที่ลากพัก',
  `because` varchar(254) NOT NULL COMMENT 'เนื่องจาก',
  `std_signature` varchar(50) NOT NULL COMMENT 'ลายเซ็นดิจิตผู้ลาพัก',
  `std_date_signature` varchar(50) NOT NULL COMMENT 'วันที่เซ็น นิสิต',
  `finished_assigment` varchar(254) NOT NULL COMMENT 'งานที่ทำแล้วเสร็จ',
  `unfinished_assignment` varchar(254) NOT NULL COMMENT 'งานที่กำลังทำ',
  `unstarting_assignment` varchar(254) NOT NULL COMMENT 'งานที่ยังไม่ทำ',
  `advisor_chairman` int(5) NOT NULL COMMENT 'รหัสอาจารย์ที่จะให้อนุมัติลาพักการเรียน',
  `advisor_chairman_signature` varchar(50) NOT NULL COMMENT 'ข้อความจากอาจารย์ที่ปรึกษา',
  `advisor_chairman_date` datetime NOT NULL COMMENT 'วันที่อาจารย์ที่ปรึกษาอนุมัติ',
  `staff_grad_node` varchar(254) NOT NULL COMMENT 'ข้อความจากเจ้าหน้าที่บัณฑิตวิทยาล้ัย',
  `staff_grad_approve_disapprove` int(1) NOT NULL COMMENT 'เรื่องทำมาถูกต้องหรือไม่',
  `dean_admin` int(2) NOT NULL COMMENT 'เลือกคนที่จะพิจารณาเรื่อง คณบดี หรือ รอง',
  `dean_admin_approve_disapprove` int(1) NOT NULL COMMENT 'สถานะการอนุมัติ ของคณบดี หรือ รอง',
  `dean_admin_node` varchar(100) NOT NULL COMMENT 'ข้อความจากคณบดีหรือรอง',
  `dean_admin_date` datetime NOT NULL COMMENT 'วันที่พิจารณจากคณบดีหรือรอง'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE `signature` (
  `Draw_ID` int(11) NOT NULL,
  `Name` varchar(254) NOT NULL,
  `Draw` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signature`
--

INSERT INTO `signature` (`Draw_ID`, `Name`, `Draw`) VALUES
(1, 'dsadsa', '{\"lines\":[[[69,81],[72,85],[78,94],[81,101],[83,105],[85,110],[86,116],[89,121],[91,125],[92,125],[92,126],[99,124],[108,113],[114,95],[117,74],[118,59],[118,52],[118,47],[118,46],[116,46],[111,46],[93,46],[75,51],[58,61],[43,71],[36,78],[31,90],[29,101],[29,112],[31,120],[39,128],[54,133],[71,135],[98,137],[125,133],[144,124],[161,110],[168,102],[170,98],[171,96]],[[167,107],[167,108],[169,109],[183,109],[201,108],[224,101],[245,95],[256,92],[258,92],[259,92],[260,92],[261,100],[261,108],[261,109],[262,109],[264,103],[269,88],[276,75],[279,71],[277,75],[273,85],[272,89],[271,90],[271,89],[271,87],[272,83],[274,76],[274,71]],[[110,200],[110,202]]]}'),
(2, 'fdsfds', '{\"lines\":[[[90,53],[90,54],[92,58],[95,69],[98,82],[101,96],[104,115],[105,121],[105,124],[106,125],[107,125],[113,122],[121,110],[130,98],[139,86],[149,74],[155,67],[156,66],[156,65],[157,65],[157,67],[157,75],[156,84],[156,91],[156,102],[156,105],[156,113],[158,117],[162,121],[168,125],[172,127],[176,128],[180,128],[185,128],[191,127],[194,125],[195,124],[196,122],[196,120]],[[222,61],[223,65],[224,80],[225,94],[225,108],[225,113],[225,117],[226,120]],[[258,58],[264,63],[268,66],[271,68],[273,71],[275,76],[276,79],[278,84],[279,91],[279,95],[279,99],[277,102],[274,106],[273,107],[272,108],[271,108],[273,108],[284,108],[295,107],[304,106],[308,106],[313,106],[317,106],[324,110],[327,111],[328,112],[329,113]]]}'),
(3, 'sdfdsfds', '{\"lines\":[[[50,53],[51,53],[52,53],[54,55],[55,61],[58,71],[62,85],[65,98],[70,112],[71,115],[71,116],[72,116],[73,116],[74,116],[81,116],[90,114],[98,108],[103,104],[105,101],[109,98],[114,96],[116,95],[122,94],[127,94],[130,94],[132,94],[133,94],[134,94],[134,96],[134,99],[134,106],[134,111],[133,115],[131,118],[129,122],[124,125],[121,127],[119,127],[118,128],[117,128],[115,128],[111,122],[111,114],[117,104],[128,92],[143,81],[158,69],[181,57],[195,53],[202,52],[205,52],[209,55],[217,63],[227,69],[237,74],[240,75],[242,76],[243,77],[243,79],[244,84],[244,89],[239,98],[230,107],[224,111],[222,113],[223,112],[229,109],[239,106],[260,101],[281,99],[286,98],[286,99],[286,100],[287,102],[288,104],[289,105],[290,106],[291,106],[333,85],[348,72],[359,64],[365,59],[367,57],[367,56]]]}'),
(4, 'ddd', '{\"lines\":[[[257,61],[258,62],[258,63],[256,63]],[[70,71],[71,71],[77,78],[90,94],[107,113],[124,132],[136,141],[144,146],[148,146],[155,146],[168,134],[176,115],[181,90],[176,65],[158,43],[140,35],[126,34],[113,37],[95,52],[73,73],[60,96],[57,112],[59,120],[62,122],[69,123],[85,123],[137,121],[211,110],[251,104],[262,102],[262,104],[259,106],[254,109],[247,113],[247,114],[248,114],[249,114],[255,114],[265,114],[274,110],[277,108],[277,107]]]}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request_doc`
--
ALTER TABLE `request_doc`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `request_doc_type`
--
ALTER TABLE `request_doc_type`
  ADD PRIMARY KEY (`doc_type_id`);

--
-- Indexes for table `request_student`
--
ALTER TABLE `request_student`
  ADD PRIMARY KEY (`std_id`);

--
-- Indexes for table `request_taking_leave`
--
ALTER TABLE `request_taking_leave`
  ADD PRIMARY KEY (`taking_leave_id`);

--
-- Indexes for table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`Draw_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request_doc`
--
ALTER TABLE `request_doc`
  MODIFY `doc_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหลักเอกสาร';

--
-- AUTO_INCREMENT for table `request_doc_type`
--
ALTER TABLE `request_doc_type`
  MODIFY `doc_type_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ประเภทเอกสาร';

--
-- AUTO_INCREMENT for table `request_student`
--
ALTER TABLE `request_student`
  MODIFY `std_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'รหัสนิสิต atu ตามการใช้งาน';

--
-- AUTO_INCREMENT for table `request_taking_leave`
--
ALTER TABLE `request_taking_leave`
  MODIFY `taking_leave_id` int(7) NOT NULL AUTO_INCREMENT COMMENT 'รหัสลาพักการเรียน';

--
-- AUTO_INCREMENT for table `signature`
--
ALTER TABLE `signature`
  MODIFY `Draw_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

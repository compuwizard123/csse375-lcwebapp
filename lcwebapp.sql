-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 14, 2012 at 11:40 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lcwebapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_timeslots`
--

CREATE TABLE IF NOT EXISTS `booked_timeslots` (
  `bktsid` int(11) NOT NULL AUTO_INCREMENT,
  `TID` varchar(50) NOT NULL,
  `TSID` int(11) NOT NULL,
  `tutee_uname` varchar(8) NOT NULL,
  `booked_day` date NOT NULL,
  PRIMARY KEY (`bktsid`),
  UNIQUE KEY `TID` (`TID`,`TSID`,`booked_day`),
  KEY `TSID` (`TSID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `booked_timeslots`
--

INSERT INTO `booked_timeslots` (`bktsid`, `TID`, `TSID`, `tutee_uname`, `booked_day`) VALUES
(1, 'bamberad', 23, 'agnerrl', '2012-02-15'),
(2, 'bamberad', 24, 'shevicna', '2012-02-15'),
(4, 'cundifij', 4, 'blurgh', '2012-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(50) DEFAULT NULL,
  `course_number` varchar(20) NOT NULL,
  `course_description` varchar(200) NOT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CID`, `department`, `course_number`, `course_description`) VALUES
(1, 'CSSE', 'CSSE371', 'Software Requirements and Specifications'),
(2, 'CSSE', 'CSSE374', 'Software Architecture'),
(3, 'CSSE', 'CSSE332', 'Computer Operating Systems'),
(4, 'ECE', 'ECE130', 'Introduction to Logic Design'),
(5, 'MA', 'MA113', 'Calculus III'),
(7, 'MA', 'MA111', 'Calculus I'),
(8, 'MA', 'MA112', 'Calculus 2');

-- --------------------------------------------------------

--
-- Table structure for table `timeslot`
--

CREATE TABLE IF NOT EXISTS `timeslot` (
  `TSID` int(11) NOT NULL AUTO_INCREMENT,
  `Time` time NOT NULL,
  `Period` varchar(50) NOT NULL,
  PRIMARY KEY (`TSID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `timeslot`
--

INSERT INTO `timeslot` (`TSID`, `Time`, `Period`) VALUES
(1, '08:05:00', '1'),
(2, '08:30:00', '1'),
(3, '09:00:00', '2'),
(4, '09:25:00', '2'),
(5, '09:55:00', '3'),
(6, '10:20:00', '3'),
(7, '10:50:00', '4'),
(8, '11:15:00', '4'),
(9, '11:45:00', '5'),
(10, '12:10:00', '5'),
(11, '12:40:00', '6'),
(12, '01:05:00', '6'),
(13, '01:35:00', '7'),
(14, '02:00:00', '7'),
(15, '02:30:00', '8'),
(16, '02:55:00', '8'),
(17, '03:25:00', '9'),
(18, '03:50:00', '9'),
(19, '04:20:00', '10'),
(20, '04:45:00', '10'),
(21, '07:00:00', 'NIGHT'),
(22, '07:30:00', 'NIGHT'),
(23, '08:00:00', 'NIGHT'),
(24, '08:30:00', 'NIGHT'),
(25, '09:00:00', 'NIGHT'),
(26, '09:30:00', 'NIGHT'),
(27, '10:00:00', 'NIGHT'),
(34, '00:00:00', ''),
(35, '00:00:00', ''),
(38, '00:00:00', ''),
(39, '00:00:00', ''),
(40, '00:00:00', ''),
(41, '00:00:00', ''),
(42, '00:00:00', ''),
(43, '00:00:00', ''),
(44, '00:00:00', ''),
(45, '00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE IF NOT EXISTS `tutor` (
  `name` varchar(50) DEFAULT NULL,
  `year` int(4) DEFAULT NULL,
  `TID` varchar(50) NOT NULL DEFAULT '',
  `major` varchar(50) DEFAULT NULL,
  `Room_Number` varchar(50) DEFAULT NULL,
  `about_tutor` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`name`, `year`, `TID`, `major`, `Room_Number`, `about_tutor`) VALUES
('Kyle Apple', 2013, 'applekw', 'CSSE', 'Home', 'BLARGH'),
('Aaron Bamberger', 2012, 'bamberad', 'CpE-CS', NULL, ''),
('Ian Cundiff', 2013, 'cundifij', 'SE', 'Percopo 104', 'The Declaration of Independence was a statement adopted by the Continental Congress on July 4, 1776, which announced that the thirteen American colonies, then at war with Great Britain, regarded themselves as independent states, and no longer a part of the British Empire. John Adams put forth a resolution earlier in the year which made a formal declaration inevitable. A committee was assembled to draft the formal declaration, to be ready when congress voted on independence. Adams persuaded the c'),
('Adam Jackson', 2012, 'jacksoad', 'CE', NULL, ''),
('Cody Plungis', 2014, 'plungicb', 'CS-SE', NULL, ''),
('asdfasdfasdf', 0, 'test', 'test', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_course`
--

CREATE TABLE IF NOT EXISTS `tutor_course` (
  `TID` varchar(50) NOT NULL,
  `CID` int(11) NOT NULL,
  UNIQUE KEY `TID` (`TID`,`CID`),
  KEY `CID` (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor_course`
--

INSERT INTO `tutor_course` (`TID`, `CID`) VALUES
('bamberad', 1),
('cundifij', 1),
('jacksoad', 1),
('plungicb', 1),
('cundifij', 2),
('plungicb', 2),
('cundifij', 3),
('jacksoad', 3),
('bamberad', 4),
('cundifij', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tutor_images`
--

CREATE TABLE IF NOT EXISTS `tutor_images` (
  `TID` varchar(50) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  UNIQUE KEY `TID` (`TID`,`image_url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor_images`
--

INSERT INTO `tutor_images` (`TID`, `image_url`) VALUES
('applekw', 'http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-1.jpg'),
('bamberad', 'http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-5.jpg'),
('cundifij', 'http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg'),
('jacksoad', 'http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-9.jpg'),
('plungicb', 'http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tutor_timeslot`
--

CREATE TABLE IF NOT EXISTS `tutor_timeslot` (
  `TID` varchar(50) NOT NULL,
  `TSID` int(11) NOT NULL,
  `DAYOFWEEK` varchar(50) NOT NULL,
  KEY `TID` (`TID`),
  KEY `TSID` (`TSID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutor_timeslot`
--

INSERT INTO `tutor_timeslot` (`TID`, `TSID`, `DAYOFWEEK`) VALUES
('bamberad', 10, ''),
('bamberad', 13, ''),
('bamberad', 14, ''),
('bamberad', 17, ''),
('bamberad', 18, ''),
('bamberad', 22, ''),
('bamberad', 23, ''),
('bamberad', 24, ''),
('bamberad', 27, ''),
('applekw', 8, 'MONDAY');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booked_timeslots`
--
ALTER TABLE `booked_timeslots`
  ADD CONSTRAINT `booked_timeslots_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `tutor` (`TID`),
  ADD CONSTRAINT `booked_timeslots_ibfk_3` FOREIGN KEY (`TSID`) REFERENCES `timeslot` (`TSID`);

--
-- Constraints for table `tutor_course`
--
ALTER TABLE `tutor_course`
  ADD CONSTRAINT `tutor_course_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `tutor` (`TID`),
  ADD CONSTRAINT `tutor_course_ibfk_3` FOREIGN KEY (`CID`) REFERENCES `course` (`CID`);

--
-- Constraints for table `tutor_images`
--
ALTER TABLE `tutor_images`
  ADD CONSTRAINT `tutor_images_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `tutor` (`TID`);

--
-- Constraints for table `tutor_timeslot`
--
ALTER TABLE `tutor_timeslot`
  ADD CONSTRAINT `tutor_timeslot_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `tutor` (`TID`),
  ADD CONSTRAINT `tutor_timeslot_ibfk_3` FOREIGN KEY (`TSID`) REFERENCES `timeslot` (`TSID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2017 at 05:26 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liveme_data`
--
CREATE DATABASE IF NOT EXISTS `liveme_data` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `liveme_data`;

-- --------------------------------------------------------

--
-- Table structure for table `contactinfo`
--

DROP TABLE IF EXISTS `contactinfo`;
CREATE TABLE IF NOT EXISTS `contactinfo` (
  `ContactInfoSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `ContactType` varchar(20) NOT NULL,
  `ContactDetails` varchar(100) NOT NULL,
  `ContactPrivacy` int(1) NOT NULL,
  `DeleteStatus` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ContactInfoSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactinfo`
--

INSERT INTO `contactinfo` (`ContactInfoSrNo`, `UserID`, `ContactType`, `ContactDetails`, `ContactPrivacy`, `DeleteStatus`) VALUES
(9, 3, 'Contact', '9825098251', 1, 0),
(4, 3, 'Contact', '9825011297', 1, 0),
(5, 3, 'Contact', 'Kolki, Upleta, Rajkot, Gujarat, India ', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `eduinfo`
--

DROP TABLE IF EXISTS `eduinfo`;
CREATE TABLE IF NOT EXISTS `eduinfo` (
  `EduInfoSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `InsName` varchar(30) NOT NULL,
  `EduType` varchar(20) NOT NULL,
  `InsJoinDate` date NOT NULL,
  `InsEndDate` date DEFAULT NULL,
  `EduDetails` varchar(100) DEFAULT NULL,
  `EduPrivacy` int(1) NOT NULL,
  `EduDeleteStatus` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`EduInfoSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eduinfo`
--

INSERT INTO `eduinfo` (`EduInfoSrNo`, `UserID`, `InsName`, `EduType`, `InsJoinDate`, `InsEndDate`, `EduDetails`, `EduPrivacy`, `EduDeleteStatus`) VALUES
(1, 3, 'RamKrishan Vidha mandir', 'Primary', '2005-06-08', '2016-12-04', 'Best school', 2, 0),
(3, 3, 'VIT University', 'College', '2015-06-18', NULL, 'i like it', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `logindetails`
--

DROP TABLE IF EXISTS `logindetails`;
CREATE TABLE IF NOT EXISTS `logindetails` (
  `LoginDetailsSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `IP` varchar(30) NOT NULL,
  `LoginTime` datetime NOT NULL,
  PRIMARY KEY (`LoginDetailsSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logindetails`
--

INSERT INTO `logindetails` (`LoginDetailsSrNo`, `UserID`, `IP`, `LoginTime`) VALUES
(1, 3, '27.251.37.55', '2017-01-21 06:07:45'),
(2, 3, '27.251.37.55', '2017-01-21 16:06:59'),
(3, 3, '27.251.37.55', '2017-01-21 17:35:06'),
(4, 3, '27.251.37.55', '2017-01-23 14:21:26'),
(5, 3, '27.251.37.55', '2017-01-24 09:51:21'),
(6, 3, '27.251.37.55', '2017-02-03 11:48:32'),
(7, 3, '27.251.37.55', '2017-02-09 15:48:35'),
(8, 3, '27.251.37.55', '2017-02-13 16:07:01'),
(9, 3, '27.251.37.55', '2017-02-20 15:56:29'),
(10, 3, '27.251.37.55', '2017-02-26 17:30:23'),
(11, 3, '27.251.37.55', '2017-03-09 09:53:50'),
(12, 3, '27.251.37.55', '2017-03-10 14:37:07'),
(13, 3, '27.251.37.55', '2017-03-15 10:48:19'),
(14, 3, '27.251.37.55', '2017-03-25 04:30:52'),
(15, 3, '27.251.37.55', '2017-04-03 09:23:04'),
(16, 3, '27.251.37.55', '2017-04-11 14:40:10'),
(17, 3, '27.251.37.55', '2017-04-11 14:46:49'),
(18, 3, '27.251.37.55', '2017-04-12 06:27:57'),
(19, 7, '27.251.37.55', '2017-04-12 06:33:44'),
(20, 5, '27.251.37.55', '2017-04-12 06:38:28'),
(21, 6, '27.251.37.55', '2017-04-12 06:42:01'),
(22, 3, '27.251.37.55', '2017-04-12 06:44:24'),
(23, 3, '27.251.37.55', '2017-05-01 17:03:54'),
(24, 3, '27.251.37.55', '2017-05-04 14:27:16');

-- --------------------------------------------------------

--
-- Table structure for table `msginfo`
--

DROP TABLE IF EXISTS `msginfo`;
CREATE TABLE IF NOT EXISTS `msginfo` (
  `CommentSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `WhoSent` int(10) NOT NULL,
  `WhoRecive` int(10) NOT NULL,
  `CommentInside` varchar(250) NOT NULL,
  `CommentTime` datetime NOT NULL,
  `CommentDelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CommentSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `msginfo`
--

INSERT INTO `msginfo` (`CommentSrNo`, `WhoSent`, `WhoRecive`, `CommentInside`, `CommentTime`, `CommentDelete`) VALUES
(1, 1, 3, 'This is first commment', '2016-12-23 09:47:21', 0),
(2, 3, 1, 'This inter msg', '2016-12-24 10:34:38', 0),
(3, 1, 3, 'ajax-comment', '2016-12-23 19:27:49', 0),
(4, 3, 1, 'hello', '2016-12-23 19:28:43', 0),
(5, 3, 1, 'how are you', '2016-12-23 19:31:22', 0),
(6, 3, 1, 'i am fime', '2016-12-23 19:31:45', 0),
(7, 1, 3, 'Good Morning', '2016-12-24 05:24:18', 0),
(8, 1, 3, 'Hello', '2016-12-24 05:31:46', 0),
(9, 1, 3, 'hi', '2016-12-24 05:32:46', 0),
(10, 1, 3, 'hi', '2016-12-24 05:32:52', 0),
(11, 1, 3, 'hi-hi', '2016-12-24 05:36:25', 0),
(12, 1, 3, 'How are you???', '2016-12-24 05:52:32', 0),
(13, 1, 3, 'i am fime', '2016-12-24 05:57:03', 0),
(14, 1, 3, 'I like coldplay', '2016-12-24 06:01:19', 0),
(15, 1, 3, 'I also like Maroon %', '2016-12-24 06:15:15', 0),
(16, 1, 3, '5*', '2016-12-24 06:15:23', 0),
(17, 1, 3, 'This is msg This is msg This is msg This is msg This is msg This is msg This is msg This is msg', '2016-12-24 06:24:04', 0),
(18, 3, 1, 'This is msg This is msg This is msg This is msg i like it i like arjit singh', '2016-12-24 06:25:11', 0),
(19, 1, 3, 'Hello How are you?????', '2016-12-24 07:34:36', 0),
(20, 1, 3, 'I am fime', '2016-12-24 08:54:37', 0),
(21, 1, 3, 'haaa', '2016-12-24 08:55:09', 0),
(22, 1, 3, 'haaa', '2016-12-24 08:56:26', 0),
(23, 1, 3, 'I i i', '2016-12-24 08:57:04', 0),
(24, 1, 3, 'Hello', '2016-12-24 08:59:04', 0),
(25, 1, 2, 'HI', '2016-12-24 11:01:03', 0),
(26, 3, 1, 'hi', '2016-12-24 17:06:58', 0),
(27, 3, 1, 'How are you??', '2016-12-26 12:19:48', 0),
(28, 3, 1, 'hello', '2016-12-28 17:43:56', 0),
(29, 3, 2, 'hello', '2017-01-04 04:42:14', 0),
(30, 3, 2, 'whats dude???', '2017-02-13 16:09:12', 0),
(31, 3, 1, 'check', '2017-03-10 14:38:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `otpsenddata`
--

DROP TABLE IF EXISTS `otpsenddata`;
CREATE TABLE IF NOT EXISTS `otpsenddata` (
  `OTPSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `SysOTP` int(6) NOT NULL,
  `OTPSendTime` datetime NOT NULL,
  `OTPStatus` int(1) NOT NULL,
  `WhatOTP` tinyint(1) NOT NULL,
  PRIMARY KEY (`OTPSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='WhatOTP 1 is for forget password and 0 is for register';

--
-- Dumping data for table `otpsenddata`
--

INSERT INTO `otpsenddata` (`OTPSrNo`, `UserID`, `SysOTP`, `OTPSendTime`, `OTPStatus`, `WhatOTP`) VALUES
(1, 1, 608996, '2016-12-02 08:26:07', 1, 0),
(2, 2, 345516, '2016-12-02 09:19:31', 1, 0),
(3, 3, 627728, '2016-12-02 09:20:43', 1, 0),
(4, 4, 859539, '2016-12-02 10:41:54', 0, 0),
(5, 6, 889230, '2016-12-20 17:09:33', 1, 0),
(6, 7, 963909, '2017-04-12 06:32:02', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `postcomment`
--

DROP TABLE IF EXISTS `postcomment`;
CREATE TABLE IF NOT EXISTS `postcomment` (
  `PostComSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `PostID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `ComInside` text NOT NULL,
  `ComTime` datetime NOT NULL,
  PRIMARY KEY (`PostComSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postcomment`
--

INSERT INTO `postcomment` (`PostComSrNo`, `PostID`, `UserID`, `ComInside`, `ComTime`) VALUES
(1, 3, 3, 'This is awesome', '2016-12-19 08:35:19'),
(2, 3, 3, 'Hello Everybody', '2016-12-19 12:55:14'),
(6, 3, 3, 'This is last', '2016-12-19 13:01:16'),
(7, 3, 1, 'This is first inter user comment', '2016-12-23 08:11:53'),
(8, 9, 3, 'hello', '2016-12-29 15:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `postdetails`
--

DROP TABLE IF EXISTS `postdetails`;
CREATE TABLE IF NOT EXISTS `postdetails` (
  `PostSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `PostInside` text NOT NULL,
  `PostImage` text,
  `PostSubject` int(10) NOT NULL,
  `WhoPost` int(10) NOT NULL,
  PRIMARY KEY (`PostSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postdetails`
--

INSERT INTO `postdetails` (`PostSrNo`, `PostInside`, `PostImage`, `PostSubject`, `WhoPost`) VALUES
(1, 'HI i this is my first poem', NULL, 1, 3),
(2, ' This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post This is my first post', NULL, 1, 3),
(4, 'Hello i am here.............', NULL, 2, 3),
(11, 'VIT Chennai', 'img/post/img_post_3_2016123015476.jpg', 1, 3),
(7, 'CID is about to over thats why i started to write this blog so enjoy this blog', NULL, 3, 1),
(10, 'Sunburn', 'img/post/img-post-3--2016-12-26-11-50-23.jpg', 1, 3),
(9, 'This is Techno VIT. It is awesome', NULL, 1, 3),
(12, 'Im travelling to Goa today. Hope it will be fun. ', 'img/post/img_post_7_201741263639.jpg', 4, 7),
(13, 'Hey! i will be travelling back home to Bangalore after a very long time as i have a long weekend from college.', 'img/post/img_post_5_201741264020.jpg', 5, 5),
(14, 'I m planning to go to monaco this vacation.I hope it will be a bright trip.', 'img/post/img_post_6_201741264348.jpg', 6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `postlike`
--

DROP TABLE IF EXISTS `postlike`;
CREATE TABLE IF NOT EXISTS `postlike` (
  `PostLikeSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `PostID` int(10) NOT NULL,
  `UserID` int(10) NOT NULL,
  `LikeTime` datetime NOT NULL,
  `LikeDelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PostLikeSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postlike`
--

INSERT INTO `postlike` (`PostLikeSrNo`, `PostID`, `UserID`, `LikeTime`, `LikeDelete`) VALUES
(77, 17, 3, '2017-05-01 17:04:16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `postme`
--

DROP TABLE IF EXISTS `postme`;
CREATE TABLE IF NOT EXISTS `postme` (
  `PostMeSr` int(10) NOT NULL AUTO_INCREMENT,
  `RealPostID` int(10) NOT NULL,
  `ShareUserID` int(11) NOT NULL,
  `PostTime` datetime NOT NULL,
  `PostDelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PostMeSr`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postme`
--

INSERT INTO `postme` (`PostMeSr`, `RealPostID`, `ShareUserID`, `PostTime`, `PostDelete`) VALUES
(1, 2, 3, '2016-12-18 16:00:15', 0),
(2, 1, 3, '2016-12-18 07:10:04', 0),
(3, 4, 3, '2016-12-19 05:09:59', 0),
(4, 5, 6, '2016-12-20 17:13:04', 0),
(5, 6, 6, '2016-12-20 17:19:16', 0),
(6, 7, 1, '2016-12-22 17:37:02', 0),
(7, 2, 1, '2016-12-23 09:02:08', 1),
(8, 4, 1, '2016-12-23 09:03:08', 0),
(9, 4, 1, '2016-12-23 09:22:07', 0),
(10, 9, 3, '2016-12-23 11:28:21', 0),
(11, 4, 3, '2016-12-25 12:38:24', 0),
(12, 7, 3, '2016-12-26 07:52:24', 0),
(13, 10, 3, '2016-12-26 11:50:23', 0),
(14, 11, 3, '2016-12-30 15:47:06', 0),
(15, 12, 7, '2017-04-12 06:36:39', 0),
(16, 13, 5, '2017-04-12 06:40:20', 0),
(17, 14, 6, '2017-04-12 06:43:48', 0);

-- --------------------------------------------------------

--
-- Table structure for table `postsubject`
--

DROP TABLE IF EXISTS `postsubject`;
CREATE TABLE IF NOT EXISTS `postsubject` (
  `PostSubSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `PostSubName` varchar(30) NOT NULL,
  `PostSubDetails` varchar(250) NOT NULL,
  `PostSubPrivacy` int(1) NOT NULL,
  `PostSubDate` datetime NOT NULL,
  `PostSubDelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PostSubSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postsubject`
--

INSERT INTO `postsubject` (`PostSubSrNo`, `UserID`, `PostSubName`, `PostSubDetails`, `PostSubPrivacy`, `PostSubDate`, `PostSubDelete`) VALUES
(1, 3, 'Life at VIT Chennai', 'It is about my college life at vit chennai.....', 2, '2016-12-05 07:03:31', 1),
(2, 3, 'Hello Hi', 'This is one sweet story', 2, '2016-12-18 14:34:28', 0),
(3, 1, 'CID ', 'India best tv series', 2, '2016-12-22 17:36:14', 0),
(4, 7, 'Holiday', 'Easter', 2, '2017-04-12 06:35:28', 0),
(5, 5, 'Home Coming', 'Travelling back home after a very long time', 1, '2017-04-12 06:39:07', 0),
(6, 6, 'Foreign Trip', 'A trip to monaco', 2, '2017-04-12 06:42:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `profileimg`
--

DROP TABLE IF EXISTS `profileimg`;
CREATE TABLE IF NOT EXISTS `profileimg` (
  `ImgSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `ImgName` varchar(30) NOT NULL,
  `ImgSize` int(8) NOT NULL,
  `ImgMyName` varchar(50) NOT NULL,
  `ImgUploadTime` datetime NOT NULL,
  PRIMARY KEY (`ImgSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profileimg`
--

INSERT INTO `profileimg` (`ImgSrNo`, `UserID`, `ImgName`, `ImgSize`, `ImgMyName`, `ImgUploadTime`) VALUES
(8, 3, 'MonarkName.jpg', 23461, 'img/users/img-3-3.jpg', '2016-12-04 16:48:34'),
(3, 3, 'VITChennai campus.jpg', 121653, 'img/users/img-3-2.jpg', '2016-12-04 10:42:58'),
(7, 3, 'VITChennai campus.jpg', 121653, 'img/users/img-3-6.jpg', '2016-12-04 16:28:22'),
(5, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-4.gif', '2016-12-04 15:01:22'),
(9, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-4.gif', '2016-12-05 08:09:51'),
(10, 3, 'Vibrance17.jpg', 145132, 'img/users/img-3-5.jpg', '2016-12-05 17:24:31'),
(11, 3, 'VITChennai campus.jpg', 121653, 'img/users/img-3-6.jpg', '2016-12-05 17:25:30'),
(12, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-7.gif', '2016-12-15 12:02:57'),
(13, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-8.gif', '2016-12-15 12:03:52'),
(14, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-9.gif', '2016-12-15 12:04:02'),
(15, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-10.gif', '2016-12-15 12:04:23'),
(16, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-11.gif', '2016-12-15 12:05:01'),
(17, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-12.gif', '2016-12-15 12:06:11'),
(18, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-13.gif', '2016-12-15 12:06:41'),
(19, 3, 'Vibrance17.jpg', 145132, 'img/users/img-3-14.jpg', '2016-12-18 17:09:32'),
(20, 1, 'IMG-20160917-WA0049.jpg', 160049, 'img/users/img-1-0.jpg', '2016-12-23 06:32:30'),
(21, 3, 'IMG-20160917-WA0046.jpg', 100570, 'img/users/img-3-15.jpg', '2016-12-23 11:11:09'),
(22, 3, 'IMG-20160917-WA0003.jpg', 134490, 'img/users/img-3-16.jpg', '2016-12-23 11:17:49'),
(23, 3, 'IMG-20160917-WA0003.jpg', 134490, 'img/users/img-3-17.jpg', '2016-12-23 11:18:11'),
(24, 3, 'holi-doodle.gif', 288151, 'img/users/img-3-18.gif', '2017-01-07 09:49:05'),
(25, 3, 'Vibrance17.jpg', 145132, 'img/users/img-3-19.jpg', '2017-01-07 09:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `userfollow`
--

DROP TABLE IF EXISTS `userfollow`;
CREATE TABLE IF NOT EXISTS `userfollow` (
  `FollowSrNo` int(10) NOT NULL AUTO_INCREMENT,
  `UserID` int(10) NOT NULL,
  `WhoFollow` int(10) NOT NULL,
  `FollowTime` datetime NOT NULL,
  `FollowDelete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`FollowSrNo`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userfollow`
--

INSERT INTO `userfollow` (`FollowSrNo`, `UserID`, `WhoFollow`, `FollowTime`, `FollowDelete`) VALUES
(19, 3, 2, '2016-12-26 11:46:28', 0),
(18, 3, 2, '2016-12-24 12:34:32', 1),
(17, 3, 1, '2016-12-24 08:01:08', 0),
(16, 1, 3, '2016-12-23 12:54:10', 0),
(15, 1, 2, '2016-12-23 12:54:05', 0),
(20, 3, 5, '2017-04-12 06:44:34', 0),
(21, 3, 7, '2017-04-12 06:44:43', 0),
(22, 3, 6, '2017-04-12 06:44:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE IF NOT EXISTS `userinfo` (
  `UserID` int(10) NOT NULL AUTO_INCREMENT,
  `UserEmail` varchar(255) NOT NULL,
  `UserPassword` varchar(16) NOT NULL,
  `ProfileImgAddress` mediumtext NOT NULL,
  `UserName` varchar(32) NOT NULL,
  `UserGender` varchar(6) NOT NULL,
  `UserDOB` text NOT NULL,
  `UserBlock` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `UserEmail` (`UserEmail`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`UserID`, `UserEmail`, `UserPassword`, `ProfileImgAddress`, `UserName`, `UserGender`, `UserDOB`, `UserBlock`) VALUES
(1, 'monark@gmail.com', 'monark', 'img/users/img-1-0.jpg', 'Shreyas', 'male', '1998-05-31', 0),
(2, 'monarkdedakiya@gmail.com', 'monark', 'img/users/no-profile.jpg', 'Gautam ', 'male', '1996-05-31', 0),
(3, 'test@gmail.com', 'test', 'img/users/img-3-19.jpg', 'Monark Dedakiya', 'male', '1997-05-31', 0),
(5, 'san31971@gmail.com', 'syednuman9', 'img/users/no-profile.jpg', 'Syed Numan', 'male', '1997-01-03', 0),
(6, 'parth.desai131@gmail.com', 'parth131', 'img/users/no-profile.jpg', 'Parth Desai', 'male', '1998-05-31', 0),
(7, 'rohitvgs.96@gmail.com', 'rohitvgs', 'img/users/no-profile.jpg', 'Rohit Viegas', 'male', '1996-11-25', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

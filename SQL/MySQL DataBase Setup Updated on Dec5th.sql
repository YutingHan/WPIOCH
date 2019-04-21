-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 5, 2018 at 14:56 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10
-- create or replace or replace DATABASE miniproject;

create database miniproject;
USE miniproject;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miniproject`
--

-- --------------------------------------------------------
--
-- Table structure for table `user`
--

create or replace TABLE `User` (
  `user_id` varchar(20) NOT NULL,
  `uPassword` varchar(20) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `wechat` varchar(20) DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `preference` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `user`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

-- --------------------------------------------------------

--
-- Table structure for table `House`
--

create or replace TABLE `House` (
  `Hid` int(20) NOT NULL,
  `Street` varchar(20) NOT NULL,
  `City` varchar(20) NOT NULL,
  `State` varchar(10) NOT NULL,
  `Latitude` float NOT NULL,
  `Longitude` float NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `description` text,
  `image` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` int(11),
  `updatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image2` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `House`
--
ALTER TABLE `House`
  ADD PRIMARY KEY (`Hid`);
--  ADD KEY `username` (`username`);

ALTER TABLE `House`
  ADD CONSTRAINT `House_uidfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

ALTER TABLE `House`
  MODIFY `Hid` int(20) NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `Restaurant_Distance`
--

create or replace TABLE `Restaurant_Distance` (
  `Hid` int(20) NOT NULL,
  `Restaurant_Name` varchar(20) NOT NULL,
  `rDistance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Restaurant_Distance`
  ADD PRIMARY KEY (`Hid`,`Restaurant_Name`);

ALTER TABLE `Restaurant_Distance`
  ADD CONSTRAINT `Restaurant_Distance_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;

--
-- Table structure for table `Supermarket_Distance`
--

create or replace TABLE `Supermarket_Distance` (
  `Hid` int(20) NOT NULL,
  `Supermarket_Name` varchar(20) NOT NULL,
  `sDistance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Supermarket_Distance`
  ADD PRIMARY KEY (`Hid`,`Supermarket_Name`);

ALTER TABLE `Supermarket_Distance`
  ADD CONSTRAINT `Supermarket_Distance_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;

--
-- Table structure for table `School_Distance`
--
create or replace TABLE `School_Distance` (
  `Hid` int(20) NOT NULL,
  `Gym_Distance` float NOT NULL,
  `Library_Distance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `School_Distance`
  ADD PRIMARY KEY (`Hid`);

ALTER TABLE `School_Distance`
  ADD CONSTRAINT `School_Distance_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;

--
-- Table structure for table `Utilities`
--
create or replace TABLE `Utilities` (
  `Hid` int(20) NOT NULL,
  `appliances` varchar(30),
  `Parking` varchar(30),
  `heating` varchar(30)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Utilities`
  ADD PRIMARY KEY (`Hid`);

ALTER TABLE `Utilities`
  ADD CONSTRAINT `Utilities_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;

--
-- Table structure for table `Attributes`
--
create or replace TABLE `Attributes` (
    `Hid` int(20) NOT NULL,
    `Distance_from_School` CHAR(1) check(`Distance_from_School` in ('A','B','C')),
    `Distance_from_Food` CHAR(1) check(`Distance_from_Food` in ('A','B','C')),
    `Distance_from_Supermarket` CHAR(1) check(`Distance_from_Supermarket` in ('A','B','C')),
    `Crime_Rate` CHAR(1) check(`Crime_Rate` in ('A','B','C'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Attributes`
  ADD PRIMARY KEY (`Hid`);

ALTER TABLE `Attributes`
  ADD CONSTRAINT `ttributes_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;


--
-- Table structure for table `Favorite`
--

create or replace TABLE `Favorite` (
  `Hid` int(20) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Favorite`
  ADD PRIMARY KEY (`Hid`,`user_id`);

ALTER TABLE `Favorite`
  ADD CONSTRAINT `Favorite_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE;
ALTER TABLE `Favorite`
  ADD CONSTRAINT `Favidfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;
--
-- Table structure for table `Find_Roomate`
--

create or replace TABLE `Find_Roomate` (
  `Hid` int(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Find_Roomate`
  ADD PRIMARY KEY (`Hid`,`user_id`);

ALTER TABLE `Find_Roomate`
  ADD CONSTRAINT `Find_Roomate_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE,
  ADD CONSTRAINT `Find_Roomate_user_idfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Table structure for table `comment`
--

create or replace TABLE `Comment` (
  `user_id` varchar(20) NOT NULL,
  `Hid` int(20) NOT NULL,
  `content` text,
  `CommentSeq` varchar(10) NOT NULL,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Constraints for table `comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`Hid`,`CommentSeq`);

ALTER TABLE `Comment`
  ADD CONSTRAINT `comment_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_user_idfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;


--
-- Table structure for table `Search_Record`
--

create or replace TABLE `Search_Record` (
  `Hid` int(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `Search_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sDistance_from_School` CHAR(1) check(`sDistance_from_School` in ('A','B','C')),
  `sDistance_from_Food` CHAR(1) check(`sDistance_from_Food` in ('A','B','C')),
  `sDistance_from_Supermarket` CHAR(1) check(`sDistance_from_Supermarket` in ('A','B','C')),
  `sCrime_Rate` CHAR(1) check(`sCrime_Rate` in ('A','B','C'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Search_Record`
  ADD PRIMARY KEY (`Hid`,`user_id`);

ALTER TABLE `Search_Record`
  ADD CONSTRAINT `Search_Record_hidfk_1` FOREIGN KEY (`Hid`) REFERENCES `House` (`Hid`) ON DELETE CASCADE,
  ADD CONSTRAINT `Search_Record_user_idfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`) ON DELETE CASCADE;

--
-- Table structure for table `Crime`
--

create or replace TABLE `Crime` (
  `Cid` int(20) NOT NULL,
  `cStreet` varchar(20) NOT NULL,
  `cType` varchar(20) NOT NULL,
  `cReport`  text,
  `cTime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `Crime`
--
ALTER TABLE `Crime`
  ADD PRIMARY KEY (`Cid`);

ALTER TABLE `Crime`
  MODIFY `Cid` int(20) NOT NULL AUTO_INCREMENT;


COMMIT;

-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 08, 2016 at 01:04 AM
-- Server version: 5.5.42-37.1
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alalbeet_movesapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `act_id` int(11) NOT NULL,
  `act_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `act_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `act_duration` int(10) NOT NULL,
  `act_distance` int(10) NOT NULL,
  `act_steps` int(10) NOT NULL,
  `act_userid` int(11) NOT NULL,
  `act_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`act_id`, `act_date`, `act_type`, `act_duration`, `act_distance`, `act_steps`, `act_userid`, `act_created`) VALUES
(1, '20151230', 'walking', 1092, 1084, 1497, 1, '2016-01-07 21:03:49'),
(2, '20151231', 'walking', 2400, 2365, 3289, 1, '2016-01-07 21:03:49'),
(3, '20160101', 'walking', 517, 370, 549, 1, '2016-01-07 21:03:49'),
(4, '20160102', 'walking', 323, 161, 315, 1, '2016-01-07 21:03:49'),
(5, '20160103', 'walking', 1949, 1153, 2295, 1, '2016-01-07 21:03:49'),
(6, '20160104', 'walking', 2058, 1174, 2159, 1, '2016-01-07 21:03:49'),
(7, '20160105', 'walking', 1094, 731, 1413, 1, '2016-01-07 21:03:49'),
(8, '20160106', 'walking', 1319, 731, 1376, 1, '2016-01-07 21:03:49'),
(9, '20160107', 'walking', 171, 139, 277, 1, '2016-01-07 21:03:49'),
(10, '20160106', 'walking', 48, 25, 50, 2, '2016-01-08 05:59:58'),
(11, '20160107', 'walking', 607, 517, 789, 2, '2016-01-08 05:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `cfg_id` int(11) NOT NULL,
  `cfg_sitename` varchar(255) NOT NULL,
  `cfg_visitors` int(20) NOT NULL,
  `cfg_clientid` varchar(255) NOT NULL,
  `cfg_clientsecret` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`cfg_id`, `cfg_sitename`, `cfg_visitors`, `cfg_clientid`, `cfg_clientsecret`) VALUES
(1, 'Test', 14547, '31MdmA43fQCqkf806vhJmuhxLHV86tG2', 'c_9kitibAUP8tjyguEtEzh9C5f3P8Z5LavzAE0i78tRdg8qnjQ7913491Z7cve8_');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `ses_id` int(11) NOT NULL,
  `ses_userid` int(11) NOT NULL,
  `ses_timein` varchar(20) NOT NULL,
  `ses_timeout` varchar(20) NOT NULL,
  `ses_code` varchar(50) NOT NULL,
  `ses_accesstoken` varchar(255) NOT NULL,
  `ses_refreshtoken` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`ses_id`, `ses_userid`, `ses_timein`, `ses_timeout`, `ses_code`, `ses_accesstoken`, `ses_refreshtoken`) VALUES
(16, 1, '1452186776', '1467738775', '568e9c9817c95', 'CCx87v9J5GNVF3hdBofw1pS4j7Jk4vZ71bivDn065n_M9I9SQ5YXFTD61F34ZjwV', '8_5SKq61UM6JpwyBwwhCvNXStEkP4dOz8WVPQihk9XSzsc7ix5'),
(20, 3, '1452233312', '1452319712', '568f526074303', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE IF NOT EXISTS `usergroups` (
  `ug_id` int(11) NOT NULL,
  `ug_title` varchar(255) NOT NULL,
  `ug_active` tinyint(1) NOT NULL,
  `ug_addedby` int(11) NOT NULL,
  `ug_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usergroups`
--

INSERT INTO `usergroups` (`ug_id`, `ug_title`, `ug_active`, `ug_addedby`, `ug_created`) VALUES
(1, 'Administrators', 1, 1, '2015-06-12 12:27:43'),
(2, 'Registered User', 1, 1, '2015-06-12 12:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `user_movesuserid` bigint(30) NOT NULL,
  `user_groupid` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_lastlogin` datetime NOT NULL,
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_status` varchar(10) NOT NULL,
  `user_firstdate` date NOT NULL,
  `user_timezone` varchar(30) NOT NULL,
  `user_lang` varchar(10) NOT NULL,
  `user_locale` varchar(10) NOT NULL,
  `user_platform` varchar(50) NOT NULL,
  `user_lastrefresh` int(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_movesuserid`, `user_groupid`, `user_fullname`, `user_username`, `user_password`, `user_email`, `user_lastlogin`, `user_created`, `user_status`, `user_firstdate`, `user_timezone`, `user_lang`, `user_locale`, `user_platform`, `user_lastrefresh`) VALUES
(1, 34476512543005945, 2, 'User: 34476512543005943', '34476512543005945', '8ae57553ed07fde7528505ed4e1a39ed', '', '2016-01-07 21:12:56', '2016-01-07 17:12:56', 'AC', '2016-01-06', 'Africa/Cairo', 'en', 'en_GB', 'android', 1452200629),
(2, 34476512543005943, 2, 'User: 34476512543005943', '34476512543005943', '658ec46a90385737b5dc4b5e8da0875e', '', '2016-01-08 10:05:07', '2016-01-08 05:59:31', 'AC', '2016-01-06', 'Africa/Cairo', 'en', 'en_GB', 'android', 1452232798),
(3, 0, 1, 'Ahmed Saed', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'eng.ahmeds3ed@gmail.com', '2016-01-08 10:08:32', '2016-01-08 06:07:08', 'AC', '0000-00-00', '', '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`cfg_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`ses_id`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`ug_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_username` (`user_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `cfg_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `ses_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `ug_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

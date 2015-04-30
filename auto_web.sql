-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-04-30 04:55:21
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `auto_web`
--

-- --------------------------------------------------------

--
-- 表的结构 `ci_admin`
--

CREATE TABLE IF NOT EXISTS `ci_admin` (
`id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(40) NOT NULL,
  `last_login` char(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_admin_project_map`
--

CREATE TABLE IF NOT EXISTS `ci_admin_project_map` (
`id` int(10) unsigned NOT NULL,
  `aid` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_case`
--

CREATE TABLE IF NOT EXISTS `ci_case` (
`id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `cname` varchar(100) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `orderby` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_case_step`
--

CREATE TABLE IF NOT EXISTS `ci_case_step` (
`id` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `pack_id` int(10) unsigned NOT NULL,
  `checkpoint` varchar(255) NOT NULL,
  `action` tinyint(3) unsigned NOT NULL,
  `locator` tinyint(3) unsigned NOT NULL,
  `element` varchar(255) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `data` text NOT NULL,
  `orderby` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=405 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_ele_repository`
--

CREATE TABLE IF NOT EXISTS `ci_ele_repository` (
`id` int(10) unsigned NOT NULL,
  `alias` varchar(150) CHARACTER SET utf8 NOT NULL,
  `locator` int(10) unsigned NOT NULL,
  `element` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `ci_execute`
--

CREATE TABLE IF NOT EXISTS `ci_execute` (
`id` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  `filename` char(15) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_pack`
--

CREATE TABLE IF NOT EXISTS `ci_pack` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `times` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_pack_step`
--

CREATE TABLE IF NOT EXISTS `ci_pack_step` (
`id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `checkpoint` varchar(255) NOT NULL,
  `action` int(10) unsigned NOT NULL,
  `locator` int(10) unsigned NOT NULL,
  `element` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `orderby` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_project`
--

CREATE TABLE IF NOT EXISTS `ci_project` (
`id` int(10) unsigned NOT NULL,
  `aid` int(10) unsigned NOT NULL,
  `pname` varchar(100) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ci_setting`
--

CREATE TABLE IF NOT EXISTS `ci_setting` (
`id` int(10) unsigned NOT NULL,
  `aid` int(10) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_admin`
--
ALTER TABLE `ci_admin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_admin_project_map`
--
ALTER TABLE `ci_admin_project_map`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_case`
--
ALTER TABLE `ci_case`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_case_step`
--
ALTER TABLE `ci_case_step`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_ele_repository`
--
ALTER TABLE `ci_ele_repository`
 ADD PRIMARY KEY (`id`), ADD KEY `alias` (`alias`);

--
-- Indexes for table `ci_execute`
--
ALTER TABLE `ci_execute`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_pack`
--
ALTER TABLE `ci_pack`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_pack_step`
--
ALTER TABLE `ci_pack_step`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_project`
--
ALTER TABLE `ci_project`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_setting`
--
ALTER TABLE `ci_setting`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_admin`
--
ALTER TABLE `ci_admin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `ci_admin_project_map`
--
ALTER TABLE `ci_admin_project_map`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ci_case`
--
ALTER TABLE `ci_case`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `ci_case_step`
--
ALTER TABLE `ci_case_step`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=405;
--
-- AUTO_INCREMENT for table `ci_ele_repository`
--
ALTER TABLE `ci_ele_repository`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `ci_execute`
--
ALTER TABLE `ci_execute`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `ci_pack`
--
ALTER TABLE `ci_pack`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ci_pack_step`
--
ALTER TABLE `ci_pack_step`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `ci_project`
--
ALTER TABLE `ci_project`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

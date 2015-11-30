-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 12 月 12 日 14:55
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `testguest`
--
CREATE DATABASE `testguest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `testguest`;

-- --------------------------------------------------------

--
-- 表的结构 `tg_article`
--

CREATE TABLE IF NOT EXISTS `tg_article` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//post id',
  `tg_reid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '//main post id',
  `tg_username` varchar(20) NOT NULL COMMENT '//post person',
  `tg_type` tinyint(2) unsigned NOT NULL COMMENT '//post type',
  `tg_title` varchar(80) NOT NULL COMMENT '//title',
  `tg_content` text NOT NULL COMMENT '//content',
  `tg_readcount` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '//number of being readed',
  `tg_commentcount` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '//number of comments',
  `tg_nice` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '//good post',
  `tg_last_modify_date` datetime NOT NULL COMMENT '//last modified',
  `tg_date` datetime NOT NULL COMMENT '//post date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `tg_article`
--

INSERT INTO `tg_article` (`tg_id`, `tg_reid`, `tg_username`, `tg_type`, `tg_title`, `tg_content`, `tg_readcount`, `tg_commentcount`, `tg_nice`, `tg_last_modify_date`, `tg_date`) VALUES
(1, 0, 'zzhang1', 1, 'a a a ', 'this is a testthis is a testthis is a testthis is a testthis is a testthis is a testthis is a testthis is a testthis is a testthis is a test', 13, 0, 0, '0000-00-00 00:00:00', '2011-11-28 21:13:32'),
(2, 0, 'lulumao', 10, 'testing post', '[size=20]font size[/size]\r\n\r\n[b]bold[/b]\r\n\r\n[i]italic[/i]\r\n\r\n[u]underline[/u]\r\n\r\n[s]strikethrough[/s]\r\n\r\n[color=#396]color[/color]\r\n\r\n[url]http://www.baidu.com[/url]\r\n\r\n[email]athrun07091988@gmail.com[/email]\r\n\r\n[img]qpic\\1\\30.gif[/img]\r\n\r\nmiao le ge mi de wo lai kan kan', 339, 11, 0, '2011-11-30 14:02:13', '2011-11-29 14:13:05'),
(3, 2, 'zidian2', 8, 'RE:testing post', 'this is a testing reply\r\n\r\n[img]qpic/3/9.gif[/img][img]qpic/3/5.gif[/img][img]qpic/3/2.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-29 17:20:26'),
(4, 2, 'clathrun', 8, 'RE:testing post', 'dahuadahuadahuadahuadahuadahuadahuadahuadahuadahuadahuadahuadahuadahuadahua', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-29 21:46:21'),
(5, 2, 'st_ao', 8, 'RE:testing post', 'geiligeiligeiligeiligeiligeiligeiligeiligeiligeiligeiligeiligeili', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-29 21:46:50'),
(6, 2, 'st_ao', 8, 'RE:testing post', 'wo lai ding ding wo lai ding ding wo lai ding ding wo lai ding ding wo lai ding ding [img]qpic/3/5.gif[/img][img]qpic/3/9.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 00:59:56'),
(7, 2, 'st_ao', 8, 'RE:testing post', 'zai shi yi shi...', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 01:02:47'),
(8, 2, 'st_ao', 8, 'RE:testing post', 'let me see...let me see...let me see...let me see...let me see...let me see...let me see...[img]qpic/3/17.gif[/img][img]qpic/3/14.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 01:21:08'),
(9, 0, 'st_ao', 10, 'miao le ge mi', 'miao le ge mi miao le ge mi miao le ge mi miao le ge mi miao le ge mi miao le ge mi miao le ge mi [img]qpic\\1\\8.gif[/img][img]qpic\\1\\5.gif[/img][img]qpic\\1\\6.gif[/img]', 21, 0, 0, '0000-00-00 00:00:00', '2011-11-30 13:20:13'),
(10, 0, 'clathrun', 11, 'the first time to post', 'the first time to postthe first time to postthe first time to postthe first time to postthe first time to post', 2, 0, 0, '0000-00-00 00:00:00', '2011-11-30 21:52:28'),
(11, 0, 'clathrun', 1, 'see it...', 'see it...see it...see it...see it...see it...', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 21:53:40'),
(12, 0, 'clathrun', 1, 'see it...', 'see it...see it...see it...see it...see it...see it...see it...see it...see it...', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 21:54:25'),
(13, 0, 'clathrun', 1, 'testing post', 'testing posttesting posttesting posttesting posttesting posttesting posttesting posttesting posttesting posttesting posttesting posttesting post', 1, 0, 0, '0000-00-00 00:00:00', '2011-11-30 21:58:12'),
(14, 0, 'clathrun', 1, 'a a a a a a', 'sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf sdf ', 1, 0, 0, '0000-00-00 00:00:00', '2011-11-30 21:59:00'),
(15, 0, 'zzhang1', 1, 'see it...', 'see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...see it...', 1, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:00:16'),
(16, 0, 'zzhang1', 1, 'try the function', 'try the function try the function try the function try the function try the function try the function try the function try the function try the function try the function try the function try the function try the function ', 2, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:06:48'),
(17, 2, 'zzhang1', 8, 'RE:testing post', 'spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming ', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:12:13'),
(18, 2, 'zzhang1', 8, 'RE:testing post', 'spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming ', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:14:02'),
(19, 2, 'zzhang1', 8, 'RE:testing post', 'spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming spamming ', 0, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:14:46'),
(20, 0, 'zzhang1', 1, 'test database', 'test databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest databasetest database', 5, 0, 0, '0000-00-00 00:00:00', '2011-11-30 22:25:38'),
(21, 0, 'zzhang1', 1, 'test database again', 'test database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database againtest database again', 9, 3, 0, '0000-00-00 00:00:00', '2011-12-01 00:15:18'),
(22, 21, 'zzhang1', 1, 'RE:test database again', 'afa afa afa afa afa afa ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-01 00:15:29'),
(23, 2, 'zidian2', 8, 'RE:testing post', '[img]qpic/1/12.gif[/img][img]qpic/1/14.gif[/img][img]qpic/1/17.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-01 12:45:28'),
(24, 0, 'zidian2', 1, 'adfa asdf', 'adfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdfadfa asdf', 4, 0, 0, '0000-00-00 00:00:00', '2011-12-01 17:36:30'),
(25, 2, 'zidian2', 8, 'RE:testing post', 'adsf adsf adsf adsf adsf adsf adsf adsf adsf adsf ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-01 17:41:07'),
(26, 21, 'zidian2', 1, 'RE:test database again', 'asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf asdf ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-01 17:41:29'),
(27, 21, 'zidian2', 1, 'Reply zzhang1 in 2.#.', '<div class="re">\r\n		<dl>\r\n			<dd class="user"><?php echo $_html[''username''];?>(<?php echo $_html[''sex''];?>)</dd>\r\n			<dt><img src="<?php echo $_html[''face''];?>" alt="<?php echo $_html[''username''];?>" /></dt>\r\n			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html[''userid''];?>">Message</a></dd>\r\n			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html[''userid''];?>">+Friend</a></dd>\r\n			<dd class="guest">Post</dd>\r\n			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html[''userid''];?>">Flower</a></dd>\r\n			<dd class="email">Email:<a href="mailto:<?php echo $_html[''email''];?>"><?php echo $_html[''email''];?></a></dd>\r\n			<dd class="url">URL:<a href="<?php echo $_html[''url''];?>" target="_blank"><?php echo $_html[''url''];?></a></dd>\r\n		</dl>\r\n		<div class="content">\r\n			<div class="user">\r\n				<span><?php echo $_i+(($_page-1)*$_pagesize);?>#</span><?php echo $_html[''username''];?> | post at:<?php echo $_html[''date''];?>\r\n			</div>\r\n			<h3>Topic: <?php echo $_html[''retitle''];?> <img src="images/icon<?php echo $_html[''type''];?>.gif"alt="icon"/><?php if(isset($_html[''re''])) {echo $_html[''re''];}?></h3>\r\n			<div class="detail">\r\n				<?php echo _ubb($_html[''content'']);?>\r\n				<?php \r\n					if ($_html[''switch''] == 1) {\r\n						echo ''<p class="autograph">''._ubb($_html[''autograph'']).''</p>'';\r\n				}\r\n				?>\r\n			</div>\r\n		</div>\r\n	</div>', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-03 16:56:36'),
(28, 0, 'zidian2', 4, 'as dfasdf', '<div class="re">\r\n		<dl>\r\n			<dd class="user"><?php echo $_html[''username''];?>(<?php echo $_html[''sex''];?>)</dd>\r\n			<dt><img src="<?php echo $_html[''face''];?>" alt="<?php echo $_html[''username''];?>" /></dt>\r\n			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html[''userid''];?>">Message</a></dd>\r\n			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html[''userid''];?>">+Friend</a></dd>\r\n			<dd class="guest">Post</dd>\r\n			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html[''userid''];?>">Flower</a></dd>\r\n			<dd class="email">Email:<a href="mailto:<?php echo $_html[''email''];?>"><?php echo $_html[''email''];?></a></dd>\r\n			<dd class="url">URL:<a href="<?php echo $_html[''url''];?>" target="_blank"><?php echo $_html[''url''];?></a></dd>\r\n		</dl>\r\n		<div class="content">\r\n			<div class="user">\r\n				<span><?php echo $_i+(($_page-1)*$_pagesize);?>#</span><?php echo $_html[''username''];?> | post at:<?php echo $_html[''date''];?>\r\n			</div>\r\n			<h3>Topic: <?php echo $_html[''retitle''];?> <img src="images/icon<?php echo $_html[''type''];?>.gif"alt="icon"/><?php if(isset($_html[''re''])) {echo $_html[''re''];}?></h3>\r\n			<div class="detail">\r\n				<?php echo _ubb($_html[''content'']);?>\r\n				<?php \r\n					if ($_html[''switch''] == 1) {\r\n						echo ''<p class="autograph">''._ubb($_html[''autograph'']).''</p>'';\r\n				}\r\n				?>\r\n			</div>\r\n		</div>\r\n	</div>', 8, 1, 0, '0000-00-00 00:00:00', '2011-12-03 16:56:58'),
(29, 0, 'zidian2', 11, 'test it', 'test it test it test it test it test it test it test it test it test it test it ', 14, 2, 0, '0000-00-00 00:00:00', '2011-12-04 14:32:32'),
(30, 29, 'zidian2', 11, 'RE:test it', 'dfvdavasdfas', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-04 14:36:46'),
(31, 28, 'zidian2', 4, 'RE:as dfasdf', ' efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf  efewf ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-04 14:50:32'),
(32, 29, 'zhiming', 11, 'RE:test it', 'i''m new i''m new i''m new i''m new i''m new i''m new i''m new i''m new i''m new ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-04 15:29:42'),
(33, 0, 'zhiming', 8, 'i''m new', 'i''ll write it again.i''ll write it again.i''ll write it again.', 4, 0, 0, '2011-12-04 16:46:46', '2011-12-04 15:30:16'),
(34, 0, 'zhiming', 3, 'this is my forum ', 'this is my forum this is my forum this is my forum this is my forum ', 6, 1, 0, '0000-00-00 00:00:00', '2011-12-04 16:44:18'),
(35, 34, 'zhiming', 3, 'RE:this is my forum ', 'good website', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-04 16:44:31'),
(40, 0, 'Icemm1', 4, 'test a post modified', '[img]qpic\\1\\17.gif[/img]\r\ntest a post test a post test a post test a post test a post test a post test a post test a post test a post test a post test a post test a post test a post test a post ', 13, 2, 0, '2011-12-09 23:07:36', '2011-12-09 22:51:39'),
(37, 0, 'gmc', 1, 'good luck ', 'good luck good luck good luck good luck good luck good luck good luck good luck good luck good luck good luck good luck good luck good luck ', 6, 0, 0, '0000-00-00 00:00:00', '2011-12-05 13:55:13'),
(38, 0, 'zidian2', 1, 'what a good day ', 'what a good day what a good day what a good day what a good day ', 18, 1, 0, '0000-00-00 00:00:00', '2011-12-05 14:54:34'),
(39, 38, 'zidian2', 1, 'RE:what a good day ', '[img]qpic/1/9.gif[/img][img]qpic/1/8.gif[/img][img]qpic/1/11.gif[/img]', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-05 14:54:57'),
(41, 0, 'Icemm1', 1, 'test two posts', 'test two poststest two poststest two poststest two poststest two poststest two poststest two poststest two poststest two poststest two posts', 4, 0, 0, '0000-00-00 00:00:00', '2011-12-09 22:54:14'),
(42, 40, 'Icemm1', 4, 'RE:test a post ', 'verify the post verify the post verify the post verify the post verify the post verify the post verify the post ', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-09 22:59:36'),
(43, 40, 'Icemm1', 4, 'RE:test a post ', 'verify the postverify the postverify the postverify the postverify the postverify the postverify the postverify the postverify the postverify the postverify the postverify the post', 0, 0, 0, '0000-00-00 00:00:00', '2011-12-09 23:01:05');

-- --------------------------------------------------------

--
-- 表的结构 `tg_dir`
--

CREATE TABLE IF NOT EXISTS `tg_dir` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//album directory',
  `tg_type` tinyint(1) unsigned NOT NULL COMMENT '//album type',
  `tg_password` char(40) DEFAULT NULL COMMENT '//album password',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '//description',
  `tg_face` varchar(200) DEFAULT NULL COMMENT '//album cover',
  `tg_dir` varchar(200) NOT NULL COMMENT '//album path',
  `tg_date` datetime NOT NULL COMMENT '//date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `tg_dir`
--

INSERT INTO `tg_dir` (`tg_id`, `tg_name`, `tg_type`, `tg_password`, `tg_content`, `tg_face`, `tg_dir`, `tg_date`) VALUES
(5, 'moshou', 0, NULL, 'moshou', 'monipic/moshou.jpg', 'photo/1322816249', '2011-12-02 16:57:29'),
(4, 'china joy', 1, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'china joy', 'monipic\\chinajoy.jpg', 'photo/1322816237', '2011-12-02 16:57:17');

-- --------------------------------------------------------

--
-- 表的结构 `tg_flower`
--

CREATE TABLE IF NOT EXISTS `tg_flower` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) NOT NULL COMMENT '//sender',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//receiver',
  `tg_flower` mediumint(8) unsigned NOT NULL COMMENT '//number of flowers',
  `tg_content` varchar(800) NOT NULL COMMENT '//comment',
  `tg_date` datetime NOT NULL COMMENT '/date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `tg_flower`
--

INSERT INTO `tg_flower` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_flower`, `tg_content`, `tg_date`) VALUES
(1, 'zzhang1', 'zidian2', 6, 'I am very appreciated to you, sending you flowers(^^)', '2011-11-28 21:10:52'),
(2, 'gmc', 'zhiming', 10, 'I am very appreciated to you, sending you flowers(^^)', '2011-12-04 15:29:11'),
(3, 'gmc', 'goodluck', 10, 'I am very appreciated to you, sending you flowers(^^)', '2011-12-05 13:52:55'),
(4, 'luckday', 'zidian2', 10, 'I am very appreciated to you, sending you flowers(^^)', '2011-12-05 14:53:45');

-- --------------------------------------------------------

--
-- 表的结构 `tg_friend`
--

CREATE TABLE IF NOT EXISTS `tg_friend` (
  `tg_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) NOT NULL COMMENT '//request receiver',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//request sender',
  `tg_content` varchar(800) NOT NULL COMMENT '//content',
  `tg_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//state',
  `tg_date` datetime NOT NULL COMMENT '//date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `tg_friend`
--

INSERT INTO `tg_friend` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(3, 'zhiming', 'zidian2', 'I would love to be your friend...', 1, '2011-12-04 17:05:43'),
(4, 'gmc', 'goodluck', 'I would love to be your friend...', 1, '2011-12-05 13:50:11'),
(5, 'luckday', 'zidian2', 'I would love to be your friend...', 1, '2011-12-05 14:53:35'),
(6, 'st_ao', 'Icemm1', 'I would love to be your friend...', 1, '2011-12-09 22:32:09');

-- --------------------------------------------------------

--
-- 表的结构 `tg_message`
--

CREATE TABLE IF NOT EXISTS `tg_message` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_touser` varchar(20) NOT NULL COMMENT '//reciever',
  `tg_fromuser` varchar(20) NOT NULL COMMENT '//sender',
  `tg_content` varchar(800) NOT NULL COMMENT '//content',
  `tg_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '//state',
  `tg_date` datetime NOT NULL COMMENT '//date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `tg_message`
--

INSERT INTO `tg_message` (`tg_id`, `tg_touser`, `tg_fromuser`, `tg_content`, `tg_state`, `tg_date`) VALUES
(1, 'zzhang1', 'zidian2', 'this is a text', 1, '2011-11-28 21:10:26'),
(5, 'gmc', 'goodluck', 'hi,girl f f f d d d g d s', 1, '2011-12-05 13:52:04'),
(3, 'zhiming', 'gmc', 'hi, how are you?', 1, '2011-12-04 15:31:45'),
(6, 'luckday', 'zidian2', 'hi how are you?', 1, '2011-12-05 14:53:24'),
(7, 'st_ao', 'Icemm1', '32343443err3r3r3r3r', 1, '2011-12-09 22:31:01');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo`
--

CREATE TABLE IF NOT EXISTS `tg_photo` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_name` varchar(20) NOT NULL COMMENT '//name of a picture',
  `tg_url` varchar(200) NOT NULL COMMENT '//path of a picture',
  `tg_content` varchar(200) DEFAULT NULL COMMENT '//description',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '//directory of a picture',
  `tg_username` varchar(20) NOT NULL COMMENT '//uploader',
  `tg_readcount` smallint(5) NOT NULL DEFAULT '0' COMMENT '//page view',
  `tg_commentcount` smallint(5) NOT NULL DEFAULT '0' COMMENT '//number of comments',
  `tg_date` datetime NOT NULL,
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 转存表中的数据 `tg_photo`
--

INSERT INTO `tg_photo` (`tg_id`, `tg_name`, `tg_url`, `tg_content`, `tg_sid`, `tg_username`, `tg_readcount`, `tg_commentcount`, `tg_date`) VALUES
(10, 'china joy', 'photo/1322816237/1322924299.jpg', '11', 4, 'zidian2', 0, 0, '2011-12-03 22:58:23'),
(11, 'china joy', 'photo/1322816237/1322924352.jpg', 'a2', 4, 'zidian2', 0, 0, '2011-12-03 22:59:15'),
(12, 'china joy', 'photo/1322816237/1322924373.jpg', 'a3', 4, 'zidian2', 0, 0, '2011-12-03 22:59:36'),
(13, 'china joy', 'photo/1322816237/1322924393.jpg', 'a4', 4, 'zidian2', 0, 0, '2011-12-03 22:59:56'),
(14, 'china joy', 'photo/1322816237/1322924418.jpg', 'a5', 4, 'zidian2', 0, 0, '2011-12-03 23:00:22'),
(15, 'china joy', 'photo/1322816237/1322924438.jpg', 'a6', 4, 'zidian2', 0, 0, '2011-12-03 23:00:41'),
(16, 'china joy', 'photo/1322816237/1322924456.jpg', 'a7', 4, 'zidian2', 0, 0, '2011-12-03 23:01:01'),
(17, 'china joy', 'photo/1322816237/1322924482.jpg', 'a8', 4, 'zidian2', 0, 0, '2011-12-03 23:01:26'),
(18, 'china joy', 'photo/1322816237/1322924505.jpg', 'a9', 4, 'zidian2', 2, 0, '2011-12-03 23:01:49'),
(19, 'china joy', 'photo/1322816237/1322924536.jpg', 'a10', 4, 'zidian2', 10, 2, '2011-12-03 23:02:20'),
(20, 'china joy', 'photo/1322816237/1322924554.jpg', 'a11', 4, 'zidian2', 7, 1, '2011-12-03 23:02:40'),
(21, 'comic', 'photo/1322816249/1322924873.jpg', '1', 5, 'zidian2', 0, 0, '2011-12-03 23:07:55'),
(22, 'comic', 'photo/1322816249/1322924892.jpg', '2', 5, 'zidian2', 0, 0, '2011-12-03 23:08:17'),
(23, 'comic', 'photo/1322816249/1322924922.jpg', '3', 5, 'zidian2', 0, 0, '2011-12-03 23:08:45'),
(24, 'comic', 'photo/1322816249/1322924950.jpg', '4\r\n', 5, 'zidian2', 0, 0, '2011-12-03 23:09:14'),
(25, 'comic', 'photo/1322816249/1322924972.jpg', '5', 5, 'zidian2', 2, 0, '2011-12-03 23:09:35'),
(26, 'comic', 'photo/1322816249/1322924987.jpg', '6', 5, 'zidian2', 2, 0, '2011-12-03 23:09:51'),
(27, 'comic', 'photo/1322816249/1322925001.jpg', '7', 5, 'zidian2', 2, 0, '2011-12-03 23:10:04'),
(28, 'comic', 'photo/1322816249/1322925015.jpg', '8', 5, 'zidian2', 2, 0, '2011-12-03 23:10:18'),
(29, 'comic', 'photo/1322816249/1322925030.jpg', '9', 5, 'zidian2', 7, 0, '2011-12-03 23:10:33'),
(30, 'comic', 'photo/1322816249/1322925051.jpg', '10', 5, 'zidian2', 16, 0, '2011-12-03 23:10:54'),
(41, 'china joy', 'photo/1322816249/1322988541.jpg', 'china joy', 5, 'zidian2', 2, 0, '2011-12-04 16:49:07'),
(43, 'comic', 'photo/1322816249/1323064665.jpg', 'comic', 5, 'goodluck', 1, 0, '2011-12-05 13:58:01'),
(44, 'comic', 'photo/1322816249/1323067372.jpg', 'comic', 5, 'zzhang1', 3, 0, '2011-12-05 14:42:59'),
(45, 'comic', 'photo/1322816249/1323068276.jpg', 'comic', 5, 'luckday', 12, 1, '2011-12-05 14:58:00');

-- --------------------------------------------------------

--
-- 表的结构 `tg_photo_comment`
--

CREATE TABLE IF NOT EXISTS `tg_photo_comment` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_title` varchar(20) NOT NULL COMMENT '//comment title',
  `tg_content` text NOT NULL COMMENT '//content',
  `tg_sid` mediumint(8) unsigned NOT NULL COMMENT '//picture ID',
  `tg_username` varchar(20) NOT NULL COMMENT '//reviewer',
  `tg_date` datetime NOT NULL COMMENT '//date',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `tg_photo_comment`
--

INSERT INTO `tg_photo_comment` (`tg_id`, `tg_title`, `tg_content`, `tg_sid`, `tg_username`, `tg_date`) VALUES
(1, 'RE:11', 'miao le ge mi', 0, 'zidian2', '2011-12-03 16:49:55'),
(2, 'RE:11', 'miao le ge mi', 4, 'zidian2', '2011-12-03 16:50:16'),
(3, 'RE:11', 'aa aa aa aa aa aa aa aa aa aa aa aa aa aa aa aa aa aa ', 4, 'zidian2', '2011-12-03 16:50:35'),
(4, 'RE:11', 'aa aa aa aa aa aa aa aa aa aa aa [img]qpic/3/12.gif[/img]', 4, 'zidian2', '2011-12-03 16:51:13'),
(5, 'RE:11', '[img]qpic/2/6.gif[/img][img]qpic/2/5.gif[/img][img]qpic/2/3.gif[/img]', 4, 'zidian2', '2011-12-03 16:53:14'),
(6, 'RE:11', '[img]qpic/1/14.gif[/img][img]qpic/1/8.gif[/img]', 4, 'zidian2', '2011-12-03 16:53:25'),
(7, 'RE:11', '[img]qpic/1/17.gif[/img][img]qpic/1/16.gif[/img][img]qpic/1/23.gif[/img]', 4, 'zidian2', '2011-12-03 16:53:36'),
(8, 'RE:11', 'wo lai kan kan ', 4, 'lulumao', '2011-12-03 17:29:52'),
(9, 'RE:zz', '[img]qpic/3/18.gif[/img][img]qpic/3/18.gif[/img][img]qpic/3/18.gif[/img]', 5, 'lulumao', '2011-12-03 17:33:11'),
(10, 'RE:from zhiming', 'i''m new i''m new i''m new i''m new i''m new i''m new i''m new i''m new [img]qpic/1/7.gif[/img][img]qpic/1/8.gif[/img][img]qpic/1/11.gif[/img]', 37, 'zhiming', '2011-12-04 15:33:22'),
(11, 'RE:china joy', 'pretty pretty pretty pretty pretty pretty ', 19, 'zhiming', '2011-12-04 16:39:04'),
(12, 'RE:china joy', '[img]qpic/1/17.gif[/img][img]qpic/1/8.gif[/img][img]qpic/1/4.gif[/img]', 19, 'zhiming', '2011-12-04 16:39:17'),
(13, 'RE:china joy', '[img]qpic/1/6.gif[/img][img]qpic/1/6.gif[/img][img]qpic/1/2.gif[/img]', 20, 'luckday', '2011-12-05 14:57:29'),
(14, 'RE:comic', 'kawayi kawayikawayikawayikawayikawayikawayikawayikawayikawayikawayikawayikawayi', 45, 'Icemm1', '2011-12-10 12:10:52');

-- --------------------------------------------------------

--
-- 表的结构 `tg_system`
--

CREATE TABLE IF NOT EXISTS `tg_system` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//ID',
  `tg_webname` varchar(20) NOT NULL COMMENT '//website name',
  `tg_article` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '//num of articles in each page',
  `tg_blog` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '//num of blogs in each page',
  `tg_photo` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '//num of albums in each page',
  `tg_skin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '//website skin',
  `tg_post` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '//post time restriction',
  `tg_re` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '//reply time restrcition',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `tg_system`
--

INSERT INTO `tg_system` (`tg_id`, `tg_webname`, `tg_article`, `tg_blog`, `tg_photo`, `tg_skin`, `tg_post`, `tg_re`) VALUES
(1, 'good luck', 8, 15, 8, 1, 60, 15);

-- --------------------------------------------------------

--
-- 表的结构 `tg_user`
--

CREATE TABLE IF NOT EXISTS `tg_user` (
  `tg_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '//user ID',
  `tg_uniqid` char(40) NOT NULL COMMENT '//unique identifier',
  `tg_active` char(40) NOT NULL COMMENT '//active identifier',
  `tg_username` varchar(20) NOT NULL COMMENT '//username',
  `tg_password` char(40) NOT NULL COMMENT '//password',
  `tg_question` varchar(20) NOT NULL COMMENT '//password question',
  `tg_answer` char(40) NOT NULL COMMENT '//password answer',
  `tg_email` varchar(40) DEFAULT NULL COMMENT '//email address',
  `tg_msn` varchar(40) DEFAULT NULL COMMENT '//msn',
  `tg_url` varchar(40) DEFAULT NULL COMMENT '//URL',
  `tg_sex` char(1) NOT NULL COMMENT '//Gender',
  `tg_profile` char(20) NOT NULL COMMENT '//profile',
  `tg_switch` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '//autographic switch',
  `tg_autograph` varchar(200) DEFAULT NULL COMMENT '//autographic content',
  `tg_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '//user level',
  `tg_post_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '//post date',
  `tg_article_time` varchar(20) NOT NULL DEFAULT '0' COMMENT '//reply date',
  `tg_reg_time` datetime NOT NULL COMMENT '//registration date',
  `tg_last_time` datetime NOT NULL COMMENT '//last login date',
  `tg_last_ip` varchar(20) NOT NULL COMMENT '//last login ip',
  `tg_login_count` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '//number of login',
  PRIMARY KEY (`tg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `tg_user`
--

INSERT INTO `tg_user` (`tg_id`, `tg_uniqid`, `tg_active`, `tg_username`, `tg_password`, `tg_question`, `tg_answer`, `tg_email`, `tg_msn`, `tg_url`, `tg_sex`, `tg_profile`, `tg_switch`, `tg_autograph`, `tg_level`, `tg_post_time`, `tg_article_time`, `tg_reg_time`, `tg_last_time`, `tg_last_ip`, `tg_login_count`) VALUES
(1, '43566f842c34ef64c5b806413e840e91feb1084d', '', 'zidian2', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'M', 'profile/profile1.jpg', 1, '[img]images/profile1.jpg[/img]', 0, '1323068074', '1323068097', '2011-11-28 21:09:00', '2011-12-10 22:04:56', '127.0.0.1', 55),
(2, 'e395fd1e0c1dc834da0f7b1dcb27a848ffb27e6f', '', 'zzhang1', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'M', 'profile/profile1.jpg', 0, '', 0, '1322669718', '1322669729', '2011-11-28 21:09:48', '2011-12-05 14:42:31', '127.0.0.1', 10),
(3, '1d687c903a0ec741aeaa9436042878bcaec77ecc', '', 'clathrun', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'F', 'profile/profile1.jpg', 1, 'wa ha ha...', 0, '0', '0', '2011-11-28 21:14:45', '2011-12-04 14:28:22', '127.0.0.1', 5),
(4, 'defdc7ff1d9f63d1bd101f13786c3f535293d6d0', '', 'st_ao', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'M', 'profile/profile3.jpg', 0, NULL, 0, '0', '0', '2011-11-28 21:15:48', '2011-12-10 22:05:18', '127.0.0.1', 8),
(5, '70f0d519b3d15da722c11351f883e5ec77d25fd6', '', 'lulumao', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'F', 'profile/profile8.jpg', 1, 'pretty cool!!!', 0, '0', '0', '2011-11-28 21:16:16', '2011-12-04 11:46:16', '127.0.0.1', 15),
(6, '806989b66399fe46e31a5625af7839d7cb72ff84', '', 'gmc', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', '', '', 'F', 'profile/profile5.jpg', 0, NULL, 1, '1323064513', '0', '2011-12-01 17:57:31', '2011-12-12 22:20:13', '127.0.0.1', 7),
(7, 'e5213da64e547b44371795987ef29dd9b34a706c', '', 'zhiming', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', '707463522@qq.com', 'clathrun@hotmail.com', '', 'M', 'profile/profile7.jpg', 1, 'to be or not to be', 0, '1322988258', '1322988271', '2011-12-04 15:23:30', '2011-12-10 22:10:27', '127.0.0.1', 11),
(10, '3065613e43d995b8a728b1ab1d871b8781b76a41', '', 'Icemm', 'ac4b844daa5093a25f0f4355613eff5a8b2ca6b7', '1234', '8cb2237d0679ca88db6464eac60da96345513964', 'asdfwef@gmail.com', 'adf@sdofj.com', '', 'M', 'profile/profile6.jpg', 0, '', 0, '0', '0', '2011-12-09 13:27:10', '2011-12-09 13:31:36', '127.0.0.1', 1),
(9, '3d2b8a438d2c4c964c40fdee6fd3143918f1a70b', '', 'luckday', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'athrun07091988@gmail.com', 'athrun_0709_1988@yahoo.com.cn', 'http://www.baidu.com', 'M', 'profile/profile1.jpg', 0, NULL, 0, '0', '0', '2011-12-05 14:51:41', '2011-12-05 15:17:59', '127.0.0.1', 3),
(11, 'b88a75c7069f01f4c4d0280a2d48b8633e73f606', '', 'Icemm1', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'sddsfsdfds', '27939c7ff0111bb70705a2781915ffd3d0d809c9', 'newmodify@yahoo.com.cn', 'newmodify@yahoo.com.cn', '', 'M', 'profile/profile7.jpg', 0, '', 1, '1323442454', '1323442865', '2011-12-09 17:58:38', '2011-12-10 22:05:55', '127.0.0.1', 9);

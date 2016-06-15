-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-12-23 23:43:27
-- 服务器版本： 5.6.21-log
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yijiansport`
--

-- --------------------------------------------------------

--
-- 表的结构 `cms_admin`
--

CREATE TABLE IF NOT EXISTS `cms_admin` (
`admin_id` int(11) NOT NULL,
  `role_id` tinyint(4) DEFAULT '0' COMMENT '权限组id',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0' COMMENT '最后登录ip',
  `admin_name` varchar(15) NOT NULL COMMENT '管理员登录账号',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员登录密码',
  `status` tinyint(1) DEFAULT '1' COMMENT '账号状态',
  `add_time` varchar(13) NOT NULL COMMENT '添加时间',
  `last_login_time` varchar(13) DEFAULT NULL COMMENT '最后登录时间',
  `login_times` int(11) DEFAULT '0' COMMENT '登录次数',
  `is_supper` tinyint(1) DEFAULT '0' COMMENT '是否超级管理员'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `cms_admin`
--

INSERT INTO `cms_admin` (`admin_id`, `role_id`, `last_login_ip`, `admin_name`, `admin_password`, `status`, `add_time`, `last_login_time`, `login_times`, `is_supper`) VALUES
(1, 12, '127.0.0.1', 'samsu', 'e10adc3949ba59abbe56e057f20f883e', 1, '', '1450875850', 44, 1),
(2, 23, '127.0.0.1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 1, '1449645500', '1449881345', 5, 0);

-- --------------------------------------------------------

--
-- 表的结构 `cms_admin_role`
--

CREATE TABLE IF NOT EXISTS `cms_admin_role` (
`role_id` tinyint(3) NOT NULL,
  `role_name` varchar(50) NOT NULL COMMENT '权限组名',
  `sort` tinyint(3) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用(0:是 1:否)'
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_admin_role`
--

INSERT INTO `cms_admin_role` (`role_id`, `role_name`, `sort`, `status`) VALUES
(12, '超级管理员', 1, 1),
(23, '管理员', 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cms_auth`
--

CREATE TABLE IF NOT EXISTS `cms_auth` (
  `role_id` tinyint(3) NOT NULL,
  `menu_id` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_auth`
--

INSERT INTO `cms_auth` (`role_id`, `menu_id`) VALUES
(12, 1),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(12, 6),
(23, 1),
(23, 2),
(23, 3),
(23, 4),
(23, 23),
(23, 24),
(23, 25),
(23, 27);

-- --------------------------------------------------------

--
-- 表的结构 `cms_menu`
--

CREATE TABLE IF NOT EXISTS `cms_menu` (
`menu_id` smallint(6) NOT NULL,
  `menu_name` varchar(50) NOT NULL COMMENT '菜单名称',
  `pid` smallint(6) NOT NULL COMMENT '父级id',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型 1:菜单 2:操作点',
  `module_name` varchar(20) NOT NULL COMMENT '模块名',
  `action_name` varchar(20) NOT NULL COMMENT '操作名',
  `class_name` varchar(20) DEFAULT NULL COMMENT '图标样式名',
  `data` varchar(120) NOT NULL COMMENT 'url参数',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `often` tinyint(1) NOT NULL DEFAULT '0',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 0::禁用 1:启用'
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_menu`
--

INSERT INTO `cms_menu` (`menu_id`, `menu_name`, `pid`, `type`, `module_name`, `action_name`, `class_name`, `data`, `remark`, `often`, `sort`, `status`) VALUES
(1, '系统', 0, 1, '', '', NULL, '', '', 0, 1, 1),
(2, '核心', 1, 1, '', '', 'ico-system-0', '', '', 0, 1, 1),
(3, '站点设置', 2, 1, 'System', 'site_setting', '', '', '', 0, 255, 1),
(4, '后台菜单', 2, 1, 'menu', 'index', NULL, '', '', 0, 255, 1),
(5, '角色管理', 2, 1, 'role', 'index', NULL, '', '', 0, 255, 1),
(6, '管理员', 2, 1, 'admin', 'index', NULL, '', '', 0, 255, 1),
(27, '添加', 4, 0, 'Menu', 'add', '', '', '', 0, 255, 1),
(28, '删除', 4, 0, 'Menu', 'del', '', '', '', 0, 255, 1),
(29, '修改', 4, 0, 'Menu', 'edit', NULL, '', '', 0, 255, 1),
(43, '内容', 0, 1, '', '', '', '', '', 0, 3, 1),
(44, '资讯', 43, 1, '', '', 'ico-cms-2', '', '', 0, 255, 1),
(45, '文章分类', 44, 1, 'NewsCategory', 'index', '', '', '', 0, 255, 1),
(46, '文章管理', 44, 1, 'News', 'index', '', '', '', 0, 255, 1);

-- --------------------------------------------------------

--
-- 表的结构 `cms_news`
--

CREATE TABLE IF NOT EXISTS `cms_news` (
`id` int(10) unsigned NOT NULL COMMENT '标识id',
  `cat_id` int(10) unsigned DEFAULT '0' COMMENT '所属栏目(分类)id，0为游离状态',
  `title` varchar(200) NOT NULL COMMENT '文章标题',
  `summary` varbinary(150) DEFAULT NULL COMMENT '简介',
  `contents` text NOT NULL COMMENT '文章内容',
  `sort` tinyint(6) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '状态 0:不显示 1:显示',
  `update_time` varchar(13) DEFAULT NULL COMMENT '最后修改时间',
  `source` varchar(20) DEFAULT '一建' COMMENT '来源',
  `view_times` int(11) DEFAULT '100' COMMENT '浏览量',
  `pic` text COMMENT '缩略图'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_news`
--

INSERT INTO `cms_news` (`id`, `cat_id`, `title`, `summary`, `contents`, `sort`, `status`, `update_time`, `source`, `view_times`, `pic`) VALUES
(5, 4, '玉锅宴牌蒸汽火锅设备即将在全国各地设立营销、体验、售后中心', '', 'rrr', 0, 1, '1450885018', '一建', 100, ''),
(6, 2, '捷能型分体式蒸汽主机（2200W）', '', 'ggg', 0, 1, '1450883732', '一建', 100, '');

-- --------------------------------------------------------

--
-- 表的结构 `cms_news_attachment`
--

CREATE TABLE IF NOT EXISTS `cms_news_attachment` (
`id` int(11) NOT NULL COMMENT '标志id',
  `nid` int(11) NOT NULL COMMENT '文章id',
  `path` text NOT NULL COMMENT '附件路径'
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cms_news_category`
--

CREATE TABLE IF NOT EXISTS `cms_news_category` (
`cat_id` int(10) unsigned NOT NULL COMMENT '栏目id',
  `cat_name` varchar(50) NOT NULL COMMENT '栏目名称',
  `sort` tinyint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `cms_news_category`
--

INSERT INTO `cms_news_category` (`cat_id`, `cat_name`, `sort`) VALUES
(1, '毽球人物', 1),
(2, '毽球知识', 2),
(3, '毽球快讯', 3),
(4, '协会介绍', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cms_admin`
--
ALTER TABLE `cms_admin`
 ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cms_admin_role`
--
ALTER TABLE `cms_admin_role`
 ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `cms_auth`
--
ALTER TABLE `cms_auth`
 ADD KEY `role_id` (`role_id`,`menu_id`);

--
-- Indexes for table `cms_menu`
--
ALTER TABLE `cms_menu`
 ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `cms_news`
--
ALTER TABLE `cms_news`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_news_attachment`
--
ALTER TABLE `cms_news_attachment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_news_category`
--
ALTER TABLE `cms_news_category`
 ADD PRIMARY KEY (`cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_admin`
--
ALTER TABLE `cms_admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_admin_role`
--
ALTER TABLE `cms_admin_role`
MODIFY `role_id` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cms_menu`
--
ALTER TABLE `cms_menu`
MODIFY `menu_id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `cms_news`
--
ALTER TABLE `cms_news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标识id',AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cms_news_attachment`
--
ALTER TABLE `cms_news_attachment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '标志id',AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `cms_news_category`
--
ALTER TABLE `cms_news_category`
MODIFY `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目id',AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

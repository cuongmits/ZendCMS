-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2014 at 11:30 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xxisolution`
--
CREATE DATABASE IF NOT EXISTS `xxisolution` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `xxisolution`;

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

CREATE TABLE IF NOT EXISTS `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

CREATE TABLE IF NOT EXISTS `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_author_email` varchar(255) NOT NULL,
  `comment_author_url` varchar(255) NOT NULL,
  `comment_author_IP` varchar(255) NOT NULL,
  `comment_date` varchar(255) NOT NULL,
  `comment_date_gmt` varchar(255) NOT NULL,
  `comment_content` varchar(255) NOT NULL,
  `comment_karma` bigint(20) NOT NULL,
  `comment_approved` varchar(255) NOT NULL,
  `comment_agent` varchar(255) NOT NULL,
  `comment_type` varchar(255) NOT NULL,
  `comment_parent` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

CREATE TABLE IF NOT EXISTS `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

CREATE TABLE IF NOT EXISTS `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1052 ;

--
-- Dumping data for table `wp_options`
--

INSERT INTO `wp_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://localhost/wordpress', 'yes'),
(2, 'blogname', 'My Blog', 'yes'),
(3, 'blogdescription', 'Just another WordPress site', 'yes'),
(4, 'users_can_register', '1', 'yes'),
(5, 'admin_email', 'cuongmits@gmail.com', 'yes'),
(44, 'template', 'default', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

CREATE TABLE IF NOT EXISTS `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=530 ;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(470, 467, '_edit_last', '1'),
(471, 467, '_edit_lock', '1398803417:1'),
(472, 467, '_wp_page_template', '0'),
(492, 500, '_edit_last', '1'),
(493, 500, '_edit_lock', '1398805929:1'),
(494, 502, '_edit_last', '1'),
(495, 502, '_edit_lock', '1398805934:1'),
(496, 505, '_edit_last', '1'),
(497, 505, '_edit_lock', '1398809808:1'),
(517, 545, '_wp_attached_file', '20140427/zend.png'),
(518, 545, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:336;s:6:"height";i:124;s:4:"file";s:17:"20140427/zend.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:10:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";}}'),
(523, 570, '_edit_last', '1'),
(524, 570, '_edit_lock', '1398803441:1'),
(525, 570, '_wp_page_template', '0'),
(528, 576, '_wp_attached_file', '20140429/info.png'),
(529, 576, '_wp_attachment_metadata', 'a:5:{s:5:"width";i:128;s:6:"height";i:128;s:4:"file";s:17:"20140429/info.png";s:5:"sizes";a:0:{}s:10:"image_meta";a:10:{s:8:"aperture";i:0;s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";i:0;s:9:"copyright";s:0:"";s:12:"focal_length";i:0;s:3:"iso";i:0;s:13:"shutter_speed";i:0;s:5:"title";s:0:"";}}');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

CREATE TABLE IF NOT EXISTS `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=577 ;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(467, 1, '2014-04-21 19:45:44', '2014-04-21 19:45:44', '<p>It&#39;s easy to get started creating your website. Knowing some of the basics will help.</p>\r\n\r\n<h2>What is a Content Management System?</h2>\r\n\r\n<p>A content management system is software that allows you to create and manage webpages easily by separating the creation of your content from the mechanics required to present it on the web.</p>\r\n\r\n<p>In this site, the content is stored in a database. The look and feel are created by a template. Joomla! brings together the template and your content to create web pages.</p>\r\n\r\n<h2>Logging in</h2>\r\n\r\n<p>To login to your site use the user name and password that were created as part of the installation process. Once logged-in you will be able to create and edit articles and modify some settings.</p>\r\n\r\n<h2>Creating an article</h2>\r\n\r\n<p>Once you are logged-in, a new menu will be visible. To create a new article, click on the &quot;Submit Article&quot; link on that menu.</p>\r\n\r\n<p>The new article interface gives you a lot of options, but all you need to do is add a title and put something in the content area. To make it easy to find, set the state to published.</p>\r\n\r\n<p>You can edit an existing article by clicking on the edit icon (this only displays to users who have the right to edit).</p>\r\n\r\n<h2>Template, site settings, and modules</h2>\r\n\r\n<p>The look and feel of your site is controlled by a template. You can change the site name, background colour, highlights colour and more by editing the template settings. Click the &quot;Template Settings&quot; in the user menu.&nbsp;</p>\r\n\r\n<p>The boxes around the main content of the site are called modules. &nbsp;You can modify modules on the current page by moving your cursor to the module and clicking the edit link. Always be sure to save and close any module you edit.</p>\r\n\r\n<p>You can change some site settings such as the site name and description by clicking on the &quot;Site Settings&quot; link.</p>\r\n\r\n<p>More advanced options for templates, site settings, modules, and more are available in the site administrator.</p>\r\n\r\n<h2>Site and Administrator</h2>\r\n\r\n<p>Your site actually has two separate sites. The site (also called the front end) is what visitors to your site will see. The administrator (also called the back end) is only used by people managing your site. You can access the administrator by clicking the &quot;Site Administrator&quot; link on the &quot;User Menu&quot; menu (visible once you login) or by adding /administrator to the end of your domain name. The same user name and password are used for both sites.</p>\r\n\r\n<h2>Learn more</h2>\r\n\r\n<p>There is much more to learn about how to use Joomla! to create the web site you envision. You can learn much more at the Joomla! documentation site and on the Joomla! forums.</p>\r\n', 'Getting Started', '', 'publish', 'open', 'open', '', 'page5-2', '', '', '2014-04-29 20:30:17', '2014-04-29 20:30:17', '', NULL, 'http://localhost/?page_id=467', 0, 'page', '', 0),
(468, 1, '2014-04-21 19:45:44', '2014-04-21 19:45:44', '', 'page5', '', 'inherit', 'open', 'open', '', '467-revision-v1', '', '', '2014-04-21 19:45:44', '2014-04-21 19:45:44', '', 467, 'http://localhost/467-revision-v1/', 0, 'revision', '', 0),
(477, 1, '2014-04-21 22:49:40', '2014-04-21 22:49:40', '', 'page55556', '', 'inherit', 'open', 'open', '', '467-revision-v2/', '', '', '2014-04-21 22:49:40', '2014-04-21 22:49:40', '', 467, 'http://localhost/467-revision-v2/', 0, 'revision', '', 0),
(478, 1, '2014-04-21 22:52:52', '2014-04-21 22:52:52', '', 'page555565', '', 'inherit', 'open', 'open', '', '467-revision-v3/', '', '', '2014-04-21 22:52:52', '2014-04-21 22:52:52', '', 467, 'http://localhost/467-revision-v3/', 0, 'revision', '', 0),
(479, 1, '2014-04-21 22:57:12', '2014-04-21 22:57:12', '', 'page555565', '', 'inherit', 'open', 'open', '', '467-revision-v4/', '', '', '2014-04-21 22:57:12', '2014-04-21 22:57:12', '', 467, 'http://localhost/467-revision-v4/', 0, 'revision', '', 0),
(480, 1, '2014-04-21 22:57:33', '2014-04-21 22:57:33', '', 'page555565', '', 'inherit', 'open', 'open', '', '467-revision-v5/', '', '', '2014-04-21 22:57:33', '2014-04-21 22:57:33', '', 467, 'http://localhost/467-revision-v5/', 0, 'revision', '', 0),
(489, 1, '2014-04-22 00:24:51', '2014-04-22 00:24:51', '', 'page555565', '', 'inherit', 'open', 'open', '', '467-revision-v6/', '', '', '2014-04-22 00:24:51', '2014-04-22 00:24:51', '', 467, 'http://localhost/467-revision-v6/', 0, 'revision', '', 0),
(500, 1, '2014-04-23 15:23:52', '2014-04-23 15:23:52', '<p>This is the first content of the first post. Enjoy it!</p>\r\n\r\n<p><img alt="" src="http://localhost/uploads/20140427/zend.png" style="float:left; height:124px; margin:5px; width:336px" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>\r\n\r\n<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>\r\n\r\n<p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>\r\n', 'This is the first post', '', 'publish', 'open', 'open', '', 'this-is-the-first-post', '', '', '2014-04-28 08:12:12', '2014-04-28 08:12:12', '', NULL, 'http://localhost/?p=500', 0, 'post', '', 0),
(501, 1, '2014-04-23 15:23:52', '2014-04-23 15:23:52', '', 'post1', '', 'inherit', 'open', 'open', '', '500-revision-v1/', '', '', '2014-04-23 15:23:52', '2014-04-23 15:23:52', '', 500, 'http://localhost/500-revision-v1/', 0, 'revision', '', 0),
(502, 1, '2014-04-23 15:24:03', '2014-04-23 15:24:03', '<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet</p>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<h2>Typi non habent claritatem insitam;</h2>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'publish', 'open', 'open', '', 'getting-started-with-zend-framework-2', '', '', '2014-04-28 06:43:29', '2014-04-28 06:43:29', '', NULL, 'http://localhost/?p=502', 0, 'post', '', 0),
(503, 1, '2014-04-23 15:24:03', '2014-04-23 15:24:03', '', 'post2', '', 'inherit', 'open', 'open', '', '502-revision-v1/', '', '', '2014-04-23 15:24:03', '2014-04-23 15:24:03', '', 502, 'http://localhost/502-revision-v1/', 0, 'revision', '', 0),
(504, 1, '2014-04-23 15:24:24', '2014-04-23 15:24:24', '', 'post2', '', 'inherit', 'open', 'open', '', '502-revision-v2/', '', '', '2014-04-23 15:24:24', '2014-04-23 15:24:24', '', 502, 'http://localhost/502-revision-v2/', 0, 'revision', '', 0),
(505, 1, '2014-04-23 19:12:33', '2014-04-23 19:12:33', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'publish', 'open', 'open', '', 'remember-by-christina-rossetti', '', '', '2014-04-29 19:49:18', '2014-04-29 19:49:18', '', NULL, 'http://localhost/?p=505', 0, 'post', '', 0),
(506, 1, '2014-04-23 19:12:33', '2014-04-23 19:12:33', '', 'abc', '', 'inherit', 'open', 'open', '', '505-revision-v1/', '', '', '2014-04-23 19:12:33', '2014-04-23 19:12:33', '', 505, 'http://localhost/505-revision-v1/', 0, 'revision', '', 0),
(507, 1, '2014-04-26 18:47:28', '2014-04-26 18:47:28', '', 'home', '', 'inherit', 'open', 'open', '', '467-revision-v7/', '', '', '2014-04-26 18:47:28', '2014-04-26 18:47:28', '', 467, 'http://localhost/467-revision-v7/', 0, 'revision', '', 0),
(508, 1, '2014-04-26 18:49:26', '2014-04-26 18:49:26', '<p>It&#39;s easy to get started creating your website. Knowing some of the basics will help.</p>\r\n\r\n<h2>What is a Content Management System?</h2>\r\n\r\n<p>A content management system is software that allows you to create and manage webpages easily by separating the creation of your content from the mechanics required to present it on the web.</p>\r\n\r\n<p>In this site, the content is stored in a database. The look and feel are created by a template. Joomla! brings together the template and your content to create web pages.</p>\r\n\r\n<h2>Logging in</h2>\r\n\r\n<p>To login to your site use the user name and password that were created as part of the installation process. Once logged-in you will be able to create and edit articles and modify some settings.</p>\r\n\r\n<h2>Creating an article</h2>\r\n\r\n<p>Once you are logged-in, a new menu will be visible. To create a new article, click on the &quot;Submit Article&quot; link on that menu.</p>\r\n\r\n<p>The new article interface gives you a lot of options, but all you need to do is add a title and put something in the content area. To make it easy to find, set the state to published.</p>\r\n\r\n<p>You can edit an existing article by clicking on the edit icon (this only displays to users who have the right to edit).</p>\r\n\r\n<h2>Template, site settings, and modules</h2>\r\n\r\n<p>The look and feel of your site is controlled by a template. You can change the site name, background colour, highlights colour and more by editing the template settings. Click the &quot;Template Settings&quot; in the user menu.&nbsp;</p>\r\n\r\n<p>The boxes around the main content of the site are called modules. &nbsp;You can modify modules on the current page by moving your cursor to the module and clicking the edit link. Always be sure to save and close any module you edit.</p>\r\n\r\n<p>You can change some site settings such as the site name and description by clicking on the &quot;Site Settings&quot; link.</p>\r\n\r\n<p>More advanced options for templates, site settings, modules, and more are available in the site administrator.</p>\r\n\r\n<h2>Site and Administrator</h2>\r\n\r\n<p>Your site actually has two separate sites. The site (also called the front end) is what visitors to your site will see. The administrator (also called the back end) is only used by people managing your site. You can access the administrator by clicking the &quot;Site Administrator&quot; link on the &quot;User Menu&quot; menu (visible once you login) or by adding /administrator to the end of your domain name. The same user name and password are used for both sites.</p>\r\n\r\n<h2>Learn more</h2>\r\n\r\n<p>There is much more to learn about how to use Joomla! to create the web site you envision. You can learn much more at the Joomla! documentation site and on the Joomla! forums.</p>\r\n', 'Getting Started', '', 'inherit', 'open', 'open', '', '467-revision-v8/', '', '', '2014-04-26 18:49:26', '2014-04-26 18:49:26', '', 467, 'http://localhost/467-revision-v8/', 0, 'revision', '', 0),
(509, 1, '2014-04-26 22:55:42', '2014-04-26 22:55:42', '', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v2/', '', '', '2014-04-26 22:55:42', '2014-04-26 22:55:42', '', 500, 'http://localhost/500-revision-v2/', 0, 'revision', '', 0),
(510, 1, '2014-04-26 22:55:57', '2014-04-26 22:55:57', '<p>This is the first content of the first post. Enjoy it!</p>\r\n', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v3/', '', '', '2014-04-26 22:55:57', '2014-04-26 22:55:57', '', 500, 'http://localhost/500-revision-v3/', 0, 'revision', '', 0),
(511, 1, '2014-04-26 22:57:34', '2014-04-26 22:57:34', '<p>This tutorial is intended to give an introduction to using Zend Framework 2 by creating a simple database driven application using the Model-View-Controller paradigm. By the end you will have a working ZF2 application and you can then poke around the code to find out more about how it all works and fits together.</p>\r\n\r\n<h2>Some assumptions<a href="http://framework.zend.com/manual/2.0/en/user-guide/overview.html#some-assumptions">&para;</a></h2>\r\n\r\n<p>This tutorial assumes that you are running PHP 5.3.3 with the Apache web server and MySQL, accessible via the PDO extension. Your Apache installation must have the mod_rewrite extension installed and configured.</p>\r\n\r\n<p>You must also ensure that Apache is configured to support&nbsp;<tt>.htaccess</tt>&nbsp;files. This is usually done by changing the setting:</p>\r\n\r\n<pre>\r\nAllowOverride <strong>None</strong>\r\n</pre>\r\n\r\n<p>to</p>\r\n\r\n<pre>\r\nAllowOverride FileInfo\r\n</pre>\r\n\r\n<p>in your&nbsp;<tt>httpd.conf</tt>&nbsp;file. Check with your distribution&rsquo;s documentation for exact details. You will not be able to navigate to any page other than the home page in this tutorial if you have not configured mod_rewrite and .htaccess usage correctly.</p>\r\n\r\n<p>for more information, please visit:&nbsp;http://framework.zend.com/manual/</p>\r\n', 'Getting Started with Zend Framework 2', '', 'inherit', 'open', 'open', '', '502-revision-v3/', '', '', '2014-04-26 22:57:34', '2014-04-26 22:57:34', '', 502, 'http://localhost/502-revision-v3/', 0, 'revision', '', 0),
(512, 1, '2014-04-26 22:57:51', '2014-04-26 22:57:51', '<p>This tutorial is intended to give an introduction to using Zend Framework 2 by creating a simple database driven application using the Model-View-Controller paradigm. By the end you will have a working ZF2 application and you can then poke around the code to find out more about how it all works and fits together.</p>\r\n\r\n<h2>Some assumptions<a href="http://framework.zend.com/manual/2.0/en/user-guide/overview.html#some-assumptions">&para;</a></h2>\r\n\r\n<p>This tutorial assumes that you are running PHP 5.3.3 with the Apache web server and MySQL, accessible via the PDO extension. Your Apache installation must have the mod_rewrite extension installed and configured.</p>\r\n\r\n<p>You must also ensure that Apache is configured to support&nbsp;<tt>.htaccess</tt>&nbsp;files. This is usually done by changing the setting:</p>\r\n\r\n<pre>\r\nAllowOverride <strong>None</strong>\r\n</pre>\r\n\r\n<p>to</p>\r\n\r\n<pre>\r\nAllowOverride FileInfo\r\n</pre>\r\n\r\n<p>in your&nbsp;<tt>httpd.conf</tt>&nbsp;file. Check with your distribution&rsquo;s documentation for exact details. You will not be able to navigate to any page other than the home page in this tutorial if you have not configured mod_rewrite and .htaccess usage correctly.</p>\r\n\r\n<p>for more information, please visit:&nbsp;http://framework.zend.com/manual/</p>\r\n', 'Getting Started with Zend Framework 2', '', 'inherit', 'open', 'open', '', '502-revision-v4/', '', '', '2014-04-26 22:57:51', '2014-04-26 22:57:51', '', 502, 'http://localhost/502-revision-v4/', 0, 'revision', '', 0),
(513, 1, '2014-04-26 22:58:12', '2014-04-26 22:58:12', '<p>This tutorial is intended to give an introduction to using Zend Framework 2 by creating a simple database driven application using the Model-View-Controller paradigm. By the end you will have a working ZF2 application and you can then poke around the code to find out more about how it all works and fits together.</p>\r\n\r\n<h2>Some assumptions<a href="http://framework.zend.com/manual/2.0/en/user-guide/overview.html#some-assumptions">&para;</a></h2>\r\n\r\n<p>This tutorial assumes that you are running PHP 5.3.3 with the Apache web server and MySQL, accessible via the PDO extension. Your Apache installation must have the mod_rewrite extension installed and configured.</p>\r\n\r\n<p>You must also ensure that Apache is configured to support&nbsp;<tt>.htaccess</tt>&nbsp;files. This is usually done by changing the setting:</p>\r\n\r\n<pre>\r\nAllowOverride <strong>None</strong>\r\n</pre>\r\n\r\n<p>to</p>\r\n\r\n<pre>\r\nAllowOverride FileInfo\r\n</pre>\r\n\r\n<p>in your&nbsp;<tt>httpd.conf</tt>&nbsp;file. Check with your distribution&rsquo;s documentation for exact details. You will not be able to navigate to any page other than the home page in this tutorial if you have not configured mod_rewrite and .htaccess usage correctly.</p>\r\n\r\n<p>for more information, please visit:&nbsp;http://framework.zend.com/manual/</p>\r\n', 'Getting Started with Zend Framework 2', '', 'inherit', 'open', 'open', '', '502-revision-v5/', '', '', '2014-04-26 22:58:12', '2014-04-26 22:58:12', '', 502, 'http://localhost/502-revision-v5/', 0, 'revision', '', 0),
(514, 1, '2014-04-26 22:58:21', '2014-04-26 22:58:21', '<p>This tutorial is intended to give an introduction to using Zend Framework 2 by creating a simple database driven application using the Model-View-Controller paradigm. By the end you will have a working ZF2 application and you can then poke around the code to find out more about how it all works and fits together.</p>\r\n\r\n<h2>Some assumptions</h2>\r\n\r\n<p>This tutorial assumes that you are running PHP 5.3.3 with the Apache web server and MySQL, accessible via the PDO extension. Your Apache installation must have the mod_rewrite extension installed and configured.</p>\r\n\r\n<p>You must also ensure that Apache is configured to support&nbsp;<tt>.htaccess</tt>&nbsp;files. This is usually done by changing the setting:</p>\r\n\r\n<pre>\r\nAllowOverride <strong>None</strong>\r\n</pre>\r\n\r\n<p>to</p>\r\n\r\n<pre>\r\nAllowOverride FileInfo\r\n</pre>\r\n\r\n<p>in your&nbsp;<tt>httpd.conf</tt>&nbsp;file. Check with your distribution&rsquo;s documentation for exact details. You will not be able to navigate to any page other than the home page in this tutorial if you have not configured mod_rewrite and .htaccess usage correctly.</p>\r\n\r\n<p>for more information, please visit:&nbsp;http://framework.zend.com/manual/</p>\r\n', 'Getting Started with Zend Framework 2', '', 'inherit', 'open', 'open', '', '502-revision-v6/', '', '', '2014-04-26 22:58:21', '2014-04-26 22:58:21', '', 502, 'http://localhost/502-revision-v6/', 0, 'revision', '', 0),
(515, 1, '2014-04-26 22:59:50', '2014-04-26 22:59:50', '<p>Remember me when I am gone away,</p>\r\n\r\n<p>Gone far away into the silent land;</p>\r\n\r\n<p>When you can no more hold me by the hand,</p>\r\n\r\n<p>Nor I half turn to go, yet turning stay.</p>\r\n\r\n<p>Remember me when no more day by day</p>\r\n\r\n<p>You tell me of our future that you plann&rsquo;d:</p>\r\n\r\n<p>Only remember me; you understand</p>\r\n\r\n<p>It will be late to counsel then or pray.</p>\r\n\r\n<p>Yet if you should forget me for a while</p>\r\n\r\n<p>And afterwards remember, do not grieve:</p>\r\n\r\n<p>For if the darkness and corruption leave</p>\r\n\r\n<p>A vestige of the thoughts that once I had,</p>\r\n\r\n<p>Better by far you should forget and smile</p>\r\n\r\n<p>Than that you should remember and be sad.</p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v2/', '', '', '2014-04-26 22:59:50', '2014-04-26 22:59:50', '', 505, 'http://localhost/505-revision-v2/', 0, 'revision', '', 0),
(532, 1, '2014-04-27 15:32:44', '2014-04-27 15:32:44', '<p>Remember me when I am gone away,</p>\r\n\r\n<p>Gone far away into the silent land;</p>\r\n\r\n<p>When you can no more hold me by the hand,</p>\r\n\r\n<p>Nor I half turn to go, yet turning stay.</p>\r\n\r\n<p>Remember me when no more day by day</p>\r\n\r\n<p>You tell me of our future that you plann&rsquo;d:</p>\r\n\r\n<p>Only remember me; you understand</p>\r\n\r\n<p>It will be late to counsel then or pray.</p>\r\n\r\n<p>Yet if you should forget me for a while</p>\r\n\r\n<p>And afterwards remember, do not grieve:</p>\r\n\r\n<p>For if the darkness and corruption leave</p>\r\n\r\n<p>A vestige of the thoughts that once I had,</p>\r\n\r\n<p>Better by far you should forget and smile</p>\r\n\r\n<p>Than that you should remember and be sad.</p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v3/', '', '', '2014-04-27 15:32:44', '2014-04-27 15:32:44', '', 505, 'http://localhost/505-revision-v3/', 0, 'revision', '', 0),
(533, 1, '2014-04-27 15:33:00', '2014-04-27 15:33:00', '<p>This is the first content of the first post. Enjoy it!</p>\r\n', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v4/', '', '', '2014-04-27 15:33:00', '2014-04-27 15:33:00', '', 500, 'http://localhost/500-revision-v4/', 0, 'revision', '', 0),
(534, 1, '2014-04-27 15:33:02', '2014-04-27 15:33:02', '<p>This tutorial is intended to give an introduction to using Zend Framework 2 by creating a simple database driven application using the Model-View-Controller paradigm. By the end you will have a working ZF2 application and you can then poke around the code to find out more about how it all works and fits together.</p>\r\n\r\n<h2>Some assumptions</h2>\r\n\r\n<p>This tutorial assumes that you are running PHP 5.3.3 with the Apache web server and MySQL, accessible via the PDO extension. Your Apache installation must have the mod_rewrite extension installed and configured.</p>\r\n\r\n<p>You must also ensure that Apache is configured to support&nbsp;<tt>.htaccess</tt>&nbsp;files. This is usually done by changing the setting:</p>\r\n\r\n<pre>\r\nAllowOverride <strong>None</strong>\r\n</pre>\r\n\r\n<p>to</p>\r\n\r\n<pre>\r\nAllowOverride FileInfo\r\n</pre>\r\n\r\n<p>in your&nbsp;<tt>httpd.conf</tt>&nbsp;file. Check with your distribution&rsquo;s documentation for exact details. You will not be able to navigate to any page other than the home page in this tutorial if you have not configured mod_rewrite and .htaccess usage correctly.</p>\r\n\r\n<p>for more information, please visit:&nbsp;http://framework.zend.com/manual/</p>\r\n', 'Getting Started with Zend Framework 2', '', 'inherit', 'open', 'open', '', '502-revision-v7/', '', '', '2014-04-27 15:33:02', '2014-04-27 15:33:02', '', 502, 'http://localhost/502-revision-v7/', 0, 'revision', '', 0),
(545, 1, '2014-04-27 18:29:00', '2014-04-27 18:29:00', '', 'zend', '', 'inherit', 'open', 'open', '', 'zend', '', '', '2014-04-27 18:29:00', '2014-04-27 18:29:00', '', NULL, 'http://localhost/uploads/20140427/zend.png', 0, 'attachment', 'image/png', 0),
(546, 1, '2014-04-28 06:25:50', '2014-04-28 06:25:50', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v4/', '', '', '2014-04-28 06:25:50', '2014-04-28 06:25:50', '', 505, 'http://localhost/505-revision-v4/', 0, 'revision', '', 0),
(547, 1, '2014-04-28 06:26:10', '2014-04-28 06:26:10', '<p>This is the first content of the first post. Enjoy it!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>\r\n', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v5/', '', '', '2014-04-28 06:26:10', '2014-04-28 06:26:10', '', 500, 'http://localhost/500-revision-v5/', 0, 'revision', '', 0),
(548, 1, '2014-04-28 06:39:05', '2014-04-28 06:39:05', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v5/', '', '', '2014-04-28 06:39:05', '2014-04-28 06:39:05', '', 505, 'http://localhost/505-revision-v5/', 0, 'revision', '', 0),
(549, 1, '2014-04-28 06:41:53', '2014-04-28 06:41:53', '<h1>Lorem ipsum dolor sit amet</h1>\r\n\r\n<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>\r\n\r\n<p>Typi non habent claritatem insitam;</p>\r\n\r\n<div style="background:#eee;border:1px solid #ccc;padding:5px 10px;">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<pre>\r\nEodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. </pre>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'inherit', 'open', 'open', '', '502-revision-v8/', '', '', '2014-04-28 06:41:53', '2014-04-28 06:41:53', '', 502, 'http://localhost/502-revision-v8/', 0, 'revision', '', 0),
(550, 1, '2014-04-28 06:42:23', '2014-04-28 06:42:23', '<h1>Lorem ipsum dolor sit amet</h1>\r\n\r\n<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>\r\n\r\n<p>Typi non habent claritatem insitam;</p>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'inherit', 'open', 'open', '', '502-revision-v9/', '', '', '2014-04-28 06:42:23', '2014-04-28 06:42:23', '', 502, 'http://localhost/502-revision-v9/', 0, 'revision', '', 0),
(551, 1, '2014-04-28 06:43:00', '2014-04-28 06:43:00', '<h1><span style="font-size:13px; line-height:1.6em">Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</span></h1>\r\n\r\n<h2>Lorem ipsum dolor sit amet</h2>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<h2>Typi non habent claritatem insitam;</h2>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'inherit', 'open', 'open', '', '502-revision-v10/', '', '', '2014-04-28 06:43:00', '2014-04-28 06:43:00', '', 502, 'http://localhost/502-revision-v10/', 0, 'revision', '', 0),
(552, 1, '2014-04-28 06:43:13', '2014-04-28 06:43:13', '<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>\r\n\r\n<h2>Lorem ipsum dolor sit amet</h2>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<h2>Typi non habent claritatem insitam;</h2>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'inherit', 'open', 'open', '', '502-revision-v11/', '', '', '2014-04-28 06:43:13', '2014-04-28 06:43:13', '', 502, 'http://localhost/502-revision-v11/', 0, 'revision', '', 0),
(553, 1, '2014-04-28 06:43:29', '2014-04-28 06:43:29', '<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet</p>\r\n\r\n<div style="background:#eee; border:1px solid #ccc; padding:5px 10px">est usus legentis in iis qui facit eorum claritatem.</div>\r\n\r\n<h2>Typi non habent claritatem insitam;</h2>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula <span class="marker">quarta decima et quinta</span> decima.</p>\r\n\r\n<p>Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n\r\n<p>Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima.&nbsp;</p>\r\n', 'Lorem ipsum dolor sit amet', '', 'inherit', 'open', 'open', '', '502-revision-v12/', '', '', '2014-04-28 06:43:29', '2014-04-28 06:43:29', '', 502, 'http://localhost/502-revision-v12/', 0, 'revision', '', 0),
(554, 1, '2014-04-28 06:44:43', '2014-04-28 06:44:43', '<p>This is the first content of the first post. Enjoy it!</p>\r\n\r\n<p><img alt="" src="http://localhost/uploads/20140427/zend.png" style="float:left; height:124px; margin:5px; width:336px" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>\r\n\r\n<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>\r\n\r\n<p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>\r\n', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v6/', '', '', '2014-04-28 06:44:43', '2014-04-28 06:44:43', '', 500, 'http://localhost/500-revision-v6/', 0, 'revision', '', 0),
(555, 1, '2014-04-28 06:52:59', '2014-04-28 06:52:59', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v6/', '', '', '2014-04-28 06:52:59', '2014-04-28 06:52:59', '', 505, 'http://localhost/505-revision-v6/', 0, 'revision', '', 0),
(556, 1, '2014-04-28 06:56:40', '2014-04-28 06:56:40', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v7/', '', '', '2014-04-28 06:56:40', '2014-04-28 06:56:40', '', 505, 'http://localhost/505-revision-v7/', 0, 'revision', '', 0),
(557, 1, '2014-04-28 08:00:46', '2014-04-28 08:00:46', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v8/', '', '', '2014-04-28 08:00:46', '2014-04-28 08:00:46', '', 505, 'http://localhost/505-revision-v8/', 0, 'revision', '', 0),
(558, 1, '2014-04-28 08:12:12', '2014-04-28 08:12:12', '<p>This is the first content of the first post. Enjoy it!</p>\r\n\r\n<p><img alt="" src="http://localhost/uploads/20140427/zend.png" style="float:left; height:124px; margin:5px; width:336px" />Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>\r\n\r\n<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.</p>\r\n\r\n<p>Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>\r\n', 'This is the first post', '', 'inherit', 'open', 'open', '', '500-revision-v7/', '', '', '2014-04-28 08:12:12', '2014-04-28 08:12:12', '', 500, 'http://localhost/500-revision-v7/', 0, 'revision', '', 0),
(562, 1, '2014-04-29 19:34:20', '2014-04-29 19:34:20', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v9/', '', '', '2014-04-29 19:34:20', '2014-04-29 19:34:20', '', 505, 'http://localhost/505-revision-v9/', 0, 'revision', '', 0),
(563, 1, '2014-04-29 19:46:08', '2014-04-29 19:46:08', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v10/', '', '', '2014-04-29 19:46:08', '2014-04-29 19:46:08', '', 505, 'http://localhost/505-revision-v10/', 0, 'revision', '', 0);
INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(564, 1, '2014-04-29 19:46:15', '2014-04-29 19:46:15', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v11/', '', '', '2014-04-29 19:46:15', '2014-04-29 19:46:15', '', 505, 'http://localhost/505-revision-v11/', 0, 'revision', '', 0),
(565, 1, '2014-04-29 19:49:18', '2014-04-29 19:49:18', '<p><em>Remember me when I am gone away,</em></p>\r\n\r\n<p><em>Gone far away into the silent land;</em></p>\r\n\r\n<p><em>When you can no more hold me by the hand,</em></p>\r\n\r\n<p><em>Nor I half turn to go, yet turning stay.</em></p>\r\n\r\n<p><em>Remember me when no more day by day</em></p>\r\n\r\n<p><em>You tell me of our future that you plann&rsquo;d:</em></p>\r\n\r\n<p><em>Only remember me; you understand</em></p>\r\n\r\n<p><em>It will be late to counsel then or pray.</em></p>\r\n\r\n<p><em>Yet if you should forget me for a while</em></p>\r\n\r\n<p><em>And afterwards remember, do not grieve:</em></p>\r\n\r\n<p><em>For if the darkness and corruption leave</em></p>\r\n\r\n<p><em>A vestige of the thoughts that once I had,</em></p>\r\n\r\n<p><em>Better by far you should forget and smile</em></p>\r\n\r\n<p><em>Than that you should remember and be sad.</em></p>\r\n', 'Remember by Christina Rossetti', '', 'inherit', 'open', 'open', '', '505-revision-v12/', '', '', '2014-04-29 19:49:18', '2014-04-29 19:49:18', '', 505, 'http://localhost/505-revision-v12/', 0, 'revision', '', 0),
(569, 1, '2014-04-29 20:29:09', '2014-04-29 20:29:09', '<p>It&#39;s easy to get started creating your website. Knowing some of the basics will help.</p>\r\n\r\n<h2>What is a Content Management System?</h2>\r\n\r\n<p>A content management system is software that allows you to create and manage webpages easily by separating the creation of your content from the mechanics required to present it on the web.</p>\r\n\r\n<p>In this site, the content is stored in a database. The look and feel are created by a template. Joomla! brings together the template and your content to create web pages.</p>\r\n\r\n<h2>Logging in</h2>\r\n\r\n<p>To login to your site use the user name and password that were created as part of the installation process. Once logged-in you will be able to create and edit articles and modify some settings.</p>\r\n\r\n<h2>Creating an article</h2>\r\n\r\n<p>Once you are logged-in, a new menu will be visible. To create a new article, click on the &quot;Submit Article&quot; link on that menu.</p>\r\n\r\n<p>The new article interface gives you a lot of options, but all you need to do is add a title and put something in the content area. To make it easy to find, set the state to published.</p>\r\n\r\n<p>You can edit an existing article by clicking on the edit icon (this only displays to users who have the right to edit).</p>\r\n\r\n<h2>Template, site settings, and modules</h2>\r\n\r\n<p>The look and feel of your site is controlled by a template. You can change the site name, background colour, highlights colour and more by editing the template settings. Click the &quot;Template Settings&quot; in the user menu.&nbsp;</p>\r\n\r\n<p>The boxes around the main content of the site are called modules. &nbsp;You can modify modules on the current page by moving your cursor to the module and clicking the edit link. Always be sure to save and close any module you edit.</p>\r\n\r\n<p>You can change some site settings such as the site name and description by clicking on the &quot;Site Settings&quot; link.</p>\r\n\r\n<p>More advanced options for templates, site settings, modules, and more are available in the site administrator.</p>\r\n\r\n<h2>Site and Administrator</h2>\r\n\r\n<p>Your site actually has two separate sites. The site (also called the front end) is what visitors to your site will see. The administrator (also called the back end) is only used by people managing your site. You can access the administrator by clicking the &quot;Site Administrator&quot; link on the &quot;User Menu&quot; menu (visible once you login) or by adding /administrator to the end of your domain name. The same user name and password are used for both sites.</p>\r\n\r\n<h2>Learn more</h2>\r\n\r\n<p>There is much more to learn about how to use Joomla! to create the web site you envision. You can learn much more at the Joomla! documentation site and on the Joomla! forums.</p>\r\n', 'Getting Started admin', '', 'inherit', 'open', 'open', '', '467-revision-v9/', '', '', '2014-04-29 20:29:09', '2014-04-29 20:29:09', '', 467, 'http://localhost/467-revision-v9/', 0, 'revision', '', 0),
(570, 1, '2014-04-29 20:30:09', '2014-04-29 20:30:09', '', 'admin editor', '', 'publish', 'open', 'open', '', 'admin-2', '', '', '2014-04-29 20:30:41', '2014-04-29 20:30:41', '', NULL, 'http://localhost/?page_id=570', 0, 'page', '', 0),
(571, 1, '2014-04-29 20:30:09', '2014-04-29 20:30:09', '', 'admin', '', 'inherit', 'open', 'open', '', '570-revision-v1', '', '', '2014-04-29 20:30:09', '2014-04-29 20:30:09', '', 570, 'http://localhost/570-revision-v1/', 0, 'revision', '', 0),
(572, 1, '2014-04-29 20:30:17', '2014-04-29 20:30:17', '<p>It&#39;s easy to get started creating your website. Knowing some of the basics will help.</p>\r\n\r\n<h2>What is a Content Management System?</h2>\r\n\r\n<p>A content management system is software that allows you to create and manage webpages easily by separating the creation of your content from the mechanics required to present it on the web.</p>\r\n\r\n<p>In this site, the content is stored in a database. The look and feel are created by a template. Joomla! brings together the template and your content to create web pages.</p>\r\n\r\n<h2>Logging in</h2>\r\n\r\n<p>To login to your site use the user name and password that were created as part of the installation process. Once logged-in you will be able to create and edit articles and modify some settings.</p>\r\n\r\n<h2>Creating an article</h2>\r\n\r\n<p>Once you are logged-in, a new menu will be visible. To create a new article, click on the &quot;Submit Article&quot; link on that menu.</p>\r\n\r\n<p>The new article interface gives you a lot of options, but all you need to do is add a title and put something in the content area. To make it easy to find, set the state to published.</p>\r\n\r\n<p>You can edit an existing article by clicking on the edit icon (this only displays to users who have the right to edit).</p>\r\n\r\n<h2>Template, site settings, and modules</h2>\r\n\r\n<p>The look and feel of your site is controlled by a template. You can change the site name, background colour, highlights colour and more by editing the template settings. Click the &quot;Template Settings&quot; in the user menu.&nbsp;</p>\r\n\r\n<p>The boxes around the main content of the site are called modules. &nbsp;You can modify modules on the current page by moving your cursor to the module and clicking the edit link. Always be sure to save and close any module you edit.</p>\r\n\r\n<p>You can change some site settings such as the site name and description by clicking on the &quot;Site Settings&quot; link.</p>\r\n\r\n<p>More advanced options for templates, site settings, modules, and more are available in the site administrator.</p>\r\n\r\n<h2>Site and Administrator</h2>\r\n\r\n<p>Your site actually has two separate sites. The site (also called the front end) is what visitors to your site will see. The administrator (also called the back end) is only used by people managing your site. You can access the administrator by clicking the &quot;Site Administrator&quot; link on the &quot;User Menu&quot; menu (visible once you login) or by adding /administrator to the end of your domain name. The same user name and password are used for both sites.</p>\r\n\r\n<h2>Learn more</h2>\r\n\r\n<p>There is much more to learn about how to use Joomla! to create the web site you envision. You can learn much more at the Joomla! documentation site and on the Joomla! forums.</p>\r\n', 'Getting Started', '', 'inherit', 'open', 'open', '', '467-revision-v10/', '', '', '2014-04-29 20:30:17', '2014-04-29 20:30:17', '', 467, 'http://localhost/467-revision-v10/', 0, 'revision', '', 0),
(573, 7, '2014-04-29 20:30:41', '2014-04-29 20:30:41', '', 'admin editor', '', 'inherit', 'open', 'open', '', '570-revision-v2/', '', '', '2014-04-29 20:30:41', '2014-04-29 20:30:41', '', 570, 'http://localhost/570-revision-v2/', 0, 'revision', '', 0),
(576, 1, '2014-04-29 21:13:29', '2014-04-29 21:13:29', '', 'info', '', 'inherit', 'open', 'open', '', 'info', '', '', '2014-04-29 21:13:29', '2014-04-29 21:13:29', '', NULL, 'http://localhost/uploads/20140429/info.png', 0, 'attachment', 'image/png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

CREATE TABLE IF NOT EXISTS `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=106 ;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(85, 'Zend Framework 2', 'zend-framework-2', 0),
(93, 'ZF2 Blog Module', 'zf2-blog-module', 0),
(97, 'zend', 'zend', 0),
(101, 'relax', 'relax', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(500, 82, 0),
(502, 82, 0),
(502, 90, 0),
(502, 94, 0),
(505, 94, 0),
(505, 98, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

CREATE TABLE IF NOT EXISTS `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(82, 85, 'category', 'posts about ZF2', 0, 2),
(90, 93, 'category', 'introduction about this module', 85, 1),
(94, 97, 'post_tag', '', 0, 2),
(98, 101, 'post_tag', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

CREATE TABLE IF NOT EXISTS `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(10, 1, 'wp_capabilities', 'administrator'),
(34, 7, 'wp_capabilities', 'contributor');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$BHRrJzst2Kp01dRN2cnYAIq6BGCeA9.', 'cuongmits', 'cuongmits@gmail.com', '', '2014-02-08 09:09:17', '', 0, 'KeoN'),
(7, 'abc', '$P$BgqwClBd0q./bVyQFgwCMqb4qB5VnK/', 'ABC', 'abc@gmail.com', '', '2014-04-29 19:59:55', '', 0, 'ABC');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wp_commentmeta`
--
ALTER TABLE `wp_commentmeta`
  ADD CONSTRAINT `commentmeta_comments` FOREIGN KEY (`comment_id`) REFERENCES `wp_comments` (`comment_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_comments`
--
ALTER TABLE `wp_comments`
  ADD CONSTRAINT `comments_posts` FOREIGN KEY (`comment_post_ID`) REFERENCES `wp_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_postmeta`
--
ALTER TABLE `wp_postmeta`
  ADD CONSTRAINT `postmeta_posts` FOREIGN KEY (`post_id`) REFERENCES `wp_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_posts`
--
ALTER TABLE `wp_posts`
  ADD CONSTRAINT `posts_posts` FOREIGN KEY (`post_parent`) REFERENCES `wp_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_users` FOREIGN KEY (`post_author`) REFERENCES `wp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_term_relationships`
--
ALTER TABLE `wp_term_relationships`
  ADD CONSTRAINT `term_relationships_posts` FOREIGN KEY (`object_id`) REFERENCES `wp_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `term_relationships_term_taxonomy` FOREIGN KEY (`term_taxonomy_id`) REFERENCES `wp_term_taxonomy` (`term_taxonomy_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_term_taxonomy`
--
ALTER TABLE `wp_term_taxonomy`
  ADD CONSTRAINT `term_taxonomy_terms` FOREIGN KEY (`term_id`) REFERENCES `wp_terms` (`term_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wp_usermeta`
--
ALTER TABLE `wp_usermeta`
  ADD CONSTRAINT `usermeta_users` FOREIGN KEY (`user_id`) REFERENCES `wp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

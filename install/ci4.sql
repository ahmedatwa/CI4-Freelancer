-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 06, 2020 at 03:17 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci4`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_banner`
--

CREATE TABLE `ci_banner` (
  `banner_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_banner`
--

INSERT INTO `ci_banner` (`banner_id`, `name`, `status`) VALUES
(7, 'Home Page Slideshow', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_banner_image`
--

CREATE TABLE `ci_banner_image` (
  `banner_image_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_banner_image`
--

INSERT INTO `ci_banner_image` (`banner_image_id`, `banner_id`, `language_id`, `title`, `link`, `image`, `sort_order`) VALUES
(140, 7, 2, 'MacBookAir', '', 'catalog/demo/banners/MacBookAir.jpg', 0),
(141, 7, 2, 'iPhone 6', 'index.php?route=product/product&path=57&product_id=49', 'catalog/demo/banners/iPhone6.jpg', 0),
(138, 7, 1, 'test', '#', 'catalog/demo/banners/MacBookAir.jpg', 2),
(139, 7, 1, 'iPhone 6', 'index.php?route=product/product&path=57&product_id=49', 'catalog/demo/banners/iPhone6.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ci_bids`
--

CREATE TABLE `ci_bids` (
  `bid_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `quote` text DEFAULT NULL,
  `text` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_category`
--

CREATE TABLE `ci_blog_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post`
--

CREATE TABLE `ci_blog_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `tags` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_blog_post`
--

INSERT INTO `ci_blog_post` (`post_id`, `user_id`, `category_id`, `title`, `slug`, `body`, `tags`, `image`, `status`, `date_added`, `date_modified`) VALUES
(1, 0, 0, 'test title', 'test-title', '<p>test title<br></p>', '', '', 1, '2020-09-05 21:30:38', '2020-09-05 21:30:38');

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post_to_commet`
--

CREATE TABLE `ci_blog_post_to_commet` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_category`
--

CREATE TABLE `ci_category` (
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `top` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category`
--

INSERT INTO `ci_category` (`category_id`, `image`, `parent_id`, `top`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, '', 0, 0, 0, 1, '2020-08-14 12:35:56', '2020-08-28 08:51:31'),
(2, '', 0, 0, 0, 1, '2020-08-14 12:35:56', '2020-08-24 20:56:47'),
(3, '', 0, 0, 0, 1, '2020-08-14 12:35:56', '2020-08-28 08:51:23'),
(7, '', 3, 0, 1, 1, '2020-08-25 07:18:01', '2020-08-25 07:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `ci_category_description`
--

CREATE TABLE `ci_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category_description`
--

INSERT INTO `ci_category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'Mobile Devs', '<p>Mobile Dev<br></p>', 'Mobile Dev', '', ''),
(1, 2, 'Mobile Devs', '<p>Mobile Dev<br></p>', 'Mobile Dev', '', ''),
(2, 1, 'internet', '<p>internet<br></p>', 'Mobile Dev', '', ''),
(2, 2, 'internet', '<p>internet<br></p>', 'internet', '', ''),
(3, 1, 'Websites, IT & Software', '<p><span style=\"color: rgb(14, 23, 36); font-family: Roboto, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 1.25rem; caret-color: rgb(14, 23, 36);\">Websites, IT & Software</span><br></p>', 'Websites, IT & Software', 'Websites, IT & Software', ''),
(3, 2, 'Websites, IT & Software', '<h3 class=\"PageJob-category-title\" style=\"margin-bottom: 0px; font-size: 1.25rem; line-height: 1.4; caret-color: rgb(14, 23, 36); color: rgb(14, 23, 36); font-family: Roboto, \"Helvetica Neue\", Helvetica, Arial, sans-serif; text-size-adjust: auto;\">Websites, IT & Software</h3>', 'Websites, IT & Software', 'Websites, IT & Software', ''),
(7, 1, 'CMS', '<p>CMS<br></p>', 'CMS', 'CMS', 'CMS'),
(7, 2, 'CMS', '<p>CMS<br></p>', 'CMS', 'CMS', 'CMS,test');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer`
--

CREATE TABLE `ci_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `address_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `email`, `telephone`, `password`, `newsletter`, `address_id`, `ip`, `status`, `code`, `date_added`, `date_modified`) VALUES
(1, 1, 'test', 'test', 'test@test.com', '444444444', '85af1c005127b696e7bd7933650bc23399df02b9', 0, 0, '::1', 1, '', '2020-08-07 15:40:08', '0000-00-00 00:00:00'),
(2, 1, 'new', 'new', 'new@new.com', '677887777', 'ca58df7b591ddac665582a105378d9982f4b5b0e', 0, 0, '::1', 1, '', '2020-08-07 17:05:30', '0000-00-00 00:00:00'),
(4, 2, 'customer', 'custmer', 'rehab.gasssssrhy@yahoo.com', '', '$2y$10$8awByKl0DD7f95.1G58FO./AmZpQTeDTn', 1, 0, '', 0, '', '2020-08-25 11:00:15', '2020-08-27 13:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_activity`
--

CREATE TABLE `ci_customer_activity` (
  `customer_activity_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_activity`
--

INSERT INTO `ci_customer_activity` (`customer_activity_id`, `freelancer_id`, `key`, `data`, `ip`, `date_added`) VALUES
(1, 2, 'register', '{\"customer_id\":2,\"name\":\"new new\"}', '::1', '2020-08-07 17:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_group`
--

CREATE TABLE `ci_customer_group` (
  `customer_group_id` int(11) NOT NULL,
  `approval` int(1) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_group`
--

INSERT INTO `ci_customer_group` (`customer_group_id`, `approval`, `sort_order`) VALUES
(1, 0, 1),
(2, 1, 2),
(3, 0, 0),
(4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_group_description`
--

CREATE TABLE `ci_customer_group_description` (
  `customer_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_group_description`
--

INSERT INTO `ci_customer_group_description` (`customer_group_id`, `language_id`, `name`, `description`) VALUES
(1, 1, 'Freelancer', 'Freelancer'),
(2, 1, 'Employer', 'Employer');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_history`
--

CREATE TABLE `ci_customer_history` (
  `customer_history_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_login`
--

CREATE TABLE `ci_customer_login` (
  `customer_login_id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_online`
--

CREATE TABLE `ci_customer_online` (
  `ip` varchar(40) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_online`
--

INSERT INTO `ci_customer_online` (`ip`, `customer_id`, `url`, `referer`, `date_added`) VALUES
('::1', 0, 'http://ci4.localhost/project/category', 'http://ci4.localhost/project/category', '2020-08-28 13:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_review`
--

CREATE TABLE `ci_customer_review` (
  `review_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `recommended` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_review`
--

INSERT INTO `ci_customer_review` (`review_id`, `project_id`, `freelancer_id`, `employer_id`, `order_id`, `recommended`, `comment`, `rating`, `status`, `date_added`, `date_modified`) VALUES
(1, 7, 1, 1, 1, 5, 'model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 2, 1, '2019-09-19 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, 1, 2, 5, 'model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 3, 1, '2019-09-19 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_event`
--

CREATE TABLE `ci_event` (
  `event_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `action` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int(3) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_event`
--

INSERT INTO `ci_event` (`event_id`, `code`, `action`, `description`, `status`, `priority`) VALUES
(1, 'activity_user_login', 'Admin\\Controllers\\Events\\Activity::login', 'Record User Login Activity', 1, 0),
(2, 'login_attempts', 'Admin\\Controllers\\Events\\Activity::loginAttempts', 'Record Login Attempts to Admin Area', 1, 0),
(3, 'mail_forgotten', 'Admin\\Controllers\\Events\\Activity::mailForgotten', 'Trigger an Email for password reset', 1, 0),
(6, 'user_activity_add', 'Admin\\Controllers\\Events\\Activity::afterInsert', 'Log Activity After Insert to DB', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_extension`
--

CREATE TABLE `ci_extension` (
  `extension_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_extension`
--

INSERT INTO `ci_extension` (`extension_id`, `type`, `code`) VALUES
(42, 'theme', 'default_theme'),
(94, 'dashboard', 'online'),
(22, 'dashboard', 'activity'),
(92, 'module', 'carousel'),
(63, 'bid', 'bid'),
(95, 'module', 'account'),
(73, 'job', 'job'),
(101, 'blog', 'category'),
(96, 'module', 'category'),
(100, 'blog', 'post');

-- --------------------------------------------------------

--
-- Table structure for table `ci_information`
--

CREATE TABLE `ci_information` (
  `information_id` int(11) NOT NULL,
  `bottom` int(1) NOT NULL DEFAULT 0,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_information`
--

INSERT INTO `ci_information` (`information_id`, `bottom`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 1, '0000-00-00 00:00:00', '2020-08-25 13:25:04'),
(2, 1, 3, 1, '0000-00-00 00:00:00', '2020-08-25 10:46:24'),
(3, 1, 1, 1, '0000-00-00 00:00:00', '2020-08-25 13:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `ci_information_description`
--

CREATE TABLE `ci_information_description` (
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_information_description`
--

INSERT INTO `ci_information_description` (`information_id`, `language_id`, `title`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 2, 'دولار', '\"لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور\r\n\r\nأنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد\r\n\r\nأكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس\r\n\r\nأيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت\r\n\r\nنيولا باراياتيور. أيكسسيبتيور ساينت أوككايكات كيوبايداتات نون بروايدينت ,سيونت ان كيولبا\r\n\r\nكيو أوفيسيا ديسيريونتموليت انيم أيدي ايست لابوريوم.\"\r\n\r\n\"سيت يتبيرسبايكياتيس يوندي أومنيس أستي ناتيس أيررور سيت فوليبتاتيم أكيسأنتييوم\r\n\r\nدولاريمكيو لايودانتيوم,توتام ريم أبيرأم,أيكيو أبسا كيواي أب أللو أنفينتوري فيرأتاتيس ايت\r\n\r\nكياسي أرشيتيكتو بيتاي فيتاي ديكاتا سيونت أكسبليكابو. نيمو أنيم أبسام فوليوباتاتيم كيواي\r\n\r\nفوليوبتاس سايت أسبيرناتشر أيوت أودايت أيوت فيوجايت, سيد كيواي كونسيكيونتشر ماجناي', 'كونسيكتيتور', '', ''),
(1, 1, 'Terms & Conditions', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span></p>', 'Terms & Conditions', '', ''),
(3, 1, 'Privacy Policy', '<p>\r\n	Privacy Policy</p>\r\n', 'Privacy Policy', '', ''),
(4, 2, 'Delivery Information', '<p>Delivery Information<br></p>', 'Delivery Information', '', ''),
(3, 2, 'Privacy Policy', '<p>Privacy Policy<br></p>', 'Privacy Policy', '', ''),
(4, 1, 'Delivery Information', '<p>\r\n	Delivery Information</p>\r\n', 'Delivery Information', '', ''),
(2, 2, 'About Us', '<p>About Us<br></p>', 'About Us', '', ''),
(2, 1, 'About Us', '<p>About Us<br></p>', 'About Us', '', ''),
(5, 1, 'new info page', '<p>new info page<br></p>', 'new info page', '', ''),
(5, 2, 'new info page', '<p>new info page<br></p>', 'new info page', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_job`
--

CREATE TABLE `ci_job` (
  `job_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `salary` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `type` tinyint(1) NOT NULL,
  `viewed` int(5) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_job`
--

INSERT INTO `ci_job` (`job_id`, `employer_id`, `salary`, `type`, `viewed`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, '0.0000', 1, 130, 1, 1, '2019-05-29 00:00:00', '2020-08-24 08:01:51'),
(2, 1, '0.0000', 1, 130, 1, 1, '2019-05-29 00:00:00', '2020-08-23 21:48:37'),
(10, 1, '0.0000', 1, 0, 1, 1, '2020-08-25 09:10:24', '2020-08-25 09:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `ci_job_description`
--

CREATE TABLE `ci_job_description` (
  `job_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_job_description`
--

INSERT INTO `ci_job_description` (`job_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 'HR Specialist', 'HR Specialist description', 'HR Specialist', 'HR Specialist', 'hr'),
(2, 'Recruiter', '<p>Recruiter desc<br></p>', 'Recruiter', 'Recruiter', 'hr'),
(10, 'new Job', '<p>new Job<br></p>', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`language_id`, `name`, `code`, `locale`, `sort_order`, `status`) VALUES
(1, 'English', 'en', 'en', 1, 1),
(2, 'Arabic', 'ar', 'ar', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout`
--

CREATE TABLE `ci_layout` (
  `layout_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_layout`
--

INSERT INTO `ci_layout` (`layout_id`, `name`) VALUES
(1, 'Home'),
(3, 'category'),
(6, 'Account'),
(8, 'Contact'),
(11, 'Information'),
(13, 'Search');

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_module`
--

CREATE TABLE `ci_layout_module` (
  `layout_module_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_layout_module`
--

INSERT INTO `ci_layout_module` (`layout_module_id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
(9, 1, 'carousel.36', 'column_left', 0),
(8, 6, 'carousel.34', 'column_left', 1),
(15, 3, 'account', 'column_left', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_route`
--

CREATE TABLE `ci_layout_route` (
  `layout_route_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_layout_route`
--

INSERT INTO `ci_layout_route` (`layout_route_id`, `layout_id`, `site_id`, `route`) VALUES
(8, 1, 0, 'common/home'),
(7, 6, 0, 'account/(:any)'),
(10, 3, 0, 'project/category');

-- --------------------------------------------------------

--
-- Table structure for table `ci_module`
--

CREATE TABLE `ci_module` (
  `module_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_module`
--

INSERT INTO `ci_module` (`module_id`, `name`, `code`, `setting`) VALUES
(1, 'test', 'carousel', '{\"name\":\"test\",\"banner_id\":\"7\",\"width\":\"130\",\"height\":\"100\",\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project`
--

CREATE TABLE `ci_project` (
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `type` tinyint(1) NOT NULL,
  `viewed` int(5) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project`
--

INSERT INTO `ci_project` (`project_id`, `freelancer_id`, `employer_id`, `bid_id`, `price`, `type`, `viewed`, `image`, `sort_order`, `delivery_time`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 1, 0, '20.0000', 1, 130, '', 1, 1, 1, '2020-08-17 14:54:10', '2020-08-29 21:01:11'),
(2, 1, 1, 0, '50.0000', 1, 130, '', 1, 1, 1, '2020-08-17 14:54:21', '2020-08-29 21:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_description`
--

CREATE TABLE `ci_project_description` (
  `project_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `tags` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_description`
--

INSERT INTO `ci_project_description` (`project_id`, `language_id`, `name`, `description`, `tags`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'Create 404 HTML template', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '', 'It is a long established fact that ', 'It is a long established fact that ', 'It is a long established fact that'),
(1, 2, 'Create 404 HTML template', '<p>Create 404 HTML template<br></p>', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_review`
--

CREATE TABLE `ci_project_review` (
  `review_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `jobseeker_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `recommended` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_review`
--

INSERT INTO `ci_project_review` (`review_id`, `project_id`, `jobseeker_id`, `employer_id`, `order_id`, `recommended`, `comment`, `rating`, `status`, `date_added`, `date_modified`) VALUES
(1, 2, 1, 1, 1, 5, 'model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 2, 1, '2019-09-19 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_status`
--

CREATE TABLE `ci_project_status` (
  `project_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_status`
--

INSERT INTO `ci_project_status` (`project_status_id`, `language_id`, `name`) VALUES
(7, 1, 'Canceled'),
(5, 1, 'Complete'),
(8, 1, 'Denied'),
(15, 2, 'Processed');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_category`
--

CREATE TABLE `ci_project_to_category` (
  `project_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_to_category`
--

INSERT INTO `ci_project_to_category` (`project_id`, `category_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(5, 1),
(6, 5),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_review`
--

CREATE TABLE `ci_review` (
  `review_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `author` varchar(32) NOT NULL,
  `text` text NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_review`
--

INSERT INTO `ci_review` (`review_id`, `project_id`, `freelancer_id`, `employer_id`, `order_id`, `author`, `text`, `rating`, `status`, `date_added`, `date_modified`) VALUES
(1, 2, 1, 1, 1, 'test', 'model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 2, 1, '2019-09-19 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 2, 1, 2, 'test', 'model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)', 3, 1, '2019-09-19 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_seo_url`
--

CREATE TABLE `ci_seo_url` (
  `seo_url_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_seo_url`
--

INSERT INTO `ci_seo_url` (`seo_url_id`, `site_id`, `language_id`, `query`, `keyword`) VALUES
(1, 0, 1, 'category_id=2', 'internet'),
(2, 0, 2, 'category_id=2', 'internet'),
(3, 0, 1, 'category_id=5', 'drupal'),
(4, 0, 2, 'category_id=5', 'drupal'),
(5, 0, 1, 'category_id=6', 'drupal'),
(6, 0, 2, 'category_id=6', 'drupal'),
(7, 0, 1, 'category_id=7', 'cms'),
(8, 0, 2, 'category_id=7', 'cms'),
(9, 0, 1, 'project_id=8', 'new-project'),
(10, 0, 2, 'project_id=8', 'new-projecteee'),
(11, 0, 1, 'job_id=9', 'test-job'),
(12, 0, 1, 'job_id=10', 'new-job'),
(14, 0, 1, 'job_id=10', 'new-job'),
(15, 0, 1, 'information_id=5', 'new-info-page'),
(16, 0, 2, 'information_id=5', 'new-info-page'),
(17, 0, 1, 'information_id=2', 'about-us'),
(18, 0, 2, 'information_id=2', 'about-us'),
(19, 0, 1, 'information_id=4', 'delivery-information'),
(20, 0, 2, 'information_id=4', 'delivery-information'),
(21, 0, 1, 'information_id=3', 'privacy-policy'),
(22, 0, 2, 'information_id=3', 'privacy-policy'),
(23, 0, 1, 'information_id=1', 'terms-conditions'),
(24, 0, 2, 'information_id=1', 'terms-conditions'),
(25, 0, 1, 'category_id=1', 'mobile-devs'),
(26, 0, 2, 'category_id=1', 'Mobile Devs'),
(27, 0, 1, 'category_id=3', 'websites-it-software'),
(28, 0, 2, 'category_id=3', 'websites-it-software'),
(29, 0, 1, 'category_id=1', 'mobile-devs'),
(30, 0, 2, 'category_id=1', 'mobile-devs'),
(31, 0, 1, 'project_id=1', ''),
(32, 0, 2, 'project_id=1', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('068887ac8beee30ecd89d613e7e05f8317953956', '::1', 1598973637, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937333633373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('09aa0214dacf2ccef14affb15878f195ef1a100e', '::1', 1599071679, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037313637393b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('09c8c6ef1761f7887d449adbb339e0111147eb9d', '::1', 1598963191, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936333139313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('0a021d28bda6effa72d4223bae7ebbdc4c8b3dcd', '::1', 1599078048, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037383032343b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('0a95ff30551213755b1c23ef9fd5777d48cf692d', '::1', 1598970227, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937303232373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('0bac4cdf73d63a772a23ac9ed1003b9a8ec2ef9f', '::1', 1598962884, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936323838343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('0c839d4d80a959fc41a8a4df08d042acbe4dbb86', '::1', 1599324755, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393332343735353b5f63695f70726576696f75735f75726c7c733a39343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f706f73742f6164643f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c4179337768223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d6572726f727c733a34303a2254686520616374696f6e20796f7520726571756573746564206973206e6f7420616c6c6f7765642e223b),
('0fea8609341d03b07276bdc51994e0409dbac2da', '::1', 1599328253, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393332383235333b5f63695f70726576696f75735f75726c7c733a39343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f63617465676f72793f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c4179337768223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b737563636573737c733a33343a22596f752068617665206d6f64696669656420626c6f672063617465676f7269657321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('10f890cf4e0218cd1ff5b5eb9d51c81099399e04', '::1', 1598969253, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936393235333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('11c7d598b4ea89e268382ceb35a1b06ddf8eec09', '::1', 1599336246, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333363234363b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('1279d791204f306f3fd006aa1b20182589ca5fd2', '::1', 1599326258, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393332363235383b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('1304822c9ce3bc02aea34ccf4f4813c291c89145', '::1', 1598969871, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936393837313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('17de361ec19555cb0b130a4a122cad830b390745', '::1', 1599154885, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135343838353b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365266c61796f75745f69643d33223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('1b91ffd1576c9bc432375550781eb0c65d72256e', '::1', 1598975718, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937353731383b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d7826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('1d740ebff5389b2e430ceaad3cb71ef0f0b7dcca', '::1', 1598977160, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937373136303b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f6a6f622f6a6f623f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('213353de3db76b753628cf555fc0278d85e6975d', '::1', 1599074155, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037343135353b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d33223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('24503d9976a2e278683bb2c9a7a72c29b0e1a5e6', '::1', 1599337552, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333373535323b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('2a88b02e7c2ffc76e8e869e23feb13dc1e5be509', '::1', 1599157660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135373636303b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d474e463353577556506b6e6c784d357a5879715241384f69734c443942766f32223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22474e463353577556506b6e6c784d357a5879715241384f69734c443942766f32223b),
('2aa9c7e75134338ec514e4153c292f3ad219e167', '::1', 1599153362, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135333336323b5f63695f70726576696f75735f75726c7c733a36343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d64657369676e2532466c61796f7574223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('31b409846c4be86a38bb9e79a35e955168f7dabf', '::1', 1598971761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937313736313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('3a8bda689f1658c86ee661147bd3bda9a4747642', '::1', 1599229680, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393232393637383b5f63695f70726576696f75735f75726c7c733a36353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d73657474696e672532466d6f64756c65223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('43387c8c20ef5b49578eb4f89a05ef5ae2760015', '::1', 1599335184, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333353138343b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('45efefac306143feb16a9c62c74b4cd0e6cb9a6b', '::1', 1598973327, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937333332373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('4b09394c1efb5dfa462e9aa883ed74cef8445a77', '::1', 1599157660, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135373636303b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d474e463353577556506b6e6c784d357a5879715241384f69734c443942766f32266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22474e463353577556506b6e6c784d357a5879715241384f69734c443942766f32223b),
('5097de7b5f57a20269cabd3f1e336ac800fc5321', '::1', 1599392756, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393339323735343b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('522e6e678a43cf9361b16124cd443276341c3997', '::1', 1599153767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135333736373b5f63695f70726576696f75735f75726c7c733a36343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d64657369676e2532466c61796f7574223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('57383426eccf354137f52053f02157420e3b0880', '::1', 1599073743, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037333734333b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('579b9b69a8cbeedb4305caa6926b5d63a1470ade', '::1', 1598972638, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937323339373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6a676b68413845546f517239754d56716130484a5a434932524e7746664b3165223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226a676b68413845546f517239754d56716130484a5a434932524e7746664b3165223b),
('5915da108f98e5fe23a25e96a5df9cd044078129', '::1', 1599336576, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333363537363b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('5aa04121271a224763e781ce7d65d880caf9aae8', '::1', 1598970632, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937303633323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('5d1f8c64e118fae198ccde4175358f00a77a03e6', '::1', 1598978939, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937383635323b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('5f8411ec1d6e0b2af2e005d0b396bb6c14e221b7', '::1', 1598973005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937333030353b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('630f315db31ea3186b6d9489f8d24bfc452912f0', '::1', 1598970938, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937303933383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('63cd5b586b42c7608efcafc455979a898ce08edc', '::1', 1599078024, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037383032343b5f63695f70726576696f75735f75726c7c733a38343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('77502deefa17612ec46a90f39c26bf78cd9eb084', '::1', 1599336877, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333363837373b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('7c2fa0c6fd9df070fefba3f503b88add2e45bc86', '::1', 1598977479, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937373437393b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d7826747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('8252be03292db48319ddd6e530ac5fee7ebe753a', '::1', 1599077224, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037373232343b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('877908f7833a4d991e9bd77714abb19551db7a1e', '::1', 1598976502, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937363530323b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d7826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('8886128df2dc542ccf4293133ff8d92cdbbb8858', '::1', 1599076040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037363034303b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('90160f32150aa8d5b67fe3ea5c77953cb6ceeee1', '::1', 1598969566, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936393536363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('9d97017002e3330ab8acbe1268f746fb1a59876f', '::1', 1599074606, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037343630363b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('9fd4a5b76caeff22b3e4df7db4a8d0d664e2cbc7', '::1', 1598976852, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937363835323b5f63695f70726576696f75735f75726c7c733a39393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d7826747970653d7468656d65223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('9fe73febaad537ec5834d27816c17024c033ab7b', '::1', 1599072341, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037323334313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('a57173017451feeb34df3df3ae3ebcfc057b2ec0', '::1', 1599155512, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135353531323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f6164643f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('aa311a55e67c1ffc36b62e418ba9daf73918960e', '::1', 1599156177, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135363137373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f6164643f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('abf0925bf58ff666a5b8c877e2f27a24a552b257', '::1', 1599324255, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393332343235353b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f706f73743f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c4179337768223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('ad1a72df3594f029bb3b55e87e546d48ff6b79a1', '::1', 1598977809, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937373830393b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d7826747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('b398fa91bdeb0f377a3af23a1feb6d295e1fd6a8', '::1', 1598968920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936383932303b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('b48ad615a2416cfecc0cfa59a4eb6010159600d6', '::1', 1599325169, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393332353136393b5f63695f70726576696f75735f75726c7c733a39343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f63617465676f72793f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c4179337768223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('b7fe954b92a659bc552141da11dad185171fb16e', '::1', 1598962121, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936323132313b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('beb11a7778e44afe255beeee414583ec02ac492c', '::1', 1599156486, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135363438363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f6164643f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('bf6d5bde46481757f813a88fb85fa5944323dd25', '::1', 1599337838, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333373535323b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f706f73743f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c4179337768223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b737563636573737c733a32393a22596f752068617665206d6f64696669656420626c6f6720706f73747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('c1ad06985b800294c2bf797bb59f52b9aaaddea9', '::1', 1598962535, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936323533353b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('c46136e59da8c477d3e8c513adee4d3be9144972', '::1', 1598971331, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937313333313b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f657874656e73696f6e732f6269643f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('c566d48d45248762e92a5e60fe02cd27d0665dc7', '::1', 1599077537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037373533373b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('c70d796dad0aef1dcee9d6dd444db2258557b631', '::1', 1599335921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393333353932313b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d693245554b48713070446f7842385a63363537345953573147526c417933776826747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22693245554b48713070446f7842385a63363537345953573147526c4179337768223b),
('d46fbf8b848ec56b911ff1f0fd3efddb053a0a38', '::1', 1599155823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135353832333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f6164643f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('d7d211ac8be9705187280f755443fc54375fd9fc', '::1', 1599155190, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393135353139303b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d4d3278304470386f544c5274736c67664564754168466e356931714f51774365266c61796f75745f69643d33223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224d3278304470386f544c5274736c67664564754168466e356931714f51774365223b),
('d9a0bb9a65797e3a33cb9eca47c9a10ec7ce9959', '::1', 1598963550, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936333535303b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('db7bd5393f1e3923d08ad33cc329db5689879c4c', '::1', 1599076414, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037363431343b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('e5ee445e6332bec76cca6264ff9631d22610260f', '::1', 1599076770, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037363737303b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('f150970d95f9db4a1adf23a98cfa5dbf0bb93aa5', '::1', 1598968543, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383936383534333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226844306647337475586f506e4661324b77654f524e676b6272455a514a395537223b),
('fa701c54c0d9477c5d5f8d0b8468899cffb67608', '::1', 1599073156, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539393037333135363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d52724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2252724379683331776e7a355a3471514765444c6642483250394a3774756a6f67223b),
('fbb3960f2cf10a488f3ced45d17a04c1fc47ae48', '::1', 1598978652, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937383635323b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f70726f6a6563742f6164643f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b),
('fc32ec8df0079427c5b7453269e5f4534c543ed8', '::1', 1598978301, 0x5f5f63695f6c6173745f726567656e65726174657c693a313539383937383330313b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f70726f6a6563742f6164643f757365725f746f6b656e3d6b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226b41546a53706479596c564c734e3072713767696875473639434f6166654d78223b);

-- --------------------------------------------------------

--
-- Table structure for table `ci_setting`
--

CREATE TABLE `ci_setting` (
  `setting_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `code` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `setting` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_setting`
--

INSERT INTO `ci_setting` (`setting_id`, `site_id`, `code`, `name`, `setting`, `serialized`) VALUES
(307, 0, 'extension_blog', 'blog_status', '1', 0),
(306, 0, 'config', 'config_layout_id', '1', 0),
(305, 0, 'module_account', 'module_account_status', '1', 0),
(303, 0, 'module_category', 'module_category_status', '1', 0),
(286, 0, 'job', 'job_status', '1', 0),
(274, 0, 'theme_default', 'theme_default_status', '1', 0),
(272, 0, 'config', 'config_customer_activity', '0', 0),
(271, 0, 'config', 'config_project_status_id', '7', 0),
(270, 0, 'config', 'config_login_attempts', '5', 0),
(269, 0, 'config', 'config_admin_limit', '20', 0),
(268, 0, 'config', 'config_currency', 'LE', 0),
(267, 0, 'config', 'config_admin_language_id', '1', 0),
(266, 0, 'config', 'config_language_id', '1', 0),
(302, 0, 'blog', 'blog_status', '1', 0),
(277, 0, 'project_bid', 'project_bid_status', '1', 0),
(273, 0, 'theme_default', 'theme_default_directory', 'default', 0),
(265, 0, 'config', 'config_telephone', '+94 423-23-221', 0),
(260, 0, 'config', 'config_logo', '', 0),
(261, 0, 'config', 'config_name', 'Your Site', 0),
(262, 0, 'config', 'config_owner', 'Ahmed Atwa', 0),
(263, 0, 'config', 'config_address', '6th Forrest Ray, London - 10001 UK', 0),
(264, 0, 'config', 'config_email', 'admin@admin.com', 0),
(259, 0, 'config', 'config_theme', 'default', 0),
(258, 0, 'config', 'config_meta_keyword', '', 0),
(257, 0, 'config', 'config_meta_description', 'Freelancer Site', 0),
(256, 0, 'config', 'config_meta_title', 'Freelancer', 0),
(300, 0, 'dashboard_online', 'dashboard_online_sort_order', '2', 0),
(299, 0, 'dashboard_online', 'dashboard_online_status', '1', 0),
(105, 0, 'dashboard_activity', 'dashboard_activity_status', '1', 0),
(106, 0, 'dashboard_activity', 'dashboard_activity_width', '5', 0),
(107, 0, 'dashboard_activity', 'dashboard_activity_sort_order', '0', 0),
(298, 0, 'dashboard_online', 'dashboard_online_width', '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user`
--

CREATE TABLE `ci_user` (
  `user_id` int(11) NOT NULL,
  `user_group_id` tinyint(4) NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_deleted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user`
--

INSERT INTO `ci_user` (`user_id`, `user_group_id`, `username`, `firstname`, `lastname`, `email`, `password`, `status`, `image`, `code`, `date_added`, `date_modified`, `date_deleted`) VALUES
(1, 1, '', 'Ahmed', 'Atwa', 'admin@admin.com', '$2y$10$zZY54wKZBMY4N.CF7PDYouaRUS/fVC0jB/B1F5iA3L68wr530OQbO', 1, '', '', '2020-06-23 15:39:58', '2020-08-19 13:53:07', '0000-00-00 00:00:00'),
(116, 2, '', 'test', 'test', 'test@test.com', '$2y$10$dz7FsKFNzwBltmknAU5L9ejxRGQA/q.q/Ih2WCWqImFeXQ34vL6Tq', 1, 'catalog/demo/ipod_touch_4.jpg', '', '2020-08-13 02:00:32', '2020-08-13 02:00:32', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_activity`
--

CREATE TABLE `ci_user_activity` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_activity`
--

INSERT INTO `ci_user_activity` (`activity_id`, `user_id`, `key`, `data`, `ip`, `user_agent`, `date_added`) VALUES
(1, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-26 15:07:03'),
(2, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-27 13:01:29'),
(3, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-28 07:37:10'),
(4, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-29 10:42:10'),
(5, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-29 17:43:29'),
(6, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-29 18:37:34'),
(7, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-29 21:39:17'),
(8, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-31 13:59:02'),
(9, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-31 14:55:28'),
(10, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-08-31 15:10:52'),
(11, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-09-01 15:56:43'),
(12, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36 OPR/70.0.3728.133', '2020-09-02 19:34:40');

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_group`
--

CREATE TABLE `ci_user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permission` text NOT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_group`
--

INSERT INTO `ci_user_group` (`user_group_id`, `name`, `permission`, `date_added`, `date_modified`) VALUES
(2, 'Demonstration', '{\"access\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"],\"modify\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"]}', '2020-07-21 21:45:31', '2020-07-21 21:45:31'),
(1, 'Admin', '{\"access\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"events\\/activity\",\"extension\\/bid\\/bid\",\"extension\\/blog\\/category\",\"extension\\/blog\\/post\",\"extension\\/dashboard\\/activity\",\"extension\\/dashboard\\/online\",\"extension\\/extensions\\/bid\",\"extension\\/extensions\\/blog\",\"extension\\/extensions\\/dashboard\",\"extension\\/extensions\\/job\",\"extension\\/extensions\\/theme\",\"extension\\/job\\/job\",\"extension\\/theme\\/default_theme\",\"localisation\\/language\",\"localisation\\/project_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/category\",\"extension\\/blog\\/category\"],\"modify\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"events\\/activity\",\"extension\\/bid\\/bid\",\"extension\\/blog\\/category\",\"extension\\/blog\\/post\",\"extension\\/dashboard\\/activity\",\"extension\\/dashboard\\/online\",\"extension\\/extensions\\/bid\",\"extension\\/extensions\\/blog\",\"extension\\/extensions\\/dashboard\",\"extension\\/extensions\\/job\",\"extension\\/extensions\\/theme\",\"extension\\/job\\/job\",\"extension\\/theme\\/default_theme\",\"localisation\\/language\",\"localisation\\/project_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/post\",\"extension\\/blog\\/category\",\"extension\\/blog\\/category\"]}', '2020-08-07 11:33:45', '2020-09-01 11:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_login`
--

CREATE TABLE `ci_user_login` (
  `user_login_id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_login`
--

INSERT INTO `ci_user_login` (`user_login_id`, `email`, `ip`, `total`, `date_added`, `date_modified`) VALUES
(3, 'admin', '::1', 1, '2020-08-19 20:21:50', '2020-08-19 20:21:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_banner`
--
ALTER TABLE `ci_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  ADD PRIMARY KEY (`banner_image_id`);

--
-- Indexes for table `ci_bids`
--
ALTER TABLE `ci_bids`
  ADD PRIMARY KEY (`bid_id`);

--
-- Indexes for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `ci_blog_post_to_commet`
--
ALTER TABLE `ci_blog_post_to_commet`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `ci_category`
--
ALTER TABLE `ci_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `ci_category_description`
--
ALTER TABLE `ci_category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`) USING BTREE,
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_customer`
--
ALTER TABLE `ci_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  ADD PRIMARY KEY (`customer_activity_id`);

--
-- Indexes for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indexes for table `ci_customer_group_description`
--
ALTER TABLE `ci_customer_group_description`
  ADD PRIMARY KEY (`customer_group_id`,`language_id`);

--
-- Indexes for table `ci_customer_history`
--
ALTER TABLE `ci_customer_history`
  ADD PRIMARY KEY (`customer_history_id`);

--
-- Indexes for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  ADD PRIMARY KEY (`customer_login_id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `ci_customer_online`
--
ALTER TABLE `ci_customer_online`
  ADD PRIMARY KEY (`ip`) USING BTREE;

--
-- Indexes for table `ci_customer_review`
--
ALTER TABLE `ci_customer_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`project_id`);

--
-- Indexes for table `ci_event`
--
ALTER TABLE `ci_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `ci_extension`
--
ALTER TABLE `ci_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- Indexes for table `ci_information`
--
ALTER TABLE `ci_information`
  ADD PRIMARY KEY (`information_id`);

--
-- Indexes for table `ci_information_description`
--
ALTER TABLE `ci_information_description`
  ADD PRIMARY KEY (`information_id`,`language_id`);

--
-- Indexes for table `ci_job`
--
ALTER TABLE `ci_job`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `ci_job_description`
--
ALTER TABLE `ci_job_description`
  ADD PRIMARY KEY (`job_id`) USING BTREE,
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_language`
--
ALTER TABLE `ci_language`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_layout`
--
ALTER TABLE `ci_layout`
  ADD PRIMARY KEY (`layout_id`);

--
-- Indexes for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  ADD PRIMARY KEY (`layout_module_id`);

--
-- Indexes for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  ADD PRIMARY KEY (`layout_route_id`);

--
-- Indexes for table `ci_module`
--
ALTER TABLE `ci_module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `ci_project`
--
ALTER TABLE `ci_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `ci_project_description`
--
ALTER TABLE `ci_project_description`
  ADD PRIMARY KEY (`project_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_project_review`
--
ALTER TABLE `ci_project_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`project_id`);

--
-- Indexes for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  ADD PRIMARY KEY (`project_status_id`,`language_id`);

--
-- Indexes for table `ci_project_to_category`
--
ALTER TABLE `ci_project_to_category`
  ADD PRIMARY KEY (`project_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `ci_review`
--
ALTER TABLE `ci_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`project_id`);

--
-- Indexes for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  ADD PRIMARY KEY (`seo_url_id`),
  ADD KEY `query` (`query`),
  ADD KEY `keyword` (`keyword`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `ci_setting`
--
ALTER TABLE `ci_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `ci_user`
--
ALTER TABLE `ci_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `ci_user_login`
--
ALTER TABLE `ci_user_login`
  ADD PRIMARY KEY (`user_login_id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_banner`
--
ALTER TABLE `ci_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  MODIFY `banner_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `ci_bids`
--
ALTER TABLE `ci_bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_blog_post_to_commet`
--
ALTER TABLE `ci_blog_post_to_commet`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ci_customer`
--
ALTER TABLE `ci_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  MODIFY `customer_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_customer_history`
--
ALTER TABLE `ci_customer_history`
  MODIFY `customer_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  MODIFY `customer_login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_review`
--
ALTER TABLE `ci_customer_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_event`
--
ALTER TABLE `ci_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ci_extension`
--
ALTER TABLE `ci_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `ci_information`
--
ALTER TABLE `ci_information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_job`
--
ALTER TABLE `ci_job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_language`
--
ALTER TABLE `ci_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_layout`
--
ALTER TABLE `ci_layout`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  MODIFY `layout_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  MODIFY `layout_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_project`
--
ALTER TABLE `ci_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_project_review`
--
ALTER TABLE `ci_project_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  MODIFY `project_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ci_review`
--
ALTER TABLE `ci_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  MODIFY `seo_url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ci_user_login`
--
ALTER TABLE `ci_user_login`
  MODIFY `user_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2020 at 06:26 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

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
  `price` decimal(15,4) NOT NULL,
  `Delivery` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_bids`
--

INSERT INTO `ci_bids` (`bid_id`, `project_id`, `freelancer_id`, `price`, `Delivery`, `status`, `date_added`) VALUES
(1, 1, 1, '20.0000', 1, 1, '2020-09-30 11:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_category`
--

CREATE TABLE `ci_blog_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_blog_category`
--

INSERT INTO `ci_blog_category` (`category_id`, `name`, `status`) VALUES
(1, 'uncategorized', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post`
--

CREATE TABLE `ci_blog_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `tags` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `trending` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_blog_post`
--

INSERT INTO `ci_blog_post` (`post_id`, `user_id`, `category_id`, `title`, `body`, `tags`, `image`, `featured`, `trending`, `status`, `date_added`, `date_modified`) VALUES
(1, 0, 1, 'What is Lorem Ipsum?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\">', '', '', 1, 1, 1, '2020-09-23 21:17:17', '2020-09-23 21:33:39'),
(2, 1, 1, 'What is Lorem Ipsum?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\">', '', '', 1, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(3, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(4, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(5, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(6, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(7, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17'),
(8, 1, 1, 'What is Lorem Ipsum?', '<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '', '', 0, 0, 1, '2020-09-23 21:17:17', '2020-09-23 21:17:17');

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

--
-- Dumping data for table `ci_blog_post_to_commet`
--

INSERT INTO `ci_blog_post_to_commet` (`comment_id`, `post_id`, `name`, `email`, `website`, `comment`, `status`, `date_added`) VALUES
(1, 1, 'sssssss', 'ssss@fff.com', '', 'ssss', 0, '2020-09-24 18:49:27');

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
-- Table structure for table `ci_country`
--

CREATE TABLE `ci_country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_country`
--

INSERT INTO `ci_country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `status`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1),
(2, 'Albania', 'AL', 'ALB', 1),
(3, 'Algeria', 'DZ', 'DZA', 1),
(4, 'American Samoa', 'AS', 'ASM', 1),
(5, 'Andorra', 'AD', 'AND', 1),
(6, 'Angola', 'AO', 'AGO', 1),
(7, 'Anguilla', 'AI', 'AIA', 1),
(8, 'Antarctica', 'AQ', 'ATA', 1),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1),
(10, 'Argentina', 'AR', 'ARG', 1),
(11, 'Armenia', 'AM', 'ARM', 1),
(12, 'Aruba', 'AW', 'ABW', 1),
(13, 'Australia', 'AU', 'AUS', 1),
(14, 'Austria', 'AT', 'AUT', 1),
(15, 'Azerbaijan', 'AZ', 'AZE', 1),
(16, 'Bahamas', 'BS', 'BHS', 1),
(17, 'Bahrain', 'BH', 'BHR', 1),
(18, 'Bangladesh', 'BD', 'BGD', 1),
(19, 'Barbados', 'BB', 'BRB', 1),
(20, 'Belarus', 'BY', 'BLR', 1),
(21, 'Belgium', 'BE', 'BEL', 1),
(22, 'Belize', 'BZ', 'BLZ', 1),
(23, 'Benin', 'BJ', 'BEN', 1),
(24, 'Bermuda', 'BM', 'BMU', 1),
(25, 'Bhutan', 'BT', 'BTN', 1),
(26, 'Bolivia', 'BO', 'BOL', 1),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', 1),
(28, 'Botswana', 'BW', 'BWA', 1),
(29, 'Bouvet Island', 'BV', 'BVT', 1),
(30, 'Brazil', 'BR', 'BRA', 1),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', 1),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1),
(33, 'Bulgaria', 'BG', 'BGR', 1),
(34, 'Burkina Faso', 'BF', 'BFA', 1),
(35, 'Burundi', 'BI', 'BDI', 1),
(36, 'Cambodia', 'KH', 'KHM', 1),
(37, 'Cameroon', 'CM', 'CMR', 1),
(38, 'Canada', 'CA', 'CAN', 1),
(39, 'Cape Verde', 'CV', 'CPV', 1),
(40, 'Cayman Islands', 'KY', 'CYM', 1),
(41, 'Central African Republic', 'CF', 'CAF', 1),
(42, 'Chad', 'TD', 'TCD', 1),
(43, 'Chile', 'CL', 'CHL', 1),
(44, 'China', 'CN', 'CHN', 1),
(45, 'Christmas Island', 'CX', 'CXR', 1),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1),
(47, 'Colombia', 'CO', 'COL', 1),
(48, 'Comoros', 'KM', 'COM', 1),
(49, 'Congo', 'CG', 'COG', 1),
(50, 'Cook Islands', 'CK', 'COK', 1),
(51, 'Costa Rica', 'CR', 'CRI', 1),
(52, 'Cote D\'Ivoire', 'CI', 'CIV', 1),
(53, 'Croatia', 'HR', 'HRV', 1),
(54, 'Cuba', 'CU', 'CUB', 1),
(55, 'Cyprus', 'CY', 'CYP', 1),
(56, 'Czech Republic', 'CZ', 'CZE', 1),
(57, 'Denmark', 'DK', 'DNK', 1),
(58, 'Djibouti', 'DJ', 'DJI', 1),
(59, 'Dominica', 'DM', 'DMA', 1),
(60, 'Dominican Republic', 'DO', 'DOM', 1),
(61, 'East Timor', 'TL', 'TLS', 1),
(62, 'Ecuador', 'EC', 'ECU', 1),
(63, 'Egypt', 'EG', 'EGY', 1),
(64, 'El Salvador', 'SV', 'SLV', 1),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1),
(66, 'Eritrea', 'ER', 'ERI', 1),
(67, 'Estonia', 'EE', 'EST', 1),
(68, 'Ethiopia', 'ET', 'ETH', 1),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1),
(70, 'Faroe Islands', 'FO', 'FRO', 1),
(71, 'Fiji', 'FJ', 'FJI', 1),
(72, 'Finland', 'FI', 'FIN', 1),
(74, 'France, Metropolitan', 'FR', 'FRA', 1),
(75, 'French Guiana', 'GF', 'GUF', 1),
(76, 'French Polynesia', 'PF', 'PYF', 1),
(77, 'French Southern Territories', 'TF', 'ATF', 1),
(78, 'Gabon', 'GA', 'GAB', 1),
(79, 'Gambia', 'GM', 'GMB', 1),
(80, 'Georgia', 'GE', 'GEO', 1),
(81, 'Germany', 'DE', 'DEU', 1),
(82, 'Ghana', 'GH', 'GHA', 1),
(83, 'Gibraltar', 'GI', 'GIB', 1),
(84, 'Greece', 'GR', 'GRC', 1),
(85, 'Greenland', 'GL', 'GRL', 1),
(86, 'Grenada', 'GD', 'GRD', 1),
(87, 'Guadeloupe', 'GP', 'GLP', 1),
(88, 'Guam', 'GU', 'GUM', 1),
(89, 'Guatemala', 'GT', 'GTM', 1),
(90, 'Guinea', 'GN', 'GIN', 1),
(91, 'Guinea-Bissau', 'GW', 'GNB', 1),
(92, 'Guyana', 'GY', 'GUY', 1),
(93, 'Haiti', 'HT', 'HTI', 1),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1),
(95, 'Honduras', 'HN', 'HND', 1),
(96, 'Hong Kong', 'HK', 'HKG', 1),
(97, 'Hungary', 'HU', 'HUN', 1),
(98, 'Iceland', 'IS', 'ISL', 1),
(99, 'India', 'IN', 'IND', 1),
(100, 'Indonesia', 'ID', 'IDN', 1),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1),
(102, 'Iraq', 'IQ', 'IRQ', 1),
(103, 'Ireland', 'IE', 'IRL', 1),
(104, 'Israel', 'IL', 'ISR', 1),
(105, 'Italy', 'IT', 'ITA', 1),
(106, 'Jamaica', 'JM', 'JAM', 1),
(107, 'Japan', 'JP', 'JPN', 1),
(108, 'Jordan', 'JO', 'JOR', 1),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1),
(110, 'Kenya', 'KE', 'KEN', 1),
(111, 'Kiribati', 'KI', 'KIR', 1),
(112, 'North Korea', 'KP', 'PRK', 1),
(113, 'South Korea', 'KR', 'KOR', 1),
(114, 'Kuwait', 'KW', 'KWT', 1),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', 1),
(117, 'Latvia', 'LV', 'LVA', 1),
(118, 'Lebanon', 'LB', 'LBN', 1),
(119, 'Lesotho', 'LS', 'LSO', 1),
(120, 'Liberia', 'LR', 'LBR', 1),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1),
(122, 'Liechtenstein', 'LI', 'LIE', 1),
(123, 'Lithuania', 'LT', 'LTU', 1),
(124, 'Luxembourg', 'LU', 'LUX', 1),
(125, 'Macau', 'MO', 'MAC', 1),
(126, 'FYROM', 'MK', 'MKD', 1),
(127, 'Madagascar', 'MG', 'MDG', 1),
(128, 'Malawi', 'MW', 'MWI', 1),
(129, 'Malaysia', 'MY', 'MYS', 1),
(130, 'Maldives', 'MV', 'MDV', 1),
(131, 'Mali', 'ML', 'MLI', 1),
(132, 'Malta', 'MT', 'MLT', 1),
(133, 'Marshall Islands', 'MH', 'MHL', 1),
(134, 'Martinique', 'MQ', 'MTQ', 1),
(135, 'Mauritania', 'MR', 'MRT', 1),
(136, 'Mauritius', 'MU', 'MUS', 1),
(137, 'Mayotte', 'YT', 'MYT', 1),
(138, 'Mexico', 'MX', 'MEX', 1),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', 1),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1),
(141, 'Monaco', 'MC', 'MCO', 1),
(142, 'Mongolia', 'MN', 'MNG', 1),
(143, 'Montserrat', 'MS', 'MSR', 1),
(144, 'Morocco', 'MA', 'MAR', 1),
(145, 'Mozambique', 'MZ', 'MOZ', 1),
(146, 'Myanmar', 'MM', 'MMR', 1),
(147, 'Namibia', 'NA', 'NAM', 1),
(148, 'Nauru', 'NR', 'NRU', 1),
(149, 'Nepal', 'NP', 'NPL', 1),
(150, 'Netherlands', 'NL', 'NLD', 1),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1),
(152, 'New Caledonia', 'NC', 'NCL', 1),
(153, 'New Zealand', 'NZ', 'NZL', 1),
(154, 'Nicaragua', 'NI', 'NIC', 1),
(155, 'Niger', 'NE', 'NER', 1),
(156, 'Nigeria', 'NG', 'NGA', 1),
(157, 'Niue', 'NU', 'NIU', 1),
(158, 'Norfolk Island', 'NF', 'NFK', 1),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1),
(160, 'Norway', 'NO', 'NOR', 1),
(161, 'Oman', 'OM', 'OMN', 1),
(162, 'Pakistan', 'PK', 'PAK', 1),
(163, 'Palau', 'PW', 'PLW', 1),
(164, 'Panama', 'PA', 'PAN', 1),
(165, 'Papua New Guinea', 'PG', 'PNG', 1),
(166, 'Paraguay', 'PY', 'PRY', 1),
(167, 'Peru', 'PE', 'PER', 1),
(168, 'Philippines', 'PH', 'PHL', 1),
(169, 'Pitcairn', 'PN', 'PCN', 1),
(170, 'Poland', 'PL', 'POL', 1),
(171, 'Portugal', 'PT', 'PRT', 1),
(172, 'Puerto Rico', 'PR', 'PRI', 1),
(173, 'Qatar', 'QA', 'QAT', 1),
(174, 'Reunion', 'RE', 'REU', 1),
(175, 'Romania', 'RO', 'ROM', 1),
(176, 'Russian Federation', 'RU', 'RUS', 1),
(177, 'Rwanda', 'RW', 'RWA', 1),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1),
(179, 'Saint Lucia', 'LC', 'LCA', 1),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1),
(181, 'Samoa', 'WS', 'WSM', 1),
(182, 'San Marino', 'SM', 'SMR', 1),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1),
(184, 'Saudi Arabia', 'SA', 'SAU', 1),
(185, 'Senegal', 'SN', 'SEN', 1),
(186, 'Seychelles', 'SC', 'SYC', 1),
(187, 'Sierra Leone', 'SL', 'SLE', 1),
(188, 'Singapore', 'SG', 'SGP', 1),
(189, 'Slovak Republic', 'SK', 'SVK', 1),
(190, 'Slovenia', 'SI', 'SVN', 1),
(191, 'Solomon Islands', 'SB', 'SLB', 1),
(192, 'Somalia', 'SO', 'SOM', 1),
(193, 'South Africa', 'ZA', 'ZAF', 1),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', 1),
(195, 'Spain', 'ES', 'ESP', 1),
(196, 'Sri Lanka', 'LK', 'LKA', 1),
(197, 'St. Helena', 'SH', 'SHN', 1),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1),
(199, 'Sudan', 'SD', 'SDN', 1),
(200, 'Suriname', 'SR', 'SUR', 1),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1),
(202, 'Swaziland', 'SZ', 'SWZ', 1),
(203, 'Sweden', 'SE', 'SWE', 1),
(204, 'Switzerland', 'CH', 'CHE', 1),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1),
(206, 'Taiwan', 'TW', 'TWN', 1),
(207, 'Tajikistan', 'TJ', 'TJK', 1),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1),
(209, 'Thailand', 'TH', 'THA', 1),
(210, 'Togo', 'TG', 'TGO', 1),
(211, 'Tokelau', 'TK', 'TKL', 1),
(212, 'Tonga', 'TO', 'TON', 1),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1),
(214, 'Tunisia', 'TN', 'TUN', 1),
(215, 'Turkey', 'TR', 'TUR', 1),
(216, 'Turkmenistan', 'TM', 'TKM', 1),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1),
(218, 'Tuvalu', 'TV', 'TUV', 1),
(219, 'Uganda', 'UG', 'UGA', 1),
(220, 'Ukraine', 'UA', 'UKR', 1),
(221, 'United Arab Emirates', 'AE', 'ARE', 1),
(222, 'United Kingdom', 'GB', 'GBR', 1),
(223, 'United States', 'US', 'USA', 1),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1),
(225, 'Uruguay', 'UY', 'URY', 1),
(226, 'Uzbekistan', 'UZ', 'UZB', 1),
(227, 'Vanuatu', 'VU', 'VUT', 1),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1),
(229, 'Venezuela', 'VE', 'VEN', 1),
(230, 'Viet Nam', 'VN', 'VNM', 1),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1),
(234, 'Western Sahara', 'EH', 'ESH', 1),
(235, 'Yemen', 'YE', 'YEM', 1),
(237, 'Democratic Republic of Congo', 'CD', 'COD', 1),
(238, 'Zambia', 'ZM', 'ZMB', 1),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1),
(242, 'Montenegro', 'ME', 'MNE', 1),
(243, 'Serbia', 'RS', 'SRB', 1),
(244, 'Aaland Islands', 'AX', 'ALA', 1),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', 1),
(246, 'Curacao', 'CW', 'CUW', 1),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', 1),
(248, 'South Sudan', 'SS', 'SSD', 1),
(249, 'St. Barthelemy', 'BL', 'BLM', 1),
(250, 'St. Martin (French part)', 'MF', 'MAF', 1),
(251, 'Canary Islands', 'IC', 'ICA', 1),
(252, 'Ascension Island (British)', 'AC', 'ASC', 1),
(253, 'Kosovo, Republic of', 'XK', 'UNK', 1),
(254, 'Isle of Man', 'IM', 'IMN', 1),
(255, 'Tristan da Cunha', 'TA', 'SHN', 1),
(256, 'Guernsey', 'GG', 'GGY', 1),
(257, 'Jersey', 'JE', 'JEY', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer`
--

CREATE TABLE `ci_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `2step` tinyint(1) NOT NULL,
  `about` text NOT NULL,
  `tag_line` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `newsletter`, `image`, `ip`, `status`, `code`, `2step`, `about`, `tag_line`, `date_added`, `date_modified`) VALUES
(1, 1, 'John ', 'Duo', 'john', 'customer@customer.com', '', '$2y$10$39XfFIWc8e5PZquTntt5a.EDeGQgT7lr2JeJhj5rPcmopMCQ44BH.', 0, '', '', 1, '', 0, 'Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.', '', '2020-09-20 12:44:02', '0000-00-00 00:00:00'),
(19, 1, '', '', 'test', 'test@test.com', '', '$2y$10$wNt8KxcKJv3TMSRkg.uKDeoWCjAxkg4reLUZUwMcFXzu3aQdQvyvm', 0, '', '', 0, 'f3awKnNmub', 0, '', '', '2020-09-26 22:28:24', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_activity`
--

CREATE TABLE `ci_customer_activity` (
  `customer_activity_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_activity`
--

INSERT INTO `ci_customer_activity` (`customer_activity_id`, `customer_id`, `key`, `data`, `ip`, `user_agent`, `date_added`) VALUES
(2, 16, 'customer_register', '{\"customer_id\":16,\"username\":\"test\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-20 15:13:58'),
(3, 17, 'customer_register', '{\"customer_id\":17,\"username\":\"rehab.garhy\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-20 15:15:07'),
(4, 18, 'customer_register', '{\"customer_id\":18,\"username\":\"rehab.garhy\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-20 15:17:24'),
(5, 19, 'customer_register', '{\"customer_id\":19,\"username\":\"test\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-26 22:28:24');

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

--
-- Dumping data for table `ci_customer_login`
--

INSERT INTO `ci_customer_login` (`customer_login_id`, `email`, `ip`, `total`, `date_added`, `date_modified`) VALUES
(1, 'admin', '::1', 3, '2020-09-15 18:51:11', '2020-09-20 12:42:50'),
(5, 'seller@seller.com', '::1', 1, '2020-09-20 12:43:27', '0000-00-00 00:00:00');

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
-- Table structure for table `ci_customer_to_balance`
--

CREATE TABLE `ci_customer_to_balance` (
  `balance_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `net_income` decimal(15,4) NOT NULL,
  `withdrawn` decimal(15,4) NOT NULL,
  `used` decimal(15,4) NOT NULL,
  `available` decimal(15,4) NOT NULL,
  `pending` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_certificate`
--

CREATE TABLE `ci_customer_to_certificate` (
  `certificate_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `year` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_customer_to_certificate`
--

INSERT INTO `ci_customer_to_certificate` (`certificate_id`, `freelancer_id`, `name`, `year`, `date_added`) VALUES
(1, 0, '', '', '2020-09-26 12:24:49'),
(2, 0, '', '', '2020-09-26 12:26:25'),
(3, 1, 'sssss', '2017', '2020-09-26 12:27:03'),
(4, 1, 'fffff', '2015', '2020-09-26 12:46:54'),
(5, 1, 'sssssss', '2018', '2020-09-26 12:47:31'),
(6, 1, 'sssssssddddd', '2007', '2020-09-26 13:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_education`
--

CREATE TABLE `ci_customer_to_education` (
  `education_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `year` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_customer_to_education`
--

INSERT INTO `ci_customer_to_education` (`education_id`, `freelancer_id`, `university_id`, `major_id`, `title`, `year`, `country`, `date_added`) VALUES
(1, 1, 1, 2, 'ba', '2020', 'Egypt', '2020-09-26 19:13:17'),
(2, 1, 1, 2, 'brach', '2020', 'Egypt', '2020-09-26 20:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_language`
--

CREATE TABLE `ci_customer_to_language` (
  `language_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `level` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_language`
--

INSERT INTO `ci_customer_to_language` (`language_id`, `freelancer_id`, `level`, `date_added`) VALUES
(1, 1, '2', '2020-09-26 21:57:36'),
(3, 1, '3', '2020-09-26 21:57:42'),
(59, 1, '4', '2020-09-26 22:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_skill`
--

CREATE TABLE `ci_customer_to_skill` (
  `skill_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `level` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_skill`
--

INSERT INTO `ci_customer_to_skill` (`skill_id`, `freelancer_id`, `level`, `date_added`) VALUES
(2, 1, 'expert', '2020-09-26 22:14:53'),
(3, 1, 'beginner', '2020-09-26 21:44:12');

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
(1, 'activity_user_login', 'Admin\\Events\\Activity::login', 'Record User Login Activity', 1, 0),
(2, 'login_attempts', 'Admin\\Events\\Activity::loginAttempts', 'Record Login Attempts to Admin Area', 1, 0),
(3, 'mail_forgotten', 'Admin\\Events\\Activity::mailForgotten', 'Trigger an Email for password reset', 1, 0),
(6, 'user_activity_add', 'Admin\\Events\\Activity::afterInsert', 'Log Activity After Insert to DB', 1, 0),
(8, 'customer_register', 'Catalog\\Events\\Activity::customerRegister', 'Trigger New Customer Registration', 1, 0),
(9, 'mail_customer_add', 'Catalog\\Events\\Activity::mailRegister', 'Trigger Email to newly registered customers', 1, 0);

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
(1, 'project', 'bid'),
(53, 'blogger', 'post'),
(52, 'blogger', 'category'),
(55, 'wallet', 'wallet'),
(56, 'theme', 'basic'),
(57, 'job', 'job'),
(58, 'module', 'category');

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
(1, 1, 0, 1, '0000-00-00 00:00:00', '2020-09-20 22:03:20'),
(2, 1, 3, 1, '0000-00-00 00:00:00', '2020-09-20 22:02:56'),
(3, 1, 1, 1, '0000-00-00 00:00:00', '2020-09-20 22:03:10');

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
(1, 2, 'الشروط والأحكام', '\"لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور\r\n\r\nأنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد\r\n\r\nأكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات . ديواس\r\n\r\nأيوتي أريري دولار إن ريبريهينديرأيت فوليوبتاتي فيلايت أيسسي كايلليوم دولار أيو فيجايت\r\n\r\nنيولا باراياتيور. أيكسسيبتيور ساينت أوككايكات كيوبايداتات نون بروايدينت ,سيونت ان كيولبا\r\n\r\nكيو أوفيسيا ديسيريونتموليت انيم أيدي ايست لابوريوم.\"\r\n\r\n\"سيت يتبيرسبايكياتيس يوندي أومنيس أستي ناتيس أيررور سيت فوليبتاتيم أكيسأنتييوم\r\n\r\nدولاريمكيو لايودانتيوم,توتام ريم أبيرأم,أيكيو أبسا كيواي أب أللو أنفينتوري فيرأتاتيس ايت\r\n\r\nكياسي أرشيتيكتو بيتاي فيتاي ديكاتا سيونت أكسبليكابو. نيمو أنيم أبسام فوليوباتاتيم كيواي\r\n\r\nفوليوبتاس سايت أسبيرناتشر أيوت أودايت أيوت فيوجايت, سيد كيواي كونسيكيونتشر ماجناي', 'كونسيكتيتور', '', ''),
(1, 1, 'Terms & Conditions', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span></p>', 'Terms & Conditions', '', ''),
(5, 1, 'new info page', '<p>new info page<br></p>', 'new info page', '', ''),
(2, 2, 'About Us', '<p><span style=\"color: rgb(0, 0, 0);\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', 'About Us', '', ''),
(3, 2, 'سياسة خاصة', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span><br></p>', 'Privacy Policy', '', ''),
(2, 1, 'About Us', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', 'About Us', '', ''),
(3, 1, 'Privacy Policy', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span><br></p>\r\n', 'Privacy Policy', '', '');

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
-- Table structure for table `ci_languages`
--

CREATE TABLE `ci_languages` (
  `language_id` int(11) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_languages`
--

INSERT INTO `ci_languages` (`language_id`, `text`) VALUES
(1, 'Afrikaans'),
(2, 'Albanian'),
(3, 'Amharic'),
(4, 'Arabic'),
(5, 'Armenian'),
(6, 'Basque'),
(7, 'Bengali'),
(8, 'Byelorussian'),
(9, 'Burmese'),
(10, 'Bulgarian'),
(11, 'Catalan'),
(12, 'Czech'),
(13, 'Chinese'),
(14, 'Croatian'),
(15, 'Danish'),
(16, 'Dari'),
(17, 'Dzongkha'),
(18, 'Dutch'),
(19, 'English'),
(20, 'Esperanto'),
(21, 'Estonian'),
(22, 'Faroese'),
(23, 'Farsi'),
(24, 'Finnish'),
(25, 'French'),
(26, 'Gaelic'),
(27, 'Galician'),
(28, 'German'),
(29, 'Greek'),
(30, 'Hebrew'),
(31, 'Hindi'),
(32, 'Hungarian'),
(33, 'Icelandic'),
(34, 'Indonesian'),
(35, 'Inuktitut (Eskimo)'),
(36, 'Italian'),
(37, 'Japanese'),
(38, 'Khmer'),
(39, 'Korean'),
(40, 'Kurdish'),
(41, 'Laotian'),
(42, 'Latvian'),
(43, 'Lappish'),
(44, 'Lithuanian'),
(45, 'Macedonian'),
(46, 'Malay'),
(47, 'Maltese'),
(48, 'Nepali'),
(49, 'Norwegian'),
(50, 'Pashto'),
(51, 'Polish'),
(52, 'Portuguese'),
(53, 'Romanian'),
(54, 'Russian'),
(55, 'Scots'),
(56, 'Serbian'),
(57, 'Slovak'),
(58, 'Slovenian'),
(59, 'Somali'),
(60, 'Spanish'),
(61, 'Swedish'),
(62, 'Swahili'),
(63, 'Tagalog-Filipino'),
(64, 'Tajik'),
(65, 'Tamil'),
(66, 'Thai'),
(67, 'Tibetan'),
(68, 'Tigrinya'),
(69, 'Tongan'),
(70, 'Turkish'),
(71, 'Turkmen'),
(72, 'Ucrainian'),
(73, 'Urdu'),
(74, 'Uzbek'),
(75, 'Vietnamese'),
(76, 'Welsh');

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
-- Table structure for table `ci_majors`
--

CREATE TABLE `ci_majors` (
  `major_id` int(11) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_majors`
--

INSERT INTO `ci_majors` (`major_id`, `text`) VALUES
(1, 'Accounting'),
(2, 'Actuarial Science'),
(3, 'Advertising'),
(4, 'Aerospace Engineering'),
(5, 'African Languages, Literatures, and Linguistics'),
(6, 'African Studies'),
(7, 'African-American Studies'),
(8, 'Agricultural Business and Management'),
(9, 'Agricultural Economics'),
(10, 'Agricultural Education'),
(11, 'Agricultural Journalism'),
(12, 'Agricultural Mechanization'),
(13, 'Agricultural Technology Management'),
(14, 'Agricultural/Biological Engineering and Bioengineering'),
(15, 'Agriculture'),
(16, 'Agronomy and Crop Science'),
(17, 'Air Traffic Control'),
(18, 'American History'),
(19, 'American Literature'),
(20, 'American Sign Language'),
(21, 'American Studies'),
(22, 'Anatomy'),
(23, 'Ancient Studies'),
(24, 'Animal Behavior and Ethology'),
(25, 'Animal Science'),
(26, 'Animation and Special Effects'),
(27, 'Anthropology'),
(28, 'Applied Mathematics'),
(29, 'Aquaculture'),
(30, 'Aquatic Biology'),
(31, 'Arabic'),
(32, 'Archeology'),
(33, 'Architectural Engineering'),
(34, 'Architectural History'),
(35, 'Architecture'),
(36, 'Art'),
(37, 'Art Education'),
(38, 'Art History'),
(39, 'Art Therapy'),
(40, 'Artificial Intelligence and Robotics'),
(41, 'Asian-American Studies'),
(42, 'Astronomy'),
(43, 'Astrophysics'),
(44, 'Athletic Training'),
(45, 'Atmospheric Science'),
(46, 'Automotive Engineering'),
(47, 'Aviation'),
(48, 'Bakery Science'),
(49, 'Biblical Studies'),
(50, 'Biochemistry'),
(51, 'Bioethics'),
(52, 'Biology'),
(53, 'Biomedical Engineering'),
(54, 'Biomedical Science'),
(55, 'Biopsychology'),
(56, 'Biotechnology'),
(57, 'Botany/Plant Biology'),
(58, 'Business Administration/Management'),
(59, 'Business Communications'),
(60, 'Business Education'),
(61, 'Canadian Studies'),
(62, 'Caribbean Studies'),
(63, 'Cell Biology'),
(64, 'Ceramic Engineering'),
(65, 'Ceramics'),
(66, 'Chemical Engineering'),
(67, 'Chemical Physics'),
(68, 'Chemistry'),
(69, 'Child Care'),
(70, 'Child Development'),
(71, 'Chinese'),
(72, 'Chiropractic'),
(73, 'Church Music'),
(74, 'Cinematography and Film/Video Production'),
(75, 'Circulation Technology'),
(76, 'Civil Engineering'),
(77, 'Classics'),
(78, 'Clinical Psychology'),
(79, 'Cognitive Psychology'),
(80, 'Communication Disorders'),
(81, 'Communications Studies/Speech Communication and Rhetoric'),
(82, 'Comparative Literature'),
(83, 'Computer and Information Science'),
(84, 'Computer Engineering'),
(85, 'Computer Graphics'),
(86, 'Computer Systems Analysis'),
(87, 'Construction Management'),
(88, 'Counseling'),
(89, 'Crafts'),
(90, 'Creative Writing'),
(91, 'Criminal Science'),
(92, 'Criminology'),
(93, 'Culinary Arts'),
(94, 'Dance'),
(95, 'Data Processing'),
(96, 'Dental Hygiene'),
(97, 'Developmental Psychology'),
(98, 'Diagnostic Medical Sonography'),
(99, 'Dietetics'),
(100, 'Digital Communications and Media/Multimedia'),
(101, 'Drawing'),
(102, 'Early Childhood Education'),
(103, 'East Asian Studies'),
(104, 'East European Studies'),
(105, 'Ecology'),
(106, 'Economics'),
(107, 'Education'),
(108, 'Education Administration'),
(109, 'Education of the Deaf'),
(110, 'Educational Psychology'),
(111, 'Electrical Engineering'),
(112, 'Elementary Education'),
(113, 'Engineering Mechanics'),
(114, 'Engineering Physics'),
(115, 'English'),
(116, 'English Composition'),
(117, 'English Literature'),
(118, 'Entomology'),
(119, 'Entrepreneurship'),
(120, 'Environmental Design/Architecture'),
(121, 'Environmental Science'),
(122, 'Environmental/Environmental Health Engineering'),
(123, 'Epidemiology'),
(124, 'Equine Studies'),
(125, 'Ethnic Studies'),
(126, 'European History'),
(127, 'Experimental Pathology'),
(128, 'Experimental Psychology'),
(129, 'Fashion Design'),
(130, 'Fashion Merchandising'),
(131, 'Feed Science'),
(132, 'Fiber, Textiles, and Weaving Arts'),
(133, 'Film'),
(134, 'Finance'),
(135, 'Floriculture'),
(136, 'Food Science'),
(137, 'Forensic Science'),
(138, 'Forestry'),
(139, 'French'),
(140, 'Furniture Design'),
(141, 'Game Design'),
(142, 'Gay and Lesbian Studies'),
(143, 'Genetics'),
(144, 'Geography'),
(145, 'Geological Engineering'),
(146, 'Geology'),
(147, 'Geophysics'),
(148, 'German'),
(149, 'Gerontology'),
(150, 'Government'),
(151, 'Graphic Design'),
(152, 'Health Administration'),
(153, 'Hebrew'),
(154, 'Hispanic-American, Puerto Rican, and Chicano Studies'),
(155, 'Historic Preservation'),
(156, 'History'),
(157, 'Home Economics'),
(158, 'Horticulture'),
(159, 'Hospitality'),
(160, 'Human Development'),
(161, 'Human Resources Management'),
(162, 'Illustration'),
(163, 'Industrial Design'),
(164, 'Industrial Engineering'),
(165, 'Industrial Management'),
(166, 'Industrial Psychology'),
(167, 'Information Technology'),
(168, 'Interior Architecture'),
(169, 'Interior Design'),
(170, 'International Agriculture'),
(171, 'International Business'),
(172, 'International Relations'),
(173, 'International Studies'),
(174, 'Islamic Studies'),
(175, 'Italian'),
(176, 'Japanese'),
(177, 'Jazz Studies'),
(178, 'Jewelry and Metalsmithing'),
(179, 'Jewish Studies'),
(180, 'Journalism'),
(181, 'Kinesiology'),
(182, 'Korean'),
(183, 'Land Use Planning and Management'),
(184, 'Landscape Architecture'),
(185, 'Landscape Horticulture'),
(186, 'Latin American Studies'),
(187, 'Library Science'),
(188, 'Linguistics'),
(189, 'Logistics Management'),
(190, 'Management Information Systems'),
(191, 'Managerial Economics'),
(192, 'Marine Biology'),
(193, 'Marine Science'),
(194, 'Marketing'),
(195, 'Mass Communication'),
(196, 'Massage Therapy'),
(197, 'Materials Science'),
(198, 'Mathematics'),
(199, 'Mechanical Engineering'),
(200, 'Medical Technology'),
(201, 'Medieval and Renaissance Studies'),
(202, 'Mental Health Services'),
(203, 'Merchandising and Buying Operations'),
(204, 'Metallurgical Engineering'),
(205, 'Microbiology'),
(206, 'Middle Eastern Studies'),
(207, 'Military Science'),
(208, 'Mineral Engineering'),
(209, 'Missions'),
(210, 'Modern Greek'),
(211, 'Molecular Biology'),
(212, 'Molecular Genetics'),
(213, 'Mortuary Science'),
(214, 'Museum Studies'),
(215, 'Music'),
(216, 'Music Education'),
(217, 'Music History'),
(218, 'Music Management'),
(219, 'Music Therapy'),
(220, 'Musical Theater'),
(221, 'Native American Studies'),
(222, 'Natural Resources Conservation'),
(223, 'Naval Architecture'),
(224, 'Neurobiology'),
(225, 'Neuroscience'),
(226, 'Nuclear Engineering'),
(227, 'Nursing'),
(228, 'Nutrition'),
(229, 'Occupational Therapy'),
(230, 'Ocean Engineering'),
(231, 'Oceanography'),
(232, 'Operations Management'),
(233, 'Organizational Behavior Studies'),
(234, 'Painting'),
(235, 'Paleontology'),
(236, 'Pastoral Studies'),
(237, 'Peace Studies'),
(238, 'Petroleum Engineering'),
(239, 'Pharmacology'),
(240, 'Pharmacy'),
(241, 'Philosophy'),
(242, 'Photography'),
(243, 'Photojournalism'),
(244, 'Physical Education'),
(245, 'Physical Therapy'),
(246, 'Physician Assistant'),
(247, 'Physics'),
(248, 'Physiological Psychology'),
(249, 'Piano'),
(250, 'Planetary Science');

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
  `budget_min` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `budget_max` decimal(15,4) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '"1:Fixed", "2:Hour"',
  `viewed` int(5) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project`
--

INSERT INTO `ci_project` (`project_id`, `freelancer_id`, `employer_id`, `bid_id`, `budget_min`, `budget_max`, `type`, `viewed`, `image`, `sort_order`, `delivery_time`, `status`, `date_added`, `date_end`, `date_modified`) VALUES
(1, 1, 1, 0, '20.0000', '50.0000', 1, 172, '', 1, 1, 1, '2020-09-17 21:56:26', '2020-09-30 17:53:15', '2020-09-16 22:06:44');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_description`
--

CREATE TABLE `ci_project_description` (
  `project_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_description`
--

INSERT INTO `ci_project_description` (`project_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'Create 404 HTML template', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', 'It is a long established fact that ', 'It is a long established fact that ', 'aaa,ddd,ffff,gggg');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_review`
--

CREATE TABLE `ci_project_review` (
  `project_review_id` int(11) NOT NULL,
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
-- Dumping data for table `ci_project_review`
--

INSERT INTO `ci_project_review` (`project_review_id`, `project_id`, `freelancer_id`, `employer_id`, `order_id`, `recommended`, `comment`, `rating`, `status`, `date_added`, `date_modified`) VALUES
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
(33, 1),
(33, 7);

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_skill`
--

CREATE TABLE `ci_project_to_skill` (
  `project_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_to_skill`
--

INSERT INTO `ci_project_to_skill` (`project_id`, `skill_id`) VALUES
(33, 11),
(33, 15);

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
(59, 0, 1, 'project_id=29', 'sssssss'),
(58, 0, 1, 'post_id=1', 'what-is-lorem-ipsum'),
(57, 0, 1, 'post_id=1', 'new-test-blog\r\n'),
(14, 0, 1, 'job_id=10', 'new-job'),
(60, 0, 1, 'project_id=30', 'sssssss'),
(61, 0, 1, 'project_id=31', 'another-test'),
(55, 0, 1, 'information_id=1', 'terms-conditions'),
(56, 0, 2, 'information_id=1', 'الشروط-والأحكام'),
(54, 0, 2, 'information_id=3', 'سياسة-خاصة'),
(52, 0, 2, 'information_id=2', 'about-us'),
(53, 0, 1, 'information_id=3', 'privacy-policy'),
(51, 0, 1, 'information_id=2', 'about-us'),
(25, 0, 1, 'category_id=1', 'mobile-devs'),
(26, 0, 2, 'category_id=1', 'Mobile Devs'),
(28, 0, 2, 'category_id=3', 'websites-it-software'),
(29, 0, 1, 'category_id=1', 'mobile-devs'),
(30, 0, 2, 'category_id=1', 'mobile-devs'),
(62, 0, 1, 'project_id=32', 'another-test'),
(43, 0, 1, 'project_id=1', 'create-404-html-template'),
(44, 0, 2, 'project_id=1', 'create-404-html-template'),
(63, 0, 1, 'project_id=33', 'another-project-test'),
(64, 0, 1, 'project_id=34', 'another-project-test'),
(65, 0, 1, 'project_id=35', 'another-project-test'),
(66, 0, 1, 'project_id=36', 'another-project-test'),
(67, 0, 1, 'project_id=37', 'another-project-test'),
(68, 0, 1, 'project_id=38', 'another-project-test'),
(69, 0, 1, 'project_id=39', 'another-project-test'),
(70, 0, 1, 'project_id=40', 'another-project-test'),
(71, 0, 1, 'project_id=41', 'another-project-test'),
(72, 0, 1, 'project_id=42', 'another-project-test'),
(73, 0, 1, 'project_id=43', 'another-test-project'),
(74, 0, 1, 'project_id=44', 'another-project-test'),
(75, 0, 1, 'project_id=45', 'another-test-project'),
(76, 0, 1, 'project_id=46', 'another-project-test'),
(77, 0, 1, 'project_id=47', 'aaaaa'),
(78, 0, 1, 'project_id=48', 'aaaaaa'),
(79, 0, 1, 'project_id=49', ''),
(80, 0, 1, 'project_id=50', 'aaaaaaa'),
(81, 0, 1, 'project_id=51', ''),
(82, 0, 1, 'project_id=52', ''),
(83, 0, 1, 'project_id=53', ''),
(84, 0, 1, 'project_id=54', ''),
(85, 0, 1, 'project_id=65', '');

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
('518b24fd217a626c983c2ac5a3c46f3750643a5d', '::1', 1600447091, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303434373039313b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d636174616c6f67253246696e666f726d6174696f6e223b),
('86036f75654e5da6da2ec3e623a5e8f56cdb62a2', '::1', 1600461336, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303436313333363b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f73657474696e673f757365725f746f6b656e3d53394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2253394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b737563636573737c733a32373a22596f752068617665206d6f6469666965642053657474696e677321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('41992676f6bb591abeb071f770979335dfaf821d', '::1', 1600461816, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303436313831363b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f73657474696e673f757365725f746f6b656e3d53394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2253394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b737563636573737c733a32373a22596f752068617665206d6f6469666965642053657474696e677321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('21f8f0ec2a728428da1ca8f14684dd1c3a1bf5e9', '::1', 1600462185, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303436323138353b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d53394c324a304d796a4f566236336d4e7769676e576f5045444963655564513726747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2253394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b737563636573737c733a33383a22537563636573733a20596f752068617665206d6f6469666965642064617368626f6172647321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('f1bee91050d1737a2039eb53d511aa5bc68d086a', '::1', 1600462960, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303436323936303b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d53394c324a304d796a4f566236336d4e7769676e576f5045444963655564513726747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2253394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f646966696564204269647321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('510d101110d2f45b77697982d07063d18e3dc0a8', '::1', 1600463041, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303436323936303b5f63695f70726576696f75735f75726c7c733a39383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d53394c324a304d796a4f566236336d4e7769676e576f5045444963655564513726747970653d626c6f67223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2253394c324a304d796a4f566236336d4e7769676e576f50454449636555645137223b),
('b2c9cbafb7f4b0624ae74d218522d194055e86bd', '::1', 1600509057, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303530393035373b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a36383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d73657474696e67253246657874656e73696f6e223b),
('65fe84f36fe711ee8c9f6718966b9d54cba46cb8', '::1', 1600548026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303534383032363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d4471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b),
('0516840fddee72543ce19b791fc3fc392edb5777', '::1', 1600550281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303535303238313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d4471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b),
('6d7d558a0f963faf8a880eac92e7726a2795e762', '::1', 1600550288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303535303238313b5f63695f70726576696f75735f75726c7c733a38343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f62616e6e65723f757365725f746f6b656e3d4471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224471744e6f6e79426245774349415a69504f4755656c4c78366a753773575834223b),
('7baf733a8d081c1bd4b74df2880bb6b8448c15aa', '::1', 1600609669, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303630393635343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d644c4f7a73684b32417631536f6d456b507772695878386a6166716c3757526e223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22644c4f7a73684b32417631536f6d456b507772695878386a6166716c3757526e223b),
('92e7e884a71cffaa1d0eacf23ed4ecb01ec5ba72', '::1', 1600635453, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303633353435333b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f696e666f726d6174696f6e3f757365725f746f6b656e3d566a336b5a736331424a45504b7861486e6c5153324f553666755939414e4474223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22566a336b5a736331424a45504b7861486e6c5153324f553666755939414e4474223b737563636573737c733a33303a22596f752068617665206d6f64696669656420696e666f726d6174696f6e21223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('96b2cfa5f342ced7a01ec4cbb63dd5926fea7b6f', '::1', 1600635759, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303633353735393b5f63695f70726576696f75735f75726c7c733a3131323a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f696e666f726d6174696f6e2f656469743f757365725f746f6b656e3d566a336b5a736331424a45504b7861486e6c5153324f553666755939414e447426696e666f726d6174696f6e5f69643d32223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22566a336b5a736331424a45504b7861486e6c5153324f553666755939414e4474223b),
('175c61a18b2f14401fe393868721123e18227f21', '::1', 1600635801, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303633353735393b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f696e666f726d6174696f6e3f757365725f746f6b656e3d566a336b5a736331424a45504b7861486e6c5153324f553666755939414e4474223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22566a336b5a736331424a45504b7861486e6c5153324f553666755939414e4474223b737563636573737c733a33303a22596f752068617665206d6f64696669656420696e666f726d6174696f6e21223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('4e35b733a9f7604ae9853104b1fe488597b07e78', '::1', 1600676582, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303637363538323b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d636174616c6f67253246696e666f726d6174696f6e223b),
('72cf791a839aba33ec49c186556d327362883fbc', '::1', 1600682594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303638323539343b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('df4c641cc5a77857e96d2149102b3bb05e9d1900', '::1', 1600720987, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303732303938363b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('fab706dd5bab5baba176a541f6051dc9de545580', '::1', 1600794819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739343831393b5f63695f70726576696f75735f75726c7c733a37303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d636174616c6f67253246696e666f726d6174696f6e223b),
('26ad797eae88075c26c78e45e4fb96b217d45b4f', '::1', 1600795183, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739353138333b5f63695f70726576696f75735f75726c7c733a39303a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f696e666f726d6174696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('67b26db7d8b76552e00ef6024d8cfe25a4cfa936', '::1', 1600795533, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739353533333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f6269642f6269643f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('738305d08716e30960c7ccddf0e874ee543c9250', '::1', 1600796102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739363130323b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f6d6f64756c652f63617465676f72793f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('5ccc6d482f921bd7d39508480f1eeb696a58e0a6', '::1', 1600796457, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739363435373b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f6d6f64756c652f63617465676f72793f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('a5485d03f4d3abf2a07ca46d0c19cc6694837c5f', '::1', 1600796764, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739363736343b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('81d87ac16254d03fce29bff205c46d8f090d2172', '::1', 1600797122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739373132323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('5c68e166025116bb3e04982513f7973348929642', '::1', 1600797444, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739373434343b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e2f6765744c6973743f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('fe7f89b4f6cc98f0018dbd1918e7c46ef4af7418', '::1', 1600797824, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739373832343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('859b4265ea5b4cd13a56709f663be34f556afd52', '::1', 1600798586, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739383538363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('f50c046c954e5ea2bad5471dea1846033526468d', '::1', 1600798926, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739383932363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('774b78c0c512d9f5f7c648617e7d347e7180ef0a', '::1', 1600799393, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739393339333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('69d3a5df54a19104e9d1997db0aaa156309ab343', '::1', 1600799744, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303739393734343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('f17df604f5e2b925c8dad00f31e2ce1e2cce1113', '::1', 1600800282, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830303238323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('b1ada330bc0ebaf451249cf7480276f4bb6e4e8f', '::1', 1600800598, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830303539383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('73bf5d620fb49a7861454128d5f0a414c5705ae5', '::1', 1600800954, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830303935343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('d323e9d42c3753bcc61e5d8aebd90da18095787b', '::1', 1600801257, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830313235373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('1e604eda1af29e3e7fdf743e1c53dc7c646a8892', '::1', 1600801592, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830313539323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('7fad57f9fd00e098fbe469f9333c41064cddecca', '::1', 1600802227, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830323232373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('007696e478b34a4c7a6bdafbafd83e63cfffd2d8', '::1', 1600802542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830323534323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('d36fce69fa9fb6f79d4de92e308e38a966a1f5a7', '::1', 1600802889, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830323838393b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('2615c692808b783dd66cdf6371fe8a57f2a5cb21', '::1', 1600803226, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830333232363b5f63695f70726576696f75735f75726c7c733a38393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f6269642f6269643f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('731425762b2306d7801689f8a33fe747cc02b6d2', '::1', 1600804092, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830343039323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('2deebf86d4d141cfea682611a77a3b3ef2906535', '::1', 1600804813, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830343831333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('4f2b9f496a859e6ab4db882bd98bb0d7e3206298', '::1', 1600805666, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830353636363b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('57ffbe1e92a841435681cb708eb40812a30d9aa1', '::1', 1600806027, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830363032373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('58c154622ba8b565ae6c8ada13b683a26ef6796c', '::1', 1600806857, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830363835373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('82d0275fe5669a9731aaed8c3afb46edd5bf2584', '::1', 1600807376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830373337363b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b69583126747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('1b5b4c59dedb08d7840f898bb71ca9e62473c6ce', '::1', 1600807694, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830373639343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('362b86b91c729dd05279a2080b887da70f450c15', '::1', 1600808054, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830383035343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b695831223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('7e107ba6f46640830e9e69fa267aa8b2537a936a', '::1', 1600808231, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303830383035343b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d575665556435443870636b5446497250616c76714e684f74673945754b69583126747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22575665556435443870636b5446497250616c76714e684f74673945754b695831223b),
('f85cf12b87ad7f7c50a146f3903cb0d4476f4a9d', '::1', 1600877099, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837363936333b5f63695f70726576696f75735f75726c7c733a35363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22745847634c51756f4a6267536c4b4571566150667770444e326b52484259696d223b),
('f587a420498b1cefeeb962260d65d2b4d5c65d82', '::1', 1600877838, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837373833383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('b833d2cc75105794df644f2eba6ed090e3b8626d', '::1', 1600878192, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837383139323b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('398c0c03a68ca22b51f7aad664e8469fed2329b5', '::1', 1600878531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837383533313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('07749c31218ceb0870f47bb7ef1cee9fdf19979c', '::1', 1600878887, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837383838373b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('aacc2978a77a38e98d63aba84a9b4fe45ed80b7b', '::1', 1600879359, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303837393335393b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('49415d76d9afd37bd9f5353abeb2da1648300720', '::1', 1600880534, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838303533343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('12f04768fa4fb3e3070203d9338b151a5106b058', '::1', 1600881005, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838313030353b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('d1c98e5c1ef18cb8b33020a4bf9db55ec0e426b5', '::1', 1600881390, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838313339303b5f63695f70726576696f75735f75726c7c733a38393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f6269642f6269643f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('32b46a03d1c4d3713f96f54a71bf6ad653b2adaa', '::1', 1600881733, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838313733333b5f63695f70726576696f75735f75726c7c733a38393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f6269642f6269643f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('6237f0d9ac610ba1066985092a039fdb17fe2063', '::1', 1600882074, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838323037343b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d6337546935786e36454971436c764c756f725a644b4e5032684633305862596b26747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('85761aabe4e8bfd51d07c1db605a564500de6f73', '::1', 1600882440, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838323434303b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('ff5eee1b7f77e6d41d2ed6ebaf095d7e881fab8b', '::1', 1600882755, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838323735353b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('b2ebc70174594f93580b708796f38a86f6e6b142', '::1', 1600883138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838333133383b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f6469666965642042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('0c72483c424ea6743547a608dd5b5e138fbaa04d', '::1', 1600883805, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838333830353b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a34333a22537563636573733a20596f752068617665206d6f6469666965642050726f6a6563742042696464696e6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('f607e626873aa311d470536df8f4168262534bd3', '::1', 1600884442, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838343434323b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('5a30db871913c6cc2ee90569d893670695532986', '::1', 1600884828, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838343832383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('248b2e8591417afb3d05a297d11d64d74d37c5fe', '::1', 1600885308, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838353330383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('ba4936d2401395f0b2160d742fbcf8afc6aa54b3', '::1', 1600885664, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838353636343b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('e4f6f74509622ae665a2c39364910b7390a90fa8', '::1', 1600886040, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838363034303b5f63695f70726576696f75735f75726c7c733a3131323a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f696e7374616c6c3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526657874656e73696f6e3d63617465676f7279223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('26f7fc6b368a8c061f3aa623893de0027fcb6154', '::1', 1600886611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838363631313b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('6f016340ba67dfb691edb0d7ae9a75bb6b8706e9', '::1', 1600887120, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838373132303b5f63695f70726576696f75735f75726c7c733a3131323a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f696e7374616c6c3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526657874656e73696f6e3d63617465676f7279223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('c1d76ab008fde19e75c6e7a999a459e2fd0fbb27', '::1', 1600887423, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838373432333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('2864a80c5d0771d833f39ffc9f049653dea6e463', '::1', 1600887825, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838373832353b5f63695f70726576696f75735f75726c7c733a3131323a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e2f626c6f672f696e7374616c6c3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b6130797526657874656e73696f6e3d63617465676f7279223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('b8d4fd492fcf86c87d2014c6a30c824ea82522d7', '::1', 1600888403, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838383430333b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f64696669656420426c6f6721223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('4dae0161b2ff9a0fbacd1bc019f6dbe88db82a44', '::1', 1600888805, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838383830353b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b),
('80c978daba70ddb53d44f84eacd425d6b600a030', '::1', 1600889618, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838393631383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a33323a22537563636573733a20596f752068617665206d6f646966696564204a6f627321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d);
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('21099284170d89132e9dfea7924e380832b90847', '::1', 1600889933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303838393933333b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f757365722f757365725f67726f75703f757365725f746f6b656e3d7062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a227062414d7a32553746483374355259474e696a6c434b6f536676456b61307975223b737563636573737c733a32393a22596f752068617665206d6f64696669656420757365722067726f757021223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('0e8509241f19524487144620a9dce95cb5b906e2', '::1', 1600891982, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839313938323b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('8e50c8d10ed72a1172e37d5c50ed121f42d69902', '::1', 1600893015, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839333031353b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73743f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b737563636573737c733a32393a22596f752068617665206d6f64696669656420626c6f6720706f73747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('0ab84a6fdcd93035289a759897b57d515a095d45', '::1', 1600893787, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839333738373b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73743f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b737563636573737c733a32393a22596f752068617665206d6f64696669656420626c6f6720706f73747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('73c6705a800c8b3adb58b0f18464e74ccc2743ca', '::1', 1600894123, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839343132333b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('986e675d36c1e94338456e4e5c0105ac4d7dc915', '::1', 1600894436, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839343433363b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('8a11f412d53d937d28886d062c1beecb97fdf402', '::1', 1600894901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839343930313b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('2836029760bd8a7a38b9437167ada21cbe30e0b9', '::1', 1600895202, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839353230323b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('e293f944db96c68c975fa0026efd9d5f0564cb3c', '::1', 1600895506, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839353530363b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('e0acdd0278fd945698f5c727fe2147f3b63c34ef', '::1', 1600897228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839373232383b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('92878e79cef3aa8582db557df8a3acd8b917b97a', '::1', 1600897228, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303839373232383b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('731d8601c480e367da4066b8714744d32e19cbd3', '::1', 1600969372, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303936393337323b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('0506a4ce6d83ff944ad44078c89051d04cd13709', '::1', 1600971695, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937313639353b5f63695f70726576696f75735f75726c7c733a39353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f657874656e73696f6e732f626c6f672f706f73742f6164643f757365725f746f6b656e3d696b4163736f6c4a485458394275454e445a7438797a7868614d773550535670223b),
('91cc7d701bb0894a14726e79a32bda0bfbe2a8f8', '::1', 1600972379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937323337393b5f63695f70726576696f75735f75726c7c733a35333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d223b),
('3232d9d4d800e93cd979e171314894958af3a55b', '::1', 1600972402, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937323337393b5f63695f70726576696f75735f75726c7c733a35363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d223b),
('87e46e551601a568e8d8172540acbad6fbc7bcef', '::1', 1600973128, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937333132383b5f63695f70726576696f75735f75726c7c733a35363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2265337177725a6a326335583770434d4e627479476c6e563036666d5376674538223b),
('56dda824ada091983f621ca1d8018a084939f358', '::1', 1600973438, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937333433383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d65337177725a6a326335583770434d4e627479476c6e563036666d5376674538223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2265337177725a6a326335583770434d4e627479476c6e563036666d5376674538223b),
('07dcb22f40439b81b04c0f11bae0a1b0caf6916c', '::1', 1600973779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937333737393b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f597226747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('87b5d069bae318d26132f9833f114f9daa4837d1', '::1', 1600974116, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937343131363b5f63695f70726576696f75735f75726c7c733a3130373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f757365722f757365725f67726f75702f656469743f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f597226757365725f67726f75705f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('53574bc42de1f98c69bde319dacf19206370f41d', '::1', 1600975032, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937353033323b5f63695f70726576696f75735f75726c7c733a3130373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f757365722f757365725f67726f75702f656469743f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f597226757365725f67726f75705f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('b320172b729df061b9c0b95eaa47abb1ca435c79', '::1', 1600975365, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937353336353b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f5972223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('ff6397e96a0c7de5d58561d5f37c22e5bb3c8cd3', '::1', 1600975692, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937353639323b5f63695f70726576696f75735f75726c7c733a39373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f657874656e73696f6e3f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f597226747970653d626964223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('524640db37d293d6072d81a1c931b3bd4e588566', '::1', 1600975721, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630303937353639323b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d69786e664b487437416b32636c305535545167704d43334c58794649524f5972223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2269786e664b487437416b32636c305535545167704d43334c58794649524f5972223b),
('c0c312481aee55d1281df1bdcdcbd8669f560617', '::1', 1601055396, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313035353339363b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('3ef6299e931f9ae61f17f792f64b3a9b09cbd204', '::1', 1601055698, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313035353639383b5f63695f70726576696f75735f75726c7c733a38383a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f637573746f6d65722f637573746f6d65723f757365725f746f6b656e3d673771335335775a644c574575793438396b557836496c484630545962504e4b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22673771335335775a644c574575793438396b557836496c484630545962504e4b223b),
('27ca425a6b13d5680b5860dc5eceb4954c2a879b', '::1', 1601056015, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313035363031353b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('8b8b9832fe0e77acf8a97af90b2ba01f9b8994f8', '::1', 1601056042, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313035363031353b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('a9cd6f371bae7d0d87aa56b38150ee417ebef5f4', '::1', 1601057336, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313035373333363b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('178b1c7e86bf0fb9622fe5248d057114ebc49943', '::1', 1601106771, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313130363737303b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('51dedb591cb35aae95a486c91237f627fea45e3f', '::1', 1601205425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313230353432353b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('46b16efea4fed1eda57f02dcce2ac5bf557aad57', '::1', 1601209315, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313230393331353b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b),
('e4409c411b1daa61fe854ef835907874cd174b33', '::1', 1601216424, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313231363432343b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636174616c6f672f63617465676f72792f6164643f757365725f746f6b656e3d466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b),
('add912c3df6e13efabbe429f6352442dadf10881', '::1', 1601216605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313231363432343b5f63695f70726576696f75735f75726c7c733a38363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f73657474696e672f73657474696e673f757365725f746f6b656e3d466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22466f3347456e364a516a3170696c57495450377864587377633539534e34525a223b),
('267a1493206697c404a34e7c0cd425bf1d50f7ef', '::1', 1601312772, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313331323737313b5f63695f70726576696f75735f75726c7c733a36363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d73657474696e6725324673657474696e67223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('f6fe0723ae3c419eaf7d48a4633a5c1bf286fa03', '::1', 1601393218, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630313339333231373b5f63695f70726576696f75735f75726c7c733a36363a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d73657474696e6725324673657474696e67223b);

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
(1, 0, 'config', 'config_meta_title', 'Freelancer', 0),
(2, 0, 'config', 'config_meta_description', 'Freelancer Site', 0),
(3, 0, 'config', 'config_meta_keyword', '', 0),
(4, 0, 'config', 'config_theme', 'default', 0),
(5, 0, 'config', 'config_logo', 'logo-1.svg', 0),
(6, 0, 'config', 'config_name', 'Your Site', 0),
(7, 0, 'config', 'config_owner', 'Ahmed Atwa', 0),
(8, 0, 'config', 'config_address', '6th Forrest Ray, London - 10001 UK', 0),
(9, 0, 'config', 'config_email', 'admin@admin.com', 0),
(10, 0, 'config', 'config_telephone', '+94 423-23-221', 0),
(11, 0, 'config', 'config_language_id', '1', 0),
(12, 0, 'config', 'config_admin_language_id', '1', 0),
(13, 0, 'config', 'config_currency', 'EGP', 0),
(14, 0, 'config', 'config_admin_limit', '20', 0),
(15, 0, 'config', 'config_login_attempts', '5', 0),
(16, 0, 'config', 'config_project_status_id', '7', 0),
(17, 0, 'config', 'config_customer_activity', '0', 0),
(18, 0, 'dashboard_activity', 'dashboard_activity_status', '1', 0),
(19, 0, 'dashboard_activity', 'dashboard_activity_width', '30', 0),
(20, 0, 'dashboard_activity', 'dashboard_activity_sort_order', '0', 0),
(21, 0, 'dashboard_online', 'dashboard_online_status', '1', 0),
(22, 0, 'dashboard_online', 'dashboard_online_width', '30', 0),
(23, 0, 'dashboard_online', 'dashboard_online_sort_order', '0', 0),
(43, 0, 'bidding_extension', 'bidding_extension_status', '1', 0),
(93, 0, 'blog_extension', 'blog_extension_status', '1', 0),
(95, 0, 'customer_wallet', 'customer_wallet_status', '1', 0),
(96, 0, 'job_extension', 'job_extension_status', '1', 0),
(97, 0, 'module_category', 'module_category_status', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_skills`
--

CREATE TABLE `ci_skills` (
  `skill_id` int(11) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_skills`
--

INSERT INTO `ci_skills` (`skill_id`, `text`) VALUES
(1, '2D Animation'),
(2, '360-degree video'),
(3, '3D Animation'),
(4, '3D Design'),
(5, '3D Model Maker'),
(6, '3D Modelling'),
(7, '3D Printing'),
(8, '3D Rendering'),
(9, '3ds Max'),
(10, '4D'),
(11, 'Academic Writing'),
(12, 'Account Management'),
(13, 'Accounting'),
(14, 'Acoustical Engineering'),
(15, 'ActionScript'),
(16, 'Active Directory'),
(17, 'Ad Planning & Buying'),
(18, 'ADO.NET'),
(19, 'Adobe Air'),
(20, 'Adobe Captivate'),
(21, 'Adobe Dreamweaver'),
(22, 'Adobe Dynamic Tag Management'),
(23, 'Adobe Fireworks'),
(24, 'Adobe Flash'),
(25, 'Adobe Freehand'),
(26, 'Adobe Illustrator'),
(27, 'Adobe InDesign'),
(28, 'Adobe Lightroom'),
(29, 'Adobe LiveCycle Designer'),
(30, 'Adobe Muse'),
(31, 'Adobe Pagemaker'),
(32, 'Adobe Premiere Pro'),
(33, 'Advertisement Design'),
(34, 'Advertising'),
(35, 'Aeronautical Engineering'),
(36, 'Aerospace Engineering'),
(37, 'Affiliate Marketing'),
(38, 'Afrikaans'),
(39, 'After Effects'),
(40, 'Agile Development'),
(41, 'Agronomy'),
(42, 'AI (Artificial Intelligence) HW/SW'),
(43, 'AI/RPA development'),
(44, 'Airbnb'),
(45, 'Airtable'),
(46, 'AJAX'),
(47, 'Albanian'),
(48, 'Alerting'),
(49, 'Algorithm'),
(50, 'Alibaba'),
(51, 'Alteryx'),
(52, 'Amazon App Development'),
(53, 'Amazon Fire'),
(54, 'Amazon Kindle'),
(55, 'Amazon Web Services'),
(56, 'Amibroker Formula Language'),
(57, 'AMQP'),
(58, 'Analog'),
(59, 'Analytics'),
(60, 'Analytics Sales'),
(61, 'Anaplan'),
(62, 'Andon'),
(63, 'Android'),
(64, 'Android Wear SDK'),
(65, 'Angular Material'),
(66, 'Angular.js'),
(67, 'Animated Video Development'),
(68, 'Animation'),
(69, 'Antenna Design'),
(70, 'Apache'),
(71, 'Apache Ant'),
(72, 'Apache Hadoop'),
(73, 'Apache Maven'),
(74, 'Apache Solr'),
(75, 'API'),
(76, 'App Designer'),
(77, 'App Developer'),
(78, 'Appcelerator Titanium'),
(79, 'Apple Compressor'),
(80, 'Apple Homekit'),
(81, 'Apple iBooks Author'),
(82, 'Apple Logic Pro'),
(83, 'Apple MFI'),
(84, 'Apple Motion'),
(85, 'Apple Safari'),
(86, 'Apple UIKit'),
(87, 'Apple Watch'),
(88, 'Apple Xcode'),
(89, 'Applescript'),
(90, 'Apttus'),
(91, 'Arabic'),
(92, 'Architectural Rendering'),
(93, 'ARCore'),
(94, 'Arduino'),
(95, 'Arena Simulation Programming'),
(96, 'Argus Monitoring Software'),
(97, 'Ariba'),
(98, 'ARKit'),
(99, 'ARM'),
(100, 'Armadillo'),
(101, 'Article Rewriting'),
(102, 'Article Submission'),
(103, 'Article Writing'),
(104, 'Articulate Storyline'),
(105, 'Artificial Intelligence'),
(106, 'Arts & Crafts'),
(107, 'AS400 & iSeries'),
(108, 'Asana'),
(109, 'ASIC'),
(110, 'ASM'),
(111, 'ASP'),
(112, 'ASP.NET'),
(113, 'Assembla'),
(114, 'Assembly'),
(115, 'Asterisk PBX'),
(116, 'Astrophysics'),
(117, 'Atlassian Confluence'),
(118, 'Atlassian Jira'),
(119, 'ATS Sales'),
(120, 'Attorney'),
(121, 'Audio Processing'),
(122, 'Audio Production'),
(123, 'Audio Services'),
(124, 'Audit'),
(125, 'Augmented Reality'),
(126, 'AutoCAD'),
(127, 'AutoCAD Architecture'),
(128, 'Autodesk Inventor'),
(129, 'Autodesk Revit'),
(130, 'Autodesk Sketchbook Pro'),
(131, 'AutoHotkey'),
(132, 'Automotive'),
(133, 'Autotask'),
(134, 'Aws Lambda'),
(135, 'Axure'),
(136, 'Azure'),
(137, 'backbone.js'),
(138, 'Backend Development'),
(139, 'Balsamiq'),
(140, 'Banner Design'),
(141, 'Bare Metal'),
(142, 'Bash Scripting'),
(143, 'Basque'),
(144, 'Battery Charging and Batteries'),
(145, 'BeagleBone Black'),
(146, 'BeautifulSoup'),
(147, 'Bengali'),
(148, 'Bicycle Courier'),
(149, 'Big Data Sales'),
(150, 'BigCommerce'),
(151, 'Bill of Materials (BOM) Analysis'),
(152, 'Bill of Materials (BOM) Evaluation'),
(153, 'Bill of Materials (BOM) Management'),
(154, 'Bill of Materials (BOM) Optimization'),
(155, 'Bill of Materials (BOM) Re-Engineering'),
(156, 'Binary Analysis'),
(157, 'Biology'),
(158, 'Biotechnology'),
(159, 'BIRT Development'),
(160, 'Bitcoin'),
(161, 'Biztalk'),
(162, 'Blackberry'),
(163, 'Blender'),
(164, 'Blockchain'),
(165, 'Blog'),
(166, 'Blog Design'),
(167, 'Blog Install'),
(168, 'Blog Writing'),
(169, 'Bluetooth'),
(170, 'Bluetooth Low Energy (BLE)'),
(171, 'Bluetooth Module'),
(172, 'BMC Remedy'),
(173, 'Board Support Package (BSP)'),
(174, 'Book Artist'),
(175, 'Book Writing'),
(176, 'Bookkeeping'),
(177, 'Boonex Dolphin'),
(178, 'Boost'),
(179, 'Bootstrap'),
(180, 'Bosnian'),
(181, 'Bower'),
(182, 'BPO'),
(183, 'Brain Storming'),
(184, 'Brand Management'),
(185, 'Brand Marketing'),
(186, 'Branding'),
(187, 'Broadcast Engineering'),
(188, 'Brochure Design'),
(189, 'BSD'),
(190, 'Bubble Developer'),
(191, 'Building Architecture'),
(192, 'Bulgarian'),
(193, 'Bulk Marketing'),
(194, 'Business Analysis'),
(195, 'Business Analytics'),
(196, 'Business Card Design'),
(197, 'Business Cards'),
(198, 'Business Catalyst'),
(199, 'Business Coaching'),
(200, 'Business Intelligence'),
(201, 'Business Plans'),
(202, 'Business Requirement Documentation'),
(203, 'Business Strategy'),
(204, 'Business Writing'),
(205, 'Buyer Sourcing'),
(206, 'C Programming'),
(207, 'C# Programming'),
(208, 'C++ Programming'),
(209, 'CAD/CAM'),
(210, 'CakePHP'),
(211, 'Calculus'),
(212, 'Call Center'),
(213, 'Call Control XML'),
(214, 'Camtasia'),
(215, 'Capture NX2'),
(216, 'Car Courier'),
(217, 'Car Driving'),
(218, 'Care Management'),
(219, 'Cargo Freight'),
(220, 'Caricature & Cartoons'),
(221, 'Carthage'),
(222, 'Cartography & Maps'),
(223, 'CasperJS'),
(224, 'Cassandra'),
(225, 'Catalan'),
(226, 'Catch Phrases'),
(227, 'CATIA'),
(228, 'Cellular Design'),
(229, 'Cellular Modules'),
(230, 'CentOs'),
(231, 'Certified Public Accountant'),
(232, 'CGI'),
(233, 'Channel Account Management'),
(234, 'Channel Sales'),
(235, 'Charts'),
(236, 'Chef Configuration Management'),
(237, 'Chemical Engineering'),
(238, 'Chordiant'),
(239, 'Christmas'),
(240, 'Chrome OS'),
(241, 'Cinema 4D'),
(242, 'Cinematography'),
(243, 'CircleCI'),
(244, 'Circuit Board Layout'),
(245, 'Circuit Design'),
(246, 'Cisco'),
(247, 'Civil Engineering'),
(248, 'Classifieds Posting'),
(249, 'Clean Technology'),
(250, 'Climate Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `ci_university`
--

CREATE TABLE `ci_university` (
  `university_id` int(11) NOT NULL,
  `country` varchar(64) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_university`
--

INSERT INTO `ci_university` (`university_id`, `country`, `text`) VALUES
(1, 'Egypt', 'Ain Shams University'),
(2, 'Egypt', 'Alamein University'),
(3, 'Egypt', 'Al-Azhar University'),
(4, 'Egypt', 'Alexandria University'),
(5, 'Egypt', 'Assiut University'),
(6, 'Egypt', 'Aswan University'),
(7, 'Egypt', 'Benha University'),
(8, 'Egypt', 'Beni-Suef University'),
(9, 'Egypt', 'Cairo University'),
(10, 'Egypt', 'Damanhour University'),
(11, 'Egypt', 'Damietta University'),
(12, 'Egypt', 'Delta University for Science and Technology'),
(13, 'Egypt', 'Egyptian Russian University'),
(14, 'Egypt', 'Egypt-Japan University of Science and Technology'),
(15, 'Egypt', 'Fayoum University'),
(16, 'Egypt', 'Future University in Egypt'),
(17, 'Egypt', 'Helwan University'),
(18, 'Egypt', 'Kafrelsheikh University'),
(19, 'Egypt', 'Mansoura University'),
(20, 'Egypt', 'Menoufia University'),
(21, 'Egypt', 'Minia University'),
(22, 'Egypt', 'Misr International University'),
(23, 'Egypt', 'Misr University for Science and Technology'),
(24, 'Egypt', 'Modern Sciences and Arts University'),
(25, 'Egypt', 'Nahda University'),
(26, 'Egypt', 'Nile University'),
(27, 'Egypt', 'October 6 University'),
(28, 'Egypt', 'Pharos University in Alexandria'),
(29, 'Egypt', 'Port Said University'),
(30, 'Egypt', 'Sinai University'),
(31, 'Egypt', 'Sohag university'),
(32, 'Egypt', 'South Valley University'),
(33, 'Egypt', 'Suez Canal University'),
(34, 'Egypt', 'Suez University'),
(35, 'Egypt', 'Tanta University'),
(36, 'Egypt', 'The American University in Cairo'),
(37, 'Egypt', 'The British University in Egypt'),
(38, 'Egypt', 'The German University in Cairo'),
(39, 'Egypt', 'Université Française d\'Égypte'),
(40, 'Egypt', 'University of Sadat City'),
(41, 'Egypt', 'University of Science and Technology at Zewail City'),
(42, 'Egypt', 'Zagazig University'),
(43, 'Saudi Arabia', 'Al Baha University'),
(44, 'Saudi Arabia', 'Al Jouf University'),
(45, 'Saudi Arabia', 'Al Yamamah University'),
(46, 'Saudi Arabia', 'Alfaisal University'),
(47, 'Saudi Arabia', 'Al-Imam Muhammad Ibn Saud Islamic University'),
(48, 'Saudi Arabia', 'Dar Al Uloom University'),
(49, 'Saudi Arabia', 'Dar Al-Hekma University'),
(50, 'Saudi Arabia', 'Effat University'),
(51, 'Saudi Arabia', 'Fahad Bin Sultan University'),
(52, 'Saudi Arabia', 'Imam Abdulrahman Bin Faisal University'),
(53, 'Saudi Arabia', 'Institute of Public Administration, Saudi Arabia'),
(54, 'Saudi Arabia', 'Islamic University of Madinah'),
(55, 'Saudi Arabia', 'Jazan University'),
(56, 'Saudi Arabia', 'King AbdulAziz University'),
(57, 'Saudi Arabia', 'King Abdullah University of Science and Technology'),
(58, 'Saudi Arabia', 'King Fahd University of Petroleum and Minerals'),
(59, 'Saudi Arabia', 'King Faisal University'),
(60, 'Saudi Arabia', 'King Khalid University'),
(61, 'Saudi Arabia', 'King Saud bin Abdulaziz University for Health Sciences'),
(62, 'Saudi Arabia', 'King Saud University'),
(63, 'Saudi Arabia', 'Majmaah University'),
(64, 'Saudi Arabia', 'Najran University'),
(65, 'Saudi Arabia', 'Northern Borders University'),
(66, 'Saudi Arabia', 'Prince Mohammad Bin Fahd University'),
(67, 'Saudi Arabia', 'Prince Sattam Bin Abdulaziz University'),
(68, 'Saudi Arabia', 'Prince Sultan University'),
(69, 'Saudi Arabia', 'Princess Nora bint Abdulrahman University'),
(70, 'Saudi Arabia', 'Qassim University'),
(71, 'Saudi Arabia', 'Shaqra University'),
(72, 'Saudi Arabia', 'Taibah University'),
(73, 'Saudi Arabia', 'Taif University'),
(74, 'Saudi Arabia', 'Umm Al-Qura University'),
(75, 'Saudi Arabia', 'University of Bisha'),
(76, 'Saudi Arabia', 'University of Business and Technology'),
(77, 'Saudi Arabia', 'University of Hafr Al Batin'),
(78, 'Saudi Arabia', 'University of Ha\'il'),
(79, 'Saudi Arabia', 'University of Jeddah'),
(80, 'Saudi Arabia', 'University of Tabuk'),
(81, 'United Arab Emirates', 'Abu Dhabi Polytechnic'),
(82, 'United Arab Emirates', 'Abu Dhabi School of Management'),
(83, 'United Arab Emirates', 'Abu Dhabi University'),
(84, 'United Arab Emirates', 'Ajman University'),
(85, 'United Arab Emirates', 'Al Ain University of Science and Technology'),
(86, 'United Arab Emirates', 'Al Dar University College'),
(87, 'United Arab Emirates', 'Al Falah University'),
(88, 'United Arab Emirates', 'Al Ghurair University'),
(89, 'United Arab Emirates', 'Al Qasimia University'),
(90, 'United Arab Emirates', 'American College of Dubai'),
(91, 'United Arab Emirates', 'American University in Dubai'),
(92, 'United Arab Emirates', 'American University in the Emirates'),
(93, 'United Arab Emirates', 'American University of Ras Al Khaimah'),
(94, 'United Arab Emirates', 'American University of Sharjah'),
(95, 'United Arab Emirates', 'Amity University Dubai'),
(96, 'United Arab Emirates', 'Canadian University of Dubai'),
(97, 'United Arab Emirates', 'City University College of Ajman'),
(98, 'United Arab Emirates', 'College of Islamic and Arabic Studies'),
(99, 'United Arab Emirates', 'Dubai Medical College'),
(100, 'United Arab Emirates', 'Dubai Pharmacy College'),
(101, 'United Arab Emirates', 'Emirates Aviation University'),
(102, 'United Arab Emirates', 'Emirates Canadian University College'),
(103, 'United Arab Emirates', 'Emirates College for Advanced Education'),
(104, 'United Arab Emirates', 'Emirates College of Technology'),
(105, 'United Arab Emirates', 'Emirates Institute for Banking and Financial Studies'),
(106, 'United Arab Emirates', 'European International College'),
(107, 'United Arab Emirates', 'European University College'),
(108, 'United Arab Emirates', 'Fatima College of Health Sciences'),
(109, 'United Arab Emirates', 'Gulf Medical University'),
(110, 'United Arab Emirates', 'Higher Colleges of Technology'),
(111, 'United Arab Emirates', 'Imam Malik College for Islamic Sharia and Law'),
(112, 'United Arab Emirates', 'Institute of Management Technology Dubai'),
(113, 'United Arab Emirates', 'Islamic Azad University U.A.E. Branch'),
(114, 'United Arab Emirates', 'Jumeira University'),
(115, 'United Arab Emirates', 'Khalifa University'),
(116, 'United Arab Emirates', 'Khawarizmi International College'),
(117, 'United Arab Emirates', 'Maktoum Bin Hamdan Dental University College'),
(118, 'United Arab Emirates', 'Manipal University, Dubai'),
(119, 'United Arab Emirates', 'MENA College of Management'),
(120, 'United Arab Emirates', 'Middlesex University Dubai'),
(121, 'United Arab Emirates', 'MODUL University Dubai'),
(122, 'United Arab Emirates', 'Mohammed Bin Rashid School of Government'),
(123, 'United Arab Emirates', 'Mohammed Bin Rashid University of Medicine and Health Sciences'),
(124, 'United Arab Emirates', 'Mohammed V University Abu Dhabi'),
(125, 'United Arab Emirates', 'Murdoch University Dubai'),
(126, 'United Arab Emirates', 'New York Institute of Technology Abu Dhabi'),
(127, 'United Arab Emirates', 'New York University Abu Dhabi'),
(128, 'United Arab Emirates', 'Ras al-Khaimah Medical and Health Sciences University'),
(129, 'United Arab Emirates', 'Rochester Institute of Technology, Dubai'),
(130, 'United Arab Emirates', 'Royal College of Surgeons in Ireland-Dubai'),
(131, 'United Arab Emirates', 'Shaheed Zulfikar Ali Bhutto Institute of Science and Technology '),
(132, 'United Arab Emirates', 'Skyline University College'),
(133, 'United Arab Emirates', 'The British University in Dubai'),
(134, 'United Arab Emirates', 'The College of Fashion and Design'),
(135, 'United Arab Emirates', 'The Emirates Academy of Hospitality Management'),
(136, 'United Arab Emirates', 'United Arab Emirates University'),
(137, 'United Arab Emirates', 'Université Paris-Sorbonne Abou Dhabi'),
(138, 'United Arab Emirates', 'Université Saint-Joseph de Dubai'),
(139, 'United Arab Emirates', 'University College of Mother and Family Sciences'),
(140, 'United Arab Emirates', 'University of Dubai'),
(141, 'United Arab Emirates', 'University of Fujairah'),
(142, 'United Arab Emirates', 'University of Sharjah'),
(143, 'United Arab Emirates', 'University of Wollongong in Dubai'),
(144, 'United Arab Emirates', 'Zayed University'),
(145, 'Lebanon', 'Al Imam Al-Ouzai University'),
(146, 'Lebanon', 'American University of Beirut'),
(147, 'Lebanon', 'American University of Culture and Education'),
(148, 'Lebanon', 'American University of Science and Technology'),
(149, 'Lebanon', 'American University of Technology'),
(150, 'Lebanon', 'Arab Open University Lebanon'),
(151, 'Lebanon', 'Arts, Sciences and Technology University in Lebanon'),
(152, 'Lebanon', 'Beirut Arab University'),
(153, 'Lebanon', 'Beirut Islamic University'),
(154, 'Lebanon', 'City University'),
(155, 'Lebanon', 'École Supérieure des Affaires'),
(156, 'Lebanon', 'Global University'),
(157, 'Lebanon', 'Haigazian University'),
(158, 'Lebanon', 'Islamic University of Lebanon'),
(159, 'Lebanon', 'Jinan University of Lebanon'),
(160, 'Lebanon', 'Lebanese American University'),
(161, 'Lebanon', 'Lebanese German University'),
(162, 'Lebanon', 'Lebanese International University'),
(163, 'Lebanon', 'Makassed University of Beirut'),
(164, 'Lebanon', 'Matn University College of Technology'),
(165, 'Lebanon', 'Middle East University'),
(166, 'Lebanon', 'Modern University for Business and Science'),
(167, 'Lebanon', 'Notre Dame University'),
(168, 'Lebanon', 'Rafik Hariri University'),
(169, 'Lebanon', 'Université Al-Kafaat'),
(170, 'Lebanon', 'Université Antonine'),
(171, 'Lebanon', 'Université du Tripoli'),
(172, 'Lebanon', 'Université la Sagesse'),
(173, 'Lebanon', 'Université Libanaise'),
(174, 'Lebanon', 'Université Libano-Canadienne'),
(175, 'Lebanon', 'Université Libano-Française de Technologie et de Sciences Appliq'),
(176, 'Lebanon', 'Université Sainte Famille'),
(177, 'Lebanon', 'Université Saint-Esprit de Kaslik'),
(178, 'Lebanon', 'Université Saint-Joseph de Beyrouth'),
(179, 'Lebanon', 'University of Balamand'),
(180, 'Oman', 'Al Musanna College of Technology'),
(181, 'Oman', 'Al Sharqiyah University'),
(182, 'Oman', 'Al-Buraimi University College'),
(183, 'Oman', 'Al-Zahra College for Women'),
(184, 'Oman', 'Bayan College'),
(185, 'Oman', 'Caledonian College of Engineering'),
(186, 'Oman', 'College of Applied Sciences, Ibri'),
(187, 'Oman', 'College of Applied Sciences, Nizwa'),
(188, 'Oman', 'College of Applied Sciences, Salalah'),
(189, 'Oman', 'College of Applied Sciences, Sohar'),
(190, 'Oman', 'College of Applied Sciences, Sur'),
(191, 'Oman', 'College of Banking and Financial Studies'),
(192, 'Oman', 'College of Shari\'a Sciences'),
(193, 'Oman', 'Dhofar University'),
(194, 'Oman', 'German University of Technology in Oman'),
(195, 'Oman', 'Global College of Engineering and Technology'),
(196, 'Oman', 'Gulf College'),
(197, 'Oman', 'Higher College of Technology'),
(198, 'Oman', 'Ibra College of Technology'),
(199, 'Oman', 'Ibri College of Technology'),
(200, 'Oman', 'International Maritime College Oman'),
(201, 'Oman', 'Majan University College'),
(202, 'Oman', 'Mazoon University College'),
(203, 'Oman', 'Middle East College'),
(204, 'Oman', 'Modern College of Business and Science'),
(205, 'Oman', 'Muscat College'),
(206, 'Oman', 'Nizwa College of Technology'),
(207, 'Oman', 'Oman College of Management and Technology'),
(208, 'Oman', 'Oman Dental College'),
(209, 'Oman', 'Oman Medical College'),
(210, 'Oman', 'Oman Tourism College'),
(211, 'Oman', 'Rustaq College of Education'),
(212, 'Oman', 'Salalah College of Technology'),
(213, 'Oman', 'Scientific College of Design'),
(214, 'Oman', 'Shinas College of Technology'),
(215, 'Oman', 'Sohar University'),
(216, 'Oman', 'Sultan Qaboos University'),
(217, 'Oman', 'Sur University College'),
(218, 'Oman', 'The University of Nizwa'),
(219, 'Oman', 'University of Buraimi'),
(220, 'Oman', 'Waljat Colleges of Applied Sciences'),
(221, 'Kuwait', 'American University of Kuwait'),
(222, 'Kuwait', 'Australian College of Kuwait'),
(223, 'Kuwait', 'Gulf University for Science and Technology'),
(224, 'Kuwait', 'Kuwait University'),
(225, 'Kuwait', 'Maastricht School of Management Kuwait'),
(226, 'Qatar', 'Qatar University'),
(227, 'Qatar', 'Hamad Bin Khalifa University'),
(228, 'Qatar', 'Weill Cornell Medicine - Qatar'),
(229, 'Qatar', 'College of the North Atlantic - Qatar'),
(230, 'Qatar', 'Doha Institute for Graduate Studies'),
(231, 'Qatar', 'University of Calgary in Qatar'),
(232, 'Qatar', 'Carnegie Mellon University in Qatar'),
(233, 'Qatar', 'Georgetown University in Qatar'),
(234, 'Qatar', 'Virginia Commonwealth University School of the Arts in Qatar'),
(235, 'Qatar', 'Texas A&M University at Qatar'),
(236, 'Qatar', 'Northwestern University in Qatar'),
(237, 'Qatar', 'HEC Paris in Qatar'),
(238, 'Qatar', 'University College London Qatar'),
(239, 'Bahrain', 'Ahlia University'),
(240, 'Bahrain', 'AMA International University Bahrain'),
(241, 'Bahrain', 'Applied Science University'),
(242, 'Bahrain', 'Arabian Gulf University'),
(243, 'Bahrain', 'Bahrain Institute for Banking and Finance'),
(244, 'Bahrain', 'Gulf University'),
(245, 'Bahrain', 'Kingdom University'),
(246, 'Bahrain', 'Royal College of Surgeons in Ireland - Medical University of Bah'),
(247, 'Bahrain', 'Royal University for Women'),
(248, 'Bahrain', 'Talal Abu-Ghazaleh University College of Business'),
(249, 'Bahrain', 'University College of Bahrain'),
(250, 'Bahrain', 'University of Bahrain');

-- --------------------------------------------------------

--
-- Table structure for table `ci_upload`
--

CREATE TABLE `ci_upload` (
  `upload_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `url` varchar(128) CHARACTER SET latin1 NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(1, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-12 09:56:39'),
(2, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-13 19:03:22'),
(3, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-16 21:17:45'),
(4, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-18 21:31:55'),
(5, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-20 14:47:41'),
(6, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:04:45'),
(7, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:08:28'),
(8, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:09:25'),
(9, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:09:46'),
(10, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:10:21'),
(11, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-23 17:12:20'),
(12, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-24 19:33:38'),
(13, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-25 18:36:36'),
(14, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 OPR/70.0.3728.178', '2020-09-27 12:17:05');

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
(1, 'Admin', '{\"access\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/theme\",\"extension\\/wallet\",\"localisation\\/language\",\"localisation\\/project_status\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\",\"module\\/category\"],\"modify\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/theme\",\"extension\\/wallet\",\"localisation\\/language\",\"localisation\\/project_status\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\",\"module\\/category\"]}', '2020-08-07 11:33:45', '2020-09-23 20:38:04');

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

-- --------------------------------------------------------

--
-- Table structure for table `ci_wallet`
--
-- Error reading structure for table ci4.ci_wallet: #1932 - Table 'ci4.ci_wallet' doesn't exist in engine
-- Error reading data for table ci4.ci_wallet: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'FROM `ci4`.`ci_wallet`' at line 1

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
-- Indexes for table `ci_customer_to_certificate`
--
ALTER TABLE `ci_customer_to_certificate`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `ci_customer_to_education`
--
ALTER TABLE `ci_customer_to_education`
  ADD PRIMARY KEY (`education_id`);

--
-- Indexes for table `ci_customer_to_language`
--
ALTER TABLE `ci_customer_to_language`
  ADD PRIMARY KEY (`language_id`,`freelancer_id`) USING BTREE,
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `ci_customer_to_skill`
--
ALTER TABLE `ci_customer_to_skill`
  ADD PRIMARY KEY (`skill_id`,`freelancer_id`);

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
  ADD PRIMARY KEY (`project_review_id`),
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
-- Indexes for table `ci_project_to_skill`
--
ALTER TABLE `ci_project_to_skill`
  ADD PRIMARY KEY (`project_id`,`skill_id`),
  ADD KEY `category_id` (`skill_id`);

--
-- Indexes for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  ADD PRIMARY KEY (`seo_url_id`),
  ADD KEY `query` (`query`),
  ADD KEY `keyword` (`keyword`);

--
-- Indexes for table `ci_setting`
--
ALTER TABLE `ci_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `ci_upload`
--
ALTER TABLE `ci_upload`
  ADD PRIMARY KEY (`upload_id`);

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
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_blog_post_to_commet`
--
ALTER TABLE `ci_blog_post_to_commet`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_customer`
--
ALTER TABLE `ci_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  MODIFY `customer_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `customer_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ci_customer_review`
--
ALTER TABLE `ci_customer_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_customer_to_certificate`
--
ALTER TABLE `ci_customer_to_certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ci_customer_to_education`
--
ALTER TABLE `ci_customer_to_education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_event`
--
ALTER TABLE `ci_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ci_extension`
--
ALTER TABLE `ci_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `ci_information`
--
ALTER TABLE `ci_information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `ci_project_review`
--
ALTER TABLE `ci_project_review`
  MODIFY `project_review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  MODIFY `project_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  MODIFY `seo_url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `ci_upload`
--
ALTER TABLE `ci_upload`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ci_user_login`
--
ALTER TABLE `ci_user_login`
  MODIFY `user_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

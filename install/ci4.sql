-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2020 at 10:33 PM
-- Server version: 5.7.23
-- PHP Version: 7.3.25

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
(2, 'Home Page Slide Show', 1);

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
  `sort_order` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_banner_image`
--

INSERT INTO `ci_banner_image` (`banner_image_id`, `banner_id`, `language_id`, `title`, `link`, `image`, `sort_order`) VALUES
(18, 2, 1, 'test', '', 'catalog/demo/image1.jpg', 0),
(17, 2, 1, 'test', '', 'catalog/demo/banners/detail.jpg', 0);

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
(1, 'General', 1);

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
(1, 0, 1, 'Sample Blog Post', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\">', '', '', 0, 0, 1, '2020-12-24 20:44:19', '2020-12-24 21:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post_to_comment`
--

CREATE TABLE `ci_blog_post_to_comment` (
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
-- Dumping data for table `ci_blog_post_to_comment`
--

INSERT INTO `ci_blog_post_to_comment` (`comment_id`, `post_id`, `name`, `email`, `website`, `comment`, `status`, `date_added`) VALUES
(1, 1, 'sssssss', 'ssss@fff.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2020-09-24 18:49:27'),
(2, 1, 'sssssss', 'ssss@fff.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2020-09-24 18:49:27'),
(3, 1, 'test', 'customer_3@demo.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2020-12-25 12:33:47'),
(4, 1, 'YallaHelp', 'customer_3@demo.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, '2020-12-25 12:34:27');

-- --------------------------------------------------------

--
-- Table structure for table `ci_category`
--

CREATE TABLE `ci_category` (
  `category_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(250) NOT NULL,
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category`
--

INSERT INTO `ci_category` (`category_id`, `parent_id`, `icon`, `top`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 0, 'fas fa-laptop-code', 0, 0, 1, '2020-10-19 12:42:10', '2020-11-19 11:27:27'),
(2, 0, 'fas fa-mobile-alt', 0, 0, 1, '2020-10-19 12:42:29', '2020-10-19 13:32:54'),
(3, 0, 'fas fa-chalkboard-teacher', 0, 0, 1, '2020-10-19 12:42:41', '2020-10-19 13:26:39'),
(4, 0, 'fas fa-palette', 0, 0, 1, '2020-10-19 12:42:56', '2020-10-19 13:34:34'),
(5, 0, 'fas fa-server', 0, 0, 1, '2020-10-19 12:43:15', '2020-10-19 13:36:19'),
(6, 0, 'fas fa-flask', 0, 0, 1, '2020-10-19 12:43:37', '2020-10-19 13:35:10'),
(7, 0, 'fas fa-industry', 0, 0, 1, '2020-10-19 12:44:16', '2020-10-19 13:39:31'),
(8, 0, 'fas fa-ad', 0, 0, 1, '2020-10-19 12:44:32', '2020-10-19 13:32:19'),
(9, 0, 'fas fa-dolly', 0, 0, 1, '2020-10-19 12:44:51', '2020-10-19 13:33:56'),
(10, 0, 'fas fa-laptop-code', 0, 0, 1, '2020-10-19 12:45:06', '2020-11-16 16:20:43'),
(11, 0, 'fas fa-language', 0, 0, 1, '2020-10-19 12:45:18', '2020-10-19 13:31:31'),
(12, 0, 'fas fa-map-pin', 0, 0, 1, '2020-10-19 12:45:33', '2020-10-19 13:37:16'),
(14, 0, 'fas fa-laptop-code', 0, 0, 1, '2020-10-19 13:41:29', '0000-00-00 00:00:00'),
(15, 1, 'fas fa-laptop-code', 0, 0, 1, '2020-10-19 13:45:18', '2020-10-19 14:06:20'),
(16, 1, '', 0, 0, 1, '2020-10-19 14:06:56', '0000-00-00 00:00:00'),
(21, 1, '', 0, 0, 1, '2020-11-09 08:44:09', '0000-00-00 00:00:00'),
(20, 1, '', 0, 0, 1, '2020-11-09 08:43:47', '0000-00-00 00:00:00'),
(22, 1, '', 0, 0, 1, '2020-11-09 08:44:38', '0000-00-00 00:00:00'),
(23, 1, '', 0, 0, 1, '2020-11-09 08:45:00', '0000-00-00 00:00:00'),
(24, 1, '', 0, 0, 1, '2020-11-09 08:45:23', '0000-00-00 00:00:00'),
(25, 1, '', 0, 0, 1, '2020-11-09 08:45:43', '0000-00-00 00:00:00'),
(26, 1, '', 0, 0, 1, '2020-11-09 08:46:03', '0000-00-00 00:00:00'),
(27, 1, '', 0, 0, 1, '2020-11-09 08:46:43', '0000-00-00 00:00:00');

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
(1, 1, 'Websites, IT & Software', 'PHP, HTML, WordPress, JavaScript, Software Architecture...', 'Websites, IT & Software', '', ''),
(2, 1, 'Mobile Phones & Computing', 'Mobile App Development, Android, iPhone, iPad, Kotlin...', 'Mobile Phones & Computing', '', ''),
(3, 1, 'Writing & Content', 'Article Writing, Content Writing, Copywriting, Article Rewriting, Research Writing...', 'Writing & Content', '', ''),
(4, 1, 'Design, Media & Architecture', 'Website Design, Graphic Design, Photoshop, CSS, Logo Design...', 'Design, Media & Architecture', '', ''),
(5, 1, 'Data Entry & Admin', 'Data Entry, Excel, Data Processing, Web Search, Virtual Assistant...', 'Data Entry & Admin', '', ''),
(6, 1, 'Engineering & Science', 'Engineering, Electrical Engineering, Electronics, Machine Learning (ML), AutoCAD...', 'Engineering & Science', '', ''),
(7, 1, 'Product Sourcing & Manufacturing', 'Product Design, Supplier Sourcing, Amazon, Product Sourcing, Process Automation...', 'Product Sourcing & Manufacturing', '', ''),
(8, 1, 'Sales & Marketing', 'Internet Marketing, Marketing, Social Media Marketing, Facebook Marketing, Sales...', 'Sales & Marketing', '', ''),
(9, 1, 'Freight, Shipping & Transportation', 'Parcel Delivery, Delivery, Logistics, Dropshipping, Moving...', 'Freight, Shipping & Transportation', '', ''),
(10, 1, 'Business, Accounting, Human Resources & Legal', 'Accounting, Business Analysis, Finance, Business Plans, Project Management...', 'Business, Accounting, Human Resources & Legal', '', ''),
(11, 1, 'Translation & Languages', 'English (US), English (UK), English Grammar, Spanish, German...', 'Translation & Languages', '', ''),
(12, 1, 'Local Jobs & Services', 'Local Job, General Labor, Teaching/Lecturing, Drafting, Computer Support...', 'Local Jobs & Services', '', ''),
(14, 1, 'Other', '<p>Anything Goes, Appointment Setting, Freelance, Fitness, Computational Fluid Dynamics...<br></p>', 'Other', '', ''),
(15, 1, '.NET', '<p>.NET<br></p>', '.NET', '', ''),
(16, 1, ' Adobe Illustrator', '<p>&nbsp;Adobe Illustrator<br></p>', ' Adobe Illustrator', '', ''),
(20, 1, 'AJAX Toolkit', '<p>AJAX Toolkit<br></p>', 'AJAX Toolkit', '', ''),
(21, 1, 'AJAX', '<p>AJAX<br></p>', 'AJAX', '', ''),
(22, 1, 'Apple Safari', '<p>Apple Safari<br></p>', 'Apple Safari', '', ''),
(23, 1, 'Amazon S3', '<p>Amazon S3<br></p>', 'Amazon S3', '', ''),
(24, 1, 'API', '<p>API<br></p>', 'API', '', ''),
(25, 1, 'Angular Material', '<p>Angular Material<br></p>', 'Angular Material', '', ''),
(26, 1, 'App Developer', '<p>App Developer<br></p>', 'App Developer', '', ''),
(27, 1, 'BigCommerce', '<p>BigCommerce<br></p>', 'BigCommerce', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_country`
--

CREATE TABLE `ci_country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
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
-- Table structure for table `ci_currency`
--

CREATE TABLE `ci_currency` (
  `currency_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_currency`
--

INSERT INTO `ci_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
(1, 'Egyptian Pound', 'EGP', '', 'L.E', '2', 1.00000000, 1, '2020-10-23 18:12:28'),
(2, 'US Dollar', 'USD', '$', '', '2', 0.06366873, 1, '2020-10-23 18:12:28'),
(6, 'Emirati Dirham', 'AED', '', 'AED', '', 0.23385489, 1, '2020-10-23 18:12:28'),
(8, 'Saudi Riyal', 'SAR', 'SAR', '', '', 0.23877320, 1, '2020-10-23 18:12:28');

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
  `ip` varchar(40) NOT NULL,
  `viewed` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `image` varchar(255) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `about` text,
  `tag_line` varchar(64) DEFAULT 'NULL',
  `rate` int(11) NOT NULL,
  `origin` varchar(64) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `github` varchar(50) NOT NULL,
  `linkedin` varchar(50) NOT NULL,
  `facebook` varchar(50) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `ip`, `viewed`, `status`, `code`, `image`, `newsletter`, `about`, `tag_line`, `rate`, `origin`, `online`, `github`, `linkedin`, `facebook`, `twitter`, `date_added`, `date_modified`) VALUES
(20, 1, 'employer', 'demo', 'customer', 'customer@customer.com', '', '$2y$10$Mj4hoXcroWKj84C0z725U.OZXkOU8qMEhDeHsRloIiaioiOm6YU7W', '', 23, 1, '', 'catalog/1608582665_83479d8608f3933ad07b.png', 0, NULL, 'NULL', 0, '', 1, '', '', '', '', '2020-11-15 12:00:19', '2020-12-21 20:31:05'),
(30, 1, 'freelancer', 'demo', 'customer_2', 'customer_2@demo.com', '', '$2y$10$1zyoqELnzmI4E0b56kc5iOkynJr3QrSEbwyXDJiauXY9beb6oaMyO', '', 1, 1, '', '', 0, NULL, 'NULL', 0, '', 0, '', '', '', '', '2020-11-15 12:03:14', '0000-00-00 00:00:00'),
(31, 1, 'cust3', 'demo3', 'customer_3', 'customer_3@demo.com', '', '$2y$10$uMWVALi8btznHdC06HfVCe4qDKVBmxavbDs6rKzhWH6FVOF5JMyRy', '', 0, 1, '', '', 0, NULL, 'NULL', 0, '', 0, '', '', '', '', '2020-12-14 17:11:19', '2020-12-15 12:59:03');

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
  `seen` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_activity`
--

INSERT INTO `ci_customer_activity` (`customer_activity_id`, `customer_id`, `key`, `data`, `ip`, `user_agent`, `seen`, `date_added`) VALUES
(1, 20, 'project_bid_add', '{\"customer_id\":20,\"project_id\":1,\"freelancer_id\":30,\"url\":\"http:\\/\\/ci4.localhost\\/employer\\/project\\/view?pid=1&cid=20\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', 1, '2020-12-14 10:55:51'),
(2, 30, 'project_offer_selected', '{\"customer_id\":\"30\",\"project_id\":\"1\",\"url\":\"\\/account\\/projects#freelancer\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', 0, '2020-12-14 10:56:42'),
(3, 31, 'customer_register', '{\"customer_id\":31,\"username\":\"customer_3\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', 0, '2020-12-14 17:11:19'),
(4, 20, 'project_bid_add', '{\"customer_id\":20,\"project_id\":1,\"freelancer_id\":31,\"url\":\"http:\\/\\/ci4.localhost\\/employer\\/project\\/view?pid=1&cid=20\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36', 1, '2020-12-14 17:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_deposit`
--

CREATE TABLE `ci_customer_deposit` (
  `balance_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `currency` varchar(30) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(20, 1, 2);

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
(1, 1, 'Default', 'Default');

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
(1, 'admin@admin.com', '::1', 27, '2020-12-27 21:42:00', '2020-12-27 22:30:35');

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
('::1', 20, 'http://ci4.localhost/account/jobs', 'http://ci4.localhost/account/message', '2020-12-27 22:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_balance`
--

CREATE TABLE `ci_customer_to_balance` (
  `balance_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `income` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `withdrawn` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `used` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `available` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `pending` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_balance`
--

INSERT INTO `ci_customer_to_balance` (`balance_id`, `customer_id`, `project_id`, `income`, `withdrawn`, `used`, `available`, `pending`, `date_added`, `date_modified`) VALUES
(1, 20, 1, '0.0000', '0.0000', '0.0000', '4200.0000', '0.0000', '2020-10-07 08:32:34', '2020-10-08 08:32:34'),
(2, 20, 1, '0.0000', '200.0000', '20.0000', '0.0000', '0.0000', '2020-11-16 08:32:34', '2020-10-08 08:32:34'),
(70, 30, 1, '24.0000', '0.0000', '0.0000', '0.0000', '0.0000', '0000-00-00 00:00:00', '2020-11-22 11:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_category`
--

CREATE TABLE `ci_customer_to_category` (
  `category_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_category`
--

INSERT INTO `ci_customer_to_category` (`category_id`, `freelancer_id`, `date_added`) VALUES
(8, 20, '2020-12-18 18:16:25'),
(20, 20, '2020-12-19 11:18:39');

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
(3, 20, 'ssssss', '2020', '2020-12-19 13:47:30'),
(4, 20, 'ddddd', '2020', '2020-12-19 13:47:34');

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
(1, 20, 1, 1, 'ba', '2020', 'Egypt', '2020-12-19 13:55:36'),
(2, 20, 2, 2, 'brach', '2020', 'American Samoa', '2020-12-19 15:47:38'),
(3, 20, 2, 5, 'bfa', '2020', 'Angola', '2020-12-19 15:47:56'),
(4, 20, 129, 3, 'bm', '2020', 'Angola', '2020-12-19 15:48:52'),
(5, 20, 168, 3, 'bfa', '2020', 'American Samoa', '2020-12-19 15:49:31');

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
(53, 20, '4', '2020-12-19 12:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute`
--

CREATE TABLE `ci_dispute` (
  `dispute_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `comment` text NOT NULL,
  `dispute_status_id` int(1) NOT NULL,
  `dispute_reason_id` int(11) NOT NULL,
  `dispute_action_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_dispute`
--

INSERT INTO `ci_dispute` (`dispute_id`, `project_id`, `freelancer_id`, `employer_id`, `created_by`, `comment`, `dispute_status_id`, `dispute_reason_id`, `dispute_action_id`, `date_added`, `date_modified`) VALUES
(16, 1, 2, 1, 1, 'new items are nont as described, low quality', 0, 1, 0, '2020-12-14 07:39:54', '2020-12-14 07:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_action`
--

CREATE TABLE `ci_dispute_action` (
  `dispute_action_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_dispute_action`
--

INSERT INTO `ci_dispute_action` (`dispute_action_id`, `language_id`, `name`) VALUES
(1, 1, 'Refunded'),
(2, 1, 'Credit Issued'),
(5, 1, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_history`
--

CREATE TABLE `ci_dispute_history` (
  `dispute_history_id` int(11) NOT NULL,
  `dispute_id` int(11) NOT NULL,
  `dispute_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_reason`
--

CREATE TABLE `ci_dispute_reason` (
  `dispute_reason_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_dispute_reason`
--

INSERT INTO `ci_dispute_reason` (`dispute_reason_id`, `language_id`, `name`) VALUES
(1, 1, 'Project Quality'),
(2, 1, 'Not as Expected'),
(3, 1, 'Other, please supply details');

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_status`
--

CREATE TABLE `ci_dispute_status` (
  `dispute_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_dispute_status`
--

INSERT INTO `ci_dispute_status` (`dispute_status_id`, `language_id`, `name`) VALUES
(1, 1, 'Investigation'),
(2, 1, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `ci_download`
--

CREATE TABLE `ci_download` (
  `download_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `ext` varchar(50) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_download`
--

INSERT INTO `ci_download` (`download_id`, `filename`, `code`, `ext`, `date_added`, `date_modified`) VALUES
(1, 'themelock.com.txt', '1606476630_833c333bd5b9eb7977f2.txt', 'txt', '2020-11-27 11:30:30', '2020-11-27 11:30:30'),
(2, 'themelock.com.txt', '1606577810_f2ce15ca924dc70e8ed5.txt', 'txt', '2020-11-28 15:36:50', '2020-11-28 15:36:50');

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
  `priority` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_event`
--

INSERT INTO `ci_event` (`event_id`, `code`, `action`, `description`, `status`, `priority`) VALUES
(1, 'activity_user_login', 'Admin\\Events\\Activity::login', 'Record User Login Activity', 1, 0),
(2, 'login_attempts', 'Admin\\Events\\Activity::loginAttempts', 'Record Login Attempts to Admin Area', 1, 0),
(17, 'project_offer_selected', 'Catalog\\Events\\Activity::addWinner', '', 1, 0),
(6, 'user_activity_add', 'Admin\\Events\\Activity::afterInsert', 'Log Activity After Insert to DB', 1, 0),
(8, 'customer_register', 'Catalog\\Events\\Activity::addCustomer', 'Add Activity for new Customers', 1, 0),
(9, 'mail_register', 'Catalog\\Events\\MailAlert::addCustomer', 'Trigger the Activation Email for new Customers', 1, 0),
(11, 'mail_forgotten', 'Catalog\\Events\\MailAlert::forgottenMail', 'trigger Forgotton email activation', 1, 0),
(22, 'customer_transfer_funds', 'Catalog\\Events\\Activity::transferFunds', '', 1, 0),
(30, 'customer_milestone_payment', 'Catalog\\Events\\Activity::payMilestone', '', 1, 0),
(29, 'project_milestone_update', 'Catalog\\Events\\Activity::milestoneUpdate', '', 1, 0),
(16, 'customer_withdraw', 'Catalog\\Events\\Activity::CustomerActivityWithdraw', '', 1, 0),
(15, 'customer_update', 'Catalog\\Events\\Activity::CustomerActivityUpdate', '', 1, 0),
(18, 'project_milestone_create', 'Catalog\\Events\\Activity::createMilestone', '', 1, 0),
(19, 'project_offer_accepted', 'Catalog\\Events\\Activity::acceptOffer', '', 1, 0),
(20, 'project_transfer_funds', 'Catalog\\Events\\Notification::freelancerPayment', '', 1, 0),
(21, 'mail_payment', 'Catalog\\Events\\MailAlert::PaymentMail', 'Trigger the Activation Email for new Customers', 1, 0),
(23, 'customer_dispute_notify', 'Admin\\Events\\Mail::customer_dispute_notify', 'Notify Customers About dispute status', 1, 0),
(24, 'project_bid_add', 'Catalog\\Events\\Activity::addBid', '', 1, 0),
(25, 'customer_withdraw_notify', 'Admin\\Events\\Mail::addWithdrawHistory', 'Notify Customer About withdraw status', 1, 0),
(26, 'mail_project_add', 'Catalog\\Events\\MailAlert::addProject', 'Send confirmation email to employer when new project posted', 1, 0),
(27, 'mail_project_status_update', 'Catalog\\Events\\MailAlert::updateProjectStatus', 'Send an email to employer when project status completed ', 1, 0),
(31, 'customer_review_add', 'Catalog\\Events\\Activity::addReview', '', 1, 0),
(32, 'project_status_update', 'Catalog\\Events\\Activity::updateProjectStatus', 'Trigger Notification to employer when project status completed ', 1, 0);

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
(75, 'project', 'bid'),
(53, 'blogger', 'post'),
(52, 'blogger', 'category'),
(72, 'module', 'category'),
(81, 'dashboard', 'activity'),
(63, 'module', 'carousel'),
(60, 'module', 'featured'),
(64, 'module', 'html'),
(71, 'theme', 'basic'),
(79, 'dashboard', 'online'),
(77, 'module', 'video'),
(80, 'module', 'freelancer'),
(83, 'wallet', 'wallet'),
(92, 'job', 'job'),
(94, 'blogger', 'comment');

-- --------------------------------------------------------

--
-- Table structure for table `ci_information`
--

CREATE TABLE `ci_information` (
  `information_id` int(11) NOT NULL,
  `bottom` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_information`
--

INSERT INTO `ci_information` (`information_id`, `bottom`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 1, '2020-09-01 11:31:34', '2020-11-25 21:35:26'),
(2, 1, 3, 1, '2020-09-01 11:31:34', '2020-11-25 21:35:07'),
(3, 1, 1, 1, '2020-09-01 11:31:34', '2020-11-25 21:35:20'),
(4, 0, 0, 1, '2020-09-01 11:31:34', '2020-11-25 21:35:13');

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
(1, 1, 'Terms & Conditions', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span></p>', 'Terms & Conditions', '', ''),
(5, 1, 'new info page', '<p>new info page<br></p>', 'new info page', '', ''),
(3, 1, 'Privacy Policy', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span><br></p>\r\n', 'Privacy Policy', '', ''),
(2, 1, 'About Us', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', 'About Us', '', ''),
(4, 1, 'How It Works', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'How It Works', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_job`
--

CREATE TABLE `ci_job` (
  `job_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `salary` decimal(15,4) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `viewed` int(5) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_job`
--

INSERT INTO `ci_job` (`job_id`, `employer_id`, `salary`, `type`, `viewed`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(15, 20, '0.0000', 1, 0, 0, 1, '2020-12-26 21:02:26', '2020-12-26 21:02:26'),
(16, 20, '0.0000', 1, 0, 0, 1, '2020-12-26 21:02:26', '2020-12-26 21:02:26');

-- --------------------------------------------------------

--
-- Table structure for table `ci_job_applicants`
--

CREATE TABLE `ci_job_applicants` (
  `job_applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_job_description`
--

INSERT INTO `ci_job_description` (`job_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 'test job', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', '', '', 'IT, Test'),
(2, 'test job', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', '', '', 'IT, Test'),
(3, 'test job', '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span><br></p>', '', '', 'IT, Test'),
(4, 'ssss', '<p>ssss</p>', '', '', 'ssss'),
(5, 'sss', '<p>ssss</p>', '', '', 'ssss'),
(6, 'ssss', '<p>ssss</p>', '', '', 'sssss'),
(7, 'aaa', '<p>aaaa</p>', '', '', 'aaaa'),
(8, 'aaa', '<p>aaa</p>', '', '', 'aaaa'),
(9, 'ddd', '<p>ddd</p>', '', '', 'dddd'),
(10, 'aaaa', '<p>aaaaaaaa</p>', '', '', 'www'),
(11, 'eeeee', '<p>eeeeeeee</p>', '', '', 'rrrr'),
(12, 'ssss', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>', '', '', 'ss'),
(13, 'dddd', '<p>dddddddd</p>', '', '', 'dddd'),
(14, 'dddd', '<p>dddddddd</p>', '', '', 'dddd'),
(15, 'ssss', '<p>sssssss</p>', '', '', 'ssss'),
(16, 'ssss', '<p>sssssss</p>', '', '', 'ssss'),
(17, 'ddd', '<p>ddhhhh</p>', '', '', 'ssss');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`language_id`, `name`, `code`, `locale`, `sort_order`, `status`) VALUES
(1, 'English', 'en', 'en', 1, 1),
(2, 'Arabic', 'en', 'ar', 1, 0);

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
(3, 'Category'),
(6, 'Account'),
(8, 'Contact'),
(11, 'Information');

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
(96, 1, 'category', 'content_top', 3),
(95, 1, 'featured', 'content_top', 2),
(94, 1, 'video.9', 'content_top', 1),
(93, 1, 'html.6', 'content_bottom', 2),
(92, 1, 'freelancer', 'content_bottom', 1),
(97, 1, 'html.5', 'content_top', 4);

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
(39, 1, 0, 'common/home'),
(7, 6, 0, 'account/(:any)'),
(40, 3, 0, 'project/category');

-- --------------------------------------------------------

--
-- Table structure for table `ci_message`
--

CREATE TABLE `ci_message` (
  `message_id` int(11) NOT NULL,
  `thread_id` varchar(32) NOT NULL,
  `project_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_message`
--

INSERT INTO `ci_message` (`message_id`, `thread_id`, `project_id`, `sender_id`, `receiver_id`, `message`, `seen`, `date_added`, `date_modified`) VALUES
(1, 'e72572021e', 1, 20, 30, '{\"sender_id\":\"20\",\"receiver_id\":\"30\",\"text\":\"ssss\"}', 0, '2020-12-14 18:28:41', '2020-12-14 18:46:30'),
(2, 'a12d4fb70a', 1, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"rrrr\"}', 1, '2020-12-14 18:28:55', '2020-12-27 22:32:05'),
(8, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"fffff\"}', 1, '2020-12-14 18:39:19', '2020-12-27 22:32:05'),
(9, 'e72572021e', 0, 20, 30, '{\"sender_id\":\"20\",\"receiver_id\":\"30\",\"text\":\"tttt\"}', 0, '2020-12-14 18:39:30', '2020-12-14 18:46:30'),
(10, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"i have seen your profile and i\'m insterested to do business with you, reach out when you get my message \"}', 1, '2020-12-14 18:47:06', '2020-12-27 22:32:05'),
(11, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"ffff\"}', 1, '2020-12-14 19:53:26', '2020-12-27 22:32:05'),
(12, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"ssss\"}', 1, '2020-12-14 19:53:53', '2020-12-27 22:32:05'),
(13, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"ssss\"}', 1, '2020-12-14 19:54:27', '2020-12-27 22:32:05'),
(14, 'a12d4fb70a', 0, 20, 31, '{\"sender_id\":\"20\",\"receiver_id\":\"31\",\"text\":\"hhh\"}', 1, '2020-12-14 19:55:55', '2020-12-27 22:32:05');

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
(3, 'Home Slide Show', 'carousel', '{\"name\":\"Home Slide Show\",\"banner_id\":\"2\",\"width\":\"1500\",\"height\":\"650\",\"autoplay\":\"1\",\"dots\":\"1\",\"infinite\":\"1\",\"arrows\":\"0\",\"status\":\"1\"}'),
(4, 'InfoBox', 'html', '{\"name\":\"InfoBox\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"photo-section\\\" data-background-image=\\\"catalog\\/default\\/images\\/section-background.jpg\\\"><p><\\/p><p><br><\\/p><p><span style=\\\"white-space:pre\\\">\\t<\\/span><!-- Infobox --><\\/p><p><span style=\\\"white-space:pre\\\">\\t<\\/span><\\/p><div class=\\\"text-content white-font\\\"><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t<\\/span><\\/p><div class=\\\"container\\\"><p><\\/p><p><br><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t<\\/span><\\/p><div class=\\\"row\\\"><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t\\t<\\/span><\\/p><div class=\\\"col-lg-6 col-md-8 col-sm-12\\\"><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t\\t\\t<\\/span><\\/p><h2>Hire experts or be hired. <br> For any job, any time.<\\/h2><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t\\t\\t<\\/span><\\/p><p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day, going forward, a new normal that has evolved from generation is on the runway towards.<\\/p><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t\\t\\t<\\/span><a href=\\\"<?php echo $register; ?>\\\" class=\\\"button button-sliding-icon ripple-effect big margin-top-20\\\">Get Started <i class=\\\"icon-material-outline-arrow-right-alt\\\"><\\/i><\\/a><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t\\t<\\/span><\\/p><\\/div><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t\\t<\\/span><\\/p><\\/div><p><\\/p><p><br><\\/p><p><span style=\\\"white-space:pre\\\">\\t\\t<\\/span><\\/p><\\/div><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t<\\/span><\\/p><\\/div><p><\\/p><p><span style=\\\"white-space:pre\\\">\\t<\\/span><!-- Infobox \\/ End --><\\/p><p><\\/p><\\/div>\"},\"status\":\"1\"}'),
(6, 'Testimonials', 'html', '{\"name\":\"Testimonials\",\"module_description\":{\"title\":\"\",\"description\":\"<!-- Testimonials -->\\r\\n<div class=\\\"section gray padding-top-65 padding-bottom-55\\\">\\r\\n\\t\\r\\n\\t<div class=\\\"container\\\">\\r\\n\\t\\t<div class=\\\"row\\\">\\r\\n\\t\\t\\t<div class=\\\"col-xl-12\\\">\\r\\n\\t\\t\\t\\t<!-- Section Headline -->\\r\\n\\t\\t\\t\\t<div class=\\\"section-headline centered margin-top-0 margin-bottom-5\\\">\\r\\n\\t\\t\\t\\t\\t<h3>Testimonials<\\/h3>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n\\r\\n\\t<!-- Categories Carousel -->\\r\\n\\t<div class=\\\"fullwidth-carousel-container margin-top-20\\\">\\r\\n\\t\\t<div class=\\\"testimonial-carousel testimonials\\\">\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/user-avatar-small-02.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Sindy Forest<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/user-avatar-small-01.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Tom Smith<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/user-avatar-placeholder.png\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Sebastiano Piccio<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Employer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/user-avatar-small-03.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>David Peterson<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services. Seamlessly empower fully researched growth strategies and interoperable sources.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/user-avatar-placeholder.png\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Marcin Kowalski<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n\\t<!-- Categories Carousel \\/ End --><\\/div>\"},\"status\":\"1\"}'),
(5, 'How It Works', 'html', '{\"name\":\"How It Works\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"section padding-top-65 padding-bottom-65\\\">\\r\\n\\t<div class=\\\"container\\\">\\r\\n\\t\\t<div class=\\\"row\\\">\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-12\\\">\\r\\n\\t\\t\\t\\t<!-- Section Headline -->\\r\\n\\t\\t\\t\\t<div class=\\\"section-headline centered margin-top-0 margin-bottom-5\\\">\\r\\n\\t\\t\\t\\t\\t<h3>How It Works?<\\/h3>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box with-line\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\"icon-line-awesome-lock\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Create an Account<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Bring to the table win-win survival strategies to ensure proactive domination going forward.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box with-line\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\"icon-line-awesome-legal\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Post a Task<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Efficiently unleash cross-media information without. Quickly maximize return on investment.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\" icon-line-awesome-trophy\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Choose an Expert<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Nanotechnology immersion along the information highway will close the loop on focusing solely.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(9, 'Home Page Video', 'video', '{\"name\":\"Home Page Video\",\"module_description\":{\"mp4\":\"catalog\\/video\\/intro.mp4\",\"webm\":\"catalog\\/video\\/intro.webm\",\"image\":\"catalog\\/video\\/intro.png\"},\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project`
--

CREATE TABLE `ci_project` (
  `project_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL DEFAULT '0',
  `budget_min` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `budget_max` decimal(15,4) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '"1:Fixed", "2:Hour"',
  `delivery_time` int(11) NOT NULL,
  `runtime` int(11) NOT NULL,
  `viewed` int(5) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `download_id` tinyint(1) NOT NULL,
  `draft` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_delete` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project`
--

INSERT INTO `ci_project` (`project_id`, `employer_id`, `freelancer_id`, `budget_min`, `budget_max`, `type`, `delivery_time`, `runtime`, `viewed`, `image`, `sort_order`, `status_id`, `download_id`, `draft`, `date_added`, `date_modified`, `date_delete`) VALUES
(1, 20, 0, '20.0000', '50.0000', 1, 3, 7, 44, '', 0, 5, 0, 0, '2020-12-14 18:45:15', '2020-11-22 18:45:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_award`
--

CREATE TABLE `ci_project_award` (
  `award_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `delivery_time` int(5) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `deposite` decimal(15,4) NOT NULL,
  `status_id` tinyint(2) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_bids`
--

CREATE TABLE `ci_project_bids` (
  `bid_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `quote` decimal(15,0) NOT NULL,
  `delivery` tinyint(1) NOT NULL,
  `selected` tinyint(1) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_bids`
--

INSERT INTO `ci_project_bids` (`bid_id`, `project_id`, `freelancer_id`, `employer_id`, `quote`, `delivery`, `selected`, `accepted`, `description`, `status`, `paid`, `date_added`, `date_modified`) VALUES
(2, 1, 30, 20, '30', 5, 1, 0, 'thanks ', 1, 0, '2020-12-14 10:55:51', '2020-12-14 10:56:42'),
(3, 1, 31, 20, '25', 3, 0, 0, 'thanks', 1, 0, '2020-12-14 17:58:34', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_bids_upgrade`
--

CREATE TABLE `ci_project_bids_upgrade` (
  `upgrade_id` int(11) NOT NULL,
  `bid_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `reason` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 1, 'Where does it come from?', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\n', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_proposal`
--

CREATE TABLE `ci_project_proposal` (
  `proposal_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `budget_min` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_status`
--

CREATE TABLE `ci_project_status` (
  `status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_status`
--

INSERT INTO `ci_project_status` (`status_id`, `language_id`, `name`) VALUES
(1, 1, 'Canceled'),
(2, 1, 'Completed'),
(3, 1, 'Denied'),
(4, 1, 'in Progress'),
(5, 1, 'Expired'),
(6, 1, 'Awarded'),
(7, 1, 'Closed'),
(8, 1, 'Open');

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
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_download`
--

CREATE TABLE `ci_project_to_download` (
  `download_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `url` varchar(128) NOT NULL,
  `count` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_message`
--

CREATE TABLE `ci_project_to_message` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_milestone`
--

CREATE TABLE `ci_project_to_milestone` (
  `milestone_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_for` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `deadline` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_upload`
--

CREATE TABLE `ci_project_to_upload` (
  `upload_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `size` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_revenue`
--

CREATE TABLE `ci_revenue` (
  `revenue_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `payer_id` int(11) NOT NULL,
  `payer` varchar(50) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `reason` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_review`
--

CREATE TABLE `ci_review` (
  `review_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `freelancer_id` int(11) NOT NULL,
  `employer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(1) NOT NULL,
  `recommended` int(1) NOT NULL,
  `ontime` int(1) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_review`
--

INSERT INTO `ci_review` (`review_id`, `project_id`, `freelancer_id`, `employer_id`, `comment`, `rating`, `recommended`, `ontime`, `submitted_by`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 2, 1, 'dddddd', 4, 3, 1, 1, 1, '2020-11-29 10:51:04', '2020-11-29 10:51:04');

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
(27, 0, 1, 'job_id=17', 'ddd'),
(26, 0, 1, 'job_id=16', 'ssss'),
(25, 0, 1, 'job_id=15', 'ssss');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('kchtol0b6au1iv1innvt4ba3lon8qv9v', '::1', 1609004644, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030343634343b5f63695f70726576696f75735f75726c7c733a36373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d76656e646f72253246626f6f747374726170223b),
('j9b2sdmi0ekn4o7n8epbrl8l1be8vipd', '::1', 1609005037, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030353033373b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('licdgo4fnurvaijjgdij3j0jecittpg8', '::1', 1609005370, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030353337303b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('o21bpm1boe08mqrpvo3i0lg6qbf31hhu', '::1', 1609005578, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030353337303b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('ror1alp92sl78gfmeddvt9uj7aot6mer', '::1', 1609005920, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030353932303b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('bi8m2cn8gfv4s3t9ce4ov730bic1sc78', '::1', 1609007008, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030373030383b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('36n3bdrohqbdh9ldbrn1tuul728u7n54', '::1', 1609007031, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030373030383b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d696d6167657325324669636f6e73223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('5dk0mcq5rvifs5imjdullsqpse70kklj', '::1', 1609007417, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030373431373b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
('e63p30v9rtvhjivivlc5k7aree0u46cn', '::1', 1609007853, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030373835333b5f63695f70726576696f75735f75726c7c733a38353a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f656d61696c3d637573746f6d65725f3325343064656d6f2e636f6d2670617373776f72643d637573746f6d6572223b),
('h7q76mgps311kev4u3rte0ljffa6540n', '::1', 1609008154, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030383135343b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f656d61696c3d637573746f6d6572253430637573746f6d65722e636f6d2670617373776f72643d637573746f6d6572223b),
('qvt5t7q9jj5c6p6pvf8qp4um8jvroa4q', '::1', 1609007863, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030373836333b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
('p7g3fklvai418d01ahleh56sqqkn71o9', '::1', 1609008320, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030383135343b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f656d61696c3d637573746f6d6572253430637573746f6d65722e636f6d2670617373776f72643d637573746f6d6572223b),
('1976n79disiqtnb93lnu2ud8agvc4d4k', '::1', 1609008695, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030383639353b5f63695f70726576696f75735f75726c7c733a36333a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d617373657473253246666f6e7473223b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d),
('5kcbcn64qdh88sh3ijkhbss14brc7raq', '::1', 1609009411, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393030393431313b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('jvp5rdho33ibcmb2tnneaikvuoqtgh92', '::1', 1609011342, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393031313334323b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('j4783mvap38uolf1gfih9bkpma28adls', '::1', 1609011674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393031313637343b5f63695f70726576696f75735f75726c7c733a33393a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e223b),
('gjm5c92f28v192bvbg7djf58n7hjknb5', '::1', 1609011687, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393031313637343b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d6d534a746157357659454133674650774f624e5836684447634d49643831756f223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226d534a746157357659454133674650774f624e5836684447634d49643831756f223b),
('3jinbr2r64vaanojq7l6v3ji0ffcqo24', '::1', 1609015862, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393031353836323b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d31446e37594f4b537948353662734c436a77385630666d347547507a7154634d223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2231446e37594f4b537948353662734c436a77385630666d347547507a7154634d223b),
('ubfsdjdtcik23tnpdiqp7rv9ssgln0c0', '::1', 1609016089, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393031353938363b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d313732774134497a584651335344566739457361476e304252744c794e35756b223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22313732774134497a584651335344566739457361476e304252744c794e35756b223b),
('mpav9070kghjs03a16airtqn9d10gecd', '::1', 1609100474, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393130303436383b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d46516e6467433344346d654d6a416374567a313661546958574f455371625a30223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a2246516e6467433344346d654d6a416374567a313661546958574f455371625a30223b),
('kcqrjj42ppcfhgb4epfia1bt8btt6j37', '::1', 1609108391, 0x5f5f63695f6c6173745f726567656e65726174657c693a313630393130383335383b5f63695f70726576696f75735f75726c7c733a38343a22687474703a2f2f6369342e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d3456693731614542684667786f3552397274644c3865624f4d6d305a6e775963223b757365725f69647c733a313a2231223b757365726e616d657c733a31303a2241686d65642041747761223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a223456693731614542684667786f3552397274644c3865624f4d6d305a6e775963223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `ci_setting`
--

CREATE TABLE `ci_setting` (
  `setting_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `setting` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_setting`
--

INSERT INTO `ci_setting` (`setting_id`, `site_id`, `code`, `name`, `setting`, `serialized`) VALUES
(515, 0, 'dashboard_activity', 'dashboard_activity_sort_order', '2', 0),
(514, 0, 'dashboard_activity', 'dashboard_activity_status', '1', 0),
(628, 0, 'config', 'config_file_mime_allowed', 'text/plain\r\nimage/png\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\n\"application/zip\"\r\napplication/x-zip\r\n\"application/x-zip\"\r\napplication/x-zip-compressed\r\n\"application/x-zip-compressed\"\r\napplication/rar\r\n\"application/rar\"\r\napplication/x-rar\r\n\"application/x-rar\"\r\napplication/x-rar-compressed\r\n\"application/x-rar-compressed\"\r\napplication/octet-stream\r\n\"application/octet-stream\"\r\naudio/mpeg\r\nvideo/quicktime\r\napplication/pdf', 0),
(627, 0, 'config', 'config_file_ext_allowed', 'zip\r\ntxt\r\npng\r\njpe\r\njpeg\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc', 0),
(518, 0, 'dashboard_online', 'dashboard_online_sort_order', '1', 0),
(521, 0, 'wallet_extension', 'wallet_extension_status', '1', 0),
(564, 0, 'blog_extension', 'blog_extension_status', '1', 0),
(26, 0, 'customer_wallet', 'customer_wallet_status', '1', 0),
(531, 0, 'job_extension', 'job_extension_status', '1', 0),
(453, 0, 'module_category', 'module_category_status', '1', 0),
(99, 0, 'extension_wallet', 'extension_wallet_status', '1', 0),
(344, 0, 'module_featured', 'module_featured_status', '1', 0),
(343, 0, 'module_featured', 'module_featured_limit', '8', 0),
(340, 0, 'theme_default', 'theme_default_status', '1', 0),
(338, 0, 'theme_default', 'theme_default_directory', 'default', 0),
(626, 0, 'config', 'config_maintenance', '0', 0),
(625, 0, 'config', 'config_instagram', 'https://www.instagram.com/yallafreelancers/', 0),
(624, 0, 'config', 'config_linkedin', 'https://www.linkedin.com/in/yallafreelancers/', 0),
(339, 0, 'theme_default', 'theme_default_color', 'red.css', 0),
(623, 0, 'config', 'config_pintrest', 'https://www.pinterest.com/yallafreelancers/', 0),
(622, 0, 'config', 'config_twitter', 'https://twitter.com/yallfreelancer', 0),
(621, 0, 'config', 'config_facebook', 'https://www.facebook.com/Yallafreelancer/', 0),
(620, 0, 'config', 'config_upgrade_highlight', '2', 0),
(619, 0, 'config', 'config_upgrade_sponser', '5', 0),
(617, 0, 'config', 'config_freelancer_fee', '', 0),
(618, 0, 'config', 'config_processing_fee', '2.3', 0),
(616, 0, 'config', 'config_customer_online', '1', 0),
(615, 0, 'config', 'config_customer_activity', '1', 0),
(614, 0, 'config', 'config_project_expired_status', '5', 0),
(331, 0, 'extension_bid', 'extension_bid_status', '1', 0),
(513, 0, 'dashboard_activity', 'dashboard_activity_width', '12', 0),
(452, 0, 'module_freelancer', 'module_freelancer_status', '1', 0),
(451, 0, 'module_freelancer', 'module_freelancer_limit', '8', 0),
(517, 0, 'dashboard_online', 'dashboard_online_status', '1', 0),
(516, 0, 'dashboard_online', 'dashboard_online_width', '3', 0),
(613, 0, 'config', 'config_project_completed_status', '2', 0),
(612, 0, 'config', 'config_project_status_id', '8', 0),
(611, 0, 'config', 'config_login_attempts', '5', 0),
(610, 0, 'config', 'config_admin_limit', '20', 0),
(609, 0, 'config', 'config_currency', 'EGP', 0),
(608, 0, 'config', 'config_admin_language_id', '1', 0),
(606, 0, 'config', 'config_telephone', '+00 000-00-000', 0),
(607, 0, 'config', 'config_language_id', '1', 0),
(605, 0, 'config', 'config_email', 'admin@admin.com', 0),
(604, 0, 'config', 'config_address', '6th Forrest Ray, London - 10001 UK', 0),
(602, 0, 'config', 'config_name', 'YallaFreelancer', 0),
(603, 0, 'config', 'config_owner', 'Ahmed Atwa', 0),
(599, 0, 'config', 'config_meta_keyword', '', 0),
(600, 0, 'config', 'config_theme', 'default', 0),
(601, 0, 'config', 'config_logo', 'catalog/logo.png', 0),
(597, 0, 'config', 'config_meta_title', 'Freelance Services Marketplace for Businesses in Egypt', 0),
(598, 0, 'config', 'config_meta_description', 'Yallafreelancer mission is to change how the world works together. Yallafreelancer connects businesses with freelancers offering digital services in 300+ categories.', 0);

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
-- Table structure for table `ci_university_majors`
--

CREATE TABLE `ci_university_majors` (
  `major_id` int(11) NOT NULL,
  `text` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_university_majors`
--

INSERT INTO `ci_university_majors` (`major_id`, `text`) VALUES
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
(1, 1, '', 'Ahmed', 'Atwa', 'admin@admin.com', '$2y$10$zZY54wKZBMY4N.CF7PDYouaRUS/fVC0jB/B1F5iA3L68wr530OQbO', 1, '', 'AYWjstdzGrmBxJwUoVCbQKPMIaTqkXlDZiEupNgO', '2020-06-23 15:39:58', '2020-08-19 13:53:07', '0000-00-00 00:00:00'),
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
(1, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-16 17:50:51'),
(2, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-16 17:51:05'),
(3, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 09:07:48'),
(4, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 09:09:18'),
(5, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 11:47:02'),
(6, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 16:22:01'),
(7, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:10:33'),
(8, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:39:57'),
(9, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:41:46'),
(10, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:43:25'),
(11, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:49:39'),
(12, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:51:37'),
(13, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36 OPR/72.0.3815.400', '2020-12-17 19:56:20'),
(14, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:84.0) Gecko/20100101 Firefox/84.0', '2020-12-18 14:02:02'),
(15, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-21 18:46:22'),
(16, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-24 19:05:59'),
(17, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 11:43:25'),
(18, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 12:34:36'),
(19, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 13:45:15'),
(20, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 13:46:08'),
(21, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 16:30:42'),
(22, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 16:31:52'),
(23, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:39:10'),
(24, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:40:39'),
(25, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:40:41'),
(26, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:40:51'),
(27, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:42:02'),
(28, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:42:26'),
(29, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:43:34'),
(30, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:54:54'),
(31, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:56:00'),
(32, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:56:11'),
(33, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:56:44'),
(34, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:56:56'),
(35, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:57:08'),
(36, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:57:33'),
(37, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:57:47'),
(38, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:58:00'),
(39, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:58:10'),
(40, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 19:58:28'),
(41, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 20:05:20'),
(42, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 20:17:41'),
(43, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-25 22:21:33'),
(44, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 11:16:05'),
(45, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 11:20:02'),
(46, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 11:21:19'),
(47, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:06:29'),
(48, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:06:33'),
(49, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:06:36'),
(50, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:07:10'),
(51, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:07:29'),
(52, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:07:32'),
(53, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:07:39'),
(54, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:07:42'),
(55, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:08:08'),
(56, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:08:48'),
(57, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:08:51'),
(58, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:08:53'),
(59, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:09:09'),
(60, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:09:11'),
(61, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:09:38'),
(62, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:09:53'),
(63, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:13:29'),
(64, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:17:00'),
(65, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:17:03'),
(66, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:25:37'),
(67, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:28:21'),
(68, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:28:45'),
(69, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:30:46'),
(70, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:56:17'),
(71, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:56:24'),
(72, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 18:56:40'),
(73, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 19:41:24'),
(74, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 20:06:55'),
(75, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 20:07:09'),
(76, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-26 20:54:43'),
(77, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-27 20:19:37'),
(78, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-27 20:21:12'),
(79, 1, 'activity_user_login', '{\"user_id\":\"1\",\"name\":\"Ahmed Atwa\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 OPR/73.0.3856.284', '2020-12-27 22:32:43');

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_group`
--

CREATE TABLE `ci_user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permission` text NOT NULL,
  `date_added` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_group`
--

INSERT INTO `ci_user_group` (`user_group_id`, `name`, `permission`, `date_added`, `date_modified`) VALUES
(2, 'Demonstration', '{\"access\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"],\"modify\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"]}', '2020-07-21 21:45:31', '2020-07-21 21:45:31'),
(1, 'Administrator', '{\"access\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/payment\",\"extension\\/theme\",\"extension\\/wallet.php_\",\"finance\\/dispute\",\"finance\\/withdrawal\",\"localisation\\/currency\",\"localisation\\/dispute_action\",\"localisation\\/dispute_reason\",\"localisation\\/dispute_status\",\"localisation\\/language\",\"localisation\\/project_status\",\"localisation\\/withdraw_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"module\\/featured\",\"module\\/freelancer\",\"module\\/html\",\"module\\/video\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\"],\"modify\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/payment\",\"extension\\/theme\",\"extension\\/wallet.php_\",\"finance\\/dispute\",\"finance\\/withdrawal\",\"localisation\\/currency\",\"localisation\\/dispute_action\",\"localisation\\/dispute_reason\",\"localisation\\/dispute_status\",\"localisation\\/language\",\"localisation\\/project_status\",\"localisation\\/withdraw_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"module\\/featured\",\"module\\/freelancer\",\"module\\/html\",\"module\\/video\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\"]}', '2020-08-07 11:33:45', '2020-12-24 21:00:49');

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
(0, 'customer@customer.com', '::1', 86, '2020-12-22 13:44:18', '2020-12-27 20:19:31'),
(0, '', '::1', 86, '2020-12-25 19:48:15', '2020-12-27 20:19:31'),
(0, 'admin@admin.com', '::1', 80, '2020-12-25 19:58:50', '2020-12-27 20:19:31'),
(0, 'customer_3@demo.com', '::1', 66, '2020-12-26 18:28:52', '2020-12-27 20:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw`
--

CREATE TABLE `ci_withdraw` (
  `withdraw_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `currency` varchar(30) NOT NULL,
  `withdraw_status_id` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `date_processed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_withdraw`
--

INSERT INTO `ci_withdraw` (`withdraw_id`, `customer_id`, `amount`, `currency`, `withdraw_status_id`, `date_added`, `date_modified`, `date_processed`) VALUES
(1, 1, '400.0000', 'EGP', 1, '2020-11-16 10:53:49', '2020-11-16 12:43:37', '2020-11-16 12:43:37'),
(2, 2, '400.0000', 'EGP', 1, '2020-11-16 10:53:49', '2020-11-16 12:43:37', '2020-11-16 12:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw_history`
--

CREATE TABLE `ci_withdraw_history` (
  `withdraw_history_id` int(11) NOT NULL,
  `withdraw_id` int(11) NOT NULL,
  `withdraw_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_withdraw_history`
--

INSERT INTO `ci_withdraw_history` (`withdraw_history_id`, `withdraw_id`, `withdraw_status_id`, `notify`, `comment`, `date_added`) VALUES
(1, 1, 1, 0, 'ccccccc', '2020-11-16 12:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw_status`
--

CREATE TABLE `ci_withdraw_status` (
  `withdraw_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_withdraw_status`
--

INSERT INTO `ci_withdraw_status` (`withdraw_status_id`, `language_id`, `name`) VALUES
(1, 0, 'Pending'),
(2, 0, 'Processing'),
(3, 0, 'Executed'),
(5, 1, 'Declined');

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
-- Indexes for table `ci_blog_post_to_comment`
--
ALTER TABLE `ci_blog_post_to_comment`
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
-- Indexes for table `ci_country`
--
ALTER TABLE `ci_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `ci_currency`
--
ALTER TABLE `ci_currency`
  ADD PRIMARY KEY (`currency_id`);

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
-- Indexes for table `ci_customer_deposit`
--
ALTER TABLE `ci_customer_deposit`
  ADD PRIMARY KEY (`balance_id`) USING BTREE;

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
-- Indexes for table `ci_customer_to_balance`
--
ALTER TABLE `ci_customer_to_balance`
  ADD PRIMARY KEY (`balance_id`,`customer_id`) USING BTREE;

--
-- Indexes for table `ci_customer_to_category`
--
ALTER TABLE `ci_customer_to_category`
  ADD PRIMARY KEY (`category_id`,`freelancer_id`);

--
-- Indexes for table `ci_customer_to_certificate`
--
ALTER TABLE `ci_customer_to_certificate`
  ADD PRIMARY KEY (`certificate_id`,`freelancer_id`) USING BTREE;

--
-- Indexes for table `ci_customer_to_education`
--
ALTER TABLE `ci_customer_to_education`
  ADD PRIMARY KEY (`education_id`,`freelancer_id`) USING BTREE;

--
-- Indexes for table `ci_customer_to_language`
--
ALTER TABLE `ci_customer_to_language`
  ADD PRIMARY KEY (`language_id`,`freelancer_id`) USING BTREE,
  ADD KEY `freelancer_id` (`freelancer_id`);

--
-- Indexes for table `ci_dispute`
--
ALTER TABLE `ci_dispute`
  ADD PRIMARY KEY (`dispute_id`);

--
-- Indexes for table `ci_dispute_action`
--
ALTER TABLE `ci_dispute_action`
  ADD PRIMARY KEY (`dispute_action_id`,`language_id`);

--
-- Indexes for table `ci_dispute_history`
--
ALTER TABLE `ci_dispute_history`
  ADD PRIMARY KEY (`dispute_history_id`);

--
-- Indexes for table `ci_dispute_reason`
--
ALTER TABLE `ci_dispute_reason`
  ADD PRIMARY KEY (`dispute_reason_id`,`language_id`);

--
-- Indexes for table `ci_dispute_status`
--
ALTER TABLE `ci_dispute_status`
  ADD PRIMARY KEY (`dispute_status_id`,`language_id`);

--
-- Indexes for table `ci_download`
--
ALTER TABLE `ci_download`
  ADD PRIMARY KEY (`download_id`);

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
-- Indexes for table `ci_job_applicants`
--
ALTER TABLE `ci_job_applicants`
  ADD PRIMARY KEY (`job_applicant_id`);

--
-- Indexes for table `ci_job_description`
--
ALTER TABLE `ci_job_description`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_language`
--
ALTER TABLE `ci_language`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_languages`
--
ALTER TABLE `ci_languages`
  ADD PRIMARY KEY (`language_id`);

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
-- Indexes for table `ci_message`
--
ALTER TABLE `ci_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `project_id` (`project_id`) USING BTREE;

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
-- Indexes for table `ci_project_award`
--
ALTER TABLE `ci_project_award`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `ci_project_bids`
--
ALTER TABLE `ci_project_bids`
  ADD PRIMARY KEY (`bid_id`);

--
-- Indexes for table `ci_project_bids_upgrade`
--
ALTER TABLE `ci_project_bids_upgrade`
  ADD PRIMARY KEY (`upgrade_id`);

--
-- Indexes for table `ci_project_description`
--
ALTER TABLE `ci_project_description`
  ADD PRIMARY KEY (`project_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `ci_project_proposal`
--
ALTER TABLE `ci_project_proposal`
  ADD PRIMARY KEY (`proposal_id`);

--
-- Indexes for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  ADD PRIMARY KEY (`status_id`,`language_id`);

--
-- Indexes for table `ci_project_to_category`
--
ALTER TABLE `ci_project_to_category`
  ADD PRIMARY KEY (`project_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `ci_project_to_download`
--
ALTER TABLE `ci_project_to_download`
  ADD PRIMARY KEY (`download_id`);

--
-- Indexes for table `ci_project_to_message`
--
ALTER TABLE `ci_project_to_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `project_id` (`receiver_id`) USING BTREE;

--
-- Indexes for table `ci_project_to_milestone`
--
ALTER TABLE `ci_project_to_milestone`
  ADD PRIMARY KEY (`milestone_id`),
  ADD KEY `project_id` (`project_id`) USING BTREE;

--
-- Indexes for table `ci_project_to_upload`
--
ALTER TABLE `ci_project_to_upload`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexes for table `ci_revenue`
--
ALTER TABLE `ci_revenue`
  ADD PRIMARY KEY (`revenue_id`);

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
-- Indexes for table `ci_setting`
--
ALTER TABLE `ci_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `ci_university`
--
ALTER TABLE `ci_university`
  ADD PRIMARY KEY (`university_id`);

--
-- Indexes for table `ci_university_majors`
--
ALTER TABLE `ci_university_majors`
  ADD PRIMARY KEY (`major_id`);

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
-- Indexes for table `ci_withdraw`
--
ALTER TABLE `ci_withdraw`
  ADD PRIMARY KEY (`withdraw_id`) USING BTREE;

--
-- Indexes for table `ci_withdraw_history`
--
ALTER TABLE `ci_withdraw_history`
  ADD PRIMARY KEY (`withdraw_history_id`);

--
-- Indexes for table `ci_withdraw_status`
--
ALTER TABLE `ci_withdraw_status`
  ADD PRIMARY KEY (`withdraw_status_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_banner`
--
ALTER TABLE `ci_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  MODIFY `banner_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_blog_post_to_comment`
--
ALTER TABLE `ci_blog_post_to_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ci_country`
--
ALTER TABLE `ci_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `ci_currency`
--
ALTER TABLE `ci_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_customer`
--
ALTER TABLE `ci_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  MODIFY `customer_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_customer_deposit`
--
ALTER TABLE `ci_customer_deposit`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ci_customer_history`
--
ALTER TABLE `ci_customer_history`
  MODIFY `customer_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  MODIFY `customer_login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_customer_to_balance`
--
ALTER TABLE `ci_customer_to_balance`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `ci_customer_to_certificate`
--
ALTER TABLE `ci_customer_to_certificate`
  MODIFY `certificate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ci_customer_to_education`
--
ALTER TABLE `ci_customer_to_education`
  MODIFY `education_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_dispute`
--
ALTER TABLE `ci_dispute`
  MODIFY `dispute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ci_dispute_action`
--
ALTER TABLE `ci_dispute_action`
  MODIFY `dispute_action_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_dispute_history`
--
ALTER TABLE `ci_dispute_history`
  MODIFY `dispute_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_dispute_reason`
--
ALTER TABLE `ci_dispute_reason`
  MODIFY `dispute_reason_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ci_dispute_status`
--
ALTER TABLE `ci_dispute_status`
  MODIFY `dispute_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_download`
--
ALTER TABLE `ci_download`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_event`
--
ALTER TABLE `ci_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ci_extension`
--
ALTER TABLE `ci_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `ci_information`
--
ALTER TABLE `ci_information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_job`
--
ALTER TABLE `ci_job`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ci_language`
--
ALTER TABLE `ci_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_languages`
--
ALTER TABLE `ci_languages`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `ci_layout`
--
ALTER TABLE `ci_layout`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  MODIFY `layout_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  MODIFY `layout_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ci_message`
--
ALTER TABLE `ci_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ci_project`
--
ALTER TABLE `ci_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_project_award`
--
ALTER TABLE `ci_project_award`
  MODIFY `award_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_bids`
--
ALTER TABLE `ci_project_bids`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_project_bids_upgrade`
--
ALTER TABLE `ci_project_bids_upgrade`
  MODIFY `upgrade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_proposal`
--
ALTER TABLE `ci_project_proposal`
  MODIFY `proposal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_project_to_download`
--
ALTER TABLE `ci_project_to_download`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_to_message`
--
ALTER TABLE `ci_project_to_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_to_milestone`
--
ALTER TABLE `ci_project_to_milestone`
  MODIFY `milestone_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_to_upload`
--
ALTER TABLE `ci_project_to_upload`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_revenue`
--
ALTER TABLE `ci_revenue`
  MODIFY `revenue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_review`
--
ALTER TABLE `ci_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  MODIFY `seo_url_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

--
-- AUTO_INCREMENT for table `ci_university`
--
ALTER TABLE `ci_university`
  MODIFY `university_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `ci_university_majors`
--
ALTER TABLE `ci_university_majors`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ci_withdraw`
--
ALTER TABLE `ci_withdraw`
  MODIFY `withdraw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_withdraw_history`
--
ALTER TABLE `ci_withdraw_history`
  MODIFY `withdraw_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_withdraw_status`
--
ALTER TABLE `ci_withdraw_status`
  MODIFY `withdraw_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

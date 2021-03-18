-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 15, 2021 at 08:51 PM
-- Server version: 8.0.23
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `freelancer`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_banner`
--

CREATE TABLE `ci_banner` (
  `banner_id` int NOT NULL,
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
  `banner_image_id` int NOT NULL,
  `banner_id` int NOT NULL,
  `language_id` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
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
  `category_id` int NOT NULL,
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
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `tags` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `trending` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_blog_post`
--

INSERT INTO `ci_blog_post` (`post_id`, `user_id`, `category_id`, `title`, `body`, `tags`, `image`, `featured`, `trending`, `status`, `date_added`, `date_modified`) VALUES
(1, 0, 1, 'Sample Blog Post', 'test', '', '', 1, 1, 1, 0, 0),
(2, 0, 1, 'Sample Blog Post 2', '<p>Sample Blog Post 2<br></p>', '', '', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_blog_post_to_comment`
--

CREATE TABLE `ci_blog_post_to_comment` (
  `comment_id` int NOT NULL,
  `post_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_blog_post_to_comment`
--

INSERT INTO `ci_blog_post_to_comment` (`comment_id`, `post_id`, `name`, `email`, `website`, `comment`, `status`, `date_added`) VALUES
(1, 1, 'sssssss', 'ssss@fff.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, 0),
(2, 1, 'sssssss', 'ssss@fff.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, 0),
(3, 1, 'test', 'customer_3@demo.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, 0),
(4, 1, 'YallaHelp', 'customer_3@demo.com', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_category`
--

CREATE TABLE `ci_category` (
  `category_id` int NOT NULL,
  `parent_id` int NOT NULL DEFAULT '0',
  `icon` varchar(250) NOT NULL,
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category`
--

INSERT INTO `ci_category` (`category_id`, `parent_id`, `icon`, `top`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 0, 'fas fa-laptop-code', 0, 0, 1, 1615470076, 1615470076),
(2, 0, 'fas fa-mobile-alt', 0, 0, 1, 0, 0),
(3, 0, 'fas fa-laptop-code', 0, 0, 1, 0, 0),
(4, 0, 'fas fa-palette', 0, 0, 1, 1615470070, 1615470070),
(5, 0, 'fas fa-laptop-code', 0, 0, 1, 1615470053, 1615470053),
(8, 0, 'fas fa-ad', 0, 0, 1, 0, 0),
(11, 0, 'fas fa-language', 0, 0, 1, 0, 0),
(16, 1, 'fas fa-laptop-code', 0, 0, 1, 0, 0),
(21, 1, 'fas fa-laptop-code', 0, 0, 1, 0, 0),
(22, 1, 'fas fa-laptop-code', 0, 0, 1, 0, 0),
(26, 1, '', 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_category_description`
--

CREATE TABLE `ci_category_description` (
  `category_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_category_description`
--

INSERT INTO `ci_category_description` (`category_id`, `language_id`, `name`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(2, 1, 'Mobile Phones & Computing', '', '<strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.&nbsp;</span>', 'Mobile Phones & Computing', '', ''),
(3, 1, 'Writing & Content', '', 'Article Writing, Content Writing, Copywriting, Article Rewriting, Research Writing...', 'Writing & Content', '', ''),
(4, 1, 'Design, Media & Architecture', 'design-media-architecture', 'Website Design, Graphic Design, Photoshop, CSS, Logo Design...', 'Design, Media & Architecture', '', ''),
(8, 1, 'Sales & Marketing', '', 'Internet Marketing, Marketing, Social Media Marketing, Facebook Marketing, Sales...', 'Sales & Marketing', '', ''),
(11, 1, 'Translation & Languages', '', 'English (US), English (UK), English Grammar, Spanish, German...', 'Translation & Languages', '', ''),
(16, 1, ' Adobe Illustrator', '', '<p> Adobe Illustrator<br></p>', ' Adobe Illustrator', '', ''),
(21, 1, 'AJAX', '', '<p>AJAX<br></p>', 'AJAX', '', ''),
(22, 1, 'Apple Safari', '', '<p>Apple Safari<br></p>', 'Apple Safari', '', ''),
(26, 1, 'App Developer', '', '<p>App Developer<br></p>', 'App Developer', '', ''),
(1, 1, 'Websites, IT & Software', 'websites-it-software', 'PHP, HTML, WordPress, JavaScript, Software Architecture...', 'Websites, IT & Software', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_country`
--

CREATE TABLE `ci_country` (
  `country_id` int NOT NULL,
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
  `currency_id` int NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_currency`
--

INSERT INTO `ci_currency` (`currency_id`, `title`, `code`, `symbol_left`, `symbol_right`, `decimal_place`, `value`, `status`, `date_modified`) VALUES
(1, 'Egyptian Pound', 'EGP', '', 'L.E', '2', 1.00000000, 1, 0),
(2, 'US Dollar', 'USD', '$', '', '2', 0.06366873, 1, 0),
(6, 'Emirati Dirham', 'AED', '', 'AED', '', 0.23385489, 1, 0),
(8, 'Saudi Riyal', 'SAR', 'SAR', '', '', 0.23877320, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer`
--

CREATE TABLE `ci_customer` (
  `customer_id` int NOT NULL,
  `customer_group_id` int NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `viewed` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `code` varchar(40) NOT NULL,
  `image` varchar(255) NOT NULL,
  `bg_image` varchar(255) NOT NULL,
  `about` text,
  `tag_line` varchar(64) DEFAULT 'NULL',
  `rate` int NOT NULL,
  `origin` varchar(64) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `social` varchar(50) NOT NULL,
  `two_step` tinyint(1) NOT NULL,
  `profile_strength` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer`
--

INSERT INTO `ci_customer` (`customer_id`, `customer_group_id`, `firstname`, `lastname`, `username`, `email`, `telephone`, `password`, `ip`, `viewed`, `status`, `code`, `image`, `bg_image`, `about`, `tag_line`, `rate`, `origin`, `online`, `social`, `two_step`, `profile_strength`, `date_added`, `date_modified`) VALUES
(1, 1, 'Anna', 'Loue', 'anna_loue', 'employer@employer.com', '', '$2y$10$1ixd5RAOq586ee7GY1Bw3uc5kdYYd1iERcRCihM65cp.eh/13lvXO', '', 498, 1, '', 'users/1615302976_e0098eb8ab6bb342d6d1.png', 'users/1615302426_ac603adb8af0cd047e11.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Software Developer', 20, '', 1, '', 0, 80, 0, 1615810634),
(2, 1, 'Mike', 'Myers', 'mike_myers', 'freelancer@freelancer.com', '', '$2y$10$.XDdX8.lbpe9urwdF914fexBnzZMLR2vyV1dIDarg8SMEuq3lqqym', '', 123, 1, '', 'catalog/1610096668_6900a7ee7f037456b8de.png', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of ', 'UX|UI Developer', 40, '', 1, '', 0, 60, 0, 0),
(3, 1, 'Sindy', 'Forest', 'sindy_forest', 'freelancer2@freelancer.com', '', '$2y$10$.XDdX8.lbpe9urwdF914fexBnzZMLR2vyV1dIDarg8SMEuq3lqqym', '', 31, 1, '', 'catalog/1610096668_6900a7ee7f037456b8de.png', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of ', 'UX|UI Developer', 40, '', 1, '', 0, 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_activity`
--

CREATE TABLE `ci_customer_activity` (
  `customer_activity_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_activity`
--

INSERT INTO `ci_customer_activity` (`customer_activity_id`, `customer_id`, `key`, `data`, `ip`, `user_agent`, `seen`, `date_added`) VALUES
(1, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"project-test-2\",\"budget\":\"20 - 60\",\"href\":\"\\/service\\/2\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615476951),
(2, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asaassasas\",\"budget\":\"7 - 9\",\"href\":\"\\/service\\/3\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615479738),
(3, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asaassasas\",\"budget\":\"7 - 9\",\"href\":\"\\/service\\/4\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615479764),
(4, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"sdsdsdsdsdsd\",\"budget\":\"7 - 20\",\"href\":\"\\/service\\/5\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615479911),
(5, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asdsdadasddsd\",\"budget\":\"6 - 10\",\"href\":\"\\/service\\/6\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480018),
(6, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asassasasssasa\",\"budget\":\"9 - 16\",\"href\":\"\\/service\\/7\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480068),
(7, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asassasasssasa\",\"budget\":\"9 - 16\",\"href\":\"\\/service\\/8\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480080),
(8, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"asassasasssasa\",\"budget\":\"9 - 16\",\"href\":\"\\/service\\/9\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480324),
(9, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"sdasdasdasdsdsd\",\"budget\":\"21 - 24\",\"href\":\"\\/service\\/10\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480412),
(10, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"dsadsdsadasdadd\",\"budget\":\"12 - 26\",\"href\":\"\\/service\\/11\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 0, 1615480985),
(11, 2, 'admin_customer_login', '{\"customer_id\":2,\"username\":\"mike_myers\"}', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15', 0, 1615481573),
(12, 1, 'admin_customer_login', '{\"customer_id\":1,\"username\":\"anna_loue\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615544932),
(13, 1, 'admin_customer_login', '{\"customer_id\":1,\"username\":\"anna_loue\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615650225),
(14, 1, 'admin_customer_login', '{\"customer_id\":1,\"username\":\"anna_loue\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615755630),
(15, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"project 12 test\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/12\\/project-12-test\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615755966),
(16, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"project 12 new test\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/13\\/project-12-new-test\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615756039),
(17, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"project 12 new new\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/14\\/project-12-new-new\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615756073),
(18, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"The standard Lorem Ipsum passage, used since the 1500s\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/15\\/the-standard-lorem-ipsum-passage-used-since-the-1500s\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615756186),
(19, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"1914 translation by H. Rackham\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/16\\/1914-translation-by-h-rackham\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615756267),
(20, 1, 'project_add', '{\"customer_id\":\"1\",\"name\":\"project 1914\",\"budget\":\"30 - 68\",\"href\":\"\\/projects\\/17\\/project-1914\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615756349),
(21, 1, 'admin_customer_login', '{\"customer_id\":1,\"username\":\"anna_loue\"}', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 0, 1615796720),
(22, 1, 'admin_customer_login', '{\"customer_id\":1,\"username\":\"anna_loue\"}', '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:87.0) Gecko/20100101 Firefox/87.0', 0, 1615834618);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_deposit`
--

CREATE TABLE `ci_customer_deposit` (
  `balance_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `currency` varchar(30) NOT NULL,
  `gateway` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_group`
--

CREATE TABLE `ci_customer_group` (
  `customer_group_id` int NOT NULL,
  `approval` int NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_group`
--

INSERT INTO `ci_customer_group` (`customer_group_id`, `approval`, `sort_order`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_group_description`
--

CREATE TABLE `ci_customer_group_description` (
  `customer_group_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_group_description`
--

INSERT INTO `ci_customer_group_description` (`customer_group_id`, `language_id`, `name`, `description`) VALUES
(1, 1, 'Default', 'Default'),
(21, 1, 'test', 'test'),
(22, 1, 'new', 'newn'),
(23, 1, 'rrrr', 'rrrr'),
(24, 1, 'ddd', 'ddd'),
(25, 1, 'sss', 'ssss');

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_history`
--

CREATE TABLE `ci_customer_history` (
  `customer_history_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `comment` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_ip`
--

CREATE TABLE `ci_customer_ip` (
  `customer_ip_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_ip`
--

INSERT INTO `ci_customer_ip` (`customer_ip_id`, `customer_id`, `ip`, `user_agent`, `date_added`) VALUES
(1, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404559),
(2, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404561),
(3, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404561),
(4, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404562),
(5, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404562),
(6, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404563),
(7, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404564),
(8, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404566),
(9, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404567),
(10, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404568),
(11, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615404570),
(12, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615408087),
(13, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615409491),
(14, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615410023),
(15, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615410407),
(16, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615457326),
(17, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36 OPR/74.0.3911.203', 1615457566),
(18, 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15', 1615481573),
(19, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 1615544932),
(20, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 1615650225),
(21, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 1615755630),
(22, 1, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36 OPR/74.0.3911.218', 1615796720),
(23, 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:87.0) Gecko/20100101 Firefox/87.0', 1615834618);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_login`
--

CREATE TABLE `ci_customer_login` (
  `customer_login_id` int NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_login`
--

INSERT INTO `ci_customer_login` (`customer_login_id`, `email`, `ip`, `total`, `date_added`, `date_modified`) VALUES
(8, 'admin@admin.com', '::1', 3, 0, 0),
(9, '', '::1', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_online`
--

CREATE TABLE `ci_customer_online` (
  `ip` varchar(40) NOT NULL,
  `customer_id` int NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_online`
--

INSERT INTO `ci_customer_online` (`ip`, `customer_id`, `url`, `referer`, `date_added`) VALUES
('127.0.0.1', 1, 'http://freelancer.localhost/account/message/getTotalUnseenMessages', 'http://freelancer.localhost/projects/websites-it-software/project-1914', 1615840207);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_balance`
--

CREATE TABLE `ci_customer_to_balance` (
  `balance_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `project_id` int NOT NULL,
  `income` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `withdrawn` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `used` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `available` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `pending` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `currency` varchar(30) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_category`
--

CREATE TABLE `ci_customer_to_category` (
  `category_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_category`
--

INSERT INTO `ci_customer_to_category` (`category_id`, `freelancer_id`, `date_added`) VALUES
(1, 1, 1615224908),
(4, 1, 1615224908),
(5, 1, 1615226083),
(8, 1, 1615224908),
(21, 2, 0),
(22, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_certificate`
--

CREATE TABLE `ci_customer_to_certificate` (
  `certificate_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `year` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_certificate`
--

INSERT INTO `ci_customer_to_certificate` (`certificate_id`, `freelancer_id`, `name`, `year`, `date_added`) VALUES
(2, 1, 'dsdsd', '2021', 1615481623),
(6, 1, 'aasssas', '2021', 1615481767);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_education`
--

CREATE TABLE `ci_customer_to_education` (
  `education_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `university_id` int NOT NULL,
  `major_id` int NOT NULL,
  `title` varchar(32) NOT NULL,
  `year` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_education`
--

INSERT INTO `ci_customer_to_education` (`education_id`, `freelancer_id`, `university_id`, `major_id`, `title`, `year`, `country`, `date_added`) VALUES
(1, 2, 3, 1, 'ba', '2021', 'Albania', 0),
(2, 1, 1, 1, 'bm', '2021', 'Albania', 1615236127);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_language`
--

CREATE TABLE `ci_customer_to_language` (
  `language_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `level` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_language`
--

INSERT INTO `ci_customer_to_language` (`language_id`, `freelancer_id`, `level`, `date_added`) VALUES
(1, 1, '2', 1615236138),
(19, 2, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_customer_to_skill`
--

CREATE TABLE `ci_customer_to_skill` (
  `skill_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `level` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_customer_to_skill`
--

INSERT INTO `ci_customer_to_skill` (`skill_id`, `freelancer_id`, `level`, `date_added`) VALUES
(1, 1, '', 1615557163),
(11, 1, '', 1615557136);

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute`
--

CREATE TABLE `ci_dispute` (
  `dispute_id` int NOT NULL,
  `project_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `created_by` int NOT NULL,
  `comment` text NOT NULL,
  `dispute_status_id` int NOT NULL,
  `dispute_reason_id` int NOT NULL,
  `dispute_action_id` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_action`
--

CREATE TABLE `ci_dispute_action` (
  `dispute_action_id` int NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
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
  `dispute_history_id` int NOT NULL,
  `dispute_id` int NOT NULL,
  `dispute_status_id` int NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_dispute_reason`
--

CREATE TABLE `ci_dispute_reason` (
  `dispute_reason_id` int NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
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
  `dispute_status_id` int NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
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
  `download_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `ext` varchar(50) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_event`
--

CREATE TABLE `ci_event` (
  `event_id` int NOT NULL,
  `code` varchar(64) NOT NULL,
  `trigger` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `action` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `priority` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_event`
--

INSERT INTO `ci_event` (`event_id`, `code`, `trigger`, `action`, `description`, `status`, `priority`) VALUES
(1, 'admin_customer_login', '', 'Catalog\\Events\\ActivityEvent::customerLogin', '', 1, 1),
(4, 'project_add', '', 'Catalog\\Events\\ActivityEvent::projectAdd', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_extension`
--

CREATE TABLE `ci_extension` (
  `extension_id` int NOT NULL,
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
(110, 'job', 'job'),
(94, 'blogger', 'comment'),
(108, 'report', 'user_activity'),
(109, 'wallet', 'wallet'),
(111, 'module', 'employer_project'),
(113, 'module', 'bid_upgrade');

-- --------------------------------------------------------

--
-- Table structure for table `ci_information`
--

CREATE TABLE `ci_information` (
  `information_id` int NOT NULL,
  `bottom` int NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_information`
--

INSERT INTO `ci_information` (`information_id`, `bottom`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, 1, 0, 1, 1615464867, 1615464867),
(2, 1, 3, 1, 0, 4294967295),
(3, 1, 1, 1, 1615466820, 1615466820),
(4, 0, 0, 1, 0, 4294967295);

-- --------------------------------------------------------

--
-- Table structure for table `ci_information_description`
--

CREATE TABLE `ci_information_description` (
  `information_id` int NOT NULL,
  `language_id` int NOT NULL,
  `title` varchar(64) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_information_description`
--

INSERT INTO `ci_information_description` (`information_id`, `language_id`, `title`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(5, 1, 'new info page', '', '<p>new info page<br></p>', 'new info page', '', ''),
(3, 1, 'Privacy Policy', 'privacy-policy', '<p><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; font-size: 14px; text-align: justify;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span><br></p>\r\n', 'Privacy Policy', '', ''),
(1, 1, 'Terms & Conditions', 'terms-conditions', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span><span style=\"color: rgb(0, 0, 0); font-family: \"Open Sans\", Arial, sans-serif; text-align: justify;\"><br></span></p>', 'Terms & Conditions', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_job`
--

CREATE TABLE `ci_job` (
  `job_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `salary` decimal(15,4) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `viewed` int NOT NULL,
  `sort_order` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_job_applicants`
--

CREATE TABLE `ci_job_applicants` (
  `job_applicant_id` int NOT NULL,
  `job_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `download_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_job_description`
--

CREATE TABLE `ci_job_description` (
  `job_id` int NOT NULL,
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
(1, 'Simple Local Job', '<p><strong style=\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Lorem Ipsum</strong><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>', '', '', 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `ci_language`
--

CREATE TABLE `ci_language` (
  `language_id` int NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_language`
--

INSERT INTO `ci_language` (`language_id`, `name`, `code`, `locale`, `sort_order`, `status`) VALUES
(1, 'English', 'en', 'en-gb,en', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_languages`
--

CREATE TABLE `ci_languages` (
  `language_id` int NOT NULL,
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
  `layout_id` int NOT NULL,
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
(11, 'Information'),
(17, 'Project-info');

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_module`
--

CREATE TABLE `ci_layout_module` (
  `layout_module_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_layout_module`
--

INSERT INTO `ci_layout_module` (`layout_module_id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
(142, 1, 'category', 'content_top', 3),
(141, 1, 'featured', 'content_top', 2),
(140, 1, 'video.9', 'content_top', 1),
(139, 1, 'html.6', 'content_bottom', 2),
(138, 1, 'freelancer', 'content_bottom', 1),
(143, 1, 'html.5', 'content_top', 4),
(136, 17, 'html.10', 'column_right', 2),
(137, 17, 'employer_project', 'column_right', 3),
(135, 17, 'html.11', 'column_right', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_layout_route`
--

CREATE TABLE `ci_layout_route` (
  `layout_route_id` int NOT NULL,
  `layout_id` int NOT NULL,
  `site_id` int NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_layout_route`
--

INSERT INTO `ci_layout_route` (`layout_route_id`, `layout_id`, `site_id`, `route`) VALUES
(55, 1, 0, '/'),
(7, 6, 0, 'account/(:any)'),
(40, 3, 0, 'project/category'),
(54, 17, 0, 'project/project');

-- --------------------------------------------------------

--
-- Table structure for table `ci_messages`
--

CREATE TABLE `ci_messages` (
  `message_id` int NOT NULL,
  `thread_id` varchar(32) NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `project_id` int NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_messages`
--

INSERT INTO `ci_messages` (`message_id`, `thread_id`, `sender_id`, `receiver_id`, `project_id`, `message`, `seen`, `date_added`, `date_modified`) VALUES
(3, 'd81c071e94', 0, 1, 0, 'Hi anna_loue, I noticed your profile and would like to offer you my project. We can discuss any details over chat.', 0, 1615284480, 1615284480),
(4, 'd81c071e94', 0, 1, 0, 'Hi anna_loue, I noticed your profile and would like to offer you my project. We can discuss any details over chat.', 0, 1615284499, 1615284499),
(5, 'd81c071e94', 2, 1, 0, 'Hi anna_loue, I noticed your profile and would like to offer you my project. We can discuss any details over chat.', 0, 1615284578, 1615284578),
(6, 'b2078695bf', 2, 3, 0, 'Hi sindy_forest, I noticed your profile and would like to offer you my project. We can discuss any details over chat.', 0, 1615284658, 1615284658);

-- --------------------------------------------------------

--
-- Table structure for table `ci_module`
--

CREATE TABLE `ci_module` (
  `module_id` int NOT NULL,
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
(6, 'Testimonials', 'html', '{\"name\":\"Testimonials\",\"module_description\":{\"title\":\"\",\"description\":\"<!-- Testimonials -->\\r\\n<div class=\\\"section gray padding-top-65 padding-bottom-55\\\">\\r\\n\\t\\r\\n\\t<div class=\\\"container\\\">\\r\\n\\t\\t<div class=\\\"row\\\">\\r\\n\\t\\t\\t<div class=\\\"col-xl-12\\\">\\r\\n\\t\\t\\t\\t<!-- Section Headline -->\\r\\n\\t\\t\\t\\t<div class=\\\"section-headline centered margin-top-0 margin-bottom-5\\\">\\r\\n\\t\\t\\t\\t\\t<h3>Testimonials<\\/h3>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n\\r\\n\\t<!-- Categories Carousel -->\\r\\n\\t<div class=\\\"fullwidth-carousel-container margin-top-20\\\">\\r\\n\\t\\t<div class=\\\"testimonial-carousel testimonials\\\">\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/catalog\\/avatar.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Sindy Forest<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/catalog\\/avatar.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Tom Smith<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/catalog\\/avatar.png\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Sebastiano Piccio<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Employer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas. Dynamically innovate resource-leveling customer service for state of the art.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/catalog\\/avatar.jpg\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>David Peterson<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services. Seamlessly empower fully researched growth strategies and interoperable sources.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<!-- Item -->\\r\\n\\t\\t\\t<div class=\\\"fw-carousel-review\\\">\\r\\n\\t\\t\\t\\t<div class=\\\"testimonial-box\\\">\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-avatar\\\">\\r\\n\\t\\t\\t\\t\\t\\t<img src=\\\"images\\/catalog\\/avatar.png\\\" alt=\\\"\\\">\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial-author\\\">\\r\\n\\t\\t\\t\\t\\t\\t<h4>Marcin Kowalski<\\/h4>\\r\\n\\t\\t\\t\\t\\t\\t <span>Freelancer<\\/span>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<div class=\\\"testimonial\\\">Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas. Dramatically maintain clicks-and-mortar solutions without functional solutions.<\\/div>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n\\t<!-- Categories Carousel \\/ End --><\\/div>\"},\"status\":\"1\"}'),
(5, 'How It Works', 'html', '{\"name\":\"How It Works\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"section padding-top-65 padding-bottom-65\\\">\\r\\n\\t<div class=\\\"container\\\">\\r\\n\\t\\t<div class=\\\"row\\\">\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-12\\\">\\r\\n\\t\\t\\t\\t<!-- Section Headline -->\\r\\n\\t\\t\\t\\t<div class=\\\"section-headline centered margin-top-0 margin-bottom-5\\\">\\r\\n\\t\\t\\t\\t\\t<h3>How It Works?<\\/h3>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box with-line\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\"icon-line-awesome-lock\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Create an Account<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Bring to the table win-win survival strategies to ensure proactive domination going forward.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box with-line\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\"icon-line-awesome-legal\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Post a Task<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Efficiently unleash cross-media information without. Quickly maximize return on investment.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t\\t<div class=\\\"col-xl-4 col-md-4\\\">\\r\\n\\t\\t\\t\\t<!-- Icon Box -->\\r\\n\\t\\t\\t\\t<div class=\\\"icon-box\\\">\\r\\n\\t\\t\\t\\t\\t<!-- Icon -->\\r\\n\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle\\\">\\r\\n\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-circle-inner\\\">\\r\\n\\t\\t\\t\\t\\t\\t\\t<i class=\\\" icon-line-awesome-trophy\\\"><\\/i>\\r\\n\\t\\t\\t\\t\\t\\t\\t<div class=\\\"icon-box-check\\\"><i class=\\\"icon-material-outline-check\\\"><\\/i><\\/div>\\r\\n\\t\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t\\t\\t<h3>Choose an Expert<\\/h3>\\r\\n\\t\\t\\t\\t\\t<p>Nanotechnology immersion along the information highway will close the loop on focusing solely.<\\/p>\\r\\n\\t\\t\\t\\t<\\/div>\\r\\n\\t\\t\\t<\\/div>\\r\\n\\r\\n\\t\\t<\\/div>\\r\\n\\t<\\/div>\\r\\n<\\/div>\"},\"status\":\"1\"}'),
(9, 'Home Page Video', 'video', '{\"name\":\"Home Page Video\",\"module_description\":{\"mp4\":\"catalog\\/video\\/intro.mp4\",\"webm\":\"catalog\\/video\\/intro.webm\",\"image\":\"catalog\\/video\\/intro.png\"},\"status\":\"1\"}'),
(10, 'Help Bidding', 'html', '{\"name\":\"Help Bidding\",\"module_description\":{\"title\":\"How to write a winning bid\",\"description\":\"<ul><li>Your best chance of winning this project is writing a great bid proposal here!<\\/li><li><span style=\\\"font-size: 1rem;\\\">Great bids are ones that: Are engaging and well written without spelling or grammatical errors<\\/span><\\/li><li><span style=\\\"font-size: 1rem;\\\">Show a clear understanding of what is required for this specific project - personalise your response!<\\/span><\\/li><li><span style=\\\"font-size: 1rem;\\\">Explain how your skills &amp; experience relate to the project and your approach to working on it<\\/span><\\/li><li><span style=\\\"font-size: 1rem;\\\">Ask questions to clarify any unclear details<\\/span><\\/li><li><span style=\\\"font-size: 1rem;\\\">Most of all - don\'t spam or post cut-and-paste bids. You will be <\\/span>penalised<span style=\\\"font-size: 1rem;\\\">&nbsp;or banned if you do so,<\\/span><\\/li><\\/ul><div><br><\\/div>\"},\"status\":\"1\"}'),
(11, 'add-project Button', 'html', '{\"name\":\"add-project Button\",\"module_description\":{\"title\":\"\",\"description\":\"<div class=\\\"bidding-widget text-white text-center\\\">\\r\\n       <a href=\\\"\\/add-project\\\" class=\\\"button btn-block ripple-effect button-sliding-icon\\\">Post a project like this <i class=\\\"fas fa-long-arrow-alt-right\\\"><\\/i><\\/a>\\r\\n      <\\/div>\"},\"status\":\"1\"}');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project`
--

CREATE TABLE `ci_project` (
  `project_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `freelancer_id` int NOT NULL DEFAULT '0',
  `budget_min` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `budget_max` decimal(15,4) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '"1:Fixed", "2:Hour"',
  `delivery_time` int NOT NULL,
  `runtime` int NOT NULL,
  `viewed` int NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `sort_order` int NOT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `download_id` tinyint(1) NOT NULL,
  `freelancer_review_id` int NOT NULL,
  `employer_review_id` int NOT NULL,
  `draft` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project`
--

INSERT INTO `ci_project` (`project_id`, `employer_id`, `freelancer_id`, `budget_min`, `budget_max`, `type`, `delivery_time`, `runtime`, `viewed`, `image`, `sort_order`, `status_id`, `download_id`, `freelancer_review_id`, `employer_review_id`, `draft`, `date_added`, `date_modified`) VALUES
(1, 1, 0, '20.0000', '50.0000', 1, 30, 30, 2, '', 0, 8, 0, 0, 0, 0, 1615476897, 1615476897),
(2, 2, 0, '20.0000', '60.0000', 1, 30, 30, 1, '', 0, 8, 0, 0, 0, 0, 1615476951, 1615476951),
(3, 1, 0, '7.0000', '9.0000', 1, 13, 14, 2, '', 0, 8, 0, 0, 0, 0, 1615479738, 1615479738),
(4, 1, 0, '7.0000', '9.0000', 1, 13, 14, 1, '', 0, 8, 0, 0, 0, 0, 1615479764, 1615479764),
(5, 1, 0, '7.0000', '20.0000', 1, 15, 27, 1, '', 0, 8, 0, 0, 0, 0, 1615479911, 1615479911),
(6, 1, 0, '6.0000', '10.0000', 1, 9, 23, 112, '', 0, 8, 0, 0, 0, 0, 1615480018, 1615480018),
(7, 1, 0, '9.0000', '16.0000', 1, 7, 10, 3, '', 0, 8, 0, 0, 0, 0, 1615480068, 1615480068),
(8, 1, 0, '9.0000', '16.0000', 1, 7, 10, 0, '', 0, 8, 0, 0, 0, 0, 1615480080, 1615480080),
(9, 1, 0, '9.0000', '16.0000', 1, 7, 10, 1, '', 0, 8, 0, 0, 0, 0, 1615480324, 1615480324),
(10, 1, 0, '21.0000', '24.0000', 1, 29, 30, 16, '', 0, 8, 0, 0, 0, 0, 1615480412, 1615480412),
(11, 1, 0, '12.0000', '26.0000', 1, 17, 30, 325, '', 0, 8, 0, 0, 0, 0, 1615480985, 1615480985),
(12, 1, 0, '30.0000', '68.0000', 1, 27, 30, 0, '', 0, 8, 0, 0, 0, 0, 1615755966, 1615755966),
(13, 1, 0, '30.0000', '68.0000', 1, 27, 30, 0, '', 0, 8, 0, 0, 0, 0, 1615756039, 1615756039),
(14, 1, 0, '30.0000', '68.0000', 1, 27, 30, 11, '', 0, 8, 0, 0, 0, 0, 1615756073, 1615756073),
(15, 1, 0, '30.0000', '68.0000', 1, 27, 30, 0, '', 0, 8, 0, 0, 0, 0, 1615756186, 1615756186),
(16, 2, 0, '30.0000', '68.0000', 1, 27, 30, 6, '', 0, 8, 0, 0, 0, 0, 1615756267, 1615756267),
(17, 2, 0, '30.0000', '68.0000', 1, 27, 30, 74, '', 0, 8, 0, 0, 0, 0, 1615756349, 1615756349);

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_award`
--

CREATE TABLE `ci_project_award` (
  `award_id` int NOT NULL,
  `project_id` int NOT NULL,
  `bid_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `delivery_time` int NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `deposite` decimal(15,4) NOT NULL,
  `status_id` tinyint NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_bids`
--

CREATE TABLE `ci_project_bids` (
  `bid_id` int NOT NULL,
  `project_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `quote` decimal(15,0) NOT NULL,
  `delivery` tinyint(1) NOT NULL,
  `selected` tinyint(1) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_bids_upgrade`
--

CREATE TABLE `ci_project_bids_upgrade` (
  `upgrade_id` int NOT NULL,
  `bid_id` int NOT NULL,
  `project_id` int NOT NULL,
  `payer_id` int NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_description`
--

CREATE TABLE `ci_project_description` (
  `project_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_description`
--

INSERT INTO `ci_project_description` (`project_id`, `language_id`, `name`, `keyword`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'project-1', 'project-1', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(2, 1, 'project-2', 'project-2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(3, 1, 'project-3', 'project-3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(4, 1, 'project-4', 'project-4', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(5, 1, 'project-5', 'project-5', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(6, 1, 'project-6', 'project-6', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(7, 1, 'project-7', 'project-7', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(8, 1, 'project-8', 'project-8', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(9, 1, 'project-9', 'project-9', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(10, 1, 'project-10', 'project-10', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(11, 1, 'project-11', 'project-11', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '', '', ''),
(12, 1, 'project 12 test', 'project-12-test', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', ''),
(13, 1, 'project 12 new test', 'project-12-new-test', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', ''),
(14, 1, 'project 12 new new', 'project-12-new-new', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', ''),
(15, 1, 'The standard Lorem Ipsum passage, used since the 1500s', 'the-standard-lorem-ipsum-passage-used-since-the-1500s', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', ''),
(16, 1, '1914 translation by H. Rackham', '1914-translation-by-h-rackham', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', ''),
(17, 1, 'project 1914', 'project-1914', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_proposal`
--

CREATE TABLE `ci_project_proposal` (
  `proposal_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `budget_min` int NOT NULL,
  `type` tinyint(1) NOT NULL,
  `delivery_time` int NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_status`
--

CREATE TABLE `ci_project_status` (
  `status_id` int NOT NULL,
  `language_id` int NOT NULL,
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
  `project_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_project_to_category`
--

INSERT INTO `ci_project_to_category` (`project_id`, `category_id`) VALUES
(1, 1),
(1, 4),
(1, 8),
(2, 1),
(2, 8),
(3, 8),
(4, 8),
(5, 1),
(6, 4),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 4),
(12, 1),
(12, 8),
(13, 1),
(13, 8),
(14, 1),
(14, 8),
(15, 1),
(15, 8),
(16, 1),
(16, 8),
(17, 1),
(17, 8);

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_download`
--

CREATE TABLE `ci_project_to_download` (
  `download_id` int NOT NULL,
  `project_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `url` varchar(128) NOT NULL,
  `count` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_project_to_milestone`
--

CREATE TABLE `ci_project_to_milestone` (
  `milestone_id` int NOT NULL,
  `project_id` int NOT NULL,
  `created_by` int NOT NULL,
  `created_for` int NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `deadline` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_revenue`
--

CREATE TABLE `ci_revenue` (
  `revenue_id` int NOT NULL,
  `project_id` int NOT NULL,
  `payer_id` int NOT NULL,
  `payer` varchar(50) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_review`
--

CREATE TABLE `ci_review` (
  `review_id` int NOT NULL,
  `project_id` int NOT NULL,
  `freelancer_id` int NOT NULL,
  `employer_id` int NOT NULL,
  `comment` text NOT NULL,
  `rating` int NOT NULL,
  `recommended` int NOT NULL,
  `ontime` int NOT NULL,
  `submitted_by` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_seo_url`
--

CREATE TABLE `ci_seo_url` (
  `seo_url_id` int NOT NULL,
  `site_id` int NOT NULL,
  `language_id` int NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_seo_url`
--

INSERT INTO `ci_seo_url` (`seo_url_id`, `site_id`, `language_id`, `query`, `keyword`) VALUES
(1, 0, 1, 'project_id=2', 'projectname-1'),
(2, 0, 1, 'project_id=3', 'projectname-1'),
(3, 0, 1, 'project_id=4', 'project-test-2'),
(4, 0, 1, 'category_id=16', 'adobe');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('36paucd3fethq921om1lbifecr4agbqp', '::1', 1615668259, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353636383235393b5f63695f70726576696f75735f75726c7c733a3130393a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266c61796f75745f69643d3137223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b),
('4rusf5lnc7q9uo3slm1uqndeg3egkrni', '::1', 1615668846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353636383834363b5f63695f70726576696f75735f75726c7c733a3130323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f68746d6c3f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266d6f64756c655f69643d3130223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b),
('83mn6qppkrpv8i3ne9jv1uqrftsb6p1u', '::1', 1615669148, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353636393134383b5f63695f70726576696f75735f75726c7c733a3130393a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266c61796f75745f69643d3137223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b6572726f725f7761726e696e677c733a34383a224c61796f7574204e616d65206d757374206265206265747765656e203320616e64203634206368617261637465727321223b5f5f63695f766172737c613a313a7b733a31333a226572726f725f7761726e696e67223b733a333a226e6577223b7d),
('1esevgiqhtb19vp15qrtdc7mb447j37f', '::1', 1615669458, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353636393435383b5f63695f70726576696f75735f75726c7c733a3130323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f68746d6c3f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266d6f64756c655f69643d3131223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b),
('ld4deq2tt8qo9pp1q5ju7cj5dn2epn8k', '::1', 1615669760, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353636393736303b5f63695f70726576696f75735f75726c7c733a3130323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f68746d6c3f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266d6f64756c655f69643d3131223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b),
('2focq47ctkalkq29puranj1ih7qjlpia', '::1', 1615671238, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353637313233383b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206d6f64756c657321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('smotd30svdjahm0n1vsbqjqkr2n5h2hq', '::1', 1615671238, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353637313233383b5f63695f70726576696f75735f75726c7c733a3131323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c652f64656c6574653f757365725f746f6b656e3d4e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41266d6f64756c655f69643d3132223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a224e584f77677262714d6349324b69783444386f4a377a564c435973466a516c41223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206d6f64756c657321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226e6577223b7d),
('hie08o70n3p7ugglbicjf2e3u1i66itu', '::1', 1615722922, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732323932323b5f63695f70726576696f75735f75726c7c733a3130393a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a266c61796f75745f69643d3137223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('8u8i45icbbvcjt5ul2cc78ec8mrs4scq', '::1', 1615723236, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732333233363b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('bnhg0kijbg7nlbdhg0lqnan2o0bqemb5', '::1', 1615723555, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732333535353b5f63695f70726576696f75735f75726c7c733a3130313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f656d706c6f7965725f70726f6a6563743f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('8h95c3pt6cj80nrra1mgdu2gtk8em194', '::1', 1615723884, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732333838343b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f66656174757265643f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('ftipdrfnvb0n1dlgo7ukvpohf368ob23', '::1', 1615724326, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732343332363b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('g3abp0dtv6f8lrf6mpiqt3lfebot7vfu', '::1', 1615725537, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732353533373b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('ljviemhimfmka27mq0uv5p935du68426', '::1', 1615726568, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732363536383b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('b8j5d28kpre6rq1qgapq054oa95msv39', '::1', 1615726980, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732363938303b5f63695f70726576696f75735f75726c7c733a3130303a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f70726f6a6563745f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('5lb5h8qb82dbmlu6ehr33o7le575arab', '::1', 1615727283, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732373238333b5f63695f70726576696f75735f75726c7c733a38373a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f757365722f757365723f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('u3redf66af0okic9ulllp30qds7bs4m1', '::1', 1615727767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732373736373b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('rppdql9a20qdrd4i4f9agjoi4foarbgu', '::1', 1615728118, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732383131383b5f63695f70726576696f75735f75726c7c733a3130303a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f70726f6a6563745f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('9gf4dbppuf620h13ge1pks0rbc3ldlog', '::1', 1615728437, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732383433373b5f63695f70726576696f75735f75726c7c733a3130303a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f70726f6a6563745f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('25toqq8tqdp25a7vs6bo58gpbif1127n', '::1', 1615728794, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732383739343b5f63695f70726576696f75735f75726c7c733a3130303a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f70726f6a6563745f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('bba93bf9aht5ocngt46udlvb6lbengjd', '::1', 1615729173, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732393137333b5f63695f70726576696f75735f75726c7c733a3130303a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f70726f6a6563745f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('ftjnv20bga4n9cnj7v1hm7on3fvttv2d', '::1', 1615729525, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353732393532353b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f6269645f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('3atavh54ae93uflmocacgnavou94926t', '::1', 1615730639, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353733303633393b5f63695f70726576696f75735f75726c7c733a3130383a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('8eb0k627qqp8bo680j4j0v6htil4sr22', '::1', 1615731317, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353733313331373b5f63695f70726576696f75735f75726c7c733a39363a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f6d6f64756c652f6269645f757067726164653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b),
('rgqrjopfbusgdcas3h51t0qhefgtur1k', '::1', 1615731317, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353733313331373b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d637558353961563443535470446a69646e67727162747642795248383136304a223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22637558353961563443535470446a69646e67727162747642795248383136304a223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206d6f64756c657321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('cb26r3adkfqjrjvg75mktpfqf1kgckt8', '::1', 1615741675, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353734313637353b5f63695f70726576696f75735f75726c7c733a39323a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f73657474696e672f6d6f64756c653f757365725f746f6b656e3d6f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b),
('46nls3t0ekvkipfjrnqlqcfl0bb6nqkr', '::1', 1615745602, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353734353630323b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d6f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('8h032q69ibmkuictdqhljvn6i5980uhg', '::1', 1615745991, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353734353939313b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d6f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('oam3677mcnak6ee7vskp4vcckovi729j', '::1', 1615746001, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353734353939313b5f63695f70726576696f75735f75726c7c733a39313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75743f757365725f746f6b656e3d6f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226f3379344e73554b72667851386e6a547a6d744f56435367504c6b36614a3270223b737563636573737c733a33353a22537563636573733a20596f752068617665206d6f646966696564206c61796f75747321223b5f5f63695f766172737c613a313a7b733a373a2273756363657373223b733a333a226f6c64223b7d),
('33hkluhod1trum6j14md97nh93g2irpj', '::1', 1615794674, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353739343637343b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a37313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d64657369676e2532466c61796f7574223b),
('8u34k25ofa1rkdsft87aa9g9c73c5mda', '::1', 1615814403, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831343430333b5f63695f70726576696f75735f75726c7c733a39343a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f64617368626f6172643f757365725f746f6b656e3d794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b),
('pbmkmq9oq1be9d777e4egihsq5v1q89n', '::1', 1615815761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831353736313b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636174616c6f672f70726f6a6563743f757365725f746f6b656e3d794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b),
('e8vv75tu2oelqa85m2m9tku7igd3de2m', '::1', 1615815761, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831353736313b5f63695f70726576696f75735f75726c7c733a39333a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636174616c6f672f70726f6a6563743f757365725f746f6b656e3d794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a22794f5a304d7a44707766346878714631625276556f61507356416e4236455933223b),
('kvk3uqj7qnl1ssirr2co7coll7qqkfon', '127.0.0.1', 1615817364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831373130323b5f63695f70726576696f75735f75726c7c733a3130383a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f64657369676e2f6c61796f75742f656469743f757365725f746f6b656e3d6233564e7154434a6f30456b74415a5566446d617a3742503864494c52484f6e266c61796f75745f69643d31223b757365725f69647c733a313a2231223b757365726e616d657c733a383a224a6f686e2044756f223b757365725f67726f75705f69647c733a313a2231223b69734c6f676765647c623a313b757365725f746f6b656e7c733a33323a226233564e7154434a6f30456b74415a5566446d617a3742503864494c52484f6e223b),
('svro5huamlbc57atnokn8uvecv9d7qr3', '127.0.0.1', 1615817278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831373237383b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
('nnqu1ufnc07guk5hf81vi4hl199eblke', '127.0.0.1', 1615817278, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831373237383b5f63695f70726576696f75735f75726c7c733a37313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d64657369676e2532466c61796f7574223b),
('9f047013phjen4a7ivgckfk56oh0cqi7', '127.0.0.1', 1615817578, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831373537383b6572726f727c733a34323a22496e76616c696420746f6b656e2073657373696f6e2e20506c65617365206c6f67696e20616761696e2e223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
('gl0hhe4h7cfidrp539i2kntnbb7tdmpb', '127.0.0.1', 1615817578, 0x5f5f63695f6c6173745f726567656e65726174657c693a313631353831373537383b5f63695f70726576696f75735f75726c7c733a37313a22687474703a2f2f667265656c616e6365722e6c6f63616c686f73742f61646d696e2f636f6d6d6f6e2f6c6f67696e3f72656469726563743d64657369676e2532466c61796f7574223b);

-- --------------------------------------------------------

--
-- Table structure for table `ci_setting`
--

CREATE TABLE `ci_setting` (
  `setting_id` int NOT NULL,
  `site_id` int NOT NULL DEFAULT '0',
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
(1035, 0, 'config', 'config_maintenance', '0', 0),
(1036, 0, 'config', 'config_global_alert', '', 0),
(1037, 0, 'config', 'config_file_ext_allowed', 'zip\r\ntxt\r\npng\r\njpe\r\njpeg\r\njpg\r\ngif\r\nbmp\r\nico\r\ntiff\r\ntif\r\nsvg\r\nsvgz\r\nzip\r\nrar\r\nmsi\r\ncab\r\nmp3\r\nqt\r\nmov\r\npdf\r\npsd\r\nai\r\neps\r\nps\r\ndoc', 0),
(1038, 0, 'config', 'config_file_mime_allowed', 'text/plain\r\nimage/png\r\nimage/jpeg\r\nimage/gif\r\nimage/bmp\r\nimage/tiff\r\nimage/svg+xml\r\napplication/zip\r\n\"application/zip\"\r\napplication/x-zip\r\n\"application/x-zip\"\r\napplication/x-zip-compressed\r\n\"application/x-zip-compressed\"\r\napplication/rar\r\n\"application/rar\"\r\napplication/x-rar\r\n\"application/x-rar\"\r\napplication/x-rar-compressed\r\n\"application/x-rar-compressed\"\r\napplication/octet-stream\r\n\"application/octet-stream\"\r\naudio/mpeg\r\nvideo/quicktime\r\napplication/pdf', 0),
(518, 0, 'dashboard_online', 'dashboard_online_sort_order', '1', 0),
(564, 0, 'blog_extension', 'blog_extension_status', '1', 0),
(659, 0, 'job_extension', 'job_extension_status', '1', 0),
(453, 0, 'module_category', 'module_category_status', '1', 0),
(1002, 0, 'module_featured', 'module_featured_status', '1', 0),
(1001, 0, 'module_featured', 'module_featured_limit', '8', 0),
(340, 0, 'theme_default', 'theme_default_status', '1', 0),
(338, 0, 'theme_default', 'theme_default_directory', 'default', 0),
(1034, 0, 'config', 'config_social_networks', '[{\"name\":\"Facebook\",\"href\":\"https:\\/\\/www.facebook.com\\/Yallafreelancer\\/\"},{\"name\":\"Pinterest\",\"href\":\"https:\\/\\/www.pinterest.com\\/yallafreelancers\\/\"},{\"name\":\"Twitter\",\"href\":\"https:\\/\\/twitter.com\\/yallfreelancer\"}]', 1),
(339, 0, 'theme_default', 'theme_default_color', 'red.css', 0),
(331, 0, 'extension_bid', 'extension_bid_status', '1', 0),
(513, 0, 'dashboard_activity', 'dashboard_activity_width', '12', 0),
(452, 0, 'module_freelancer', 'module_freelancer_status', '1', 0),
(451, 0, 'module_freelancer', 'module_freelancer_limit', '8', 0),
(517, 0, 'dashboard_online', 'dashboard_online_status', '1', 0),
(516, 0, 'dashboard_online', 'dashboard_online_width', '3', 0),
(1027, 0, 'config', 'config_customer_activity', '1', 0),
(1028, 0, 'config', 'config_customer_online', '1', 0),
(1029, 0, 'config', 'config_freelancer_fee', '', 0),
(1030, 0, 'config', 'config_processing_fee', '2.3', 0),
(1033, 0, 'config', 'config_chat_widget', '<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/5f7ed980f0e7167d00172fcb/default\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->', 0),
(1026, 0, 'config', 'config_project_expired_status', '5', 0),
(1025, 0, 'config', 'config_project_completed_status', '2', 0),
(1024, 0, 'config', 'config_project_status_id', '8', 0),
(1023, 0, 'config', 'config_login_attempts', '5', 0),
(1022, 0, 'config', 'config_admin_limit', '20', 0),
(1021, 0, 'config', 'config_currency', 'EGP', 0),
(657, 0, 'report_user_activity', 'report_user_activity_sort_order', '1', 0),
(656, 0, 'report_user_activity', 'report_user_activity_status', '1', 0),
(1020, 0, 'config', 'config_admin_language_id', '1', 0),
(1019, 0, 'config', 'config_language_id', '1', 0),
(1018, 0, 'config', 'config_telephone', '+00 000-00-000', 0),
(1017, 0, 'config', 'config_email', 'admin@admin.com', 0),
(1016, 0, 'config', 'config_address', '6th Forrest Ray, London - 10001 UK', 0),
(1015, 0, 'config', 'config_owner', 'Ahmed Atwa', 0),
(1014, 0, 'config', 'config_name', 'YallaFreelancer', 0),
(1013, 0, 'config', 'config_logo', 'catalog/logo.png', 0),
(1012, 0, 'config', 'config_theme', 'default', 0),
(1011, 0, 'config', 'config_meta_keyword', '', 0),
(1010, 0, 'config', 'config_meta_description', 'Yallafreelancer mission is to change how the world works together. Yallafreelancer connects businesses with freelancers offering digital services in 300+ categories.', 0),
(1009, 0, 'config', 'config_meta_title', 'Freelance Services Marketplace for Businesses in Egypt', 0),
(1008, 0, 'module_employer_project', 'module_employer_project_status', '1', 0),
(1007, 0, 'module_employer_project', 'module_employer_project_limit', '8', 0),
(1051, 0, 'module_bid_upgrade', 'module_bid_upgrade_setting', '[{\"name\":\"Sponsored\",\"fee\":\"5\",\"description\":\"Bids that are sponsored are 518% more likely to be awarded. Stand out from the rest of the freelancers, by being pinned to the top of the employer\'s bid list. There is only one sponsored bid per project.\"},{\"name\":\"Sealed\",\"fee\":\"0.2\",\"description\":\"Upgrading to a sealed entry will hide your bid from other freelancers. This keeps others from copying your work, making your bid one-of-a-kind.\"},{\"name\":\"Highlight\",\"fee\":\"2\",\"description\":\"Make your bid highlighted in yellow for greater visibility to the employer and a higher chance of being awarded the project.\"}]', 1),
(1052, 0, 'module_bid_upgrade', 'module_bid_upgrade_status', '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_skills`
--

CREATE TABLE `ci_skills` (
  `skill_id` int NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_skills`
--

INSERT INTO `ci_skills` (`skill_id`, `name`, `status`, `date_added`, `date_modified`) VALUES
(1, 'HTML/CSS', 1, 2021, 2021),
(2, 'JavaScript', 1, 2021, 2021),
(4, 'jQuery', 1, 2021, 2021),
(5, 'Git/Version Control', 1, 2021, 2021),
(6, 'RESTful Services/APIs', 1, 2021, 2021),
(7, 'Bootstrap', 1, 2021, 2021),
(8, 'ReactJS', 1, 2021, 2021),
(9, 'Ember', 1, 2021, 2021),
(10, 'Backbone', 1, 2021, 2021),
(11, 'AngularJS', 1, 2021, 2021),
(12, 'VUE', 1, 2021, 2021);

-- --------------------------------------------------------

--
-- Table structure for table `ci_university`
--

CREATE TABLE `ci_university` (
  `university_id` int NOT NULL,
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
  `major_id` int NOT NULL,
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
-- Table structure for table `ci_upload`
--

CREATE TABLE `ci_upload` (
  `upload_id` int NOT NULL,
  `project_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `size` varchar(32) NOT NULL,
  `ext` varchar(32) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_upload`
--

INSERT INTO `ci_upload` (`upload_id`, `project_id`, `customer_id`, `filename`, `code`, `type`, `size`, `ext`, `date_added`, `date_modified`) VALUES
(1, 14, 1, 'robots.txt', '1615756073_cdf3664821169c06f72c.txt', 'text/plain', '25', 'txt', 1615756073, 1615756073),
(2, 15, 1, 'robots.txt', '1615756186_d4ed7bc9d5a64de5f54a.txt', 'text/plain', '25', 'txt', 1615756186, 1615756186),
(3, 16, 1, 'robots.txt', '1615756267_af04caca8b7b4eba4e89.txt', 'text/plain', '25', 'txt', 1615756267, 1615756267),
(4, 17, 1, 'robots.txt', '1615756349_d0d22f81839874ce211d.txt', 'text/plain', '25', 'txt', 1615756349, 1615756349);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user`
--

CREATE TABLE `ci_user` (
  `user_id` int NOT NULL,
  `user_group_id` tinyint NOT NULL,
  `username` varchar(20) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user`
--

INSERT INTO `ci_user` (`user_id`, `user_group_id`, `username`, `firstname`, `lastname`, `email`, `password`, `salt`, `status`, `image`, `code`, `date_added`, `date_modified`) VALUES
(1, 1, 'admin', 'John', 'Duo', 'admin@admin.com', '$2y$10$V8WWHtf9gCRyhmAqM3IAoOu6OYoHqP1CS9sLQnYlsBu6FxVLYN1yi', '3c7dcb236', 1, '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_activity`
--

CREATE TABLE `ci_user_activity` (
  `activity_id` int NOT NULL,
  `user_id` int NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_group`
--

CREATE TABLE `ci_user_group` (
  `user_group_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `permission` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_group`
--

INSERT INTO `ci_user_group` (`user_group_id`, `name`, `permission`, `date_added`, `date_modified`) VALUES
(2, 'Demonstration', '{\"access\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"],\"modify\":[\"extension\\/dashboard\",\"extension\\/module\",\"localisation\\/language\",\"catalog\\/information\",\"user\\/user\",\"user\\/user_group\",\"common\\/filemanager\",\"report\\/activity\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/setting\",\"tool\\/log\",\"blog\\/post\",\"module\\/featured\",\"module\\/information\",\"module\\/special\",\"module\\/slideshow\",\"module\\/html\",\"module\\/carousel\",\"module\\/bestseller\",\"dashboard\\/sale\",\"dashboard\\/order\",\"dashboard\\/recent\",\"dashboard\\/map\",\"dashboard\\/chart\",\"dashboard\\/customer\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"dashboard\\/activity\",\"dashboard\\/online\",\"dashboard\\/activity\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\",\"module\\/carousel\"]}', 0, 0),
(1, 'Administrator', '{\"access\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"catalog\\/skill\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/payment\",\"extension\\/report\",\"extension\\/theme\",\"extension\\/wallet\",\"finance\\/dispute\",\"finance\\/withdrawal\",\"localisation\\/currency\",\"localisation\\/dispute_action\",\"localisation\\/dispute_reason\",\"localisation\\/dispute_status\",\"localisation\\/language\",\"localisation\\/project_status\",\"localisation\\/withdraw_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"module\\/featured\",\"module\\/freelancer\",\"module\\/html\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\",\"module\\/employer_project\",\"module\\/project_upgrade\",\"module\\/bid_upgrade\"],\"modify\":[\"catalog\\/category\",\"catalog\\/information\",\"catalog\\/project\",\"catalog\\/review\",\"catalog\\/skill\",\"common\\/filemanager\",\"customer\\/customer\",\"customer\\/customer_group\",\"design\\/banner\",\"design\\/layout\",\"design\\/seo_url\",\"extension\\/bid\",\"extension\\/blog\",\"extension\\/dashboard\",\"extension\\/job\",\"extension\\/payment\",\"extension\\/report\",\"extension\\/theme\",\"extension\\/wallet\",\"finance\\/dispute\",\"finance\\/withdrawal\",\"localisation\\/currency\",\"localisation\\/dispute_action\",\"localisation\\/dispute_reason\",\"localisation\\/dispute_status\",\"localisation\\/language\",\"localisation\\/project_status\",\"localisation\\/withdraw_status\",\"module\\/account\",\"module\\/carousel\",\"module\\/category\",\"module\\/featured\",\"module\\/freelancer\",\"module\\/html\",\"module\\/video\",\"report\\/online\",\"report\\/report\",\"setting\\/event\",\"setting\\/extension\",\"setting\\/module\",\"setting\\/setting\",\"tool\\/log\",\"tool\\/mail\",\"user\\/user\",\"user\\/user_group\",\"extensions\\/bid\\/bid\",\"extensions\\/blog\\/category\",\"extensions\\/blog\\/comment\",\"extensions\\/blog\\/post\",\"extensions\\/dashboard\\/activity\",\"extensions\\/dashboard\\/online\",\"extensions\\/job\\/job\",\"extensions\\/report\\/user_activity\",\"extensions\\/theme\\/basic\",\"extensions\\/wallet\\/wallet\",\"module\\/employer_project\",\"module\\/project_upgrade\",\"module\\/bid_upgrade\"]}', 0, 4294967295);

-- --------------------------------------------------------

--
-- Table structure for table `ci_user_login`
--

CREATE TABLE `ci_user_login` (
  `user_login_id` int NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user_login`
--

INSERT INTO `ci_user_login` (`user_login_id`, `email`, `ip`, `total`, `date_added`, `date_modified`) VALUES
(1, 'freelancer@freelancer.com', '::1', 3, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw`
--

CREATE TABLE `ci_withdraw` (
  `withdraw_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `currency` varchar(30) NOT NULL,
  `withdraw_status_id` tinyint(1) NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0',
  `date_modified` int UNSIGNED NOT NULL DEFAULT '0',
  `date_processed` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw_history`
--

CREATE TABLE `ci_withdraw_history` (
  `withdraw_history_id` int NOT NULL,
  `withdraw_id` int NOT NULL,
  `withdraw_status_id` int NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_added` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_withdraw_status`
--

CREATE TABLE `ci_withdraw_status` (
  `withdraw_status_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Indexes for table `ci_customer_ip`
--
ALTER TABLE `ci_customer_ip`
  ADD PRIMARY KEY (`customer_ip_id`),
  ADD KEY `ip` (`ip`);

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
-- Indexes for table `ci_customer_to_skill`
--
ALTER TABLE `ci_customer_to_skill`
  ADD PRIMARY KEY (`skill_id`,`freelancer_id`) USING BTREE,
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
-- Indexes for table `ci_messages`
--
ALTER TABLE `ci_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `project_id` (`receiver_id`) USING BTREE;

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
-- Indexes for table `ci_project_to_milestone`
--
ALTER TABLE `ci_project_to_milestone`
  ADD PRIMARY KEY (`milestone_id`),
  ADD KEY `project_id` (`project_id`) USING BTREE;

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
-- Indexes for table `ci_skills`
--
ALTER TABLE `ci_skills`
  ADD PRIMARY KEY (`skill_id`);

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
  ADD PRIMARY KEY (`user_login_id`);

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
  MODIFY `banner_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_banner_image`
--
ALTER TABLE `ci_banner_image`
  MODIFY `banner_image_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ci_blog_category`
--
ALTER TABLE `ci_blog_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_blog_post`
--
ALTER TABLE `ci_blog_post`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_blog_post_to_comment`
--
ALTER TABLE `ci_blog_post_to_comment`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_category`
--
ALTER TABLE `ci_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ci_country`
--
ALTER TABLE `ci_country`
  MODIFY `country_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `ci_currency`
--
ALTER TABLE `ci_currency`
  MODIFY `currency_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ci_customer`
--
ALTER TABLE `ci_customer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_customer_activity`
--
ALTER TABLE `ci_customer_activity`
  MODIFY `customer_activity_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ci_customer_deposit`
--
ALTER TABLE `ci_customer_deposit`
  MODIFY `balance_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_group`
--
ALTER TABLE `ci_customer_group`
  MODIFY `customer_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_customer_history`
--
ALTER TABLE `ci_customer_history`
  MODIFY `customer_history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_ip`
--
ALTER TABLE `ci_customer_ip`
  MODIFY `customer_ip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ci_customer_login`
--
ALTER TABLE `ci_customer_login`
  MODIFY `customer_login_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ci_customer_to_balance`
--
ALTER TABLE `ci_customer_to_balance`
  MODIFY `balance_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_customer_to_certificate`
--
ALTER TABLE `ci_customer_to_certificate`
  MODIFY `certificate_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ci_customer_to_education`
--
ALTER TABLE `ci_customer_to_education`
  MODIFY `education_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_dispute`
--
ALTER TABLE `ci_dispute`
  MODIFY `dispute_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_dispute_action`
--
ALTER TABLE `ci_dispute_action`
  MODIFY `dispute_action_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ci_dispute_history`
--
ALTER TABLE `ci_dispute_history`
  MODIFY `dispute_history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_dispute_reason`
--
ALTER TABLE `ci_dispute_reason`
  MODIFY `dispute_reason_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ci_dispute_status`
--
ALTER TABLE `ci_dispute_status`
  MODIFY `dispute_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_download`
--
ALTER TABLE `ci_download`
  MODIFY `download_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_event`
--
ALTER TABLE `ci_event`
  MODIFY `event_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_extension`
--
ALTER TABLE `ci_extension`
  MODIFY `extension_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `ci_information`
--
ALTER TABLE `ci_information`
  MODIFY `information_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ci_job`
--
ALTER TABLE `ci_job`
  MODIFY `job_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_language`
--
ALTER TABLE `ci_language`
  MODIFY `language_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ci_languages`
--
ALTER TABLE `ci_languages`
  MODIFY `language_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `ci_layout`
--
ALTER TABLE `ci_layout`
  MODIFY `layout_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ci_layout_module`
--
ALTER TABLE `ci_layout_module`
  MODIFY `layout_module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `ci_layout_route`
--
ALTER TABLE `ci_layout_route`
  MODIFY `layout_route_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ci_messages`
--
ALTER TABLE `ci_messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ci_module`
--
ALTER TABLE `ci_module`
  MODIFY `module_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ci_project`
--
ALTER TABLE `ci_project`
  MODIFY `project_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ci_project_award`
--
ALTER TABLE `ci_project_award`
  MODIFY `award_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_bids`
--
ALTER TABLE `ci_project_bids`
  MODIFY `bid_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_bids_upgrade`
--
ALTER TABLE `ci_project_bids_upgrade`
  MODIFY `upgrade_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_proposal`
--
ALTER TABLE `ci_project_proposal`
  MODIFY `proposal_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_status`
--
ALTER TABLE `ci_project_status`
  MODIFY `status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ci_project_to_download`
--
ALTER TABLE `ci_project_to_download`
  MODIFY `download_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_project_to_milestone`
--
ALTER TABLE `ci_project_to_milestone`
  MODIFY `milestone_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_revenue`
--
ALTER TABLE `ci_revenue`
  MODIFY `revenue_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_review`
--
ALTER TABLE `ci_review`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_seo_url`
--
ALTER TABLE `ci_seo_url`
  MODIFY `seo_url_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_setting`
--
ALTER TABLE `ci_setting`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1053;

--
-- AUTO_INCREMENT for table `ci_skills`
--
ALTER TABLE `ci_skills`
  MODIFY `skill_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ci_university`
--
ALTER TABLE `ci_university`
  MODIFY `university_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `ci_university_majors`
--
ALTER TABLE `ci_university_majors`
  MODIFY `major_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `ci_upload`
--
ALTER TABLE `ci_upload`
  MODIFY `upload_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_user_activity`
--
ALTER TABLE `ci_user_activity`
  MODIFY `activity_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_user_group`
--
ALTER TABLE `ci_user_group`
  MODIFY `user_group_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ci_user_login`
--
ALTER TABLE `ci_user_login`
  MODIFY `user_login_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ci_withdraw`
--
ALTER TABLE `ci_withdraw`
  MODIFY `withdraw_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_withdraw_history`
--
ALTER TABLE `ci_withdraw_history`
  MODIFY `withdraw_history_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_withdraw_status`
--
ALTER TABLE `ci_withdraw_status`
  MODIFY `withdraw_status_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

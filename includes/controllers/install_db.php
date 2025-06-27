<?php 
require_once('../initialize.php');
global $db;

$table['tbl_articles'] = "CREATE TABLE IF NOT EXISTS `tbl_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `meta_keywords` varchar(250) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `type` int(1) NOT NULL,
  `added_date` varchar(50) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `homepage` int(1) NOT NULL DEFAULT '0',
  `image` varchar(50) NOT NULL,
  `date` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_advertisement'] = "CREATE TABLE IF NOT EXISTS `tbl_advertisement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `img_height` int(11) NOT NULL,
  `img_width` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `url_link` varchar(255) NOT NULL,
  `notification` int(11) NOT NULL,
  `notif_status` tinyint(1) NOT NULL DEFAULT '0',
  `mail_to` mediumtext NOT NULL,
  `content` text NOT NULL,
  `remarks` text NOT NULL,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `added_date` varchar(50) NOT NULL,
  `sortorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_configs'] = "CREATE TABLE IF NOT EXISTS `tbl_configs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sitetitle` varchar(200) NOT NULL,
  `icon_upload` varchar(200) NOT NULL,
  `logo_upload` varchar(200) NOT NULL,
  `sitename` varchar(50) NOT NULL,
  `location_type` tinyint(1) NOT NULL DEFAULT '1',
  `location_map` mediumtext NOT NULL,
  `location_image` varchar(250) NOT NULL,
  `fiscal_address` tinytext NOT NULL,
  `mail_address` tinytext NOT NULL,
  `contact_info` tinytext NOT NULL,
  `email_address` tinytext NOT NULL,
  `breif` text NOT NULL,
  `copyright` varchar(200) NOT NULL,
  `site_keywords` varchar(500) NOT NULL,
  `site_description` varchar(500) NOT NULL,
  `google_anlytics` text NOT NULL,
  `template` varchar(100) NOT NULL,
  `admin_template` varchar(100) NOT NULL,
  `headers` text,
  `footer` text,
  `search_box` text,
  `search_result` text,
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_countries'] = "CREATE TABLE IF NOT EXISTS `tbl_countries` (
	`id` int(3) NOT NULL AUTO_INCREMENT,
	`country_name` varchar(50) NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_destination'] = "CREATE TABLE IF NOT EXISTS `tbl_destination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brief` blob NOT NULL,
  `content` blob NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `meta_keywords` tinytext NOT NULL,
  `meta_description` tinytext NOT NULL,
  `sortorder` int(11) NOT NULL,
  `added_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_activities'] = "CREATE TABLE IF NOT EXISTS `tbl_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `parentOf` int(11) NOT NULL,
  `destinationId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `brief` blob NOT NULL,
  `content` blob NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `meta_keywords` tinytext NOT NULL,
  `meta_description` tinytext NOT NULL,
  `sortorder` int(11) NOT NULL,
  `added_date` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_events'] = "CREATE TABLE IF NOT EXISTS `tbl_events` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(250) NOT NULL,
	`content` text NOT NULL,
	`image` varchar(50) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`sortorder` int(11) NOT NULL,
	`added_date` varchar(50) NOT NULL,
	`meta_keywords` varchar(250) NOT NULL,
	`meta_description` varchar(250) NOT NULL,
	`event_stdate` date NOT NULL,
	`event_endate` date NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_galleries'] = "CREATE TABLE IF NOT EXISTS `tbl_galleries` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(250) NOT NULL,
	`image` varchar(50) NOT NULL,
	`detail` varchar(200) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`sortorder` int(11) NOT NULL,
	`registered` varchar(50) NOT NULL,
	`type` int(1) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_gallery_images'] = "CREATE TABLE IF NOT EXISTS `tbl_gallery_images` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`galleryid` int(11) NOT NULL COMMENT 'is foreign id of galleries.id',
	`title` varchar(200) NOT NULL,
	`image` varchar(50) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`detail` varchar(200) NOT NULL,
	`sortorder` int(11) NOT NULL,
	`registered` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_group_type'] = "CREATE TABLE IF NOT EXISTS `tbl_group_type` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`group_name` varchar(50) NOT NULL,
	`group_type` varchar(20) NOT NULL,
	`authority` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=>Frontend,2=>Personality,3=>Backend,4=>Both',
	`description` tinytext NOT NULL,
	`status` tinyint(4) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_logs'] = "CREATE TABLE IF NOT EXISTS `tbl_logs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`action` varchar(50) NOT NULL,
	`registered` varchar(50) NOT NULL,
	`userid` int(11) NOT NULL,
	`user_action` int(11) NOT NULL,
	`ip_track` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_logs_action'] = "CREATE TABLE IF NOT EXISTS `tbl_logs_action` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(100) NOT NULL,
	`icon` varchar(100) NOT NULL,
	`bgcolor` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_menu'] = "CREATE TABLE IF NOT EXISTS `tbl_menu` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`linksrc` varchar(150) NOT NULL,
	`parentOf` int(11) NOT NULL DEFAULT '0',
	`linktype` varchar(10) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`sortorder` int(11) NOT NULL,
	`added_date` varchar(50) NOT NULL,
	`type` int(1) NOT NULL,
	`icon` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_modules'] = "CREATE TABLE IF NOT EXISTS `tbl_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL DEFAULT 'dashboard',
  `mode` varchar(20) NOT NULL,
  `icon_link` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL,
  `added_date` date NOT NULL,
  `properties` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_news'] = "CREATE TABLE IF NOT EXISTS `tbl_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `author` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `news_date` date NOT NULL,
  `archive_date` date DEFAULT NULL,
  `sortorder` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `image` varchar(50) NOT NULL,
  `source` mediumtext NOT NULL,
  `type` int(1) NOT NULL,
  `display` tinyint(2) NOT NULL DEFAULT '0',
  `linksrc` varchar(255) NOT NULL,
  `linktype` tinyint(1) NOT NULL DEFAULT '0',
  `meta_keywords` varchar(250) NOT NULL,
  `meta_description` varchar(250) NOT NULL,
  `added_date` varchar(50) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_package'] = "CREATE TABLE IF NOT EXISTS `tbl_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `destinationId` int(11) NOT NULL,
  `activityId` int(11) NOT NULL,
  `regionId` int(11) NOT NULL,
  `price` varchar(50) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `days` varchar(200) NOT NULL,
  `maptype` int(11) NOT NULL,
  `mapimage` varchar(255) NOT NULL,
  `mapgoogle` text NOT NULL,
  `videolink` int(11) NOT NULL,
  `breif` blob NOT NULL,
  `overview` blob NOT NULL,
  `itinerary` blob NOT NULL,
  `incexc` blob NOT NULL,
  `availability` blob NOT NULL,
  `others` blob NOT NULL,
  `guide` blob NOT NULL,
  `altitude` varchar(50) NOT NULL,
  `difficulty` enum('Easy','Moderate','Moderate To Strenous','Strenous','Very Strenous') NOT NULL,
  `gread` enum('Five','Four','Three','Two','One') NOT NULL,
  `season` enum('Winter',' ‎Spring','Autumn','Summer') NOT NULL,
  `pdate` varchar(50) NOT NULL,
  `startpoint` varchar(255) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `gallery` blob NOT NULL,
  `tags` varchar(50) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `lastminutes` tinyint(1) NOT NULL DEFAULT '0',
  `homepage` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sortorder` int(11) NOT NULL,
  `added_date` varchar(50) NOT NULL,
  `meta_keywords` blob NOT NULL,
  `meta_description` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_permission'] = "CREATE TABLE IF NOT EXISTS `tbl_permission` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(5) CHARACTER SET utf8 NOT NULL,
	`group_id` varchar(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`module_id` varchar(11) NOT NULL,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_polloptions'] = "CREATE TABLE IF NOT EXISTS `tbl_polloptions` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`pollid` int(11) NOT NULL COMMENT 'foreign id for tbl_polls.id',
	`pollOption` varchar(100) NOT NULL,
	`sortorder` int(11) NOT NULL,
	`hits` int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_polls'] = "CREATE TABLE IF NOT EXISTS `tbl_polls` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`question` varchar(250) NOT NULL,
	`added_date` varchar(50) NOT NULL,
	`sortorder` int(11) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`type` int(1) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_slideshow'] = "CREATE TABLE IF NOT EXISTS `tbl_slideshow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `linksrc` varchar(255) NOT NULL,
  `linktype` tinyint(1) NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `added_date` varchar(50) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";


$table['tbl_slideshows_withouttlist'] = "CREATE TABLE IF NOT EXISTS `tbl_slideshows_withouttlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `sortorder` int(11) NOT NULL,
  `registered` varchar(50) NOT NULL,
  `type` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_social_networking'] = "CREATE TABLE IF NOT EXISTS `tbl_social_networking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `linksrc` varchar(250) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `sortorder` int(11) NOT NULL,
  `registered` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_subscribers'] = "CREATE TABLE IF NOT EXISTS `tbl_subscribers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(100) NOT NULL,
	`mailaddress` varchar(250) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '1',
	`sortorder` int(11) NOT NULL,
	`added_date` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_testimonial'] = "CREATE TABLE IF NOT EXISTS `tbl_testimonial` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`image` varchar(250) NOT NULL,
	`content` text NOT NULL,
	`sortorder` int(11) NOT NULL,
	`status` int(1) NOT NULL,
	`country` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";


$table['tbl_users'] = "CREATE TABLE IF NOT EXISTS `tbl_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`first_name` varchar(50) NOT NULL,
	`middle_name` varchar(50) NOT NULL,
	`last_name` varchar(50) NOT NULL,
	`contact` varchar(50) NOT NULL,
	`email` varchar(50) NOT NULL,
	`optional_email` mediumtext NOT NULL,
	`username` varchar(50) NOT NULL,
	`password` varchar(65) NOT NULL,
	`accesskey` varchar(50) NOT NULL,
	`image` varchar(255) NOT NULL,
	`group_id` int(11) NOT NULL,
	`access_code` varchar(255) NOT NULL,
	`facebook_uid` varchar(255) NOT NULL,
	`facebook_accesstoken` varchar(255) NOT NULL,
	`facebook_tokenexpire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`status` tinyint(1) NOT NULL DEFAULT '0',
	`sortorder` int(11) NOT NULL,
	`added_date` date NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_user_info'] = "CREATE TABLE IF NOT EXISTS `tbl_user_info` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`person_id` int(11) NOT NULL,
	`email2` varchar(100) NOT NULL,
	`dob` date NOT NULL,
	`zodic_sign` varchar(100) NOT NULL,
	`current_city` tinytext NOT NULL,
	`education` tinytext NOT NULL,
	`home_town` tinytext NOT NULL,
	`phone_res` varchar(30) NOT NULL,
	`phone_office` varchar(30) NOT NULL,
	`mobile_no` varchar(30) NOT NULL,
	`mobile_no2` varchar(30) NOT NULL,
	`children_name` tinytext NOT NULL,
	`pet_name` tinytext NOT NULL,
	`nick_name` varchar(255) NOT NULL,
	`gender` enum('male','female','other') NOT NULL,
	`birth_place` varchar(100) NOT NULL,
	`maritial_status` enum('married','single','divorced') NOT NULL,
	`spouse_name` varchar(100) NOT NULL,
	`publish_spoush_name` tinyint(1) NOT NULL,
	`publish_children_name` varchar(255) NOT NULL,
	`career_start_date` date NOT NULL,
	`facebook_link` varchar(255) NOT NULL,
	`facebook_page` tinytext NOT NULL,
	`twitter_link` tinytext NOT NULL,
	`google_plus` tinytext NOT NULL,
	`linkedin` tinytext NOT NULL,
	`skpye_address` varchar(255) NOT NULL,
	`short_desc` text NOT NULL,
	`website` varchar(255) NOT NULL,
	`other_profession` tinytext NOT NULL,
	`question_set` int(11) NOT NULL,
	`answer_status` tinyint(1) NOT NULL COMMENT '0=>Not finished,1=>finised,2=>ongoing review,3=>complete review,',
	`notification` varchar(50) NOT NULL COMMENT 'notification for answer status complete.',
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_video'] = "CREATE TABLE IF NOT EXISTS `tbl_video` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`source` varchar(200) NOT NULL,
	`url_type` varchar(50) NOT NULL,
	`title` mediumtext NOT NULL,
	`thumb_image` mediumtext NOT NULL,
	`url` varchar(255) NOT NULL,
	`host` varchar(255) NOT NULL,
	`content` text NOT NULL,
	`class` varchar(100) NOT NULL,
	`status` int(1) NOT NULL DEFAULT '0',
	`sortorder` int(11) NOT NULL,
	`added_date` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_visitorcounter'] = "CREATE TABLE IF NOT EXISTS `tbl_visitorcounter` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`action` varchar(255) NOT NULL,
	`action_id` int(11) NOT NULL,
	`ip_address` varchar(50) NOT NULL,
	`added_date` date NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ";

$table['tbl_themes'] = "CREATE TABLE IF NOT EXISTS `tbl_themes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`title` varchar(255) NOT NULL,
  	`properties` text NOT NULL,
  	`jsproperties` text NOT NULL,
  	`cssproperties` text NOT NULL,
  	`status` tinyint(1) NOT NULL DEFAULT '0',
  	`type` int(11) NOT NULL DEFAULT '0',
  	`added_date` varchar(50) NOT NULL,
  	PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

// Create tables
foreach($table as $tbl=>$sql) { $db->query($sql)or die(mysqli_error()); }

// Feed Data into the table
$data['tbl_configs'] = "INSERT INTO `tbl_configs` (`id`, `sitetitle`, `icon_upload`, `logo_upload`, `sitename`, `location_type`, `location_map`, `location_image`, `copyright`, `site_keywords`, `site_description`, `google_anlytics`, `template`, `admin_template`, `headers`, `footer`, `search_box`, `search_result`, `action`) 
		VALUES
		(1, 'Synhawk  Version 2.0', 'QYpIh_icon.png', 's5IUF_logo.png', 'Synhawk  Version 2.0', 0, '', '', 'Copyrights  © Synhawk  Version 2.0. {year}. All Rights Reserved.', 'Meta keywords', 'Meta description', '', 'web', 'blue', 'Header HTML', 'Footer HTML', 'Develop By Amit prajapati', 'Develop By Amit prajapati', 1);";

$data['tbl_countries'] = "INSERT INTO `tbl_countries` (`id`, `country_name`, `status`) 
			VALUES
			(1, 'United States', 1),
			(2, 'Canada', 1),
			(3, 'Mexico', 1),
			(4, 'Afghanistan', 1),
			(5, 'Albania', 1),
			(6, 'Algeria', 1),
			(7, 'Andorra', 1),
			(8, 'Angola', 1),
			(9, 'Anguilla', 1),
			(10, 'Antarctica', 1),
			(11, 'Antigua and Barbuda', 1),
			(12, 'Argentina', 1),
			(13, 'Armenia', 1),
			(14, 'Aruba', 1),
			(15, 'Ascension Island', 1),
			(16, 'Australia', 1),
			(17, 'Austria', 1),
			(18, 'Azerbaijan', 1),
			(19, 'Bahamas', 1),
			(20, 'Bahrain', 1),
			(21, 'Bangladesh', 1),
			(22, 'Barbados', 1),
			(23, 'Belarus', 1),
			(24, 'Belgium', 1),
			(25, 'Belize', 1),
			(26, 'Benin', 1),
			(27, 'Bermuda', 1),
			(28, 'Bhutan', 1),
			(29, 'Bolivia', 1),
			(30, 'Bophuthatswana', 1),
			(31, 'Bosnia-Herzegovina', 1),
			(32, 'Botswana', 1),
			(33, 'Bouvet Island', 1),
			(34, 'Brazil', 1),
			(35, 'British Indian Ocean', 1),
			(36, 'British Virgin Islands', 1),
			(37, 'Brunei Darussalam', 1),
			(38, 'Bulgaria', 1),
			(39, 'Burkina Faso', 1),
			(40, 'Burundi', 1),
			(41, 'Cambodia', 1),
			(42, 'Cameroon', 1),
			(44, 'Cape Verde Island', 1),
			(45, 'Cayman Islands', 1),
			(46, 'Central Africa', 1),
			(47, 'Chad', 1),
			(48, 'Channel Islands', 1),
			(49, 'Chile', 1),
			(50, 'China, Peoples Republic', 1),
			(51, 'Christmas Island', 1),
			(52, 'Cocos (Keeling) Islands', 1),
			(53, 'Colombia', 1),
			(54, 'Comoros Islands', 1),
			(55, 'Congo', 1),
			(56, 'Cook Islands', 1),
			(57, 'Costa Rica', 1),
			(58, 'Croatia', 1),
			(59, 'Cuba', 1),
			(60, 'Cyprus', 1),
			(61, 'Czech Republic', 1),
			(62, 'Denmark', 1),
			(63, 'Djibouti', 1),
			(64, 'Dominica', 1),
			(65, 'Dominican Republic', 1),
			(66, 'Easter Island', 1),
			(67, 'Ecuador', 1),
			(68, 'Egypt', 1),
			(69, 'El Salvador', 1),
			(70, 'England', 1),
			(71, 'Equatorial Guinea', 1),
			(72, 'Estonia', 1),
			(73, 'Ethiopia', 1),
			(74, 'Falkland Islands', 1),
			(75, 'Faeroe Islands', 1),
			(76, 'Fiji', 1),
			(77, 'Finland', 1),
			(78, 'France', 1),
			(79, 'French Guyana', 1),
			(80, 'French Polynesia', 1),
			(81, 'Gabon', 1),
			(82, 'Gambia', 1),
			(83, 'Georgia Republic', 1),
			(84, 'Germany', 1),
			(85, 'Gibraltar', 1),
			(86, 'Greece', 1),
			(87, 'Greenland', 1),
			(88, 'Grenada', 1),
			(89, 'Guadeloupe (French)', 1),
			(90, 'Guatemala', 1),
			(91, 'Guernsey Island', 1),
			(92, 'Guinea Bissau', 1),
			(93, 'Guinea', 1),
			(94, 'Guyana', 1),
			(95, 'Haiti', 1),
			(96, 'Heard and McDonald Isls', 1),
			(97, 'Honduras', 1),
			(98, 'Hong Kong', 1),
			(99, 'Hungary', 1),
			(100, 'Iceland', 1),
			(101, 'India', 1),
			(102, 'Iran', 1),
			(103, 'Iraq', 1),
			(104, 'Ireland', 1),
			(105, 'Isle of Man', 1),
			(106, 'Israel', 1),
			(107, 'Italy', 1),
			(108, 'Ivory Coast', 1),
			(109, 'Jamaica', 1),
			(110, 'Japan', 1),
			(111, 'Jersey Island', 1),
			(112, 'Jordan', 1),
			(113, 'Kazakhstan', 1),
			(114, 'Kenya', 1),
			(115, 'Kiribati', 1),
			(116, 'Kuwait', 1),
			(117, 'Laos', 1),
			(118, 'Latvia', 1),
			(119, 'Lebanon', 1),
			(120, 'Lesotho', 1),
			(121, 'Liberia', 1),
			(122, 'Libya', 1),
			(123, 'Liechtenstein', 1),
			(124, 'Lithuania', 1),
			(125, 'Luxembourg', 1),
			(126, 'Macao', 1),
			(127, 'Macedonia', 1),
			(128, 'Madagascar', 1),
			(129, 'Malawi', 1),
			(130, 'Malaysia', 1),
			(131, 'Maldives', 1),
			(132, 'Mali', 1),
			(133, 'Malta', 1),
			(134, 'Martinique (French)', 1),
			(135, 'Mauritania', 1),
			(136, 'Mauritius', 1),
			(137, 'Mayotte', 1),
			(139, 'Micronesia', 1),
			(140, 'Moldavia', 1),
			(141, 'Monaco', 1),
			(142, 'Mongolia', 1),
			(143, 'Montenegro', 1),
			(144, 'Montserrat', 1),
			(145, 'Morocco', 1),
			(146, 'Mozambique', 1),
			(147, 'Myanmar', 1),
			(148, 'Namibia', 1),
			(149, 'Nauru', 1),
			(150, 'Nepal', 1),
			(151, 'Netherlands Antilles', 1),
			(152, 'Netherlands', 1),
			(153, 'New Caledonia (French)', 1),
			(154, 'New Zealand', 1),
			(155, 'Nicaragua', 1),
			(156, 'Niger', 1),
			(157, 'Niue', 1),
			(158, 'Norfolk Island', 1),
			(159, 'North Korea', 1),
			(160, 'Northern Ireland', 1),
			(161, 'Norway', 1),
			(162, 'Oman', 1),
			(163, 'Pakistan', 1),
			(164, 'Panama', 1),
			(165, 'Papua New Guinea', 1),
			(166, 'Paraguay', 1),
			(167, 'Peru', 1),
			(168, 'Philippines', 1),
			(169, 'Pitcairn Island', 1),
			(170, 'Poland', 1),
			(171, 'Polynesia (French)', 1),
			(172, 'Portugal', 1),
			(173, 'Qatar', 1),
			(174, 'Reunion Island', 1),
			(175, 'Romania', 1),
			(176, 'Russia', 1),
			(177, 'Rwanda', 1),
			(178, 'S.Georgia Sandwich Isls', 1),
			(179, 'Sao Tome, Principe', 1),
			(180, 'San Marino', 1),
			(181, 'Saudi Arabia', 1),
			(182, 'Scotland', 1),
			(183, 'Senegal', 1),
			(184, 'Serbia', 1),
			(185, 'Seychelles', 1),
			(186, 'Shetland', 1),
			(187, 'Sierra Leone', 1),
			(188, 'Singapore', 1),
			(189, 'Slovak Republic', 1),
			(190, 'Slovenia', 1),
			(191, 'Solomon Islands', 1),
			(192, 'Somalia', 1),
			(193, 'South Africa', 1),
			(194, 'South Korea', 1),
			(195, 'Spain', 1),
			(196, 'Sri Lanka', 1),
			(197, 'St. Helena', 1),
			(198, 'St. Lucia', 1),
			(199, 'St. Pierre Miquelon', 1),
			(200, 'St. Martins', 1),
			(201, 'St. Kitts Nevis Anguilla', 1),
			(202, 'St. Vincent Grenadines', 1),
			(203, 'Sudan', 1),
			(204, 'Suriname', 1),
			(205, 'Svalbard Jan Mayen', 1),
			(206, 'Swaziland', 1),
			(207, 'Sweden', 1),
			(208, 'Switzerland', 1),
			(209, 'Syria', 1),
			(210, 'Tajikistan', 1),
			(211, 'Taiwan', 1),
			(212, 'Tahiti', 1),
			(213, 'Tanzania', 1),
			(214, 'Thailand', 1),
			(215, 'Togo', 1),
			(216, 'Tokelau', 1),
			(217, 'Tonga', 1),
			(218, 'Trinidad and Tobago', 1),
			(219, 'Tunisia', 1),
			(220, 'Turkmenistan', 1),
			(221, 'Turks and Caicos Isls', 1),
			(222, 'Tuvalu', 1),
			(223, 'Uganda', 1),
			(224, 'Ukraine', 1),
			(225, 'United Arab Emirates', 1),
			(226, 'Uruguay', 1),
			(227, 'Uzbekistan', 1),
			(228, 'Vanuatu', 1),
			(229, 'Vatican City State', 1),
			(230, 'Venezuela', 1),
			(231, 'Vietnam', 1),
			(232, 'Virgin Islands (Brit,1)', 1),
			(233, 'Wales', 1),
			(234, 'Wallis Futuna Islands', 1),
			(235, 'Western Sahara', 1),
			(236, 'Western Samoa', 1),
			(237, 'Yemen', 1),
			(238, 'Yugoslavia', 1),
			(239, 'Zaire', 1),
			(240, 'Zambia', 1),
			(241, 'Zimbabwe', 1);";

$data['tbl_logs_action'] = "INSERT INTO `tbl_logs_action` (`id`, `title`, `icon`, `bgcolor`) 
			VALUES
			(1, 'Login', 'icon-sign-in', 'bg-blue'),
			(2, 'Logout', 'icon-sign-out', 'primary-bg'),
			(3, 'Add', 'icon-plus-circle', 'bg-green'),
			(4, 'Edit', 'icon-edit', 'bg-blue-alt'),
			(5, 'Copy', 'icon-copy', 'ui-state-default'),
			(6, 'Delete', 'icon-clock-os-circle', 'bg-red');";

$data['tbl_destination'] = "INSERT INTO `tbl_destination` (`id`, `slug`, `title`, `image`, `brief`, `content`, `status`, `meta_keywords`, `meta_description`, `sortorder`, `added_date`) 
			VALUES
			(1, 'nepal', 'Nepal', 'VGTa8_1.jpg', '', '', 1, '', '', 1, '2015-06-13 21:37:01');";

$data['tbl_activities'] = "INSERT INTO `tbl_activities` (`id`, `slug`, `parentOf`, `destinationId`, `title`, `image`, `brief`, `content`, `status`, `meta_keywords`, `meta_description`, `sortorder`, `added_date`) 
			VALUES
			(1, 'honey-hunter', 0, 1, 'Honey Hunter', 'iRTFG_2.jpg', '', '', 1, '', '', 1, '2015-06-13 21:45:29'),
			(2, 'trekking', 0, 1, 'Trekking', 'GW8gC_3.jpg', '', '', 1, '', '', 2, '2015-06-13 21:46:19'),
			(3, 'jungle-safari', 0, 1, 'Jungle Safari', 'tGeKU_4.jpg', '', '', 1, '', '', 3, '2015-06-13 21:46:42'),
			(4, 'sky-dive', 0, 1, 'Sky Dive', '', '', '', 1, '', '', 4, '2015-06-13 21:47:02');";

$data['tbl_galleries'] = "INSERT INTO `tbl_galleries` (`id`, `title`, `image`, `detail`, `status`, `sortorder`, `registered`, `type`) 
			VALUES
			(1, 'Countries', '91bUc_skin3-logo.png', '', 1, 1, '2015-06-15 17:30:14', 0),
			(2, 'Adventure', 'tNkpi_logo.png', '', 1, 2, '2015-06-15 17:30:51', 0);";

$data['tbl_gallery_images'] = "INSERT INTO `tbl_gallery_images` (`id`, `galleryid`, `title`, `image`, `status`, `detail`, `sortorder`, `registered`) 
			VALUES
			(1, 1, 'First', 'AHbDN_3yR00_img6.jpg', 1, '', 1, '2015-06-15 17:32:35'),
			(2, 1, 'Second', 'VJh7X_fd2nw_img10.jpg', 1, '', 2, '2015-06-15 17:32:36'),
			(3, 1, 'Third', 'xRmJo_FY7v4_img8.jpg', 1, '', 3, '2015-06-15 17:32:36'),
			(4, 2, 'First', 'PGMCe_Pehha_img5.jpg', 1, '', 1, '2015-06-15 17:33:08'),
			(5, 2, 'Second', 'cSPa1_Qsrkg_img2.jpg', 1, '', 2, '2015-06-15 17:33:08'),
			(6, 2, 'Third', 'tCPSJ_uRf2x_img11.jpg', 1, '', 3, '2015-06-15 17:33:08'),
			(7, 2, 'Four', 'q1Zl5_vHWsm_img1.jpg', 1, '', 4, '2015-06-15 17:33:08');";

$data['tbl_menu'] = "INSERT INTO `tbl_menu` (`id`, `name`, `linksrc`, `parentOf`, `linktype`, `status`, `sortorder`, `added_date`, `type`, `icon`) 
			VALUES
			(1, 'Home', 'home', 0, '0', 1, 1, '2015-06-13 12:46:03', 1, ''),
			(2, 'About Us', 'pages/about-us', 0, '0', 1, 2, '2015-06-13 12:46:22', 1, ''),
			(3, 'Services', '#', 0, '0', 1, 3, '2015-06-13 12:46:41', 1, ''),
			(4, 'Packages', '#', 0, '0', 1, 4, '2015-06-13 12:47:05', 1, ''),
			(5, 'Faq''s', '#', 0, '0', 1, 5, '2015-06-13 12:47:39', 1, ''),
			(6, 'Blog', '#', 0, '0', 1, 6, '2015-06-13 12:47:56', 1, ''),
			(7, 'Testimonials', '#', 0, '0', 1, 7, '2015-06-13 12:48:18', 1, ''),
			(8, 'Contact Us', 'pages/contact-us', 0, '0', 1, 8, '2015-06-13 12:48:44', 1, ''),
			(9, 'Breakfast at Everest', '#', 3, '0', 1, 1, '2015-06-13 12:49:08', 1, ''),
			(10, 'Wedding at Everest', '#', 3, '0', 1, 2, '2015-06-13 12:49:28', 1, ''),
			(11, 'Annapurna Heli Tour', '#', 3, '0', 1, 3, '2015-06-13 12:49:52', 1, ''),
			(12, 'Photography Tour', '#', 3, '0', 1, 4, '2015-06-13 12:50:09', 1, ''),
			(13, 'Trekking', '#', 4, '0', 1, 1, '2015-06-13 12:50:32', 1, ''),
			(14, 'Tour', '#', 4, '0', 1, 2, '2015-06-13 12:50:52', 1, ''),
			(15, 'Adventure Sports', '#', 4, '0', 1, 3, '2015-06-13 12:51:06', 1, ''),
			(16, 'Nepal Air Rules', '#', 4, '0', 1, 4, '2015-06-13 12:51:24', 1, ''),
			(17, 'Safety', '#', 0, '0', 1, 16, '2015-06-15 13:06:16', 2, ''),
			(18, 'Our Picks', '#', 0, '0', 1, 15, '2015-06-15 13:06:16', 2, ''),
			(19, 'Blog', '#', 0, '0', 1, 14, '2015-06-15 13:06:16', 2, ''),
			(20, 'Specials', '#', 0, '0', 1, 13, '2015-06-15 13:06:16', 2, ''),
			(21, 'Exclusives', '#', 0, '0', 1, 12, '2015-06-15 13:06:16', 2, ''),
			(22, 'Disclaimer', '#', 0, '0', 1, 11, '2015-06-15 13:06:16', 2, ''),
			(23, 'About', '#', 0, '0', 1, 9, '2015-06-15 13:06:16', 2, ''),
			(24, 'Know Nepal', '#', 0, '0', 1, 10, '2015-06-15 13:06:16', 2, ''),
			(25, 'Brochure', '#', 0, '0', 1, 17, '2015-06-15 13:06:16', 2, ''),
			(26, 'Pokhara Tour', '#', 0, '0', 1, 18, '2015-06-15 13:12:37', 2, ''),
			(27, 'Helicopter Tour', '#', 0, '0', 1, 19, '2015-06-15 13:12:54', 2, ''),
			(28, 'Privacy Policy', '#', 0, '0', 1, 20, '2015-06-15 13:13:08', 2, '');";

$data['tbl_modules'] = "INSERT INTO `tbl_modules` (`id`, `parent_id`, `name`, `link`, `mode`, `icon_link`, `status`, `sortorder`, `added_date`, `properties`) 
			VALUES
			(1, 0, 'User Mgmt', 'user/list', 'user', 'icon-users', 1, 1, '0000-00-00', 'a:2:{s:8:\"imgwidth\";s:3:\"125\";s:9:\"imgheight\";s:3:\"125\";}'),
			(2, 0, 'Menu Mgmt', 'menu/list', 'menu', 'icon-list', 1, 2, '0000-00-00', 'a:1:{s:5:\"level\";s:1:\"4\";}'),
			(3, 0, 'Articles Mgmt', 'articles/list', 'articles', 'icon-adn', 1, 3, '0000-00-00', 'a:2:{s:8:\"imgwidth\";s:3:\"200\";s:9:\"imgheight\";s:3:\"200\";}'),
			(4, 0, 'Slideshow Mgmt', 'slideshow/list', 'slideshow', 'icon-film', 1, 4, '0000-00-00', 'a:3:{s:8:\"imgwidth\";s:4:\"1600\";s:9:\"imgheight\";s:3:\"700\";s:8:\"imgdelay\";s:4:\"9000\";}'),
			(5, 0, 'Gallery Mgmt', 'gallery/list', 'gallery', 'icon-picture-o', 1, 5, '0000-00-00', 'a:4:{s:8:\"imgwidth\";s:3:\"800\";s:9:\"imgheight\";s:3:\"400\";s:9:\"simgwidth\";s:3:\"600\";s:10:\"simgheight\";s:3:\"350\";}'),
			(6, 0, 'News Mgmt', 'news/list', 'news', 'icon-list-alt', 1, 6, '0000-00-00', 'a:2:{s:8:\"imgwidth\";s:3:\"700\";s:9:\"imgheight\";s:3:\"350\";}'),
			(7, 0, 'Advertisement Mgmt', 'advertisement/list', 'advertisement', 'icon-indent', 1, 7, '0000-00-00', 'a:8:{s:9:\"limgwidth\";s:3:\"100\";s:10:\"limgheight\";s:3:\"200\";s:9:\"timgwidth\";s:3:\"300\";s:10:\"timgheight\";s:3:\"400\";s:9:\"rimgwidth\";s:3:\"500\";s:10:\"rimgheight\";s:3:\"600\";s:9:\"bimgwidth\";s:3:\"700\";s:10:\"bimgheight\";s:3:\"800\";}'),
			(8, 0, 'Video Mgmt', 'video/list', 'video', 'icon-hdd-o', 1, 10, '0000-00-00', ''),
			(9, 0, 'Poll Mgmt', 'poll/list', 'poll', 'icon-exchange', 1, 9, '0000-00-00', ''),
			(10, 0, 'Social Link Mgmt', 'social/list', 'social', 'icon-google-plus', 1, 12, '0000-00-00', 'a:2:{s:8:\"imgwidth\";s:2:\"40\";s:9:\"imgheight\";s:2:\"40\";}'),
			(11, 0, 'Setting Mgmt', 'setting/list', 'settings', 'icon-gear', 1, 16, '0000-00-00', ''),
			(12, 11, 'Preference Mgmt', 'preference/list', 'preference', 'icon-gear', 1, 1, '0000-00-00', 'a:4:{s:8:\"imgwidth\";s:2:\"50\";s:9:\"imgheight\";s:2:\"50\";s:9:\"simgwidth\";s:3:\"145\";s:10:\"simgheight\";s:2:\"80\";}'),
			(13, 11, 'Themes Mgmt', 'themes/list', 'themes', 'icon-gear', 1, 2, '0000-00-00', ''),
			(14, 11, 'Office Info/Location', 'location/list', 'location', 'icon-gear', 1, 3, '0000-00-00', ''),
			(15, 11, 'Modules Mgmt', 'module/list', 'module', 'icon-gear', 1, 4, '0000-00-00', ''),
			(16, 11, 'Properties Mgmt', 'properties/list', 'properties', 'icon-gear', 1, 5, '0000-00-00', ''),			
			(17, 0, 'Testimonial Mgmt', 'testimonial/list', 'testimonial', 'icon-list-alt', 1, 11, '2015-01-09', ''),
			(18, 0, 'Subscribers Mgmt', 'subscribers/list', 'subscribers', 'icon-comments', 1, 8, '2015-01-09', ''),
			(19, 0, 'Destination Mgmt', 'destination/list', 'destination', 'icon-plane', 1, 13, '2015-06-01', 'a:2:{s:8:\"imgwidth\";s:3:\"400\";s:9:\"imgheight\";s:3:\"400\";}'),
			(20, 0, 'Activities Mgmt', 'activities/list', 'activities', 'icon-tags', 1, 14, '2015-06-01', 'a:2:{s:8:\"imgwidth\";s:3:\"500\";s:9:\"imgheight\";s:3:\"600\";}'),
			(21, 0, 'Package Mgmt', 'package/list', 'package', 'icon-gift', 1, 15, '2015-06-01', 'a:6:{s:8:\"imgwidth\";s:3:\"270\";s:9:\"imgheight\";s:3:\"160\";s:11:\"mapimgwidth\";s:3:\"800\";s:12:\"mapimgheight\";s:3:\"600\";s:15:\"galleryimgwidth\";s:4:\"1170\";s:16:\"galleryimgheight\";s:3:\"560\";}');";

$data['tbl_news'] = "INSERT INTO `tbl_news` (`id`, `title`, `author`, `content`, `news_date`, `archive_date`, `sortorder`, `status`, `image`, `source`, `type`, `display`, `linksrc`, `linktype`, `meta_keywords`, `meta_description`, `added_date`, `slug`) 
			VALUES
			(1, 'Amazing Places', 'longtail-e-media', '<p>Purus ac congue arcu cursus ut vitae pulvinar massaidp.</p><hr id=\"system_readmore\" style=\"border-style: dashed; border-color: orange;\" />', '2015-06-15', '0000-00-00', 1, 1, 'HbrcM_blog1.jpg', '', 1, 0, '', 0, '', '', '2015-06-15 14:36:01', 'amazing-places'),
			(2, 'Everest Base Camp', 'longtail-e-media', '<p>Purus ac congue arcu cursus ut vitae pulvinar massaidp.</p><hr id=\"system_readmore\" style=\"border-style: dashed; border-color: orange;\" />', '2015-06-12', '0000-00-00', 2, 1, 'nkvO6_blog2.jpg', '', 1, 0, '', 0, '', '', '2015-06-15 14:36:40', 'everest-base-camp');";

$data['tbl_package'] = "INSERT INTO `tbl_package` (`id`, `slug`, `title`, `image`, `destinationId`, `activityId`, `regionId`, `price`, `currency`, `days`, `maptype`, `mapimage`, `mapgoogle`, `videolink`, `breif`, `overview`, `itinerary`, `incexc`, `availability`, `others`, `guide`, `altitude`, `difficulty`, `gread`, `season`, `pdate`, `startpoint`, `endpoint`, `gallery`, `tags`, `featured`, `lastminutes`, `homepage`, `status`, `sortorder`, `added_date`, `meta_keywords`, `meta_description`) 
			VALUES
			(1, 'nepal-filming-tours', 'Nepal Filming Tours', '5IA2E_popular6.jpg', 1, 1, 0, '10050', 'USD', '5', 1, 'ip1Jn_Iiu4Q_slide2.jpg', '', 1, 0x3c703e0d0a0942726569662073656374696f6e3c2f703e0d0a, 0x3c68323e0d0a09576879204e6570616c20617320612066696c6d696e672064657374696e6174696f6e3c2f68323e0d0a3c703e0d0a094e6570616c206973206f6e65206f6620746865206d6f73742062656175746966756c20636f756e747279207769746820697426727371756f3b7320756e69717565206c616e6473636170657320637265617465642062792074686520616c74697475646520766172696174696f6e2e2054686520636f756e7472792068617320676f7420736f206d616e7920756e69717565206c6f636174696f6e732074686174206174747261637473207468652076697369746f7273206f6620657665727920696e746572657374732e2050656f706c6520686176652074726176656c6c6564204e6570616c2073696e6365206c6f6e67206261636b20746f2073656520746865206d6f756e7461696e7320616e6420616e6369656e7420616e6420696e7472696e7369632061727420616e6420617263686974656374757265206f6620746869732063756c747572616c6c792072696368206e6174696f6e2e204265736964657320657870657269656e63696e6720746865206265617574792074686174206861732073707265616420657665727920636f726e6572206f66207468697320636f756e7472792c20697420676976657320796f7520657175616c206f70706f7274756e69747920746f207368617265207468697320657870657269656e636520746f2074686520776f726c64207468726f75676820796f7572206c656e7365732e204974206f6666657273206120776964652072616e6765206f662070616e6f72616d69632064657374696e6174696f6e7320746861742066617363696e61746573207468652070656f706c65207669736974696e6720616e6420746f2074686f7365207761746368696e6720697420696e2061206672616d652e204120776964652076617269657479206f66206c616e647363617065732066726f6d206c6f77206c616e64732c2074726f706963616c20666f726573747320746f2074686520686967682048696d616c6179617320676976657320616e20616d706c652063686f69636520666f72207468652066696c6d6d616b65727320746f206361707475726520697420696e207468656972206c656e73652e205468652063756c747572616c206865726974616765732c20616e6369656e74206d6f6e756d656e74732c20666573746976616c7320616e642064697665727365642067726f7570206f662070656f706c6520676976657320616e6f74686572206d61676963616c206175726120746f206d616b652074686520636f756e747279206d6f72652076696272616e742e2054686520636f756e747279206f6666657273206120636f6c6f7266756c20626c656e64206f66206e61747572616c2062656175747920776974682074686520726963682063756c74757265206d616b696e6720697420756e69717565206f6620697426727371756f3b73206b696e642e3c2f703e0d0a, 0x3c68323e0d0a094c6f636174696f6e3c2f68323e0d0a3c64697620636c6173733d22726f6f6d2d6c697374206c697374696e672d7374796c653320686f74656c223e0d0a093c703e0d0a090954686572652061726520636f756e746c657373207069637475726573717565206c6f636174696f6e732073747265746368696e6720616c6c206f766572204e6570616c20456173742d205765737420616e64206c6f776c616e6420746f20736e6f77636170706564206d6f756e7461696e73207769746820776f726c6426727371756f3b7320382068696768657374207065616b732e204e6561726c7920612071756172746572206f6620697426727371756f3b73206c616e6420617265612077686963682061726520612070726f7465637465642061726561207769746820746865206e6174696f6e616c207061726b732c2077696c646c6966652072657365727665732c20636f6e736572766174696f6e20617265617320616e6420612068756e74696e6720726573657276652070726f74656374696e672076617374206e756d626572206f6620666c6f726120616e64206661756e617320616c6c6f777320796f7520746f20626520696e207468652062657374206e61747572616c2073657474696e6773207468617420796f752063616e20696d6167696e652e205468652063697469657320616e642076616c6c6579732061726520657175616c6c79206d6f7265206361707469766174696e6720776974682074686520686f7370697461626c6520616e64206b696e64204e6570616c6573652070656f706c6520616e64207468656972206c6966657374796c652e20596f752063616e2066696e6420746865206c6f636174696f6e73206f66206576657279206b696e6420746861742077696c6c2061646420746f20796f75722073746f72792e3c2f703e0d0a3c2f6469763e0d0a3c61727469636c6520636c6173733d22626f78223e0d0a094368697477616e206e6174696f6e616c207061726b3c2f61727469636c653e0d0a3c61727469636c6520636c6173733d22626f78223e0d0a09426172646961206e6174696f6e616c207061726b3c2f61727469636c653e0d0a3c61727469636c6520636c6173733d22626f78223e0d0a093c703e0d0a09094b6f7368692074617070752077696c646c69666520726573657276653c2f703e0d0a3c2f61727469636c653e0d0a, 0x3c68323e0d0a0953657276696365733c2f68323e0d0a3c703e0d0a09576520736572766520796f75206173206f6e6520706f696e74206c6f636174696f6e20746f2070726f7669646520796f7520616c6c2074686520736572766963657320776869636820796f75206e65656420746f207375636365737366756c6c7920636f6d706c65746520796f757220616c6c206b696e64206f662066696c6d696e672070726f6a6563747320696e204e6570616c2e2057652077696c6c20626520796f757220636f6f7264696e6174696e67206167656e6379207768696c6520707265706172696e6720796f757220616c6c206e6563657373617279206c6567616c20646f63756d656e747320666f72206f627461696e696e67207065726d6974732061732077656c6c206173206769766520796f7520746865206d6f7374206e656365737361727920696e666f726d6174696f6e20746f206d616b6520796f75722070726f6a6563742072756e20736d6f6f74686c7920616e6420696e20746865206265737420636f6d666f72742e205765206172652061207465616d206f6620657870657269656e6365642070726f66657373696f6e616c732077686f20756e6465727374616e6420746865206e656564206f66206f75722066696c6d696e6720636c69656e74732066726f6d206f7572203230207965617273206f6620657870657269656e6365206f6e20746865206669656c642e2057652076616c75652074686520696e746572657374206f66206f757220636c69656e747320746f2066696c6d20696e204e6570616c20616e6420776520616c776179732064656469636174656420746f206d616b6520746865697220776f726b206561737920616e642066756e20696e2065766572792077617920706f737369626c652e3c2f703e0d0a3c703e0d0a09312e2046494c4d494e47205045524d4954533c6272202f3e0d0a09322e20435553544f4d20434c454152414e43453c6272202f3e0d0a09332e204c4f434154494f4e3c6272202f3e0d0a09342e2043415354494e473c6272202f3e0d0a09352e2043524557533c6272202f3e0d0a09362e2045515549504d454e543c6272202f3e0d0a09372e204143434f4d4d4f444154494f4e533c2f703e0d0a, 0x3c64697620636c6173733d227461622d70616e6520666164652061637469766520696e222069643d226372756973652d666f6f642d64696e6e696e67223e0d0a093c64697620636c6173733d22626f78223e0d0a09093c68323e0d0a0909094f757220576f726b733c2f68323e0d0a09093c703e0d0a0909095765206861766520616c726561647920776f726b65642077697468207365766572616c20696e7465726e6174696f6e616c2066696c6d696e672067726f757073206163726f73732074686520676c6f62652e20536f6d65206f66206f7572206578636974696e6720756e64657274616b696e677320617265203a3c2f703e0d0a093c2f6469763e0d0a3c2f6469763e0d0a3c703e0d0a09266e6273703b3c2f703e0d0a, 0x3c64697620636c6173733d227461622d70616e6520666164652061637469766520696e222069643d226372756973652d72657669657773223e0d0a093c68323e0d0a09095472656b6b696e672026616d703b204f7468657220416476656e74757265733c2f68323e0d0a093c703e0d0a09095472656b6b696e6720697320746865206d6f737420706f70756c617220666f726d206f6620657870657269656e63696e6720746869732062656175746966756c20636f756e74727920616e642067657474696e6720746f206b6e6f7720746865206d6f73742065786f74696320706c6163657320616e642070656f706c65206f662074686520636f756e7472792e2054686572652061726520776f726c642072656e6f776e656420747261696c7320616e6420726f757465732074686174207472656b6b6572732077616c6b2065616368207965617220696e207468697320706c616365732e205765206173206578706572747320696e207472656b6b696e672077696c6c207368617265206f7572206b6e6f776c6564676520616e6420657870657269656e636520746f206d616b6520796f7572207472656b6b696e6720657870657269656e636520736f6d657468696e67206d656d6f7261626c652e3c6272202f3e0d0a09093c6272202f3e0d0a0909ef82b720416e6e617075726e6120636972637569743c6272202f3e0d0a0909ef82b7204576657265737420426173652063616d70207472656b3c6272202f3e0d0a0909ef82b7204d616e61736c7520616e64205473756d2076616c6c6579207472656b3c6272202f3e0d0a0909ef82b720446f6c706f207472656b3c6272202f3e0d0a0909ef82b7204c616e6774616e67207472656b3c6272202f3e0d0a09093c6272202f3e0d0a09093c7374726f6e673e554e4951554520455850455249454e4345533c2f7374726f6e673e3c6272202f3e0d0a0909ef82b720425245414b41535420494e20455645524553543c6272202f3e0d0a0909ef82b72050484f544f47524150485920544f5552533c2f703e0d0a3c2f6469763e0d0a3c703e0d0a09266e6273703b3c2f703e0d0a, 0x3c68323e0d0a09576879204e6570616c20617320612066696c6d696e672064657374696e6174696f6e3c2f68323e0d0a3c703e0d0a094e6570616c206973206f6e65206f6620746865206d6f73742062656175746966756c20636f756e747279207769746820697426727371756f3b7320756e69717565206c616e6473636170657320637265617465642062792074686520616c74697475646520766172696174696f6e2e2054686520636f756e7472792068617320676f7420736f206d616e7920756e69717565206c6f636174696f6e732074686174206174747261637473207468652076697369746f7273206f6620657665727920696e746572657374732e2050656f706c6520686176652074726176656c6c6564204e6570616c2073696e6365206c6f6e67206261636b20746f2073656520746865206d6f756e7461696e7320616e6420616e6369656e7420616e6420696e7472696e7369632061727420616e6420617263686974656374757265206f6620746869732063756c747572616c6c792072696368206e6174696f6e2e204265736964657320657870657269656e63696e6720746865206265617574792074686174206861732073707265616420657665727920636f726e6572206f66207468697320636f756e7472792c20697420676976657320796f7520657175616c206f70706f7274756e69747920746f207368617265207468697320657870657269656e636520746f2074686520776f726c64207468726f75676820796f7572206c656e7365732e204974206f6666657273206120776964652072616e6765206f662070616e6f72616d69632064657374696e6174696f6e7320746861742066617363696e61746573207468652070656f706c65207669736974696e6720616e6420746f2074686f7365207761746368696e6720697420696e2061206672616d652e204120776964652076617269657479206f66206c616e647363617065732066726f6d206c6f77206c616e64732c2074726f706963616c20666f726573747320746f2074686520686967682048696d616c6179617320676976657320616e20616d706c652063686f69636520666f72207468652066696c6d6d616b65727320746f206361707475726520697420696e207468656972206c656e73652e205468652063756c747572616c206865726974616765732c20616e6369656e74206d6f6e756d656e74732c20666573746976616c7320616e642064697665727365642067726f7570206f662070656f706c6520676976657320616e6f74686572206d61676963616c206175726120746f206d616b652074686520636f756e747279206d6f72652076696272616e742e2054686520636f756e747279206f6666657273206120636f6c6f7266756c20626c656e64206f66206e61747572616c2062656175747920776974682074686520726963682063756c74757265206d616b696e6720697420756e69717565206f6620697426727371756f3b73206b696e642e3c2f703e0d0a, '4000', 'Very Strenous', 'Five', '', 'August  2015', 'Kathmandu', 'Kathmandu', 0x613a343a7b693a303b733a31313a2246476342715f312e6a7067223b693a313b733a31313a2277766e52625f322e6a7067223b693a323b733a31313a2251676645495f332e6a7067223b693a333b733a31313a2258696e67575f342e6a7067223b7d, '10% Discount', 0, 0, 1, 1, 1, '2015-06-13 21:52:30', '', ''),
			(2, 'breakfast-at-everest', 'Breakfast at Everest', 'bzfzD_popular1.jpg', 1, 2, 0, '2500', 'USD', '5', 1, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0x4e3b, '', 0, 0, 1, 1, 3, '2015-06-13 21:58:35', '', ''),
			(5, 'wedding-at-everest', 'Wedding at Everest', 'bvPP6_popular2.jpg', 1, 2, 0, '5000', 'USD', '5', 1, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Coming Soon', 0, 0, 1, 1, 2, '2015-06-13 22:01:10', '', ''),
			(6, 'tiger-photography-tour', 'Tiger Photography Tour', '5jN4q_popular3.jpg', 1, 3, 0, '5000', 'USD', '5', 1, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Coming Soon', 0, 0, 1, 1, 4, '2015-06-13 22:02:10', '', ''),
			(7, 'everest-sky-dive', 'Everest Sky Dive', 'eEpnI_popular4.jpg', 1, 4, 0, '3520', 'USD', '2', 1, '', '', 2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Coming Soon', 0, 0, 1, 1, 5, '2015-06-13 22:02:56', '', ''),
			(8, 'medical-tourism-nepal', 'Medical Tourism Nepal', '3xaqQ_popular5.jpg', 1, 2, 0, '7000', 'USD', '', 1, '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Coming Soon', 0, 0, 1, 1, 6, '2015-06-13 22:03:44', '', ''),
			(9, 'bhairav-kunda-trek', 'Bhairav Kunda Trek', 'TkDU7_popular7.jpg', 1, 2, 0, '', '', '', 1, '', '', 0, 0x3c703e0d0a094e756e6320637572737573206c696265726f20707572757320616320636f6e677565206172637520637572737573207574207365642076697461652070756c76696e6172206d61737361206964706f727461206e657175657469616d20656c65726973717565206d6920696420666175636962757320696163756c69732076697461652070756c76696e61722e3c2f703e0d0a, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, 1, 8, '2015-06-13 22:04:24', '', ''),
			(10, 'paragliding', 'Paragliding', 's4w4M_popular8.jpg', 1, 2, 0, '', '', '', 1, '', '', 0, 0x3c703e0d0a094e756e6320637572737573206c696265726f20707572757320616320636f6e677565206172637520637572737573207574207365642076697461652070756c76696e6172206d61737361206964706f727461206e657175657469616d20656c65726973717565206d6920696420666175636962757320696163756c69732076697461652070756c76696e61722e3c2f703e0d0a, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, 1, 7, '2015-06-13 22:05:02', '', ''),
			(11, 'paanch-pokhari-tour', 'Paanch Pokhari Tour', 'iRCVM_popular10.jpg', 1, 2, 0, '', '', '', 1, '', '', 0, 0x3c703e0d0a094e756e6320637572737573206c696265726f20707572757320616320636f6e677565206172637520637572737573207574207365642076697461652070756c76696e6172206d61737361206964706f727461206e657175657469616d20656c65726973717565206d6920696420666175636962757320696163756c69732076697461652070756c76696e61722e3c2f703e0d0a, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1, 0, 1, 9, '2015-06-13 22:05:36', '', ''),
			(12, 'khaptad-national-park', 'Khaptad National Park', 'Usw0O_popular11.jpg', 1, 2, 0, '300', 'USD', '', 1, '', '', 0, 0x3c703e0d0a094e756e6320637572737573206c696265726f20707572757320616320636f6e677565206172637520637572737573207574207365642076697461652070756c76696e6172206d61737361206964706f727461206e657175657469616d20656c65726973717565206d6920696420666175636962757320696163756c69732076697461652070756c76696e61722e3c2f703e0d0a, '', '', '', '', '', '', '', '', '', '', 'mon, Jan 26, 2016', '', '', '', '', 1, 1, 0, 1, 10, '2015-06-13 22:06:09', '', ''),
			(13, 'rara-trek', 'Rara Trek', 'wM0zE_popular9.jpg', 1, 2, 0, '', '', '', 1, '', '', 0, 0x3c703e0d0a094e756e6320637572737573206c696265726f20707572757320616320636f6e677565206172637520637572737573207574207365642076697461652070756c76696e6172206d61737361206964706f727461206e657175657469616d20656c65726973717565206d6920696420666175636962757320696163756c69732076697461652070756c76696e61722e3c2f703e0d0a, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 0, 0, 1, 11, '2015-06-14 08:57:20', '', '');";

$data['tbl_slideshow'] = "INSERT INTO `tbl_slideshow` (`id`, `title`, `image`, `linksrc`, `linktype`, `content`, `status`, `added_date`, `sortorder`, `type`) 
			VALUES
			(1, 'slide 1', 'OHCnv_slide1.jpg', '#', 0, '', 1, '2015-06-13 19:57:47', 1, 0),
			(2, 'slide 2', 'Iiu4Q_slide2.jpg', '#', 0, '', 1, '2015-06-13 19:58:16', 2, 0);";

$data['tbl_social_networking'] = "INSERT INTO `tbl_social_networking` (`id`, `title`, `image`, `linksrc`, `status`, `sortorder`, `registered`) 
			VALUES
			(1, 'Facebook', 'soap-icon-facebook', '#', 1, 1, ''),
			(2, 'Twitter', 'soap-icon-twitter', '#', 1, 2, ''),
			(3, 'Google plus', 'soap-icon-googleplus', '#', 1, 3, ''),
			(4, 'Linkedin', 'soap-icon-linkedin', '#', 1, 4, ''),
			(5, 'Vimeo', 'soap-icon-vimeo', '#', 1, 5, ''),
			(6, 'Dribble', 'soap-icon-dribble', '#', 1, 6, ''),
			(7, 'Flicker', 'soap-icon-flickr', '#', 1, 7, '');";

$data['tbl_video'] = "INSERT INTO `tbl_video` (`id`, `source`, `url_type`, `title`, `thumb_image`, `url`, `host`, `content`, `class`, `status`, `sortorder`, `added_date`) 
			VALUES
			(1, 'https://www.youtube.com/watch?v=6IryxtRjBEQ', 'youtube', 'bengal tiger attack bear HD - YouTube', 'http://img.youtube.com/vi/6IryxtRjBEQ/0.jpg', 'https://www.youtube.com/watch?v=6IryxtRjBEQ', 'www.youtube.com', 'The tiger (Panthera tigris) is the largest cat species, reaching a total body length of up to 3.38 m (11.1 ft) over curves and weighing up to 388.7 kg (857 l...', 'youtube', 1, 1, '2015-06-15 12:02:04'),
			(2, 'https://www.youtube.com/watch?v=dZpc936_Hgo', 'youtube', 'Fast & Furious 6 Official Final Trailer (2013) - Vin Diesel Movie HD - YouTube', 'http://img.youtube.com/vi/dZpc936_Hgo/0.jpg', 'https://www.youtube.com/watch?v=dZpc936_Hgo', 'www.youtube.com', 'Subscribe to TRAILERS: http://bit.ly/sxaw6h Subscribe to COMING SOON: http://bit.ly/H2vZUn Like us on FACEBOOK:http://goo.gl/dHs73. Subscribe to INDIE TRAILE...', 'youtube', 1, 2, '2015-06-15 12:02:34');";

$data['tbl_group_type'] = "INSERT INTO `tbl_group_type` (`id`, `group_name`, `group_type`, `authority`, `description`, `status`) 
			VALUES
			(1, 'Administrator', '1', 1, '', 1);";

$data['tbl_users'] = "INSERT INTO `tbl_users` (`id`, `first_name`, `middle_name`, `last_name`, `contact`, `email`, `optional_email`, `username`, `password`, `accesskey`, `image`, `group_id`, `access_code`, `facebook_uid`, `facebook_accesstoken`, `facebook_tokenexpire`, `status`, `sortorder`, `added_date`) 
			VALUES
			(1, 'longtail-e-media', '', '', '', 'support@longtail.info', 'info@longtail.info;support@longtail.info', 'admin', '32b9da145699ea9058dd7d6669e6bcc5', 'NIuqfVYJMSZzG2CaQnugzoG3K20', '', 1, 'jx3PtXqKso', '', '', '2015-04-09 05:15:04', 1, 1, '2014-03-26');";

$data['tbl_themes'] = "INSERT INTO `tbl_themes` (`id`, `title`, `properties`, `jsproperties`, `cssproperties`, `status`, `type`, `added_date`) 
		VALUES
		(1, 'Top Header', '', '', 'a:2:{s:22:\"header-top-nav-bgcolor\";s:7:\"#9fc5e8\";s:22:\"header-top-nav-display\";s:5:\"block\";}', 1, 0, '2015-06-25 23:16:09'),
		(2, 'Main Header', 'a:1:{s:5:\"level\";s:1:\"4\";}', '', 'a:1:{s:17:\"main-menu-bgcolor\";s:7:\"#ffffff\";}', 1, 0, '2015-06-25 23:16:16'),
		(3, 'Slideshow', 'a:5:{s:8:\"imgwidth\";s:4:\"1200\";s:9:\"imgheight\";s:3:\"600\";s:16:\"imagetransaction\";s:19:\"scaledownfrombottom\";s:15:\"imageslidespeed\";s:5:\"15000\";s:10:\"imageslots\";s:1:\"7\";}', 'a:3:{s:12:\"slidenavtype\";s:4:\"both\";s:13:\"slidenavarrow\";s:4:\"none\";s:13:\"slidenavstyle\";s:5:\"round\";}', '', 1, 0, '2015-06-25 23:27:05'),
		(4, 'Main Package', 'a:2:{s:9:\"mpkgtitle\";s:32:\"Exclusive Ama Adventure Packages\";s:12:\"mpkgsubtitle\";s:73:\"Exclusive packages to make the tour memorable lifelong. Book with us Now.\";}', '', 'a:8:{s:10:\"mpkgbgtype\";s:1:\"0\";s:11:\"mpkgbgcolor\";s:4:\"#fff\";s:13:\"mpkgimgradius\";s:4:\"20px\";s:14:\"mpkgshadowleft\";s:4:\"10px\";s:13:\"mpkgshadowtop\";s:3:\"3px\";s:15:\"mpkgshadowright\";s:3:\"4px\";s:16:\"mpkgshadowbottom\";s:3:\"0px\";s:15:\"mpkgshadowcolor\";s:7:\"#9fc5e8\";}', 1, 0, '2015-06-26 17:46:48'),
		(5, 'Sub Package', 'a:1:{s:9:\"spkgtitle\";s:22:\"Other popular packages\";}', '', 'a:2:{s:10:\"spkgbgtype\";s:1:\"1\";s:11:\"spkgbgimage\";s:59:\"http://localhost/synhwakTravel/images/themes/nhaC6_silh.jpg\";}', 1, 0, '2015-06-26 17:17:13'),
		(6, 'Information Block', '', '', 'a:2:{s:16:\"infoblockbgcolor\";s:7:\"#3d85c6\";s:16:\"infoblockdisplay\";s:5:\"block\";}', 1, 0, '2015-06-26 12:57:03'),
		(7, 'Top Footer', '', '', 'a:1:{s:16:\"topfooterbgcolor\";s:4:\"#fff\";}', 1, 0, '2015-06-26 13:02:44'),
		(8, 'Main Footer', '', '', 'a:1:{s:17:\"mainfooterbgcolor\";s:4:\"#eee\";}', 1, 0, '2015-06-26 13:07:07');";

//populate
foreach($data as $tbl=>$sql) { $db->query($sql) or die($sql); }
echo "<script language='javascript'>window.location.href = '../../apanel/index.php';</script>";
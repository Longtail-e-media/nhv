<?php
// GET THE FOLDER NAME AND CHECK IF THE SITE IS INSTALLED OR NOT
include("config.php");
if(!defined('SITE_FOLDER')){
	// GO TO INSTALLATION PROCESS
	echo("<script language='javascript'>window.location.href='includes/controllers/install_config.php';</script>");
}

/*
|	Security Feature of PROTOJCMS enabling all ERROR REPORT ON...
| 	It is recommended to turn error_reporting OFF while placing it online.
*/

// setting mode is only for the development phase. set $__settings = true; iif site mode set to settings.

(defined('DEVELOPMENT_PHASE')) ? '' : define('DEVELOPMENT_PHASE', 1); // set to 0 if not development phase.
(DEVELOPMENT_PHASE == 1) ? error_reporting(E_ALL) : '';

// ******************************************************************************************************************


// DEFINE CORE PATHS
/*
| DS - Directory separator. "\" for windows and "/" for unix and other OS.
*/
defined('DS') 		  	? NULL : define('DS', DIRECTORY_SEPARATOR);
/*
| SITE_ROOT - 
*/
if($online)
{
    $base_protocol = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {$base_protocol .= 's';}
	defined('SITE_ROOT')  		? NULL : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.SITE_FOLDER.DS);
	defined('BASE_URL')   		? NULL : define('BASE_URL', $base_protocol . '://'.$_SERVER['HTTP_HOST'].'/'.SITE_FOLDER.'/');
	
} else {
	defined('SITE_ROOT')  		? NULL : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.str_replace('::','/',SITE_STR).DS.SITE_FOLDER.DS);
	defined('BASE_URL')   		? NULL : define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].str_replace('::','/',SITE_STR).'/'.SITE_FOLDER.'/');
}

/* Common path constant */
defined('LIB_PATH')   			? NULL : define('LIB_PATH', SITE_ROOT.'includes');
defined('AJAX_PATH')   			? NULL : define('AJAX_PATH', SITE_ROOT.'includes'.DS.'controllers'.DS);
defined('JS_PATH')				? NULL : define('JS_PATH', BASE_URL.'js/');
defined('CSS_PATH')				? NULL : define('CSS_PATH', BASE_URL.'css/');
defined('ASSETS_PATH')			? NULL : define('ASSETS_PATH', BASE_URL.'assets/');
defined('IMAGE_PATH')			? NULL : define('IMAGE_PATH', BASE_URL.'images/');
defined('SLIDESHOW_PATH')		? NULL : define('SLIDESHOW_PATH', IMAGE_PATH.'slideshow/');



/* Admin path constatnt */
defined('ADMIN_URL')  			? NULL : define('ADMIN_URL', BASE_URL.'/apanel/');
defined('GOOGLE_URL')  			? NULL : define('GOOGLE_URL','');

defined('ADMIN_JS')				? NULL : define('ADMIN_JS', BASE_URL.'js/apanel/');
defined('ADMIN_CSS')			? NULL : define('ADMIN_CSS', BASE_URL.'css/apanel/');
defined('ADMIN_IMAGES')			? NULL : define('ADMIN_IMAGES', BASE_URL.'images/apanel/');

/* Front path constatnt */
defined('FRONT_JS')				? NULL : define('FRONT_JS', BASE_URL.'/js/front/');
defined('FRONT_CSS')			? NULL : define('FRONT_CSS', BASE_URL.'/css/front/');
defined('FRONT_PLUGINS')		? NULL : define('FRONT_PLUGINS', BASE_URL.'/plugins/');

/* Info path constant */
defined('COPYRIGHT')			? NULL : define('COPYRIGHT', 'copyright &#169; SYNHAWK '.date('Y'));
defined('VERSION')				? NULL : define('VERSION', ' CMS version 1.3 ');
defined('POWERED_BY')			? NULL : define('POWERED_BY', 'Longtail e-media Pvt. Ltd.');
defined('WEBSITE')				? NULL : define('WEBSITE', 'http://www.longtail.info/');


// Load Config file first
//require_once('config.php');
require_once('dBug.php');

// Load core objects
require_once('session.php');
require_once('database.php');
require_once('database_object.php');
// require_once('google-api.php');

// Load basic functions next
require_once('functions.php');
require_once('meta_tags.php');

// Load helper Class
require_once('helpers/language.php');
// require_once('helpers/class.phpmailer.php');
require_once('helpers/PHPMailer/src/Exception.php');
require_once('helpers/PHPMailer/src/PHPMailer.php');
require_once('helpers/PHPMailer/src/SMTP.php');
require_once('helpers/MCAPI.class.php');
require_once('helpers/class.countrylist.php');
require_once('helpers/class.pagination.php');
require_once('helpers/Pagination2.php');
require_once('helpers/class.pdf.php');

// Load module classes
require_once('modals/class.config.php');
require_once('modals/class.log.php');
require_once('modals/class.logaction.php');
require_once('modals/class.module.php');
require_once('modals/class.user.php');
require_once('modals/class.articles.php');
require_once('modals/class.bookinginfo.php');
require_once('modals/class.countries.php');

?>
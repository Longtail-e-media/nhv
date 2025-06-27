<?php
// SITE REGULARS
$jVars['site:header'] 		= Config::getField('headers',true);
$jVars['site:footer'] 		= Config::getField('footer',true);
$siteRegulars 				= Config::find_by_id(1);
$jVars['site:copyright']	= str_replace('{year}',date('Y'),$siteRegulars->copyright)." Website by
                            <a href=\"https://longtail.info/\">Longtail e-media</a>";
$jVars['site:fevicon']		=  '<link rel="shortcut icon" href="'.IMAGE_PATH.'preference/'.$siteRegulars->icon_upload.'"> 
							    <link rel="apple-touch-icon" href="'.IMAGE_PATH.'preference/'.$siteRegulars->icon_upload.'"> 
							    <link rel="apple-touch-icon" sizes="72x72" href="'.IMAGE_PATH.'preference/'.$siteRegulars->icon_upload.'"> 
							    <link rel="apple-touch-icon" sizes="114x114" href="'.IMAGE_PATH.'preference/'.$siteRegulars->icon_upload.'">';
$lgclass = (!defined('ERROR_PAGE') and !defined('NEWS_PAGE')) ?'navbar-brand':'';
$jVars['site:logo']			=  '<a href="'.BASE_URL.'home" title="'.$siteRegulars->sitetitle.'">
			                            <img src="'.IMAGE_PATH.'preference/'.$siteRegulars->logo_upload.'" alt="'.$siteRegulars->sitetitle.'" />
			                        </a>';	

$jVars['site:seotitle'] 	= MetaTagsFor_SEO();
$jVars['baseurl']			= '<base url="'.BASE_URL.'"/>';
$jVars['site:baseurl']		= BASE_URL;
$jVars['site:folder']		= SITE_FOLDER;
$jVars['baselink']	        = '<base href="'.BASE_URL.'" />';

// view modules 
require_once('module.header.php');
//require_once('dynamicfile/dynamic.php');
require_once('module.search.php');
require_once('module.newslists.php');
require_once('module.booking.php');
require_once('module.book.php');
require_once('module.packagelists.php');
require_once('module.onlinechat.php');
require_once('module.enquiry.php');
require_once('module.customize.php');

// SITE MODULES
$modulesList = Module::getAllmode();

foreach($modulesList as $module):
	$fileName = "module.".$module->mode.".php";
	if(file_exists("views/".$fileName)){
	  require_once("views/".$fileName);
	}
endforeach;

// view modules
require_once('language-front.php');
require_once('module.footer.php');
require_once('module.location-info.php');
require_once('module.contactus.php');
require_once('module.testimonial.php');

// Default JCMS Sources >> JS and CSS files ~~~~~~~~~~~~~~~~~~~~
$jVars['frontCss'] = "";
$jVars['forntJs']  = "";

/* For Front CSS */
$initialCssFiles = array(
						 FRONT_CSS."bootstrap.css"
						);
for($i = 0; $i < count($initialCssFiles); $i++)
{
	$jVars['frontCss'] .= getFrontCss($initialCssFiles[$i]);
}	

/* For Front JS */
$initialJsFiles  = array(
						 FRONT_JS."jquery.min.js"
						);
for($i = 0; $i < count($initialJsFiles); $i++)
{
	$jVars['forntJs'] .= getFrontJs($initialJsFiles[$i]);
}
?>
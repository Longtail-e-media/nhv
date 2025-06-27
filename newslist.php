<?php

define('HOMEPAGE', 0); // Track homepage.
define('NEWSLIST_PAGE', 1);// Track news page.
define('JCMSTYPE', 0); // Track Current site language.

require_once("includes/initialize.php");

$currentTemplate	= Config::getCurrentTemplate('template');
$jVars 				= array();
$template 			= "template/{$currentTemplate}/newslist.html";

require_once('views/modules.php');

template($template, $jVars, $currentTemplate);

?>
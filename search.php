<?php

define('HOMEPAGE', 0); // Track homepage.
define('SEARCH_PAGE', 1);// Track Article page.
define('JCMSTYPE', 0); // Track Current site language.

require_once("includes/initialize.php");

$currentTemplate	= Config::getCurrentTemplate('template');
$jVars 				= array();
$template 			= "template/{$currentTemplate}/search.html";

require_once('views/modules.php');

template($template, $jVars, $currentTemplate);

?>
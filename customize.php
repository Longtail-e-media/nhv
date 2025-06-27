<?php

define('HOMEPAGE', 0); // Track homepage.
define('CUSTOMIZE_TRIP', 1);// Track Article page.
define('JCMSTYPE', 0); // Track Current site language.

require_once("includes/initialize.php");

$currentTemplate	= Config::getCurrentTemplate('template');
$jVars 				= array();
$template 			= "template/{$currentTemplate}/customize-trip.html";

require_once('views/modules.php');

template($template, $jVars, $currentTemplate);

?>
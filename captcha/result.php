<?php
/*
============================
QuickCaptcha 1.0 - A bot-thwarting text-in-image web tool.
Copyright (c) 2006 Web 1 Marketing, Inc.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
============================
See settings.php for common settings. You shouldn't need to change
anything in this file.
============================
*/
include "settings.php";

session_start();
$string = strtoupper($_SESSION['string']);

/* RECEIVE VALUE */
$validateValue=$_REQUEST['fieldValue'];
$validateId=$_REQUEST['fieldId'];

	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

if($validateValue == $string){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
}
//session_destroy(); 
?>
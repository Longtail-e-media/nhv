<?php
session_start();
include "settings.php";
$string = strtoupper($_SESSION['string']);
$userstring = strtoupper($_POST['userstring']); 
if (($string == $userstring) && (strlen($string) > 4)) {
	echo 'true'; // json_encode(array("message"=>"success"));
} else {
	echo'false'; // json_encode(array("message"=>"failure"));
}
?>
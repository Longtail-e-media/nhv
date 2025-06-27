<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");
	// Load necessary files then...
	require_once('../initialize.php');
	$action = $_REQUEST['action']; //GET ACTION
	$tableName = "tbl_logs";   //TABLE NAME
	
	switch($action){
		case "delete_all":
			if($db->query("TRUNCATE TABLE {$tableName}")){
				log_action("Log has been cleared.",1,6);
				echo json_encode(array("action"=>"success"));
			} else {
				echo json_encode(array("action"=>"error"));
			}
		break;
	}
?>
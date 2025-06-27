<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');
	
	$action = $_REQUEST['action'];
	
	switch($action) 
	{			
		case "add":	
			$record = new Meetup();
			
			//$record->slug 		= create_slug($_REQUEST['name']);
			$record->name 		= $_REQUEST['name'];
			$record->image		=!empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';	
			$record->address	= $_REQUEST['address'];
			$record->status		= $_REQUEST['status'];
			$record->date1		= $_REQUEST['date1'];
			$record->date2		= $_REQUEST['date2'];
			$record->time = $_REQUEST['time'];
			$record->content = $_REQUEST['content'];
			$record->sortorder	= Meetup::find_maximum();
			
			
			$checkDupliName=Meetup::checkDupliName($record->name);			
			if($checkDupliName):
				echo json_encode(array("action"=>"warning","message"=>"Meetup Title Already Exists."));		
				exit;		
			endif;
			$db->begin();
			if($record->save()): $db->commit();
			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Meetup '".$record->name."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			log_action($message,1,3);
			   //echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['changesSaved']));
				//log_action("Articles [".$record->name."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback(); echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Meetup::find_by_id($_REQUEST['idValue']);
			
			if($record->name!=$_REQUEST['name']){
				$checkDupliName=Meetup::checkDupliName($_REQUEST['name']);
				if($checkDupliName):
					echo json_encode(array("action"=>"warning","message"=>"Meetup name is already exist."));		
					exit;		
				endif;
			}
			
			
			$record->name 		= $_REQUEST['name'];
			$record->image		=!empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$record->address	= $_REQUEST['address'];
			$record->status		= $_REQUEST['status'];
			$record->date1		= $_REQUEST['date1'];
			$record->date2		= $_REQUEST['date2'];
			$record->time = $_REQUEST['time'];
			$record->content = $_REQUEST['content'];
			//$record->sortorder	= Expert::find_maximum();
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Meetup '".$record->name."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action($message,1,4);
			   //log_action("Articles [".$record->name."] Edit Successfully",1,4);
			else: $db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Meetup::find_by_id($id);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_meetup WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_meetup", "sortorder");
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Meetup '".$record->name."'");
			echo json_encode(array("action"=>"success","message"=>$message));	
			log_action("Meetup  [".$record->name."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Meetup::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Meetup::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
		break;
			
		case "bulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$res  = $db->query("DELETE FROM tbl_meetup WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_meetup", "sortorder");
			
			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Meetup"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":			
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			datatableReordering('tbl_meetup', $sortIds, "sortorder", '','',1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Meetup"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
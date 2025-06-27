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
			$record = new Events();
			
			$record->slug 		= create_slug($_REQUEST['title']);
			$record->title 			= $_REQUEST['title'];
			$record->brief 			= $_REQUEST['brief'];				
			$record->event_stdate 	= $_REQUEST['event_stdate'];			
			$record->type 			= $_REQUEST['type'];
			$record->image 			= serialize(array_values(array_filter($_REQUEST['imageArrayname'])));	
			if(!empty($_REQUEST['galleryArrayname'])){
				$record->gallery 		= serialize(array_values(array_filter($_REQUEST['galleryArrayname'])));
			}		
			$record->content		= $_REQUEST['content'];	
			$record->status			= $_REQUEST['status'];
			$record->meta_keywords		= $_REQUEST['meta_keywords'];
			$record->meta_description	= $_REQUEST['meta_description'];
			
			$record->sortorder	= Events::find_maximum();
			$record->added_date = registered();			
			
			$checkDupliName=Events::checkDupliName($record->title);			
			if($checkDupliName):
				echo json_encode(array("action"=>"warning","message"=>"Events Title Already Exists."));		
				exit;		
			endif;

			$db->begin();
			if($record->save()): $db->commit();
			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Event '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Events [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Events::find_by_id($_REQUEST['idValue']);

			if($record->title!=$_REQUEST['title']){
				$checkDupliName=Events::checkDupliName($_REQUEST['title']);
				if($checkDupliName):
					echo json_encode(array("action"=>"warning","message"=>"Events title is already exist."));		
					exit;		
				endif;
			}
							
			$record->slug 		= create_slug($_REQUEST['title']);							
			$record->title 			= $_REQUEST['title'];			
			$record->brief 			= $_REQUEST['brief'];	
			$record->event_stdate 	= $_REQUEST['event_stdate'];			
			$record->type 			= $_REQUEST['type'];
			$record->image 			= serialize(array_values(array_filter($_REQUEST['imageArrayname'])));	
			if(!empty($_REQUEST['galleryArrayname'])){
				$record->gallery 		= serialize(array_values(array_filter($_REQUEST['galleryArrayname'])));
			}	
			$record->content		= $_REQUEST['content'];	
			$record->status			= $_REQUEST['status'];
			$record->meta_keywords		= $_REQUEST['meta_keywords'];
			$record->meta_description	= $_REQUEST['meta_description'];
			
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Event '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Events [".$record->title."] Edit Successfully",1,4);
			else:
				echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Events::find_by_id($id);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_events WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;			
			reOrder("tbl_events", "sortorder");		
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Event '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Events  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Events::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Events::find_by_id($allid[$i]);
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
				$record = Events::find_by_id($allid[$i]);
				log_action("Events  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
				
				$res  = $db->query("DELETE FROM tbl_events WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_events", "sortorder");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Event"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			datatableReordering('tbl_events', $sortIds, "sortorder", '', '',1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Events"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
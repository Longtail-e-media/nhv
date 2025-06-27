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
			$record = new Advertisement();
			
			$record->title 			= $_REQUEST['title'];
			$record->position		= $_REQUEST['position'];
			$record->image			= $_REQUEST['imageArrayname'];
			$record->img_height 	= $_REQUEST['img_height'];
			$record->img_width 		= $_REQUEST['img_width'];
			$record->date_from		= $_REQUEST['date_from'];
			$record->date_to		= $_REQUEST['date_to'];			
			$record->url_link		= $_REQUEST['url_link'];
			$record->notification	= $_REQUEST['notification'];
			$record->notif_status	= $_REQUEST['notif_status'];
			$record->mail_to		= $_REQUEST['mail_to'];
			$record->content		= $_REQUEST['content'];
			$record->remarks		= $_REQUEST['remarks'];			
			$record->status			= $_REQUEST['status'];
			
			$record->sortorder		= Advertisement::find_maximum();
			$record->added_date 	= registered();
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			$db->begin();
			if($record->save()):$db->commit();
			    $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Advertisement '".$record->title."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Advertisement [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else:$db->rollback();echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Advertisement::find_by_id($_REQUEST['idValue']);
			
			$record->title 			= $_REQUEST['title'];
			$record->position		= $_REQUEST['position'];
			$record->image			= $_REQUEST['imageArrayname'];
			$record->img_height 	= $_REQUEST['img_height'];
			$record->img_width 		= $_REQUEST['img_width'];
			$record->date_from		= $_REQUEST['date_from'];
			$record->date_to		= $_REQUEST['date_to'];			
			$record->url_link		= $_REQUEST['url_link'];
			$record->notification	= $_REQUEST['notification'];
			$record->notif_status	= $_REQUEST['notif_status'];
			$record->mail_to		= $_REQUEST['mail_to'];
			$record->content		= $_REQUEST['content'];
			$record->remarks		= $_REQUEST['remarks'];			
			$record->status			= $_REQUEST['status'];
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Advertisement '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Advertisement [".$record->title."] Edit Successfully",1,4);
			else:$db->rollback();
			echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Advertisement::find_by_id($id);
			log_action("Advertisements  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_advertisement WHERE id='{$id}'");
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_advertisement", "sortorder");	
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Advertisement '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));		
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Advertisement::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Advertisement::find_by_id($allid[$i]);
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
				$record = Advertisement::find_by_id($allid[$i]);
				log_action("Advertisements  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
				
				$res  = $db->query("DELETE FROM tbl_advertisement WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();	
			reOrder("tbl_advertisement", "sortorder");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Advertisements"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Advertisement::field_by_id($id,'position');
			datatableReordering('tbl_advertisement', $sortIds, "sortorder", "position",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Advertisement"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
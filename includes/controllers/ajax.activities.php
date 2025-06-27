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
		case "filteractivity":
			$desId = addslashes($_REQUEST['destid']);
			$selId = addslashes($_REQUEST['selct']);
			$rec = Activities::get_all_filterdata($desId,$selId);	
			echo json_encode(array("action"=>"success","result"=>$rec))	;
		break;

		case "add":	
			$record = new Activities();
			
			$record->destinationId = $_REQUEST['destinationId'];
			$record->slug 		= create_slug($_REQUEST['title']);
			$record->title_brief	= $_REQUEST['title_brief'];
			$record->parentOf 	= $_REQUEST['parentOf'];
			$record->title 		= $_REQUEST['title'];
			$record->image		= $_REQUEST['imageArrayname'];
			$record->banner_image = $_REQUEST['imageArrayname2'];	
			$record->content	= $_REQUEST['content'];
			$record->status		= $_REQUEST['status'];
			$record->meta_keywords		= $_REQUEST['meta_keywords'];
			$record->meta_description	= $_REQUEST['meta_description'];
			$record->sortorder	= Activities::find_maximum_byparent("sortorder",$_REQUEST['parentOf']);
			$record->added_date = registered();
			
			/*$checkDupliName=Activities::checkDupliName($record->title);
			if($checkDupliName):
				echo json_encode(array("action"=>"warning","message"=>"Activitiess Title Already Exists."));		
				exit;		
			endif;*/
			$db->begin();
			if($record->save()): $db->commit();
			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Activities '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			log_action($message,1,3);
			   //echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['changesSaved']));
				//log_action("Activities [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback(); echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Activities::find_by_id($_REQUEST['idValue']);
			
			$record->destinationId = $_REQUEST['destinationId'];
			/*if($record->title!=$_REQUEST['title']){
				$checkDupliName=Activities::checkDupliName($_REQUEST['title']);
				if($checkDupliName):
					echo json_encode(array("action"=>"warning","message"=>"Activitiess name is already exist."));		
					exit;		
				endif;
			}*/
			
			$record->slug 		= create_slug($_REQUEST['title']);
			$record->title_brief	= $_REQUEST['title_brief'];
			$record->parentOf 	= $_REQUEST['parentOf'];
			$record->title 		= $_REQUEST['title'];
			$record->image		= $_REQUEST['imageArrayname'];
			$record->banner_image = $_REQUEST['imageArrayname2'];
			$record->content	= $_REQUEST['content'];
			$record->status		= $_REQUEST['status'];
			$record->meta_keywords		= $_REQUEST['meta_keywords'];
			$record->meta_description	= $_REQUEST['meta_description'];
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Activities '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action($message,1,4);
			   //log_action("Activities [".$record->title."] Edit Successfully",1,4);
			else: $db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Activities::find_by_id($id);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_activities WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrderSub("tbl_activities", "sortorder", "parentOf",$record->parentOf);
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Activities '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));	
			log_action("Activitiess  [".$record->name."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Activities::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Activities::find_by_id($allid[$i]);
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
				$res  = $db->query("DELETE FROM tbl_activities WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_activities", "sortorder");
			
			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Activities"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Activities::field_by_id($id,'parentOf');
			datatableReordering('tbl_activities', $sortIds, "sortorder", "parentOf",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Activities"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;	

		case "filteractivityfront":
			$desId = addslashes($_REQUEST['destid']);
			$selId = addslashes($_REQUEST['selct']);
			$rec = Activities::get_all_filterdatafront($desId,$selId);	
			echo json_encode(array("action"=>"success","result"=>$rec))	;
		break;

		case "getactvitypackage":
			$destId = addslashes($_REQUEST['destid']);

			// Activity filter by destination id
			$resact='<option value="">Choose Activities</option>';
			$sql = "SELECT id, title FROM tbl_activities WHERE destinationId='$destId' AND parentOf='0' AND status='1' ORDER BY sortorder DESC ";
			$actRec = Activities::find_by_sql($sql);
			if($actRec){
				foreach($actRec as $actRow){
					$resact.='<option value="'.$actRow->id.'">'.$actRow->title.'</option>';
				}
			}

			// Package filter by destination id
			$respkg='<option value="">Choose Package</option>';
			$sql2 = "SELECT slug, title FROM tbl_package WHERE destinationId='$destId' AND status='1' ORDER BY sortorder DESC ";
			$pkgRec = Package::find_by_sql($sql2);
			if($pkgRec){
				foreach($pkgRec as $pkgRow){
					$respkg.='<option value="'.$pkgRow->slug.'">'.$pkgRow->title.'</option>';
				}
			}

			echo json_encode(array("resactivity"=>$resact,"respackage"=>$respkg));
		break;
	}
?>
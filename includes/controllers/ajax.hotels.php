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
			
			$Hotels = new Hotels();

			$Hotels->slug 		= create_slug($_REQUEST['title']);
			$Hotels->parentId 	= $_REQUEST['parentId'];
			$Hotels->title    	= $_REQUEST['title'];	
			$Hotels->image		= $_REQUEST['imageArrayname'];
			$Hotels->banner_image = $_REQUEST['imageArrayname2'];	
			$Hotels->brief			= $_REQUEST['brief'];
			$Hotels->price_range	= $_REQUEST['price_range'];
			$Hotels->grade		= $_REQUEST['grade'];
			$Hotels->status		= $_REQUEST['status'];
			$Hotels->sortorder	= Hotels::find_maximum_byparent("sortorder",$_REQUEST['parentId']);
			$Hotels->added_date 	= registered();
			
			$checkDupliTitle = Hotels::checkDupliTitle($Hotels->title,$_REQUEST['parentId']);			
			if($checkDupliTitle):
				echo json_encode(array("action"=>"warning","message"=>"Hotels Title Already Exists."));		
				exit;		
			endif;

			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Hotels Image!"));
				exit;					
			endif;
			
			$db->begin();
			if($Hotels->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Hotels Image '".$Hotels->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Hotels [".$Hotels->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;				
		break;
		
		case "edit":			
			$Hotels = Hotels::find_by_id($_REQUEST['idValue']);			
			
			$checkDupliTitle = Hotels::checkDupliTitle($_REQUEST['title'],$Hotels->parentId,$Hotels->id);
			if($checkDupliTitle):
				echo json_encode(array("action"=>"warning","message"=>"Hotels Title is already exist."));		
				exit;		
			endif;

			if(!empty($_REQUEST['imageArrayname'])):				
				$Hotels->image		= $_REQUEST['imageArrayname'];				
			endif;	

			$Hotels->slug 		= create_slug($_REQUEST['title']);
			$Hotels->parentId = $_REQUEST['parentId'];
			$Hotels->title    = $_REQUEST['title'];	
			$Hotels->banner_image = $_REQUEST['imageArrayname2'];
			$Hotels->brief			= $_REQUEST['brief'];
			$Hotels->price_range	= $_REQUEST['price_range'];
			$Hotels->grade		= $_REQUEST['grade'];
			$Hotels->status   = $_REQUEST['status'];	

			$db->begin();				
			if($Hotels->save()):$db->commit();	
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Hotels '".$Hotels->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Hotels [".$Hotels->title."] Edit Successfully",1,4);
			else:$db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;							
		break;
								
		case "delete":
			$id = $_REQUEST['id'];
			$record = Hotels::find_by_id($id);
			log_action("Hotels  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();
			$db->query("DELETE FROM tbl_hotels WHERE parentId='{$id}'");
			$res = $db->query("DELETE FROM tbl_hotels WHERE id='{$id}'");
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_hotels", "sortorder");						
			echo json_encode(array("action"=>"success","message"=>"Hotels  [".$record->title."]".$GLOBALS['basic']['deletedSuccess']));							
		break;
		
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Hotels::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				   if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;

		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Hotels::find_by_id($allid[$i]);
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
						$db->query("DELETE FROM tbl_hotels WHERE parentId='".$allid[$i]."'");
				$res  = $db->query("DELETE FROM tbl_hotels WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_hotels", "sortorder");
			
			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Hotels"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
				
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Hotels::field_by_id($id,'parentId');
			datatableReordering('tbl_hotels', $sortIds, "sortorder", '', '',1);
			datatableReordering('tbl_hotels', $sortIds, "sortorder", "parentId",$posId);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Hotels "); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;		
	}
?>
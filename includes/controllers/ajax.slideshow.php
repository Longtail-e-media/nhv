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
			$record = new Slideshow();
			
			$record->title 			= $_REQUEST['title'];
			$record->image			= $_REQUEST['imageArrayname'];
			$record->linksrc 		= $_REQUEST['linksrc'];
			$record->linktype 		= $_REQUEST['linktype'];
			$record->content		= $_REQUEST['content'];			
			$record->status			= $_REQUEST['status'];
			$record->type           = $_REQUEST['type'];
			$record->sortorder		= Slideshow::find_maximum();
			$record->added_date 	= registered();
			if($_REQUEST['type']==1){
				$record->image		= !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			}else{
				$record->source 	= $_REQUEST['videoArrayname'];
			}
		
			
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Slideshow '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Slideshow [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Slideshow::find_by_id($_REQUEST['idValue']);
			
			$record->title 			= $_REQUEST['title'];
			$record->linksrc 		= $_REQUEST['linksrc'];
			$record->linktype 		= $_REQUEST['linktype'];
			$record->content		= $_REQUEST['content'];			
			$record->status			= $_REQUEST['status'];
			
			$record->type           = $_REQUEST['type'];
			if($_REQUEST['type']==1){
				if(!empty($_REQUEST['imageArrayname'])) {
					$record->image		= $_REQUEST['imageArrayname'];
				}
				$record->source 	= '';
			}else{
				$record->source 	= $_REQUEST['videoArrayname'];
				$record->image		= '';
			}	

			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Slideshow '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Slideshow [".$record->title."] Edit Successfully",1,4);
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Slideshow::find_by_id($id);
			log_action("Slideshows  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->query("DELETE FROM tbl_slideshow WHERE id='{$id}'");
			
			reOrder("tbl_slideshow", "sortorder");			
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Slideshow '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Slideshow  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Slideshow::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Slideshow::find_by_id($allid[$i]);
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
				$record = Slideshow::find_by_id($allid[$i]);
				log_action("Slideshow  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);				
				$res = $db->query("DELETE FROM tbl_slideshow WHERE id='".$allid[$i]."'");				
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_slideshow", "sortorder");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Slideshow"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":			
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Slideshow::field_by_id($id,'type');
			datatableReordering('tbl_slideshow', $sortIds, "sortorder", "type",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Slideshow"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
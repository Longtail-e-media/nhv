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
			
			$Links = new Links();
			
			$Links->parentId 	= $_REQUEST['parentId'];
			$Links->title    	= $_REQUEST['title'];	
			//$Links->image		= $_REQUEST['imageArrayname'];	
			$Links->linktype	= $_REQUEST['linktype'];
			$Links->linksrc		= $_REQUEST['linksrc'];
			$Links->status		= $_REQUEST['status'];
			$Links->sortorder	= Links::find_maximum_byparent("sortorder",$_REQUEST['parentId']);
			$Links->added_date 	= registered();
			
			$checkDupliTitle = Links::checkDupliTitle($Links->title,$_REQUEST['parentId']);			
			if($checkDupliTitle):
				echo json_encode(array("action"=>"warning","message"=>"Links Title Already Exists."));		
				exit;		
			endif;

			/*if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Links Image!"));
				exit;					
			endif;*/
			
			$db->begin();
			if($Links->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Links Image '".$Links->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Links [".$Links->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;				
		break;
		
		case "edit":			
			$Links = Links::find_by_id($_REQUEST['idValue']);			
			
			$checkDupliTitle = Links::checkDupliTitle($_REQUEST['title'],$Links->parentId,$Links->id);
			if($checkDupliTitle):
				echo json_encode(array("action"=>"warning","message"=>"Links Title is already exist."));		
				exit;		
			endif;

			/*if(!empty($_REQUEST['imageArrayname'])):				
				$Links->image		= $_REQUEST['imageArrayname'];				
			endif;*/	
			$Links->parentId = $_REQUEST['parentId'];
			$Links->title    = $_REQUEST['title'];	
			$Links->linktype = $_REQUEST['linktype'];
			$Links->linksrc	 = $_REQUEST['linksrc'];
			$Links->status   = $_REQUEST['status'];	

			$db->begin();				
			if($Links->save()):$db->commit();	
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Links '".$Links->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Links [".$Links->title."] Edit Successfully",1,4);
			else:$db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;							
		break;
								
		case "delete":
			$id = $_REQUEST['id'];
			$record = Links::find_by_id($id);
			log_action("Links  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();
			$db->query("DELETE FROM tbl_links WHERE parentId='{$id}'");
			$res = $db->query("DELETE FROM tbl_links WHERE id='{$id}'");
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_links", "sortorder");						
			echo json_encode(array("action"=>"success","message"=>"Links  [".$record->title."]".$GLOBALS['basic']['deletedSuccess']));							
		break;
		
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Links::find_by_id($id);
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
				$record = Links::find_by_id($allid[$i]);
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
						$db->query("DELETE FROM tbl_links WHERE parentId='".$allid[$i]."'");
				$res  = $db->query("DELETE FROM tbl_links WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_links", "sortorder");
			
			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Links"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
				
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Links::field_by_id($id,'parentId');
			datatableReordering('tbl_links', $sortIds, "sortorder", '', '',1);
			datatableReordering('tbl_links', $sortIds, "sortorder", "parentId",$posId);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Links "); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;		
	}
?>
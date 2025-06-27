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
			$record = new Video();
			
			$record->source 	= $_REQUEST['source'];
			$record->url_type  	= $_REQUEST['url_type'];

			$vRow =  getMyvideo($record->source,$record->url_type);
			$record->title 		= $vRow['title'];
			$record->thumb_image= $vRow['thumb_image'];
			$record->url 		= $vRow['url'];
			$record->host 		= $vRow['host'];
			$record->content 	= $vRow['content'];
			$record->class 		= $vRow['class'];

			$record->status		= 1;
			$record->sortorder	= Video::find_maximum();
			$record->added_date = registered();
			
			$db->begin();
			if($record->save()): $db->commit();
			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Video '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Video [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
		case "editExistsRecord":
			$id = addslashes($_REQUEST['id']);
			$record = Video::find_by_id($id);
			echo json_encode(array("editId"=>$record->id,"title"=>$record->title,"vsource"=>$record->source));
		break;
			
		case "edit":
			$record = Video::find_by_id($_REQUEST['idValue']);
			
			$record->source 	= $_REQUEST['source'];
			$record->url_type  	= $_REQUEST['url_type'];

			$vRow =  getMyvideo($record->source,$record->url_type);
			$record->title 		= $vRow['title'];
			$record->thumb_image= $vRow['thumb_image'];
			$record->url 		= $vRow['url'];
			$record->host 		= $vRow['host'];
			$record->content 	= $vRow['content'];
			$record->class 		= $vRow['class'];
			
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Video '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Video [".$record->title."] Edit Successfully",1,4);
			else:
				echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Video::find_by_id($id);
			$db->query("DELETE FROM tbl_video WHERE id='{$id}'");
			
			reOrder("tbl_video", "sortorder");
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Video '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Video  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Video::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
						
		case "sort":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$order	= $_REQUEST['toPosition'];// IS a line containing sortorder
			
			$db->query("UPDATE tbl_video SET sortorder=".$order." WHERE id=".$id." ");
			
			reOrder("tbl_video", "sortorder");
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Video"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
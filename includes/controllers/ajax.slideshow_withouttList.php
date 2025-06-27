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
			
			$imageName  = !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$title      = !empty($_REQUEST['title'])?$_REQUEST['title']:'';
			
			if(!empty($imageName)):
			foreach($imageName as $key=>$val):
				$FimageName		= $imageName[$key];
				$Ftitle	        = $title[$key];																	
				//Save Record
				if(!empty($FimageName)):
				$Slideshow	 = new Slideshow();

				$Slideshow->image		= $FimageName; 		
				$Slideshow->title     	= $Ftitle;
				$Slideshow->status		= 1;
				$Slideshow->sortorder	= Slideshow::find_maximum();														
				$Slideshow->registered	= registered();
				$db->begin();						
				$res   =  $Slideshow->save();
				   if($res):$db->commit();	else: $db->rollback();endif;
				endif;
			endforeach;	
				$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Images '".$Slideshow->title."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;						
		break;
				
		case "delete":
			$id = $_REQUEST['id'];
			$record = Slideshow::find_by_id($id);
			log_action("Slideshow Image  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();
			$res  = $db->query("DELETE FROM tbl_slideshows WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_slideshows", "sortorder");			
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Slideshow Image '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Slideshow Image  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);	
		break;
		
		
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Slideshow::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
		
		case "sortSlideshow":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$record = Slideshow::find_by_id($id);
			$order	= $_REQUEST['toPosition'];// IS a line containing sortorder
			
			$db->begin();
			$res = $db->query("UPDATE tbl_slideshows SET sortorder=".$order." WHERE id=".$id." ");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_slideshows", "sortorder");
			echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['sorted']));							
		break;
	}
?>
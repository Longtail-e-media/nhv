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
			$Gallery = new Gallery();
			
			$Gallery->title 		= $_REQUEST['title'];
			$Gallery->image			= $_REQUEST['imageArrayname'];			
			$Gallery->status		= 1;
			$Gallery->sortorder		= Gallery::find_maximum();														
			$Gallery->registered	= registered();	
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$db->begin();
			if($Gallery->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Gallery Image '".$Gallery->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Gallery Image [".$Gallery->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
		case "edit":			
			$Gallery = Gallery::find_by_id($_REQUEST['idValue']);
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$Gallery->image	= $_REQUEST['imageArrayname']; 		
			$Gallery->title = $_REQUEST['title'];			
			$db->begin();				
			if($Gallery->save()):$db->commit();	
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Gallery '".$Gallery->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Gallery Image [".$Gallery->title."] Edit Successfully",1,4);
			else:$db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;							
		break;

		case "delete":
			$id = $_REQUEST['id'];
			$record = Gallery::find_by_id($id);
			log_action("Gallery Image  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_galleries WHERE id='{$id}'");
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_galleries", "sortorder");						
			echo json_encode(array("action"=>"success"));							
		break;
		
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Gallery::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				   if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;

		case "sort":			
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			datatableReordering('tbl_galleries', $sortIds, "sortorder", '','',1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Gallery"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;

		// Sub gallery action section	
		case "addSubGalleryImage":
			$galleryid = $_REQUEST['galleryid'];
			$Gallery	 = new GalleryImage();

			$Gallery->title 		= $_REQUEST['title'];
			$Gallery->image			= $_REQUEST['imageArrayname'];	
			$Gallery->galleryid		= $galleryid;	
			$Gallery->status		= 1;
			$Gallery->sortorder		= GalleryImage::find_maximum_byparent("sortorder",$galleryid);																										
			$Gallery->registered	= registered();	
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$db->begin();
			if($Gallery->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Gallery Image '".$Gallery->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Gallery Image [".$Gallery->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;						
		break;			
		
		
		case "deleteSubimage":
			$id = $_REQUEST['id'];
			$record = GalleryImage::find_by_id($id);
			log_action("Sub Gallery Image  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();  		    	
			$res =  $db->query("DELETE FROM tbl_gallery_images WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_gallery_images", "sortorder");					
			echo json_encode(array("action"=>"success"));	
		break;

		case "SubtoggleStatus":
			$id = $_REQUEST['id'];
			$record = GalleryImage::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;		
		
		case "subSort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = GalleryImage::field_by_id($id,'galleryid');
			datatableReordering('tbl_gallery_images', $sortIds, "sortorder", "galleryid",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Gallery Image"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;		
	}
?>
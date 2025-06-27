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
			
			$Gallery->slug 			= create_slug($_REQUEST['title']);
			$Gallery->title 		= $_REQUEST['title'];
			$Gallery->image			= $_REQUEST['imageArrayname'];			
			$Gallery->status		= 1;
			$Gallery->sortorder		= Gallery::find_maximum();														
			$Gallery->registered	= registered();	
			
			$checkDupliName = Gallery::checkDupliName($Gallery->title);			
			if($checkDupliName):
				echo json_encode(array("action"=>"warning","message"=>"Gallery Title Already Exists."));		
				exit;		
			endif;

			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$db->begin();
			if($Gallery->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Gallery Image '".$Gallery->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Gallery [".$Gallery->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
		case "edit":			
			$Gallery = Gallery::find_by_id($_REQUEST['idValue']);
			
			if($Gallery->title!=$_REQUEST['title']){
				$checkDupliName = Gallery::checkDupliName($_REQUEST['title']);
				if($checkDupliName):
					echo json_encode(array("action"=>"warning","message"=>"Gallery title is already exist."));		
					exit;		
				endif;
			}

			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$Gallery->image	= $_REQUEST['imageArrayname']; 
			$Gallery->slug 	= create_slug($_REQUEST['title']);		
			$Gallery->title = $_REQUEST['title'];			
			$db->begin();				
			if($Gallery->save()):$db->commit();	
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Gallery '".$Gallery->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Gallery Image [".$Gallery->title."] Edit Successfully",1,4);
			else:$db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;							
		break;
		
		case "addSubGalleryImage":
					
			$imageName  = !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$title      = !empty($_REQUEST['title'])?$_REQUEST['title']:'';
			$galleryid  = $_REQUEST['galleryid'];
			if(!empty($imageName)):
			foreach($imageName as $key=>$val):
				$FimageName		= $imageName[$key];
				$Ftitle	        = $title[$key];																	
				//Save Record
				if(!empty($FimageName)):
				$Gallery	 = new GalleryImage();

				$Gallery->image			= $FimageName; 		
				$Gallery->title     	= $Ftitle;
				$Gallery->status		= 1;
				$Gallery->galleryid		= $galleryid;
				$Gallery->sortorder		= GalleryImage::find_maximum_byparent("sortorder",$galleryid);														
				$Gallery->registered	= registered();						
				$db->begin();						
				$res   =  $Gallery->save();
				   if($res):$db->commit();	else: $db->rollback();endif;
				log_action("Sub Gallery Image [".$Gallery->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
				endif;
			endforeach;				
				echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['changesSaved'],"galleryid"=>$galleryid));				
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
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
		
		case "toggleStatusSubimage":
			$id = $_REQUEST['id'];
			$record = GalleryImage::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();  	
			$res = $record->save();
			if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;
		
		case "sort":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$order	= ($_REQUEST['toPosition']==1)?0:$_REQUEST['toPosition'];// IS a line containing sortorder
			$db->begin();
			$res = $db->query("UPDATE tbl_galleries SET sortorder=".$order." WHERE id=".$id." ");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_galleries", "sortorder");
			echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['sorted']));
		break;
		
		case "sortSubGalley":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$record = GalleryImage::find_by_id($id);
			$order	= $_REQUEST['toPosition'];// IS a line containing sortorder
			
			$db->begin();
			$res = $db->query("UPDATE tbl_gallery_images SET sortorder=".$order." WHERE id=".$id." ");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrderSub("tbl_gallery_images", "sortorder", "galleryid",$record->galleryid);
			echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['sorted']));
		break;		
	}
?>
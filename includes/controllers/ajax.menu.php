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
			$record = new Menu();

			$record->type 			= !empty($_REQUEST['type'])?$_REQUEST['type']:Menu::getType_By($_REQUEST['parentOf']);
			// $record->style 			= !empty($_REQUEST['style'])?$_REQUEST['style']:Menu::getStyle_By($_REQUEST['parentOf']);
		    $record->module 		= $_REQUEST['module'];
		    $record->module_id 		= $_REQUEST['module_id'];
		    $record->name 			= $_REQUEST['name'];
			$record->linksrc 		= $_REQUEST['linksrc'];
			$record->image		= !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$record->parentOf 		= $_REQUEST['parentOf'];
			$record->linktype 		= $_REQUEST['linktype'];
			$record->status			= $_REQUEST['status'];
			$record->sortorder		= Menu::find_maximum_byparent("sortorder",$_REQUEST['parentOf']);
			$record->added_date 	= registered();
			
			
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Menu '".$record->name."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Menu [".$record->name."] Created".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
			
		case "edit":
			$record = Menu::find_by_id($_REQUEST['idValue']);
			
			$record->type 		= !empty($_REQUEST['type'])?$_REQUEST['type']:Menu::getType_By($_REQUEST['parentOf']);
			// $record->style 		= !empty($_REQUEST['style'])?$_REQUEST['style']:Menu::getStyle_By($_REQUEST['parentOf']);
			$record->module 	= $_REQUEST['module'];
		    $record->module_id 	= $_REQUEST['module_id'];
			$record->name 		= $_REQUEST['name'];
			$record->linksrc 	= $_REQUEST['linksrc'];
			$record->image		= !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$record->parentOf 	= $_REQUEST['parentOf'];
			$record->linktype 	= $_REQUEST['linktype'];
			$record->status		= $_REQUEST['status'];
			
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Menu '".$record->name."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Menu [".$record->name."] Edit Successfully",1,4);
			else: 
				$db->rollback();
			 	echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
			
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Menu::find_by_id($id);
			// Loop through to check the sub menus.
			if($record):
			delteMenuSubs($record->id);

			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Menu '".$record->name."'");
			echo json_encode(array("action"=>"success","message"=>$message));			
			log_action("Menu  [".$record->name."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			endif;
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Menu::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;			
		
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Menu::field_by_id($id,'parentOf');
			datatableReordering('tbl_menu', $sortIds, "sortorder", "parentOf",$posId);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Menu"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;		
	}
?>
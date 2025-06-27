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
			$record = new Career();			
			$record->fullname 		    = $_REQUEST['fullname'];
			$record->current_address 	= $_REQUEST['current_address'];			
			$record->mobile	 			= $_REQUEST['mobile'];
			$record->phone				= $_REQUEST['phone'];
			$record->email 				= $_REQUEST['email'];			
			$record->career				= $_REQUEST['career'];
			$record->exp				= $_REQUEST['exp'];
			$record->expyear			= $_REQUEST['expyear'];
			$record->expmonth			= $_REQUEST['expmonth'];
			$record->SalaryCriteria		= $_REQUEST['SalaryCriteria'];
			$record->ES_Currency_Abb	= $_REQUEST['ES_Currency_Abb'];
			$record->salary				= $_REQUEST['salary'];
			$record->Level				= $_REQUEST['Level'];
			$record->qualification		= $_REQUEST['qualification'];
			$record->myfile				= $_REQUEST['myfile'];
			$record->career_date		= $_REQUEST['career_date'];

			
			
					
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Career '".$record->fullname."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Career [".$record->fullname."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Career::find_by_id($_REQUEST['idValue']);
							
			$record->fullname 		    = $_REQUEST['fullname'];
			$record->current_address 	= $_REQUEST['current_address'];			
			$record->mobile	 			= $_REQUEST['mobile'];
			$record->phone				= $_REQUEST['phone'];
			$record->email 				= $_REQUEST['email'];			
			$record->career				= $_REQUEST['career'];
			$record->exp				= $_REQUEST['exp'];
			$record->expyear			= $_REQUEST['expyear'];
			$record->expmonth			= $_REQUEST['expmonth'];
			$record->SalaryCriteria		= $_REQUEST['SalaryCriteria'];
			$record->ES_Currency_Abb	= $_REQUEST['ES_Currency_Abb'];
			$record->salary				= $_REQUEST['salary'];
			$record->Level				= $_REQUEST['Level'];
			$record->qualification		= $_REQUEST['qualification'];
			$record->myfile				= $_REQUEST['myfile'];


			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Career '".$record->fullname."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Career [".$record->fullname."] Edit Successfully",1,4);
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Career::find_by_id($id);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_career WHERE id='{$id}'");
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_career", "id");
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Career '".$record->fullname."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Career  [".$record->fullname."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Career::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Career::find_by_id($allid[$i]);
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
				$record = Career::find_by_id($allid[$i]);
				log_action("Career  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);				
				$res = $db->query("DELETE FROM tbl_career WHERE id='".$allid[$i]."'");				
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_career", "id");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Career"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$order	= ($_REQUEST['toPosition']==1)?0:$_REQUEST['toPosition'];// IS a line containing sortorder
			
			$db->query("UPDATE tbl_news SET sortorder=".$order." WHERE id=".$id." ");
			
			reOrder("tbl_career", "sortorder");
			$message  = sprintf($GLOBALS['basic']['sorted_'], "dd-mm-yyyy"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
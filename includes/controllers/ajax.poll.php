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
			$record = new Poll();
			
			$record->question			= $_REQUEST['question'];
			$record->status				= $_REQUEST['status'];
			$record->sortorder			= Poll::find_maximum();
			$record->added_date 		= registered();
			
			$db->begin();
			if($record->save()): 	
				$PollId  = mysql_insert_id(); 
				
				// Inserting Poll Options				
				$PollOptionTitle	= !empty($_REQUEST['pollOption'])?$_REQUEST['pollOption']:"";		
				
				if(!empty($PollOptionTitle))
				foreach($PollOptionTitle as $key=>$val):
					$FPollOptionTitle	= $PollOptionTitle[$key];																	
					//Save Record
					if(!empty($FPollOptionTitle)):
					$OPTrecord = new PollOptions();
					
					$OPTrecord->pollid		= $PollId;
					$OPTrecord->pollOption	= $FPollOptionTitle; 
					$OPTrecord->sortorder	= PollOptions::find_maximum();					
					$OPTrecord->save();
					endif;
				endforeach;								
			   $db->commit();				
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Poll '".$record->question."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action($message,1,3);
			else: $db->rollback(); echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Poll::find_by_id($_REQUEST['idValue']);
			
			$record->question	= $_REQUEST['question'];
			$record->status		= $_REQUEST['status'];
			$db->begin();
			$record->save();
			$PollId  = $_REQUEST['idValue']; 
			$db->query("DELETE FROM `tbl_polloptions` WHERE pollid='".$PollId."'");
			
			// Inserting Poll Options				
				$PollOptionTitle	= !empty($_REQUEST['pollOption'])?$_REQUEST['pollOption']:"";		
				
				if(!empty($PollOptionTitle))
				foreach($PollOptionTitle as $key=>$val):
					$FPollOptionTitle	= $PollOptionTitle[$key];																	
					//Save Record
					if(!empty($FPollOptionTitle)):
					$OPTrecord = new PollOptions();
					
					$OPTrecord->pollid		= $PollId;
					$OPTrecord->pollOption	= $FPollOptionTitle; 
					$OPTrecord->sortorder	= PollOptions::find_maximum();					
					$res  =  $OPTrecord->save();
					endif;
				endforeach;	
			if($res)$db->commit();else $db->rollback();	
			$message  = sprintf($GLOBALS['basic']['changesSaved_'], "Poll '".$record->question."'");
			echo json_encode(array("action"=>"success","message"=>$message));

				log_action($message,1,4);				
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Poll::find_by_id($id);
			$db->begin();
			$db->query("DELETE FROM `tbl_polloptions` WHERE pollid='".$id."'");
			$res = $db->query("DELETE FROM tbl_polls WHERE id='{$id}'");
			if($res)$db->commit();else $db->rollback();	
			reOrder("tbl_polls", "sortorder");
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Poll '".$record->question."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			log_action($message,1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Poll::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Poll::find_by_id($allid[$i]);
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
				$record = Poll::find_by_id($allid[$i]);
				log_action("Polls  [".$record->question."]".$GLOBALS['basic']['deletedSuccess'],1,6);
				
				$db->query("DELETE FROM `tbl_polloptions` WHERE pollid='".$allid[$i]."'");
				$res  = $db->query("DELETE FROM tbl_polls WHERE id='".$allid[$i]."'");
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();	
			reOrder("tbl_polls", "sortorder");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Poll"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			datatableReordering('tbl_polls', $sortIds, "sortorder", '', '',1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Poll"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;
	}
?>
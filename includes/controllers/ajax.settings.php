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
		case "adminTemplating":
			$configs = Config::find_by_id(1);
			$configs->admin_template = $_REQUEST['template'];
			if($configs->save()){
				echo "Template changes saved successfully.||1";	
			} else {
				echo "";
			}
			break;
		
		case "general":	
			$configs = Config::find_by_id(1);
			
			$configs->sitename 			= $_REQUEST['sitename'];
			$configs->sitetitle 		= $_REQUEST['sitetitle'];
			$configs->headers 			= $_REQUEST['headers'];
			$configs->footer 			= $_REQUEST['footer'];
			$configs->search_box 		= $_REQUEST['search_box'];
			$configs->search_result		= $_REQUEST['search_result'];
			$configs->site_keywords 	= $_REQUEST['site_keywords'];
			$configs->site_description	= $_REQUEST['site_description'];
            $db->begin();
			if($configs->save()):	$db->commit();	
			$message  = sprintf($GLOBALS['basic']['changesSaved_'], "Configuration '".$configs->sitename."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action($GLOBALS['setts']['generalDone']);
			else: $db->rollback(); echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
			break;
			
		case "profile":
			$user = User::find_by_id(1);
			
			$user->name 	= $_REQUEST['name'];
			$user->email 	= $_REQUEST['email'];
			$user->address 	= $_REQUEST['address'];
			$user->username = $_REQUEST['username'];
			
			// check if the password is reset or not
			$password = $_REQUEST['password'];
			$confirmP = $_REQUEST['passwordConfirm'];
			($password == $confirmP && $password!="") ? $user->password = md5($password) : NULL ;
			
			if($user->save()) {
				echo $GLOBALS['basic']['changesSaved']."||1";
				log_action($GLOBALS['setts']['profileDone']);
			} else  {
				echo $GLOBALS['basic']['noChanges']."||4";
			}
			break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$module = Module::find_by_id($id);
			$module->published = ($module->published == 1) ? 0 : 1 ;
			$module->save();
			echo "";
			break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$module = Module::find_by_id($allid[$i]);
				$module->published = ($module->published == 1) ? 0 : 1 ;
				$module->save();
			}
			echo "";
			break;
			
		case "sort":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$order	= $_REQUEST['order'];// IS a line containing sortorder
			$arr_id = explode("|", $id);
			$arr_or	= explode("|", $order);
			$action = 4;
			$totalrows = count($arr_or);
			for($i=1; $i<$totalrows; $i++){
				$module = Module::find_by_id($arr_id[$i]);
				$module->sortorder = $arr_or[$i];
				if($module->save()) {
					$action = 1;
				}
			}
			echo ($action == 1) ? $GLOBALS['basic']['sorted']."||1" : "4";
			break;
		
		case "perPageSave":
			$id = $_REQUEST['id'];
			$module = Module::find_by_id($_REQUEST['id']);
			$module->perpage = $_REQUEST['perpage'];
			if($module->save()){
				echo $GLOBALS['basic']['changesSaved']."||1";
			} else {
				echo 4;
			}
			break;
			
		case "module_name":
			$id = $_REQUEST['id'];
			$module = Module::find_by_id($id);
			$module->name = $_REQUEST['name'];
			if($module->save()){
				echo $GLOBALS['basic']['changesSaved']."||1";
			} else {
				echo 4;
			}
			break;
		case 'booking_delete':
			$id = $_REQUEST['id'];
			$record = Bookinginfo::find_by_id($id);
			$db->query("UPDATE tbl_bookinginfo SET status='0' WHERE id='$id'");		
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Booking Information '".$record->accesskey."'");
			echo json_encode(array("action"=>"success","message"=>$message));				
			log_action("Booking Information  [".$record->accesskey."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			break;
	}
?>
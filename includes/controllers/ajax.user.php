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
		case "addNewUser":
			$record = new User();

			$record->first_name 	= $_REQUEST['first_name'];
			$record->middle_name	= $_REQUEST['middle_name'];
			$record->last_name		= $_REQUEST['last_name'];				
			$record->email			= $_REQUEST['email'];
			$record->optional_email = $_REQUEST['optional_email'];
			$record->username		= $_REQUEST['username'];
			$record->password		= md5($_REQUEST['password']);
			$record->accesskey		= @randomKeys(25);
			$record->group_id		= $_REQUEST['field_type'];
			$record->status			= $_REQUEST['status'];
			$record->sortorder		= User::find_maximum();
			$record->added_date 	= registered();
			
			$checkDupliUname=User::checkDupliUname($record->username);
			if($checkDupliUname):
				echo json_encode(array("action"=>"warning","message"=>"Username Already Exists."));		
				exit;		
			endif;
			$db->begin();
			if($record->save()): $db->commit();
				$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
				log_action("User [".$record->first_name." ".$record->middle_name." ".$record->last_name."] login Created ".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback(); echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
		case "editNewUser":
			$record = User::find_by_id($_REQUEST['idValue']);
			
			$record->first_name 	= $_REQUEST['first_name'];
			$record->middle_name	= $_REQUEST['middle_name'];
			$record->last_name		= $_REQUEST['last_name'];
			$record->email			= $_REQUEST['email'];
			$record->optional_email = $_REQUEST['optional_email'];
			$record->accesskey		= @randomKeys(25);
			if($record->username!=$_REQUEST['username']){
				$checkDupliUname=User::checkDupliUname($_REQUEST['username']);
				if($checkDupliUname):
					echo json_encode(array("action"=>"warning","message"=>"Username Already Exists."));	
					exit;		
				endif;
			}
			
			$record->username	= $_REQUEST['username'];			
			$record->status		= $_REQUEST['status'];
			$record->group_id	= $_REQUEST['field_type'];
			if(!empty($_REQUEST['password']))
			$record->password	= md5($_REQUEST['password']);
			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("User [".$record->first_name." ".$record->middle_name." ".$record->last_name."] Edit Successfully",1,4);
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;		

		case "userPermission":
			$record = User::find_by_id($_REQUEST['idValue']);
			
			$module_id = !empty($_REQUEST['module_id'])?$_REQUEST['module_id']:array();
			$record->permission = serialize($module_id);

			$db->begin();
			if($record->save()):$db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("User [".$record->first_name." ".$record->middle_name." ".$record->last_name."] Edit Successfully",1,4);
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
					
		case "delete":			
			$id = $_REQUEST['id'];
			$record = User::find_by_id($id);
			$db->begin();
			$res = $db->query("DELETE FROM tbl_users WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_users", "sortorder");
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Question Category  [".$record->first_name.' '.$record->middle_name.' '.$record->last_name."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = User::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();  	
			$res = $record->save();
			if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;						
		case "sortbyadmin":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$order	= ($_REQUEST['toPosition']==1)?0:$_REQUEST['toPosition'];// IS a line containing sortorder
			$db->begin();
			$res = $db->query("UPDATE tbl_users SET sortorder=".$order." WHERE id=".$id." ");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_users", "sortorder");
			$message  = sprintf($GLOBALS['basic']['sorted_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			echo json_encode(array("action"=>"success","message"=>$message));	
		break;

		case "checkLogin":
			$session->start();
			$uname    = addslashes($_REQUEST['username']);
			$password = addslashes($_REQUEST['password']) ;

			$found_user = User::authenticateAdmin($uname, md5($password));
			
			// ** check the number of login attempts
			$_SESSION['countrials'] = (isset($_SESSION['countrials'])) ? $_SESSION['countrials']+1 : 1;
			if($found_user):	

				$session->set('u_id',$found_user->id);
				$session->set('acc_ip',$_SERVER['REMOTE_ADDR']);
				$session->set('acc_agent',$_SERVER['HTTP_USER_AGENT']);
				$session->set('loginUser',$found_user->first_name.' '.$found_user->middle_name.' '.$found_user->last_name);
				$session->set('accesskey',$found_user->accesskey);

				$preId = Config::getconfig_info();
				log_action($GLOBALS['login']['login'].$session->get('loginUser').$GLOBALS['login']['loggedIn'],1,1);
				echo json_encode(array("action"=>"success","pgaction"=>$preId->action));
			else: 
				echo json_encode(array("action"=>"unsuccess","message"=>"Uername Or Password Not Match "));     
			endif;
		break;
		
		case "changepassword":
			$record = User::find_by_id($_REQUEST['idValue']);	
			
			if(!empty($_REQUEST['password']))
			$record->password	= md5($_REQUEST['password']);	
			$db->begin();		
			if($record->save()): $db->commit();
				$message  = sprintf($GLOBALS['basic']['changesSaved_'], "User '".$record->first_name." ".$record->middle_name." ".$record->last_name."'");
			    echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback();echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
		
		case "forgetuser_password":
			$emailAddress  = addslashes($_REQUEST['mailaddress']);
			$mailcheck     = User::get_validMember_mail($emailAddress);
			
			if($mailcheck):			
				$accessToken = randomKeys(10);			
				$row = User::find_by_mail($emailAddress);
				
				$forgetRec	 = User::find_by_id($row->id);				
				$forgetRec->access_code = $accessToken;
				
				/* Mail Format */
				$siteName   = Config::getField('sitename',true);
				$AdminEmail = User::get_UseremailAddress_byId(1);		
				$UserName	= User::get_user_shotInfo_byId($row->id);
				$fullName	= $UserName->first_name.' '.$UserName->middle_name.' '.$UserName->last_name; 
				
				$msgbody = '<div>
				<h3>Reset password on '.$siteName.'</h3>				
				<div><font face="Trebuchet MS">Dear '.$fullName.' !</font> <br /><br><br>
				Please <a href="'.ADMIN_URL.'resetpassword-'.$accessToken.'">click here to reset your password.</a> <br><br>
				If you didn\'t request your password then delete this email.  <br>
				<br><br>
				<p>Thanks,
				<br> Webmaster<br>
				'.$siteName.'
				</p>
				</div>
				</div>';
				  
				 $mail = new PHPMailer();	
				
				 $mail->SetFrom($AdminEmail,$siteName);				 
				 $mail->AddReplyTo($forgetRec->email,$fullName);
				 $mail->AddAddress($forgetRec->email,$fullName);		  
				 $mail->Subject    = "Forgot password on ".$siteName;	
				 $mail->MsgHTML($msgbody);
				
				if(!$mail->Send()):
					echo json_encode(array('action'=>'unsuccess','message'=>'Not valid User email address'));
				else:
					$forgetRec->save();
					echo json_encode(array('action'=>'success','message'=>'Please check your mail for reset passord'));
				endif;				
			else:
				echo json_encode(array('action'=>'unsuccess','message'=>'Not valid User email address'));
			endif;
		break;
		
		case "resetuser_password":
			$id = addslashes($_REQUEST['userId']);
			$record = User::find_by_id($id);
			$record->password = md5($_REQUEST['password']);
			$record->access_code = randomKeys(10);
			if($record->save()):
				echo json_encode(array('action'=>'success','message'=>'Password has been changed, please login!'));
			else:
				echo json_encode(array('action'=>'unsuccess','message'=>'Internal error.'));
			endif;
		break;
	}
?>
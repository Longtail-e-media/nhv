<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');

	$usermail = User::field_by_id('1', 'email');
	$sitename = Config::getField('sitename',true);
	$bccmail = User::field_by_id('1','optional_email');
	
	$action = $_REQUEST['action'];
	
	switch($action) 
	{			
		case 'register':
			$record = new Member();

			foreach($_POST as $key=>$val){$$key=$val;}
			$record->first_name 	= $first_name;
			$record->middle_name 	= $middle_name;
			$record->last_name 		= $last_name;
			$record->gender 		= $gender;
			$record->dob 			= $dob;
			$record->mailaddress 	= $mailaddress;
			$record->phoneno 		= $phoneno;
			$record->current_address = $current_address;
	
			$record->status 	 	= 1;
			$record->sortorder		= Member::find_maximum();
			$record->added_date 	= registered();

			/*
			* Main mail info
			*/
			$fullname = $first_name.' '.$middle_name.' '.$last_name;
			$body='<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
	  			<tr><td><p>Dear Sir,</p></td></tr>
		  		<tr>
				<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Member Register Request</span><br />The details provided are :</p>
				  	<p><strong>Fullname</strong> : '.$fullname.'<br />				
		  			<strong>E-mail Address</strong>: '.$mailaddress.'<br />
			 		<strong>Contact No.</strong> : '.$phoneno.'<br />
			 		<strong>Professional Information</strong> <br />
			 		
		  		</tr>
		  		<tr>
					<td><p>&nbsp;</p><p>Thank you,<br />'.$fullname.'</p></td>
		  		</tr>
			</table>';

			$mail = SMTPMailer();
			$mail->SetFrom($mailaddress, $fullname);
			$mail->AddReplyTo($mailaddress, $fullname);
			$mail->AddAddress($usermail, $sitename);
			$recs = explode(';', $bccmail);
			foreach($recs as $k=>$v){ if(!empty($v)){ $mail->AddBCC($v, $sitename);} }
			$mail->Subject    = "Member Register Request Mail";		
			$mail->MsgHTML($body);

			/*
			* Reply mail info
			*/
			$rplybody='<table width="100%" border="0"  style=" ">
				<tr><td><p>Hello '.$fullname.',</p></td></tr>
				<tr><td><p>Thank you for the register request ! You will get the account activation email soon.</p></td></tr>
				<tr>
					<td><p>&nbsp;</p>
					<p>Thanking you,<br />
					'.$sitename.'
					</p></td>
				</tr>
			</table>';

			$rplymail = SMTPMailer();

			$rplymail->SetFrom($usermail, $sitename);
			$rplymail->AddReplyTo($usermail, $sitename);
			$rplymail->AddAddress($mailaddress, $fullname);				
			$rplymail->Subject    = "no-reply ".$sitename;				
			$rplymail->MsgHTML($rplybody);

			if(!$mail->Send()) { 
				$message='<div class="alert alert-danger fade in alert-dismissable col-sm-12">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> Sorry! could not send your request.
                </div>';
				echo json_encode(array("action"=>"success", "message"=>$message));
			}
			else {
				$rplymail->Send();
				$db->begin();
					$record->save();
				$db->commit();

				$message='<div class="alert alert-success fade in alert-dismissable col-sm-12">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>success!</strong> Thank you for the request Messageing ! You will get the confirmation email soon.
                </div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}

			break;

		case 'profile':
			foreach($_POST as $key=>$val){$$key=$val;}
			$token = unserialize(base64_decode(strtr(addslashes($_token), '-_', '+/')));
			$record = Member::find_by_id($token['login_id']);

			if($record->mailaddress!=$mailaddress){
				$chk = Member::checkDupliEmail($mailaddress);
				if($chk=='1') {
					$message='<div class="col-sm-2">&nbsp;</div>
	                <div class="alert alert-warning fade in alert-dismissable col-sm-10">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Warning!</strong> Email Address already exists.
	                </div>';
					echo json_encode(array("action"=>"success", "message"=>$message));	
					exit;		
				}
			}
			
			$record->first_name 	= $first_name;
			$record->middle_name 	= $middle_name;
			$record->last_name 		= $last_name;
			$record->gender 		= $gender;
			$record->dob 			= $dob;
			$record->mailaddress 	= $mailaddress;
			$record->phoneno 		= $phoneno;
			$record->current_address = $current_address;
			
		
			$db->begin();
			if($record->save()) { $db->commit();
			   	$message='<div class="col-sm-2">&nbsp;</div>
                <div class="alert alert-success fade in alert-dismissable col-sm-10">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>success!</strong> Successfully save request data.
                </div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}
			else {
				$message='<div class="col-sm-2">&nbsp;</div>
                <div class="alert alert-danger fade in alert-dismissable col-sm-10">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> request data not save.
                </div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}


			break;

		case "add":	
			$record = new Member();

			foreach($_POST as $key=>$val){$$key=$val;}
			if(!empty($mailaddress)) {
				$chk = Member::checkDupliEmail($mailaddress);
				if($chk=='1') {
					echo "Member Email address Already Exists.";	
					exit;		
				}
			}
			
			$record->first_name 	= $first_name;
			$record->middle_name 	= $middle_name;
			$record->last_name 		= $last_name;
			$record->gender 		= $gender;
			$record->dob 			= $dob;
			$record->mailaddress 	= $mailaddress;
			$record->phoneno 		= $phoneno;
			$record->current_address = $current_address;
			
			$record->status		= $status;
			$record->sortorder	= Member::find_maximum();
			$record->added_date = registered();
			
			$db->begin();
			if($record->save()) { $db->commit();
				$fullname = $first_name.' '.$middle_name.' '.$last_name;
				$message  = sprintf($GLOBALS['basic']['addedSuccess'], "Member '".$fullname."'");
				echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Member [".$fullname."]".$GLOBALS['basic']['addedSuccess'],1,3);
			}
			else {
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			}
			break;
							
		case "edit":
			$record = Member::find_by_id($_REQUEST['idValue']);

			if($record->mailaddress!=$_REQUEST['mailaddress']) {
				$chk=Member::checkDupliEmail($_REQUEST['mailaddress']);
				if($chk=='1') {
					echo "Member Email address Already Exists.";		
					exit;		
				}
			}
			
			$record->first_name 	= $_REQUEST['first_name'];
			$record->middle_name 	= $_REQUEST['middle_name'];
			$record->last_name 		= $_REQUEST['last_name'];
			$record->gender 		= $_REQUEST['gender'];
			$record->dob 			= $_REQUEST['dob'];
			$record->mailaddress 	= $_REQUEST['mailaddress'];
			$record->phoneno 		= $_REQUEST['phoneno'];
			$record->current_address = $_REQUEST['current_address'];
			

			if(!empty($_REQUEST['password'])){
				$record->pass_text	= md5(md5($_REQUEST['password']));
			}

			$db->begin();
			if($record->save()) { $db->commit();
				$fullname = $_REQUEST['first_name'].' '.$_REQUEST['middle_name'].' '.$_REQUEST['last_name'];
			   	$message  = sprintf($GLOBALS['basic']['changesSaved'], "Member '".$fullname."'");
			   	echo json_encode(array("action"=>"success","message"=>$message));
			   	log_action("Member [".$fullname."] Edit Successfully",1,4);
			}
			else {
				echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			}
			break;
			
		case "delete":
			$id = addslashes($_REQUEST['id']);
			$record = Member::find_by_id($id);
			$db->query("DELETE FROM tbl_member WHERE id='{$id}'");
			
			reOrder("tbl_member", "sortorder");

			$fullname = $record->first_name.' '.$record->middle_name.' '.$record->last_name;
			$message  = sprintf($GLOBALS['basic']['deletedSuccess'], "Member '".$fullname."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Member  [".$fullname."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			break;

		case 'toggleApproved':
			$id = $_REQUEST['id'];
			$record = Member::find_by_id($id);		

			if($record->login_status!='1') {

				$new_pass = @randomKeys(5);
				$record->login_status	= 1;
				$record->user_text 		= $record->mailaddress;
				$record->pass_text 		= md5(md5($new_pass));

				/*
				* Main mail info
				*/
				$fullname = $record->first_name.' '.$record->middle_name.' '.$record->last_name;
				$body='<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
		  			<tr><td><p>Dear '.$fullname.',</p></td></tr>
			  		<tr>
					<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Your Request has been approved by '.$sitename.'</span><br />The login details provided are :</p>
					  	<p><strong>Username</strong> : '.$record->user_text.'<br />				
			  			<strong>Password</strong>: '.$new_pass.'<br />
				 		<strong>Link</strong>: '.BASE_URL.'member/login</p></td>
			  		</tr>
			  		<tr>
						<td><p>&nbsp;</p><p>Thank you,<br />'.$sitename.'</p></td>
			  		</tr>
				</table>';

				$mail = SMTPMailer();
				$mail->SetFrom($usermail, $sitename);
				$mail->AddReplyTo($usermail, $sitename);
				$mail->AddAddress($record->mailaddress, $fullname);
				$mail->Subject    = "Request Approved From ".$sitename;		
				$mail->MsgHTML($body);

				if(!$mail->Send()) { $message = "Sorry! could not send your request."; 
					echo json_encode(array("action"=>"error","message"=>$message));	
				}
				else {
					$db->begin();
						$record->save();
					$db->commit();
					$message = "Member ".$fullname." has been approved and sent approve mail. (Password : $new_pass)";
					echo json_encode(array("action"=>"success","message"=>$message));	
				}

			}
			else {
				$message = "Member ".$record->first_name." already approved. "; 
				echo json_encode(array("action"=>"warning","message"=>$message));	
			}
			
			break;
		
		// Module Setting Sections  >> <<
		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Member::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
			break;

		// Front loging section
		case 'login':
			$uname = addslashes($_POST['login_user']);
			$upass = addslashes($_POST['login_pass']);

			$recRow = Member::get_login_access($uname, md5(md5($upass)));
			if(!empty($recRow)) {
				// echo '<pre>';
				// print_r($recRow);

				if($recRow->status=='1' AND $recRow->login_status!='1') {
					$message='<div class="col-sm-4">&nbsp;</div>
	                <div class="alert alert-warning fade in alert-dismissable col-sm-4">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Warning!</strong> Your account not approved yet.
	                </div>
	                <div class="col-sm-4">&nbsp;</div>';
					echo json_encode(array("act"=>"error", "message"=>$message)); 
					exit;
				}

				if($recRow->status!='1' AND $recRow->login_status=='1') {
					$message='<div class="col-sm-4">&nbsp;</div>
	                <div class="alert alert-warning fade in alert-dismissable col-sm-4">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Warning!</strong> Your account has been blocked.
	                </div>
	                <div class="col-sm-4">&nbsp;</div>';
					echo json_encode(array("act"=>"error", "message"=>$message)); 
					exit;
				}

				if($recRow->status=='1' AND $recRow->login_status=='1') {
					@session_start();
					$new_session->start();
					$fullname = $recRow->first_name.' '.$recRow->middle_name.' '.$recRow->last_name;
					$token = serialize(array('login_id'=>$recRow->id, 'login_user'=>$fullname, 'login_email'=>$recRow->mailaddress));
					$new_session->set('_token', strtr(base64_encode($token), '+/', '-_'));
					$_SESSION["_token"] = strtr(base64_encode($token), '+/', '-_');

					$message='<div class="col-sm-4">&nbsp;</div>
	                <div class="alert alert-success fade in alert-dismissable col-sm-4">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Success!</strong> Redirecting please wait...
	                </div>
	                <div class="col-sm-4">&nbsp;</div>';
					echo json_encode(array("act"=>"success", "url"=>BASE_URL.'member/dashboard', "message"=>$message));
					exit; die();
				}

			}
			else {
				$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-danger fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> Invalid username/password.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("act"=>"error", "message"=>$message)); 
			}

			break;
					
		case 'reset':
			foreach($_POST as $key=>$val){$$key=$val;}
			$token = unserialize(base64_decode(strtr(addslashes($_token), '-_', '+/')));
			$record = Member::find_by_id($token['login_id']);

			$chk = Member::checkOldpass($record->id, md5(md5($old_pass)));
			if($chk!='1') {
				$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-warning fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Warning!</strong> Old password not match.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;		
			}

			$record->pass_text = md5(md5($new_pass));

			$db->begin();
			if($record->save()) { $db->commit();
			   	$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-success fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>success!</strong> Successfully save request data.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}
			else {
				$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-danger fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> request data not save.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}

			break;	

		case 'resetpass':
			foreach($_POST as $key=>$val){$$key=$val;}
			$record = Member::find_by_passtoken($_token);
			
			$record->pass_text = md5(md5($new_reset_pass));
			$record->reset_token 	= '';

			$db->begin();
			if($record->save()) { $db->commit();
			   	$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-success fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>success!</strong> Successfully save request data.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("act"=>"success", "url"=>BASE_URL.'member/login', "message"=>$message));	
				exit;	
			}
			else {
				$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-danger fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> request data not save.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("act"=>"error", "message"=>$message));	
				exit;	
			}

			break;

		case 'forget':
			$mail = addslashes($_POST['forget_mail']);
			$recRow = Member::get_forget_pass($mail);
			if(!empty($recRow)) {
				// echo '<pre>';
				// print_r($recRow);

				if($recRow->status=='1' AND $recRow->login_status!='1') {
					$message='<div class="col-sm-4">&nbsp;</div>
	                <div class="alert alert-warning fade in alert-dismissable col-sm-4">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Warning!</strong> Your account not approved yet.
	                </div>
	                <div class="col-sm-4">&nbsp;</div>';
					echo json_encode(array("act"=>"error", "message"=>$message)); 
					exit;
				}

				if($recRow->status!='1' AND $recRow->login_status=='1') {
					$message='<div class="col-sm-4">&nbsp;</div>
	                <div class="alert alert-warning fade in alert-dismissable col-sm-4">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Warning!</strong> Your account has been blocked.
	                </div>
	                <div class="col-sm-4">&nbsp;</div>';
					echo json_encode(array("act"=>"error", "message"=>$message)); 
					exit;
				}

				if($recRow->status=='1' AND $recRow->login_status=='1') {
					
					$_token = @randomKeys(15);
					$recRow->reset_token = $_token;

					/*
					* Main mail info
					*/
					$fullname = $recRow->first_name.' '.$recRow->middle_name.' '.$recRow->last_name;
					$body='<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
			  			<tr><td><p>Dear '.$fullname.',</p></td></tr>
				  		<tr>
						<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Your Request has been approved by '.$sitename.'</span><br />Click below link for reset your password. :</p>
						  	<p><strong>Link</strong>: <a href="'.BASE_URL.'member/reset-pass/'.$_token.'" target="_blank">'.BASE_URL.'member/reset-pass/'.$_token.'</a></p></td>
				  		</tr>
				  		<tr>
							<td><p>&nbsp;</p><p>Thank you,<br />'.$sitename.'</p></td>
				  		</tr>
					</table>';

					$mail = SMTPMailer();
					$mail->SetFrom($usermail, $sitename);
					$mail->AddReplyTo($usermail, $sitename);
					$mail->AddAddress($recRow->mailaddress, $fullname);
					$mail->Subject    = "Password Reset Link From ".$sitename;		
					$mail->MsgHTML($body);

					if(!$mail->Send()) {
						$message='<div class="col-sm-4">&nbsp;</div>
		                <div class="alert alert-danger fade in alert-dismissable col-sm-4">
		                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		                    <strong>Error!</strong> Your request not sent. Please try again.
		                </div>
		                <div class="col-sm-4">&nbsp;</div>';
						echo json_encode(array("act"=>"error", "message"=>$message));
						exit;
					}
					else {			
						$recRow->save();
						$message='<div class="col-sm-4">&nbsp;</div>
		                <div class="alert alert-success fade in alert-dismissable col-sm-4">
		                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
		                    <strong>Success!</strong> Your request has been update. please check your mail for reset password.
		                </div>
		                <div class="col-sm-4">&nbsp;</div>';
						echo json_encode(array("act"=>"success", "url"=>BASE_URL.'member/login', "message"=>$message));
						exit;
					}
				}


			}
			else {
				$message='<div class="col-sm-4">&nbsp;</div>
                <div class="alert alert-danger fade in alert-dismissable col-sm-4">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error!</strong> request email address not found.
                </div>
                <div class="col-sm-4">&nbsp;</div>';
				echo json_encode(array("action"=>"success", "message"=>$message));	
				exit;	
			}
			break;

		case 'activity':
			foreach($_POST as $key=>$val){$$key=$val;}
			$token = unserialize(base64_decode(strtr(addslashes($_token), '-_', '+/')));
			$record = Member::find_by_id($token['login_id']);
			if(!empty($record)) {
				/*
				* Main mail info
				*/
				$fullname = $record->first_name.' '.$record->middle_name.' '.$record->last_name;
				$imgLink = !empty($uploadimg)? BASE_URL.'attachmail/'.$uploadimg:'N/A';
				$body='<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
		  			<tr><td><p>Dear Sir,</p></td></tr>
			  		<tr>
					<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Member Activity Request</span><br />The details provided are :</p>
					  	<p><strong>Member Name</strong> : '.$fullname.'<br />	
				 		<strong>Contact No.</strong> : '.$record->phoneno.'</p></td>
			  		</tr>
			  		<tr>
			  			<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Activity Detail</span></p>
			  				<p><strong>Title</strong> : '.$activity_title.'<br />	
				 			<strong>Content</strong> : '.htmlentities($activity_content).'<br />
				 			<p><strong>Image Link</strong> : '.$imgLink.'</p></td>
			  		</tr>
			  		<tr>
						<td><p>&nbsp;</p><p>Thank you,<br />'.$fullname.'</p></td>
			  		</tr>
				</table>';

				$mail = SMTPMailer();
				$mail->SetFrom($record->mailaddress, $fullname);
				$mail->AddReplyTo($record->mailaddress, $fullname);
				$mail->AddAddress($usermail, $sitename);
				$recs = explode(';', $bccmail);
				foreach($recs as $k=>$v){ if(!empty($v)){ $mail->AddBCC($v, $sitename);} }
				$mail->Subject    = "Member Activity Request Mail";		
				$mail->MsgHTML($body);

				/*
				* Reply mail info
				*/
				$rplybody='<table width="100%" border="0"  style=" ">
					<tr><td><p>Hello '.$fullname.',</p></td></tr>
					<tr><td><p>Thank you for the activity request ! You will get inform when published activity.</p></td></tr>
					<tr>
						<td><p>&nbsp;</p>
						<p>Thanking you,<br />
						'.$sitename.'
						</p></td>
					</tr>
				</table>';

				$rplymail = SMTPMailer();

				$rplymail->SetFrom($usermail, $sitename);
				$rplymail->AddReplyTo($usermail, $sitename);
				$rplymail->AddAddress($record->mailaddress, $fullname);				
				$rplymail->Subject    = "no-reply ".$sitename;				
				$rplymail->MsgHTML($rplybody);

				if(!$mail->Send()) { 
					$message='<div class="alert alert-danger fade in alert-dismissable col-sm-12">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>Error!</strong> Sorry! could not send your request.
	                </div>';
					echo json_encode(array("action"=>"success", "message"=>$message));
				}
				else {
					$rplymail->Send();
					$message='<div class="alert alert-success fade in alert-dismissable col-sm-12">
	                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
	                    <strong>success!</strong> Thank you for the request Messageing ! You will get the confirmation email soon.
	                </div>';
					echo json_encode(array("action"=>"success", "message"=>$message));	
					exit;	
				}
			}
			break;
		
	}
?>
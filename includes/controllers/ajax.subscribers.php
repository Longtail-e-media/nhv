<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');

	$adminmail = User::get_UseremailAddress_byId(1);
	$sitename  = Config::getField('sitename',true);
	
	$action = $_REQUEST['action'];
	
	switch($action) 
	{						
		case "addsubscribers":			
			foreach ($_REQUEST as $key=>$val){$$key=$val;}
			$record = new Subscribers();	

			$record->title			= $fullname;
			$record->mailaddress	= $mailaddress;	
			$record->status 		= 1;			
			$record->sortorder		= Subscribers::find_maximum();
			$record->added_date		= registered();

			// sending mail							
			$mail = new PHPMailer();					

			$body ='<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>Fullname : </td>
							<td>'.$fullname.'</td>
						</tr>
						<tr>
							<td>Email Address : </td>
							<td>'.$mailaddress.'</td>
						</tr>
					</table>';  
	
			// member register mail receive
			$mail->SetFrom($mailaddress, $fullname);
			$mail->AddReplyTo($mailaddress,$fullname);
			$mail->AddAddress($adminmail, $sitename);
			$mail->Subject    = "Newsletter Subscriber Details";
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
			$mail->MsgHTML($body);
			
			if(!$mail->Send()){
				echo json_encode(array("action"=>"success","message"=>"We could not sent your request at the time. Please try again later.."));
			}else{
				$chkRec = Subscribers::checkDupliEmail($mailaddress);	
				if(empty($chkRec)): $record->save(); endif;				
				echo json_encode(array("action"=>"success","message"=>"Your registration request has been received successfully. You will get a confirmation mail very soon."));
			}		
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Subscribers::find_by_id($id);
			log_action("Subscribers  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->query("DELETE FROM tbl_subscribers WHERE id='{$id}'");
			
			reOrder("tbl_subscribers", "sortorder");			
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Subscribers '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Subscribers  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;		

		case "getMailaddress":
			$fullname = addslashes($_REQUEST['fullname']);
			$mail = addslashes($_REQUEST['email_address']);
			
			$record = new Subscribers();
			$record->title		   = $fullname;
			$record->email_address = $mail;

			$checkDupliEmail = Subscribers::checkDupliEmail($mail);			
			if($checkDupliEmail):
				echo json_encode(array("message"=>"Email Address Already Exists !"));		
				exit;		
			endif;

			// For Mail Chimp
			$api = new MCAPI('819718a1f4406cea17991df58b4d2c8f-us3');
			$list_id = "936ee54603";
			$getresult = $api->listSubscribe($list_id, $mail, '');
			
			if($getresult === true):
				$record->save();
				echo json_encode(array("message"=>"Success! Check your email to confirm subscribe.!"));	
			else:
				echo json_encode(array("message"=>"Sorry mail not successfully sent !"));	
			endif;	

		break;
	}
?>
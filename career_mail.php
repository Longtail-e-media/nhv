<?php
require_once("includes/initialize.php");


	$usermail = User::get_UseremailAddress_byId(1);
	$ccusermail = User::field_by_id(1,'optional_email');
	$sitename = Config::getField('sitename',true);
    
	
	foreach($_REQUEST as $key=>$val){$$key=$val;}
	$post_name=Vacency::find_by_id($position);
	$body = '
	<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
	  <tr>
		<td><p>Dear Sir,</p>
		</td>
	  </tr>
	  <tr>
		<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Application for Position '.$post_name->title.'  </span><br />
		  The details provided by the applicant are:</p>
		  <p><strong>Fullname</strong> : '.$fname.'<br />		
		  <strong>E-mail Address</strong>: '.$email.'<br />
		  <strong>Contact No.</strong>: '.$contact.'<br />
		  <strong>Address</strong>: '.$address.'<br />
		 <strong>RESUME</strong>: '.$fileArrayname.'(check at the back end Vacency management)<br/>
		  <strong>Message</strong>: '.$message.'<br />
		 
		  </p>
		</td>
	  </tr>
	  <tr>
		<td><p>&nbsp;</p>
		<p>Thank you,<br />
		'.$fname.'
		</p></td>
	  </tr>
	</table>
	';
	
	$record = new Applicant();			
		$record->fullname 		    = $_REQUEST['fname'];
		$record->current_address 	= $_REQUEST['address'];			
		$record->mobile	 			= $_REQUEST['contact'];
		$record->email 				= $_REQUEST['email'];			
		$record->position				= $_REQUEST['position'];
		$record->myfile				= $_REQUEST['fileArrayname'];
        $record->qualification				= $_REQUEST['message'];
        $record->sortorder				= Applicant::find_maximum();
		
		$db->begin();
		$record->save(); 
		$db->commit();
		
		
	if($_POST['action']=="forcareer"):
	$mail = new PHPMailer(); // defaults to using php "mail()"
	
	$mail->SetFrom($email, $fname);
	$mail->AddReplyTo($email,$fname);
	
	$mail->AddAddress($usermail, $sitename);
	// if add extra email address on back end
	if(!empty($ccusermail)){
		$rec = explode(';', $ccusermail);
		if($rec){
			foreach($rec as $row){
				$mail->AddCC($row,$sitename);
			}		
		}
	}
	
	$mail->Subject    = 'Application mail from '.$fname;
	
	$mail->MsgHTML($body);
	
	if(!$mail->Send()) {
		echo json_encode(array("action"=>"unsuccess","message"=>"We could not sent your request at the time. Please try again later."));
	}else{
		echo json_encode(array("action"=>"success","message"=>"Your request has been successfully received, You will be shortly informed through mail with you verified by admin."));
	}
endif;
?>
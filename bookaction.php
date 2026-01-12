<?php
require_once("includes/initialize.php");

if(isset($_POST['action']) and ($_POST['action']=='forcoment')):
	$usermail = User::field_by_id(1, 'email');
	$sitename = Config::getField('sitename',true);

	foreach($_POST as $key=>$val){$$key=$val;}


	$body ='<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
			  <tr>
				<td><p>Dear Sir/Mam,</p>
				</td>
			  </tr>
			  <tr>
				<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Package Booking message</span><br />
				  The details provided are:</p>
				  	<p>
				  		<strong>Package Name</strong> : '.$tripname.'<br />	
				  		<strong>Date of arrival</strong> : '.$tarri.'<br />	
				  		<strong>Date of Departure</strong> : '.$tdept.'<br />
				  		<strong>No of Adult</strong> : '.$tadult.'<br />		
				  		<strong>No of Adult</strong> : '.$tchildren.'<br />
				  		<strong>Full Name</strong>: '.$tname.'<br />
				  		<strong>Date of birth</strong>: '.$tdob.'<br />
				  		<strong>Profession</strong>: '.$tprofession.'<br />
				  		<strong>Nationality</strong> : '.$tnationality.'<br />
				 		<strong>Home Address</strong> : '.$thomeaddress.'<br />
				 		<strong>City</strong>: '.$tcity.'<br />
				 		<strong>Country</strong>: '.$tcountry.'<br />
				 		<strong>Postal/zip code</strong>: '.$tpostal.'<br />
				 		<strong>Phone No.</strong>: '.$tphone.'<br />
				 		<strong>Mobile No.</strong>: '.$tmobile.'<br />
				 		<strong>Email</strong> : '.$temail.'<br />
				 		<strong>Passport No.</strong> : '.$tpassport.'<br />
				 		<strong>Passport Issue Date</strong>: '.$tpass_issue.'<br />
				 		<strong>Passport Expiry Date</strong>: '.$tpass_expiry.'<br />
				 	
				 		<strong>Other Informations</strong><br /><br />
				 		<strong>Best way to Contact You</strong>: <br />'.$person_ctype.'<br />
				 		<strong>How did you get to know About us? </strong>: <br />'.$person_hear.'<br />
				 		<strong>Question/Comments</strong>: <br />'.$tmess.'<br />
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you,<br />
				'.$tname.'
				</p></td>
			  </tr>
			</table>';

		$mail = SMTPMailer();
		$mail->SetFrom($temail, $tname);
		$mail->AddReplyTo($temail,$tname);
		$mail->AddAddress($usermail, $sitename);
		$bccmail = User::field_by_id('1','optional_email');
		if($bccmail){
			$recs = explode(';',$bccmail);
			foreach($recs as $k=>$v){
				$mail->AddBCC($v, $sitename);
			}
		}
		$mail->Subject    = "Booking Inquiry for ".$tripname;
		
		$mail->MsgHTML($body);
		
		if(!$mail->Send()):
			echo json_encode(array("action"=>"unsuccess","message"=>"<div class='alert alert-danger'>Sorry! could not send your request.</div>"));
		else:
			echo json_encode(array("action"=>"success","message"=>"<div class='alert alert-success succ_mess'>Your request has been successfully received, You will be informed shortly  through mail by admin.</div>"));
		endif;
endif;
?>
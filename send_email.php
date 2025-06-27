<?php if(!empty($bookInfo)) {
	$fullname = $bookInfo->person_title.' '.$bookInfo->person_fname.' '.$bookInfo->person_mname.' '.$bookInfo->person_lname;
	$body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
		<tr>
			<td><p>Dear Sir,</p></td>
		</tr>
		<tr>
			<td>Trip Name : '.Package::field_by_id($bookInfo->pkg_id, 'title').'</td>
		</tr>
		<tr>
			<td>Trip Date : '.$bookInfo->trip_date.'</td>
		</tr>
		<tr>
			<td>Trip Pax. : '.$bookInfo->trip_pax.'</td>
		</tr>
		<tr>
			<td>Trip Amount : '.$bookInfo->trip_currency.' '.$bookInfo->pay_amt.'</td>
		</tr>		
		<tr>
			<td><p>The details provided are:</p>
				<p>
					<strong>IP Address </strong> : '.$bookInfo->ip_address.'<br />
					<strong>Transaction Code</strong> : '.$bookInfo->accesskey.'<br />    
					<strong>Full Name</strong>: '.$fullname.'<br />
					<strong>Phone Number</strong> : '.$bookInfo->person_phone.'<br />
					<strong>Email Address</strong>: '.$bookInfo->person_email.'<br />
					<strong>Home Address</strong> : '.$bookInfo->person_address.'<br />
					<strong>Country</strong>: '.$bookInfo->person_country.'
				</p>
			</td>
		</tr>
		<tr>
			<td><p>&nbsp;</p>
			<p>Thanking you,<br />
			'.$fullname.'
			</p></td>
		</tr>
	</table>';

	/*
	* mail info
	*/

	$mail = new PHPMailer(); // defaults to using php "mail()"  
	$mail->SetFrom($bookInfo->person_email, $fullname);
	$mail->AddReplyTo($bookInfo->person_email,$fullname);
	$mail->AddAddress($usermail, $sitename);
	// if add extra email address on back end
	if(!empty($ccusermail)){
		$rec = explode(';', $ccusermail);
		if(!empty($rec)) {
			foreach($rec as $opt_row) {
				$mail->AddCC($opt_row, $sitename);
			}   
		}
	}
	$mail->Subject  = "Booking Inquiry from ".$fullname;
	$mail->MsgHTML($body);
	@$mail->Send();

	/*
	* Reply mail info
	*/
	$rplybody='<table width="100%" border="0"  style=" ">
		<tr>
			<td><p>Hello '.$fullname.',</p></td>
		</tr>
		<tr>
			<td><p>The details you provided are Sucessfully Received. </p></td>
		</tr>
		<tr>
			<td><p>&nbsp;</p>
			<p>Thanking you,<br />
			'.$sitename.'
			</p></td>
		</tr>
	</table>';

	$rplymail = new PHPMailer(); // defaults to using php "mail()"  

	$rplymail->SetFrom($usermail, $sitename);
	$rplymail->AddReplyTo($usermail, $sitename);
	$rplymail->AddAddress($bookInfo->person_email, $fullname);
	$rplymail->Subject    = "no-reply ".$sitename;
	$rplymail->MsgHTML($rplybody);
	@$rplymail->Send();
}
else {
	echo 'Access denied !';
} ?>
<?php
require_once("includes/initialize.php");

if (isset($_POST['action']) and ($_POST['action'] == 'forEnquiry')):
    $usermail = User::field_by_id(1, 'email');
    $ccmail = User::field_by_id('1', 'optional_email');
    $sitename = Config::getField('sitename', true);

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    $body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
			  <tr>
				<td><p>Dear Sir,</p>
				</td>
			  </tr>
			  <tr>
				<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Enquiry message</span><br />
				  The details provided are:</p>
				  	<p><strong>Fullname</strong> : ' . $full_name . '<br />		
                      <strong>E-mail Address</strong>: ' . $email . '<br />
                      <strong>Phone Number</strong>: ' . $phone . '<br />
                      <strong>Country</strong>: ' . $country . '<br />
                      <strong>City</strong>: ' . $city . '<br /><br />
                      
                      <strong>Trip Name</strong>: ' . $trip_name . '<br />
                      <strong>Trip Date</strong>: ' . $trip_date . '<br />
                      <strong>No. of Pax</strong>: ' . $pax . '<br /><br />
                      
                      <strong>Message</strong>: ' . $message . '
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you,<br />
				' . $full_name . '
				</p></td>
			  </tr>
			</table>';

    $mail = new PHPMailer(); // defaults to using php "mail()"
    $mail->SetFrom($email, $full_name);
    $mail->AddReplyTo($email, $full_name);
    $mail->AddAddress($usermail, $sitename);

    if ($ccmail) {
        $recs = explode(';', $ccmail);
        foreach ($recs as $k => $v) {
            $mail->AddCC($v, $sitename);
        }
    }
    $mail->Subject = "Enquiry from " . $full_name . " for " . $trip_name;

    $mail->MsgHTML($body);

    if (!$mail->Send()):
        echo json_encode(array("action" => "unsuccess", "message" => "Sorry! could not send your message."));
    else:
        echo json_encode(array("action" => "success", "message" => "Your message has been successfully received."));
    endif;
endif;
?>
<?php
require_once("includes/initialize.php");

if (isset($_POST['action']) and ($_POST['action'] == 'forcoment')):
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
				  	<p>
				  		<strong>Full Name</strong> : ' . $name . '<br />	
				  		<strong>Email Address</strong> : ' . $email . '<br />	
				 		<strong>Message</strong>: <br />' . $message . '<br />
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you,<br />
				' . $name . '
				</p></td>
			  </tr>
			</table>';

    $mail = new PHPMailer(); // defaults to using php "mail()"
    $mail->SetFrom($email, $name);
    $mail->AddReplyTo($email, $name);
    $mail->AddAddress($usermail, $sitename);

    if ($ccmail) {
        $recs = explode(';', $ccmail);
        foreach ($recs as $k => $v) {
            $mail->AddCC($v, $sitename);
        }
    }
    $mail->Subject = "Enquiry from " . $name;

    $mail->MsgHTML($body);

    if (!$mail->Send()):
        echo json_encode(array("action" => "unsuccess", "message" => "Sorry! could not send your message."));
    else:
        echo json_encode(array("action" => "success", "message" => "Your message has been successfully received."));
    endif;
endif;
?>
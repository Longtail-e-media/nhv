<?php
require_once("includes/initialize.php");

if (isset($_POST['action']) and ($_POST['action'] == 'forfriendmail')):
    $usermail = User::field_by_id(1, 'email');
    $sitename = Config::getField('sitename', true);

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }
    $packageRec = Package::find_by_id($package_id);
    $body = '<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
			  <tr>
				<td><p>Dear Sir,</p>
				</td>
			  </tr>
			  <tr>
				<td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Best Package for your travel</span><br />
				  The details provided are:</p>
				  	<p>
				 		<strong>URL</strong>: <br />' . BASE_URL . 'package/' . $packageRec->slug . '<br />
				 		<strong>Message</strong>: <br />' . $message . '<br />
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you<br />
				</p></td>
			  </tr>
			</table>';

    $mail = SMTPMailer();
    $mail->SetFrom($usermail, $sitename);
    $mail->AddReplyTo($usermail, $sitename);
    $mail->AddAddress($primary_email);

    if (!empty($cc_emails)) {
        $ccmail = explode(",", $cc_emails);
        if ($ccmail) {
            $recs = $ccmail;
            foreach ($recs as $k => $v) {
                $mail->AddCC($v);
            }
        }
    }
    $mail->Subject = "Best Package for your travel";

    $mail->MsgHTML($body);

    if (!$mail->Send()):
        echo json_encode(array("action" => "unsuccess", "message" => "Sorry! could not send your message."));
    else:
        echo json_encode(array("action" => "success", "message" => "Your Package has been shared."));
    endif;
endif;
?>
<?php
require_once("includes/initialize.php");

if ($_POST['action'] == "forCustomize"):

    $usermail = User::get_UseremailAddress_byId(1);
    $ccusermail = User::field_by_id(1, 'optional_email');
    $sitename = Config::getField('sitename', true);

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    $sql = "INSERT INTO tbl_customize_trip (name, trip, trip_date, pax, email, phone, address, country, message)
            VALUES ('" . $full_name . "', 
                    '" . $trip . "', 
                    '" . $trip_date . "', 
                    '" . $pax . "', 
                    '" . $email . "', 
                    '" . $phone . "',
                    '" . $address . "',
                    '" . $country . "',
                    '" . $message . "')";
    $res = $db->query($sql);

    if ($res) {
        $body = '
            <table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
              <tr>
                <td><p>Dear Sir,</p>
                </td>
              </tr>
              <tr>
                <td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Customized Trip message</span><br />
                    The details provided are:</p>
                    
                  <p><strong>Fullname</strong> : ' . $full_name . '<br />		
                  <strong>E-mail Address</strong>: ' . $email . '<br />
                  <strong>Whatsapp</strong>: ' . $phone . '<br />
                  <strong>Country</strong>: ' . $country . '<br />
                  <strong>Address</strong>: ' . $address . '<br /><br />
                  
                  <strong>Trip Name</strong>: ' . $trip . '<br />
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
            </table>
            ';

        /*
        * mail info
        */

        $mail = new PHPMailer(); // defaults to using php "mail()"

        $mail->SetFrom($email, $full_name);
        $mail->AddReplyTo($email, $full_name);

        $mail->AddAddress($usermail, $sitename);
        // if add extra email address on back end
        if (!empty($ccusermail)) {
            $rec = explode(';', $ccusermail);
            if ($rec) {
                foreach ($rec as $row) {
                    $mail->AddCC($row, $sitename);
                }
            }
        }

        $mail->Subject = 'Customize mail from ' . $full_name;

        $mail->MsgHTML($body);

        if (!$mail->Send()) {
            echo json_encode(array("action" => "unsuccess", "message" => "We could not sent your request at the time. Please try again later."));
        } else {
            echo json_encode(array("action" => "success", "message" => "Your request has been successfully received, You will be shortly informed through mail once verified by admin."));
        }
    }

endif;
?>
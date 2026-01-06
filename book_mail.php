<?php

$usermail = User::get_UseremailAddress_byId(1);
//$ccusermail = User::field_by_id(1,'optional_email');
$sitename = Config::getField('sitename', true);
$pkgRec = Package::find_by_id($pkg_id);

$body = '
	<table width="100%" border="0" cellpadding="0" style="font:12px Arial, serif;color:#222;">
        <tr>
            <td><p>Dear Sir,</p>
            </td>
        </tr>
        <tr>
            <td><p><span style="color:#0065B3; font-size:14px; font-weight:bold">Booking message</span><br/>
                The details provided are:</p>
                <p>
                    <strong>Fullname</strong> : ' . $full_name . '<br/>
                    <strong>E-mail Address</strong>: ' . $email . '<br/>
                    <strong>Whatsapp</strong> : ' . $phone . '<br/>
                    <strong>Address</strong> : ' . $address1 . ' / ' . $address2 . '<br/>
                    <strong>Country</strong> : ' . $country . '<br/>';
if (!empty($zipcode)) {
    $body .= '    <strong>Zip Code</strong> : ' . $zipcode . '<br/>';
}
if (!empty($province)) {
    $body .= '    <strong>Province(City)</strong> : ' . $province . '<br/>';
}
if (!empty($state)) {
    $body .= '    <strong>State(Town)</strong> : ' . $state . '<br/>';
}
// $pax = $pax + 1;
if (!empty($pax) && $pax !== 'undefined') {
    $body .= '         <strong>Pax</strong> : ' . $pax . '<br/>';
}
if (!empty($fixed_date_id)) {
    $body .= '    <!--<br><strong>Fixed Departure Id</strong> : ' . $fixed_date_id . '<br/>-->
                    <strong>Fixed Departure Date</strong> : ' . $date . '<br/><br>';
} else {
    $body .= '      <strong>Trip Date</strong> : ' . $date . '<br/>';
}
$body .= '
                    <strong>Message</strong>: ' . str_replace('\'', '', $message) . '<br/>
                </p>
            </td>
        </tr>';
if (!empty($additional_name[0])) {
    $body .= '<tr>
                <p><strong>Additional Travellers Information</strong></p>
                <p>
                    <table border="1" style="font:12px Arial, serif;color:#222; border: 1px solid #222; text-align: center; width: 60%;">
                        <tr>
                            <th style="height:20px;">Full Name</th>
                            <th style="height:20px;">Number</th>
                            <th style="height:20px;">Address</th>
                        </tr>
            ';
    $length = sizeof($additional_name);
    for ($i = 0; $i < $length; $i++) {
        $body .= '
            <tr>
                <td style="height:20px;">' . $additional_name[$i] . '</td>
                <td style="height:20px;">' . $additional_phone[$i] . '</td>
                <td style="height:20px;">' . $additional_address[$i] . '</td>
            </tr>
        ';
    }
    $body .= '    </table>
                </p>
            </tr>';
}
$body .= '<tr>
            <td><p>&nbsp;</p>
                <p>Thank you,<br/>
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
$mail->Subject = 'Booking mail from ' . $full_name . ' for ' . $pkgRec->title;
$mail->MsgHTML($body);
$mail->Send();
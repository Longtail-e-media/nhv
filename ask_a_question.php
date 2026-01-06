<?php
require_once("includes/initialize.php");

if(isset($_POST['action']) and ($_POST['action']=='forQuestion')):
    $usermail = User::field_by_id(1, 'email');
    $ccmail  = User::field_by_id('1','optional_email');
    $sitename = Config::getField('sitename',true);

    foreach($_POST as $key=>$val){$$key=$val;}

    $body ='<table width="100%" border="0" cellpadding="0" style="font:14px Arial, serif;color:#222;">
			  <tr>
				<td><p>Dear Sir,</p>
				</td>
			  </tr>
			  <tr>
				<td><p><span style="color:#0065B3; font-size:16px; font-weight:bold">Question</span><br />
				  The details provided are:</p>
				  	<p>
				  		<strong>Full Name</strong> : '.$full_name.'<br />	
				  		<strong>Email Address</strong> : '.$email.'<br />	
				 		<strong>Question</strong>: <br />'.$message.'<br />
				  	</p>
				</td>
			  </tr>
			  <tr>
				<td><p>&nbsp;</p>
				<p>Thank you,<br />
				'.$full_name.'
				</p></td>
			  </tr>
			</table>';

    $mail = new PHPMailer(); // defaults to using php "mail()"
    $mail->SetFrom($email, $full_name);
    $mail->AddReplyTo($email,$full_name);
    $mail->AddAddress($usermail, $sitename);

    if($ccmail){
        $recs = explode(';',$ccmail);
        foreach($recs as $k=>$v){
            $mail->AddCC($v, $sitename);
        }
    }
    $mail->Subject    = "Question from ".$full_name." on ".$package_name;

    $mail->MsgHTML($body);

    if(!$mail->Send()):
        echo json_encode(array("action"=>"unsuccess","message"=>"Sorry! could not send your question. Please try again later."));
    else:
        echo json_encode(array("action"=>"success","message"=>"Thank you for your question. We will get back shortly with an answer."));
    endif;
endif;
?>
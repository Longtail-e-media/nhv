<?php
define('HOMEPAGE', 0); // Track homepage.
define('JCMSTYPE', 0); // Track Current site language.

require_once("includes/initialize.php");
$currentTemplate	= Config::getCurrentTemplate('template');
$jVars 				= array();
$template 			= "template/{$currentTemplate}/success.html";

require_once('views/modules.php');

$msg_success = '';
$act_post =  'transaction'; // !empty($_POST['act_post'])?addslashes($_POST['act_post']):'';
switch ($act_post) {

	case 'transaction':
		$order_id = !empty($_REQUEST['order_id'])?addslashes($_REQUEST['order_id']):'amit';
		$row = Bookinginfo::find_by_tranid($order_id);
		if(!empty($row)) {
			$msg_success.='<div class="message-tx">
				<h4 class="text-center">Payment transaction has been successful.</h4>
				<p class="text-center">Transaction short Detail provide below :</p>			
				<p class="text-center"><strong>Order Id :</strong> '.$order_id.'</p>
				<p class="text-center"><strong>Transaction Id :</strong> '.$row->transaction_code.'</p>
				<p><br><br><br></p>
			</div>';
		}
		else { redirect_to(BASE_URL.'home'); }
		break;

	default:
		redirect_to(BASE_URL.'home');

		break;
}
$jVars['module:success-msg'] = $msg_success;

template($template, $jVars, $currentTemplate);
?>
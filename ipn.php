<?php
require_once("includes/initialize.php");
$usermail = User::get_UseremailAddress_byId(1);
$ccusermail = User::field_by_id(1,'optional_email');
$sitename = Config::getField('sitename',true);

define("DEBUG", 1);
// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);
define("LOG_FILE", "ipn.log");
// Read POST data
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
    $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
  $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
  if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
    $value = urlencode(stripslashes($value));
  } else {
    $value = urlencode($value);
  }
  $req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if(USE_SANDBOX == true) {
  $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
  $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
  return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if(DEBUG == true) {
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}

// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
  {
  if(DEBUG == true) { 
    error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
  }
  curl_close($ch);
  exit;
} else {
    // Log the entire HTTP response if debug is switched on.
    if(DEBUG == true) {
      error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
      error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp ($res, "VERIFIED") == 0) {
  // assign posted variables to local variables
  foreach($_POST as $k=>$v){ $$k=$v;}
  $bookInfo = Bookinginfo::find_by_tranid($item_number);  
  global $db;
  $query="UPDATE tbl_bookinginfo SET 
  pay_type         = 'Paypal-".$payment_type."',
  transaction_code = '".$txn_id."',
  pay_by           = '".$payer_email."',
  pay_amt          = '".$payment_gross."',
  confirm_date     = '".registered()."',
  confirm_ip       = '".$_SERVER['REMOTE_ADDR']."',
  status           = '1' 
  WHERE id='$bookInfo->id' ";
  $db->query($query);
  
  // Sent mail
  require_once ('send_email.php');
  
  if(DEBUG == true) {
    error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
  }
  
} else if (strcmp ($res, "INVALID") == 0) {
  // log for manual investigation
  // Add business logic here which deals with invalid IPN messages
  if(DEBUG == true) {
    error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
  }
}
?>
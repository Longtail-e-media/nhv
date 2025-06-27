<?php ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
require_once("includes/initialize.php");
$sitename  = Config::getField('sitename',true);
$ctmplate  = Config::getCurrentTemplate('template');
$logo = Config::getField('logo_upload',true);
$js_path   = BASE_URL."template/{$ctmplate}/js/jquery-1.11.3.min.js";

$paytype = !empty($_REQUEST['paytype'])?addslashes($_REQUEST['paytype']):'';
if(!empty($paytype)) { ?>
<!DOCTYPE html><html><head><title>Payment Transaction</title><script src="<?php echo $js_path;?>"></script></head><body>
    <style>body{margin:0 auto; padding:0px;}</style>
    <div style="margin:0 auto; padding:0px; text-align:center;"><br /><br />
    <img class="retina" alt="logo" src="<?php echo BASE_URL;?>images/preference/<?php echo $logo; ?>" ><br /><br /><br />
    <h2>Transaction Processing..... Please wait.</h2></div>
    <?php // Transaction package
    if($paytype=='package') { 
        foreach($_POST as $key=>$val) { $$key=$val; }
        $ntest = !empty($trans_key)?$trans_key:0;
        $row = Bookinginfo::find_by_token($trans_key); 
        if(!empty($row)) { ?> 
        <!-- <form action="https://www.paypal.com/cgi-bin/webscr" name="frmchkoutpay" method="post" id="frm-paypal"> -->
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" name="frmchkoutpay" method="post" id="frm-paypal">
            <input type="hidden" name="cmd"           value="_xclick">
            <input type="hidden" name="business"      value="amit-facilitator@longtail.info">      
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="item_name"     value="<?php echo Package::field_by_id($row->pkg_id, 'title');?>">
            <input type="hidden" name="item_number"   value="<?php echo $row->accesskey;?>">
            <input type="hidden" name="no_shipping"   value="1">
            <input type="hidden" name="no_note"       value="1">
            <input type="hidden" name="amount"        value="<?php echo ($row->date_rate*$row->trip_pax);?>">
            <input type="hidden" name="return"        value="<?php echo BASE_URL;?>success/<?php echo $row->accesskey;?>">
            <input type="hidden" name="cancel_return" value="<?php echo BASE_URL;?>unsuccess"/>
            <input type="hidden" name="notify_url"    value="<?php echo BASE_URL;?>ipn.php">
            <input type="hidden" name="cpp_header_image" value="<?php echo IMAGE_PATH.'preference/'.$logo;?>" />
        </form>
        <script>document.getElementById('frm-paypal').submit();</script>
    <?php } else { redirect_to(BASE_URL.'unsuccess');} } ?>
</body></html>    
<?php } ?>
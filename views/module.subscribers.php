<?php
$result = '';

$result.='<h3>NEWSLETTER SIGN UP</h3> 
<form class="form_subscribe" action="" role="form" id="newsletterForm" method="post">	    
	<div class="row">
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user-plus"></i>
                </span>
                <input class="form-control" placeholder="Your Name" name="fullname" id="fullname" type="text">
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <input class="form-control" placeholder="Your  Email" name="email_address" id="email_address" >
            </div>
        </div>
        <div class="col-md-2">
            <span class="input-group-btn">
            	<input type="submit" class="btn btn-primary" id="btn-submit" value="SIGN UP" />
            </span>
        </div>
    </div>
</form>
<div id="result-newsletter"></div>';

$jVars["module:subscribe_form"] = $result;

$respopn='';
    $respopn.='<div class="newletter_text">Newsletter<span class="arrow_btn"></span></div>
    <div class="wrapper_content">
        <span>Subscribe to our newsletter and get 5% discount on packages</span><br/>
        <form class="form_subscribepop" action="" role="form" id="newsletterForm" method="post">       
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user-plus"></i>
                        </span>
                        <input class="form-control" placeholder="Your Name" name="fullname" id="fullname" type="text">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        <input class="form-control" placeholder="Your  Email" name="email_address" id="email_address" >
                    </div>
                </div>
                <div class="col-md-2">
                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-primary" id="btn-submit" value="SIGN UP" />
                    </span>
                </div>
            </div>
        </form>
        <div id="result-newsletterpop"></div>
    </div>';
$jVars["module:subscribe_formpop"] = $respopn;
?>
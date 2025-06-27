<?php
/* 
* Module Contact us
*/
$rescntbdc=$rescontct= '';

if(defined('CONTACTUS_PAGE')){

$rescntbdc.='<div class="opacy_bg_02">
     <div class="container">
        <h3>Contact Us</h3>
        <div class="crumbs">
            <ul>
                <li><a href="'.BASE_URL.'home">Home</a></li>
                <li>/</li>
                <li>Contact Us</li>                                         
            </ul>    
        </div>
    </div>  
</div>  
<!-- End Content Parallax-->';
/* End Breadcrumb block */

$rescontct.='
        <section>
        <div class="form form-spac rows">
            <div class="container">
                <!-- TITLE & DESCRIPTION -->
                <!--<div class="spe-title col-md-12">
                    <h2>CHO-OYU TREKKING<span> Contact us</span></h2>
                    <div class="title-line">
                        <div class="tl-1"></div>
                        <div class="tl-2"></div>
                        <div class="tl-3"></div>
                    </div>
                    <p>EXPLORE YOUR DREAMS</p>
                </div>-->
                <div class="col-md-6 col-sm-6 col-xs-12 form_1 wow fadeInLeft" data-wow-duration="1s">
                   
                    <form id="ajaxform" name="home_form" action="" method="post">
                        <ul>
                            <li>
                                <label class="text-black" for="fname">Name</label>
                                <input type="text" name="ename" value="" id="ename">
                            </li>
                            <li>
                                <label class="text-black" for="eemail">Email</label>
                                <input type="email" name="eemail" value="" id="eemail">
                            </li>
                            <li>
                                <label class="text-black" for="emobile">Contact</label>
                                <input type="tel" name="emobile" value="" id="emobile">
                            </li>
                            <li>
                                <label class="text-black" for="emobile">Your Comments</label>
                                <textarea name="emess" cols="40" rows="3" id="text-comment" placeholder="Enter your message"></textarea>
                            </li>
                            <div class="form-group col-md-3">
                        <label for="inputCode4">Human Verification</label>
                        <img src='.BASE_URL.'/captcha/imagebuilder.php?rand=310333 border="1" class="text-field" onclick="updateCaptcha(this);">
                    </div>
                    <div class="form-group col-md-9 pt-4 mt-2">
                        <input type="text" class="form-control" id="inputCode4"
                               placeholder="Type the verification code" name="userstring" maxlength="5">
                    </div>
                            <li>
                                <input type="submit" value="Submit" id="send_button">
                            </li>        
                        </ul>
                    </form>
                </div>
                <!--====== COMMON NOTICE ==========-->
                <div class="col-md-6 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="1s">
                    <div class="rows book_poly">'.$jVars['module:locationinfo'].'</div>
                </div>
            </div>
        </div>
    </section>
               ';
}

$jVars['module:contactus-breadcrumb'] = $rescntbdc;
$jVars['module:contact-form'] = $rescontct;

?>
<?php
/*
*quick search index page....
*/
$qsearch = '';
$qsearch = '
            <form action="' . BASE_URL . 'searchlist" method="POST" id="home_search" name="home_search">
                <div class="from-inner">
                    <div class="row shrink-auto-sm gap-1">
                        <div class="col-12 col-auto">
                            <div class="col-inner">
                                <div class="row cols-1 cols-sm-4 gap-1">
                                    <div class="col">
                                        <div class="col-inner">
                                            <div class="form-group">
                                                <!--<label>Destination</label>-->
                                                <select class="form-control form-control-sm qdestination"
                                                        name="qdestination[]" tabindex="2">
                                                <option value="">Destination <span class="homet" style="font-size:20px;">*</span></option>';
$qsearch .= Destination::get_destination_option();
$qsearch .= '                                   </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="col-inner">
                                            <div class="form-group">
                                                <!--<label>Activities</label>-->
                                                <select class="form-control form-control-sm qactivities"
                                                        name="qactivities[]" tabindex="2">
                                                    <option value="">Activity*</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="col-inner">
                                            <div class="form-group">
                                                <!--<label>Duration</label>-->
                                                <select class="form-control form-control-sm"
                                                        name="days" tabindex="2">
                                                    <option value="">Duration*</option>
                                                    <option value="5" >1-5 Days</option>
                                                    <option value="10" >6-10 Days</option>
                                                    <option value="15" >11-15 Days</option>
                                                    <option value="morethan15" >more than 15 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="col-inner search-home">
                                            <button class="btn btn-primary btn-block home_submit" type="submit" id="submit">
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
            ';
$jVars['module:quickform'] = $qsearch;


/*
* Booking form section for chooyu
*/
$formbook = '';
$slug = !empty($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
$sRec = Package::find_by_slug($slug);
if (!empty($sRec)) {
    $formbook = '<form id="tbook_form" name="tbook_form" action="">
                    <strong>Trip Detail.</strong>
                          <ul>
                            <li>
                                <input type="text" name="tripname" value="' . $sRec->slug . '" id="tripname" placeholder="' . $sRec->slug . '">
                            </li>
                          </ul>
                          <br/>
                          <ul>
                            <li>
                                <input type="text" name="tarri" value="" id="checkin" placeholder="Date of arrival" class="checkin">
                            </li>
                            <li>
                                <input type="text" name="tdept" value="" id="checkout" placeholder="Date of departure" class="checkout">
                            </li>
                            <li>
                                <input type="number" name="tadult" value="" id="tadult" placeholder="No Adults">
                            </li>

                            <li>
                                <input type="number" name="tchildren" value="" id="tchildren" placeholder="No Childrens">
                            </li>
                            </ul>

                           <strong> Personal detail.</strong>
                            <ul>
                            <li>
                                <input type="text" name="tname" value="" id="tname" placeholder="Name">
                            </li>
                            <li>
                                <input type="date" name="tdob" value="" id="tdob" placeholder="Date of Birth">
                            </li>
                            <li>
                                <input type="text" name="tprofession" value="" id="tprofession" placeholder="Profession">
                            </li>
                            <li>
                                <input type="text" name="tnationality" value="" id="tnationality" placeholder="Nationality">
                            </li>
                            <li>
                                <input type="text" name="thomeaddress" value="" id="thomeaddress" placeholder="Home Address">
                            </li>
                             <li>
                                <input type="text" name="tcity" value="" id="tcity" placeholder="City">
                            </li>
                            <li>
                                <input type="text" name="tcountry" value="" id="tcountry" placeholder="Country">
                            </li>
                            <li>
                                <input type="text" name="tpostal" value="" id="tpostal" placeholder="Postal/Zip code">
                            </li>
                            <li>
                                <input type="tel" name="tphone" value="" id="tphone" placeholder="Phone No.">
                            </li>
                            <li>
                                <input type="tel" name="tmobile" value="" id="tmobile" placeholder="Mobile">
                            </li>
                            <li>
                                <input type="email" name="temail" value="" id="temail" placeholder="Email id">
                            </li>
                            <li>
                                <input type="text" name="tpassport" value="" id="tpassport" placeholder="Passport No.">
                            </li>
                            <li>
                                <input type="text" name="tpass_issue" value="" id="tpass_issue" placeholder="Passport Issue Date">
                            </li>
                            <li>
                                <input type="text" name="tpass_expiry" value="" id="tpass_expiry" placeholder="Passport Expiry Date">
                            </li>
                         
                                <strong>Other Information</strong>
                                 <div class="">Best Way to Contact You</div>
                                 <div class="font-icon-checkbox row">
                                    <div class="col-sm-2">
                                      <input name="person_ctype" id="contact_med1" type="checkbox" value="mail" >
                                      <label for="contact_med1">E-mail</label>
                                    </div>
                                    <div class="col-sm-2">
                                      <input name="person_ctype" id="contact_med2" type="checkbox" value="phone" >
                                      <label for="contact_med2">Phone</label>
                                    </div>
                                    <div class=" col-sm-2">
                                      <input name="person_ctype" id="contact_med3" type="checkbox" value="mobile" >
                                      <label for="contact_med3">Mobile</label>
                                    </div>
                                 </div>
                                 </ul>
                                <ul>
                                    <li>
                                        <label for="">How did you Hear About Us ?</label>
                                        <select class="form-control" name="person_hear">
                                            <option value="">Choose Hear About</option>
                                            <option value="search">Search Engine</option>
                                            <option value="referral">Referral</option>
                                            <option value="advertisement">Advertisement</option>
                                            <option value="newsletter">Newsletter</option>
                                            <option value="magazine">Magazine</option>
                                        </select>
                                    </li>
                                </ul>
                              <ul> 
                                <li>
                                     <strong>Your Question/comment.</strong>
                                    <textarea name="tmess" cols="40" rows="3" id="text-comment" placeholder="Enter your message"></textarea>
                            
                                </li>
                            </ul>
                            <ul>
                                <li>
                                      <div class="form-group col-sm-12">
                                        <img src="' . BASE_URL . 'captcha/imagebuilder.php?rand=310333" border="1" class="form-control" onclick="updateCaptcha(this);">                     
                                      </div>              
                                      <div class="form-group col-sm-12">
                                         <input placeholder="Enter Security Code" type="text" class="form-control" name="userstring" maxlength="5" />
                                      </div>
                                </li>
                            </ul>
                             <ul>
                                <li>
                                     
                                    <input type="submit" value="Submit" id="send_button">

                                </li>

                            </ul>
                    </form>';
}
$jVars['module:formbooking'] = $formbook;

/*
*
*/

$resbookbdc = $resbook = '';

if (defined('BOOKING_PAGE')) {
    $slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) ? addslashes($_REQUEST['slug']) : '';
    $bkpkgRec = Package::find_by_slug($slug);
    if ($bkpkgRec) {

        $resbookbdc .= '<div class="row">
            <h2 class="color-white">Booking Form</h2>
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <ul class="banner-breadcrumb color-white clearfix">
                    <li><a class="link-blue-2" href="' . BASE_URL . '">home</a> /</li>
                    <li><a class="link-blue-2" href="javascript:void(0);">Booking</a></li>
                    <li><a class="link-blue-2" href="javascript:void(0);">' . $bkpkgRec->title . '</a></li>
                </ul>
            </div>
        </div>';
        /* End Breadcrumb block */

        $resbook .= '<div id="inquiry-msg"></div>
        <form class="simple-from" action="" method="post" id="frm-booking">
            <div class="simple-group">
                <h3 class="small-title">Trip Information</h3>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Trip Name</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="trip_name" value="' . $bkpkgRec->title . '" readonly>
                            </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-block type-2 clearfix">
                            <div class="form-block clearfix">
                            <div class="form-label color-dark-2">Date of arrival</div>
                            <div class="input-style-1 b-50 color-3">
                                <img src="' . BASE_URL . 'template/web/img/calendar_icon_grey.png" alt="Image not Found">
                                <input type="text" placeholder="" id="checkin" class="checkin" name="checkin">
                            </div>                  
                        </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Date of Departure</div>
                            <div class="form-block clearfix">
                            <div class="input-style-1 b-50 color-3">
                                <img src="' . BASE_URL . 'template/web/img/calendar_icon_grey.png" alt="Image not Found">
                                <input type="text" placeholder="" id="checkout" class="checkout" name="checkout">
                            </div>                  
                        </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-block type-2 clearfix bookingselector">
                            <div class="form-label color-dark-2">No of Traveller</div>
                            <select name="no_traveller" class="drop-wrap">
                                <option value="">None</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3-5">3 - 5</option>
								<option value="6-9">6 - 9 </option>
								<option value="10+">10+</option>
                            </select>                            
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="simple-group">
                <h3 class="small-title">Your Personal Information</h3>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">First Name</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="first_name">
                            </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Last Name</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="last_name">
                            </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">E-mail Adress</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="mailaddress">
                            </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Country Name</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="country_name">
                            </div>
                        </div>                          
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Contact Number</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <input type="text" placeholder="" name="home_contact">
                            </div>
                        </div>
                    </div>
                   
                    
                </div>
            </div>
			
			<div class="simple-group">
                <h3 class="small-title">Hotel Information</h3>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix bookingselector">
                            <div class="form-label color-dark-2">Hotel Arrangements</div>
                            <select name="hotel_arrangement" class="drop-wrap">
                                <option value="">None</option>
								<option value="Economy / Budget">Economy / Budget </option>
								<option value="Standard">Standard</option>
								<option value="Luxury / Deluxe">Luxury / Deluxe</option>
								<option value="Heritage">Heritage</option>
                            </select>                            
                        </div>
                    </div>
					<div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix bookingselector">
                            <div class="form-label color-dark-2">Single Rooms Required</div>
                            <select name="no_room" class="drop-wrap">
                                <option value="">None</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4+">4 +</option>
                            </select>                            
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="simple-group">
                <h3 class="small-title">Other Informations</h3>
                <div class="row">
				
				    <div class="col-xs-12 col-sm-6">
                        <div class="form-block type-2 clearfix bookingselector">
                            <div class="form-label color-dark-2">How did you get to know About us? </div>  
                            <select name="know_about" class="drop-wrap">
                                <option value="">None</option>
                                <option value="Search Engine">Search Engine</option>
                                <option value="Recommendation">Recommendation</option>
                                <option value="Repeat Client">Repeat Client</option>
                                <option value="Agent">Agent</option>
                                <option value="Other Website">Other Website</option>
                            </select>                            
                        </div>
                    </div>
				 
                    <div class="col-xs-12 col-sm-12">
                        <div class="form-block type-2 clearfix">
                            <div class="form-label color-dark-2">Enter your comment</div>
                            <div class="input-style-1 b-50 brd-0 type-2 color-3">
                                <textarea class="area-style-1 color-1" name="comment" placeholder="Comment"></textarea>
                            </div>
                        </div>                          
                    </div>
                                        
                </div>
                    <div class="confirm-terms">
                        <div class="input-entry color-3">
                            <input class="" id="text-2" type="checkbox" name="terms" value="1">
                            <label class="clearfix" for="text-2">
                                <span class="checkbox-text">By continuing, you agree to the<a class="color-dr-blue-2 link-dark-2" href="#"> Terms and Conditions</a>.</span>
                            </label>
                        </div>
                    </div>                          
            </div>
            <input type="submit" class="c-button bg-dr-blue-2 hv-dr-blue-2-o" value="confirm booking">
        </form>';
    }
}

$jVars['module:book-breadcrumb'] = $resbookbdc;
$jVars['module:book-form'] = $resbook;
?>
<?php
$customizee = $customize = '';


$customizee .= '<section>
        <div class="form form_booking rows form-spac">
            <div class="container">
                <!--====== BOOKING FORM ==========-->
                <div class="col-md-offset-2 col-md-8 col-sm-8 col-xs-12 form_1 form_book wow fadeInLeft" data-wow-duration="1s">
                <div class="alert alert-success" id="msg" style="display:none;"></div>
                    <form id="trip-bookng" action="" method="post">
                        <div class="row customizess">
                            <div class="col-sm-12">
                                <label for="">Select Your Trip <abbr class="required" title="required">*</abbr>
                                </label>
                                <select name="pack" class="form-control">
                                    <option value="">Choose</option>';

$tripRec = Package::get_packages();
if (!empty($tripRec)) {
    foreach ($tripRec as $trips) {
        $customizee .= '<option value="' . $trips->title . '">' . $trips->title . '</option>';
    }
}

$customizee .= '
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="row customizess">
                            <div class="col-sm-6">
                                <label for="">Trip Date</label>
                                <input id="trip_date" type="text" name="trip_date" class="form-control" placeholder="Trip date" data-rate=""/>
                                    <span class="trip-rate"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Trip Duration</label>
                                <input name="trip_duration" type="number" class="form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row customizess">
                            <div class="col-sm-6">
                                <label for="">Adult</label>
                                <input name="adult" type="number" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Child</label>
                                <input name="child" type="number" class="form-control">
                            </div>
                        </div>
                        <br>

                        <div class="row customizess">
                            <div class="col-sm-6">
                                <label for="">First Name <abbr class="required" title="required">*</abbr>
                                </label>
                                <input name="person_fname" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Last Name <abbr class="required" title="required">*</abbr></label>
                                <input name="person_lname" type="text" class="form-control">
                            </div>
                        </div>
                        </br>

                        <div class="row customizess">
                            <div class="col-sm-6">
                                <label for="">E-mail</label>
                                <input name="person_email" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Contact No.</label>
                                <input name="person_phone" type="text" class="form-control">
                            </div>
                        </div>
                        </br>

                        <div class="row customizess">
                            <div class="col-sm-6">
                                <label for="">Address</label>
                                <input name="person_address" type="text" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label for="">Country</label>
                                <select name="person_country" class="form-control countrySelect" id="countrySelect">
                                <option value="">Choose</option>';
$contRec = Countries::find_all();
foreach ($contRec as $contRow) {
    $customizee .= '<option value="' . $contRow->country_name . '" contact-value="' . $contRow->country_no_code . '">' . $contRow->country_name . '</option>';
}
$customizee .= '
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="row customizess">
                            <div class="col-sm-12">
                                <label for="">Your Question / Comments</label>
                                <textarea name="person_comment" class="book_text_area form-control"></textarea>
                            </div>
                            <div class="col-sm-12"></br>
                            <label for="">For security reason</label>
                            <div class="row">
                            <div class="col-sm-3">
                            <img src="' . BASE_URL . 'captcha/imagebuilder.php?rand=310333" border="1" class="text-field" onclick="updateCaptcha(this);">
                            </div>
                            <div class="col-sm-5">
                            <input placeholder="Enter Security Code" type="text" class="form-control" name="userstring" maxlength="5" />
                            </div>
                            </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-block btn-primary btn-contact-page" style="padding:0; width:181px; height:40px; margin-top:15px;" id="btn-booking" name="submit">Submit</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>';


$customize .= '
        <form id="customize_form" action="" method="post">
            <h4 class="heading-title"><span>Customize Your Trip</span></h4>
            <div class="row gap-15 mb-15">
                <div class="col-12 col-md-12">

                    <div class="form-group">
                        <label>Select Your Trip</label>
                        <select data-placeholder="Select Your Trip" class="chosen-the-basi form-control" tabindex="2" name="trip">
                            <option value="">Select Your Trip</option>';
$tripRec = Package::get_packages();
if (!empty($tripRec)) {
    foreach ($tripRec as $trips) {
        $customize .= '<option value="' . $trips->title . '">' . $trips->title . '</option>';
    }
}
$customize .= '
                        </select>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-md-6">
                    <div class="form-group">
                        <label>Trip Date</label>
                        <div class="row cols-3 gap-5">
                            <input type="text" name="trip_date" class="form-control datepicker-here" placeholder="Trip Date" data-language="en"/>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-6 col-md-6">
                    <div class="form-group">
                        <label>No. Of Pax.</label>
                         <input type="number" class="form-control" name="pax"  placeholder="No. of pax"/>
                        <!--<select data-placeholder="Select" name="pax" class="chosen-the-basi form-control" tabindex="2">
                            <option value="">Select</option>
                            <option value="1-4">1-4</option>
                            <option value="5-15">5-10</option>
                            <option value="11-18">11-18</option>
                            <option value="19-29">19-29</option>
                            <option value="30-50">30-50</option>
                            <option value="50+">50+</option>
                        </select>-->
                    </div>
                </div>

                <div class="w-100 d-block d-md-none"></div>

                <div class="col-6 col-md-12">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Full name"/>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email address"/>
                    </div>
                </div>
<div class="col-6 col-md-6">
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address"/>
                    </div>
                </div>
   <div class="col-6 col-md-6">
                    <div class="form-group">
                        <label>Country</label>
                        <select data-placeholder="Select" name="country" class="chosen-the-basi form-control countrySelect" tabindex="2" id="countrySelect">
                            <option value="">Select</option>';
$contRec = Countries::find_all();
foreach ($contRec as $contRow) {
    $customize .= '<option value="' . $contRow->country_name . '" contact-value="' . $contRow->country_no_code . '">' . $contRow->country_name . '</option>';
}
$customize .= '
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control phone" placeholder="Phone number"/>
                    </div>
                </div>

                
             

                <div class="col-6 col-md-12">
                    <div class="form-group">
                        <label>Your Question/Comments</label>
                        <textarea class="form-control rounded-0" name="message" id="exampleFormControlTextarea2" rows="3"></textarea>
                    </div>
                </div>
                
                <div class="" id="msg" style="display:none;"></div>

                <div class="col-sm-8 col-md-6">
                    <button type="submit" id="submit" class="btn btn-primary btn-contact-page">Submit</button>
                </div>
            </div>
        </form>
';

$jVars['module:customize'] = $customize;

?>
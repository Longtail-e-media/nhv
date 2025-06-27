<?php
/*
* Trip Booking 
*/
$rescbred = $resbook = $side_info_bar = $side_script = '';
foreach ($_POST as $key => $val) {
    $$key = $val;
}
if (defined('BOOKTRIP_PAGE')) {

    $slug = (!empty($_REQUEST['slug'])) ? addslashes($_REQUEST['slug']) : '';
    $pkgRec = Package::find_by_slug($slug);

    if ($pkgRec) {
        // booking fotm start
        $resbook .= '
            <form id="booking_form" method="post" action="">
                <h4 class="heading-title mt-5"><span>Traveller Information</span></h4>
                <div class="row gap-15 mb-15">
                    <div class="col-6 col-md-12">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Full name"/>
                            <input type="hidden" name="pkg_id" value="' . $pkgRec->id . '"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" name="email" class="form-control" placeholder="Email Address"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>Zipcode *</label>
                            <input type="text" name="zipcode" class="form-control" placeholder="Zipcde"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>Country *</label>
                            <select data-placeholder="Select" name="country" class="chosen-the-basi form-control countrySelect" tabindex="2" id="countrySelect">
                                <option value="">Select</option>';
        $countries = Countries::find_all();
        foreach ($countries as $country) {
            $resbook .= '<option value="' . $country->country_name . '" contact-value="' . $country->country_no_code . '">' . $country->country_name . '</option>';
        }
        $resbook .= '
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>Phone *</label>
                            <input type="text" name="phone" class="form-control phone" placeholder="Phone number"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label>Address *</label>
                            <input type="text" name="address1" class="form-control" placeholder="Street 1"/>
                            <input type="text" name="address2" class="form-control mt-10" placeholder="Street 2 - Optional"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>Province</label>
                            <input type="text" name="province" class="form-control" placeholder="Or city"/>
                        </div>
                    </div>
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control" placeholder="Or town"/>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-12">
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea name="message" id="message" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                </div>
                <hr class="mv-40">';
        if (!empty($max_pax)) {
            if ($max_pax == 0) {
                $max = 0;
            } else {
                $max = (!empty($max_pax)) ? $max_pax : $pkgRec->group_size;
            }
        }else{
            $max = (!empty($max_pax)) ? $max_pax : $pkgRec->group_size;
        }
        if ($max > 0) {
            $resbook .= '
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="faqAccordionTab03-01">
                        <div class="tab-inner">
                            <div id="faqAccordion_03_g1" class="bt-collapse-wrapper collapse-style-04 as-accordion">
                                <div class="collapse-item">
                                    <div class="collapse-header" id="faqAccordion_03_g1-heading01">
                                        <h5 class="collapse-title">
                                            <a class="collapse-link" data-toggle="collapse"
                                               data-target="#faqAccordion_03_g1-collapse01"
                                               aria-expanded="true"
                                               aria-controls="faqAccordion_03_g1-collapse01">
                                                Additional Information for Guest 1
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="faqAccordion_03_g1-collapse01" class="collapse show"
                                         aria-labelledby="faqAccordion_03_g1-heading01"
                                         data-parent="#faqAccordion_03_g1">
                                        <div class="collapse-body">
                                            <div class="collapse-inner">
                                                <div class="row gap-15 mb-15">
                                                    <div class="col-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control " name="additional_name[]" placeholder="Full name"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control phone" name="additional_phone[]" placeholder="Phone number"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" name="additional_address[]" placeholder="Address"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mv-40">';
        }

        if (!empty($fixed_date_id)) {
            $resbook .= '<input type="hidden" name="fixed_date_id" value="' . $fixed_date_id . '">';
        }
        $resbook .= '
                <div class="custom-control custom-checkbox">
                    <input id="terms" name="terms" type="checkbox" class="custom-control-input" value="acceptTerms"/>
                    <label class="custom-control-label" for="terms">By submitting
                        a booking request, you accept our <a href="'.BASE_URL.'pages/terms-and-conditions" target="_blank">terms and conditions.</label>
                </div>
                <div id="msg" style="display: none;"></div>
                <div class="row mt-20">
                    <div class="col-sm-8 col-md-6">
                        <button type="submit" id="submit" class="btn btn-primary btn-contact-page">Book Now</button>
                    </div>
                </div>
            </form>
            ';
        // booking form end

        // Trip Details start
        $destslug = Destination::field_by_id($pkgRec->destinationId, 'slug');
        $dsRec = Destination::find_by_slug($destslug);
        $side_info_bar .= '
            <aside class="sticky-kit sidebar-wrapper no-border">
                <div class="booking-box">
                    <div class="box-heading"><h3 class="h6 text-white text-uppercase">Trip detail</h3></div>
                    <div class="box-content">
                        <a href="' . BASE_URL . 'package/' . $pkgRec->slug . '" class="tour-small-grid-01 mb-20 clearfix">
                            <div class="image"><img src="' . IMAGE_PATH . 'package/' . $pkgRec->image . '" alt="' . $pkgRec->title . '"/></div>
                            <div class="content">
                                <h6>' . $pkgRec->title . '</h6>
                                <ul class="item-meta">
                                    <li><i class="elegent-icon-pin_alt text-warning"></i>' . $dsRec->title . '</li>
                                    <li><strong>' . $pkgRec->days . ' days</strong></li>
                                </ul>';
        if (!empty($pkgRec->difficulty)) {
            switch ($pkgRec->difficulty) {
                case 'Easy':
                    $side_info_bar .= '<span class="price">Difficulty : <span class="h6 line-1 number"><img src="' . IMAGE_PATH . 'static/meter/1.png" title="'.$pkgRec->difficulty.'" class="new-img4  "></span></span>';
                    break;
                case 'Moderate':
                    $side_info_bar .= '<span class="price">Difficulty : <span class="h6 line-1 number"><img src="' . IMAGE_PATH . 'static/meter/2.png" title="'.$pkgRec->difficulty.'" class="new-img4  "></span></span>';
                    break;
                case 'Moderate To Strenous':
                    $side_info_bar .= '<span class="price">Difficulty : <span class="h6 line-1 number"><img src="' . IMAGE_PATH . 'static/meter/3.png" title="'.$pkgRec->difficulty.'" class="new-img4  "></span></span>';
                    break;
                case 'Strenous':
                    $side_info_bar .= '<span class="price">Difficulty : <span class="h6 line-1 number"><img src="' . IMAGE_PATH . 'static/meter/4.png" title="'.$pkgRec->difficulty.'" class="new-img4  "></span></span>';
                    break;
                case 'Very Strenous':
                    $side_info_bar .= '<span class="price">Difficulty : <span class="h6 line-1 number"><img src="' . IMAGE_PATH . 'static/meter/5.png" title="'.$pkgRec->difficulty.'" class="new-img4  "></span></span>';
                    break;
            }
        }
        $side_info_bar .= '
                                <!--<span class="price">Difficulty : <span class="h6 line-1 number">' . $pkgRec->difficulty . '</span></span>-->
                                <!--<span class="price">Price from <span class="h6 line-1 text-primary number">$ ' . $pkgRec->price . '</span></span>-->
                            </div>
                        </a>
                        <span class="font600">Your chosen date</span>
                        <div class="form-group form-spin-group mt-10">
                            <div class="error-message-date"></div>
                            ';
        if (!empty($date)) {
            $side_info_bar .= '<input type="text" class="form-control" id="datepicker-here" name="trip_date" data-language="en" value="' . $date . '" readonly/>
                                ';
        } else {
            $side_info_bar .= '<input type="text" class="form-control datepicker-here" id="datepicker-here" name="trip_date" data-language="en" placeholder="Choose Date"/>';
        }
        $side_info_bar .= '
                        </div>';
             if ($max == 0) {           
        $side_info_bar .= '<span class="font600">Travellers to go</span>
        <div class="form-group form-spin-group mt-10">
        <input type="number" class="form-control" name="paxx"  placeholder="No. of pax"/>
        </div>';
             }
        if ($max > 0) {
            $side_info_bar .= '
                        <div class="form-group form-spin-group  mt-15 ">
                            <label class="h6 font-sm">How many guests?</label>
                            <input type="text" class="form-control touch-spin-03 form-control-readonly" name="trip_pax" value="1" readonly/>
                        </div>
            ';
        }
           $siteRegulars = Config::find_by_id(1);

    $tellinked = '';
    $telno = explode(",", $siteRegulars->contact_info);
    $lastElement = array_shift($telno);
    $tellinked .= '<a href="tel:' . $lastElement . '" target="_blank">' . $lastElement . '</a>';
    foreach ($telno as $tel) {
        
        $tellinked .= ',<a href="tel:+977-' . $tel . '" target="_blank">' . $tel . '</a>';
        if(end($telno)!= $tel){
        $tellinked .= '';
        }   
}
        $side_info_bar .= '
                        <!--<ul class="border-top mt-20 pt-15">
                            <li class="clearfix">$3550 x 2 guests<span class="float-right">$251.98</span>
                            </li>
                            <li class="clearfix">Booking fee + tax<span class="float-right">$9.50</span>
                            </li>
                            <li class="clearfix pl-15">Book now &amp; Save<span
                                    class="float-right text-primary">-$15</span></li>
                            <li class="clearfix">Other fees<span
                                    class="float-right text-success">Free</span></li>
                            <li class="clearfix border-top font700 text-uppercase">
                                <div class="border-top mt-1">
                                    <span>Total</span><span class="float-right text-dark">$248.58</span>
                                </div>
                            </li>
                        </ul>-->
                    </div>
                    <div class="box-bottom">
                        <h6 class="">We are the best tour operator</h6>
                        <p class="font-sm" style="color:#fff;font-size:14px;">For custom tour program, direct call <span class=""> '.$tellinked.'</span>.
                        </p>
                    </div>
                </div>
            </aside>
            ';

        if ($max > 0) {
            $side_script .= '
                <script>
                    $(".touch-spin-03").TouchSpin({
                        min: 1,
                        max: ' . $max . ',
                        buttondown_class: "btn btn-light btn-touch-spin",
                        buttonup_class: "btn btn-light btn-touch-spin"
                    });
                </script>
            ';
        }

        // Trip Details end
    }

}

$jVars['module:book-bread'] = $rescbred;
$jVars['module:trip-booking-form'] = $resbook;
$jVars['module:trip-booking-info'] = $side_info_bar;
$jVars['module:trip-booking-info-script'] = $side_script;
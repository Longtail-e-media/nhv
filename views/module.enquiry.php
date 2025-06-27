<?php
$enquiry = '';
$trip_slug = $trip_title = $trip_brief = '';
if (!empty($_REQUEST['slug'])) {
    $slug = addslashes($_REQUEST['slug']);
    $tripRec = Package::find_by_slug($slug);
    if (!empty($tripRec)) {
        $enquiry .= '
                <form id="enquiry_form" method="post" action="">
                    <h4 class="heading-title"><span>Enquiry Form</span></h4>
                    <div class="row gap-15 mb-15">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>Trip Name</label>
                                <div class="row cols-3 gap-5">
                                    <input type="text" class="form-control" placeholder="' . $tripRec->title . '" name="trip_name" value="' . $tripRec->title . '" readonly/>
                                </div>
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
                                <select data-placeholder="Select" name="pax" class="chosen-the-basi form-control" tabindex="2">
                                    <option value="">Select</option>
                                    <option value="1-4">1-4</option>
                                    <option value="5-15">5-10</option>
                                    <option value="11-18">11-18</option>
                                    <option value="19-29">19-29</option>
                                    <option value="30-50">30-50</option>
                                    <option value="50+">50+</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-100 d-block d-md-none"></div>
                        <div class="col-6 col-md-12">
                            <div class="form-group">
                                <label>Full Name</label>
                                    <input type="text" name="full_name" class="form-control" placeholder="Full name"/>
                                </div>
                            </div>
                        <div class="col-6 col-sm-6 col-md-7">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email address"/>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone number"/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" placeholder="City"/>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select data-placeholder="Select" name="country" class="chosen-the-basi form-control" tabindex="2">
                                    <option value="">Select</option>
                                    ';
        $contRec = Countries::find_all();
        foreach ($contRec as $contRow) {
            $enquiry .= '<option value="' . $contRow->country_name . '">' . $contRow->country_name . '</option>';
        }
        $enquiry .= '
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-12">
                            <div class="form-group">
                                <label>Your Question/Comments</label>
                                <textarea class="form-control rounded-0" name="message" id="exampleFormControlTextarea2" rows="3"></textarea>
                            </div>
                        </div>
                        <div id="msg" style="display: none;"></div>
                        <div class="col-sm-8 col-md-6">
                            <button type="submit" id="submit" class="btn btn-primary btn-contact-page">Submit</button>
                        </div>
                    </div>
                </form>
        ';
    }
}

$jVars['module:enquiry'] = $enquiry;

?>

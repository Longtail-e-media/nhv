<?php
/*
* Module Package 
* Package::get_databy_display(column name, status, limit);
*/

// Destination display in homepage
$home_destination = '';
if (defined("HOME_PAGE")) {
    $destinations = Destination::get_destination();
    if (!empty($destinations)) {
        foreach ($destinations as $destination) {
            $file_path = SITE_ROOT . "images/destination/" . @$destination->image;
            $img = (!empty($destination->image) and file_exists($file_path)) ? IMAGE_PATH . "destination/" . $destination->image : IMAGE_PATH . "static/home-destination.jpg";
            $tours = Package::get_total_destination_packages($destination->id);
            $briefs = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', $destination->content);
            $home_destination .= '
                <div class="slick-item">
                    <figure class="destination-grid-item-01 hovereffect">
                   
                        <a href="' . BASE_URL . 'destination/' . $destination->slug . '">
                            <div class="image">
                                <img src="' . $img . '" alt="' . $destination->title . '"/>
                            </div>
                            <figcaption class="content tour-slide tour-slide123">
                                <h3>' . $destination->title . '</h3>
                                <p class="text-muted1">' . $tours . ' Packages</p>
                            </figcaption>
                            <div class="overlay">
                                <h4>' . $destination->title . '</h4><br/>
                                <h3>' . $tours . ' Packages</h3>
                                <h3 class="hoverp">' . strip_tags($briefs[0]) . '</h3>
                        </div>
                        </a>
                    </figure>
                </div>
            ';
        }
    }
}
$jVars["module:home-destination"] = $home_destination;

/* Package Display Using Home Flag */
$reshome = $grade = $destination_name = $rating = '';
$homeRec = Package::get_databy_display('homepage', 1, 6);
if (!empty($homeRec)) {
    foreach ($homeRec as $RecRow) {
        $img = $tag = '';
        // getting image
        $file_path = SITE_ROOT . "images/package/" . @$RecRow->image;
        $img = (!empty($RecRow->image) and file_exists($file_path)) ? IMAGE_PATH . "package/" . $RecRow->image : IMAGE_PATH . "static/home-featured.jpg";

        // getting tags
        $tag = (!empty($RecRow->tags)) ? '<span class="ribbon_3 ' . $RecRow->color . '">' . $RecRow->tags . '</span>' : '';

        // getting destination name
        $destination_name = Destination::field_by_id($RecRow->destinationId, 'title');

        // getting avg rating
        $rating = Package::get_avg_rating($RecRow->id);

        $price_text = '';
        if (!empty($RecRow->price) and (empty($RecRow->offer_price))) {
            $price_text = '<p class="home-price">Starting USD ' . $RecRow->price . '</p>';
        }
        if (!empty($RecRow->offer_price)) {
            $price_text = '<p class="home-price">Starting USD <del>' . $RecRow->price . '</del> ' . $RecRow->offer_price . '</p>';
        }

        $reshome .= '
                <div class="col-md-4">
                    <figure class="tour-grid-item-01 aw">
                        <a href="' . BASE_URL . 'package/' . $RecRow->slug . '">
                            <div class="image">
                                <img src="' . $img . '" alt="' . $RecRow->title . '"/>
                                
                                    ' . $price_text . '
                                
                            </div>
                            <figcaption class="content ">
                                ' . $tag . '
                                <h5 class="">' . substr($RecRow->title, 0, 45) . '</h5>
                                <ul class="item-meta mt-10">
                                    <li>
                                        <!--<i class="elegent-icon-pin_alt text-warning"></i>-->
                                        <i class="far fa-map pr-2" style="color: #f39949;"></i> ' . $destination_name . '
                                    </li>
                                    <!--<li>
                                        <div class="rating-item rating-sm rating-inline clearfix">
                                            <div class="rating-icons">
                                                <input type="hidden" class="rating"
                                                       data-filled="rating-icon ri-star rating-rated"
                                                       data-empty="rating-icon ri-star-empty"
                                                       data-fractions="2"
                                                       data-readonly value="' . $rating . '"/>
                                            </div>
                                        </div>
                                    </li>-->
                                    <li>
                                        <i class="far fa-hourglass pr-2" style="color: #f39949;"></i> ' . $RecRow->days . ' Days
                                        <!--<span class="font700 h6">
                                            <p class="mt-3">Price from <span
                                                    class="h6 line-1 text-primary font16">$ ' . $RecRow->price . '</span> <span
                                                    class="text-muted mr-5"></span></p>
                                        </span>-->
                                    </li>
                                </ul>
                            </figcaption>';
        if (!empty($RecRow->accomodation)) {
            $reshome .= '<p class="featured-trip1 d-none">';
            $routes = explode(',', $RecRow->accomodation);
            $limitedRouts = array_slice($routes, 0, 4);
            foreach ($limitedRouts as $route) {
                $reshome .= (end($limitedRouts) == $route) ? $route : $route . ' -> ';
            }
            $reshome .= '</p>';
        }
        if (!empty($RecRow->difficulty)) {
            switch ($RecRow->difficulty) {
                case 'Easy':
                    $reshome .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3" title="' . $RecRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Moderate':
                    $reshome .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3" title="' . $RecRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Moderate To Strenous':
                    $reshome .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3" title="' . $RecRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Strenous':
                    $reshome .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3" title="' . $RecRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Very Strenous':
                    $reshome .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3" title="' . $RecRow->difficulty . '" alt="Difficulty">';
                    break;
            }
        }
        $reshome .= '
                        </a>
                    </figure>
                    
                </div>
            
        ';
    }
}

$jVars['module:package-home'] = $reshome;

/* Package Display Using Feature Flag */
$resfeature = '';

$featureRec = Package::get_databy_display('featured', 1, 6);
if (!empty($featureRec)) {
    foreach ($featureRec as $fetRow) {
        $img = $tag = '';
        // getting image
        $file_path = SITE_ROOT . "images/package/" . $fetRow->image;
        $img = (!empty($fetRow->image) and file_exists($file_path)) ? IMAGE_PATH . "package/" . $fetRow->image : $img = IMAGE_PATH . "static/home-featured.jpg";

        // getting tags
        $tag = (!empty($fetRow->tags)) ? '<span class="ribbon_3 ' . $fetRow->color . '">' . $fetRow->tags . '</span>' : '';

        // getting destination
        $destination_name = Destination::field_by_id($fetRow->destinationId, 'title');

        // getting avg rating
        $rating = Package::get_avg_rating($fetRow->id);

        $price_text = '';
        if (!empty($fetRow->price) and (empty($fetRow->offer_price))) {
            $price_text = '<p class="home-price">Starting USD ' . $fetRow->price . '</p>';
        }
        if (!empty($fetRow->offer_price)) {
            $price_text = '<p class="home-price">Starting USD <del>' . $fetRow->price . '</del> ' . $fetRow->offer_price . '</p>';
        }

        $resfeature .= '
            <div class="col-md-4">
                <figure class="tour-grid-item-01 aw">
                    <a href="' . BASE_URL . 'package/' . $fetRow->slug . '">
                        <style>
                            .hgt-230{height:230px !important;}
                            .new-img3.tt{top:54%;}
                        </style>
                        <div class="image">
                            <img src="' . $img . '" alt="' . $fetRow->title . '" class="hgt-230"/>
                            ' . $price_text . '
                            
                            
                        </div>
                        <figcaption class="content ">
                            ' . $tag . '
                            <h5 class="">' . substr($fetRow->title, 0, 48) . '</h5>
                            <ul class="item-meta mt-10">
                                <li>
                                    <!--<i class="elegent-icon-pin_alt text-warning"></i>--> 
                                    <i class="far fa-map pr-2" style="color: #f39949;"></i>' . $destination_name . '
                                </li>
                                <!--<li>
                                    <div class="rating-item rating-sm rating-inline clearfix">
                                        <div class="rating-icons">
                                            <input type="hidden" class="rating"
                                                   data-filled="rating-icon ri-star rating-rated"
                                                   data-empty="rating-icon ri-star-empty" data-fractions="2"
                                                   data-readonly value="' . $rating . '"/>
                                        </div>
                                    </div>
                                </li>-->
                                <li><i class="far fa-hourglass pr-2" style="color: #f39949;"></i>' . $fetRow->days . ' Days</li>
                            </ul>
                            
                        </figcaption>';
        if (!empty($fetRow->accomodation)) {
            $resfeature .= '<p class="featured-trip1 d-none">';
            $routes = explode(',', $fetRow->accomodation);
            $limitedRoutes = array_slice($routes, 0, 4); // limit to first 4 items
            $lastRoute = end($limitedRoutes);

            foreach ($limitedRoutes as $route) {
                $resfeature .= ($lastRoute == $route) ? $route : $route . ' -> ';
            }

            $resfeature .= '</p>';
        }
        if (!empty($fetRow->difficulty)) {
            switch ($fetRow->difficulty) {
                case 'Easy':
                    $resfeature .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3 tt" title="' . $fetRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Moderate':
                    $resfeature .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3 tt" title="' . $fetRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Moderate To Strenous':
                    $resfeature .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3 tt" title="' . $fetRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Strenous':
                    $resfeature .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3 tt" title="' . $fetRow->difficulty . '" alt="Difficulty">';
                    break;
                case 'Very Strenous':
                    $resfeature .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3 tt" title="' . $fetRow->difficulty . '" alt="Difficulty">';
                    break;
            }
        }
        $resfeature .= '    
                    </a>
                </figure>
            </div>
        ';
    }
}

$jVars['module:package-feature'] = $resfeature;

/* package display using Fixed flag */
$resfix = '';
// $sql = "SELECT MAX(pd.package_currency),MAX(pd.package_rate), MIN(pd.package_date) AS package_date, p.slug,p.group_size, p.title, p.difficulty,p.id, p.image,p.accomodation, p.tags, p.price, p.breif, p.days, p.gread, p.pdate, p.destinationId, p.activityId FROM tbl_package_date AS pd 
// INNER JOIN tbl_package AS p ON pd.package_id = p.id 
// WHERE 
// p.status='1' AND pd.status='1' AND package_date>=CURDATE() GROUP BY pd.package_id ORDER BY package_date ASC ";
$sql = "SELECT 
    MAX(pd.package_currency) AS package_currency,
    MAX(pd.package_rate) AS package_rate,
    MIN(pd.package_date) AS package_date,
    p.slug,
    p.group_size,
    p.title,
    p.difficulty,
    p.id,
    p.image,
    p.accomodation,
    p.tags,
    p.price,
    p.breif,
    p.days,
    p.gread,
    p.pdate,
    p.destinationId,
    p.activityId,
    pd.package_seats,
    IFNULL(SUM(b.trip_pax), 0) AS total_booked,
    (pd.package_seats - IFNULL(SUM(b.trip_pax), 0)) AS remaining_seats
FROM tbl_package_date AS pd
INNER JOIN tbl_package AS p ON pd.package_id = p.id
LEFT JOIN tbl_bookinginfo AS b 
    ON b.pkg_id = p.id AND b.fixed_date_id = pd.id
WHERE 
    p.status = '1' 
    AND pd.status = '1' 
    AND pd.package_date >= CURDATE()
GROUP BY pd.id
HAVING remaining_seats > 0
ORDER BY package_date ASC;";
$query = $db->query($sql);
$totl = $db->num_rows($query);
if (defined('FIXED_DEPATURE')) {
    if ($totl > 0) {
        while ($FixRow = $db->fetch_object($query)) {
            $file_path = SITE_ROOT . 'images/package/' . $FixRow->image;
            if (file_exists($file_path) and !empty($FixRow->title)) {
                $activity = Activities::field_by_id($FixRow->activityId, 'title');
                $resfix .= '
            <!--<div class="col-md-4">
            <div class="to-ho-hotel-con"><a href="' . BASE_URL . 'package/' . $FixRow->slug . '">
                <div class="to-ho-hotel-con-1">
                    <div class="hom-hot-av-tic">
                        ' . $activity . ' 
                    </div>
                    <img src="' . IMAGE_PATH . 'package/' . $FixRow->image . '" alt="' . $FixRow->title . '">
                </div>
                <div class="to-ho-hotel-con-23">
                    <div class="to-ho-hotel-con-2">
                        <h4>' . $FixRow->title . '</h4>
                    </div></a>
                    <div class="to-ho-hotel-con-3">
                        <ul>
                            <li>
                                Duration : ' . $FixRow->days . ' <br />
                                Difficulty : ' . set_na($FixRow->difficulty) . '
                            </li>
                        </ul>
                    </div>
                    <div class="to-ho-hotel-con-4">
                        <a href="' . BASE_URL . 'book/package/' . $FixRow->slug . '" class="link-btn hom-hot-book-btn">Book Now</a>
                        <a href="' . BASE_URL . 'package/' . $FixRow->slug . '" class="link-btn hom-hot-view-btn">View More</a>
                    </div>
                </div>
            </div>
        </div>-->
        ';
                $img = $tag = '';
                // getting image
                $file_path = SITE_ROOT . "images/package/" . $FixRow->image;
                $img = (!empty($FixRow->image) and file_exists($file_path)) ? IMAGE_PATH . "package/" . $FixRow->image : $img = IMAGE_PATH . "static/home-featured.jpg";

                // getting tags
                $tag = (!empty($FixRow->tags)) ? '<span class="ribbon_3 ' . $FixRow->color . '">' . $FixRow->tags . '</span>' : '';

                // getting destination
                $destination_name = Destination::field_by_id($FixRow->destinationId, 'title');

                // getting avg rating
                $rating = Package::get_avg_rating($FixRow->id);

                $price_text = '';
                if (!empty($FixRow->price) and (empty($FixRow->offer_price))) {
                    $price_text = '<p class="home-price">Starting USD ' . $FixRow->price . '</p>';
                }
                if (!empty($FixRow->offer_price)) {
                    $price_text = '<p class="home-price">Starting USD <del>' . $FixRow->price . '</del> ' . $FixRow->offer_price . '</p>';
                }

                $resfix .= '
            <div class="col">
                <figure class="tour-grid-item-01 aw">
                    <a href="' . BASE_URL . 'package/' . $FixRow->slug . '">
                        <style>
                            .hgt-230{height:230px !important;}
                            .new-img3.tt{top:54%;}
                        </style>
                        <div class="image">
                            <img src="' . $img . '" alt="' . $FixRow->title . '" class="hgt-230"/>
                            ' . $price_text . '
                            
                            
                        </div>
                        <figcaption class="content ">
                            ' . $tag . '
                            <h5 class="">' . substr($FixRow->title, 0, 48) . '</h5>';
                $fixeddata = packagedate::get_package_date_home($FixRow->id);
                //  pr($fixeddata);
                if (!empty($fixeddata)) {
                    $start_date = date('F d, Y', strtotime($fixeddata->package_date));
                    $end_date = date('F d, Y', strtotime($fixeddata->package_date . ' + ' . $FixRow->days . ' days'));
                    // $count=packagedate::getTotalSub($FixRow->id);
                    // $total = !empty($count) ? $count : 0;
                    //  @$diff = $fixeddata->package_seats - $total;
                    $sqla = "SELECT SUM(trip_pax) total FROM tbl_bookinginfo WHERE pkg_id=$FixRow->id AND fixed_date_id=$fixeddata->id";
                    $resa = $db->fetch_array($db->query($sqla));
                    $totala = !empty($resa['total']) ? $resa['total'] : 0;
                    // pr($diffa);
                    @$diffa = $fixeddata->package_seats - $totala;
                    // pr($FixRow);
                    $difffa = $diffa - 1;
                    if ($diffa > 0) {
                        $resfix .= '  
                            <ul class="item-meta mt-15">
                                <li><span class="font700 h6">Start/End Trip:</span> <span class="font400 h6">' . $start_date . ' - ' . $end_date . '</span></li>
                               
                            </ul>
                           
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="item-meta mt-15">
                                        <li>
                                            <!--<i class="elegent-icon-pin_alt text-warning"></i>--> 
                                            <i class="far fa-map pr-2"></i>' . $destination_name . '
                                        </li>
                                        <!--<li>
                                            <div class="rating-item rating-sm rating-inline clearfix">
                                                <div class="rating-icons">
                                                    <input type="hidden" class="rating"
                                                           data-filled="rating-icon ri-star rating-rated"
                                                           data-empty="rating-icon ri-star-empty" data-fractions="2"
                                                           data-readonly value="' . $rating . '"/>
                                                </div>
                                            </div>
                                        </li>-->    <li><span class="font700 h6"><i class="far fa-hourglass"></i>' . $FixRow->days . ' Days</span></li>
                                    </ul>
                                    
                                </div>';

                        $resfix .= '<div class="col-md-6">
                                <ul class="item-meta mt-15">
                                    <li><span class="font700 h6">seats left:</span> <span class="font400 h6">' . $diffa . '</span></li>
                                </ul>
                               <form method="post" action="' . BASE_URL . 'book/package/' . $FixRow->slug . '">
                                    <input type="hidden" name="date" value="' . date('Y-m-d', strtotime($fixeddata->package_date)) . '">
                                    <input type="hidden" name="price" value="' . $fixeddata->package_rate . '">
                                    <input type="hidden" name="fixed_date_id" value="' . $fixeddata->id . '">
                                    <input type="hidden" name="max_pax" value="' . $difff . '">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm mt-3 btn-contact-page">Book now</button>
                                </form></div></div>';
                    }
                    $resfix .= '
                            <!-- <ul class="item-meta mt-15">
                                <li><span class="font700 h6">' . $FixRow->days . ' Days</span></li>
                                <li>
                                    <p class="mt-3">Price from <span class="h6 line-1 text-primary font16">$ ' . $FixRow->price . '</span>
                                        <span class="text-muted mr-5"></span></p>
                                </li>
                            </ul>-->
                        </figcaption>';
                    if (!empty($FixRow->accomodation)) {
                        $resfix .= '<p class="featured-trip1 d-none">';
                        $routes = explode(',', $FixRow->accomodation);
                        $limitedRoutes = array_slice($routes, 0, 4); // limit to first 4 items
                        $lastRoute = end($limitedRoutes);

                        foreach ($limitedRoutes as $route) {
                            $resfix .= ($lastRoute == $route) ? $route : $route . ' -> ';
                        }

                        $resfix .= '</p>';
                    }
                    if (!empty($FixRow->difficulty)) {
                        switch ($FixRow->difficulty) {
                            case 'Easy':
                                $resfix .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3 tt" title="' . $FixRow->difficulty . '" alt="Difficulty">';
                                break;
                            case 'Moderate':
                                $resfix .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3 tt" title="' . $FixRow->difficulty . '" alt="Difficulty">';
                                break;
                            case 'Moderate To Strenous':
                                $resfix .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3 tt" title="' . $FixRow->difficulty . '" alt="Difficulty">';
                                break;
                            case 'Strenous':
                                $resfix .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3 tt" title="' . $FixRow->difficulty . '" alt="Difficulty">';
                                break;
                            case 'Very Strenous':
                                $resfix .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3 tt" title="' . $FixRow->difficulty . '" alt="Difficulty">';
                                break;
                        }
                    }
                    $resfix .= '    
                    </a>
                </figure>
            </div>
        ';
                }
            }
        }
    }
}

$jVars['module:package-fixed'] = $resfix;


/*fixed departure above testimonial
*/
$fixedlist = '';
$fixRec = Package::get_databy_display('fixed', 1, 18);
if (!empty($fixRec)) {
    foreach ($fixRec as $FixRow) {
        // echo "<pre>";print_r($FixRow);
        // echo $FixRow->title;
        $file_path = SITE_ROOT . 'images/package/' . $FixRow->image;
        if (file_exists($file_path) and !empty($FixRow->title)) {
            if (!empty($FixRow->date)) {
                $fixedlist .= '<div class="dpt"><a class="link" href="' . BASE_URL . 'package/' . $FixRow->slug . '">
            <div class="row">';
                $fixedlist .= '<div class="col-xs-4 date">' . $FixRow->date . '</div>
                <div class="col-xs-8 title">' . $FixRow->title . '</div>';
                $fixedlist .= ' </div></a></div>';
            }
        }
    }
}

$jVars['module:dept-fixed'] = $fixedlist;


// sidebar feature package
$respkg_feature = '';

$featureRec = Package::get_databy_display('featured', 1, 6);
if (!empty($featureRec)) {
    foreach ($featureRec as $pkgfRow) {
        $file_path = SITE_ROOT . 'images/package/' . $pkgfRow->image;
        if (file_exists($file_path) and !empty($pkgfRow->image)) {
            $respkg_feature .= '<div class="hotel-small style-2 clearfix">
                <a class="hotel-img black-hover" href="' . BASE_URL . 'package/' . $pkgfRow->slug . '">
                    <img class="img-responsive radius-0" src="' . IMAGE_PATH . 'package/' . $pkgfRow->image . '" alt="' . $pkgfRow->title . '">
                    <div class="tour-layer delay-1"></div>                              
                </a>
                <div class="hotel-desc">
                    <h4><a href="' . BASE_URL . 'package/' . $pkgfRow->slug . '">' . $pkgfRow->title . '</a></h4>
                    <div class="tour-info-line">
                        <div class="tour-info">
                            <img src="' . BASE_URL . 'template/web/img/calendar_icon_grey.png" alt="Image not Found">
                            <span class="font-style-2 color-dark-2">' . $pkgfRow->days . '</span>
                        </div>                  
                    </div>                                                                          
                </div>
            </div>';
        }
    }
}

$jVars['module:package-featureside'] = $respkg_feature;

// Package Detail section 
$respkg_breadcrumb = $respkg_detail = $send_review = $email_friend = $ask_question = '';
if (defined('PACKAGE_PAGE')) {
    $slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) ? addslashes($_REQUEST['slug']) : '';
    $pkgRec = Package::find_by_slug($slug);

    $destslug = Destination::field_by_id($pkgRec->destinationId, 'slug');

    // getting avg rating
    $rating = Package::get_avg_rating($pkgRec->id);
    $reviews_total = Package::get_review_num($pkgRec->id);

    if (!empty($pkgRec)) {

        $respkg_detail .= '
            <section class="page-wrapper page-detail pt-0">
            <div class="pt-0"></div>
				<div class="fullwidth-horizon-sticky none-sticky-hide">
					<div class="fullwidth-horizon-sticky-inner">
						<div class="container">
							<div class="fullwidth-horizon-sticky-item clearfix">
								<ul id="horizon-sticky-nav" class="horizon-sticky-nav clearfix">
									<li>
										<a href="#detail-content-sticky-nav-01">Overview</a>
									</li>
									<li>
										<a href="#detail-content-sticky-nav-02">Itinerary</a>
									</li>';
        if (!empty($pkgRec->other_info)) {
            $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-08">Note</a>
									</li>
            ';
        }
        if ($pkgRec->maptype == 1) {
            $file_path = SITE_ROOT . 'images/package/map/' . $pkgRec->mapimage;
            if (file_exists($file_path) and !empty($pkgRec->mapimage)) {
                $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-03">Map</a>
									</li>
                ';
            }
        }
        if ($pkgRec->maptype == 2 and !empty($pkgRec->mapgoogle)) {
            $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-03">Map</a>
									</li>
            ';
        }
        if (!empty($pkgRec->incexc)) {
            $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-04">What\'s included</a>
									</li>
            ';
        }
        $fixedDates = Packagedate::getPackage_limit($pkgRec->id);
        $fixedDatesIdArr = Packagedate::check_availability($fixedDates, $pkgRec->id, $pkgRec->group_size);
        if (!empty($fixedDatesIdArr)) {
            $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-05">Availabilities</a>
									</li>
            ';
        }

        /*$reviews = Review::find_by_package($pkgRec->id);
        if(!empty($reviews)){*/
        $respkg_detail .= '
                                    <li>
										<a href="#detail-content-sticky-nav-07">Reviews</a>
									</li>
            ';
        /*}*/

        $respkg_detail .= '
									<li>
										<a href="#detail-content-sticky-nav-06">FAQ</a>
									</li>
									';


        $respkg_detail .= '
								</ul>
							</div>
						</div>
					</div>
				</div>
				';

        $sliderImages = PackageImage::getImagelist_by($pkgRec->id);
        if ($sliderImages) {
            $respkg_detail .= '
               <!--<div class="slick-carousel-wrapper slick-hero-wrapper clearfix">
					<div class="slick-carousel-inner">
						<div class="slick-hero">-->
                        	<div class="slider-collage detail-slide" style="padding-top:90px;">
                    <div class="main text-center">
                        <div class="container-fluid" id="gallery">
            ';
            $imageChunks = array_chunk($sliderImages, 3);
            // foreach ($sliderImages as $sliderImage) {

            //     $respkg_detail .= '


            //           <!--  <div class="slick-item">
            //                 <div class="image">
            //                     <img src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" alt="' . $sliderImage->title . '" />
            //                 </div>
            //             </div>
            //     ';
            // }
            if (!empty($sliderImages)) {
                $maxVisible = 6;
                $totalImages = count($sliderImages);

                // Limit to max 6, and pad if needed
                $images = array_slice($sliderImages, 0, $maxVisible);
                if ($totalImages < $maxVisible) {
                    $lastImage = end($sliderImages);
                    for ($i = $totalImages; $i < $maxVisible; $i++) {
                        $images[] = $lastImage;
                    }
                }

                // Split into chunks of 3 for layout
                $imageChunks = array_chunk($images, 3);
                $i = 0;

                foreach ($imageChunks as $index => $imageGroup) {
                    $rowClass = ($index == 0) ? 'row image-row-1 room-images' : 'row room-images room-next-images';
                    $respkg_detail .= '<div class="' . $rowClass . '">';

                    foreach ($imageGroup as $imgIndex => $sliderImage) {
                        $colClass = 'col-md-3';
                        if ($index == 0 && $imgIndex == 2) {
                            $colClass = 'col-md-6';
                        } elseif ($index == 1 && $imgIndex == 0) {
                            $colClass = 'col-md-6';
                        }

                        // First 6 images are visible
                        if ($i < $maxVisible) {
                            $respkg_detail .= '
                    <div class="' . $colClass . ' images" style="display: block;">
                        <a href="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" data-src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '">
                            <img src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" width="100%" class="img-thumbnail" alt="' . htmlspecialchars($sliderImage->title) . '">
                        </a>
                    </div>
                ';
                        } else {
                            // Shouldn't happen with maxVisible = 6, but kept for fallback
                            $respkg_detail .= '
                    <div class="d-none images">
                        <a href="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" data-src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '">
                            <img src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" alt="' . htmlspecialchars($sliderImage->title) . '" />
                        </a>
                    </div>
                ';
                        }

                        $i++;
                    }

                    $respkg_detail .= '</div>'; // end row
                }
            }


            // foreach ($sliderImages as $sliderImage) {
            //     $respkg_detail .= '
            //             <div class="slick-item">
            //                 <div class="image">
            //                     <img src="' . IMAGE_PATH . 'package/galleryimages/' . $sliderImage->image . '" alt="' . $sliderImage->title . '" />
            //                 </div>
            //             </div>
            //     ';
            // }
            $respkg_detail .= '
                        <div class="floating-button-deluxeRoom d-none">
                                <button class="float-end" onclick="light()">Show more images</button>
                            </div>
                        </div>
                        </div>
                        </div>         
            <!--  </div>
					</div>
				</div>-->
				
				<!--<div class="slider-collage detail-slide" style="padding-top:90px;">
                    <div class="main text-center">
                        <div class="container-fluid" id="gallery">
                            <div class="row image-row-1 room-images">
                            
                                <div class="col-md-3 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/bhutan.jpg">
                                        <img src="../template/web/img/bhutan.jpg" width="100%" class="img-thumbnail" alt="New Project (9)">
                                    </a>
                                </div>
                            
                            
                                <div class="col-md-3 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/banner.jpg">
                                        <img src="../template/web/img/banner.jpg" width="100%" class="img-thumbnail" alt="New Project (1)">
                                    </a>
                                </div>
                            
                            
                                <div class="col-md-6 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/banner.jpg">
                                        <img src="../template/web/img/banner.jpg" width="100%" class="img-thumbnail" alt="New Project (2)">
                                    </a>
                                </div>
                            
                            </div>
                            <div class="row  room-images room-next-images">
                            
                                <div class="col-md-6 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/banner.jpg">
                                        <img src="../template/web/img/banner.jpg" width="100%" class="img-thumbnail" alt="New Project">
                                    </a>
                                </div>
                            
                            
                                <div class="col-md-3 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/banner.jpg">
                                        <img src="../template/web/img/banner.jpg" width="100%" class="img-thumbnail" alt="New Project (3)">
                                    </a>
                                </div>
                            
                            
                                <div class="col-md-3 images" data-src="../template/web/img/banner.jpg" style="display: block;">
                                    <a href="../template/web/img/banner.jpg">
                                        <img src="../template/web/img/banner.jpg" width="100%" class="img-thumbnail" alt="New Project (4)">
                                    </a>
                                </div>
                            

                            </div>
                            <div class="floating-button-deluxeRoom">
                                <button class="float-end" onclick="light()">Show more images</button>
                            </div>
                        </div>
                        </div>
                        </div>-->
            ';
        } else {
            $respkg_detail .= '
                <div class="slick-carousel-wrapper slick-hero-wrapper clearfix">
					<div class="slick-carousel-inner">
						<div class="slick-hero">
                            <div class="slick-item">
                                <div class="image">
                                    <img src="' . IMAGE_PATH . 'static/package/7.jpg" alt="' . $pkgRec->title . '" />
                                </div>
                            </div>
                            <div class="slick-item">
                                <div class="image">
                                    <img src="' . IMAGE_PATH . 'static/package/6.jpg" alt="' . $pkgRec->title . '" />
                                </div>
                            </div>
                            <div class="slick-item">
                                <div class="image">
                                    <img src="' . IMAGE_PATH . 'static/package/5.jpg" alt="' . $pkgRec->title . '" />
                                </div>
                            </div>
                        </div>
					</div>
				</div>
            ';
        }

        $dsRec = Destination::find_by_slug($destslug);
        $respkg_detail .= '   
				<div class="page-title page-title1 border-bottom pt-25 mt-0 mb-0 border-bottom-0 d-none">
					<div class="container">
						<div class="row gap-15 align-items-center">
							<div class="col-12 col-md-7 detail-bread">
								<nav aria-label="breadcrumb">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
										<li class="breadcrumb-item one"><a href="' . BASE_URL . 'destination/' . $dsRec->slug . '">' . $dsRec->title . '</a></li>
										<li class="breadcrumb-item two"><a href="#" class="">' . $pkgRec->title . '</a></li>
										<!--<li class="breadcrumb-item active" aria-current="page">Tour detail</li>-->
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				
				<div class="container pt-30">
					<div class="row gap-20 gap-lg-40">
						<div class="col-12 col-lg-12">
							<div class="content-wrapper">
								<div id="detail-content-sticky-nav-01" class="detail-header mb-30">
									<div class="row gap-15 align-items-center">
							            <div class="col-12 col-md-8 d-flex align-items-center">
								            <h3 class="">' . $pkgRec->title . '</h3>
								            ';
        if (!empty($pkgRec->difficulty)) {
            switch ($pkgRec->difficulty) {
                case 'Easy':
                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" alt="Difficulty" title="' . $pkgRec->difficulty . '" style="width:100px">';
                    break;
                case 'Moderate':
                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" alt="Difficulty" title="' . $pkgRec->difficulty . '" style="width:100px">';
                    break;
                case 'Moderate To Strenous':
                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" alt="Difficulty" title="' . $pkgRec->difficulty . '" style="width:100px">';
                    break;
                case 'Strenous':
                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" alt="Difficulty" title="' . $pkgRec->difficulty . '" style="width:100px">';
                    break;
                case 'Very Strenous':
                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" alt="Difficulty" title="' . $pkgRec->difficulty . '" style="width:100px">';
                    break;
            }
        }
        $respkg_detail .= '
							            </div>
							            <div class="col-12 col-md-4">
    							            <div class="row">
    							                <div class="col-md-6">
    							                    <a href="' . BASE_URL . 'book/package/' . $pkgRec->slug . '" class="btn btn-primary btn-wide btn-contact-page" style="width:100%;">Book Now</a>
    							                </div>
    							                <div class="col-md-2">
    							                    <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">          
    							                        <i class="far fa-envelope" title="Email a Friend" style="font-size: 30px;"></i>
                                                    </a>
    							                </div>
    							                <div class="col-sm-4 text-sm-right">
        											<div class="col-inner">
        												<h6>Share:</h6>
        												<div class="box-socials clearfix">
        													<a href="http://www.facebook.com/share.php?caption=' . $pkgRec->slug . '&description=' . $pkgRec->title . '&u=' . BASE_URL . 'package/' . $pkgRec->slug . '&picture=' . IMAGE_PATH . 'package/' . $pkgRec->image . '/"" class="" target="_blank"><i class="fab fa-facebook-square"></i></a>
        													<a href="https://twitter.com/share?url=' . BASE_URL . 'package/' . $pkgRec->slug . '/&text=' . $pkgRec->title . '" class="" target="_blank"><i class="fab fa-twitter-square"></i></a>
        													<a href="https://www.linkedin.com/sharing/share-offsite/?url=' . BASE_URL . 'package/' . $pkgRec->slug . '" class="" target="_blank"><i class="fab fa-linkedin"></i></a>

        												</div>
        											</div>
        										</div>
    							            </div>
							            </div>
							            
						            </div>
									
									<div class="d-flex flex-column flex-sm-row align-items-sm-center mb-20">
										<!--<div class="mr-15 font-lg">
											Country: <a href="#"><i class="elegent-icon-pin_alt text-warning"></i> ' . $dsRec->title . '</a>
										</div>
										<div>
											<div class="rating-item rating-inline">
												<div class="rating-icons">
													<input type="hidden" class="rating" data-filled="rating-icon ri-star rating-rated" data-empty="rating-icon ri-star-empty" data-fractions="2" data-readonly value="' . $rating . '"/>
												</div>
												<p class="rating-text font600 text-muted font-12 letter-spacing-1"><span class="text-dark mr-3">' . $rating . '/5</span> ' . $reviews_total . ' reviews</p>
											</div>
										</div>-->
									</div>
									
									<ul class="list-inline-block highlight-list mt-30">
									';
        if (!empty($pkgRec->gread)) {
            $respkg_detail .= '
		                                <li>
									        <span class="icon-font d-block trip-facts">
												<img src="' . BASE_URL . 'template/web/img/check.png">
											</span>
											<p>
											';
            for ($i = 0; $i < $pkgRec->gread; $i++) {
                $respkg_detail .= '<i class="ri-star"></i>';
            }
            for ($i = 5; $i > $pkgRec->gread; $i--) {
                $respkg_detail .= '<i class="ri-star-empty"></i>';
            }
            $respkg_detail .= '
										    </p>
									    </li>
		    ';
        }

        $respkg_detail .= '
										<li>
											<span class="icon-font d-block trip-facts">
												<img src="' . BASE_URL . 'template/web/img/duration.png">
											</span>
											';
        $days = ($pkgRec->days == 1) ? 'day' : 'days';
        $respkg_detail .= '
											<p>' . $pkgRec->days . ' ' . $days . '</p>
										</li>
										';
        if (!empty($pkgRec->startpoint) and !empty($pkgRec->endpoint)) {
            $respkg_detail .= '
                                        <li>
											<span class="icon-font d-block trip-facts">
												<img src="' . BASE_URL . 'template/web/img/start.png">
											</span>
											<p>' . $pkgRec->startpoint . '/' . $pkgRec->endpoint . '</p>
										</li>
            ';
        }
        $respkg_detail .= '
										<!--
										<li>
											<span class="icon-font d-block trip-facts">
												<img src="' . BASE_URL . 'template/web/img/grade.png">
											</span>
											<p>' . $pkgRec->difficulty . '</p>
										</li>
										-->
										';
        if (!empty($pkgRec->season)) {
            $respkg_detail .= '
                                        <li>
											<span class="icon-font d-block trip-facts">
												<img src="' . BASE_URL . 'template/web/img/season.png">
											</span>
											<p>' . $pkgRec->season . '</p>
										</li>
            ';
        }
        $respkg_detail .= '
										<li>
											<span class="icon-font d-block trip-facts">
												<!--<img src="' . BASE_URL . 'template/web/img/group.png">-->
												<img src="' . BASE_URL . 'template/web/img/people.png">
											</span>
											<p>' . $pkgRec->group_size . ' people</p> 
										</li>
									</ul>
									<div class="mb-30"></div>
									' . $pkgRec->overview . '
								</div>
								<div class="mb-50"></div>
								<div id="detail-content-sticky-nav-02" class="fullwidth-horizon-sticky-section">
								    
								    <div class="row">
								        <div class="col-md-8">
								            <h4 class="heading-title">Itinerary</h4>
								        </div>
								        ';
        if ($pkgRec->itenaryfile) {
            $respkg_detail .= '
                        <div class="col-md-4">
                            <a href="' . IMAGE_PATH . 'package/docs/' . $pkgRec->itenaryfile . '" target="_blank" class="btn btn-primary btn-block btn-contact-page">Download itinerary</a>
                        </div>
            ';
        }
        $respkg_detail .= '
                            </div>
                            ';

        $itineraries = Itinerary::getPackage_limit($pkgRec->id);
        if ($itineraries) {
            $respkg_detail .= '
                <ul class="itinerary-list mt-30">
            ';
            foreach ($itineraries as $itinerary) {
                $respkg_detail .= '
                        <li>
                            <div class="itinerary-day">
                                <span>' . $itinerary->day . '</span>
                            </div>
                            <h6>' . $itinerary->title . '</h6>
                            ' . $itinerary->content . '
                        </li>
                ';
            }
            $respkg_detail .= '
                </ul>
            ';
        }

        $respkg_detail .= '			
                    <div class="mb-50"></div>
                </div>
                                ';

        if (!empty($pkgRec->other_info)) {
            $respkg_detail .= '
                    <div id="detail-content-sticky-nav-08" class="fullwidth-horizon-sticky-section">
                        <h4 class="heading-title">Note</h4> 
                        ' . $pkgRec->other_info . '
                        <div class="mb-50"></div>
                    </div>
                ';
        }

        if ($pkgRec->maptype == 1) {
            $file_path = SITE_ROOT . 'images/package/map/' . $pkgRec->mapimage;
            if (file_exists($file_path) and !empty($pkgRec->mapimage)) {
                $respkg_detail .= '
                    <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
                        <h4 class="heading-title">Map</h4> 
                        <img src="' . IMAGE_PATH . 'package/map/' . $pkgRec->mapimage . '" width="100%" height="450">
                        <div class="mb-50"></div>
                    </div>
                ';
            }
        }
        if ($pkgRec->maptype == 2 and !empty($pkgRec->mapgoogle)) {
            $respkg_detail .= '
                <div id="detail-content-sticky-nav-03" class="fullwidth-horizon-sticky-section">
                    <h4 class="heading-title">Map</h4> 
                    <iframe src=' . $pkgRec->mapgoogle . ' width="100%" height="450"></iframe>
                    <div class="mb-50"></div>
                </div>
            ';
        }

        if (!empty($pkgRec->incexc)) {
            $respkg_detail .= '
                <div id="detail-content-sticky-nav-04" class="fullwidth-horizon-sticky-section">
                    <h4 class="heading-title">What\'s included</h4>
                    ' . $pkgRec->incexc . '
                ';
            if (!empty($pkgRec->booking_info)) {
                $respkg_detail .= '
                    <h5>Not included</h5>
                    ' . $pkgRec->booking_info . '
                ';
            }
            $respkg_detail .= '
                    <div class="mb-50"></div>
                </div>
            ';
        }

        $fixedDates = Packagedate::getPackage_limit($pkgRec->id);
        //$fixedDatesIdArr = Packagedate::check_availability($fixedDates, $pkgRec->id, $pkgRec->group_size);
        $fixedDatesIdArr = Packagedate::check_availability($fixedDates, $pkgRec->id);
        if ($fixedDatesIdArr) {
            $respkg_detail .= '
                <div id="detail-content-sticky-nav-05" class="fullwidth-horizon-sticky-section">
                    <h4 class="heading-title">Availabilities</h4>
                    <div class="mb-20"></div>
                    <div class="item-text-long-wrapper">
                    <div class="item-heading text-muted">
                        <div class="row d-none d-sm-flex">
                            <div class="col-12 col-sm-9">
                                <div class="col-inner">
                                    <div class="row gap-10">
                                        <div class="col-4">Trip start</div>
                                        <div class="col-1"></div>
                                        <div class="col-4">Trip End</div>
                                        <div class="col-3">Book Before</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="col-inner">
                                    <div class="row gap-10">
                                        <div class="col-6 text-center">status</div>
                                        <!--<div class="col-6 text-right">price</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            ';

            foreach ($fixedDatesIdArr as $fixedDateId) {
                $fixedDate = Packagedate::find_by_id($fixedDateId);

                $today = date('F d, Y');
                $start_date = date('F d, Y', strtotime($fixedDate->package_date));
                $start_date_day = date('l', strtotime($fixedDate->package_date));
                //$closure_date = date('F d, Y', strtotime($fixedDate->package_date . ' - ' . $fixedDate->package_closure . ' days'));
                $closure_date = date('F d, Y', strtotime($fixedDate->package_closure));
                $end_date = date('F d, Y', strtotime($fixedDate->package_date . ' + ' . $pkgRec->days . ' days'));
                $end_date_day = date('l', strtotime($end_date));

                $seats_left = $sold_out = '';
                $sql = "SELECT SUM(trip_pax) total FROM tbl_bookinginfo WHERE pkg_id=$pkgRec->id AND fixed_date_id=$fixedDate->id";
                $res = $db->fetch_array($db->query($sql));
                $total = !empty($res['total']) ? $res['total'] : 0;
                // @$diff = $pkgRec->group_size - $total;
                @$diff = $fixedDate->package_seats - $total;
                $difff = $diff - 1;

                if ($diff > 0) {
                    $seats_left .= '
                            <div class="col-12 text-left text-sm-center">
                                <span class="font-sm">seats left </span>
                                <strong class="d-block">' . $diff . '</strong>
                            </div>
                            <!--<div class="col-6 text-left  text-sm-right">
                                <strong class="d-block">$ ' . $fixedDate->package_rate . '</strong>
                                <span class="font-sm">/ person</span>
                            </div>-->
                    ';
                } else {
                    $sold_out = 'sold-out';
                    $seats_left .= '
                            <div class="col-12 text-left text-sm-center">
                                <strong class="d-block text-success">Sold Out</strong>
                            </div>
                            <!--<div class="col-6 text-left  text-sm-right"></div>-->
                    ';
                }

                if ((strtotime($closure_date) >= strtotime($today))) {
                    $respkg_detail .= '
                        <div class="item-text-long ' . $sold_out . '">
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-9">
                                    <div class="col-inner mb-0 mb-sm-0">
                                        <div class="row gap-10 align-items-center">
                                            <div class="col-4"> 
                                                <span class="font-sm">' . $start_date_day . '</span>
                                                <strong class="d-block">' . $start_date . '</strong>
                                            </div>
                                            <div class="col-1">
                                                <span class="day-count mt-3">' . $pkgRec->days . '<br/>days</span>
                                            </div>
                                            <div class="col-4 text-right text-sm-left">
                                                <span class="font-sm">' . $end_date_day . '</span>
                                                <strong class="d-block">' . $end_date . '</strong>
                                            </div>
                                            <div class="col-3 ">
                                                <span class="font-sm">' . date('l', strtotime($fixedDate->package_closure)) . '</span>
                                                <strong class="d-block">' . date('F d, Y', strtotime($fixedDate->package_closure)) . '</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 col-sm-1">
                                    <div class="col-inner">
                                        <div class="row gap-10 align-items-center">
                                            ' . $seats_left . '
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-2">
                                    <form method="post" action="' . BASE_URL . 'book/package/' . $pkgRec->slug . '">
                                        <input type="hidden" name="date" value="' . date('Y-m-d', strtotime($fixedDate->package_date)) . '">
                                        <input type="hidden" name="price" value="' . $fixedDate->package_rate . '">
                                        <input type="hidden" name="fixed_date_id" value="' . $fixedDate->id . '">
                                        <input type="hidden" name="max_pax" value="' . $difff . '">
                                        <button type="submit" class="btn btn-primary btn-block btn-sm mt-3 btn-contact-page">Book now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                }

            }

            $respkg_detail .= '
                </div>
                <div class="mb-50"></div>
            </div>
            ';
        }


        $respkg_detail .= '
          
            <div id="detail-content-sticky-nav-07" class="fullwidth-horizon-sticky-section expert1">
                    
                        <h4 class="heading-title">Reviews</h4>';

        $reviews = Review::find_by_package($pkgRec->id);
        if ($reviews) {
            $respkg_detail .= '            
                        
                        <div class="bg-white-gradient-top-bottom pt-0">
                			<div class="bg-image overlay-relative">
            					<div class="testimonial-grid-slick-carousel testimonial-grid-wrapper" style="padding-top:0px;">
            					    <div class="testimonial-grid-arrow">
        								<ul>
        									<li class="testimonial-grid-prev"><button><span>previuos</span></button></li>
        									<li class="testimonial-grid-next"><button><span>next</span></button></li>
        								</ul>
            						</div>
            						   
            						<div class="slick-carousel-wrapper gap-50">
            							<div class="slick-carousel-outer">
            								<div class="slick-carousel-inner">
            									<div class="slick-testimonial-grid-arrows">
                        ';
            // pr($reviews);
            foreach ($reviews as $review) {
                $linkstart = (!empty($review->linksrc)) ? '<a href="' . $review->linksrc . '" target="_blank">' : '';
                $linkend = (!empty($review->linksrc)) ? '</a>' : '';
                $respkg_detail .= '
                                <div class="slick-item">
					                <div class="testimonial-grid-01">
					                    <div class="rating-item rating-sm">
                                            <div class="rating-icons">
                                                <input type="hidden" class="rating" data-filled="rating-icon ri-star rating-rated" data-empty="rating-icon ri-star-empty" data-fractions="2" data-readonly value="' . $review->rating . '"/>
                                            </div>
                                        </div>
						                <div class="content">
							                <p class="saying">
	                                            ' . strip_tags($review->comments) . '
                                            </p>
						                </div>
						
						                <div class="man clearfix">
            							<div class="image">
            								' . $linkstart . '<img src="' . IMAGE_PATH . 'package/review/' . $review->image . '" alt="' . $review->name . '" class="image-circle" />' . $linkend . '
            							</div>
							
							            <div class="texting">
								            <h5>' . $review->name . '</h5>
								            <p class="text-muted testimonial-cite">' . $review->country . '</p>
							            </div>
							            
						            </div>
					            </div>
				            </div>
				
                            
                ';
            }
            $respkg_detail .= '
                        
                        </div>
                        </div>
                        </div>
                        </div></div>
                        </div>
                        </div>
                        ';
        }

        $respkg_detail .= '
                    <div class="row mt-25">
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="col-inner">
                                <a data-toggle="modal" data-target="#exampleModalLong" class="btn btn-primary btn-wide btn-contact-page" style="color:#fff">Write Your Review</a>
                            </div>
                        </div>
                    </div>
                </div>
                  <div id="detail-content-sticky-nav-06" class="fullwidth-horizon-sticky-section">
                <h4 class="heading-title">FAQ</h4>
                <div class="faq-item-long-wrapper">
                    ' . $pkgRec->availability . '
                </div>
                
                <div class="row mt-25">
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="col-inner">
                            <a href="#exampleModalfaq" data-toggle="modal" data-target="#exampleModalfaq" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-wide btn-contact-page">Ask a question</a>
                        </div>
                    </div>
                </div>
                <div class="mb-50"></div>
            </div>
        ';
        // Similar Tours
        $actSlug = Activities::field_by_id($pkgRec->activityId, 'slug');
        $sql = "SELECT id FROM tbl_activities WHERE slug='$actSlug' AND status=1";
        $query = $db->query($sql);
        $totl = $db->num_rows($query);

        if ($totl > 0) {
            $respkg_detail .= '
                    <div class="fullwidth-horizon-sticky-section">
                        <h4 class="heading-title">Similar Tour</h4>
                            <div class="slick-carousel-wrapper gap-5" style="margin-top: 0px;">
                                <div class="slick-carousel-inner">
                                    <div class="slick-top-destination-detail activities">
                ';
            while ($row = $db->fetch_object($query)) {
                $similarTours = Package::get_filterpkg_by('', $row->id);
                foreach ($similarTours as $similarTour) {
                    $destslug = Destination::field_by_id($similarTour->destinationId, 'slug');
                    $dsRec = Destination::find_by_slug($destslug);
                    $rating = Package::get_avg_rating($similarTour->id);
                    $reviews_total = Package::get_review_num($similarTour->id);
                    if ($similarTour->id != $pkgRec->id) {
                        $respkg_detail .= '
                            <div class="slick-item">
                             <div class="col">
                                <figure class="tour-grid-item-01 ">
                                    <a href="' . BASE_URL . 'package/' . $similarTour->slug . '">
                                        <div class="image">
                                            <img src="' . IMAGE_PATH . 'package/' . $similarTour->image . '" alt="' . $similarTour->title . '" />

                                        </div>
                                        <figcaption class="content">
                                            <h5 class="">' . substr($similarTour->title, 0, 45) . '</h5>
                                            <ul class="item-meta mt-10 detailul">
                                                <li class="a123">
                                                    <!--<i class="elegent-icon-pin_alt text-warning"></i>--> 
                                                    <i class="far fa-map pr-2"style="color: #f39949;"></i>' . $dsRec->title . '
                                                </li>
                                                <!--<li>
                                                    <div class="rating-item rating-sm rating-inline clearfix">
                                                        <div class="rating-icons">
                                                            <input type="hidden" class="rating" data-filled="rating-icon ri-star rating-rated" data-empty="rating-icon ri-star-empty" data-fractions="2" data-readonly value="' . $rating . '"/>
                                                        </div>
                                                    </div>
                                                </li>-->
                                                <li><i class="far fa-hourglass pr-2" style="color: #f39949;"></i>' . $similarTour->days . ' days</li>
                                            </ul>
                                            <!--<ul class="item-meta mt-15">
                                                <li><span class="font700 h6" >' . $similarTour->days . ' days</span></li>
                                                <li>
                                                    <p class="mt-3">Price from <span class="h6 line-1 text-primary font16">$ ' . $similarTour->price . '</span> <span class="text-muted mr-5"></span></p>
                                                </li>
                                            </ul>-->
                                        </figcaption>';
                        if (!empty($similarTour->accomodation)) {
                            $respkg_detail .= '<p class="featured-trip1 d-none">';
                            $routes = explode(',', $similarTour->accomodation);
                            $limitedRouts = array_slice($routes, 0, 4);
                            foreach ($limitedRouts as $route) {
                                $respkg_detail .= (end($limitedRouts) == $route) ? $route : $route . ' -> ';
                            }
                            $respkg_detail .= '</p>';
                        }
                        if (!empty($similarTour->difficulty)) {
                            switch ($similarTour->difficulty) {
                                case 'Easy':
                                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3 ulnew-img3" title="' . $similarTour->difficulty . '" alt="Difficulty">';
                                    break;
                                case 'Moderate':
                                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3 ulnew-img3" title="' . $similarTour->difficulty . '" alt="Difficulty">';
                                    break;
                                case 'Moderate To Strenous':
                                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3 ulnew-img3" title="' . $similarTour->difficulty . '" alt="Difficulty">';
                                    break;
                                case 'Strenous':
                                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3 ulnew-img3" title="' . $similarTour->difficulty . '" alt="Difficulty">';
                                    break;
                                case 'Very Strenous':
                                    $respkg_detail .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3 ulnew-img3" title="' . $similarTour->difficulty . '" alt="Difficulty">';
                                    break;
                            }
                        }
                        $respkg_detail .= '
                                    </a>
                                </figure>
                            </div>
                            </div>
                        ';
                    }
                }
            }
            $respkg_detail .= '
                                </div>
                            </div>
                            </div>
                        <div class="mb-50"></div>
                    </div>
                ';
        }

        $pkgExperts = unserialize($pkgRec->expert_id);
        if (is_array($pkgExperts) and !empty($pkgExperts)) {
            $respkg_detail .= '
                    <div class="fullwidth-horizon-sticky-section ">
                        <h4 class="heading-title">Experts</h4>
            ';
            foreach ($pkgExperts as $pkgExpert) {
                $expert = Expert::find_by_id($pkgExpert[0][0]);
                if ($expert) {
                    $respkg_detail .= '
                        <div class="blog-author bg-light">
                            <div class="author-label">
                                <img src="' . IMAGE_PATH . 'expert/' . $expert->image . '" alt="' . $expert->name . '" class="img-circle" />
                            </div>
                            <div class="author-details">
                                <h5 class="heading">' . $expert->name . '</h5>
                                ' . $expert->description . '
                            </div>
                        </div>
                    ';
                }
            }
            $respkg_detail .= '
                        <div class="mb-50"></div>
                    </div>
            ';
        }


        $respkg_detail .= '          
                </div>
            </div>
                    <div class="col-12 col-lg-4 d-none">
                        <aside class="sticky-kit-02 sidebar-wrapper no-border mt-20 mt-lg-0">
        ';
        $price_text = '';
        if (!empty($pkgRec->price) and empty($pkgRec->offer_price)) {
            $price_text .= '   
                            <div class="book-now-detail">
                                <p class="price-book">
                                    <span class="text">Starting Price:</span>
                                    <ins style="text-decoration: none;"><span><span>USD</span>' . $pkgRec->price . '</span></ins>
                                    <span class="text">per person</span>
                                </p>
                            </div>
            ';
        }

        if (!empty($pkgRec->offer_price)) {
            $price_text .= '
                            <div class="book-now-detail">
                                <p class="price-book">
                                    <span class="text">Starting Price:</span>
                                    <del style="color: red;"><ins style="text-decoration: none;"><span><span>USD</span>' . $pkgRec->price . '</span></ins></del>
                                    <span class="text">per person</span>
                                </p>
                                <p class="price-book">
                                    <span class="text">Offer Price:</span>
                                    <ins style="text-decoration: none;"><span><span>USD</span>' . $pkgRec->offer_price . '</span></ins>
                                    <span class="text">per person</span>
                                </p>
                            </div>
            ';
        }

        $respkg_detail .= '
                            <div class="booking-box">
                                <div class="box-heading"><h3 class="h6 text-white text-uppercase">Make a booking</h3></div>
                                <div class="box-content enquiry-box">
                                    ' . $price_text . '
                                    <p class="d-none d-xl-block d-lg-block d-xl-none">
                                        <a class="btn btn-primary btn-block btn_map" href="' . BASE_URL . 'enquiry/package/' . $pkgRec->slug . '">Make an Enquiry <br> or <br> contact for group discount</a>
                                    </p>
                                    ';

        if (!empty($pkgRec->group_size_price1) or !empty($pkgRec->group_size_price2) or !empty($pkgRec->group_size_price3) or (!empty($pkgRec->group_size_price4)) or !empty($pkgRec->group_size_price5)) {
            $respkg_detail .= '
                    <a class="showStandardPP">Group Booking Discount </a>
                    <div class="standardPP border-top">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-list table-hover" style="border-bottom: 1px solid #ccc;">
                                    <thead>
                                        <tr>
                                            <th>No. of People</th>
                                            <th class="text-right">Price per person</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            for ($i = 1; $i <= 5; $i++) {
                $col_name_size = "group_size_price" . $i;
                $col_name_discouont = "discount" . $i;
                if (!empty($pkgRec->$col_name_size) and !empty($pkgRec->$col_name_discouont)) {
                    $discount = $pkgRec->price - ($pkgRec->price * $pkgRec->$col_name_discouont / 100);
                    $respkg_detail .= '
                                        <tr>
                                            <td> ' . $pkgRec->$col_name_size . ' </td>
                                            <td class="text-right">
                                            &nbsp; <span class="groupNewPrice">
                                            USD ' . $discount . ' </span>
                                            </td>
                                        </tr>
                ';
                }
            }
            $respkg_detail .= '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            ';
        }

        $respkg_detail .= '
                                    <a href="' . BASE_URL . 'book/package/' . $pkgRec->slug . '" class="btn btn-primary btn-block btn-contact-page">Book Now</a>
                                </div>';

        $fixedDates = Packagedate::getPackage_limit($pkgRec->id, 5);
        //$fixedDatesIdArr = Packagedate::check_availability($fixedDates, $pkgRec->id, $pkgRec->group_size);
        $fixedDatesIdArr = Packagedate::check_availability($fixedDates, $pkgRec->id);
        if (!empty($fixedDatesIdArr)) {
            $respkg_detail .= '
                    <div class="box-content col-md-12 enquiry-box">
                        <div class="downloadNote">
                            <h4>Fixed Departure</h4>
                            <div class="item-text-long-wrapper">
                                <div class="item-text-long side123">
            ';

            foreach ($fixedDatesIdArr as $fixedDateId) {
                $fixedDate = Packagedate::find_by_id($fixedDateId);

                $start_date = date('F d, Y', strtotime($fixedDate->package_date));
                $start_date_day = date('l', strtotime($fixedDate->package_date));
                $sql = "SELECT SUM(trip_pax) total FROM tbl_bookinginfo WHERE pkg_id=$pkgRec->id AND fixed_date_id=$fixedDate->id";
                $res = $db->fetch_array($db->query($sql));
                $total = !empty($res['total']) ? $res['total'] : 0;
                @$diff = $pkgRec->group_size - $total;
                $difff = $diff - 1;

                //getting days left
                $date1 = new DateTime();
                $date2 = new DateTime($fixedDate->package_closure);
                $days = $date2->diff($date1)->format('%a');
                $days++;

                $left = '';
                if (strtotime(date('Y-m-d')) < strtotime($fixedDate->package_closure)) {
                    $left = ($days == 1) ? $days . '<br/>day left' : $days . '<br/>days left<style>.hn' . $fixedDate->id . '{height:58px !important}</style>';
                } else {
                    $left = 'Last day';
                }

                $respkg_detail .= '
                        <div class="row align-items-center">
                            <div class="col-12 col-sm-7">
                                <div class="col-inner mb-10 mb-sm-0">
                                    <div class="row gap-10 align-items-center">
                                        <div class="col-5">
                                            <span class="day-count mt-3 count123 hn' . $fixedDate->id . '">' . $left . '</span>
                                        </div>
                                        <div class="col-7 text-right text-sm-left">
                                            <span class="font-sm">' . $start_date_day . '</span>
                                            <strong class="d-block">' . $start_date . '</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-sm-5 sidebtn">
                                <form method="post" action="' . BASE_URL . 'book/package/' . $pkgRec->slug . '">
                                    <input type="hidden" name="date" value="' . date('Y-m-d', strtotime($fixedDate->package_date)) . '">
                                    <input type="hidden" name="price" value="' . $fixedDate->package_rate . '">
                                    <input type="hidden" name="fixed_date_id" value="' . $fixedDate->id . '">
                                    <input type="hidden" name="max_pax" value="' . $difff . '">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm mt-3 btn-contact-page">Book now</button>
                                </form>
                            </div>
                        </div>
                ';
            }

            $respkg_detail .= '
                                </div>
                            </div>
                        </div>
                    </div>
            ';
        }
        $respkg_detail .= '
                                <div class="box-content col-md-12" style="background: #f2f0d0;">
                                <div class="downloadNote">
                                    <h4>Your Perfect Tour Experience</h4>
                                    <p>ABC and EBC, one of the leading trekking agencies of Nepal, would like to invite you to discover the diversity and wonders and beauties of the Himalayas</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="../customize" class="btn btn-primary btn-block btn-contact-page mt-3">
                                            Customize Trip</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="box-bottom bg-light">
                                    <h6 class="font-sm">We are the best tour operator</h6>
                                    <p class="font-sm">Our custom tour program, direct call <br><br><span class="text-primary"><a href="tel:  +977 9856073085"> +977 9856073085</a></span> Saurav<br><br><a href="tel:  +977 9851173085"> +977 9851173085</a> Surya</span> </p><br>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>
        ';


        // Review Modal
        $send_review .= '
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Write Your Review</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="review_form" method="post" action="">
                                <div class="row gap-15">
                                    <div class="col-4 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label>Trip Title</label>
                                            <input type="text" class="form-control" name="package_title" value="' . $pkgRec->title . '" readonly/>
                                            <input type="hidden" name="package_id" value="' . $pkgRec->id . '" readonly/>
                                        </div>
                                    </div>
            
                                    <div class="w-100 d-block d-md-none"></div>
            
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="full_name" placeholder="Full name"/>
                                        </div>
                                    </div>
            
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Gender <span class="text-danger">*</span></label>
                                            <select data-placeholder="Select" class="chosen-the-basi form-control" name="gender" tabindex="2">
                                                <option value="" disabled selected>Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="0">Others</option>
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Country <span class="text-danger">*</span></label>
                                            <select data-placeholder="Select" class="chosen-the-basi form-control countrySelect" name="country" tabindex="2" id="countrySelect">
                                                <option value="" disabled selected>Select</option>';
        $countries = Countries::find_all();
        foreach ($countries as $country) {
            $send_review .= '<option value="' . $country->country_name . '" contact-value="' . $country->country_no_code . '">' . $country->country_name . '</option>';
        }
        $send_review .= '
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="col-6 col-md-6">
                                        <div class="form-group">
                                            <label>Upload Image <span class="text-danger">*</span></label>
                                            <input type="file" name="review_img" id="review_img" class="no-shadow">
                                            <div id="preview_Image"></div>
                                        </div>
                                    </div>
            
                                    <div class="col-6 col-sm-6 col-md-7">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" placeholder="Email address"/>
                                        </div>
                                    </div>
            
                                    <div class="col-12 col-sm-6 col-md-5">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control phone" name="phone" placeholder="Phone number"/>
                                        </div>
                                    </div>';
        $send_review .= '
                                    <div class="col-12 col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <div class="ratz">
                                            <label>Overall Rating <span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5a" type="radio" name="overall_rating" value="5">
                                              <label for="rating5a">5</label>
                                              <input id="rating4a" type="radio" name="overall_rating" value="4">
                                              <label for="rating4a">4</label>
                                              <input id="rating3a" type="radio" name="overall_rating" value="3">
                                              <label for="rating3a">3</label>
                                              <input id="rating2a" type="radio" name="overall_rating" value="2">
                                              <label for="rating2a">2</label>
                                              <input id="rating1a" type="radio" name="overall_rating" value="1">
                                              <label for="rating1a">1</label>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Pre-trip Info <span class="text-danger">*</span></label>
                                            <span class="starRating1">
                                              <input id="rating5b" type="radio" name="pre_trip_rating" value="5">
                                              <label for="rating5b">5</label>
                                              <input id="rating4b" type="radio" name="pre_trip_rating" value="4">
                                              <label for="rating4b">4</label>
                                              <input id="rating3b" type="radio" name="pre_trip_rating" value="3">
                                              <label for="rating3b">3</label>
                                              <input id="rating2b" type="radio" name="pre_trip_rating" value="2">
                                              <label for="rating2b">2</label>
                                              <input id="rating1b" type="radio" name="pre_trip_rating" value="1">
                                              <label for="rating1b">1</label>
                                            </span>
                                        </div>
                                        </div>
                                    </div>
            
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Transportation<span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5c" type="radio" name="transportation_rating" value="5">
                                              <label for="rating5c">5</label>
                                              <input id="rating4c" type="radio" name="transportation_rating" value="4">
                                              <label for="rating4c">4</label>
                                              <input id="rating3c" type="radio" name="transportation_rating" value="3">
                                              <label for="rating3c">3</label>
                                              <input id="rating2c" type="radio" name="transportation_rating" value="2">
                                              <label for="rating2c">2</label>
                                              <input id="rating1c" type="radio" name="transportation_rating" value="1">
                                              <label for="rating1c">1</label>
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Accommodation<span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5e" type="radio" name="accommodation_rating" value="5">
                                              <label for="rating5e">5</label>
                                              <input id="rating4e" type="radio" name="accommodation_rating" value="4">
                                              <label for="rating4e">4</label>
                                              <input id="rating3e" type="radio" name="accommodation_rating" value="3">
                                              <label for="rating3e">3</label>
                                              <input id="rating2e" type="radio" name="accommodation_rating" value="2">
                                              <label for="rating2e">2</label>
                                              <input id="rating1e" type="radio" name="accommodation_rating" value="1">
                                              <label for="rating1e">1</label>
                                            </span>
                                        </div></div>
                                    </div>';
        $send_review .= '                                    
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Meals<span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5d" type="radio" name="meals_rating" value="5">
                                              <label for="rating5d">5</label>
                                              <input id="rating4d" type="radio" name="meals_rating" value="4">
                                              <label for="rating4d">4</label>
                                              <input id="rating3d" type="radio" name="meals_rating" value="3">
                                              <label for="rating3d">3</label>
                                              <input id="rating2d" type="radio" name="meals_rating" value="2">
                                              <label for="rating2d">2</label>
                                              <input id="rating1d" type="radio" name="meals_rating" value="1">
                                              <label for="rating1d">1</label>
                                            </span>
                                        </div></div>
                                    </div>
            
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Staffs <span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5f" type="radio" name="staffs_rating" value="5">
                                              <label for="rating5f">5</label>
                                              <input id="rating4f" type="radio" name="staffs_rating" value="4">
                                              <label for="rating4f">4</label>
                                              <input id="rating3f" type="radio" name="staffs_rating" value="3">
                                              <label for="rating3f">3</label>
                                              <input id="rating2f" type="radio" name="staffs_rating" value="2">
                                              <label for="rating2f">2</label>
                                              <input id="rating1f" type="radio" name="staffs_rating" value="1">
                                              <label for="rating1f">1</label>
                                            </span>
                                        </div></div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                        <div class="ratz">
                                            <label>Value for Money <span class="text-danger">*</span></label>
                                            <span class="starRating">
                                              <input id="rating5g" type="radio" name="money_rating" value="5">
                                              <label for="rating5g">5</label>
                                              <input id="rating4g" type="radio" name="money_rating" value="4">
                                              <label for="rating4g">4</label>
                                              <input id="rating3g" type="radio" name="money_rating" value="3">
                                              <label for="rating3g">3</label>
                                              <input id="rating2g" type="radio" name="money_rating" value="2">
                                              <label for="rating2g">2</label>
                                              <input id="rating1g" type="radio" name="money_rating" value="1">
                                              <label for="rating1g">1</label>
                                            </span>
                                        </div></div>
                                    </div>';
        $send_review .= '
                                    <div class="col-12 col-md-12">
                                        <div class="form-group">
                                            <label for="comment-message">Message <span class="text-danger">*</span></label>
                                            <textarea name="message" id="comment-message" class="form-control" rows="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-success" id="msg" style="display:none;"></div>
                                
                        </div>
            
                        <div class="modal-footer">
                            <button type="submit" id="submit" class="btn btn-primary btn-contact-page">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';

        // Email a friend
        $email_friend .= '
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send a Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="email_a_friend" method="post" action="">
                                <div class="" id="msg" style="display:none;"></div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Trip Name</label>
                                    <input type="text" class="form-control" id="recipient-name" value="' . $pkgRec->title . '" readonly>
                                    <input type="hidden" class="form-control" name="package_id" value="' . $pkgRec->id . '">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-email" class="col-form-label">Email Address<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="recipient-email" name="primary_email" placeholder="To:">
                                    <small class="text-muted">Single email</small>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-emails" class="col-form-label">Email Address (Optional)</label>
                                    <input type="text" class="form-control" id="recipient-emails" name="cc_emails" placeholder="Cc:">
                                    <small class="text-muted">Use commas to separate multiple emails</small>
                                </div>
                                <div class="form-group">
                                    <label for="comment-message">Message<span class="text-danger">*</span></label>
                                    <textarea name="message" id="comment-message" name="message" class="form-control" rows="6"></textarea>
                                </div>
                                
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="submit" class="btn btn-primary btn-contact-page #exampleModal">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';

        //Ask a Question
        $ask_question .= '
        
           <div class="modal fade" id="exampleModalfaq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Ask a Question</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          <form method="post" action="" id="ask_question_form">
                                            <div class="d-flex flex-column flex-lg-row align-items-stretch">
                                                <div class="flex-md-grow-1 bg-primary-light">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-lg-12">
                                                        <div class="" id="msgg" style="display:none;"></div>
                                                            <div class="form-group">
                                                                <label>Full name</label>
                                                                <input type="text" name="full_name" class="form-control"/>
                                                                <input type="hidden" name="package_name" value="' . $pkgRec->title . '"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email adress</label>
                                                                <input type="text" name="email" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <textarea name="message" id="comment-message" class="form-control" rows="6"></textarea>
                                                            </div>
                                                            <button type="submit" id="submit" class="btn btn-primary btn-wide btn-contact-page">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                            </div>
                    </div>
                </div>
            </div>
            
            <!--<div class="modal fade modal-with-tabs form-login-modal" id="loginFormTabInModal" aria-labelledby="modalWIthTabsLabel"
     tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content shadow-lg">
            
                        <nav class="d-none">
                            <ul class="nav external-link-navs clearfix">
                                <li><a data-toggle="tab" href="#loginFormTabInModal-login">Sign-in</a></li>
                                <li><a data-toggle="tab" href="#loginFormTabInModal-register">Register </a></li>
                                <li><a data-toggle="tab" href="#loginFormTabInModal-forgot-pass">Forgot Password </a></li>
                            </ul>
                        </nav>
                        
                        <div class="text-center pb-20">
                            <button type="button" class="close" data-dismiss="modal" aria-labelledby="Close">
                                <span aria-hidden="true"><i class="far fa-times-circle"></i></span>
                            </button>
                        </div>
            
                        <div class="tab-content">
            
                            <div role="tabpanel" class="tab-pane active" id="askquestions">
            
                                <div class="form-login">
            
                                    <div class="form-header">
                                        <h4>Ask A Question</h4>
                                    </div>
            
                                    <div class="form-body">
                                        <form method="post" action="" id="ask_question_form">
                                            <div class="d-flex flex-column flex-lg-row align-items-stretch">
                                                <div class="flex-md-grow-1 bg-primary-light">
                                                    <div class="row">
                                                        <div class="col-12 col-md-10 col-lg-8">
                                                        <div class="" id="msgg" style="display:none;"></div>
                                                            <div class="form-group">
                                                                <label>Full name</label>
                                                                <input type="text" name="full_name" class="form-control"/>
                                                                <input type="hidden" name="package_name" value="' . $pkgRec->title . '"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email adress</label>
                                                                <input type="text" name="email" class="form-control"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Question</label>
                                                                <textarea name="message" id="comment-message" class="form-control" rows="6"></textarea>
                                                            </div>
                                                            <button type="submit" id="submit" class="btn btn-primary btn-wide btn-contact-page">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
            
                            </div> -->';

        $ask_question .= '
                           <!-- <div role="tabpanel" class="tab-pane fade in" id="emailfriend">
            
                                <div class="form-login">
            
                                    <div class="form-header">
                                        <h4>Ask A Questions</h4>
                                    </div>
            
                                    <div class="form-body">
            
                                        <form method="post" action="#">
            
                                            <div class="d-flex flex-column flex-lg-row align-items-stretch">
            
                                                <div class="flex-grow-1 bg-primary-light">
            
                                                    <div class="form-inner">
                                                        <div class="form-group">
                                                            <label>Full name</label>
                                                            <input type="text" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email adress</label>
                                                            <input type="text" class="form-control"/>
                                                        </div>
                                                        <div class="row cols-2 gap-10">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Password</label>
                                                                    <input type="password" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label>Confirm password</label>
                                                                    <input type="password" class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                </div>
            
                                                <div class="form-login-socials">
                                                    <div class="login-socials-inner">
                                                        <h5 class="mb-20">Or sign-in with your socials</h5>
                                                        <button class="btn btn-login-with btn-facebook btn-block"><i
                                                                class="fab fa-facebook"></i> facebook
                                                        </button>
                                                        <button class="btn btn-login-with btn-google btn-block"><i
                                                                class="fab fa-google"></i> google
                                                        </button>
                                                        <button class="btn btn-login-with btn-twitter btn-block"><i
                                                                class="fab fa-twitter"></i> google
                                                        </button>
                                                    </div>
                                                </div>
            
                                            </div>
            
                                            <div class="d-flex flex-column flex-md-row mt-30 mt-lg-10">
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="btn btn-primary btn-wide mt-5">Sign-up</a>
                                                </div>
                                                <div class="pt-1 ml-0 ml-md-15 mt-15 mt-md-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="loginFormTabInModal-acceptTerm">
                                                        <label class="custom-control-label line-145"
                                                               for="loginFormTabInModal-acceptTerm">By clicking this, you are agree
                                                            to to our <a href="#">terms of use</a> and <a href="#">privacy
                                                                policy</a> including the use of cookies</label>
                                                    </div>
                                                </div>
                                            </div>
            
                                        </form>
            
                                    </div>
            
                                    <div class="form-footer">
                                        <p>Already a member? <a href="#loginFormTabInModal-login" class="tab-external-link font600">Sign
                                            in</a></p>
                                    </div>
            
                                </div>
            
                            </div>
            
                            <div role="tabpanel" class="tab-pane fade in" id="loginFormTabInModal-forgot-pass">
            
                                <div class="form-login">
            
                                    <div class="form-header">
                                        <h4>Lost your password?</h4>
                                        <p>Please provide your detail.</p>
                                    </div>
            
                                    <div class="form-body">
                                        <form method="post" action="#">
                                            <p class="line-145">We\'ll send password reset instructions to the email address associated with your account.</p>
                                            <div class="row">
                                                <div class="col-12 col-md-10 col-lg-8">
                                                    <div class="form-group">
                                                        <input type="password" class="form-control" placeholder="password"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary mt-5">Retreive password</button>
                                        </form>
                                    </div>
            
                                    <div class="form-footer">
                                        <p>Back to <a href="#loginFormTabInModal-login" class="tab-external-link font600">Sign
                                            in</a> or <a href="#loginFormTabInModal-register" class="tab-external-link font600">Sign
                                            up</a></p>
                                    </div>
            
                                </div>
            
                            </div>
            
                        </div>
            
                        
                    </div>
                </div>
            </div>-->
        ';

    } else {
        $url = BASE_URL . 'pages/errors';
        redirect_to($url);
    }
}

$jVars['module:package-breadcrumb'] = $respkg_breadcrumb;
$jVars['module:package-detail'] = $respkg_detail;
$jVars['module:package-review-modal'] = $send_review;
$jVars['module:package-email-friend'] = $email_friend;
$jVars['module:package-ask-question-modal'] = $ask_question;


// Fixed package for home
$reshfix = '';
// $sql = "SELECT MAX(pd.package_currency),MAX(pd.package_rate), MIN(pd.package_date) AS package_date, p.slug,p.group_size, p.title, p.difficulty,p.id, p.image,p.accomodation, p.tags, p.price, p.breif, p.days, p.gread, p.pdate, p.destinationId, p.activityId FROM tbl_package_date AS pd 
// INNER JOIN tbl_package AS p ON pd.package_id = p.id 
// WHERE 
// p.status='1' AND pd.status='1' AND package_date>=CURDATE() GROUP BY pd.package_id ORDER BY package_date ASC LIMIT 6";
$sql = "SELECT 
    MAX(pd.package_currency) AS package_currency,
    MAX(pd.package_rate) AS package_rate,
    MIN(pd.package_date) AS package_date,
    p.slug,
    p.group_size,
    p.title,
    p.difficulty,
    p.id,
    p.image,
    p.accomodation,
    p.tags,
    p.price,
    p.breif,
    p.days,
    p.gread,
    p.pdate,
    p.destinationId,
    p.activityId,
    pd.package_seats,
    IFNULL(SUM(b.trip_pax), 0) AS total_booked,
    (pd.package_seats - IFNULL(SUM(b.trip_pax), 0)) AS remaining_seats
FROM tbl_package_date AS pd
INNER JOIN tbl_package AS p ON pd.package_id = p.id
LEFT JOIN tbl_bookinginfo AS b 
    ON b.pkg_id = p.id AND b.fixed_date_id = pd.id
WHERE 
    p.status = '1' 
    AND pd.status = '1' 
    AND pd.package_date >= CURDATE()
GROUP BY pd.id
HAVING remaining_seats > 0
ORDER BY package_date ASC
LIMIT 6;";
// $sql = "SELECT MAX(pd.package_currency), MAX(pd.package_rate), MIN(pd.package_date) AS package_date, p.slug, p.title, p.image, p.tags, p.breif, p.days, p.gread, p.pdate, p.destinationId, p.activityId FROM tbl_package_date AS pd 
//     INNER JOIN tbl_package AS p ON pd.package_id = p.id 
//     WHERE 
//     p.status='1' AND pd.status='1' AND package_date>=CURDATE() GROUP BY pd.package_id ORDER BY COUNT(package_date) ASC  LIMIT 6 ";
$query = $db->query($sql);

$totl = $db->num_rows($query);
if ($totl > 0) {
    while ($row = $db->fetch_object($query)) {
        $file_path = SITE_ROOT . 'images/package/' . $row->image;
        if (file_exists($file_path) and !empty($row->title)) {
            $activity = Activities::field_by_id($row->activityId, 'title');
            $reshfix .= '
            <!--<div class="col-md-4">
            <div class="to-ho-hotel-con"><a href="' . BASE_URL . 'package/' . $row->slug . '">
                <div class="to-ho-hotel-con-1">
                    <div class="hom-hot-av-tic">
                        ' . $activity . ' 
                    </div>
                    <img src="' . IMAGE_PATH . 'package/' . $row->image . '" alt="' . $row->title . '">
                </div>
                <div class="to-ho-hotel-con-23">
                    <div class="to-ho-hotel-con-2">
                        <h4>' . $row->title . '</h4>
                    </div></a>
                    <div class="to-ho-hotel-con-3">
                        <ul>
                            <li>
                                Duration : ' . $row->days . ' <br />
                                Difficulty : ' . set_na($row->difficulty) . '
                            </li>
                        </ul>
                    </div>
                    <div class="to-ho-hotel-con-4">
                        <a href="' . BASE_URL . 'book/package/' . $row->slug . '" class="link-btn hom-hot-book-btn">Book Now</a>
                        <a href="' . BASE_URL . 'package/' . $row->slug . '" class="link-btn hom-hot-view-btn">View More</a>
                    </div>
                </div>
            </div>
        </div>-->
        ';
            $img = $tag = '';
            // getting image
            $file_path = SITE_ROOT . "images/package/" . $row->image;
            $img = (!empty($row->image) and file_exists($file_path)) ? IMAGE_PATH . "package/" . $row->image : $img = IMAGE_PATH . "static/home-featured.jpg";

            // getting tags
            $tag = (!empty($row->tags)) ? '<span class="ribbon_3 ' . $row->color . '">' . $row->tags . '</span>' : '';

            // getting destination
            $destination_name = Destination::field_by_id($row->destinationId, 'title');

            // getting avg rating
            $rating = Package::get_avg_rating($row->id);

            $price_text = '';
            if (!empty($row->price) and (empty($row->offer_price))) {
                $price_text = '<p class="home-price">Starting USD ' . $row->price . '</p>';
            }
            if (!empty($row->offer_price)) {
                $price_text = '<p class="home-price">Starting USD <del>' . $row->price . '</del> ' . $row->offer_price . '</p>';
            }

            $reshfix .= '
            <div class="col">
                <figure class="tour-grid-item-01">
                    <a href="' . BASE_URL . 'package/' . $row->slug . '">
                        <style>
                            .hgt-230{height:230px !important;}
                            .new-img3.tt{top:54%;}
                        </style>
                        <div class="image">
                            <img src="' . $img . '" alt="' . $row->title . '" class="hgt-230"/>
                            ' . $price_text . '
                            
                            
                        </div>
                        <figcaption class="content ">
                            ' . $tag . '
                            <h5 class="">' . substr($row->title, 0, 48) . '</h5>';
            $fixeddata = packagedate::get_package_date_home($row->id);
            if (!empty($fixeddata)) {
                $start_date = date('F d, Y', strtotime($fixeddata->package_date));
                $end_date = date('F d, Y', strtotime($fixeddata->package_date . ' + ' . $row->days . ' days'));
                $sqlb = "SELECT SUM(trip_pax) total FROM tbl_bookinginfo WHERE pkg_id=$row->id AND fixed_date_id=$fixeddata->id";
                $resb = $db->fetch_array($db->query($sqlb));
                $totalb = !empty($resb['total']) ? $resb['total'] : 0;
                // pr($total);
                @$diffb = $fixeddata->package_seats - $totalb;
                // $difffb = $diffb - 1;
                $difffb = $diffb;
                // pr($difffb);
                if ($diffb > 0) {
                    $reshfix .= '  
                            <ul class="item-meta mt-15">
                                <li><span class="font700 h6">Start/End Trip:</span> <span class="font400 h6">' . $start_date . ' - ' . $end_date . '</span></li>
                               
                            </ul>
                            
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="item-meta mt-15">
                                        <li>
                                            <!--<i class="elegent-icon-pin_alt text-warning"></i>--> 
                                            <i class="far fa-map pr-2"></i>' . $destination_name . '
                                        </li>
                                        <!--<li>
                                            <div class="rating-item rating-sm rating-inline clearfix">
                                                <div class="rating-icons">
                                                    <input type="hidden" class="rating"
                                                           data-filled="rating-icon ri-star rating-rated"
                                                           data-empty="rating-icon ri-star-empty" data-fractions="2"
                                                           data-readonly value="' . $rating . '"/>
                                                </div>
                                            </div>
                                        </li>-->    <li><span class="font700 h6"><i class="far fa-hourglass"></i>' . $row->days . ' Days</span></li>
                                    </ul>
                                </div>';
                    $reshfix .= '<div class="col-md-6">
                               <ul class="item-meta mt-15">
                                <li><span class="font700 h6">seats left:</span> <span class="font400 h6">' . $difffb . '</span></li>
                               
                            </ul>
                               <form method="post" action="' . BASE_URL . 'book/package/' . $row->slug . '">
                                    <input type="hidden" name="date" value="' . date('Y-m-d', strtotime($fixeddata->package_date)) . '">
                                    <input type="hidden" name="price" value="' . $fixeddata->package_rate . '">
                                    <input type="hidden" name="fixed_date_id" value="' . $fixeddata->id . '">
                                    <input type="hidden" name="max_pax" value="' . $difffb . '">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm mt-3 btn-contact-page">Book now</button>
                                </form></div></div>';
                }
                $reshfix .= '
                            <!-- <ul class="item-meta mt-15">
                                <li><span class="font700 h6">' . $row->days . ' Days</span></li>
                                <li>
                                    <p class="mt-3">Price from <span class="h6 line-1 text-primary font16">$ ' . $row->price . '</span>
                                        <span class="text-muted mr-5"></span></p>
                                </li>
                            </ul>-->
                        </figcaption>';
                if (!empty($row->accomodation)) {
                    $reshfix .= '<p class="featured-trip1 d-none">';
                    $routes = explode(',', $row->accomodation);
                    $limitedRoutes = array_slice($routes, 0, 4); // limit to first 4 items
                    $lastRoute = end($limitedRoutes);

                    foreach ($limitedRoutes as $route) {
                        $reshfix .= ($lastRoute == $route) ? $route : $route . ' -> ';
                    }

                    $reshfix .= '</p>';
                }
                if (!empty($row->difficulty)) {
                    switch ($row->difficulty) {
                        case 'Easy':
                            $reshfix .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3 tt" title="' . $row->difficulty . '" alt="Difficulty">';
                            break;
                        case 'Moderate':
                            $reshfix .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3 tt" title="' . $row->difficulty . '" alt="Difficulty">';
                            break;
                        case 'Moderate To Strenous':
                            $reshfix .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3 tt" title="' . $row->difficulty . '" alt="Difficulty">';
                            break;
                        case 'Strenous':
                            $reshfix .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3 tt" title="' . $row->difficulty . '" alt="Difficulty">';
                            break;
                        case 'Very Strenous':
                            $reshfix .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3 tt" title="' . $row->difficulty . '" alt="Difficulty">';
                            break;
                    }
                }
                $reshfix .= '    
                    </a>
                </figure>
            </div>
        ';
            }
        }
    }
}

$jVars['module:package-fixedHome'] = $reshfix;

?>
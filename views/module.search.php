<?php
$destination = $activity = $days = '';

if (isset($_REQUEST)) {
    foreach ($_REQUEST as $key => $val) {
        $$key = $val;
    }
}

$resisearch = $respkglist = $bread = $bread_title = $bread_text = $bread_text_extra = $navigation = $realtedarticle = '';

if (defined('SEARCH_PAGE')) {

    /* search page search form start*/
    /* destination filter start*/
    $destination_filter = '';
    $destinationRec = Destination::get_destination();

    // Check if any destination is selected
    $has_selected = !empty($gdestination_slug) || !empty($qdestination[0]);

    foreach ($destinationRec as $destinationRow) {
        // Determine if current destination is selected
        if (!empty($gdestination_slug)) {
            $sel = ($gdestination_slug == $destinationRow->slug) ? 'checked' : '';
        } else {
            $sel = (!empty($qdestination) && in_array($destinationRow->id, $qdestination)) ? 'checked' : '';
        }

        // If some are selected, show only the checked ones
        if ($has_selected && $sel !== 'checked') {
            continue;
        }

        $tot = Package::get_total_destination_packages($destinationRow->id);
        $destination_filter .= '
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input qdestination" name="qdestination[]" ' . $sel . ' id="dest-' . $destinationRow->id . '" value="' . $destinationRow->id . '">
                    <label class="custom-control-label d-flex justify-content-between" for="dest-' . $destinationRow->id . '">' . $destinationRow->title . ' <span class="checkbox-count">' . $tot . '</span></label>
                </div>
        ';
    }
    /* destination filter end*/

    /* activites filter start*/
    $activities_filter = '';

    // Determine selected destination ID
    $selected_destination_id = null;
    if (@$gdestination_slug) {
        $selected_destination = Destination::find_by_slug($gdestination_slug); // You must have this method
        $selected_destination_id = $selected_destination->id ?? null;
    } elseif (!empty($qdestination)) {
        $selected_destination_id = $qdestination[0]; // If you support multiple, loop as needed
    }

    // Fetch activities
    if ($selected_destination_id) {
        // Get only activities under selected destination
        $ActivitiesRec = Activities::get_activities_by_destination($selected_destination_id);
    } else {
        // No destination selected – get all activities
        $ActivitiesRec = Activities::get_activities_parent();
    }

    foreach ($ActivitiesRec as $ActivitiesRow) {
        if (@$gactivity_slug) {
            $sel = (@$gactivity_slug == $ActivitiesRow->slug) ? 'checked' : '';
        } else {
            $sel = (@$qactivities[0] == $ActivitiesRow->id) ? 'checked' : '';
        }
        $tot = 0;
        $tot += Package::get_total_activities_packages($ActivitiesRow->id);
        $activities_filter .= '
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input qactivities" name="qactivities[]" ' . $sel . ' id="acti-' . $ActivitiesRow->id . '" value="' . $ActivitiesRow->id . '">
                    <label class="custom-control-label d-flex justify-content-between" for="acti-' . $ActivitiesRow->id . '">' . $ActivitiesRow->title . ' <span class="checkbox-count">' . $tot . '</span></label>
                </div>
        ';
    }
    /* activites filter end*/

    /* Activity (Difficulty) Level filter start*/
    $difficulty_filter = '';
    $difficultyRec = array(
        '1' => 'Easy',
        '2' => 'Moderate',
        '3' => 'Moderate To Strenous',
        '4' => 'Strenous',
        '5' => 'Very Strenous'
    );

    // Determine selected destination
    $selected_destination_id = null;
    if (!empty($gdestination_slug)) {
        $selected_destination = Destination::find_by_slug($gdestination_slug); // must exist
        $selected_destination_id = $selected_destination->id ?? null;
    } elseif (!empty($qdestination)) {
        $selected_destination_id = $qdestination[0]; // support one for now
    }

    foreach ($difficultyRec as $k => $v) {
        $sel = (@in_array($k, @$gdifficulty)) ? 'checked' : '';
        $tot = 0;

        // Build base query
        $sql = "SELECT id FROM tbl_package WHERE difficulty='" . $v . "' AND status=1";

        // Add destination condition if selected
        if ($selected_destination_id) {
            $sql .= " AND FIND_IN_SET(" . (int)$selected_destination_id . ", destinationId)";
        }

        // Get count
        $tot = $db->num_rows($db->query($sql));
        $difficulty_filter .= '
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input gdifficulty" name="gdifficulty[]" ' . $sel . ' id="diff-' . $k . '" value="' . $k . '">
                    <label class="custom-control-label d-flex justify-content-between" for="diff-' . $k . '">' . $v . ' <span class="checkbox-count">' . $tot . '</span></label>
                </div>
        ';
    }
    /* Activity Level filter end*/

    /* Price Range start*/
    $price_filter = '';
    $priceRec = array('1000' => 'Below USD 1000', '2000' => 'USD 1000 - 2000', 'morethan2000' => 'USD 2000 above');
    foreach ($priceRec as $k => $v) {
        $sel = ($k == @$gprice) ? 'checked' : '';
        $price_filter .= '
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input gprice" name="gprice" ' . $sel . ' id="price-' . $k . '" value="' . $k . '">
                <label class="custom-control-label d-flex justify-content-between" for="price-' . $k . '">' . $v . ' <span class="checkbox-count">(123)</span></label>
            </div>
        ';
    }
    /* Price Range end*/

    /* Duration start*/
    $duration_filter = '';
    $durationRec = array(
        '5' => '1-5 Days',
        '10' => '6-10 Days',
        '15' => '11-15 Days',
        'morethan15' => 'More than 15 Days'
    );

    // Determine selected destination
    $selected_destination_id = null;
    if (@$gdestination_slug) {
        $selected_destination = Destination::find_by_slug($gdestination_slug); // must exist
        $selected_destination_id = $selected_destination->id ?? null;
    } elseif (!empty($qdestination)) {
        $selected_destination_id = $qdestination[0]; // or loop if multiple
    }

    foreach ($durationRec as $k => $v) {
        $sel = ($k == @$days) ? 'checked' : '';
        $tot = 0;
        // Base SQL
        $sql = "SELECT id FROM tbl_package WHERE status=1";
        switch ($k) {
            case '5':
                $sql .= " AND days <= 5";
                break;
            case '10':
                $sql .= " AND days > 5 AND days <= 10";
                break;
            case '15':
                $sql .= " AND days > 10 AND days <= 15";
                break;
            case 'morethan15':
                $sql .= " AND days >= 16";
                break;
        }
        // Append destination filter if selected
        if ($selected_destination_id) {
            $sql .= " AND FIND_IN_SET(" . (int)$selected_destination_id . ", destinationId)";
        }

        $tot = $db->num_rows($db->query($sql));
        $duration_filter .= '
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input gdays" name="days" ' . $sel . ' id="days-' . $k . '" value="' . $k . '">
                        <label class="custom-control-label d-flex justify-content-between" for="days-' . $k . '">' . $v . ' <span class="checkbox-count">' . $tot . '</span></label>
                    </div>
        ';
    }
    /* Duration end*/

    $resisearch .= '
        <aside class="sidebar-wrapper pv">
        <!--<div class="secondary-search-box mb-30">-->
            <!--<h4 class="">Search</h4>-->
            <form action="' . BASE_URL . 'searchlist" method="post" id="search_form">
    ';
    if (isMobile()) {
        $resisearch .= '
            <div id="accordion mobile-view" style="display:none;">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Destination
                            </button>
                        </h5>
                    </div>
    
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="box-content">
                                ' . $destination_filter . '
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Activities
                            </button>
                        </h5>
                    </div>
                    
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            <div class="box-content">
                                ' . $activities_filter . '
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Duration
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                        <div class="card-body">
                            <div class="box-content">
                                ' . $duration_filter . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    else {
        $resisearch .= '
                <div class="sidebar-box">
                    <div class="box-title"><h5>Destination</h5></div>
                    <div class="box-content">
                        ' . $destination_filter . '
                    </div>
                </div>

                <div class="sidebar-box">
                    <div class="box-title"><h5>Activities</h5></div>
                    <div class="box-content">
                        ' . $activities_filter . '
                    </div>
                </div>
                
                <div class="sidebar-box">
                    <div class="box-title"><h5>Duration</h5></div>
                    <div class="box-content">
                        ' . $duration_filter . '
                    </div>
                </div>

                <div class="sidebar-box">
                    <div class="box-title"><h5>Activity Level</h5></div>
                    <div class="box-content">
                        ' . $difficulty_filter . '
                    </div>
                </div>

                <!--<div class="sidebar-box">
                    <div class="box-title"><h5>Price Range</h5></div>
                    <div class="box-content">
                        ' . $price_filter . '
                    </div>
                </div>-->
        ';
    }
    $resisearch .= '                
            </form>
        </aside>
    ';
    /* search page search form end*/

    global $db;
    /*$sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.difficulty, pkg.accomodation,
            act.title as activity, act.slug as activity_slug, 
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            INNER JOIN tbl_activities act 
            ON pkg.activityId = act.id 
            WHERE pkg.status=1 ";*/
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.offer_price, pkg.difficulty, pkg.accomodation,
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            INNER JOIN tbl_activities act 
            ON pkg.activityId = act.id
            WHERE pkg.status=1 ";

    if (!empty($qdestination[0]) and @$qdestination[0] != 'all') {
        foreach ($qdestination as $qdest) {
            if (sizeof($qdestination) > 1) {
                if (array_values($qdestination)[0] == $qdest) {
                    $sql .= " AND ( pkg.destinationId = $qdest ";
                } elseif (end($qdestination) == $qdest) {
                    $sql .= " OR pkg.destinationId = $qdest )";
                } else {
                    $sql .= " OR pkg.destinationId = $qdest ";
                }
            } else {
                $sql .= " AND pkg.destinationId = $qdest ";
            }
        }
    }
    if (@$gdestination_slug) {
        $dest = Destination::find_by_slug($gdestination_slug);
        $sql .= " AND pkg.destinationId = $dest->id ";
    }

    if (!empty($qactivities[0]) and @$qactivities[0] != 'all') {
        foreach ($qactivities as $qact) {
            if (sizeof($qactivities) > 1) {
                if (array_values($qactivities)[0] == $qact) {
                    $sql .= " AND ( act.id = '$qact' ";
                } elseif (end($qactivities) == $qact) {
                    $sql .= " OR act.id = '$qact' )";
                } else {
                    $sql .= " OR act.id = '$qact' ";
                }
            } else {
                $sql .= " AND act.id = '$qact' ";
            }
        }
    }
    if (@$gactivity_slug) {
        $act = Activities::find_by_slug($gactivity_slug);
        $sql .= " AND pkg.activityId = $act->id ";
    }

    if (!empty($gdifficulty)) {
        foreach ($gdifficulty as $gdiff) {
            if (sizeof($gdifficulty) > 1) {
                if (array_values($gdifficulty)[0] == $gdiff) {
                    $sql .= " AND ( pkg.difficulty = $gdiff ";
                } elseif (end($gdifficulty) == $gdiff) {
                    $sql .= " OR pkg.difficulty = $gdiff )";
                } else {
                    $sql .= " OR pkg.difficulty = $gdiff ";
                }
            } else {
                $sql .= " AND pkg.difficulty = $gdiff ";
            }
        }
    }
    if (!empty($days)) {
        switch ($days) {
            case '5':
                $sql .= " AND pkg.days <= $days ";
                break;
            case '10':
                $sql .= " AND ( pkg.days > 5 AND pkg.days <= $days ) ";
                break;
            case '15':
                $sql .= " AND ( pkg.days > 10 AND pkg.days <= $days ) ";
                break;
            case 'morethan15':
                $sql .= " AND pkg.days >= 16 ";
                break;
        }
    }
    if (!empty($gprice)) {
        switch ($gprice) {
            case '1000':
                $sql .= " AND pkg.price <= $gprice ";
                break;
            case '2000':
                $sql .= " AND (pkg.price > 1000 AND pkg.price <= $gprice)";
                break;
            case 'morethan2000':
                $sql .= " AND pkg.price > 2000 ";
                break;
        }
    }

    /* Breadcrumb Start*/
    if (!empty($gdestination_slug)) {
        $destt = Destination::find_by_slug($gdestination_slug);
        $total = Package::get_total_destination_packages($destt->id);
        $imgs = unserialize($destt->gallery);
        if ($imgs != "a:0:{}") {
            $file_path = SITE_ROOT . 'images/destination/gallery/' . $imgs[0];
            if (file_exists($file_path)) {
                $bread .= '<style>.about-banner{background: linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)),url(' . IMAGE_PATH . 'destination/gallery/' . $imgs[0] . ');background-repeat: no-repeat;
    background-size: cover;position:relative;}</style>';
            }
        }
        $bread .= '
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item one"><a href="' . BASE_URL . 'destination-list">Destination</a></li>
                        <li class="breadcrumb-item two active" aria-current="page">' . $destt->title . '</li>
                    </ol>
                </nav>
                <!--<h4 class="mt-0 line-125 title-breadcrum">' . $total . ' Trip Packages in ' . $destt->title . '</h4>-->
        ';
        if ($destt->id == 11) {
            $bread_title .= '
                <h2><span><span style="color:#3a3838">Packages for ' . $destt->title . '</span></span></h2>
            ';
        } else {
            $bread_title .= '
                <h2>' . $destt->title . ' Packages</h2>
            ';
        }
        $brief = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', $destt->content);
        $content = !empty($brief[1]) ? $brief[1] : $brief[0];
        $bread_text .= '
                <h2>' . $destt->title . '</h2>';
        if (!empty($destt->title_brief)) {
            $bread_text .= '
                <p>' . $destt->title_brief . '
                    <!--<a href="#" id="read_more">Read More</a>-->
                </p>
            ';
        }
        if (!empty($destt->content)) {
            $bread_text_extra .= '
               <!-- <h4>' . $destt->title . '</h4>-->
                    ' .  $content . '
            ';
        }
         $relateddetails=Articles::find_all_category($destt->id);
        if(!empty($relateddetails)){
            $realtedarticle .='
            <div class="section-title search-title1">
                    
                <h2>Top Destination in  '. $destt->title . '</h2>
            
                </div>';
                 $realtedarticle .='
                 <div class="">
                    <div class="row">
                        <div class="col-md-12 popular1 article-below">
                            <div class="row d-flex equal-height cols-1 cols-sm-2 cols-lg-3 gap-20 mb-30">';
            foreach($relateddetails as $relateddetail){
          $imgNm = '';
        $file_path = SITE_ROOT . 'images/articles/' . $relateddetail->image;
        if (file_exists($file_path) and !empty($relateddetail->image)) {
            $imgNm .= IMAGE_PATH . 'articles/' . $relateddetail->image;
        } else {
            $imgNm .= IMAGE_PATH . 'static/article-banner.jpg';
        }
          $realtedarticle .= '<div class="col">
                    <figure class="tour-grid-item-01" style="width:100%">
                        <a href="' . BASE_URL  .'pages/'. $relateddetail->slug . '">
                            
                                    <div class="image">
                                        <img src="'.$imgNm.'" alt="' . $relateddetail->title . '"/>
                                    </div>
                              
                                    <figcaption class="content">
                                        <h5 class="">' .$relateddetail->title. ' </h5>
                             </a>           
               
                    </div>
                ';

            }
            $realtedarticle .='</div>
                        </div>
                    </div>
            </div>';
        }
    }
    if (!empty($qdestination[0])) {
        if ($qdestination[0] == 'all') {
            $total = Package::get_total_destination_packages(10);
            $bread .= '
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item one"><a href="' . BASE_URL . 'destination-list">Destination</a></li>
                        <li class="breadcrumb-item two active" aria-current="page">All</li>
                    </ol>
                </nav>
                <!--<h4 class="mt-0 line-125 title-breadcrum">' . $total . ' Trip Packages in Nepal</h4>-->
        ';
        
        } else {
            $destt = Destination::find_by_id($qdestination[0]);
            $total = Package::get_total_destination_packages($destt->id);
            $imgs = unserialize($destt->gallery);
            if ($imgs != "a:0:{}") {
                $file_path = SITE_ROOT . 'images/destination/gallery/' . $imgs[0];
                if (file_exists($file_path)) {
                    $bread .= '<style>.about-banner{background: linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)),url(' . IMAGE_PATH . 'destination/gallery/' . $imgs[0] . ') !important;}</style>';
                }
            }
            $bread .= '
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item one"><a href="' . BASE_URL . 'destination-list">Destination</a></li>
                        <li class="breadcrumb-item two active" aria-current="page">' . $destt->title . '</li>
                    </ol>
                </nav>
                <!--<h4 class="mt-0 line-125 title-breadcrum">' . $total . ' Trip Packages in ' . $destt->title . '</h4>-->
            ';
            if ($qdestination[0] == 11) {
                $bread_title .= '
                <h2><span><span style="color:#3a3838">Packages for ' . $destt->title . '</span></span></h2>
                ';
            } else {
                $bread_title .= '
                <h2>' . $destt->title . ' Packages</h2>
                ';
            }
            $brief = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', $destt->content);
        $content = !empty($brief[1]) ? $brief[1] : $brief[0];
        $bread_text .= '
                <h2>' . $destt->title . '</h2>';
        if (!empty($destt->title_brief)) {
            $bread_text .= '
                <p>' . $destt->title_brief . '
                    <!--<a href="#" id="read_more">Read More</a>-->
                </p>
            ';
        }
        if (!empty($destt->content)) {
            $bread_text_extra .= '
         <!--       <h4>' . $destt->title . '</h4>-->
                    ' .  $content . '
            ';
        }
        }
            $relateddetails=Articles::find_all_category($destt->id);
        if(!empty($relateddetails)){
            $realtedarticle .='<div class="section-title search-title1"><h4>Top Destination in  '. $destt->title . '</h4></div>';
             $realtedarticle .='
                 <div class="">
                    <div class="row">
                        <div class="col-md-12 popular1 article-below">
                            <div class="row d-flex equal-height cols-1 cols-sm-2 cols-lg-3 gap-20 mb-30">';
            foreach($relateddetails as $relateddetail){
          $imgNm = '';
        $file_path = SITE_ROOT . 'images/articles/' . $relateddetail->image;
        if (file_exists($file_path) and !empty($relateddetail->image)) {
            $imgNm .= IMAGE_PATH . 'articles/' . $relateddetail->image;
        } else {
            $imgNm .= IMAGE_PATH . 'static/article-banner.jpg';
        }
          $realtedarticle .= '<div class="col-md-4">
                    <figure class="tour-grid-item-01">
                        <a href="' . BASE_URL  . $relateddetail->slug . '">
                            
                                    <div class="image">
                                        <img src="'.$imgNm.'" alt="' . $relateddetail->title . '"/>
                                    </div>
                              
                                    <figcaption class="content">
                                        <h5 class="">' .$relateddetail->title. ' </h5>
                             </a>           
               
                    </div>
                ';

        }
         $realtedarticle .='</div>
                        </div>
                    </div>
            </div>';
    }
    }
    if (!empty($gactivity_slug)) {
        $totalIds = Activities::get_id_by_slug($gactivity_slug);
        $tot = 0;
        foreach ($totalIds as $totalId) {
            $tot += Package::get_total_activities_packages($totalId->id);
        }
        $actt = Activities::find_by_slug($gactivity_slug);
        $destt = Destination::find_by_id($actt->destinationId);
        if (!empty($actt->banner_image)) {
            $file_path = SITE_ROOT . 'images/activities/banner/' . $actt->banner_image;
            if (file_exists($file_path)) {
                $bread .= '<style>.about-banner{background: linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)),url(' . IMAGE_PATH . 'activities/banner/' . $actt->banner_image . ') !important;}</style>';
            }
        }
        $bread .= '
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item one"><a href="' . BASE_URL . 'activity-list/' . $destt->slug . '">Activity</a></li>
                        <li class="breadcrumb-item two active" aria-current="page">' . $actt->title . '</li>
                    </ol>
                </nav>
                <!--<h4 class="mt-0 line-125 title-breadcrum">' . $tot . ' Trip Packages in ' . $actt->title . '</h4>-->
        ';
        $bread_title .= '
            <h2><span><span style="color:#3a3838">' . $actt->title . ' Packages</span></span></h2>
        ';
       
        
                $brief = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', $actt->content);
        $content = !empty($brief[1]) ? $brief[1] : $brief[0];
        $bread_text .= '
                <h2>' . $actt->title . '</h2>';
        if (!empty($actt->title_brief)) {
            $bread_text .= '
                <p>' . $actt->title_brief . '
                 <!--<a href="#" id="read_more">Read More</a>-->
                </p>
            ';
        }
        if (!empty($destt->content)) {
            $bread_text_extra .= '
             <!--   <h4>' . $actt->title . '</h4>-->
                    ' .  $content . '
            ';
        }

    }
    /* Breadcrumb End*/

    $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
    $limit = 15;
    $total_num = $db->num_rows($db->query($sql));
    $startpoint = ($page * $limit) - $limit;
    $start = $startpoint + 1;
    $end = (($startpoint + $limit) > $total_num) ? $total_num : $startpoint + $limit;

    $sql .= " ORDER BY pkg.sortorder ASC";
    $sql .= " LIMIT " . $startpoint . "," . $limit;

    $res = $db->query($sql);
    $total = $db->affected_rows($res);
//     echo '<pre>'; print_r($sql); die();
    if ($total > 0) {
        while ($rows = $db->fetch_array($res)) {
            if (file_exists(SITE_ROOT . 'images/package/' . $rows['image'])) {
                $sql = "SELECT AVG(rating) 'rating' FROM tbl_review WHERE package_id=" . $rows['id'];
                $ratingObj = $db->fetch_object($db->query($sql));
                $rating_float = (float)$ratingObj->rating;
                $rating_floor = floor($rating_float);
                $rating = ($rating_float <= ($rating_floor + 0.5)) ? ($rating_floor + 0.5) : (ceil($rating_float));
                $days = ($rows['days'] == 1) ? 'day' : 'days';
                
                $price_text = '';
                if (!empty($rows['price']) and (empty($rows['offer_price']))) {
                    $price_text = '<p class="home-price">Starting USD ' . $rows['price'] . '</p>';
                }
                if (!empty($rows['offer_price'])) {
                    $price_text = '<p class="home-price">Starting USD <del>' . $rows['price'] . '</del> ' . $rows['offer_price'] . '</p>';
                }
        
                $respkglist .= '<div class="col-md-4">
                    <figure class="tour-grid-item-01">
                        <a href="' . BASE_URL . 'package/' . $rows['slug'] . '">
                            
                                    <div class="image">
                                        <img src="' . IMAGE_PATH . 'package/' . $rows['image'] . '" alt="' . $rows['title'] . '"/>
                                        ' . $price_text . '
                                    </div>
                              
                                    <figcaption class="content">
                                        <h5 class="">' .substr($rows['title'] , 0, 45). ' </h5>
                                        <ul class="item-meta mt-15">
                                            <li>
                                                <!--<i class="elegent-icon-pin_alt text-warning"></i>-->
                                                <i class="far fa-map pr-2"></i>' . $rows['destination'] . '
                                            </li>
                                            <!--<li>
                                                <div class="rating-item rating-sm rating-inline clearfix">
                                                    <div class="rating-icons">
                                                        <input type="hidden" class="rating"
                                                               data-filled="rating-icon ri-star rating-rated"
                                                               data-empty="rating-icon ri-star-empty"
                                                               data-fractions="2" data-readonly
                                                               value="' . $rating . '"/>
                                                    </div>
                                                </div>
                                            </li>-->
                                            <li ><i class="far fa-hourglass pr-2"></i> ' . $rows['days'] . ' ' . $days . ' </li >
                                        </ul>
                                        <!--<p>' . $rows['breif'] . ' </p >-->
                                        
                                    </figcaption >';
                if (!empty($rows['accomodation'])) {
                    $respkglist .= '<p class="featured-trip1 d-none">';
                    $routes = explode(',', $rows['accomodation']);
                    $limitedRouts = array_slice($routes, 0, 4);
                    foreach ($limitedRouts as $route) {
                        if (end($limitedRouts) == $route) {
                            $respkglist .= $route;
                        } else {
                            $respkglist .= $route . ' -> ';
                        }
                    }
                    $respkglist .= '</p>';
                }
                if (!empty($rows['difficulty'])) {
                    switch ($rows['difficulty']) {
                        case 'Easy':
                            $respkglist .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3">';
                            break;
                        case 'Moderate':
                            $respkglist .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3">';
                            break;
                        case 'Moderate To Strenous':
                            $respkglist .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3">';
                            break;
                        case 'Strenous':
                            $respkglist .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3">';
                            break;
                        case 'Very Strenous':
                            $respkglist .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3">';
                            break;
                    }
                }
                $respkglist .= '
                        </a >
                    </figure >
                    </div>
                ';

            }
        }
        $navigation .= '
                    <div class="pager-innner">
                        <div class="row align-items-center text-center text-lg-left">
                            <div class="col-12 col-lg-5">
                                Showing result ' . $start . ' to ' . $end . ' from ' . $total_num . '
                            </div>
                            <div class="col-12 col-lg-7">';
        $navigation .= get_front_pagination_for_search($total_num, $limit, $page, BASE_URL . 'searchlist');
        $navigation .= '
                            </div>
                        </div>
                    </div>
        ';
    } else {
        $respkglist .= '
            <figure class="tour-long-item-01">
                <h3>No Result Found</h3>
             </figure>';
    }
    /*}else{
        $url = BASE_URL.'pages / errors';
        redirect_to($url);
    }*/
}

$jVars['module:search-searchform'] = $resisearch;
$jVars['module:package-search-breadcrumb'] = $bread;
$jVars['module:package-search-breadcrumb-title'] = $bread_title;
$jVars['module:package-search-breadcrumb-text'] = $bread_text;
$jVars['module:package-search-breadcrumb-extra'] = $bread_text_extra;
$jVars['module:package-search-related-extra'] = $realtedarticle;
$jVars['module:package-searchlist'] = $respkglist;
$jVars['module:package-navigation'] = $navigation;
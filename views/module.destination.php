<?php
/*
* Destination list for home section
*/
$resdest = '';
$destRec = Destination::getDestinationlist(4);
if ($destRec) {
    foreach ($destRec as $destRow) {
        $resdest .= '<div class="box_first">
	    	<img src="' . IMAGE_PATH . 'destination/' . $destRow->image . '" alt="' . $destRow->title . '">
    		<a href="' . BASE_URL . 'destination/' . $destRow->slug . '">
    			<span>' . $destRow->title . '</span>
    		</a>
	    </div>';
    }
}

$jVars['module:destination-list'] = $resdest;

/*
* Destination list for footer section
*/
$resdestfooter = '';
$destRec = Destination::getfooterDestination(4);
if ($destRec) {
    $resdestfooter .= '<ul>';
    foreach ($destRec as $destRow) {
        $resdestfooter .= '<li>
		    	<i class="fa fa-check"></i> 
		    	<a href="' . BASE_URL . 'destination/' . $destRow->slug . '">' . $destRow->title . '</a>
		    </li>';
    }
    $resdestfooter .= '</ul>';
}

$jVars['module:footer-destination'] = $resdestfooter;


$resdestbdc = $resdestbanner = $resdest = $resdestactv = '';
if (defined('DESTINATION_PAGE') and !empty($_REQUEST['slug'])) {
    $slug = addslashes($_REQUEST['slug']);
    $recRow = Destination::find_by_slug($slug);
    if ($recRow) {

        // Breadcrumb section
        $imgNm = '';
        if ($recRow->gallery != "a:0:{}" and !empty($recRow->gallery)) {
            $imageList = unserialize($recRow->gallery);
            $imgno = array_rand($imageList);
            $file_path = SITE_ROOT . 'images/destination/gallery/' . $imageList[$imgno];
            if (file_exists($file_path)) {
                $imgNm .= IMAGE_PATH . 'destination/gallery/' . $imageList[$imgno];
            } else {
                $imgNm = IMAGE_PATH . 'static/destination-img.jpg';
            }
        } else {
            $imgNm = IMAGE_PATH . 'static/destination-img.jpg';
        }
        $resdestbdc .= '<style>div.inner_banner{background:url(' . $imgNm . ') no-repeat center center;}</style>';

        $resdestbdc .= '<h2><span>' . $recRow->title . '</span></h2>
		<ul>
		    <li><a href="' . BASE_URL . 'home">Home</a></li>
		    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
		    <li><a href="javascript:void(0);">Destination</a></li>
		    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
		    <li><a href="javascript:void(0);">' . $recRow->title . '</a></li>
		</ul>';

        // Content section
        $resdest .= '';
        $art_img = SITE_ROOT . 'images/destination/' . $recRow->image;
        if (!empty($recRow->image) and file_exists($art_img)) {
            $resdest .= '<div class="col-sm-6 pull-right">
					<img class="img-responsive img-full" src="' . IMAGE_PATH . 'destination/' . $recRow->image . '" alt="' . $recRow->title . '">
				</div>';
        }
        $resdest .= '<div class=""> 
				' . $recRow->content . '
			</div>
		</div>';

        // Sidebar Related activities list
        $actRec = Activities::get_actitvityby($recRow->id, 0);
        if ($actRec) {
            $resdestactv .= '<section>
		        <div class="rows pad-bot-redu">
		            <div class="container">
		                <!-- TITLE & DESCRIPTION -->
		                <div class="spe-title">
		                    <h2> <span>All</span> Activities</h2>
		                    <div class="title-line">
		                        <div class="tl-1"></div>
		                        <div class="tl-2"></div>
		                        <div class="tl-3"></div>
		                    </div>
		                    <p>' . $recRow->title_brief . '</p>
		                </div>
		                <div>';
            foreach ($actRec as $actRow) {
                $resdestactv .= '<div class="col-md-3 col-sm-6 col-xs-12 b_packages">
								<a href="' . BASE_URL . 'activities/' . $recRow->slug . '/' . $actRow->slug . '"><div class="v_place_img">
									<img src="' . IMAGE_PATH . 'activities/' . $actRow->image . '" alt="' . $actRow->title . '">
									<h4>' . $actRow->title . '</h4>
								</div></a>
								<!--<div class="b_pack rows">
									<div class="col-md-12 col-sm-12">
										<h4>' . $actRow->title . '</h4>
										<a href="' . BASE_URL . 'activities/' . $recRow->slug . '/' . $actRow->slug . '" class="link-btn hom-hot-view-btn pull-right">Details</a>
									</div>
								</div>-->
							</div>';
            }

            $resdestactv .= '</div>
		            </div>
		        </div>
		    </section>';
        } else {
            $packageRec = Package::get_filterpkg_by($recRow->id);
            if ($packageRec) {
                $resdestactv .= '<section>
			        <div class="rows pad-bot-redu tb-space">
			            <div class="container">
			                <!-- TITLE & DESCRIPTION -->
			                <div class="spe-title">
			                    <h2> <span>' . $recRow->title . '</span> Packages</h2>
			                    <div class="title-line">
			                        <div class="tl-1"></div>
			                        <div class="tl-2"></div>
			                        <div class="tl-3"></div>
			                    </div>
			                    <p>' . $recRow->title_brief . '</p>
			                </div>
			                <div>';
                foreach ($packageRec as $packageRow) {
                    $file_path = SITE_ROOT . 'images/package/' . $packageRow->image;
                    if (file_exists($file_path) and !empty($packageRow->image)) {
                        $activity = Activities::field_by_id($packageRow->activityId, 'title');
                        $resdestactv .= '<div class="col-md-4">
							            <div class="to-ho-hotel-con">
							                <div class="to-ho-hotel-con-1">
							                    <div class="hom-hot-av-tic">
							                        ' . $activity . ' 
							                    </div>
							                    <img src="' . IMAGE_PATH . 'package/' . $packageRow->image . '" alt="' . $packageRow->title . '">
							                </div>
							                <div class="to-ho-hotel-con-23">
							                    <div class="to-ho-hotel-con-2">
							                        <h4>' . $packageRow->title . '</h4>
							                    </div>
							                    <div class="to-ho-hotel-con-3">
							                        <ul>
							                            <li>
							                                Duration : ' . $packageRow->days . ' Days <br />
							                                Gread : ' . $packageRow->gread . '
							                            </li>
							                            <li><span class="ho-hot-pri">' . $packageRow->currency . ' ' . $packageRow->price . '</span>
							                            </li>
							                        </ul>
							                    </div>
							                    <div class="to-ho-hotel-con-4">
							                        <a href="' . BASE_URL . 'book/package/' . $packageRow->slug . '" class="link-btn hom-hot-book-btn">Book Now</a>
							                        <a href="' . BASE_URL . 'package/' . $packageRow->slug . '" class="link-btn hom-hot-view-btn">View More</a>
							                    </div>
							                </div>
							            </div>
							        </div>';
                    }
                }

                $resdestactv .= '</div>
			            </div>
			        </div>
			    </section>';
            }
        }

    } else {
        $url = BASE_URL . 'pages/errors';
        redirect_to($url);
    }
}

$jVars['module:destination-breadcrumb'] = $resdestbdc;
$jVars['module:destination-details'] = $resdest;
$jVars['module:destination-activities'] = $resdestactv;


// Destination listing
$dest_bread = $dest_list = '';
$destinations = Destination::find_all();
if (defined('DESTINATION_PAGE')) {
    if ($destinations) {
        $dest_bread .= '
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="#">Destination</a></li>
                </ol>
            </nav>
        ';

        foreach ($destinations as $destination) {
            $img = '';
            /*
            $images = unserialize($destination->gallery);
            if(is_array($images) and !empty($images)){
                $file_path = SITE_ROOT.'images/destination/gallery/'.$images[0];
                if(file_exists($file_path)){
                    $img = '
                        <div class="image">
                            <img src="'.IMAGE_PATH.'destination/gallery/'.$images[0].'" alt="'.$destination->title.'" style="height:450px"/>
                        </div>
                    ';
                }
            }
            */
            $file_path = SITE_ROOT . "images/destination/" . @$destination->image;
            $img = (!empty($destination->image) and file_exists($file_path)) ? IMAGE_PATH . "destination/" . $destination->image : IMAGE_PATH . "static/home-destination.jpg";
            $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />',$destination->content);
            $dest_list .= '
                <div class="col">
                    <figure class="tour-grid-item-01">
                        <a href="'.BASE_URL.'destination/'.$destination->slug.'">
                            <div class="image">
                                <img src="'.$img.'" alt="'.$destination->title.'" style="height:450px"/>
                            </div>
                            <figcaption class="content ">
                                <h5 style="font-size:20px; min-height:36px;" >'.$destination->title.'</h5>
                                '.$content[0].'
                            </figcaption>
                        </a>
                    </figure>
                </div>
            ';
        }
    }
}

$jVars['module:destination-list-breadcrumb'] = $dest_bread;
$jVars['module:destination-list'] = $dest_list;
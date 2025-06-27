<?php
/*
* Module Package 
* Package::get_databy_display(column name, status, limit);
*/

/* Package Display Using Home Flag */
$reshome= '';
$homeRec = Package::get_databy_display('homepage',1,6);
if(!empty($homeRec)) {
	foreach($homeRec as $RecRow){
		$file_path = SITE_ROOT.'images/package/'.$RecRow->image;
	    if(file_exists($file_path) and !empty($RecRow->title)) {       
        $activity = Activities::field_by_id($RecRow->activityId, 'title');
        $reshome.='<div class="col-md-4">
            <div class="to-ho-hotel-con"><a href="'.BASE_URL.'package/'.$RecRow->slug.'">
                <div class="to-ho-hotel-con-1">
                    <div class="hom-hot-av-tic">
                        '.$activity.' 
                    </div>
                    <img src="'.IMAGE_PATH.'package/'.$RecRow->image.'" alt="'.$RecRow->title.'">
                </div></a>
                <div class="to-ho-hotel-con-23">
                    <div class="to-ho-hotel-con-2">
                        <a href="'.BASE_URL.'package/'.$RecRow->slug.'" class=""><h4>'.$RecRow->title.'</h4></a>
                    </div>
                    <div class="to-ho-hotel-con-3">
                        <ul>
                            <li>
                                Duration : '.$RecRow->days.' Days <br />
                                Difficulty : '.set_na($RecRow->difficulty).'
                            </li>
                        </ul>
                    </div>
                    <div class="to-ho-hotel-con-4">
                        <a href="'.BASE_URL.'book/package/'.$RecRow->slug.'" class="link-btn hom-hot-book-btn">Book Now</a>
                        <a href="'.BASE_URL.'package/'.$RecRow->slug.'" class="link-btn hom-hot-view-btn">View More</a>
                    </div>
                </div>
            </div>
        </div>';
	    }
	}
}

$jVars['module:package-home'] = $reshome;

/* package display using Fixed flag */
$resfix= '';

    $RecNews = Package::get_databy_display('fixed',1);

    // how many records should be displayed on a page?
    $records_per_page = 6;

    // instantiate the pagination object
    $pagination = new Pagination2();

    // set position of the next/previous page links
    $pagination->navigation_position(isset($_GET['navigation_position']) && in_array($_GET['navigation_position'], array('left', 'right')) ? $_GET['navigation_position'] : 'outside');

    // the number of total records is the number of records in the array
    $pagination->records(count($RecNews));

    // records per page
    $pagination->records_per_page($records_per_page);

    // here's the magick: we need to display *only* the records for the current page
    $RecNews = array_slice(
        $RecNews,                                             //  from the original array we extract
        (($pagination->get_page() - 1) * $records_per_page),    //  starting with these records
        $records_per_page                                       //  this many records
    );
if(!empty($RecNews)) {
    foreach($RecNews as $index => $FixRow){
        $file_path = SITE_ROOT.'images/package/'.$FixRow->image;
        if(file_exists($file_path) and !empty($FixRow->title)) {       
        $activity = Activities::field_by_id($FixRow->activityId, 'title');
        $resfix.='<div class="col-md-4">
            <div class="to-ho-hotel-con"><a href="'.BASE_URL.'package/'.$FixRow->slug.'">
                <div class="to-ho-hotel-con-1">
                    <div class="hom-hot-av-tic">
                        '.$activity.' 
                    </div>
                    <img src="'.IMAGE_PATH.'package/'.$FixRow->image.'" alt="'.$FixRow->title.'">
                </div>
                <div class="to-ho-hotel-con-23">
                    <div class="to-ho-hotel-con-2">
                        <h4>'.$FixRow->title.'</h4>
                    </div></a>
                    <div class="to-ho-hotel-con-3">
                        <ul>
                            <li>
                                Duration : '.$FixRow->days.' Days <br />
                                Difficulty : '.set_na($FixRow->difficulty).'
                            </li>
                        </ul>
                    </div>
                    <div class="to-ho-hotel-con-4">
                        <a href="'.BASE_URL.'book/package/'.$FixRow->slug.'" class="link-btn hom-hot-book-btn">Book Now</a>
                        <a href="'.BASE_URL.'package/'.$FixRow->slug.'" class="link-btn hom-hot-view-btn">View More</a>
                    </div>
                </div>
            </div>
        </div>';
        }
    }
    // render the pagination links
    $resfix.= '<div class="clear"></div><div class="col-sm-12">'.$pagination->render().'</div>';
}

$jVars['module:package-fixed'] = $resfix;

/*fixed departure above testimonial
*/
$fixedlist='';
$fixRec = Package::get_databy_display('fixed',1,18);
if(!empty($fixRec)) {
      foreach($fixRec as $FixRow){
        // echo "<pre>";print_r($FixRow);
        // echo $FixRow->title;
        $file_path = SITE_ROOT.'images/package/'.$FixRow->image;
        if(file_exists($file_path) and !empty($FixRow->title)) {        
 if(!empty($FixRow->date)){
$fixedlist.='<div class="dpt"><a class="link" href="'.BASE_URL.'package/'.$FixRow->slug.'">
            <div class="row">';

           
               
                   $fixedlist.='<div class="col-xs-4 date">'.$FixRow->date.'</div>
                <div class="col-xs-8 title">'.$FixRow->title.'</div>';
                
              
                
         

            $fixedlist.=' </div></a></div>';
              }      
        }
    }
}

$jVars['module:dept-fixed'] = $fixedlist;

/* Package Display Using Feature Flag */
$resfeature= '';

$featureRec = Package::get_databy_display('featured',1,6);
if(!empty($featureRec)) {
    foreach($featureRec as $fetRow){
        $file_path = SITE_ROOT.'images/package/'.$fetRow->image;
        if(file_exists($file_path) and !empty($fetRow->title)) {       
        $activity = Activities::field_by_id($fetRow->activityId, 'title');
        $resfeature.='<div class="col-md-4">
            <div class="to-ho-hotel-con"><a href="'.BASE_URL.'package/'.$fetRow->slug.'">
                <div class="to-ho-hotel-con-1">
                    <div class="hom-hot-av-tic">
                        '.$activity.' 
                    </div>
                    <img src="'.IMAGE_PATH.'package/'.$fetRow->image.'" alt="'.$fetRow->title.'">
                </div>
                <div class="to-ho-hotel-con-23">
                    <div class="to-ho-hotel-con-2">
                        <h4>'.$fetRow->title.'</h4>
                    </div></a>
                    <div class="to-ho-hotel-con-3">
                        <ul>
                            <li>
                                Duration : '.$fetRow->days.' Days <br />
                                Difficulty : '.set_na($fetRow->difficulty).'
                            </li>
                        </ul>
                    </div>
                    <div class="to-ho-hotel-con-4">
                        <a href="'.BASE_URL.'book/package/'.$fetRow->slug.'" class="link-btn hom-hot-book-btn">Book Now</a>
                        <a href="'.BASE_URL.'package/'.$fetRow->slug.'" class="link-btn hom-hot-view-btn">View More</a>
                    </div>
                </div>
            </div>
        </div>';
        }
    }
}

$jVars['module:package-feature'] = $resfeature;


// sidebar feature package
$respkg_feature='';

$featureRec = Package::get_databy_display('featured',1,6);
if(!empty($featureRec)) {
    foreach($featureRec as $pkgfRow) {
        $file_path = SITE_ROOT.'images/package/'.$pkgfRow->image;
        if(file_exists($file_path) and !empty($pkgfRow->image)) { 
            $respkg_feature.='<div class="hotel-small style-2 clearfix">
                <a class="hotel-img black-hover" href="'.BASE_URL.'package/'.$pkgfRow->slug.'">
                    <img class="img-responsive radius-0" src="'.IMAGE_PATH.'package/'.$pkgfRow->image.'" alt="'.$pkgfRow->title.'">
                    <div class="tour-layer delay-1"></div>                              
                </a>
                <div class="hotel-desc">
                    <h4><a href="'.BASE_URL.'package/'.$pkgfRow->slug.'">'.$pkgfRow->title.'</a></h4>
                    <div class="tour-info-line">
                        <div class="tour-info">
                            <img src="'.BASE_URL.'template/web/img/calendar_icon_grey.png" alt="Image not Found">
                            <span class="font-style-2 color-dark-2">'.$pkgfRow->days.'</span>
                        </div>                  
                    </div>                                                                          
                </div>
            </div>';
        }
    }
}

$jVars['module:package-featureside']  = $respkg_feature;

// Package Detail section 
$respkg_breadcrumb=$respkg_detail='';
if(defined('PACKAGE_PAGE')) {
    $slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug']))? addslashes($_REQUEST['slug']):'';
    $pkgRec = Package::find_by_slug($slug);
    $destslug = Destination::field_by_id($pkgRec->destinationId, 'slug');

    if(!empty($pkgRec)) {

        $dsRec = Destination::find_by_slug($destslug);
        $respkg_breadcrumb.='<h2><span>'.$pkgRec->title.'</span></h2>
        <ul>
            <li><a href="'.BASE_URL.'home">Home</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li><a href="'.BASE_URL.'destination/'.$destslug.'">'.$dsRec->title.'</a></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li><a href="javascript:void(0);">'.$pkgRec->title.'</a></li>
        </ul>';

        // Details
        $respkg_detail.='<section>
            <div class="rows banner_book" id="inner-page-title">
                <div class="container">
                    <div class="banner_book_1">
                        <ul>
                            <li class="dl1">Location : '.$dsRec->title.'</li>
                            <li class="dl2">Activity : '.Activities::field_by_id($pkgRec->activityId,'title').'</li>
                            <li class="dl3">Duration : '.$pkgRec->days.'</li>
                            <li class="dl4"><a href="'.BASE_URL.'book/package/'.$pkgRec->slug.'">Book Now</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="rows inn-page-bg com-colo">
                <div class="container inn-page-con-bg tb-space">
                    <div class="col-md-9">
                        <div class="tour_head">
                            <h2>'.$pkgRec->title.'</h2>
                        </div>';

                        $imgall = unserialize($pkgRec->gallery);
                        if(!empty($imgall)) {
                            $i=0;$imgnav=$imgmn='';
                            foreach($imgall as $k=>$imgname) {
                                $img_path = SITE_ROOT.'images/package/gallery/'.$imgname;
                                if(file_exists($img_path)){
                                    $imgnav.='<li data-target="#myCarousel1" data-slide-to="'.$i.'"><img src="'.IMAGE_PATH.'package/gallery/'.$imgname.'" alt="amit prajapati"></li> ';
                                    $imgmn.='<div class="item '.(($i==0)?'active':'').'">
                                        <img src="'.IMAGE_PATH.'package/gallery/'.$imgname.'" alt="amit prajapati" width="460" height="345">
                                    </div>';
                                }
                            $i++;}
                            $respkg_detail.='<div class="tour_head1 hotel-book-room">
                                <h3>Photo Gallery</h3>
                                <div id="myCarousel1" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators carousel-indicators-1">
                                        '.$imgnav.'
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner carousel-inner1" role="listbox">                     
                                        '.$imgmn.'
                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel1" role="button" data-slide="prev">
                                        <span><i class="fa fa-angle-left hotel-gal-arr" aria-hidden="true"></i></span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel1" role="button" data-slide="next">
                                        <span><i class="fa fa-angle-right hotel-gal-arr hotel-gal-arr1" aria-hidden="true"></i></span>
                                    </a>
                                </div>                        
                            </div>';
                        }                        

                        if(!empty($pkgRec->overview)) {
                            $respkg_detail.='<div class="tour_head1">
                                <h3>Overview</h3>
                                '.$pkgRec->overview.'
                            </div>';
                        }

                        if(!empty($pkgRec->itinerary)) {
                            $respkg_detail.='<div class="tour_head1">
                            <h3>Short Itinerary</h3>
                            '.$pkgRec->itinerary.'
                        </div>';
                        }

                        if(!empty($pkgRec->availability)) {
                            $respkg_detail.='<div class="tour_head1">
                                <h3>Itinerary</h3>
                                '.$pkgRec->availability.'
                            </div>';
                        }

                        if(!empty($pkgRec->incexc)) {
                            $respkg_detail.='<div class="tour_head1">
                                <h3>Includes</h3>
                                '.$pkgRec->incexc.'
                            </div>';
                        }

                        if(!empty($pkgRec->booking_info)) {
                            $respkg_detail.='<div class="tour_head1">
                                <h3>Excludes</h3>
                                '.$pkgRec->booking_info.'
                            </div>';
                        }

                        if(!empty($pkgRec->other_info)) {
                            $respkg_detail.='<div class="tour_head1">
                                <h3>Others Information</h3>
                                '.$pkgRec->other_info.'
                            </div>';
                        } 

                    $respkg_detail.='</div>

                    <div class="col-md-3 tour_r">
                        <div class="tour_right tour_incl tour-ri-com">
                            <h3>Trip Fact</h3>
                            <ul>
                                <li>Trip Duration : '.$pkgRec->days.'</li>
                                <li>Arrival Date: '.$pkgRec->startpoint.'</li>
                                <li>Departure Date: '.$pkgRec->endpoint.'</li>
                                <li>Highest Altitude : '.$pkgRec->altitude.' m</li>
                                <li>Difficulty : '.set_na($pkgRec->difficulty).'</li>
                                <li>Grade : '.set_na($pkgRec->gread).'</li>
                                <li>Season : '.set_na($pkgRec->season).'</li>
                                <li>Destination : '.$dsRec->title.'</li>
                                <li>Activity : '.Activities::field_by_id($pkgRec->activityId,'title').'</li>
                            </ul>
                        </div>

                        

                        <div class="tour_right head_right tour_help tour-ri-com">
                            <h3>Help & Support</h3>
                            <div class="tour_help_1">
                                <h4 class="tour_help_1_call">Call Us Now</h4>
                                <h4><i class="fa fa-phone" aria-hidden="true"></i> '.$siteRegulars->contact_info.'</h4>
                            </div>
                        </div>

                        <div class="tour_right tour_rela tour-ri-com">
                            <h3>Popular Packages</h3>';
                            $featureRec = Package::get_databy_display('featured',1,6);
                            if(!empty($featureRec)) {
                                foreach($featureRec as $pkgfRow) {
                                    $file_path = SITE_ROOT.'images/package/'.$pkgfRow->image;
                                    if(file_exists($file_path) and !empty($pkgfRow->image)) { 
                                        $respkg_detail.='<div class="tour_rela_1">
                                            <img src="'.IMAGE_PATH.'package/'.$pkgfRow->image.'" alt="'.$pkgfRow->title.'"/>
                                            <h4>'.$pkgfRow->title.'</h4>
                                            <p>Duration : '.$pkgfRow->days.'</p>
                                            <a href="'.BASE_URL.'package/'.$pkgfRow->slug.'" class="link-btn">View this Package</a>
                                        </div>';
                                    }
                                }
                            }                          
                        $respkg_detail.='</div>

                    </div>

                </div>
            </div>
        </section>';

    }else{
        $url = BASE_URL.'pages/errors';
        redirect_to($url);
    }
}

$jVars['module:package-breadcrumb'] = $respkg_breadcrumb;
$jVars['module:package-detail']   = $respkg_detail;



// Fixed package for home
$reshfix='';
$sql = "SELECT pd.package_currency, pd.package_rate, MIN(pd.package_date) AS package_date, p.slug, p.title, p.image, p.tags, p.breif, p.days, p.gread, p.pdate, p.destinationId, p.activityId FROM tbl_package_date AS pd 
    INNER JOIN tbl_package AS p ON pd.package_id = p.id 
    WHERE 
    p.status='1' AND pd.status='1' AND package_date>=CURDATE() GROUP BY pd.package_id ORDER BY package_date ASC  LIMIT 4 ";
$query = $db->query($sql);
$totl = $db->num_rows($query);   
if($totl>0) { 
    while($row=$db->fetch_object($query)) { 
        $reshfix.='<div class="dpt">
            <a class="link" href="'.BASE_URL.'package/'.$row->slug.'">
                <div class="row">
                    <div class="col-xs-4 date">'.date('d M Y', strtotime($row->package_date)).'</div>
                    <div class="col-xs-8 title">'.$row->title.'</div> 
                </div>
            </a>
        </div>';
    }
}

$jVars['module:package-fixedHome'] = $reshfix;
?>
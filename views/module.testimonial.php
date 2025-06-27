<?php
/*
* Testimonial module
*/

// $tmonialRec = Review::find_for_homepage();
$tmonialRec = Testimonial::get_alltestimonial();

// Home Testimonial
$tstmresult = $tstmresult_old = '';
$image='';
if ($tmonialRec) {
    foreach ($tmonialRec as $row) {
        if(!empty($row->image)){
            $image= IMAGE_PATH . 'testimonial/' . $row->image;       
        }
        else{
            $image= BASE_URL . 'template/web/default.png'; 
        }
        $linkstart = (!empty($row->linksrc)) ? '<a href="' . $row->linksrc . '" target="_blank">' : '';
        $linkend = (!empty($row->linksrc)) ? '</a>' : '';
        $tstmresult .= '
                <div class="slick-item">
					<div class="testimonial-grid-01">
						<div class="content">
							<p class="saying">' . strip_tags($row->content) . '</p>
						</div>
						
						<div class="man clearfix">
							<div class="image">
								<img src="' .$image. '" alt="' . $row->name . '" class="img-circle"/>
							</div>
							
							<div class="texting">
								<h5>' . $row->name . '</h5>
								<p class="text-muted testimonial-cite">' . $row->country . '</p>
							</div>
						</div>
					</div>
				</div>
		';
		$tstmresult_old .='
				
                <div class="slick-item border-btm-dadada d-none hide">
                    <div class="testimonial-grid-01">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="texting">
                                <h5>' . $row->name . '</h5>
                                <ul class="item-meta">
                                    <li>
                                        <i class="elegent-icon-pin_alt text-warning"></i> ' . $row->country . '
                                    </li>
                                    <!--<li>|</li>
                                    <li>
                                        <p class="text-muted testimonial-cite"> 
                                        </p>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="content">
                                <p class="saying">' . strip_tags($row->content) . '</p>
                            </div>
                        </div>
                        <div class="col-md-1">
                            ' . $linkstart . '<div class="image">
                                <img src="' . IMAGE_PATH . 'testimonial/' . $row->image . '" alt="' . $row->name . '" class="img-circle"/>
                            </div>' . $linkend . '
                        </div>
                    </div>
                        

                        <div class="man clearfix">';
        $file_path = SITE_ROOT . 'images/package/review/' . $row->image;
        if (file_exists($file_path)):
            $tstmresult_old .= '
                        <!--<div class="image">
                            <img src="' . IMAGE_PATH . 'package/review/' . $row->image . '" alt="' . $row->name . '" class="img-circle"/>
                        </div>-->
                        ';
        else:
            $tstmresult_old .= '
                    <!--<div class="image">
                        <img src="' . IMAGE_PATH . 'static/no-pic.jpg" alt="' . $row->name . '" class="img-circle"/>
                    </div>-->
                    ';
        endif;
        $tstmresult_old .= '
                        <!--<div class="texting">
                            <h5>' . $row->name . '</h5>
                            <ul class="item-meta">
                                <li>
                                    <i class="elegent-icon-pin_alt text-warning"></i> ' . $row->country . '
                                </li>
                                <li>|</li>
                                <li>
                                    <p class="text-muted testimonial-cite"> </p>
                                </li>
                            </ul>
                        </div>-->
                    </div>
                </div>
            </div>
             ';
    }
}

$jVars['module:testimonial-list'] = $tstmresult;

/*
* Testimonial listing
*/
$reststmo = '';

if (defined('TESTIMONIAL_PAGE')) {
    $tlistRec = Testimonial::get_alltestimonial();
    if ($tlistRec) {
        $reststmo .= '<ul class="testimonial_detail">';
        foreach ($tlistRec as $tlistRow) {
            $reststmo .= '<li>';
            $file_path = SITE_ROOT . 'images/testimonial/' . $tlistRow->image;
            if (file_exists($file_path)):
                $reststmo .= '<div class="testimonial_img">
                        <img src="' . BASE_URL . 'phpthumb/phpThumb.php?w=241&h=150&src=' . IMAGE_PATH . 'testimonial/' . $tlistRow->image . '&zc=1"  title="' . $tlistRow->name . '" />                                             
                    </div>';
            endif;
            $reststmo .= '<div class="testimonail_det">' . $tlistRow->content . '
                <span>- ' . $tlistRow->name . ', ' . $tlistRow->country . '</span></div>
            </li>';
        }
        $reststmo .= '</ul>';
    }
}

$jVars['module:testimonialdetail'] = $reststmo;

$testimono = '';

$tstRand = Testimonial::get_alltestimonial();
if (!empty($tstRand)) {
    $testimono .= '<div class="testimonial-slider owl-carousel">';
    foreach ($tstRand as $testim) {


        $testimono .= '
<div class=" slider-item text-center">
                        <p>"' . ($testim->content) . '"</p>';
        $file_path = SITE_ROOT . 'images/testimonial/' . $testim->image;
        if (file_exists($file_path)):
            $testimono .= '<div class="testimonial_img text-center">
                                    <img style="width:50px;display: initial;" src="' . IMAGE_PATH . 'testimonial/' . $testim->image . '"  title="' . $testim->name . '" />                                           
                                </div>';
        endif;
        $testimono .= '<h5 >' . $testim->name . '</h5><h5 class="text-center"><i>-' . $testim->country . '</i></h5> 
                    </div>';
    }
    $testimono .= '</div>';
}
$jVars['module:testimonial-rand'] = $testimono;


?>
<?php
/* 
* Module Slideshow
*/

$nav = $simg = $reslide = '';
$Records = Slideshow::getSlideshow_by(0);

if (!empty($Records)) {
    $reslide .= '<div id="myCarousel" class="carousel slide" data-ride="carousel">';
    $i = 0;
    foreach ($Records as $RecRow) {
        $file_path = SITE_ROOT . 'images/slideshow/' . $RecRow->image;
        if (file_exists($file_path) and !empty($RecRow->image)) {
            $linkTarget = ($RecRow->linktype == 1) ? ' target="_blank" ' : '';
            $linksrc = ($RecRow->linktype != 1) ? BASE_URL . $RecRow->linksrc : $RecRow->linksrc;
            $linkstart = ($RecRow->linksrc != '') ? '<a href="' . $linksrc . '" ' . $linkTarget . ' class="hs1 wow fadeInUp" data-wow-duration="2.0s">' : '<a href="javascript:void(0);" class="hs1 wow fadeInUp" data-wow-duration="2.0s">';
            $linkend = ($RecRow->linksrc != '') ? '</a>' : '</a>';
            $nav .= '<li data-target="#myCarousel" data-slide-to="' . $i . '" class= " ' . (($i == '0') ? 'active' : '') . '"></li>';
            $simg .= '<style>#slide-' . $RecRow->id . '{background: url("' . IMAGE_PATH . 'slideshow/' . $RecRow->image . '"); background-size:cover; }</style>
				<div class="item ' . (($i == '0') ? 'active' : '') . '" id="slide-' . $RecRow->id . '">		            
		            <div class="carousel-caption slider-cap">
		                <h1 class="wow fadeInDown" data-wow-duration="1s">' . $RecRow->title . '</h1>
		                
		            </div>
		        </div>';
        }
        $i++;
    }
    $reslide .= '<!-- Indicators -->
	    <ol class="carousel-indicators">
	        ' . $nav . '
	    </ol>
	    <div class="carousel-inner" role="listbox">
	        ' . $simg . '

	    </div>
	</div>';
}

$jVars['module:slideshow'] = $reslide;


/**
 * Home page video
 */
$home_slide = '';
$slides = Slideshow::getSlideshow_by(0);

if (!empty($slides)) {
    foreach ($slides as $slide) {
        $home_slide .= '
            <video autoplay muted loop>
                <source src="' . IMAGE_PATH . 'slideshow/video/' . $slide->source . '" type="video/mp4">
            </video>
        ';
    }
}

$jVars['module:home-slideshow'] = $home_slide;
?>
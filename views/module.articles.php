<?php
/*
* Articles Module
*/
$resbcumb = '';
$resartcle = '';

if (defined('ARTICLE_PAGE')) {
    $page = isset($_REQUEST['slug']) ? addslashes($_REQUEST['slug']) : '';
    $Record = Articles::getArticles($page);
    if ($Record) {
        // Banner image
        $imgNm = '';
        $file_path = SITE_ROOT . 'images/articles/' . $Record->image;
        if (file_exists($file_path) and !empty($Record->image)) {
            $imgNm .= IMAGE_PATH . 'articles/' . $Record->image;
        } else {
            $imgNm .= IMAGE_PATH . 'static/article-banner.jpg';
        }

        // For Title and breadcrumb
        $resbcumb .= '
            <div class="page-title mb-0 about-banner about-gallery-banner" style="background:linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)),url(' . $imgNm . ');background-repeat: no-repeat;
    background-size: cover;
    position: relative;">
                <div class="container">
                    <div class="row gap-15 align-items-center bread123">
                        <div class="col-12 col-md-7 about-bread">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">' . $Record->title . '</li>
                                </ol>
                            </nav>
                            <!--<h4 class="mt-0 line-125 title-breadcrum">' . $Record->title . '</h4>-->
                        </div>
                    </div>
                </div>
            </div>
            
            ';

        // Detail
        $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($Record->content));
        $content = implode("", $content);
        $resartcle .= '
            <div class="container">
                <h2 class="text-center" style="font-weight: 400;color: #000;">' . $Record->type . '</h2>
                ' . $content . '';

        $reviews = Review::find_all();
        $happy_clients = sizeof($reviews);
        $expeditions_total = Package::get_total_by_activity_id(56);
        $tour1 = Package::get_total_by_activity_id(59);
        $tour2 = Package::get_total_by_activity_id(58);
        $tour_total = $tour1 + $tour2;
        $biking_total = Package::get_total_by_activity_id(57);
        $trek1 = Package::get_total_by_activity_id(54);
        $trek2 = Package::get_total_by_activity_id(60);
        $trek_total = ($trek1) + ($trek2);
        $ressss= '';
        $ressss .= '
                <section class="team" data-aos="fade-up">
                <div class="container">
                    <div class="row cols-1 cols-sm-2 cols-lg-3 gap-20 gap-md-40">
                        <div class="a1b2" style="display:flex">
                            <div class="col card">
                                <div class="featured-icon-horizontal-01 clearfix">
                                    <div class="icon-font">
    				                    <!--<div class="counter" data-target="' . $expeditions_total . '">0</div>-->
    				                    <div class="counter" data-decimal-delimiter="," data-thousand-delimiter="," data-value="' . $expeditions_total . '">0</div>
    				                </div>
                                    <div class="content">
                        				<h6>No. of expediton</h6>
                        				<p class="text-muted">
                        					Make a climbing in the Himalayan range an unforgettable experience.</p>
                        			</div>
                                </div>
                            </div>
                            
                            <div class="col card">
                                <div class="featured-icon-horizontal-01 clearfix">
                                    <div class="icon-font">
    				                    <!--<div class="counter" data-target="' . $trek_total . '">0</div>-->
    				                    <div class="counter" data-decimal-delimiter="," data-thousand-delimiter="," data-value="' . $trek_total . '">0</div>
    				                </div>
                                    <div class="content">
                        				<h6>No. of Trekkings</h6>
                        				<p class="text-muted">
                        					Walk to specific the purpose of exploring and enjoying the scenery.</p>
                        			</div>
                                </div>
                            </div>
                            
                            <div class="col card">
                                <div class="featured-icon-horizontal-01 clearfix">
                                    <div class="icon-font">
    				                    <!--<div class="counter" data-target="' . $tour_total . '">0</div>-->
    				                    <div class="counter" data-decimal-delimiter="," data-thousand-delimiter="," data-value="' . $tour_total . '">0</div>
    				                </div>
                                    <div class="content">
                        				<h6>No. of Tours</h6>
                        				<p class="text-muted">
                        					Know the importance of sightseeing, mountains & pilgrimage sites.</p>
                        			</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </section>
            ';

        $resartcle .= '
            </div>
        ';
    } else {
        $resartcle .= '
        <div class="container">
            <h2 class="text-center mt-100" style="font-weight: 400;color: #000;">404</h2>
        </div>';
    }
}

$jVars['module:articlebcumb'] = $resbcumb;
$jVars['module:articlepage'] = $resartcle;


/*
/news list at homepage
*/
$reshome = '';
if (defined('HOME_PAGE')) {
    $rechome = Articles::homepageArticles(1);
    if ($rechome) {
        foreach ($rechome as $row) {
            $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', trim($row->content));
            $reshome .= $content[0];
        }
    }
}

$jVars['module:showhome'] = $reshome;
?>
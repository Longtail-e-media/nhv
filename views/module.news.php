<?php
/*
* News Module
*/

$resnwsbdc = $resnwsbanner = $resnwsdetails = '';

if (defined('NEWS_PAGE')) {
    $slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) ? addslashes($_REQUEST['slug']) : '';
    $newsRec = News::find_by_slug($slug);
    if ($newsRec) {
        // Banner section       
        if (file_exists(SITE_ROOT . 'images/news/banner/' . $newsRec->banner_image)) {
            $resnwsbanner .= '<section class="" style="background: rgba(0, 0, 0, 0) url(\'' . IMAGE_PATH . 'news/banner/' . $newsRec->banner_image . '\') no-repeat scroll center center / cover ;
height: 253px;"> </section>';
        } else {
            $resnwsbanner .= '<section class="" style="background: rgba(0, 0, 0, 0) url(\'' . IMAGE_PATH . 'banner.png\') no-repeat scroll center center / cover ;
height: 253px;"> </section>';
        }


        $resnwsbdc .= '<div class="news"><h2><span>' . $newsRec->title . '</span></h2>
		<ul>
		    <li><a href="' . BASE_URL . 'home">Home</a></li>
		    <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
		    <li><a href="javascript:void(0);">' . $newsRec->title . '</a></li>
		</ul>';


        /* End Breadcrumb block */

        if (file_exists(SITE_ROOT . 'images/news/' . $newsRec->image)) {
            $resnwsdetails .= '<div class="newsdetail"><img class="news_img" src="' . IMAGE_PATH . 'news/' . $newsRec->image . '" alt="' . $newsRec->title . '"/>';
        }
        $resnwsdetails .= '<div>' . $newsRec->content . '</div>';

    } /*else{
    	$url = BASE_URL.'pages/errors';
        redirect_to($url);
    }*/
}
$resnwsdetails .= '</div>';

$jVars['module:news-bannerimg'] = $resnwsbanner;
$jVars['module:news-breadcrumb'] = $resnwsbdc;
$jVars['module:news-details'] = $resnwsdetails;


$newssss = '';
if (defined('HOME_PAGE')) {
    // $idd=(isset($_REQUEST['id']) and !empty($_REQUEST['id']))? addslashes($_REQUEST['id']):'';
    $newsRec = News::getLatestNewsList(1);
    foreach ($newsRec as $newsCon) {
        $newssss .= '            
                    <div class="tips_left tips_left_1">
                        <h5>' . $newsCon->title . '</h5><small>' . date('M d, Y', strtotime($newsCon->news_date)) . '</small>
                        <p>' . $newsCon->brief . '</p>' . '<a class="btn btn-default btn-xs" href="' . BASE_URL . 'news/' . $newsCon->slug . '">+read more</a>
                    </div>
                ';

    }

}
$jVars['module:newsarea'] = $newssss;
?>
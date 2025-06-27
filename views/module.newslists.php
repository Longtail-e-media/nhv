<?php
/*
* News Lists Module
*/

$resnewslist = $resnewspgn = '';

if (defined('NEWSLIST_PAGE')) {

    $RecNews = News::get_news_by();

    // how many records should be displayed on a page?
    $records_per_page = 9;

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
    $resnewslist .= '<div class="row"><div class="newslist">';
    if ($RecNews) {
        foreach ($RecNews as $index => $newsCon) {

            $resnewslist .= '
<div class="col-sm-6"> <img class="news_img" src="' . IMAGE_PATH . 'news/' . $newsCon->image . '" alt="' . $newsCon->title . '"/>
				<h5><strong>' . $newsCon->title . '</strong></h5>On ' . $newsCon->news_date . '
                        <p>' . $newsCon->brief . '<a href="' . BASE_URL . 'news/' . $newsCon->slug . '">+read more</a> </p>
                   </div> ';
        }
        $resnewspgn .= '</div>';
        // render the pagination links
        $resnewspgn .= $pagination->render();
    }
}

$jVars['module:news-listing'] = $resnewslist;
$jVars['module:news-pagination'] = $resnewspgn;
?>
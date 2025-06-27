<?php
/*
* Activities Listing Page 
*/


// Activities listing according to Destination
$act_bread = $act_list = '';
if (defined('ACTIVITIES_PAGE') and !empty($_REQUEST['slug'])) {
    $slug = addslashes($_REQUEST['slug']);
    $destt = Destination::find_by_slug($slug);
    $activities = Activities::get_actitvityby($destt->id);

    if ($activities) {
        $imgs = unserialize($destt->gallery);
        if ($imgs != "a:0:{}") {
            $file_path = SITE_ROOT . 'images/destination/gallery/' . $imgs[0];
            if (file_exists($file_path)) {
                $act_bread .= '<style>.about-banner{background: linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)),url(' . IMAGE_PATH . 'destination/gallery/' . $imgs[0] . ') !important;}</style>';
            }
        }
        $act_bread .= '
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active"><a href="#">Activities</a></li>
                </ol>
            </nav>
        ';

        foreach ($activities as $activity) {
            $img = '';
            $file_path = SITE_ROOT . "images/activities/" . $activity->image;
            if (file_exists($file_path) and !empty($activity->image)) {
                $img = '
                    <div class="image">
                        <img src="' . IMAGE_PATH . 'activities/' . $activity->image . '" alt="' . $activity->title . '" style="height:450px"/>
                    </div>
                ';
            }
            $content = explode('<hr id="system_readmore" style="border-style: dashed; border-color: orange;" />', $activity->content);
            $act_list .= '
                <div class="col">
                    <figure class="tour-grid-item-01">
                        <a href="' . BASE_URL . 'activity/' . $activity->slug . '">
                            ' . $img . '
                            <figcaption class="content ">
                                <h5>' . $activity->title . '</h5>
                                </br>
                                ' . $content[0] . '
                            </figcaption>
                        </a>
                    </figure>
                </div>
            ';
        }
    } else {
        $act_list .= '
            <div class="col">
                No Activities Found
            </div>
        ';
    }
} else {
    $act_list .= '
            <div class="col">
                No Activities Found
            </div>
        ';
}

$jVars['module:activity-list-breadcrumb'] = $act_bread;
$jVars['module:activity-list'] = $act_list;
?>
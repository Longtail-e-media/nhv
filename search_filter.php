<?php
require_once("includes/initialize.php");

$result = $navigation = '';
if (isset($_POST['action']) and ($_POST['action'] == 'filter_data')) {

    foreach ($_POST as $key => $val) {
        $$key = $val;
    }

    global $db;
    /*
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.difficulty,pkg.accomodation,
            act.title as activity, act.slug as activity_slug, 
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            INNER JOIN tbl_activities act 
            ON pkg.activityId = act.id 
            WHERE pkg.status=1 ";
    */
    $sql = "SELECT pkg.id, pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.price, pkg.offer_price, pkg.difficulty, pkg.accomodation,
            dst.title as destination, dst.slug as destination_slug
            FROM tbl_package  pkg 
            INNER JOIN tbl_destination  dst 
            ON pkg.destinationId = dst.id 
            WHERE pkg.status=1 ";

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
    if (!empty($qdestination)) {
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
    if (!empty($qactivities)) {
        foreach ($qactivities as $qact) {
            if (sizeof($qactivities) > 1) {
                if (array_values($qactivities)[0] == $qact) {
                    //$sql .= " AND ( act.id = '$qact' ";
                    $sql .= " AND ( pkg.activityId = '$qact' ";
                } elseif (end($qactivities) == $qact) {
                    //$sql .= " OR act.id = '$qact' )";
                    $sql .= " OR pkg.activityId = '$qact' )";
                } else {
                    //$sql .= " OR act.id = '$qact' ";
                    $sql .= " OR pkg.activityId = '$qact' ";
                }
            } else {
                //$sql .= " AND act.id = '$qact' ";
                $sql .= " AND pkg.activityId = '$qact' ";
            }
        }
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

    $page = 1;
    $limit = 15;
    $total_num = $db->num_rows($db->query($sql));
    $startpoint = ($page * $limit) - $limit;
    $start = $startpoint + 1;
    $end = (($startpoint + $limit) > $total_num) ? $total_num : $startpoint + $limit;
    $sql .= " ORDER BY pkg.sortorder ASC";
    $sql .= " LIMIT " . $startpoint . "," . $limit;

    $res = $db->query($sql);
    $total = $db->affected_rows($res);

    if ($total > 0) {
        while ($rows = $db->fetch_array($res)) {
            if (file_exists(SITE_ROOT . 'images/package/' . $rows['image'])) {
                $rating = Package::get_avg_rating($rows['id']);
                $days = ($rows['days'] == 1) ? 'day' : 'days';

                $price_text = '';
                if (!empty($rows['price']) and (empty($rows['offer_price']))) {
                    $price_text = '<p class="home-price">Starting USD ' . $rows['price'] . '</p>';
                }
                if (!empty($rows['offer_price'])) {
                    $price_text = '<p class="home-price">Starting USD <del>' . $rows['price'] . '</del> ' . $rows['offer_price'] . '</p>';
                }

                $result .= '<div class="col">
                    <figure class="tour-grid-item-01">
                        <a href="' . BASE_URL . 'package/' . $rows['slug'] . '">
                                    <div class="image">
                                        <img src="' . IMAGE_PATH . 'package/' . $rows['image'] . '" alt="' . $rows['title'] . '"/>
                                        ' . $price_text . '
                                    </div>
                        
                                    <figcaption class="content">
                                        <h5 class="">' .substr($rows['title'], 0, 45). '</h5>
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
                                            <li ><span class="font700 h6" ><i class="far fa-hourglass"></i> ' . $rows['days'] . ' ' . $days . ' </span ></li >
                                        </ul>
                                        <!--<p>' . $rows['breif'] . ' </p >-->
                                        
                                    </figcaption >';
                if (!empty($rows['accomodation'])) {
                    $result .= '<p class="featured-trip1">';
                    $routes = explode(',', $rows['accomodation']);
                    $limitedRouts = array_slice($routes, 0, 4);
                    foreach ($limitedRouts as $route) {
                        if (end($limitedRouts) == $route) {
                            $result .= $route;
                        } else {
                            $result .= $route . ' -> ';
                        }
                    }
                    $result .= '</p>';
                }
                if (!empty($rows['difficulty'])) {
                    switch ($rows['difficulty']) {
                        case 'Easy':
                            $result .= '<img src="' . IMAGE_PATH . 'static/meter/1.png" class="new-img3">';
                            break;
                        case 'Moderate':
                            $result .= '<img src="' . IMAGE_PATH . 'static/meter/2.png" class="new-img3">';
                            break;
                        case 'Moderate To Strenous':
                            $result .= '<img src="' . IMAGE_PATH . 'static/meter/3.png" class="new-img3">';
                            break;
                        case 'Strenous':
                            $result .= '<img src="' . IMAGE_PATH . 'static/meter/4.png" class="new-img3">';
                            break;
                        case 'Very Strenous':
                            $result .= '<img src="' . IMAGE_PATH . 'static/meter/5.png" class="new-img3">';
                            break;
                    }
                }
                $result .= '
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
        $result .= '
            <figure class="tour-long-item-01">
                 <h3>No Result Found</h3>
             </figure>';
    }

    echo json_encode(array("action" => "success", "result" => $result, "nav" => $navigation));
}

?>
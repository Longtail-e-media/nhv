<?php

/**
 * Display Blogs in Homepage
 **/
$home_blog = '';

if (defined("HOME_PAGE")) {
    $blogs = CombinedNews::find_all(4);
    foreach ($blogs as $blog) {
        $img = '';
        if (!empty($blog->image)) {
            $file_path = SITE_ROOT . "images/combinednews/" . $blog->image;
            if (file_exists($file_path)) {
                $img = IMAGE_PATH . "combinednews/" . $blog->image;
            } else {
                $img = IMAGE_PATH . "static/home-blog.jpg";
            }
        } else {
            $img = IMAGE_PATH . "static/home-blog.jpg";
        }
        $home_blog .= '
            <div class="col-md-3 col-sm-3 col-xs-12">
                <a class="box_news" href="' . BASE_URL . 'blog/' . $blog->slug . '">
                    <figure>
                        <img src="' . $img . '" alt="' . $blog->title . '">
                        <!--<figcaption><strong>' . date('d', strtotime($blog->event_stdate)) . '</strong>' . date('M', strtotime($blog->event_stdate)) . '</figcaption>-->
                    </figure>
                    <div class="white-re">
                    <h4>' . $blog->title . '</h4>
                    <!--' . $blog->brief . '-->
                    <ul>
                        <li>' . $blog->author . '</li>
                        <li>|</li>
                        <li class="text-capitalize">' . date('F d, Y', strtotime($blog->event_stdate)) . '</li>
                    </ul>
                    </div>
                </a>
            </div>
        ';
    }
}

$jVars["module:home-blog"] = $home_blog;


/**
 * Blog listing page
 **/

$blog_list = $blog_list_breadcrumb = $blog_list_nav = '';
if (defined("BLOGLIST_PAGE")) {

    $blog_list_breadcrumb .= '
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Travel Blog</li>
                </ol>
            </nav>
    ';

    $page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"])) ? $_REQUEST["pageno"] : 1;
    $sql = "SELECT * FROM tbl_conbined_news WHERE status='1' ORDER BY event_stdate DESC";

    $limit = 4;
    $total = $db->num_rows($db->query($sql));
    $startpoint = ($page * $limit) - $limit;
    $sql .= " LIMIT " . $startpoint . "," . $limit;

    $blogs = CombinedNews::find_by_sql($sql);
    if ($blogs) {
        foreach ($blogs as $blog) {
            $img = '';
            if (!empty($blog->image)) {
                $file_path = SITE_ROOT . "images/combinednews/" . $blog->image;
                if (file_exists($file_path)) {
                    $img = IMAGE_PATH . "combinednews/" . $blog->image;
                } else {
                    $img = IMAGE_PATH . "static/home-blog.jpg";
                }
            } else {
                $img = IMAGE_PATH . "static/home-blog.jpg";
            }
            $blog_list .= '
                <article class="post-long-01">
                    <div class="d-flex flex-column flex-sm-row align-items-xl-center">
                        <div>
                            <div class="image">
                                <img src="' . $img . '" alt="' . $blog->title . '"/>
                            </div>
                        </div>
                        <div>
                            <div class="content">
                                <span class="post-date text-muted">' . date('M d, Y', strtotime($blog->event_stdate)) . '</span>
                                <h4>' . $blog->title . '</h4>
                                ' . $blog->brief . '
                                <a href="' . BASE_URL . 'blog/' . $blog->slug . '" class="h6">Read this <i class="elegent-icon-arrow_right"></i></a>
                            </div>
                        </div>
                    </div>
                </article>
            ';
        }
        $blog_list_nav .= get_front_pagination($total, $limit, $page, BASE_URL . 'blog');
    }
}

$jVars["module:blog-list:breadcrumb"] = $blog_list_breadcrumb;
$jVars["module:blog-list:list"] = $blog_list;
$jVars["module:blog-list:nav"] = $blog_list_nav;


/**
 * Blog Detail page
 **/

$blog_detail = $blog_breadcrumb = $recent_blogs = $comment_list = $blog_id = '';
if (defined("BLOG_PAGE")) {
    $slug = (isset($_REQUEST["slug"]) and !empty($_REQUEST["slug"])) ? $_REQUEST["slug"] : '';
    $blogRec = CombinedNews::find_by_slug($slug);
    if (!empty($blogRec)) {

        $blog_id = $blogRec->id;

        $banner_img = '';
        if (!empty($blogRec->banner_image)) {
            $file_path = SITE_ROOT . "images/combinednews/banner/" . $blogRec->banner_image;
            if (file_exists($file_path)) {
                $banner_img = IMAGE_PATH . "combinednews/banner/" . $blogRec->banner_image;
            } else {
                $banner_img = IMAGE_PATH . "static/article-banner.jpg";
            }
        } else {
            $banner_img = IMAGE_PATH . "static/article-banner.jpg";
        }

        $blog_breadcrumb .= '
            <div class="page-title mb-0 about-banner search-banner" style="background:linear-gradient(180deg, rgba(0, 0, 0, 0.22), rgba(0, 0, 0, 0.22)), url(' . $banner_img . ');">
                <div class="container">
                    <div class="row gap-15 align-items-center bread123">
                        <div class="col-12 col-md-7 search-bread">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active"><a href="' . BASE_URL . 'blog">Blogs</a></li>
                                    <!--<li class="breadcrumb-item active" aria-current="page">' . $blogRec->title . '</li>-->
                                </ol>
                            </nav>
                            <!--<h4 class="mt-0 line-125 title-breadcrum">' . $blogRec->title . '</h4>-->
                        </div>
                    </div>
                </div>
            </div>
        ';

        $images = unserialize($blogRec->gallery);
        if (!empty($images)) {
            $gallery_section = '
            <h4 class="text-capitalize line-125">' . $blogRec->title . '</h4>
            </br>
                <div class="slider single-item">
            ';
            foreach ($images as $image){
                $gallery_section.='
                    <div class="image mb-40">
                        <img src="' . IMAGE_PATH . 'combinednews/gallery/' . $image . '" alt="' . $blogRec->title . '"/>
                    </div>
                ';
            }
            $gallery_section.='  
                </div>
            ';
        }
        $blog_detail .= $gallery_section . '

            <div class="blog-single-heading">
                <!--<h4 class="text-capitalize line-125">' . $blogRec->title . '</h4>-->

                <div class="row gap-30">
                    <div class="col-12 col-sm-6">
                        <div class="col-inner">
                            <ul class="meta-list text-muted mb-20">
                                <li>by <a href="#">' . $blogRec->author . '</a></li>
                                <li>on ' . date('F d, Y', strtotime($blogRec->event_stdate)) . '</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 text-sm-right">
                        <div class="col-inner">
                            <h6>Share:</h6>
                            <div class="box-socials clearfix">
                                <a href="http://www.facebook.com/share.php?caption=' . $blogRec->slug . '&description=' . $blogRec->brief . '&u=' . BASE_URL . 'blog/' . $blogRec->slug . '&picture=' . IMAGE_PATH . 'combinednews/' . $blogRec->image . '/" 
                                class="" target="_blank">
                                    <i class="fab fa-facebook-square"></i>
                                </a>
                                <a href="https://twitter.com/share?url=' . BASE_URL . 'blog/' . $blogRec->slug . '/&text=' . $blogRec->title . '" class="" target="_blank">
                                    <i class="fab fa-twitter-square"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=' . BASE_URL . 'blog/' . $blogRec->slug . '" class="" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                                <!--<a href="#" class="text-muted">
                                    <i class="fab fa-pinterest-square"></i>
                                </a>
                                <a href="#" class="text-muted">
                                    <i class="fab fa-flickr"></i>
                                </a>-->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="blog-entry mt-0">
                ' . $blogRec->content . '
            </div>
            <div class="mb-50"></div>
        ';


        // Comments Section
        $comments = NewsComment::find_by_news($blogRec->id);
        if (!empty($comments)) {
            $comment_list .= '
                <h4 class="heading-title">
                    <span>Comments</span>
                </h4>
                <div class="comment-wrapper">
                    <ul class="comment-item">
            ';

            foreach ($comments as $comment) {
                $img = '';
                if (!empty($comment->image)) {
                    $file_path = SITE_ROOT . "images/newscomment/" . $comment->image;
                    if (file_exists($file_path)) {
                        $img = IMAGE_PATH . "newscomment/" . $comment->image;
                    } else {
                        $img = IMAGE_PATH . "static/no-pic.jpg";
                    }
                } else {
                    $img = IMAGE_PATH . "static/no-pic.jpg";
                }
                $comment_list .= '
                    <li>
                        <div class="comment-avatar">
                            <img src="' . $img . '" alt="' . $comment->person_name . '"/>
                        </div>
                        <div class="comment-header">
                            <p class="heading mt-0">' . $comment->person_name . '</p>
                            <!--<span class="comment-time">23 minutes</span>-->
                        </div>
                        <div class="comment-content">
                            <p>' . $comment->comment . '</p>
                        </div>
                    </li>
                ';
            }

            $comment_list .= '
                    </ul>
                        <div class="clear"></div>
                        <!--<div class="text-center">-->
                        <!--	<a href="#" class="btn btn-primary btn-sm">Load More</a>-->
                        <!--</div>-->
                    </div><!-- End Comment -->
                    <div class="mb-50"></div>
            ';
        }

    } else {
        $blog_breadcrumb .= '
            <div class="page-title mb-0 about-banner">
                <div class="container">
                    <div class="row gap-15 align-items-center">
                        <div class="col-12 col-md-7">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'home"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="' . BASE_URL . 'blog">Blogs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">No Blog Found</li>
                                </ol>
                            </nav>
                            <h4 class="mt-0 line-125 title-breadcrum">No Blog Found</h4>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $blog_detail .= '
            <div class="blog-single-heading">
                <h4 class="text-capitalize center line-125">No Blog Found</h4>
            </div>
        ';
    }

    $recentBlogs = CombinedNews::getRelatednews_by(@$blogRec->id, 6);
    if (!empty($recentBlogs)) {
        foreach ($recentBlogs as $recentBlog) {
            $img = '';
            if (!empty($recentBlog->image)) {
                $file_path = SITE_ROOT . "images/combinednews/" . $recentBlog->image;
                if (file_exists($file_path)) {
                    $img = IMAGE_PATH . "combinednews/" . $recentBlog->image;
                } else {
                    $img = IMAGE_PATH . "static/home-blog.jpg";
                }
            } else {
                $img = IMAGE_PATH . "static/home-blog.jpg";
            }
            $recent_blogs .= '
                <li class="clearfix">
                    <a href="' . BASE_URL . 'blog/' . $recentBlog->slug . '">
                        <div class="image">
                            <img src="' . $img . '" alt="' . $recentBlog->title . '"/>
                        </div>
                        <div class="content">
                            <p>' . $recentBlog->title . '</p>
                            <p class="recent-post-sm-meta"><i class="ri ri-calendar mr-5"></i>
                            ' . date('F d, Y', strtotime($recentBlog->event_stdate)) . '</p>
                        </div>
                    </a>
                </li>
            ';
        }
    }
}

$jVars["module:blog:id"] = $blog_id;
$jVars["module:blog:breadcrumb"] = $blog_breadcrumb;
$jVars["module:blog:details"] = $blog_detail;
$jVars["module:blog:comments"] = $comment_list;
$jVars["module:blog:recent-blogs"] = $recent_blogs;
?>
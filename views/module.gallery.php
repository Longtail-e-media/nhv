<?php
/*
* Gallery Module
*/
$galtitle = $resgal = $breadcrumb = $gallery_nav = '';

if (defined('GALLERY_PAGE')) {
    $slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) ? addslashes($_REQUEST['slug']) : '';
    $gallRec = Gallery::find_by_slug($slug);

    if ($gallRec) {
        $galtitle .= '<h3>Gallery / ' . $gallRec->title . '</h3>';

        $gaimgRec = GalleryImage::getImagelist_by($gallRec->id);
        if ($gaimgRec) {
            $resgal .= '<ul class="gallery_ul">';
            foreach ($gaimgRec as $gaimgRow) {
                $file_path2 = SITE_ROOT . 'images/gallery/galleryimages/' . $gaimgRow->image;
                if (file_exists($file_path2) and !empty($gaimgRow->image)) {
                    $resgal .= '<li class="gallery_block">
						<a href="' . IMAGE_PATH . 'gallery/galleryimages/' . $gaimgRow->image . '" title="' . $gaimgRow->title . '" class="gallerypopup">
							<img src="' . IMAGE_PATH . 'gallery/galleryimages/' . $gaimgRow->image . '" alt="' . $gaimgRow->title . '"/>
							<span>' . $gaimgRow->title . '</span>
						</a>
					</li>';
                }
            }
            $resgal .= '</ul>';
        } else {
            $resgal .= 'No Result Found !';
        }
    } else {
        $breadcrumb .= '
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="./home"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>

            <!--<h4 class="mt-0 line-125 title-breadcrum">Gallery</h4>-->
        ';

        $pgalRec = Gallery::getGallery();
        if ($pgalRec) {
            $gallery_nav .= '
                <li class="col-md active" data-class="all">ALL</li>
            ';
            foreach ($pgalRec as $pgalRow) {
                $gallery_nav .= '
                    <li class="col-md" data-class="' . $pgalRow->title . '">' . $pgalRow->title . '</li>
                ';
                $galleryImages = GalleryImage::getImagelist_by($pgalRow->id);
                if ($galleryImages) {
                    foreach ($galleryImages as $galleryImage) {
                        $file_path2 = SITE_ROOT . 'images/gallery/galleryimages/' . $galleryImage->image;
                        if (file_exists($file_path2) and !empty($galleryImage->image)) {
                            $resgal .= '
                                <div class="col-md-3 images" data-class="' . $pgalRow->title . '" data-src="' . IMAGE_PATH . 'gallery/galleryimages/' . $galleryImage->image . '">
                                    <img src="' . IMAGE_PATH . 'gallery/galleryimages/' . $galleryImage->image . '" alt="' . $galleryImage->title . '">
                                </div>
                            ';
                        }
                    }
                }
            }
        }
    }
}

$jVars['module:gallerytitle'] = $galtitle;
$jVars['module:gallery-breadcrumb'] = $breadcrumb;
$jVars['module:gallery-nav'] = $gallery_nav;
$jVars['module:gallery'] = $resgal;

?>
<?php
/*
* Hotels Module
*/
$reshtbanner=$reshtitle=$reshotels='';

if(defined('HOTELS_PAGE')){
	$slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug']))? addslashes($_REQUEST['slug']):'';
    $hotelsRec = Hotels::find_by_slug($slug);

    if($hotelsRec){
        // Banner section       
        if(file_exists(SITE_ROOT.'images/hotels/banner/'.$hotelsRec->banner_image) and !empty($hotelsRec->banner_image)){
            $reshtbanner.='<section class="" style="background: rgba(0, 0, 0, 0) url(\''.IMAGE_PATH.'hotels/banner/'.$hotelsRec->banner_image.'\') no-repeat scroll center center / cover ;
height: 253px;"> </section>';
        }else{
            $reshtbanner.='<section class="" style="background: rgba(0, 0, 0, 0) url(\''.IMAGE_PATH.'banner.png\') no-repeat scroll center center / cover ;
height: 253px;"> </section>';
        }

    	$reshtitle.='<h3>'.$hotelsRec->title.'</h3>'.strip_tags($hotelsRec->brief).'<br /><br />';

        $hchildRec = Hotels::find_all_byparnt($hotelsRec->id);
        if($hchildRec){
            $reshotels.='<ul>';
                foreach($hchildRec as $hchildRow){
                    $reshotels.='<li class="hotel_detail_block">
                        <div class="hotel_detail_img"> 
                            <img src="'.BASE_URL.'phpthumb/phpThumb.php?w=230&h=188&src='.IMAGE_PATH.'hotels/'.$hchildRow->image.'&zc=1" alt="'.$hchildRow->title.'">
                        </div>
                        <div class="hotel_detail_content">
                            <h4>'.$hchildRow->title.'</h4>
                            <p>'.strip_tags($hchildRow->brief).'</p>
                            <h3>Price Range: '.$hchildRow->price_range.'</h3>
                            <div class="rating">
                                <ul>';
                                for($i=1; $i<=$hchildRow->grade; $i++){
                                    $reshotels.='<li><a href="javascript:void(0);"></a></li>';
                                }
                                $reshotels.='</ul>
                            </div>
                            <a href="javascript:void(0);" class="link_hotel hotelbooking" slug="'.$hchildRow->slug.'">Book now</a>                             
                        </div>
                    </li>';   
                }
            $reshotels.='</ul><div id="fancybox"></div>';
        }
    }else{
    	$hallRec = Hotels::find_all_byparnt();
    	if($hallRec){
            $reshtbanner.='<section class="" style="background: rgba(0, 0, 0, 0) url(\''.IMAGE_PATH.'banner.png\') no-repeat scroll center center / cover ;
height: 253px;"> </section>';
            
    		$reshtitle.='<h3>Places for hotels</h3>';

    		foreach($hallRec as $hallRow){
    			$reshotels.='<div class="hotel_block">
	            	<h4>'.$hallRow->title.'</h4>
	            	<img src="'.BASE_URL.'phpthumb/phpThumb.php?w=253&h=175&src='.IMAGE_PATH.'hotels/'.$hallRow->image.'&zc=1" alt="'.$hallRow->title.'">
			    	<p><a href="'.BASE_URL.'hotels/'.$hallRow->slug.'" class="readmore"></a></p>
	          	</div>';
    		}
    	}
    }
}

$jVars['module:hotelsbanner'] = $reshtbanner;
$jVars['module:hotelstitle'] = $reshtitle;
$jVars['module:hotelslist'] = $reshotels;
?>
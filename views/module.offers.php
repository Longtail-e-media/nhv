<?php 
$res_offers='';


$recOffer = Offers::getOffers_by();
if($recOffer){
	$count=1;
	foreach($recOffer as $row){
		$colorId =  ($count++%4==0)?$count=1:$count;
		$res_offers.='<div class="col-sm-6 col-md-3">
	        <!-- promotion-box-->
	        <div class="promotion-box">';
	        	$file_path = SITE_ROOT.'images/offers/'.$row->image;
				if(file_exists($file_path)):
		            $res_offers.='<div class="promotion-box-header">
		                <img src="'.IMAGE_PATH.'offers/'.$row->image.'" alt="'.$row->title.'">
		            </div>';
	            endif;

	            $res_offers.='<div class="promotion-box-center color-'.$colorId.'">
	               <div class="prince">
	                    '.$row->disamount.'
	                </div>
	                <div class="percentage">
	                    %<span>'.$row->title.'</span>.
	                </div>
	            </div>

	            <div class="promotion-box-info">
	                <p>'.strip_tags($row->content).'</p>';

	                $splitSRC   = explode("http://", $row->linksrc);
				    $linkTarget = ($row->linktype == 1)? ' target="_blank" ' : ''; 
				    $linksrc  = (count($splitSRC) == 1)? BASE_URL.$row->linksrc : $row->linksrc;
	                $res_offers.='<a href="'.$linksrc.'" '.$linkTarget.' class="btn btn-primary">View Details</a>
	            </div>
	        </div>
	        <!-- End promotion-box-->
	    </div>';
	}
}

$jVars['module:specialOffers'] = $res_offers;
<?php
/*
* Package list by Activities
*/
$respkglistact='';

if(defined('PACKAGELISTS_PAGE')){	
	$slug = (isset($_REQUEST['slug']) and !empty($_REQUEST['slug']))? addslashes($_REQUEST['slug']):'';
	$actRec = Activities::find_by_slug($slug);
	$respkglistact.='<h3>Package > '.$actRec->title.'</h3><hr />';

	if($actRec){		
		global $db;
		$sql = "SELECT pkg.title, pkg.slug, pkg.breif, pkg.days, pkg.image, pkg.gread, 
				act.title as activity, act.slug as activity_slug, 
				dst.title as destination, dst.slug as destination_slug 
				FROM tbl_package  pkg 
				INNER JOIN tbl_destination  dst 
				ON pkg.destinationId = dst.id 
				INNER JOIN tbl_activities act 
				ON pkg.activityId = act.id 
				WHERE 1=1 ";		
		
		$sql.= " AND pkg.activityId = $actRec->id ";		

		$res = $db->query($sql);
		$total = $db->affected_rows($res);
		if($total>0){
			while($rows= $db->fetch_array($res)){
				if(file_exists(SITE_ROOT.'images/package/'.$rows['image'])){
					$activity =  !empty($rows['activity'])? $rows['activity'].' /':'';
					$respkglistact.='<div class="col-xs-12 col-sm-6 col-md-4">
		                <div class="img-hover">
		                    <img src="'.IMAGE_PATH.'package/'.$rows['image'].'" alt="'.$rows['title'].'" class="img-responsive">
		                    <div class="overlay"><a href="'.BASE_URL.'package/'.$rows['slug'].'" class=""><i class="fa fa-plus-circle"></i></a></div>
		                </div>
		                <div class="info-gallery">
		                    <h3>
		                        '.$rows['title'].'<br>
		                        <span>'.$activity.$rows['destination'].'</span>
		                    </h3>
		                    <hr class="separator">
		                    <p>'.strip_tags($rows['breif']).'</p>';
		                    if($rows['gread']){
	                        $gRec = array('Five'=>'5', 'Four'=>'4', 'Three'=>'3', 'Two'=>'2', 'One'=>'1');
	                        $respkglistact.='<ul class="starts">';
	                            for($i=1; $i<=$gRec[$rows['gread']]; $i++){
	                                $respkglistact.='<li><a href="javascript:void(0);"><i class="fa fa-star"></i></a></li>';
	                            }
	                            $tot = (6-$gRec[$rows['gread']]);
	                            for($j=1; $j<$tot; $j++){
	                                $respkglistact.='<li><i class="fa fa-star"></i></li>';
	                            }
	                        $respkglistact.='</ul>';
	                        }
		                    $respkglistact.='<div class="content-btn">
		                    	<a href="'.BASE_URL.'package/'.$rows['slug'].'" class="btn btn-primary">View Details</a>
		                    </div>
		                    <div class="price"><b>Days</b>'.set_na($rows['days']).'</div>                
		                </div>
		            </div>';
		        }
			}
		}else{
			$respkglistact.='<div class="col-xs-12 col-sm-6 col-md-4">No Result Found</div>';
		}
	}else{
		$url = BASE_URL.'pages/errors';
        redirect_to($url);
	}
}

$jVars['module:packagelist-activities'] = $respkglistact;
?>
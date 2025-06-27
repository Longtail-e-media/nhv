<?php 
// Ongoing home events
$oghomevnt='';

$ogevRec = Events::get_ongoing_events(4);
if($ogevRec) {
	foreach($ogevRec as $ogevRow) {
		$imgRec = unserialize($ogevRow->image);
		if(!empty($imgRec)) {
			$img_name = $imgRec[0];
			$img_path = SITE_ROOT.'images/events/'.$img_name;
			if(file_exists($img_path)) {  
				$oghomevnt.='<div class="blog-carousel">
					<div class="entry"> 
						<img src="'.IMAGE_PATH.'events/'.$img_name.'" alt="'.$ogevRow->title.'" class="img-responsive">
						<div class="magnifier">
			                <div class="buttons"> 
			                	<a class="st" rel="bookmark" href="'.BASE_URL.'events/detail/'.$ogevRow->slug.'"><i class="fa fa-link"></i></a> 
			                </div>
			                <!-- end buttons --> 
		              	</div>
					</div>
					<!-- end entry -->
					<div class="blog-carousel-header">
						<h3><a title="" href="'.BASE_URL.'events/detail/'.$ogevRow->slug.'">'.$ogevRow->title.'</a></h3>
						<div class="blog-carousel-meta"> 
							<span><i class="fa fa-calendar"></i> '.date('M d, Y', strtotime($ogevRow->event_stdate)).'</span> 
						</div>
						<!-- end blog-carousel-meta --> 
					</div>
					<!-- end blog-carousel-header -->
					<div class="blog-carousel-desc">
						<p>'.strip_tags($ogevRow->brief).'</p>
					</div>
					<!-- end blog-carousel-desc --> 
				</div>';
			}
		}
	}
}

$jVars['module:ogeventsHome'] = $oghomevnt;

// Upcomming home events
$uchomevnt='';

$ucevRec = Events::get_upcomming_events(4);

if($ucevRec) {
	foreach($ucevRec as $ucevRow) {
		$cimgRec = unserialize($ucevRow->image);
		if(!empty($cimgRec)) {
			$cimg_name = $cimgRec[0];
			$cimg_path = SITE_ROOT.'images/events/'.$cimg_name;
			if(file_exists($cimg_path)) {  
				$uchomevnt.='<div class="blog-carousel">
					<div class="entry"> 
						<img src="'.IMAGE_PATH.'events/'.$cimg_name.'" alt="'.$ucevRow->title.'" class="img-responsive">
						<div class="magnifier">
			                <div class="buttons"> 
			                	<a class="st" rel="bookmark" href="'.BASE_URL.'events/detail/'.$ucevRow->slug.'"><i class="fa fa-link"></i></a> 
			                </div>
			                <!-- end buttons --> 
		              	</div>
					</div>
					<!-- end entry -->
					<div class="blog-carousel-header">
						<h3><a title="" href="'.BASE_URL.'events/detail/'.$ucevRow->slug.'">'.$ucevRow->title.'</a></h3>
						<div class="blog-carousel-meta"> 
							<span><i class="fa fa-calendar"></i> '.date('M d, Y', strtotime($ucevRow->event_stdate)).'</span> 
						</div>
						<!-- end blog-carousel-meta --> 
					</div>
					<!-- end blog-carousel-header -->
					<div class="blog-carousel-desc">
						<p>'.strip_tags($ucevRow->brief).'</p>
					</div>
					<!-- end blog-carousel-desc --> 
				</div>';
			}
		}
	}
}

$jVars['module:uceventsHome'] = $uchomevnt;

/*
* For Events
*/
$resevntbrd=$resevntdetail='';
if(defined('EVENTS_PAGE')) {
	if(isset($_REQUEST['slug']) and !empty($_REQUEST['slug'])) {
		$slug = addslashes($_REQUEST['slug']);
		$eventRec = Events::find_by_slug($slug);
		if(!empty($eventRec)) {
			$resevntbrd.='<div class="col-lg-12">
				<h2>'.$eventRec->title.'</h2>
				<ul class="breadcrumb pull-right">
					<li><a href="'.BASE_URL.'">Home</a></li>
					<li><a href="'.BASE_URL.'events/list">Events</a></li>
					<li>'.$eventRec->title.'</li>
				</ul>
			</div>';

			$resevntdetail.='<div id="content" class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
				$cimgRec = unserialize($eventRec->image);
				if(!empty($cimgRec) and !empty($eventRec->image)) {
					$resevntdetail.='<div class="widget margin-top">
						<div id="aboutslider" class="flexslider clearfix">
							<ul class="slides">';
							foreach($cimgRec as $k=>$cimgnm) {
								$resevntdetail.='<li><img src="'.IMAGE_PATH.'events/'.$cimgnm.'" class="img-responsive" alt="'.$eventRec->title.'"></li>';
							}
							$resevntdetail.='</ul>
							<!-- end slides -->
							<div class="aboutslider-shadow"> <span class="s1"></span> </div>
						</div>
						<!-- end slider --> 
					</div>';
				}

				$resevntdetail.='<div class="blog-carousel-header"><h1></h1>
					<div class="blog-carousel-meta"> <span><i class="fa fa-calendar"></i> '.date('M d, Y', strtotime($eventRec->event_stdate)).'</span> </div>
					<!-- end blog-carousel-meta --> 
				</div>
				<div class="widget">
					'.$eventRec->content.'
				</div>
		      	<div class="clearfix"></div>
			</div>';

			$relevntRec = Events::get_relatedevnt($eventRec->id, '8');
			if(!empty($relevntRec)) {
				$resevntdetail.='<div id="sidebar" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="widget">
						<div class="title"><h2>Other Events</h2></div>
						<ul class="recent_posts_widget shopslisting-widget">';
						foreach($relevntRec as $relevntRow) {
							$imgRec = unserialize($relevntRow->image);
							$img_name = $imgRec[0];
							$resevntdetail.='<li> 
								<a href="'.BASE_URL.'events/detail/'.$relevntRow->slug.'"><img src="'.IMAGE_PATH.'events/'.$img_name.'" alt="" />'.$relevntRow->title.'</a>
								<div class="blog-carousel-meta"> <span><i class="fa fa-calendar"></i> '.date('M d, Y', strtotime($relevntRow->event_stdate)).'</span> </div>
							</li>';
						}
						$resevntdetail.='</ul>
					</div>
				</div>';
			}
		}
	}
	else {
		$resevntbrd.='<div class="col-lg-12">
			<h2>Events</h2>
			<ul class="breadcrumb pull-right">
				<li><a href="'.BASE_URL.'">Home</a></li>
				<li>Events</li>
			</ul>
		</div>';

		$sql = "SELECT slug, title, brief, image, event_stdate, event_endate FROM tbl_events WHERE status='1' ORDER BY event_stdate DESC ";

		$page = (isset($_REQUEST["pageno"]) and !empty($_REQUEST["pageno"]))? $_REQUEST["pageno"] : 1;
		$limit = 6;
		$total = $db->num_rows($db->query($sql));
		$startpoint = ($page * $limit) - $limit; 
		$sql.=" LIMIT ".$startpoint.",".$limit;
		$query = $db->query($sql);

		if($total>0) {			
			$resevntdetail.='<div id="content" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="row">
					<div class="blog-masonry">';
						$sn=1;
						while($recRow=$db->fetch_object($query)) {

							$resevntdetail.='<div class="col-lg-6">
							    <div class="blog-carousel">
							        <div class="entry">
							            <div class="flexslider">
							                <ul class="slides">';
							                $cimgRec = unserialize($recRow->image);
							                foreach($cimgRec as $k=>$cimgnm) {
							                    $resevntdetail.='<li><img src="'.IMAGE_PATH.'events/'.$cimgnm.'" alt="" class="img-responsive"></li>';
							                }
							                $resevntdetail.='</ul>
							            	<!-- end slides --> 
							            </div>
							            <!-- end quote-post -->
							        </div>
							        <!-- end entry -->
							        <div class="blog-carousel-header">
							            <h3><a title="" href="'.BASE_URL.'events/detail/'.$recRow->slug.'">'.$recRow->title.'</a></h3>
							            <div class="blog-carousel-meta"> <span><i class="fa fa-calendar"></i> '.date('M d, Y', strtotime($recRow->event_stdate)).'</span> </div>
							            <!-- end blog-carousel-meta --> 
							        </div>
							        <!-- end blog-carousel-header -->
							        <div class="blog-carousel-desc">
							            <p>'.strip_tags($recRow->brief).'</p>
							        </div>
							    <!-- end blog-carousel-desc --> 
							    </div>
							    <!-- end blog-carousel --> 
							</div>';
						}

		                $resevntdetail.= get_front_pagination($total, $limit, $page, BASE_URL."events/list");

					$resevntdetail.='</div>
				</div>
			</div>';
		}
	}
}

$jVars['module:eventBreadcrumb'] = $resevntbrd;
$jVars['module:eventdetailList'] = $resevntdetail;
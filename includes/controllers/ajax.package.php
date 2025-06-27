<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');
	
	$action = $_REQUEST['action'];
	
	switch($action) 
	{						
		case "filteractivity":
			$desId = addslashes($_REQUEST['destid']);
			$selId = addslashes($_REQUEST['selct']);
			$rec = Activities::get_all_filterdata($desId,$selId);	
			echo json_encode(array("action"=>"success","result"=>$rec));
		break;

		case "filterRegion":
			$actId = addslashes($_REQUEST['actid']);
			$selId = addslashes($_REQUEST['selct']);
			$rec = Activities::get_all_regiondata($actId,$selId);	
			echo json_encode(array("action"=>"success","result"=>$rec));
		break;

		case "add":	
			$record = new Package();

			$checkDupliName = Package::checkDupliName($record->title);			
			if($checkDupliName):
				echo json_encode(array("action"=>"warning","message"=>"Package Title Already Exists."));		
				exit;		
			endif;

			$newArr = array();
			/*$fparent = (isset($_REQUEST['fparent']) and !empty($_REQUEST['fparent']))?$_REQUEST['fparent']:'';*/
			$feature = (isset($_REQUEST['feature']) and !empty($_REQUEST['feature']))?$_REQUEST['feature']:'';
			if( !empty($feature)){				
				foreach($feature as $kk=>$vv){ 
					$final_fpt = !empty($feature[$kk])?$feature[$kk]:'';
					$final_ft  = !empty($feature[$kk])?$feature[$kk]:'';
					$newArr[$kk] = array($final_fpt,$final_ft); 
				}
			}


			$record->slug 			= create_slug($_REQUEST['title']);
			$record->title 			= $_REQUEST['title']; 
			$record->image 			= $_REQUEST['imageArrayname'];

			//$record->banner_image	= serialize(array_values(array_filter($_REQUEST['imageArrayname2'])));
			$record->itenaryfile		= !empty($_REQUEST['imageArrayname3'])?$_REQUEST['imageArrayname3']:'';	
			$record->destinationId 	= $_REQUEST['destinationId'];
			$record->activityId 	= $_REQUEST['activityId'];
			$record->regionId 		= $_REQUEST['regionId'];
			$record->expert_id		= serialize($newArr);
//			$record->price 			= $_REQUEST['price'];
			//$record->offers 		= $_REQUEST['offers'];
			//$record->offer_price 	= $_REQUEST['offer_price'];
			//$record->discount 		= $_REQUEST['discount'];
			$record->currency 		=  'USD'; // $_REQUEST['currency'];
			//$record->group_size_price 			= $_REQUEST['group_size_price'];
			$record->days 			= $_REQUEST['days'];
			$record->accomodation 			= $_REQUEST['accomodation'];
//			$record->group_size 			= $_REQUEST['group_size'];
//			$record->group_size_price1 			= $_REQUEST['group_size_price1'];
//			$record->discount1		= $_REQUEST['discount1'];
//			$record->group_size_price2	 			= $_REQUEST['group_size_price2'];
//			$record->discount2	 		= $_REQUEST['discount2'];
//			$record->group_size_price3	 			= $_REQUEST['group_size_price3'];
//			$record->discount3			= $_REQUEST['discount3'];
//			$record->group_size_price4	 			= $_REQUEST['group_size_price4'];
//			$record->discount_4	 		= $_REQUEST['discount4'];
//			$record->group_size_price5	 			= $_REQUEST['group_size_price5'];
//			$record->discount_5	 		= $_REQUEST['discount5'];
			//$record->transportation 			= $_REQUEST['transportation'];
			$record->maptype 		= $_REQUEST['maptype'];
			if($_REQUEST['maptype']==1){				
				$record->mapgoogle		= '';				
				$record->mapimage		= $_REQUEST['mapArrayname'];
			}
			if($_REQUEST['maptype']==2){
				$record->mapimage		= '';
				$record->mapgoogle		= $_REQUEST['mapgoogle'];
			}			
// 			$record->breif 			= $_REQUEST['breif'];
			$record->overview 		= $_REQUEST['overview'];
			//$record->itinerary 		= $_REQUEST['itinerary'];
			$record->incexc			= $_REQUEST['incexc'];
			$record->availability 	= $_REQUEST['availability'];
			// $record->others 		= $_REQUEST['others'];
			$record->booking_info 	= $_REQUEST['booking_info'];
			$record->other_info		= $_REQUEST['other_info'];
			// $record->guide 			= $_REQUEST['guide'];
			// $record->altitude 		= $_REQUEST['altitude'];
			$record->difficulty 	= $_REQUEST['difficulty'];
			$record->gread 			= $_REQUEST['gread'];
			$record->season 		= $_REQUEST['season'];
			$record->startpoint  	= $_REQUEST['startpoint'];
			$record->endpoint		= $_REQUEST['endpoint'];
			/*if(!empty($_REQUEST['galleryArrayname'])){
				$record->gallery 		= serialize($_REQUEST['galleryArrayname']);
			}	*/		
			$record->tags 			= $_REQUEST['tags'];
			$record->featured 		= $_REQUEST['featured'];
			/*$record->lastminutes 	= $_REQUEST['lastminutes'];*/
			$record->color 		= $_REQUEST['color'];
			$record->homepage 		= $_REQUEST['homepage'];
			$record->status 		= $_REQUEST['status'];
		 	$record->sortorder		= Package::find_maximum();
		 	$record->added_date		= registered();
		 	$record->meta_keywords	= $_REQUEST['meta_keywords']; 
		 	$record->meta_description = $_REQUEST['meta_description'];
							
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;
			
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Package '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
				log_action("Package [".$record->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
		break;
			
		case "edit":
			$record = Package::find_by_id($_REQUEST['idValue']);
			$newArr = array();
			/*$fparent = (isset($_REQUEST['fparent']) and !empty($_REQUEST['fparent']))?$_REQUEST['fparent']:'';*/
			$feature = (isset($_REQUEST['feature']) and !empty($_REQUEST['feature']))?$_REQUEST['feature']:'';
			if( !empty($feature)){				
				foreach($feature as $kk=>$vv){ 
					$final_fpt = !empty($feature[$kk])?$feature[$kk]:'';
					$final_ft  = !empty($feature[$kk])?$feature[$kk]:'';
					$newArr[$kk] = array($final_fpt,$final_ft); 
				}
			} 
			
			if($record->title!=$_REQUEST['title']){
				$checkDupliName = Package::checkDupliName($_REQUEST['title']);
				if($checkDupliName):
					echo json_encode(array("action"=>"warning","message"=>"Package Title is already exist."));		
					exit;		
				endif;
			}
			$record->expert_id 		= serialize($newArr);
			$record->slug 			= create_slug($_REQUEST['title']);
			$record->title 			= $_REQUEST['title']; 
			$record->image 			= $_REQUEST['imageArrayname'];
			//$record->banner_image	= serialize(array_values(array_filter($_REQUEST['imageArrayname2'])));
			$record->itenaryfile		= !empty($_REQUEST['imageArrayname3'])?$_REQUEST['imageArrayname3']:'';	
			$record->destinationId 	= $_REQUEST['destinationId'];
			$record->activityId 	= $_REQUEST['activityId'];
			$record->regionId 		= $_REQUEST['regionId'];
			
//			$record->price 			= $_REQUEST['price'];
			//$record->offers 		= $_REQUEST['offers'];
			//$record->offer_price 	= $_REQUEST['offer_price'];
			$record->currency 		=  'USD'; // $_REQUEST['currency'];
			
//			$record->group_size_price1 			= $_REQUEST['group_size_price1'];
//			$record->discount1		= $_REQUEST['discount1'];
//			$record->group_size_price2	 			= $_REQUEST['group_size_price2'];
//			$record->discount2	 		= $_REQUEST['discount2'];
//			$record->group_size_price3	 			= $_REQUEST['group_size_price3'];
//			$record->discount3			= $_REQUEST['discount3'];
//			$record->group_size_price4	 			= $_REQUEST['group_size_price4'];
//			$record->discount4	 		= $_REQUEST['discount4'];
//			$record->group_size_price5	 			= $_REQUEST['group_size_price5'];
//			$record->discount5	 		= $_REQUEST['discount5'];
			$record->days 			= $_REQUEST['days'];
			$record->accomodation 			= $_REQUEST['accomodation'];
			$record->group_size 			= $_REQUEST['group_size'];
			//$record->transportation 			= $_REQUEST['transportation'];
			$record->maptype 		= $_REQUEST['maptype'];
			if($_REQUEST['maptype']==1){				
				$record->mapgoogle		= '';				
				$record->mapimage		= $_REQUEST['mapArrayname'];
			}
			if($_REQUEST['maptype']==2){
				$record->mapimage		= '';
				$record->mapgoogle		= $_REQUEST['mapgoogle'];
			}	
// 			$record->breif 			= $_REQUEST['breif'];
			$record->overview 		= $_REQUEST['overview'];
			//$record->itinerary 		= $_REQUEST['itinerary'];
			$record->incexc			= $_REQUEST['incexc'];
			$record->availability 	= $_REQUEST['availability'];
			// $record->others 		= $_REQUEST['others'];
			$record->booking_info 	= $_REQUEST['booking_info'];
			$record->other_info		= $_REQUEST['other_info'];
			// $record->guide 			= $_REQUEST['guide'];
			// $record->altitude 		= $_REQUEST['altitude'];
			$record->difficulty 	= $_REQUEST['difficulty'];
			$record->gread 			= $_REQUEST['gread'];
			$record->season 		= $_REQUEST['season'];
			$record->startpoint  	= $_REQUEST['startpoint'];
			$record->endpoint		= $_REQUEST['endpoint'];
			/*if(!empty($_REQUEST['galleryArrayname'])){
				$record->gallery 		= serialize($_REQUEST['galleryArrayname']);
			}*/
			$record->tags 			= $_REQUEST['tags'];
			$record->featured 		= $_REQUEST['featured'];
			/*$record->lastminutes 	= $_REQUEST['lastminutes'];*/
			$record->color 		= $_REQUEST['color'];
			$record->homepage 		= $_REQUEST['homepage'];
			$record->status 		= $_REQUEST['status'];
		 	$record->meta_keywords	= $_REQUEST['meta_keywords']; 
		 	$record->meta_description = $_REQUEST['meta_description'];

			if(!empty($_REQUEST['imageArrayname'])):				
				$record->image		= $_REQUEST['imageArrayname'];				
			endif;	

			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Package '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			   log_action("Package [".$record->title."] Edit Successfully",1,4);
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
		break;
			
		case "delete":
			$id = $_REQUEST['id'];
			$record = Package::find_by_id($id);
			log_action("Package  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->query("DELETE FROM tbl_package WHERE id='{$id}'");
			
			reOrder("tbl_package", "sortorder");			
			
			$message  = sprintf($GLOBALS['basic']['deletedSuccess_'], "Package '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));					
			log_action("Package  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
		break;
		
		// Module Setting Sections  >> <<
		case "toggleFeatured":
			$id = $_REQUEST['id'];
			$record = Package::find_by_id($id);
			$record->featured = ($record->featured == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;

		case "togglelstmin":
			$id = $_REQUEST['id'];
			$record = Package::find_by_id($id);
			$record->lastminutes = ($record->lastminutes == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;

		case "togglehome":
			$id = $_REQUEST['id'];
			$record = Package::find_by_id($id);
			$record->homepage = ($record->homepage == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;

		case "toggleStatus":
			$id = $_REQUEST['id'];
			$record = Package::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$record->save();
			echo "";
		break;
			
		case "bulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Package::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
		break;
			
		case "bulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$record = Package::find_by_id($allid[$i]);
				log_action("Package  [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);				
				$res = $db->query("DELETE FROM tbl_package WHERE id='".$allid[$i]."'");				
				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();
			reOrder("tbl_package", "sortorder");
			
			if($return==1):
				$message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Package"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
		break;
			
		case "sort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			datatableReordering('tbl_package', $sortIds, "sortorder");
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Package"); 
			echo json_encode(array("action"=>"success","message"=>$message));
		break;

		case "filteractivityfront":
			$desId = addslashes($_REQUEST['destid']);
			$selId = addslashes($_REQUEST['selct']);
			$rec = Activities::get_all_filterdatafront($desId,$selId);	
			echo json_encode(array("action"=>"success","result"=>$rec));
		break;

		case "addpackagedate":
			$record = new Packagedate();
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->package_currency = $_REQUEST['package_currency'];
//			$record->package_rate 	= $_REQUEST['package_rate'];
			$record->package_date 	= $_REQUEST['package_date'];
			$record->package_closure 	= $_REQUEST['package_closure'];
			$record->package_seats 	= $_REQUEST['package_seats'];
			$record->status 		= $_REQUEST['status'];
			
			$record->sortorder		= Packagedate::find_maximum_byparent("sortorder", $_REQUEST['package_id']);	
			$record->added_date 	= registered();
						
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Pacakge date '".$record->package_date."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
			break;

		case "editpackagedate":
			$record = Packagedate::find_by_id($_REQUEST['idValue']);
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->package_currency = $_REQUEST['package_currency'];
//			$record->package_rate 	= $_REQUEST['package_rate'];
			$record->package_date 	= $_REQUEST['package_date'];
			$record->package_closure 	= $_REQUEST['package_closure'];
            $record->package_seats 	= $_REQUEST['package_seats'];
			$record->status 		= $_REQUEST['status'];

			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Pacakge date '".$record->package_date."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
			break;

		case "deletesubpackage":
			$id = $_REQUEST['id'];
			$record = Packagedate::find_by_id($id);
			log_action("Package date [".$record->package_date."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();

			$res   = $db->query("DELETE FROM tbl_package_date WHERE id='{$id}'");			
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_package_date", "sortorder");						
			echo json_encode(array("action"=>"success","message"=>"Sub Package [".$record->package_date."]".$GLOBALS['basic']['deletedSuccess']));							
			break;

		case "SubtoggleStatus":
			$id = $_REQUEST['id'];
			$record = Packagedate::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
			break;

		case "subbulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Packagedate::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
			break;
			
		case "subbulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$record = Packagedate::find_by_id($allid[$i]);
				$res  = $db->query("DELETE FROM tbl_package_date WHERE id='".$allid[$i]."'");				
				reOrderSub("tbl_package_date", "sortorder", "package_id",$record->package_id);

				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();

			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Package"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
			break;

		case "subSort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Packagedate::field_by_id($id,'package_id');
			datatableReordering('tbl_package_date', $sortIds, "sortorder", "package_id",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Sub Package"); 
			echo json_encode(array("action"=>"success","message"=>$message));
			break;	
	
	case "additinerary":
			$record = new Itinerary();
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->day 			= $_REQUEST['day'];
			$record->title 			= $_REQUEST['title'];
			$record->slug 			= create_slug($_REQUEST['title']);
			$record->image			= $_REQUEST['imageArrayname'];
			$record->content 			= $_REQUEST['content'];
			$record->status			= $_REQUEST['status'];	
			$record->sortorder		= Itinerary::find_maximum_byparent("sortorder", $_REQUEST['package_id']);	
			
			/*if(empty($_REQUEST['imageArrayname'])):
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;
			endif;*/
						
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Itinerary '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
			break;

		case "edititinerary":
			$record = Itinerary::find_by_id($_REQUEST['idValue']);
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->day 			= $_REQUEST['day'];
			$record->title 			= $_REQUEST['title'];
			$record->slug 			= create_slug($_REQUEST['title']);
			$record->image			= $_REQUEST['imageArrayname'];
			$record->content 			= $_REQUEST['content'];
			$record->status			= $_REQUEST['status'];	

			if(!empty($_REQUEST['imageArrayname'])):				
				$record->image		= $_REQUEST['imageArrayname'];				
			endif;	

			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Itinerary '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
			break;

		case "deleteitinerary":
			$id = $_REQUEST['id'];
			$record = Itinerary::find_by_id($id);
			log_action("Itinerary [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();

			$res   = $db->query("DELETE FROM tbl_itinerary WHERE id='{$id}'");			
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_itinerary", "sortorder");						
			echo json_encode(array("action"=>"success","message"=>"Itinerary [".$record->title."]".$GLOBALS['basic']['deletedSuccess']));							
			break;

		case "SubitoggleStatus":
			$id = $_REQUEST['id'];
			$record = Itinerary::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
			break;

		case "subibulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Itinerary::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
			break;
			
		case "subibulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$record = Itinerary::find_by_id($allid[$i]);
				$res  = $db->query("DELETE FROM tbl_itinerary WHERE id='".$allid[$i]."'");				
				reOrderSub("tbl_itinerary", "sortorder", "package_id",$record->package_id);

				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();

			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Itinerary"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
			break;

		case "subiSort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Itinerary::field_by_id($id,'package_id');
			datatableReordering('tbl_itinerary', $sortIds, "sortorder", "package_id",$posId,0);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Itinerary"); 
			echo json_encode(array("action"=>"success","message"=>$message));
			break;	



			case "addreview":
			$record = new Review();
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->title 			= $_REQUEST['title'];
			//$record->linksrc 		= $_REQUEST['linksrc'];
			$record->image			= $_REQUEST['imageArrayname'];
			$record->comments 		= $_REQUEST['content'];
			$record->name 			= $_REQUEST['name'];
			$record->address 		= (!empty($_REQUEST['address']))?$_REQUEST['address']:'';
			$record->country 		= $_REQUEST['country'];
			$record->email 			= (!empty($_REQUEST['email']))?$_REQUEST['email']:'';
			$record->gender 		= $_REQUEST['gender'];
			$record->pretrip 		= $_REQUEST['pretrip'];
			$record->meals 			= $_REQUEST['meals'];
			$record->staffs 		= $_REQUEST['staffs'];
			$record->transportation = $_REQUEST['transportation'];
			$record->accomodation 	= $_REQUEST['accomodation'];
			$record->money 			= $_REQUEST['money'];
			$record->rating 		= $_REQUEST['rating'];
			$record->status			= $_REQUEST['status'];	
			$record->homepage		= $_REQUEST['homepage'];
			$record->sortorder		= Review::find_maximum_byparent("sortorder", $_REQUEST['package_id']);
           		$record->added_date 	= registered();
			
			if(empty($_REQUEST['imageArrayname'])):				
				echo json_encode(array("action"=>"warning","message"=>"Required Upload Image !"));
				exit;					
			endif;			
			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Review '".$record->title."'");
			echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback();
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;
			break;

        case "addReviewFront":
            $record = new Review();

            if(empty($_REQUEST['imageArrayname'])):
                echo json_encode(array("action"=>"warning","message"=>"Image Required!"));
                exit;
            endif;

            $record->package_id 	= $_REQUEST['package_id'];
            $record->title 			= $_REQUEST['full_name'];
            $record->image			= $_REQUEST['imageArrayname'];
            $record->comments 		= $_REQUEST['message'];
            $record->name 			= $_REQUEST['full_name'];
            $record->address 		= $_REQUEST['phone'];
            $record->country 		= $_REQUEST['country'];
            $record->email 			= $_REQUEST['email'];
            $record->gender 		= $_REQUEST['gender'];
            $record->pretrip 		= $_REQUEST['pre_trip_rating'];
            $record->meals 			= $_REQUEST['meals_rating'];
            $record->staffs 		= $_REQUEST['staffs_rating'];
            $record->transportation = $_REQUEST['transportation_rating'];
            $record->accomodation 	= $_REQUEST['accommodation_rating'];
            $record->money 			= $_REQUEST['money_rating'];
            $record->rating 		= $_REQUEST['overall_rating'];
            $record->status			= 0;
            $record->homepage		= 0;
            $record->sortorder		= Review::find_maximum_byparent("sortorder", $_REQUEST['package_id']);
            $record->added_date 	= registered();


            $db->begin();
            if($record->save()): $db->commit();
                echo json_encode(array("action"=>"success","message"=>"Your Review has been successfully received !"));
            else: $db->rollback();
                echo json_encode(array("action"=>"error","message"=>"Unable to send Review. Please try again."));
            endif;
            break;

			case "editreview":
			$record = Review::find_by_id($_REQUEST['idValue']);
			
			$record->package_id 	= $_REQUEST['package_id'];
			$record->title 			= $_REQUEST['title'];
            //$record->linksrc 		= $_REQUEST['linksrc'];
			$record->image			= $_REQUEST['imageArrayname'];
			$record->comments 		= $_REQUEST['content'];
			$record->name 			= $_REQUEST['name'];
            $record->address 		= (!empty($_REQUEST['address']))?$_REQUEST['address']:'';
            $record->country 		= $_REQUEST['country'];
            $record->email 			= (!empty($_REQUEST['email']))?$_REQUEST['email']:'';
			$record->gender 		= $_REQUEST['gender'];
			$record->pretrip 		= $_REQUEST['pretrip'];
			$record->meals 			= $_REQUEST['meals'];
			$record->staffs 		= $_REQUEST['staffs'];
			$record->transportation	= $_REQUEST['transportation'];
			$record->accomodation	= $_REQUEST['accomodation'];
			$record->money 			= $_REQUEST['money'];
			$record->rating 			= $_REQUEST['rating'];
			$record->status			= $_REQUEST['status'];
            $record->homepage		= $_REQUEST['homepage'];
			if(!empty($_REQUEST['imageArrayname'])):				
				$record->image		= $_REQUEST['imageArrayname'];				
			endif;	


			$db->begin();
			if($record->save()): $db->commit();
			   $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Review '".$record->title."'");
			   echo json_encode(array("action"=>"success","message"=>$message));
			else: $db->rollback(); echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
			endif;
			break;

        case "togglehomeReview":
            $id = $_REQUEST['id'];
            $record = Review::find_by_id($id);
            $record->homepage = ($record->homepage == 1) ? 0 : 1 ;
            $record->save();
            echo "";
        break;

			case "deletereview":
			$id = $_REQUEST['id'];
			$record = Review::find_by_id($id);
			log_action("Review [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();

			$res   = $db->query("DELETE FROM tbl_review WHERE id='{$id}'");			
  		    if($res):$db->commit();	else: $db->rollback();endif;
			reOrder("tbl_review", "sortorder");						
			echo json_encode(array("action"=>"success","message"=>"Review [".$record->title."]".$GLOBALS['basic']['deletedSuccess']));							
			break;

		case "SubreviewtoggleStatus":
			$id = $_REQUEST['id'];
			$record = Review::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
			break;

		case "subreviewbulkToggleStatus":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			for($i=1; $i<count($allid); $i++){
				$record = Review::find_by_id($allid[$i]);
				$record->status = ($record->status == 1) ? 0 : 1 ;
				$record->save();
			}
			echo "";
			break;
			
		case "subreviewbulkDelete":
			$id = $_REQUEST['idArray'];
			$allid = explode("|", $id);
			$return = "0";
			$db->begin();
			for($i=1; $i<count($allid); $i++){
				$record = Review::find_by_id($allid[$i]);
				$res  = $db->query("DELETE FROM tbl_review WHERE id='".$allid[$i]."'");				
				reOrderSub("tbl_review", "sortorder", "package_id",$record->package_id);

				$return = 1;
			}
			if($res)$db->commit();else $db->rollback();

			if($return==1):
			    $message  = sprintf($GLOBALS['basic']['deletedSuccess_bulk'], "Itinerary"); 
				echo json_encode(array("action"=>"success","message"=>$message));
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['noRecords']));
			endif;
			break;

		case "subiiSort":
			$id 	 = $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$sortIds = $_REQUEST['sortIds'];
			$posId   = Review::field_by_id($id,'package_id');
			datatableReordering('tbl_review', $sortIds, "sortorder", "package_id",$posId,1);
			$message  = sprintf($GLOBALS['basic']['sorted_'], "Review"); 
			echo json_encode(array("action"=>"success","message"=>$message));
			break;	

		case "addPackageImage":
					
		$packageid  = $_REQUEST['packageid'];			
		
			$imageName  = !empty($_REQUEST['imageArrayname'])?$_REQUEST['imageArrayname']:'';
			$title      = !empty($_REQUEST['title'])?$_REQUEST['title']:'';
			
			if(!empty($imageName)):
			foreach($imageName as $key=>$val):
				$FimageName		= $imageName[$key];
				$Ftitle	        = $title[$key];																	
				//Save Record
				if(!empty($FimageName)):
				$Gallery	 = new PackageImage();

				$Gallery->image			= $FimageName; 		
				$Gallery->title     	= $Ftitle;
				$Gallery->status		= 1;
				$Gallery->packageid		= $packageid;
				$Gallery->sortorder		= PackageImage::find_maximum_byparent("sortorder",$packageid);														
				$Gallery->registered	= registered();						
				$db->begin();						
				$res   =  $Gallery->save();
			if($res):$db->commit();	else: $db->rollback();endif;
				log_action(" Package Gallery Image [".$Gallery->title."]".$GLOBALS['basic']['addedSuccess'],1,3);
				endif;
			endforeach;				
				echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['changesSaved'],"packageid"=>$packageid));				
			else:
				echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
			endif;			
		
		break;
		case "SubGallerytoggleStatus":
			$id = $_REQUEST['id'];
			$record = PackageImage::find_by_id($id);
			$record->status = ($record->status == 1) ? 0 : 1 ;
			$db->begin();						
				$res   =  $record->save();
				if($res):$db->commit();	else: $db->rollback();endif;
			echo "";
		break;

		case "deleteimage":
			$id = $_REQUEST['id'];
			$record = PackageImage::find_by_id($id);
			log_action("Package Gallery Image [".$record->title."]".$GLOBALS['basic']['deletedSuccess'],1,6);
			$db->begin();  		    	
			$res =  $db->query("DELETE FROM tbl_package_images WHERE id='{$id}'");
			if($res):$db->commit();	else: $db->rollback();endif;
			reOrderSub("tbl_package_images", "sortorder", "packageid", $record->packageid);					
			echo json_encode(array("action"=>"success"));	
		break;

		case "sortGalley":
			$id 	= $_REQUEST['id']; 	// IS a line containing ids starting with : sortIds
			$record = PackageImage::find_by_id($id);
			$sortIds = $_REQUEST['sortIds'];
			
			datatableReordering('tbl_package_images', $sortIds, "sortorder", 'packageid', $record->packageid, 0);
			reOrder('tbl_package_images',"sortorder");
			echo json_encode(array("action"=>"success","message"=>$GLOBALS['basic']['sorted']));
		break;	
			
		case "editGalleryImageText":

            $GalleryImage = PackageImage::find_by_id($_REQUEST['id']);
            if(!empty($GalleryImage)){
                $GalleryImage->title = $_REQUEST['title'];
                $db->begin();
                if($GalleryImage->save()):$db->commit();
                    $message  = sprintf($GLOBALS['basic']['changesSaved_'], "Sub Gallery Image '".$GalleryImage->title."'");
                    echo json_encode(array("action"=>"success","message"=>$message));
                    log_action("Gallery Image [".$GalleryImage->title."] Edit Successfully",1,4);
                else:$db->rollback();echo json_encode(array("action"=>"notice","message"=>$GLOBALS['basic']['noChanges']));
                endif;
            }else{
                echo json_encode(array("action"=>"error","message"=>$GLOBALS['basic']['unableToSave']));
            }

        break;
		
	}
?>
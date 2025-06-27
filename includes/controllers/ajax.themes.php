<?php 
	// Load the header files first
	header("Expires: 0"); 
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
	header("cache-control: no-store, no-cache, must-revalidate"); 
	header("Pragma: no-cache");

	// Load necessary files then...
	require_once('../initialize.php');
	$myArr = array();
	foreach($_REQUEST as $k=>$v){$$k=$v;}
	
	switch($action){
		case "action-properties":
			/* Menu Peroperties */
			if($actype=='mainmenu'){
				$myArr = array( "level"=>$level);
			}

			/* Main Slideshow Properties */
			if($actype=='mainslider'){
				$myArr = array( "imgwidth"=>$imgwidth,"imgheight"=>$imgheight,"imagetransaction"=>$imagetransaction,"imageslidespeed"=>$imageslidespeed,"imageslots"=>$imageslots);
			}

			/* Interdiction Properties */
			if($actype=='interdiction'){
				$myArr = array( "intdutitle"=>$intdutitle, "intdubrief"=>$intdubrief, 
					"ads1icon"=>$ads1icon, "ads1title"=>$ads1title, "ads1link"=>$ads1link,
					"ads2icon"=>$ads2icon, "ads2title"=>$ads2title, "ads2link"=>$ads2link,
					"ads3icon"=>$ads3icon, "ads3title"=>$ads3title, "ads3link"=>$ads3link,
					"ads4icon"=>$ads4icon, "ads4title"=>$ads4title, "ads4link"=>$ads4link,
					"ads5icon"=>$ads5icon, "ads5title"=>$ads5title, "ads5link"=>$ads5link,
					"ads6icon"=>$ads6icon, "ads6title"=>$ads6title, "ads6link"=>$ads6link,
					"ads7icon"=>$ads7icon, "ads7title"=>$ads7title, "ads7link"=>$ads7link,
					"ads8icon"=>$ads8icon, "ads8title"=>$ads8title, "ads8link"=>$ads8link
				);
			}

			/* Main Package Properties */
			if($actype=='mainpackage'){
				$myArr = array( "mpkgtitle"=>$mpkgtitle );
			}

			/* Offers Properties */
			if($actype=='offers'){
				$myArr = array( "offerstitle"=>$offerstitle );
			}

			/* Testimonial Properties */
			if($actype=='testimonial'){
				$myArr = array( "testimonialtitle"=>$testimonialtitle, "testimonialbrief"=>$testimonialbrief );
			}

			/* Footer Properties */
			if($actype=='footer'){
				$myArr = array( "footerbrief"=>$footerbrief);
			}

			$rec = Themes::find_by_id($myVal);
			$rec->properties = serialize($myArr);
			$rec->status 	 = 1;
			$rec->added_date = registered();
			$rec->save();

			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Thems Properties Attributes");
			echo json_encode(array("action"=>"success","message"=>$message));
		break;

		case "action-jsproperties":
			/* Main Slideshow JS Properties */
			if($actype=='mainslider'){
				$myArr = array( "slidenavtype"=>$slidenavtype,"slidenavarrow"=>$slidenavarrow,"slidenavstyle"=>$slidenavstyle);
			}

			/* Main Twitter JS Properties */
			if($actype=='twitter'){
				$myArr = array( "twitterid"=>$twitterid);
			}

			$rec = Themes::find_by_id($myVal);
			$rec->jsproperties = serialize($myArr);
			$rec->status 	 = 1;
			$rec->added_date = registered();
			$rec->save();

			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Thems JS Properties Attributes");
			echo json_encode(array("action"=>"success","message"=>$message));
		break;

		case "action-cssproperties":
			/* Top Navigation CSS Properties */
			if($actype=='topnav'){
				$myArr = array("bodybgtype"=>$bgtype);		
			}

			/* Menu CSS Properties */
			if($actype=='mainmenu'){
				$myArr = array('main-menu-bgcolor'=>$bgcolor);
			}

			/* Main Package CSS Properties */
			if($actype=='mainpackage'){
				$cond1 = ($mpkgbgtype==1)?'mpkagbgimage':'mpkgbgcolor';	
				$cond2 = ($mpkgbgtype==1)?$bgimage:$mpkgbgcolor;						
				$disval = !empty($mpkgdisplay)?$mpkgdisplay:'none';
				$myArr = array( "mpkgbgtype"=>$mpkgbgtype,$cond1=>$cond2, "mpkgfontcolor"=>$mpkgfontcolor, "mpkgdisplay"=>$disval);
			}

			/* Interdiction Block CSS Properties */
			if($actype=='interdiction'){
				$disval = !empty($interdictiondisplay)?$interdictiondisplay:'none';					
				$myArr = array('interdictiondisplay'=>$disval);				
			}

			/* Information Block CSS Properties */
			if($actype=='infoblock'){
				$disval = !empty($infoblockdisplay)?$infoblockdisplay:'none';					
				$myArr = array('infoblockbgcolor'=>$infoblockbgcolor,'infoblockdisplay'=>$disval);				
			}

			/* Offers CSS Properties */
			if($actype=='offers'){
				$cond1 = ($offersbgtype==1)?'offersbgimage':'offersbgcolor';	
				$cond2 = ($offersbgtype==1)?$bgimage:$offersbgcolor;
				$disval = !empty($offersdisplay)?$offersdisplay:'none';
				$myArr = array("offersbgtype"=>$offersbgtype,$cond1=>$cond2, "offersfontcolor"=>$offersfontcolor, "offersdisplay"=>$disval);
			}

			/* Testimonial Block CSS Properties */
			if($actype=='testimonial'){
				$cond1 = ($testimonialbgtype==1)?'testimonialbgimage':'testimonialbgcolor';	
				$cond2 = ($testimonialbgtype==1)?$bgimage:$bgcolor;
				$disval = !empty($testimonialdisplay)?$testimonialdisplay:'none';					
				$myArr = array("testimonialbgtype"=>$testimonialbgtype,$cond1=>$cond2,'testimonialdisplay'=>$disval);				
			}

			/* Information Twitter CSS Properties */
			if($actype=='twitter'){
				$disval = !empty($twitterdisplay)?$twitterdisplay:'none';					
				$myArr = array('twitterbgcolor'=>$twitterbgcolor,'twitterdisplay'=>$disval);				
			}

			/* Footer CSS Properties */
			if($actype=='footer'){				
				$myArr = array('topfooterbgcolor'=>$topfooterbgcolor, 'downfooterbgcolor'=>$downfooterbgcolor);				
			}

			$rec = Themes::find_by_id($myVal);
			$rec->cssproperties = serialize($myArr);
			$rec->status 		= 1;
			$rec->added_date 	= registered();
			$rec->save();

			$message  = sprintf($GLOBALS['basic']['addedSuccess_'], "Thems CSS Properties Attributes");
			echo json_encode(array("action"=>"success","message"=>$message));			
		break;
	}
?>
<?php
session_start();
$PROJECT	   =  !empty($_POST['PROJECT'])?"/".$_POST['PROJECT']."/":"/";
$thumb_width   =  @$_POST['thumb_width'];
$thumb_height  =  @$_POST['thumb_height'];
$targetFolder  =  $_POST['targetFolder'];

function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height,$dest) { 
 list($width_orig, $height_orig,$img_type) = @getimagesize($imgSrc);  
   if($img_type == 1 || $img_type == 2 || $img_type == 3){
       if($img_type == 1) $myImage = imagecreatefromgif($imgSrc);
	   elseif($img_type == 2) $myImage = imagecreatefromjpeg($imgSrc);
	   else $myImage = imagecreatefrompng($imgSrc);
        $ratio_orig = $width_orig/$height_orig;
			
			if (($thumbnail_width/$thumbnail_height) < $ratio_orig) {
			   if($thumbnail_width>$width_orig){$new_height = $height_orig;}else{$new_height = $thumbnail_width/$ratio_orig;}
			   
			   if($thumbnail_width>$width_orig){$new_width = $width_orig;}else{$new_width = $thumbnail_width;}
			} else {
			   if($thumbnail_height>$height_orig){$new_width = $width_orig;}else{$new_width = $thumbnail_height*$ratio_orig;}
			   if($thumbnail_height>$height_orig){$new_height = $height_orig;}else{$new_height = $thumbnail_height;}
			}
		   
			$x_mid = $new_width/2;  //horizontal middle
			$y_mid = $new_height/2; //vertical middle
		   
			$process = imagecreatetruecolor(round($new_width), round($new_height));
			
			imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
			$thumb=imagecreatetruecolor($new_width, $new_height);
			
			
		 imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($new_width/2)), ($y_mid-($new_height/2)), $new_width, $new_height, $new_width, $new_height);
		
		switch($img_type)
		{
			  case '1':
				  imagegif($thumb,$dest);
			  break;
			  case '2':
				  imagejpeg($thumb,$dest);
			  break;
			  case '3':
				  imagepng($thumb,$dest);
			  break;
			  default:			   
			  break;
		  }
		
			imagedestroy($process);
			imagedestroy($myImage);
			}
}// CroppedThumbnail close		


function randomkeys($length) {
    $validCharacters = "1234567890abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}


if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'].$PROJECT.$targetFolder; 
	if(!file_exists($targetPath)){ mkdir($targetPath); }
	$targetFile = $_FILES['Filedata']['name'];
	
	//add bye me
	$targetFile  = randomkeys(5)."-".preg_replace('/\s+/', '-', strtolower($targetFile));
	
	// Validate the file type
	$blacklist = array("php","exe");
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);		
	$thumbPath =  str_replace('//','/',$targetPath) .'thumbnails/';
	$targetFileThumbs =  $thumbPath.$targetFile;
	if(!file_exists($thumbPath)){ mkdir($thumbPath); }
	if(in_array($fileParts['extension'],$blacklist)) {
	    die("Restricted File!");				
		}	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
		{   move_uploaded_file($tempFile,$targetPath.$targetFile);
		    if (in_array(strtolower($fileParts['extension']),array('jpg','jpeg','gif','png'))) {
			CroppedThumbnail($targetPath.$targetFile,$thumb_width,$thumb_height,$targetFileThumbs);}
		}
		
	echo $targetFile;
	} else {
		echo 'Invalid file type.';
	}
}
?>
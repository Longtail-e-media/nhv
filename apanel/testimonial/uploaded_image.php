<?php
include_once('../../includes/initialize.php');
if(!isset($_SESSION['imageNameArr'])){ $_SESSION['imageNameArr']=array(); }
$_SESSION['imageNameArr'][] = $_POST['imagefile']; 
$imageNameArr =  $_SESSION['imageNameArr'];
$deleteid = rand(0,99999);
if(!empty($imageNameArr)):
foreach($imageNameArr as $key=>$val):?>
<div class="form-row">
<div class="form-label col-md-2"></div> 
<div class="col-md-3" id="previewUserimage<?php echo $deleteid;?>">
    <div class="infobox info-bg">
        <img src="<?php echo IMAGE_PATH.'testimonial/thumbnails/'.$val;?>"  style="width:100%"/>
        <a href="javascript:void(0);" onclick="deleteTempimage(<?php echo $deleteid;?>);">
            <span class="badge badge-absolute float-right bg-red" style="right: -10px !important;">
                <i class="glyph-icon icon-clock-os"></i>
            </span>
        </a>
        <input type="hidden" name="imageArrayname" value="<?php echo $val;?>" class="validate[required,length[0,250]]" />        
    </div> 
</div>
</div>
<?php endforeach; endif;  
//uplodify
  if(isset($_SESSION['imageNameArr'])){
   if(count($_SESSION['imageNameArr'])>0){
      foreach($_SESSION['imageNameArr'] as $key=>$val)
      { 
         @unlink(IMAGE_PATH.'testimonial/thumbnails/'.$val);
      	 @unlink(IMAGE_PATH.'testimonial/'.$val);
      }	 
    	unset($_SESSION['imageNameArr']);
       }
  }
//uplodify
?>

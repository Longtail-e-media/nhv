<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_slideshows"; // Database table name
$moduleId 		  = 5;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name

if(isset($_GET['page']) && $_GET['page'] == "slideshow" && isset($_GET['mode']) && $_GET['mode']=="list"):	
?>
<h3>
List Slideshows
<!--<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewSlideshow();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-plus-square"></i>
    </span>
    <span class="button-content"> Add New </span>
</a>-->
</h3>
<div class="divider"></div>
<div class="my-msg"></div>

<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<form action="" class="col-md-12 center-margin" method="post" id="slideshow_frm">
    <div class="row">
        <div class="form-row col-md-12">
            <div class="form-input col-md-10">
               <input type="file" name="users_upload" id="users_upload" class="transparent no-shadow">
            </div>
            <div class="form-input float-right">
        		<button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                    <span class="button-content">
                        Save
                    </span>	
        		</button>  
        	</div>
        </div>
      
        <!-- Upload image preview -->
        <div id="previewUser_Image"></div>  
                    
    </div>     
</form>    

<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#users_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'    : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'      : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/slideshow/',thumb_width:200,thumb_height:200},
	'method'   : 'post',
    'cancelImg' : '<?php echo BASE_URL;?>uploadify/cancel.png',
    'auto'      : true,
	'multi'     : true,	
	'hideButton': false,	
	'buttonText' : 'Upload Image',
	'width'     : 125,
	'height'	: 21,
	'removeCompleted' : true,
	'progressData' : 'speed',
	'uploadLimit' : 100,
	'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
	 'buttonClass' : 'button formButtons',
  	'onUploadSuccess' : function(file, data, response) {
		$('#uploadedImageName').val('1');
		var filename =  data;
		$.post('<?php echo BASE_URL;?>apanel/slideshow/uploaded_slideshow.php',{imagefile:filename},function(msg){			
			   $('#previewUser_Image').append(msg).show();
			}); 
		    
    },
	'onDialogOpen'      : function(event,ID,fileObj) {		
    },
	'onUploadError' : function(file, errorCode, errorMsg, errorString) {
           alert(errorMsg);
        },
	'onUploadComplete' : function(file) {
          //alert('The file ' + file.name + ' was successfully uploaded');
        } 	
  });
});
    // ]]>
</script>
<?php 
//clearImages("tbl_slideshows", "slideshow");
//clearImages("tbl_slideshows", "slideshow/thumbnails");
$slideshows = Slideshow::find_by_sql("SELECT * FROM tbl_slideshows ORDER BY sortorder ASC");
if($slideshows):
?>
<div class="row"> 
<div class="col-md-12 slideshow-sort">
<?php 
$ic=1;
foreach($slideshows as $slideshowRow):
//$newrecRow = ($ic++%4==0)?'</div><div class="row">':'';?>      
     <div class="col-md-3 removeSavedimg<?php echo $slideshowRow->id;?>" id="<?php echo $slideshowRow->id;?>">
        <div class="infobox info-bg">                            	                                
        	<div class="button-group" data-toggle="buttons">
                <span class="float-left"><?php 
						$filesize = (file_exists(SITE_ROOT."images/slideshow/".$slideshowRow->image))?filesize(SITE_ROOT."images/slideshow/".$slideshowRow->image):'0 KB';
						echo 'Size : '.getFileFormattedSize($filesize);
					
                    ?>
                </span>                                   
                <a class="btn small float-right" href="javascript:void(0);" onclick="deleteImage(<?php echo $slideshowRow->id;?>);">
                    <i class="glyph-icon icon-trash-o"></i>
                </a>
                <?php
					$imageStatus = ($slideshowRow->status==1)?'icon-check-circle-o':'icon-clock-os-circle-o';
				?>
                <a class="btn small float-right imageStatusToggle" href="javascript:void(0);" rowId="<?php echo $slideshowRow->id;?>" status="<?php echo $slideshowRow->status;?>">
                    <i class="glyph-icon <?php echo $imageStatus;?>" id="toggleImg<?php echo $slideshowRow->id;?>"></i>
                </a>                                    
            </div>
            <img src="<?php echo IMAGE_PATH.'slideshow/thumbnails/'.$slideshowRow->image;?>"  style="width:100%"/>
            <span><?php echo $slideshowRow->title;?></span>                              
        </div> 
    </div>
    <?php //echo $newrecRow;?>   
<?php endforeach;?> 
</div>   
</div> 
<?php endif;  ?>
<!-----------------------------------Add edit Section ---------------------------------------------------------------------------------->

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
	$slideshowId 	= addslashes($_REQUEST['id']);
	$slideshowInfo   = Slideshow::find_by_id($slideshowId);
	$status 		= ($slideshowInfo->status==1)?"checked":"";
	$unstatus 	    = ($slideshowInfo->status==0)?"checked":"";
endif;	
?>
<h3>
AddEdit Slideshow
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewSlideshowlist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="slideshow_frm">
        <div class="row">
        <div class="form-row col-md-12">
            <div class="form-input col-md-10">
               <input type="file" name="slideshow_upload" id="slideshow_upload" class="btn medium primary-bg">
            </div>
        </div>
        <!-- Upload user image preview -->
        <div id="preview_Image"></div>              
    </div>  
        	
               
    		
            <div class="form-row">                
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio" name="status" id="check1" value="1" <?php echo !empty($status)?$status:"checked";?>>
                    <label for="">Published</label>
                    <input type="radio" class="custom-radio" name="status" id="check0" value="0" <?php echo !empty($unstatus)?$unstatus:"";?>>
                    <label for="">Un-Published</label>
                </div>                
            </div>              
            <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
            </button>
            <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($slideshowInfo->id)?$slideshowInfo->id:0;?>" />
         </form>    
    </div>
</div>  
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#slideshow_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/slideshow/',thumb_width:200,thumb_height:200},
	'method'     : 'post',
    'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
    'auto'       : true,
	'multi'      : true,	
	'hideButton' : false,	
	'buttonText' : 'Upload Image',
	'width'      : 125,
	'height'	 : 21,
	'removeCompleted' : true,
	'progressData' : 'speed',
	'uploadLimit' : 100,
	'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
	 'buttonClass' : 'button formButtons',
   /* 'checkExisting' : '/uploadify/check-exists.php',*/
  	'onUploadSuccess' : function(file, data, response) {
		$('#uploadedImageName').val('1');
		var filename =  data;
		$.post('<?php echo BASE_URL;?>apanel/slideshow/uploaded_slideshow.php',{imagefile:filename},function(msg){			
			   $('#preview_Image').append(msg).show();
			}); 
		    
    },
	'onDialogOpen'      : function(event,ID,fileObj) {		
    },
	'onUploadError' : function(file, errorCode, errorMsg, errorString) {
           alert(errorMsg);
        },
	'onUploadComplete' : function(file) {
          //alert('The file ' + file.name + ' was successfully uploaded');
        } 	
  });
});
    // ]]>
</script>



<?php endif; ?>
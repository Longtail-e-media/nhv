<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_testimonial"; // Database table name
$moduleId 		  = 18;				// module id >>>>> tbl_modules
$moduleFoldername = "testimonial";		// Image folder name

if(isset($_GET['page']) && $_GET['page'] == "testimonial" && isset($_GET['mode']) && $_GET['mode']=="list"):
clearImages($moduleTablename, $moduleFoldername);
clearImages($moduleTablename, $moduleFoldername."/thumbnails");	
?>
<h3>
List Testimonial
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewtestimonial();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-plus-square"></i>
    </span>
    <span class="button-content"> Add New </span>
</a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
        <thead>
            <tr>
               <th style="display:none;"></th>
               <th class="text-center"><input class="check-all" type="checkbox" /></th>
               <th class="text-center">Name</th>
               <th class="text-center">Country</th>                
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Testimonial::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->name;?>"><?php echo $record->name;?></a>
                    </div>
                </td>
                <td><?php echo $record->country;?></td>                                          
                <td class="text-center">
					<?php	
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editRecord(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordDelete(<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
					<input name="sortId" type="hidden" value="<?php echo $record->id;?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<div class="pad0L col-md-2">
<select name="dropdown" id="groupTaskField" class="custom-select">
    <option value="0"><?php echo $GLOBALS['basic']['choseAction'];?></option>
    <option value="delete"><?php echo $GLOBALS['basic']['delete'];?></option>
    <option value="toggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
</select>
</div>
<a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">
    <span class="glyph-icon icon-separator float-right">
      <i class="glyph-icon icon-cog"></i>
    </span>
    <span class="button-content"> Submit </span>
</a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
	$testimonialId 	= addslashes($_REQUEST['id']);
	$testimonialInfo   = Testimonial::find_by_id($testimonialId);
	$status 	= ($testimonialInfo->status==1)?"checked":" ";
	$unstatus 	= ($testimonialInfo->status==0)?"checked":" ";
endif;	
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit testimonial':'Add New testimonial';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewtestimoniallist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="testimonial_frm">
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Name :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Name" class="col-md-6 validate[required,length[0,200]]" type="text" name="name" id="name" value="<?php echo !empty($testimonialInfo->name)?$testimonialInfo->name:"";?>">
                </div>                
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Country :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Country" class="col-md-6 " type="text" name="country" id="country" value="<?php echo !empty($testimonialInfo->country)?$testimonialInfo->country:"";?>">
                   
                </div>                
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Image :
                    </label>
                </div> 
                
                <?php if(!empty($testimonialInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg<?php echo $testimonialInfo->id;?>">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/testimonial/".$testimonialInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/testimonial/".$testimonialInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavetestimonialimage(<?php echo $testimonialInfo->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'testimonial/thumbnails/'.$testimonialInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader <?php echo !empty($testimonialInfo->image)?"hide":"";?>">          
                   <input type="file" name="image" id="image_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (240 px X 130 px)</small></label> 
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image"><input type="hidden" name="imageArrayname" value="<?php echo !empty($testimonialInfo->image)?$testimonialInfo->image:"";?>" class="" /></div>
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Link Url :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Link Url" class="col-md-6 " type="text" name="linksrc" id="linksrc" value="<?php echo !empty($testimonialInfo->linksrc)?$testimonialInfo->linksrc:"";?>">
                   
                </div>                
            </div>

             <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Grade :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <select class="col-md-4" name="grade">
                        <option value="0">Choose Grade</option>
                        <?php for($i=1; $i<=5; $i++){
                            $sel = (@$testimonialInfo->grade==$i)?' selected':'';
                            echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
                        } ?>
                    </select>                   
                </div>                
            </div>

            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Content :
                    </label>
                </div> 
            	<div class="form-label col-md-10">                    
                    <textarea name="content" id="content" class="large-textarea validate[required]"><?php echo !empty($testimonialInfo->content)?$testimonialInfo->content:"";?></textarea>
                    <!--<a class="btn medium bg-orange mrg5T" title="Read More" id="readMore" href="javascript:void(0);">
                        <span class="button-content">Read More</span>
                    </a>-->
                </div>            
            </div>
             
            <div class="form-row">   
            	<div class="form-label col-md-2">
                    <label for="">
                        Published :
                    </label>
                </div>             
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio" name="status" id="check1" value="1" <?php echo !empty($status)?$status:"checked";?>>
                    <label for="">Published</label>
                    <input type="radio" class="custom-radio" name="status" id="check0" value="0" <?php echo !empty($unstatus)?$unstatus:"";?>>
                    <label for="">Un-Published</label>
                </div>                
            </div> 
           
            <button btn-action='0' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
            </button>
            <?php if(!isset($_GET['id'])){?>
            <button btn-action='1' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save & More
                </span>
            </button>
            <?php }?>
            <button btn-action='2' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save & quit
                </span>
            </button>
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($testimonialInfo->id)?$testimonialInfo->id:0;?>" />
         </form>    
    </div>
</div>   
<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["content"];
create_editor(base_url,editor_arr);
</script>

<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#image_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'   : {PROJECT : '<?php echo SITE_FOLDER; ?>',targetFolder:'images/testimonial/',thumb_width:265,thumb_height:170},
    'method'     : 'post',
    'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
    'auto'       : true,
    'multi'      : false,   
    'hideButton' : false,   
    'buttonText' : 'Upload Image',
    'width'      : 125,
    'height'     : 21,
    'removeCompleted' : true,
    'progressData' : 'speed',
    'uploadLimit' : 100,
    'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
     'buttonClass' : 'button formButtons',
   /* 'checkExisting' : '/uploadify/check-exists.php',*/
    'onUploadSuccess' : function(file, data, response) {
        $('#uploadedImageName').val('1');
        var filename =  data;
        $.post('<?php echo BASE_URL;?>apanel/testimonial/uploaded_image.php',{imagefile:filename},function(msg){          
               $('#preview_Image').html(msg).show();
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
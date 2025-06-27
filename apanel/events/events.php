
<?php
$moduleTablename  = "tbl_events"; // Database table name
$moduleId 		  = 9;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name

if(isset($_GET['page']) && $_GET['page'] == "events" && isset($_GET['mode']) && $_GET['mode']=="list"):	
?>
<h3>
List Events
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewEvents();">
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
               <th>Title</th>
               <th class="text-center">Start Date</th>   
               <th class="text-center">Event Status</th>           
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Events::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->title;?>"><?php echo $record->title;?></a>
                    </div>
                </td>
                <td><?php echo $record->event_stdate;?></td>
                <td><?php echo ($record->type==1)?'Ongoing':'Upcoming';?></td>                
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
    <span class="button-content"> Click </span>
</a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
	$eventsId 	= addslashes($_REQUEST['id']);
	$eventsInfo   = Events::find_by_id($eventsId);
	$status 	= ($eventsInfo->status==1)?"checked":"";
	$unstatus 	= ($eventsInfo->status==0)?"checked":"";

    $type     = ($eventsInfo->type==1)?"checked":"";
    $untype   = ($eventsInfo->type==2)?"checked":"";
endif;	
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit Events':'Add Events';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="vieweventslist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="events_frm">
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Events Title" class="col-md-6 validate[required,length[0,250]]" type="text" name="title" id="title" value="<?php echo !empty($eventsInfo->title)?$eventsInfo->title:"";?>">
                </div>                
            </div>               
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Date :
                    </label>
                </div>                
                <div class="form-input col-md-12">
                	<div class="col-md-4">
                    	<input placeholder="Start From" type="text" name="event_stdate" id="event_stdate" placeholder="From" class="validate[required] datepicker" value="<?php echo !empty($eventsInfo->event_stdate)?$eventsInfo->event_stdate:"";?>">
                    </div>
                    <div class="col-md-2">
                    	<input placeholder="End To" type="text" name="event_endate" id="event_endate" placeholder="To" class="validate[required] datepicker" value="<?php // echo !empty($eventsInfo->event_endate)?$eventsInfo->event_endate:"";?>">
                    </div>
                </div>               
            </div>    
                 
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Brief :
                    </label>
                </div>                
                <div class="form-input col-md-10">
                    <textarea placeholder="Events brief" class="col-md-8 validate[required,length[0,250]]" type="text" name="brief" id="brief"><?php echo !empty($eventsInfo->brief)?$eventsInfo->brief:"";?></textarea>
                </div>                
            </div>    

            <div class="form-row add-image">
                <div class="form-label col-md-2">
                    <label for="">
                        Banner Image :
                    </label>
                </div> 
                <div class="form-input col-md-10 uploader">          
                   <input type="file" name="banner_image" id="banner_image" class="transparent no-shadow">
                   <!-- <label><small>Image Dimensions (864 px X 315 px)</small></label> -->
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image"><input type="hidden" name="imageArrayname[]" /></div>
            </div>      

            <div class="form-row">
            <?php 
                if(!empty($eventsInfo->image)):
                $imageRec = unserialize($eventsInfo->image);
                if($imageRec):
                    foreach($imageRec as $k=>$imageRow): ?>
                        <div class="col-md-3" id="removeSavedimg<?php echo $k;?>">
                            <div class="infobox info-bg">                                                               
                                <div class="button-group" data-toggle="buttons">
                                    <span class="float-left">
                                        <?php 
                                            if(file_exists(SITE_ROOT."images/events/".$imageRow)):
                                                $filesize = filesize(SITE_ROOT."images/events/".$imageRow);
                                                echo 'Size : '.getFileFormattedSize($filesize);
                                            endif;
                                        ?>
                                    </span> 
                                    <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedimage(<?php echo $k;?>);">
                                        <i class="glyph-icon icon-trash-o"></i>
                                    </a>                                                       
                                </div>
                                <img src="<?php echo IMAGE_PATH.'events/thumbnails/'.$imageRow;?>"  style="width:100%"/>                                                                                   
                                <input type="hidden" name="imageArrayname[]" value="<?php echo $imageRow;?>" />
                            </div> 
                        </div>
                <?php endforeach;
                endif;
                endif;?>
            </div>

    		<div class="form-row">
            	<div class="form-label col-md-12">
                    <label for="">
                        Content :
                    </label>
                    <textarea name="content" id="content" class="large-textarea validate[required]"><?php echo !empty($eventsInfo->content)?$eventsInfo->content:"";?></textarea>
                    <a class="btn medium bg-orange mrg5T" title="Read More" id="readMore" href="javascript:void(0);">
                        <span class="button-content">Read More</span>
                    </a>
                </div>            
            </div>


              <div class="form-row add-image">
                <div class="form-label col-md-2">
                    <label for="">
                        Gallery :
                    </label>
                </div> 
              <div class="form-input col-md-10 uploader">          
                   <input type="file" name="gallery" id="gallery" class="transparent no-shadow">
                   <label><small>Image Dimensions (500 px X 500 px)</small></label>
                </div>                
                <!-- Upload user Gallery image preview -->
                <div id="preview_gallery"><input type="hidden" name="galleryArrayname[]" /></div>
            </div>   
        
            <div class="form-row ">                                
                <?php if(!empty($eventsInfo->gallery)):
                $imgall = unserialize($eventsInfo->gallery);
                 if($imgall){
                    foreach($imgall as $imgk=>$imgv){ ?>
                    <div class="col-md-3" id="removeSavedimg<?php echo $imgk;?>">
                        <div class="infobox info-bg">                                                               
                            <div class="button-group" data-toggle="buttons">
                                <span class="float-left">
                                    <?php 
                                        if(file_exists(SITE_ROOT."images/events/gallery/".$imgv)):
                                            $filesize = filesize(SITE_ROOT."images/events/gallery/".$imgv);
                                            echo 'Size : '.getFileFormattedSize($filesize);
                                        endif;
                                    ?>
                                </span> 
                                <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedgalimage('<?php echo $imgk;?>');">
                                    <i class="glyph-icon icon-trash-o"></i>
                                </a>                                                       
                            </div>
                            <img src="<?php echo IMAGE_PATH.'events/gallery/thumbnails/'.$imgv;?>"  style="width:100%"/>                                                                                   
                            <input type="hidden" name="galleryArrayname[]" value="<?php echo $imgv;?>" class="" />
                        </div> 
                    </div>
                    <?php }
                    } 
                endif;?>
                
            </div>

            <div class="form-row">   
                <div class="form-label col-md-2">
                    <label for="">
                        Event Type :
                    </label>
                </div>             
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio" name="type" id="check1" value="1" <?php echo !empty($type)?$type:"";?>>
                    <label for="">Ongoing</label>
                    <input type="radio" class="custom-radio" name="type" id="check0" value="2" <?php echo !empty($untype)?$untype:"checked";?>>
                    <label for="">Upcoming</label>
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
            <!-- Meta Tags-->
            <div class="form-row">              
                <div class="form-checkbox-radio col-md-9">
                	<a class="btn medium bg-blue" href="javascript:void(0);" onClick="toggleMetadata();">
                        <span class="glyph-icon icon-separator float-right">
                        	<i class="glyph-icon icon-caret-down"></i>
                        </span>
                        <span class="button-content"> Metadata Info </span>
                    </a>
                </div>                
            </div>  
            <div class="form-row <?php echo (!empty($eventsInfo->meta_keywords) || !empty($eventsInfo->meta_description))?'':'hide';?> metadata">   
            	<div class="col-md-6">
                	<textarea placeholder="Meta Keyword" name="meta_keywords" id="meta_keywords" class="character-keyword validate[required]"><?php echo !empty($eventsInfo->meta_keywords)?$eventsInfo->meta_keywords:"";?></textarea>
                    <div class="keyword-remaining clear input-description">250 characters left</div>
                </div>  
                <div class="col-md-6">
                	<textarea placeholder="Meta Description" name="meta_description" id="meta_description" class="character-description validate[required]"><?php echo !empty($eventsInfo->meta_description)?$eventsInfo->meta_description:"";?></textarea>
                    <div class="description-remaining clear input-description">160 characters left</div>
                </div>                
            </div>
                       
            <button btn-action='0' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
            </button>
            <button btn-action='1' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save & More
                </span>
            </button>
            <button btn-action='2' type="submit" name="submit" class="btn-submit btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save & quit
                </span>
            </button>
            <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($eventsInfo->id)?$eventsInfo->id:0;?>" />
         </form>    
    </div>
</div>   
<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["content"];
create_editor(base_url,editor_arr);
</script>

<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
$(document).ready(function() {
    $('#banner_image').uploadify({
        'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
        'uploader'    : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
        'formData'    : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/events/',thumb_width:380,thumb_height:478},
        'method'   : 'post',
        'cancelImg' : '<?php echo BASE_URL;?>uploadify/cancel.png',
        'auto'      : true,
        'multi'     : true, 
        'hideButton': false,    
        'buttonText' : 'Upload Image',
        'width'     : 125,
        'height'    : 21,
        'removeCompleted' : true,
        'progressData' : 'speed',
        'uploadLimit' : 100,
        'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
        'buttonClass' : 'button formButtons',
       /* 'checkExisting' : '/uploadify/check-exists.php',*/
        'onUploadSuccess' : function(file, data, response) {
            $('#uploadedImageName').val('1');
            var filename =  data;
            $.post('<?php echo BASE_URL;?>apanel/events/banner_image.php',{imagefile:filename},function(msg){            
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
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#gallery').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/events/gallery/',thumb_width:200,thumb_height:200},
    'method'     : 'post',
    'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
    'auto'       : true,
    'multi'      : true,   
    'hideButton' : false,   
    'buttonText' : 'Upload Image',
    'width'      : 100,
    'height'     : 25,
    'removeCompleted' : true,
    'progressData' : 'speed',
    'uploadLimit' : 100,
    'fileTypeExts' : '*.gif; *.jpg; *.jpeg;  *.png; *.GIF; *.JPG; *.JPEG; *.PNG;',
     'buttonClass' : 'button formButtons',
   /* 'checkExisting' : '/uploadify/check-exists.php',*/
    'onUploadSuccess' : function(file, data, response) {
        $('#uploadedImageName').val('1');
        var filename =  data;
        $.post('<?php echo BASE_URL;?>apanel/events/uploaded_gallery.php',{imagefile:filename},function(msg){           
               $('#preview_gallery').append(msg).show();
            }); 
            
    },
    'onDialogOpen'  : function(event,ID,fileObj) {      
    },
    'onUploadError' : function(file, errorCode, errorMsg, errorString) {
           alert(errorMsg);
        },
    'onUploadComplete' : function(file) {
          //alert('The file ' + file.name + ' was successfully uploaded');
        }   
  });
});

</script>
<?php endif; ?>
<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_hotels"; // Database table name
$moduleId 		  = 21;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name

if(isset($_GET['page']) && $_GET['page'] == "hotels" && isset($_GET['mode']) && $_GET['mode']=="list"):
clearImages($moduleTablename, "hotels");
clearImages($moduleTablename, "hotels/thumbnails");
$parentId = (isset($_REQUEST['id']) and !empty($_REQUEST['id']))?addslashes($_REQUEST['id']):0;
?>
<h3>
List Hotels
<?php if(!empty($_REQUEST['id'])){ ?> 
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewHotelslist(0);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
<?php }?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewHotels();">
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
               <th class="text-center">Title</th>    
               <th class="text-center">Hotels</th>     
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Hotels::find_all_byparnt($parentId);    
                  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><?php echo $record->title;?></td>                 
                <td class="text-center">
                <?php $countChild = Hotels::getTotalChild($record->id);
                if($countChild){ ?>
                	<a class="primary-bg medium btn loadingbar-demo" title="" <?php echo ($countChild)?'onClick="viewChildlist('.$record->id.');"':'';?> href="javascript:void(0);">
                        <span class="button-content">
                            <span class="badge bg-orange radius-all-4 mrg5R" title="" data-original-title="Badge with tooltip"><?php echo $countChild;?></span>
                            <span class="text-transform-upr font-bold font-size-11">View Lists</span>
                        </span>
                    </a>
                <?php }else{ echo 'N/A'; } ?>
              </td>                
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
    $hotelsId  = addslashes($_REQUEST['id']);
    $hotelsInfo   = Hotels::find_by_id($hotelsId);
    $status     = ($hotelsInfo->status==1)?"checked":" ";
    $unstatus   = ($hotelsInfo->status==0)?"checked":" ";
endif;  
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit Hotels':'Add Hotels';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewHotelslist(<?php echo !empty($hotelsInfo->parentId)?$hotelsInfo->parentId:0;?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <form action="" class="col-md-12 center-margin" id="hotels_frm">
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Parent :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <?php $Parentview = !empty($hotelsInfo->parentId)?$hotelsInfo->parentId:0;
                        echo Hotels::get_parentList_bylevel(1,$Parentview); ?>                
                </div>                
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Title" class="col-md-6 validate[required,length[0,50]]" type="text" name="title" id="title" value="<?php echo !empty($hotelsInfo->title)?$hotelsInfo->title:"";?>">
                </div>                
            </div>                                 
            <div class="form-row add-image">
                <div class="form-label col-md-2">
                    <label for="">
                        Image :
                    </label>
                </div> 
                
                <?php if(!empty($hotelsInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg<?php echo $hotelsInfo->id;?>">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/hotels/".$hotelsInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/hotels/".$hotelsInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedHotelsimage(<?php echo $hotelsInfo->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'hotels/thumbnails/'.$hotelsInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader<?php echo $hotelsInfo->id;?> <?php echo !empty($hotelsInfo->image)?"hide":"";?>">          
                   <input type="file" name="hotels_upload" id="hotels_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (293px X 215px)</small></label>
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image"><input type="hidden" name="imageArrayname" value="<?php echo !empty($hotelsInfo->image)?$hotelsInfo->image:"";?>" class="" /></div>
            </div> 

            <div class="form-row add-image">
                <div class="form-label col-md-2">
                    <label for="">
                        Banner Image :
                    </label>
                </div> 
                
                <?php if(!empty($hotelsInfo->banner_image)):?>
                <div class="col-md-3" id="removeSavedimgb<?php echo $hotelsInfo->id;?>">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/hotels/banner/".$hotelsInfo->banner_image)):
                                        $filesize = filesize(SITE_ROOT."images/hotels/banner/".$hotelsInfo->banner_image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right bannerImg" href="javascript:void(0);" onclick="deleteSavedHotelsimage('b<?php echo $hotelsInfo->id;?>');">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'hotels/banner/thumbnails/'.$hotelsInfo->banner_image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploaderb<?php echo $hotelsInfo->id;?> <?php echo !empty($hotelsInfo->banner_image)?"hide":"";?>">          
                   <input type="file" name="banner_upload" id="banner_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (1353px X 253px)</small></label>
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image2"><input type="hidden" name="imageArrayname2" value="<?php echo !empty($hotelsInfo->banner_image)?$hotelsInfo->banner_image:"";?>" class="" /></div>
            </div>

            <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Brief :
                    </label>
                </div> 
                <div class="form-input col-md-8">          
                   <textarea name="brief" id="brief" class="large-textarea"><?php echo !empty($hotelsInfo->brief)?$hotelsInfo->brief:"";?></textarea>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Price Range :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="Price Range" class="col-md-6" type="text" name="price_range" id="price_range" value="<?php echo !empty($hotelsInfo->price_range)?$hotelsInfo->price_range:"";?>">
                </div>                
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Star :
                    </label>
                </div>                
                <div class="form-input col-md-2">
                    <select name="grade" id="grade" class="">
                        <option value="">Choose Grade</option>
                        <?php for($i=1; $i<=5; $i++){
                            echo '<option value="'.$i.'">'.$i.'</option>';
                        } ?>
                    </select>
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($hotelsInfo->id)?$hotelsInfo->id:0;?>" />
         </form>    
    </div>
</div>   

<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
CKEDITOR.replace( 'brief',{
    toolbar :
    [   
        { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },                   
        { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },'/',
        { name: 'colors', items : [ 'TextColor','BGColor' ] },
        { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
    ]
});
</script>

<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#hotels_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/hotels/',thumb_width:200,thumb_height:200},
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
        $.post('<?php echo BASE_URL;?>apanel/hotels/uploaded_image.php',{imagefile:filename},function(msg){           
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

    $('#banner_upload').uploadify({
        'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
        'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
        'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/hotels/banner/',thumb_width:200,thumb_height:200},
        'method'     : 'post',
        'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
        'auto'       : true,
        'multi'      : true,    
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
            $('#uploadedImageName2').val('1');
            var filename =  data;
            $.post('<?php echo BASE_URL;?>apanel/hotels/banner_image.php',{imagefile:filename},function(msg){           
                   $('#preview_Image2').html(msg).show();
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
<?php 
if(isset($_GET['page']) && $_GET['page'] == "gallery" && isset($_GET['mode']) && $_GET['mode']=="galleryimagelist"):
clearImages("tbl_gallery_images", "gallery/galleryimages");
clearImages("tbl_gallery_images", "gallery/galleryimages/thumbnails");  
$id = intval(addslashes($_GET['id'])); 
?>
<h3>
List Galleries Images ["<?php echo Gallery::getGalleryName($id);?>"]
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewGalleryImage(<?php echo $id;?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-plus-square"></i>
    </span>
    <span class="button-content"> Add New </span>
</a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="sub-example">
        <thead>
            <tr>
               <th class="text-center">S.No.</th>
               <th class="text-center">Title</th>       
               <th class="text-center">Size</th>       
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $subrecords = GalleryImage::find_by_sql("SELECT * FROM tbl_gallery_images WHERE galleryid='{$id}' ORDER BY sortorder DESC");   
                  foreach($subrecords as $key=>$subrecord): ?>    
            <tr id="<?php echo $subrecord->id;?>">
                <td class="text-center"><?php echo $key+1;?></td>
                <td>
                    <div class="top-icon-bar dropdown">
                        <a href="javascript:void(0);" title="" class="user-ico clearfix" data-toggle="dropdown">
                            <span><?php echo $subrecord->title;?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="infobox info-bg mrg0B">                                 
                                    <img src="<?php echo IMAGE_PATH.'gallery/galleryimages//thumbnails/'.$subrecord->image;?>"  style="width:100%"/>
                                    <span><?php echo $subrecord->title;?></span>                              
                                </div>                                 
                            </li>
                        </ul>
                    </div>                  
                </td>         
                <td class="text-center">
                    <?php 
                    $filesize = filesize(SITE_ROOT."images/gallery/galleryimages/".$subrecord->image);
                    echo getFileFormattedSize($filesize);
                    ?>
                </td>
                <td class="text-center">
                    <?php   
                        $statusImage = ($subrecord->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($subrecord->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusSubToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $subrecord->status;?>" id="imgHolder_<?php echo $subrecord->id;?>" moduleId="<?php echo $subrecord->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editGalleryImageRecord(<?php echo $subrecord->galleryid;?>,<?php echo $subrecord->id;?>);">
                        <i class="glyph-icon icon-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="subrecordDelete(<?php echo $subrecord->id;?>);">
                        <i class="glyph-icon icon-remove"></i>
                    </a>
                    <input name="sortId" type="hidden" value="<?php echo $subrecord->id;?>">
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addeditgalleryimage"): ?>
<h3>
<?php 
$mid = addslashes($_REQUEST['id']);
$parenttitle =  ' ['.Gallery::getGalleryName($mid).'] ';
echo (isset($_GET['subid']))?'Edit '.$parenttitle .' Gallery':'Add '.$parenttitle .' Gallery';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewGallerylist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>
<div class="my-msg"></div>
<?php
if(isset($_GET['subid']) && !empty($_GET['subid'])):
    $galleryId  = addslashes($_REQUEST['subid']);
    $galleryInfo   = GalleryImage::find_by_id($galleryId);
endif;
?>
<div class="example-box">
    <div class="example-code">                       
         <form action="" class="col-md-12 center-margin" method="post" id="subgallery_frm" >
            <div class="form-row add-image">                
                <div class="form-label col-md-2">
                    <label for="">
                        Image :
                    </label>
                </div>                    
                <?php if(!empty($galleryInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg<?php echo $galleryInfo->id;?>">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/gallery/galleryimages/".$galleryInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/gallery/galleryimages/".$galleryInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedGalleryimage(<?php echo $galleryInfo->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'gallery/galleryimages/thumbnails/'.$galleryInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                    <div class="form-input col-md-10 uploader <?php echo !empty($galleryInfo->image)?"hide":"";?>">                       
                       <input type="file" name="gallery_imgupload" id="gallery_imgupload" class="transparent no-shadow">
                       <label><small>Image Dimensions (<?php echo Module::get_properties($moduleId,'simgwidth');?> px X <?php echo Module::get_properties($moduleId,'simgheight');?> px)</small></label>
                    </div>
                    <!-- Upload user image preview -->
                    <div id="previewUser_Image"><input type="hidden" name="imageArrayname" value="<?php echo !empty($galleryInfo->image)?$galleryInfo->image:"";?>" class="" /></div> 
                </div>
                <div class="form-row">                    
                    <div class="form-label col-md-2">
                        <label for="">
                            Title :
                        </label>
                    </div>   
                    <div class="form-input col-md-10"> 
                       <input type="text" name="title" id="title" value="<?php echo !empty($galleryInfo->title)?$galleryInfo->title:"";?>" class="col-md-6">
                    </div>  
                </div>
                <div class="form-row">    
                    <div class="form-input col-md-10 mrg10T">
                        <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4 btn-submit" id="btn-submit" title="Save">
                            <span class="button-content">
                                Save
                            </span> 
                        </button>  
                    </div>
                </div>
               <input type="hidden" name="galleryid" id="galleryid" value="<?php echo !empty($mid)?$mid:0;?>" />                             
               <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($galleryInfo)?$galleryInfo->id:0;?>" />                             
            </div>     
        </form>    
    </div>
</div>
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#gallery_imgupload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'    : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'      : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/gallery/galleryimages/',thumb_width:200,thumb_height:200},
    'method'   : 'post',
    'cancelImg' : '<?php echo BASE_URL;?>uploadify/cancel.png',
    'auto'      : true,
    'multi'     : false, 
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
        $.post('<?php echo BASE_URL;?>apanel/gallery/uploaded_gallery_image.php',{imagefile:filename},function(msg){            
               $('#previewUser_Image').html(msg).show();
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
<?php endif;?>
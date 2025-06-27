<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_review"; // Database table name
$moduleId         = 31;              // module id >>>>> tbl_modules
$moduleFoldername = "reviews";     // Image folder name

if(isset($_GET['page']) && $_GET['page'] == "review" && isset($_GET['mode']) && $_GET['mode']=="list"):   
/*clearImages($moduleTablename, $moduleFoldername);
clearImages($moduleTablename, $moduleFoldername."/thumbnails");*/
?>
<h3>
List Reviews

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
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Review::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");  
                  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editReview(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->name;?>"><?php echo $record->name;?></a>
                    </div>
                </td>               
                <td class="text-center">
                    <?php   
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button"
                           data-placement="top" title="View detail" onclick="editReview(<?php echo $record->id; ?>);">

                            <span class="button-content"> View Detail </span>


                        </a>
                   
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="recordReviewDelete(<?php echo $record->id;?>);">
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

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "EditReview"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
    $reviewId     = addslashes($_REQUEST['id']);
    $reviewInfo   = Review::find_by_id($reviewId);
    
    //echo "<pre>";var_dump($reviewInfo);die();
  
endif;  
?>
<h3>
<?php echo (isset($_GET['id']))?'View Review':'View Review';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewreviewlist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
 <table cellpadding="0" cellspacing="0" border="0" class="table">

        <thead>

        <tr>

            <th style="display:none;"></th>


        </tr>

        </thead>


        <tbody>

        <?php $record = Review::find_by_sql("SELECT * FROM " . $moduleTablename . " ORDER BY sortorder DESC ");
        //echo "<pre>";var_dump($record);die();

        ?>

        <tr id="<?php echo $record->id; ?>"></tr>

        <td style="display:none;"><?php echo $reviewInfo->sortorder; ?></td>

        <tr>
            <th>Name</th>
            <td><?php echo $reviewInfo->name; ?></td>
        </tr>
        <tr>
            <th class="text-center">Address</th>
            <td><?php echo $reviewInfo->address; ?></td>
        </tr>
        <tr>
            <th class="text-center">Country</th>
            <td><?php echo $reviewInfo->country; ?></td>
        </tr>


        <tr>
            <th class="text-center">Email</th>
            <td><?php echo $reviewInfo->email; ?></td>
        </tr>


        <tr>
            <th class="text-center">Comments</th>
            <td><?php echo $reviewInfo->comments; ?></td>
        </tr>

       <tr>
            <th class="text-center">Image</th>
            <td><a href='../../../images/reviews/<?php echo $reviewInfo->myfile; ?>' target="_blank"><?php echo $reviewInfo->myfile; ?></a></td>
        </tr>




        </tbody>

    </table>

<!-- <script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["content"];
create_editor(base_url,editor_arr);
</script>
 -->
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<!-- <script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#gallery_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/articles/',thumb_width:200,thumb_height:200},
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
        $.post('<?php echo BASE_URL;?>apanel/articles/uploaded_image.php',{imagefile:filename},function(msg){           
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
</script> -->
<?php endif; ?>
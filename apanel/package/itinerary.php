<?php
$ItineraryTablename  = "tbl_itinerary"; // Database table name
if(isset($_GET['page']) && $_GET['page'] == "package" && isset($_GET['mode']) && $_GET['mode']=="itinerarylist"):
$id = intval(addslashes($_GET['id']));
    clearImages($ItineraryTablename, "package/itinerary");
    clearImages($ItineraryTablename, "package/itinerary/thumbnails");
?>
<h3>
List Itinerary ["<?php echo Package::field_by_id($id, 'title');?>"]
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewItinerary(<?php echo $id;?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-plus-square"></i>
    </span>
    <span class="button-content"> Add New </span>
</a>
<a class="loadingbar-demo btn medium bg-blue-alt float-right mrg5R" href="javascript:void(0);" onClick="viewPackagelist();">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="subexample1">
        <thead>
            <tr>
               <th style="display:none;"></th>
               <th class="text-center"><input class="check-all" type="checkbox" /></th>
               <th>Day</th>         
               <th class="text-center">Order</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Itinerary::find_by_sql("SELECT * FROM ".$ItineraryTablename." WHERE package_id=".$id." ORDER BY sortorder ASC "); 
                  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td>
                    <div class="col-md-7">
                        <a href="javascript:void(0);" onClick="editItinerary(<?php echo $record->package_id;?>,<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->day;?>"><?php echo $record->day;?></a>
                    </div>
                </td>       
                <td class="text-center"><?php echo $record->sortorder?></td>
                <td class="text-center">
                    <?php   
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusItinerary" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editItinerary(<?php echo $record->package_id;?>,<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="subreDelete(<?php echo $record->id;?>);">
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
<select name="dropdown" id="groupTaskField1" class="custom-select">
    <option value="0"><?php echo $GLOBALS['basic']['choseAction'];?></option>
    <option value="subidelete"><?php echo $GLOBALS['basic']['delete'];?></option>
    <option value="subitoggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
</select>
</div>
<a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn1">
    <span class="glyph-icon icon-separator float-right">
      <i class="glyph-icon icon-cog"></i>
    </span>
    <span class="button-content"> Submit </span>
</a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdititinerary"): 
$pid   = addslashes($_REQUEST['id']);
if(isset($_GET['subid']) and !empty($_GET['subid'])):
    $subpackageId   = addslashes($_REQUEST['subid']);
    $itineraryInfo  = Itinerary::find_by_id($subpackageId);
    $status     = ($itineraryInfo->status==1)?"checked":" ";
    $unstatus   = ($itineraryInfo->status==0)?"checked":" ";
    $breakfast = ($itineraryInfo->breakfast == 1) ? "checked" : " ";
    $lunch = ($itineraryInfo->lunch == 1) ? "checked" : " ";
    $dinner = ($itineraryInfo->dinner == 1) ? "checked" : " ";
endif;  
?>
<h3>
<?php echo (isset($_GET['subid']))?'Edit Itinerary':'Add Itinerary';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewItinerarylist(<?php echo $pid;?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <form action="" class="col-md-12 center-margin" id="itinerary_frm">
        <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Day:
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Day" class="col-md-4 validate[required]" type="text" name="day" id="day" value="<?php echo !empty($itineraryInfo->day)?$itineraryInfo->day:"";?>">
                </div>                
            </div>             
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title:
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Title" class="col-md-6 validate[required]" type="text" name="title" id="title" value="<?php echo !empty($itineraryInfo->title)?$itineraryInfo->title:"";?>">
                </div>                
            </div> 
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                       Image :
                    </label>
                </div> 
                <div class="form-input col-md-10 uploader1 <?php echo !empty($itineraryInfo->image)?"hide":"";?>">          
                   <input type="file" name="background_upload" id="background_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions 400 px X 400 px)</small></label>
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image"><input type="hidden" name="imageArrayname" class="" /></div>
                <?php if(!empty($itineraryInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg1">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/package/itinerary/".$itineraryInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/package/itinerary/".$itineraryInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedItineraryimage(1);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'package/itinerary/thumbnails/'.$itineraryInfo->image;?>"  style="width:100%"/>                                <input type="hidden" name="imageArrayname" value="<?php echo $itineraryInfo->image; ?>" class="" />                                                   
                    </div> 
                </div>
                <?php endif;?>
                
            </div> 
             <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Content :
                    </label>
                </div> 
                <div class="form-input col-md-8">          
                   <textarea name="content" id="content" class="large-textarea"><?php echo !empty($itineraryInfo->content)?$itineraryInfo->content:"";?></textarea>
                </div>
            </div>
            <!--  <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Included :
                    </label>
                </div> 
                    <div class="form-checkbox-radio col-md-9">
                        <input type="checkbox" class="custom-radio" name="breakfast" id="breakfast"
                               value="1" <?php echo !empty($breakfast) ? $breakfast : ""; ?>>
                        <label for="">Breakfast</label>
                       
                        <input type="checkbox" class="custom-radio" name="lunch" id="lunch"
                               value="1" <?php echo !empty($lunch) ? $lunch : ""; ?>>
                        <label for="">Lunch</label>

                        <input type="checkbox" class="custom-radio" name="dinner" id="dinner"
                               value="1" <?php echo !empty($dinner) ? $dinner : ""; ?>>
                        <label for="">Dinner</label>
                    </div>
                </div> -->

              <!--   <div class="form-row">
                    <div class="form-label col-md-2">
                    <label>Hotel :</label>
                </div>
            
                <div class="form-input col-md-3">
                    <select data-placeholder="None" name="hotel1" class="chosen-select validate[]" id="hotel1">
                        <option value="">Hotel</option>
                       

                        <?php $sql = "SELECT id, title FROM tbl_hotel WHERE status='1' ORDER BY sortorder ASC";
                        $hotel1 = Hotel::find_by_sql($sql); 
                        if(!empty($hotel1)) {

                            $result1.='<option>';
                            foreach($hotel1 as $hotelRow) {
                                

                                $sel = (!empty($itineraryInfo->hotel1) and $itineraryInfo->hotel1==$hotelRow->id) ?'selected':'';
                                $result1.='<option value="'.$hotelRow->id.'" '.$sel.'>'.$hotelRow->title.'</option>';
                            }
                            $result1.='</option>'; 
                        }
                        echo $result1; ?>

                    </select>
                </div>

                <div class="form-input col-md-3">
                    <select data-placeholder="None" name="hotel2" class="chosen-select validate[]" id="hotel2">
                        <option value="">Hotel</option>
                       

                        <?php $sql = "SELECT id, title FROM tbl_hotel WHERE status='1' ORDER BY sortorder ASC";
                        $hotel2 = Hotel::find_by_sql($sql); 
                        if(!empty($hotel2)) {

                            $result2.='<option>';
                            foreach($hotel2 as $hotelRow) {
                                

                                $sel = (!empty($itineraryInfo->hotel2) and $itineraryInfo->hotel2==$hotelRow->id) ?'selected':'';
                                $result2.='<option value="'.$hotelRow->id.'" '.$sel.'>'.$hotelRow->title.'</option>';
                            }
                            $result2.='</option>'; 
                        }
                        echo $result2; ?>

                    </select>
                </div>

                <div class="form-input col-md-3">
                    <select data-placeholder="None" name="hotel3" class="chosen-select validate[]" id="hotel3">
                        <option value="">Hotel</option>
                       

                        <?php $sql = "SELECT id, title FROM tbl_hotel WHERE status='1' ORDER BY sortorder ASC";
                        $hotel3 = Hotel::find_by_sql($sql); 
                        if(!empty($hotel3)) {

                            $result3.='<option>';
                            foreach($hotel3 as $hotelRow) {
                                

                                $sel = (!empty($itineraryInfo->hotel3) and $itineraryInfo->hotel3==$hotelRow->id) ?'selected':'';
                                $result3.='<option value="'.$hotelRow->id.'" '.$sel.'>'.$hotelRow->title.'</option>';
                            }
                            $result3.='</option>'; 
                        }
                        echo $result3; ?>

                    </select>
                </div>
            </div>
 -->
 

          
                                    
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($itineraryInfo->id)?$itineraryInfo->id:0;?>" />
            <!-- <input type="hidden" name="package_currency" id="package_currency" value="USD" /> -->
            <input type="hidden" name="package_id" id="package_id" value="<?php echo !empty($itineraryInfo->package_id)?$itineraryInfo->package_id:$pid;?>" />
         </form>    
    </div>
</div>  
<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["content"];
create_editor(base_url,editor_arr);
</script> 
<script type="text/javascript">
   // <![CDATA[
    $(document).ready(function() {
    $('#background_upload').uploadify({
    'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
    'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
    'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/package/itinerary/',thumb_width:200,thumb_height:200},
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
        $.post('<?php echo BASE_URL;?>apanel/package/uploaded_image1.php',{imagefile:filename},function(msg){            
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
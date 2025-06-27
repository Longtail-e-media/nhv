<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_hotel"; // Database table name
$moduleId 		  = 25;	
$moduleFoldername = "reservation";	
$destination= array(1=>'Nepal');		// module id >>>>> tbl_modules
$rating = array(1=>'One Star', 2=>'Two Star', 3=>'Three Star', 4=>'Four Star', 5=>'Five Star');

if(isset($_GET['page']) && $_GET['page'] == "reservation" && isset($_GET['mode']) && $_GET['mode']=="list"):	
 
?>
<h3>
List Hotel
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewHotel();">
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
               
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Hotel::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->title;?>"><?php echo $record->title;?></a>
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
	$HotelId 	   	= addslashes($_REQUEST['id']);
	$HotelInfo   	= Hotel::find_by_id($HotelId);
	$status 	= ($HotelInfo->status==1)?"checked":" ";
	$unstatus 	= ($HotelInfo->status==0)?"checked":" ";
    
    $external = ($HotelInfo->linktype==1)?"checked":" ";
    $internal = ($HotelInfo->linktype==0)?"checked":" ";
endif;	
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit Hotel':'Add Hotel';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewHotellist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="hotel_frm">
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Destination :
                    </label>
                </div>                
                <div class="form-input col-md-2">
                    <select data-placeholder="None" class="chosen-select validate[required]" id="destination" name="destination">
                        <option value="none">Choose</option>
                    <?php foreach ($destination as $key => $val) {
                           $sel = (!empty($HotelInfo->destination) and $HotelInfo->destination==$key)?'selected':'';
                           echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>' ;
                        }?>
                    </select>    
                </div>                
            </div>
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Title" class="col-md-6 validate[required,length[0,50]]" type="text" name="title" id="title" value="<?php echo !empty($HotelInfo->title)?$HotelInfo->title:"";?>">
                </div>                
            </div>                         
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                       Image :
                    </label>
                </div> 
                
                <?php if(!empty($HotelInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg1">
                    <div class="infobox info-bg">                            	                                
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/reservation/".$HotelInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/reservation/".$HotelInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedHotelimage(1);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'reservation/thumbnails/'.$HotelInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader1 <?php echo !empty($HotelInfo->image)?"hide":"";?>">          
                   <input type="file" name="background_upload" id="background_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (<?php echo Module::get_properties($moduleId,'imgwidth');?> px X <?php echo Module::get_properties($moduleId,'imgheight');?> px)</small></label>
                </div>                
                <!-- Upload user image preview -->
            	<div id="preview_Image"><input type="hidden" name="imageArrayname" value="" class="" /></div>
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Rating :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <select data-placeholder="None" class="chosen-select validate[required]" id="rating" name="rating">
                        <option value="none">Choose Rating</option>
                    <?php foreach ($rating as $key => $val) {
                           $sel = (!empty($HotelInfo->rating) and $HotelInfo->rating==$key)?'selected':'';
                           echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>' ;
                        }?>
                    </select>    
                </div>                
            </div>
            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Link Type :
                    </label>
                </div>
                <div class="form-checkbox-radio col-md-9">
                    <input id="" class="custom-radio" type="radio" name="linktype" value="0" onClick="linkTypeSelect(0);" <?php echo !empty($internal)?$internal:"checked";?>>
                    <label for="">Internal Link</label>
                    <input id="" class="custom-radio" type="radio" name="linktype" value="1" onClick="linkTypeSelect(1);" <?php echo !empty($external)?$external:"";?>>
                    <label for="">External Link</label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                         Hotel Link :
                    </label>
                </div>
                <div class="form-input col-md-8">
                    <div class="col-md-4" style="padding-left:0px !important;">
                        <input  placeholder="Hotel Link" class="" type="text" name="linksrc" id="linksrc" value="<?php echo !empty($HotelInfo->linksrc)?$HotelInfo->linksrc:"";?>">                    
                    </div>
                    <div class="col-md-6" style="padding-left:0px !important;">
                       <select data-placeholder="Select Link Page" class="col-md-4 chosen-select" id="linkPage">
                            <option value=""></option>
                            <?php 
                                $Lpageview = !empty($HotelInfo->linksrc)?$HotelInfo->linksrc:"";
                                $LinkTypeview = !empty($HotelInfo->linktype)?$HotelInfo->linktype:"";
                                // Article Page Link
                                echo Articles::get_internal_link($Lpageview,$LinkTypeview);
                            ?>
                        </select>  
                    </div>                    
                </div>
            </div>
             <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Content :
                    </label>
                </div> 
                <div class="form-input col-md-8">          
                   <textarea name="content" id="content" class="large-textarea"><?php echo !empty($HotelInfo->content)?$HotelInfo->content:"";?></textarea>
                </div>
            </div>


                          		
            <div class="form-row">     
            	<div class="form-label col-md-2">
                    <label for="">
                        Status :
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($HotelInfo->id)?$HotelInfo->id:0;?>" />
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
	$('#background_upload').uploadify({
	'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
	'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/reservation/',thumb_width:200,thumb_height:200},
	'method'     : 'post',
	'cancelImg'  : '<?php echo BASE_URL;?>uploadify/cancel.png',
	'auto'       : true,
	'multi'      : false,	
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
		$.post('<?php echo BASE_URL;?>apanel/reservation/uploaded_image.php',{imagefile:filename},function(msg){			
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
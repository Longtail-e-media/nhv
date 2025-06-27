<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_advertisement"; // Database table name
$moduleId 		  = 7;				// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name
$position = array(1=>'Left', 2=>'Top', 3=>'Right', 4=>'Bottom', 5=>'Member Block');
if(isset($_GET['page']) && $_GET['page'] == "advertisement" && isset($_GET['mode']) && $_GET['mode']=="list"):	
clearImages($moduleTablename, "advertisement");
clearImages($moduleTablename, "advertisement/thumbnails");
?>
<h3>
List Advertisement
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewAdvertisement();">
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
               <th class="text-center">Started Date</th>              
               <th class="text-center">Expired Date</th>              
               <th class="text-center">Display</th> 
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Advertisement::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td>
                	<div class="top-icon-bar dropdown">
                        <a href="javascript:void(0);" title="" class="user-ico clearfix" data-toggle="dropdown">
                            <span><?php echo $record->title;?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="infobox info-bg mrg0B">                                	
                                  	<img src="<?php echo IMAGE_PATH.'advertisement/thumbnails/'.$record->image;?>"  style="width:100%"/>
                                    <span><?php echo $record->title;?></span>                              
                                </div>                                 
                            </li>
                        </ul>
                    </div>  
                </td>
                <td><?php echo $record->date_from;?></td> 
                <td><?php echo $record->date_to;?></td>      
                <td class="text-center"><?php echo ($record->position)?$position[$record->position]:'N/A';?></td>         
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
	$advId 	   	= addslashes($_REQUEST['id']);
	$advInfo   	= Advertisement::find_by_id($advId);
	$status 	= ($advInfo->status==1)?"checked":" ";
	$unstatus 	= ($advInfo->status==0)?"checked":" ";
    $notyes     = ($advInfo->notif_status==1)?"checked":" ";
    $notno      = ($advInfo->notif_status==0)?"checked":" ";
endif;	
?>
<h3>
AddEdit Advertisement
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewadvertisementlist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="advertisment_frm">
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Advertisment Title" class="col-md-6 validate[required,length[0,50]]" type="text" name="title" id="title" value="<?php echo !empty($advInfo->title)?$advInfo->title:"";?>">
                </div>                
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Display :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <select data-placeholder="Select Display Path" class="chosen-select validate[required]" id="position" name="position">
                        <option value="">Choose Position</option>
                        <?php foreach ($position as $key => $val) {
                           $sel = (!empty($advInfo->position) and $advInfo->position==$key)?'selected':'';
                           echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>' ;
                        }?>
                    </select>  
                </div>                
            </div>   
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Image :
                    </label>
                </div> 
                
                <?php if(!empty($advInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg<?php echo $advInfo->id;?>">
                    <div class="infobox info-bg">                            	                                
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/advertisement/".$advInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/advertisement/".$advInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedAdvertisementimage(<?php echo $advInfo->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'advertisement/thumbnails/'.$advInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader <?php echo !empty($advInfo->image)?"hide":"";?>">          
                   <input type="file" name="gallery_upload" id="gallery_upload" class="transparent no-shadow">
                   <label><small>
                   Recommended Image Dimension Left (<?php echo Module::get_properties($moduleId,'limgwidth');?> px X <?php echo Module::get_properties($moduleId,'limgheight');?> px) <br />
                   Recommended Image Dimension Top (<?php echo Module::get_properties($moduleId,'timgwidth');?> px X <?php echo Module::get_properties($moduleId,'timgheight');?> px) <br />
                   Recommended Image Dimension Right (<?php echo Module::get_properties($moduleId,'rimgwidth');?> px X <?php echo Module::get_properties($moduleId,'rimgheight');?> px) <br />
                   Recommended Image Dimension Bottom (<?php echo Module::get_properties($moduleId,'bimgwidth');?> px X <?php echo Module::get_properties($moduleId,'bimgheight');?> px)
                   </small></label>
                </div>                
                <!-- Upload user image preview -->
            	<div id="preview_Image"><input type="hidden" name="imageArrayname" value="<?php echo !empty($advInfo->image)?$advInfo->image:"";?>" class="" /></div>
            </div>
                
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                       Custom :
                    </label>
                </div> 
                <div class="form-input col-md-12">                	
                	<div class="col-md-2">
                    	<input type="text" name="img_height" id="img_height" placeholder="Height (Px)" class="" value="<?php echo !empty($advInfo->img_height)?$advInfo->img_height:"";?>">
                    </div>                    
                    <div class="col-md-2">
                    	<input type="text" name="img_width" id="img_width" placeholder="Width (Px)" class="" value="<?php echo !empty($advInfo->img_width)?$advInfo->img_width:"";?>">
                    </div>
                </div>     
            </div>
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                       Display Date :
                    </label>
                </div> 
                <div class="form-input col-md-12">
                	<div class="col-md-2">
                    	<input type="text" name="date_from" id="date_from" placeholder="From" class="validate[required] datepicker" value="<?php echo !empty($advInfo->date_from)?$advInfo->date_from:"";?>">
                    </div>
                    <div class="col-md-2">
                    	<input type="text" name="date_to" id="date_to" placeholder="To" class="validate[required] datepicker" value="<?php echo !empty($advInfo->date_to)?$advInfo->date_to:"";?>">
                    </div>
                </div>     
            </div>
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Link :
                    </label>
                </div> 
                <div class="form-input col-md-4">          
                   <input placeholder="Advertisment Url Link" type="text" name="url_link" id="url_link" value="<?php echo !empty($advInfo->url_link)?$advInfo->url_link:"";?>">
                </div>
            </div>
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Notification Before :
                    </label>
                </div> 
                <div class="form-input col-md-2">          
                   <input placeholder="Before Day" type="text" name="notification" id="notification" class="validate[custom[integer],required]" value="<?php echo !empty($advInfo->notification)?$advInfo->notification:"";?>">              	</div>
            </div>
            <div class="form-row">     
                <div class="form-label col-md-2">
                    <label for="">
                        Notification To mail :
                    </label>
                </div>           
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio mailradio" name="notif_status" id="notyes" value="1" <?php echo !empty($notyes)?$notyes:"";?>>
                    <label for="">Yes</label>
                    <input type="radio" class="custom-radio mailradio" name="notif_status" id="notno" value="0" <?php echo !empty($notno)?$notno:"checked";?>>
                    <label for="">No</label>
                </div>                
            </div>

            <div class="form-row <?php echo !empty($advInfo->notif_status)?'':'hide'; ?> mailsentbox">
                <div class="form-label col-md-2">
                    <label for="">
                        Mail Format :
                    </label>
                </div> 
                <div class="form-input col-md-8">     
                   <input placeholder="Client Email Address" type="text" name="mail_to" id="mail_to" class="validate[required]" value="<?php echo !empty($advInfo->mail_to)?$advInfo->mail_to:"";?>"><br /><br />      
                   <textarea name="content" id="content" class="large-textarea"><?php echo !empty($advInfo->content)?$advInfo->content:"";?></textarea>
                </div>
            </div>
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Remarks :
                    </label>
                </div> 
                <div class="form-input col-md-4">          
                   <textarea name="remarks" id="remarks" class="large-textarea validate[required]"><?php echo !empty($advInfo->remarks)?$advInfo->remarks:"";?></textarea>
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($advInfo->id)?$advInfo->id:0;?>" />
         </form>    
    </div>
</div>   
<script type="text/javascript" src="<?php echo ASSETS_PATH; ?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
	$(document).ready(function() {
	$('#gallery_upload').uploadify({
	'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
	'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/advertisement/',thumb_width:200,thumb_height:200},
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
		$.post('<?php echo BASE_URL;?>apanel/advertisement/uploaded_image.php',{imagefile:filename},function(msg){			
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
<script>
    $(document).ready(function() {
/************************************ Editor for message *****************************************/
    var base_url =  "<?php echo ASSETS_PATH; ?>";
    CKEDITOR.replace( 'content',{
            toolbar :
            [   
                { name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },                   
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },'/',
                { name: 'colors', items : [ 'TextColor','BGColor' ] },
                { name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
            ]
        });
    });
</script>
<?php endif; ?>
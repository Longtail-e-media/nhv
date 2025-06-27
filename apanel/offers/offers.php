<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_offers"; // Database table name
$moduleId 		  = 29;				// module id >>>>> tbl_modules

if(isset($_GET['page']) && $_GET['page'] == "offers" && isset($_GET['mode']) && $_GET['mode']=="list"):	
clearImages($moduleTablename, "offers");
clearImages($moduleTablename, "offers/thumbnails");
?>
<h3>
List Offers
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewOffers();">
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
               <!-- <th>Discount(%)</th> -->
               <th>Link</th>
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Offers::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->title;?>"><?php echo $record->title;?></a>
                    </div>
                </td>        
               <!--  <td><?php echo $record->disamount;?></td> -->
                <td><?php echo set_na($record->linksrc);?></td>
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
	$advInfo   	= Offers::find_by_id($advId);
	$status 	= ($advInfo->status==1)?"checked":" ";
	$unstatus 	= ($advInfo->status==0)?"checked":" ";

    $enq = ($advInfo->type == 0) ? "checked" : " ";
        $pay = ($advInfo->type == 1) ? "checked" : " ";
        $payhide = ($advInfo->type == 0) ? "hide" : "";


    $external = ($advInfo->linktype==1)?"checked":" ";
    $internal = ($advInfo->linktype==0)?"checked":" ";
endif;	
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit Offers':'Add Offers';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewOfferslist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="offers_frm">
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Offers Title" class="col-md-6 validate[required,length[0,50]]" type="text" name="title" id="title" value="<?php echo !empty($advInfo->title)?$advInfo->title:"";?>">
                </div>                
            </div>             

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Discount(%) :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Discount (%)" class="col-md-6 validate[required,length[0,50]]" type="text" name="disamount" id="disamount" value="<?php echo !empty($advInfo->disamount)?$advInfo->disamount:"";?>">
                </div>                
            </div> 
            
            <div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                       Image :
                    </label>
                </div> 
                
                <?php if(!empty($advInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg1">
                    <div class="infobox info-bg">                            	                                
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/offers/".$advInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/offers/".$advInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedOffersimage(1);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'offers/thumbnails/'.$advInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader1 <?php echo !empty($advInfo->image)?"hide":"";?>">          
                   <input type="file" name="background_upload" id="background_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (<?php echo Module::get_properties($moduleId,'imgwidth');?> px X <?php echo Module::get_properties($moduleId,'imgheight');?> px)</small></label>
                </div>                
                <!-- Upload user image preview -->
            	<div id="preview_Image"><input type="hidden" name="imageArrayname" value="" class="" /></div>
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
                        Link :
                    </label>
                </div>
                <div class="form-input col-md-8">
                    <div class="col-md-4" style="padding-left:0px !important;">
                        <input  placeholder="Slideshow Link" class="" type="text" name="linksrc" id="linksrc" value="<?php echo !empty($advInfo->linksrc)?$advInfo->linksrc:"";?>">                    
                    </div>
                    <div class="col-md-4" style="padding-left:0px !important;">
                        <select data-placeholder="Select Link Page" class="col-md-4 chosen-select" id="linkPage">
                            <option value=""></option>
                            <?php 
                                $Lpageview = !empty($advInfo->linksrc)?$advInfo->linksrc:"";
                                $LinkTypeview = !empty($advInfo->linktype)?$advInfo->linktype:"";
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
                        Short Content :
                    </label>
                </div> 
                <div class="form-input col-md-8">          
                   <textarea name="content" id="content" class="large-textarea"><?php echo !empty($advInfo->content)?$advInfo->content:"";?></textarea>
                </div>
            </div>
    		
           <!--  <div class="form-row">
                    <div class="form-label col-md-2">
                        <label for="">
                            Booking Type :
                        </label>
                    </div>
                    <div class="form-checkbox-radio col-md-9">
                        <input type="radio" class="custom-radio booktype" name="type" id="booktype0"
                               value="0" <?php echo !empty($enq) ? $enq : "checked"; ?>>
                        <label for="">Enquiry</label>
                        <input type="radio" class="custom-radio booktype" name="type" id="booktype1"
                               value="1" <?php echo !empty($pay) ? $pay : ""; ?>>
                        <label for="">Payment</label>
                    </div>
                </div>-->

                <div class="form-row payment-info <?php //echo !empty($payhide) ? $payhide : '';
                //echo isset($_GET['id']) ? '' : 'hide'; ?>">
                    <div class="form-label col-md-2">
                        <label for="">Payment Info :</label>
                    </div>
                    <div class="form-input col-md-8">
                        <table class="table tbl-result">
                            <tr>
                                <th>Title</th>
                                <th>Rate (USD)</th>
                                <th>Rate (INR)</th>
                                <th>Rate (NPR)</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php
                            if (empty($advInfo->id)) {
                                $tid = 0;
                            } else {
                                $tid = $advInfo->id;
                            }
                            $csql = "SELECT offer_type, offer_usd, offer_inr, offer_npr FROM tbl_offer_child WHERE offer_id = $tid ";
                            $query = $db->query($csql);
                            if ($db->num_rows($query) > 0) {
                                $i = 1;
                                while ($row = $db->fetch_object($query)) { ?>
                                    <tr class="dp<?php echo $i; ?>">
                                        <td><input class="validate[required]" type="text" name="offer_type[]"
                                                   value="<?php echo $row->offer_type; ?>"></td>
                                        <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                              name="offer_usd[]" value="<?php echo $row->offer_usd; ?>">
                                        </td>
                                        <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                              name="offer_inr[]" value="<?php echo $row->offer_inr; ?>">
                                        </td>
                                        <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                              name="offer_npr[]" value="<?php echo $row->offer_npr; ?>">
                                        </td>
                                        <td width="40">
                                            <a href="javascript:;" class="btn bg-blue btn-add">&nbsp;+&nbsp;</a>
                                            <?php if ($i > 1) { ?><a href="javascript:;" class="btn bg-red btn-remove"
                                                                     data-id="dp<?php echo $i; ?>">
                                                    &nbsp;x&nbsp;</a><?php } ?>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                }
                            } else { ?>
                                <tr>
                                    <td><input class="validate[required]" type="text" name="offer_type[]"></td>
                                    <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                          name="offer_usd[]"></td>
                                    <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                          name="offer_inr[]"></td>
                                    <td width="90"><input class="validate[required,custom[number]]" type="text"
                                                          name="offer_npr[]"></td>
                                    <td width="40">
                                        <a href="javascript:;" class="btn bg-blue btn-add">&nbsp;+&nbsp;</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
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
            <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
            </button>
            <input myaction='0' type="hidden" name="idValue" id="idValue"
                       value="<?php echo !empty($advInfo->id) ? $advInfo->id : 0; ?>"/>
            
         </form>    
    </div>
</div>   

<script type="text/javascript" src="<?php echo ASSETS_PATH;?>uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript">
   // <![CDATA[
	$(document).ready(function() {
	$('#background_upload').uploadify({
	'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
	'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/offers/',thumb_width:200,thumb_height:200},
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
		$.post('<?php echo BASE_URL;?>apanel/offers/uploaded_image.php',{imagefile:filename},function(msg){			
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
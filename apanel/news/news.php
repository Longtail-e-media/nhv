<link href="<?php echo ASSETS_PATH; ?>uploadify/uploadify.css" rel="stylesheet" type="text/css" />
<?php
$moduleTablename  = "tbl_news"; // Database table name
$moduleId 		  = 6;				// module id >>>>> tbl_modules
$moduleFoldername = "news";		// Image folder name
//$position = array(1=>'News Page', 2=>'Workshop Page', 3=>'Both Page');

if(isset($_GET['page']) && $_GET['page'] == "news" && isset($_GET['mode']) && $_GET['mode']=="list"):	
clearImages($moduleTablename, $moduleFoldername);
clearImages($moduleTablename, $moduleFoldername."/thumbnails");
?>
<h3>
List News
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewNewss();">
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
               <th class="text-center">News Date</th>   
               <th class="text-center">Author</th>        
               <!-- <th class="text-center">Display</th> -->
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = News::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->title;?>"><?php echo $record->title;?></a>
                    </div>
                </td>
                <td><?php echo $record->news_date;?></td>
                <td><?php echo $record->author;?></td>                
                <!-- <td><?php //echo $position[$record->display];?></td>   -->
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
	$newsId 	= addslashes($_REQUEST['id']);
	$newsInfo   = News::find_by_id($newsId);
	$status 	= ($newsInfo->status==1)?"checked":" ";
	$unstatus 	= ($newsInfo->status==0)?"checked":" ";

    $addtype    = ($newsInfo->type==1)?"checked":" ";
    $unaddtype  = ($newsInfo->type==0)?"checked":" ";

    $imghide    = ($newsInfo->type==0)?'hide':' ';
    $videohide  = ($newsInfo->type==1)?'hide':' ';
endif;	
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit News':'Add News';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewnewslist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="news_frm">
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="News Title" class="col-md-6 validate[required,length[0,200]]" type="text" name="title" id="title" value="<?php echo !empty($newsInfo->title)?$newsInfo->title:"";?>">
                </div>                
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Author :
                    </label>
                </div>                
                <div class="form-input col-md-6">
                    <input placeholder="News Author Name" class="col-md-6 validate[required,length[0,200]]" type="text" name="author" id="author" value="<?php $adminName = User::get_user_shotInfo_byId(1); echo !empty($newsInfo->author)?$newsInfo->author:$adminName->first_name;?>">
                </div>                
            </div>   
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Date :
                    </label>
                </div>                
                <div class="form-input col-md-4">
                    <input placeholder="News Date" class="col-md-6 validate[required] datepicker" type="text" name="news_date" id="news_date" value="<?php echo !empty($newsInfo->news_date)?$newsInfo->news_date:"";?>">
                </div>                
            </div>     

            <!-- <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Display :
                    </label>
                </div>                
                <div class="form-input col-md-2">
                    <select data-placeholder="Choose Page" class="validate[required]" id="display" name="display">
                        <option value="">Choose Page</option>
                        <?php /*foreach ($position as $key => $val) {
                           $sel = (!empty($newsInfo->display) and $newsInfo->display==$key)?'selected':'';
                           echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>' ;
                        }*/?>
                    </select>    
                </div>                
            </div> -->

            <!-- <div class="form-row">   
                <div class="form-label col-md-2">
                    <label for="">
                        Add Type :
                    </label>
                </div>             
                <div class="form-checkbox-radio col-md-9">
                    <input type="radio" class="custom-radio addtype" name="type" id="adtype1" value="1" <?php echo !empty($addtype)?$addtype:"checked";?>>
                    <label for="">Image</label>
                    <input type="radio" class="custom-radio addtype" name="type" id="adtype0" value="0" <?php echo !empty($unaddtype)?$unaddtype:"";?>>
                    <label for="">Video</label>
                </div>                
            </div>  -->
            
            <div class="form-row add-image">
            	<div class="form-label col-md-2">
                    <label for="">
                        Image :
                    </label>
                </div> 
                
                <?php if(!empty($newsInfo->image)):?>
                <div class="col-md-3" id="removeSavedimg<?php echo $newsInfo->id;?>">
                    <div class="infobox info-bg">                            	                                
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/news/".$newsInfo->image)):
                                        $filesize = filesize(SITE_ROOT."images/news/".$newsInfo->image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedNewsimage(<?php echo $newsInfo->id;?>);">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'news/thumbnails/'.$newsInfo->image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader <?php echo !empty($newsInfo->image)?"hide":"";?>">          
                   <input type="file" name="gallery_upload" id="gallery_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (<?php echo Module::get_properties($moduleId,'imgwidth');?> px X <?php echo Module::get_properties($moduleId,'imgheight');?> px)</small></label>
                </div>                
                <!-- Upload user image preview -->
            	<div id="preview_Image"><input type="hidden" name="imageArrayname" value="<?php echo !empty($newsInfo->image)?$newsInfo->image:"";?>" class="" /></div>
            </div>

            <div class="form-row add-image">
                <div class="form-label col-md-2">
                    <label for="">
                        Banner Image :
                    </label>
                </div> 
                
                <?php if(!empty($newsInfo->banner_image)):?>
                <div class="col-md-3" id="removeSavedimgb<?php echo $newsInfo->id;?>">
                    <div class="infobox info-bg">                                                               
                        <div class="button-group" data-toggle="buttons">
                            <span class="float-left">
                                <?php 
                                    if(file_exists(SITE_ROOT."images/news/banner/".$newsInfo->banner_image)):
                                        $filesize = filesize(SITE_ROOT."images/news/banner/".$newsInfo->banner_image);
                                        echo 'Size : '.getFileFormattedSize($filesize);
                                    endif;
                                ?>
                            </span> 
                            <a class="btn small float-right" href="javascript:void(0);" onclick="deleteSavedActivitiesimage('b<?php echo $newsInfo->id;?>');">
                                <i class="glyph-icon icon-trash-o"></i>
                            </a>                                                       
                        </div>
                        <img src="<?php echo IMAGE_PATH.'news/banner/thumbnails/'.$newsInfo->banner_image;?>"  style="width:100%"/>                                                                                   
                    </div> 
                </div>
                <?php endif;?>
                <div class="form-input col-md-10 uploader">          
                   <input type="file" name="banner_upload" id="banner_upload" class="transparent no-shadow">
                   <label><small>Image Dimensions (1353px X 253px)</small></label>
                </div>                
                <!-- Upload user image preview -->
                <div id="preview_Image2"><input type="hidden" name="imageArrayname2" value="<?php echo !empty($newsInfo->banner_image)?$newsInfo->banner_image:"";?>" class="" /></div>
            </div>

            <!-- <div class="form-row <?php //echo !empty($videohide)?$videohide:''; echo isset($_GET['id'])?'':'hide'; ?> videolink">
                <div class="form-label col-md-2">
                    <label for="">
                        Video link :
                    </label>
                </div>
                <div class="form-input col-md-10">  
                    <input placeholder="http://www.youtube.com/watch?v=fs2khSNtSu0" class="col-md-8 validate[custom[url]]" type="text" name="source" id="source" value="<?php echo !empty($newsInfo->source)?$newsInfo->source:"";?>" >                                     
                </div>                
            </div> -->         

            <!-- <div class="form-row">
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
            </div> -->

            <!-- <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Link :
                    </label>
                </div>
                <div class="form-input col-md-8">
                    <div class="col-md-4" style="padding-left:0px !important;">
                        <input  placeholder="Extra Link" class="" type="text" name="linksrc" id="linksrc" value="<?php echo !empty($newsInfo->linksrc)?$newsInfo->linksrc:"";?>">                    
                    </div>
                    <div class="col-md-4" style="padding-left:0px !important;">
                        <select data-placeholder="Select Link Page" class="col-md-4 chosen-select" id="linkPage">
                            <option value=""></option>
                            <?php 
                                //$Lpageview = !empty($newsInfo->linksrc)?$newsInfo->linksrc:"";
                                //$LinkTypeview = !empty($newsInfo->linktype)?$newsInfo->linktype:"";
                                // Article Page Link
                                //echo Article::get_internal_link($Lpageview,$LinkTypeview);
                                // Product Page Link
                                //echo Product::get_product_link($Lpageview,$LinkTypeview);
                                // Gallery Page Link
                                //echo Gallery::get_gallery_link($Lpageview,$LinkTypeview);
                            ?>
                        </select>  
                    </div>                    
                </div>
            </div> -->

            <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Breif :
                    </label>
                </div> 
                <div class="form-input col-md-8">          
                   <textarea name="brief" id="brief" class="large-textarea"><?php echo !empty($newsInfo->brief)?$newsInfo->brief:"";?></textarea>
                </div>
            </div>
                    
    		<div class="form-row">
            	<div class="form-label col-md-12">
                    <label for="">
                        Content :
                    </label>
                    <textarea name="content" id="content" class="large-textarea validate[required]"><?php echo !empty($newsInfo->content)?$newsInfo->content:"";?></textarea>
                    <a class="btn medium bg-orange mrg5T" title="Read More" id="readMore" href="javascript:void(0);">
                        <span class="button-content">Read More</span>
                    </a>
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
            <div class="form-row <?php echo (!empty($newsInfo->meta_keywords) || !empty($newsInfo->meta_description))?'':'hide';?> metadata">   
            	<div class="col-md-6">
                	<textarea placeholder="Meta Keyword" name="meta_keywords" id="meta_keywords" class="character-keyword validate[required]"><?php echo !empty($newsInfo->meta_keywords)?$newsInfo->meta_keywords:"";?></textarea>
                    <div class="keyword-remaining clear input-description">250 characters left</div>
                </div>  
                <div class="col-md-6">
                	<textarea placeholder="Meta Description" name="meta_description" id="meta_description" class="character-description validate[required]"><?php echo !empty($newsInfo->meta_description)?$newsInfo->meta_description:"";?></textarea>
                    <div class="description-remaining clear input-description">160 characters left</div>
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($newsInfo->id)?$newsInfo->id:0;?>" />
         </form>    
    </div>
</div>   
<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["content"];
create_editor(base_url,editor_arr);
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
	$('#gallery_upload').uploadify({
	'swf'  : '<?php echo ASSETS_PATH;?>uploadify/uploadify.swf',
	'uploader'   : '<?php echo ASSETS_PATH;?>uploadify/uploadify.php',
	'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/news/',thumb_width:200,thumb_height:200},
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
		$.post('<?php echo BASE_URL;?>apanel/news/uploaded_image.php',{imagefile:filename},function(msg){			
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
        'formData'   : {PROJECT : '<?php echo SITE_FOLDER;?>',targetFolder:'images/news/banner/',thumb_width:200,thumb_height:200},
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
            $.post('<?php echo BASE_URL;?>apanel/news/banner_image.php',{imagefile:filename},function(msg){           
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
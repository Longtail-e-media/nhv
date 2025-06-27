<?php
$moduleTablename  = "tbl_social_networking"; // Database table name
$moduleId         = 11;             // module id >>>>> tbl_modules
$moduleFoldername = "social";       // Image folder name
    
if(isset($_GET['page']) && $_GET['page'] == "social" && isset($_GET['mode']) && $_GET['mode']=="list"):       
?>
<h3>
List Social Links
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewSocial();">
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
               <th class="text-center">S.No.</th>
               <th>Icon</th>
               <th class="text-center">Link</th>      
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = SocialNetworking::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder ASC "); 
                  foreach($records as $record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td class="text-center"><?php echo $record->sortorder;?></td>                
                <td>                                                                                                       
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->title;?>">
                        <?php echo $record->title;?>
                    </a>
                </td>                              
                <td><?php echo !empty($record->linksrc)?$record->linksrc:'';?></td>
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
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
    $socialId    = addslashes($_REQUEST['id']);
    $socialInfo  = SocialNetworking::find_by_id($socialId);
    $status      = ($socialInfo->status==1)?"checked":" ";
    $unstatus    = ($socialInfo->status==0)?"checked":" ";
endif;  
?>

<h3>
    <?php echo (isset($_GET['id']))?'Edit Social Link':'Add Social Link';?>
    <a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewSociallist();">
        <span class="glyph-icon icon-separator">
            <i class="glyph-icon icon-arrow-circle-left"></i>
        </span>
        <span class="button-content"> Back </span>
    </a>
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <form action="" class="col-md-10 center-margin" id="social_frm">
            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Title :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Social Link Title" class="col-md-4 validate[required,length[0,200]]" type="text" name="title" id="title" value="<?php echo !empty($socialInfo->title)?$socialInfo->title:"";?>">
                </div>                
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Link :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Social Link " class="col-md-4 validate[required,length[0,250]]" type="text" name="linksrc" id="linksrc" value="<?php echo !empty($socialInfo->linksrc)?$socialInfo->linksrc:"";?>">
                </div>                
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Icon  :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="fa-icon" class="col-md-4 validate[required,length[0,200]]" type="text" name="imageArrayname" id="imageArrayname" value="<?php echo !empty($socialInfo->image)?$socialInfo->image:"";?>">
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

            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($socialInfo)?$socialInfo->id:0;?>" />
        </form>
    </div>
</div>    
<?php endif; ?>
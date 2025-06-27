<?php
$subpackageTablename  = "tbl_package_date"; // Database table name
if(isset($_GET['page']) && $_GET['page'] == "package" && isset($_GET['mode']) && $_GET['mode']=="packagedatelist"):
$id = intval(addslashes($_GET['id']));  
?>
<h3>
List Package Date ["<?php echo Package::field_by_id($id, 'title');?>"]
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="AddNewPackagedate(<?php echo $id;?>);">
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
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="subexample">
        <thead>
            <tr>
               <th style="display:none;"></th>
               <th class="text-center"><input class="check-all" type="checkbox" /></th>
               <th>Package Date</th>         
               <!--<th class="text-center">Package Rate</th>-->
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Packagedate::find_by_sql("SELECT * FROM ".$subpackageTablename." WHERE package_id=".$id." ORDER BY package_date DESC "); 
                  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
                <td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td>
                    <div class="col-md-7">
                        <a href="javascript:void(0);" onClick="editsubpackage(<?php echo $record->package_id;?>,<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->package_date;?>"><?php echo $record->package_date;?></a>
                    </div>
                </td>       
                <!--<td class="text-center"><?php echo $record->package_currency.' '.$record->package_rate;?></td>-->
                <td class="text-center">
                    <?php   
                        $statusImage = ($record->status == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($record->status == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusSubToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $record->status;?>" id="imgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
                    <a href="javascript:void(0);" class="loadingbar-demo btn small bg-blue-alt tooltip-button" data-placement="top" title="Edit" onclick="editsubpackage(<?php echo $record->package_id;?>,<?php echo $record->id;?>);">
                        <i class="glyph-icon icon-edit"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn small bg-red tooltip-button" data-placement="top" title="Remove" onclick="subrecordDelete(<?php echo $record->id;?>);">
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
    <option value="subdelete"><?php echo $GLOBALS['basic']['delete'];?></option>
    <option value="subtoggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
</select>
</div>
<a class="btn medium primary-bg" href="javascript:void(0);" id="applySelected_btn">
    <span class="glyph-icon icon-separator float-right">
      <i class="glyph-icon icon-cog"></i>
    </span>
    <span class="button-content"> Submit </span>
</a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEditpackagedate"): 
$pid   = addslashes($_REQUEST['id']);
if(isset($_GET['subid']) and !empty($_GET['subid'])):
    $subpackageId   = addslashes($_REQUEST['subid']);
    $packagedateInfo  = Packagedate::find_by_id($subpackageId);
    $status     = ($packagedateInfo->status==1)?"checked":" ";
    $unstatus   = ($packagedateInfo->status==0)?"checked":" ";
endif;  
?>
<h3>
<?php echo (isset($_GET['subid']))?'Edit Sub Package':'Add Sub Package';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewpackagedatelist(<?php echo $pid;?>);">
    <span class="glyph-icon icon-separator">
        <i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
        <form action="" class="col-md-12 center-margin" id="subpackage_frm">            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Package Date :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Package Date" class="col-md-2 validate[required]" type="text" name="package_date" id="package_date" value="<?php echo !empty($packagedateInfo->package_date)?$packagedateInfo->package_date:"";?>">
                </div>                
            </div>   

            <!--<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Package Rate (US$) :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Package Rate" class="col-md-2 validate[required]" type="text" name="package_rate" id="package_rate" value="<?php echo !empty($packagedateInfo->package_rate)?$packagedateInfo->package_rate:"";?>"> 
                </div>                
            </div>-->

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Booking Close Date :
                    </label>
                </div>
                <div class="form-input col-md-20">
                    <input placeholder="Closure Date" class="col-md-2 validate[required]" type="text" name="package_closure" id="package_closure" value="<?php echo !empty($packagedateInfo->package_closure)?$packagedateInfo->package_closure:"";?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        No. of Seats :
                    </label>
                </div>
                <div class="form-input col-md-20">
                    <input placeholder="Number of Seats" class="col-md-2 validate[required]" type="text" name="package_seats" id="package_seats" value="<?php echo !empty($packagedateInfo->package_seats)?$packagedateInfo->package_seats:"";?>">
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($packagedateInfo->id)?$packagedateInfo->id:0;?>" />
            <input type="hidden" name="package_currency" id="package_currency" value="USD" />
            <input type="hidden" name="package_id" id="package_id" value="<?php echo !empty($packagedateInfo->package_id)?$packagedateInfo->package_id:$pid;?>" />
         </form>    
    </div>
</div>  
<?php endif; ?>
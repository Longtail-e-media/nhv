<?php
$moduleTablename  = "tbl_polls"; // Database table name
$moduleId 		  = 12;		// module id >>>>> tbl_modules
$moduleFoldername = "";		// Image folder name

if(isset($_GET['page']) && $_GET['page'] == "poll" && isset($_GET['mode']) && $_GET['mode']=="list"):	
?>
<h3>
List Poll
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
               <th>Question</th>
               <th class="text-center">Options</th>           
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Poll::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
				  foreach($records as $key=>$record): ?>    
            <tr id="<?php echo $record->id;?>">
            	<td style="display:none;"><?php echo $key+1;?></td>
                <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $record->id;?>" /></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $record->question;?>"><?php echo $record->question;?></a>
                    </div>
                </td>
                <td class="text-center">
                <div class="dropdown">
                	<a href="javascript:void(0);" class="lbtn medium bg-orange radius-all-4 btn" data-toggle="dropdown">
                        <span class="button-content font-size-14">view &ensp;
                        	<i class="glyph-icon font-size-11 icon-chevron-down"></i>
                        </span>
                        <span class="badge badge-absolute float-right bg-red">
                        	<?php echo PollOptions::count_QuestionOpt($record->id);?>
                        </span>
                    </a>
                    <ul class="dropdown-menu float-right" style="min-width: 250px;">         
                    <?php $Qstopt = PollOptions::getPollOptions($record->id); 
						  if($Qstopt):
						  $k=1;
						  foreach($Qstopt as $QstoptRow):
						  $colclass = ($k++%2==0)?"bg-green":"bg-blue";
						  ?>               
                        <li>           
                        	<span class="badge badge-absolute float-right radius-all-100 mrg5R <?php echo $colclass;?>  tooltip-button" data-original-title="Answer hits" title=""><?php echo $QstoptRow->hits;?></span>                
                            <i class="glyph-icon icon-play-circle-o mrg5R"></i>
                            <?php echo $QstoptRow->pollOption;?>                        
                        </li>
                        <li class="divider"></li>
                    <?php endforeach; endif; ?>    
                    </ul>
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
    <span class="button-content"> Submit </span>
</a>
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
	$pollId 	= addslashes($_REQUEST['id']);
	$pollInfo   = Poll::find_by_id($pollId);
	$status 	= ($pollInfo->status==1)?"checked":"";
	$unstatus 	= ($pollInfo->status==0)?"checked":"";
endif;	
?>
<h3>
AddEdit Poll
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewpolllist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="poll_frm">
        	<div class="form-row">
            	<div class="form-label col-md-2">
                    <label for="">
                        Question :
                    </label>
                </div>
                <div class="form-input col-md-8">
                    <textarea name="question" id="question" class="textarea-autosize validate[required]"><?php echo !empty($pollInfo->question)?$pollInfo->question:"";?></textarea>
                </div>
            </div>               
            
            <div class="form-row my-style <?php echo !empty($pollInfo)?"hide":"";?>">     
            	<div class="form-label col-md-2">
                    <label for="">
                        Options :
                    </label>
                </div>           
                <div class="form-input col-md-12" id="NewRow0">                    
                    <div class="col-md-4">
                        <input placeholder="Options Title" type="text" name="pollOption[]" id="pollOption" class="validate[required]">
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn medium bg-blue tooltip-button" data-placement="right" title="Add" onclick="addnewRow(this);">
                            <i class="glyph-icon icon-plus-square"></i>
                       </a>
                     </div>                                          
                 </div>                               	 
            </div>      
            
            <?php if(!empty($pollInfo)):?>
            <?php $optionRec = PollOptions::getPollOptions($pollInfo->id);
				$i = 1;
				if($optionRec):
				foreach($optionRec as $optionRow):
				$rand = rand(1,999);
				$first = $i++;?>
            <div class="form-row my-style">     
            	<div class="form-label col-md-2">
                    <?php if($first==1):?>
                    <label for="">
                        Options :
                    </label>
                    <?php endif;?>
                </div>       
                <div class="form-input col-md-12" id="NewRow<?php echo $rand;?>">                    
                    <div class="col-md-4">
                        <input placeholder="Options Title" type="text" name="pollOption[]" id="pollOption" class="validate[required]" value="<?php echo $optionRow->pollOption;?>">
                    </div>
                    <div>
                        <a href="javascript:void(0);" class="btn medium bg-blue tooltip-button" data-placement="right" title="Add" onclick="addnewRow(this);">
                            <i class="glyph-icon icon-plus-square"></i>
                       </a>
                       <?php if($first!=1):?>
                       <a href="javascript:void(0);" class="btn medium bg-red tooltip-button" data-placement="right" title="Delete" onclick="deletenewRow(<?php echo $rand;?>);">
						  <i class="glyph-icon icon-minus-square"></i>
			   		   </a>
                       <?php endif;?>
                     </div>                                          
                 </div>                                                	 
            </div>
            <?php endforeach; endif; endif;?>
            <!-- Dynamicly Add Opions Fields-->
            <div id="option-field"></div>        
    		
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
                                   
            <button type="submit" name="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4" id="btn-submit" title="Save">
                <span class="button-content">
                    Save
                </span>
            </button>
            <input type="hidden" name="idValue" id="idValue" value="<?php echo !empty($pollInfo->id)?$pollInfo->id:0;?>" />
         </form>    
    </div>
</div>  
<?php endif; ?>
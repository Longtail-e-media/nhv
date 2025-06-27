<?php
if(isset($_GET['mode']) && $_GET['mode'] == "general")
{
	//include_apanel_template("editor.php");
	$configs = Config::find_by_id(1);
?>
<h3>
General Settings
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewPersonlist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>

<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
 <form action="" class="col-md-10 center-margin" id="generalSettings_frm">

    <fieldset id="mainFieldset"> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
          <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        <?php echo $GLOBALS['setts']['siteName'];?> :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Site Name" class="col-md-8 validate[required,length[0,50]]" type="text" name="sitename" id="sitename" value="<?php echo $configs->sitename;?>">
                </div>                
            </div>
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        <?php echo $GLOBALS['setts']['siteTitle'];?> :
                    </label>
                </div>                
                <div class="form-input col-md-20">
                    <input placeholder="Site Title" class="col-md-8 validate[required,length[0,50]]" type="text" name="sitetitle" id="sitetitle" value="<?php echo $configs->sitetitle;?>">
                </div>                
            </div>
            
        <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Header :
                    </label>
                    <textarea name="headers" id="headers" class="large-textarea validate[required]" ><?php echo $configs->headers;?></textarea>
                </div>
            </div>

            <div class="form-row">
            	<div class="form-label col-md-12">
                    <label for="">
                        Footer :
                    </label>
                    <textarea name="footer" id="footer" class="large-textarea validate[required]">
						<?php echo !empty($configs->footer)?$configs->footer:"";?>
                    </textarea>
                </div>            
            </div>
            
            <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Google Search Box :
                    </label>
                    <textarea name="search_box" id="search_box" class="large-textarea validate[required]"><?php echo $configs->search_box;?></textarea>
                </div>
            </div>
            
            
            <div class="form-row">
                <div class="form-label col-md-12">
                    <label for="">
                        Google Search Result :
                    </label>
                    <textarea name="search_result" id="search_result" class="large-textarea validate[required]" ><?php echo $configs->search_result;?></textarea>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        <?php echo $GLOBALS['setts']['siteKeywords'];?> :
                    </label>
                </div>                
				<div class="form-input col-md-15">
					<textarea name="site_keywords" id="site_keywords" class="large-textarea"><?php echo $configs->site_keywords;?></textarea>
                </div>                  
            </div>
            
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        <?php echo $GLOBALS['setts']['siteDesc'];?> :
                    </label>
                </div>                
                <div class="form-input col-md-15">
					<textarea name="site_description" id="site_description" class="large-textarea"><?php echo $configs->site_description;?></textarea>
                </div>                
            </div>

        
<div class="btn-group">
            <input name="submit_btn" type="submit" class="btn medium bg-blue-alt" id="submit_btn" value="<?php echo $GLOBALS['basic']['saveChanges'];?>" />
        </div>
       
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>

</div> <!-- end tab1 -->
</div> <!-- eND MAIN TABL -->
<script>
var base_url =  "<?php echo ASSETS_PATH; ?>";
var editor_arr = ["footer", "headers", "search_box", "search_result"];
create_editor(base_url,editor_arr);
</script>
<?php 
}
else if(isset($_GET['mode']) && $_GET['mode'] == "module")
{
	$modules = Module::display_all();
	reOrder("tbl_modules", "sortorder"); // Starting the sortorder from 1 to ++..
?>
<h3>
Site Module Settings
</h3>
<div class="example-box">
    <div class="example-code">

<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
    <thead>
        <tr class="nodrop">
           <th><input class="check-all" type="checkbox" /></th>
           <th><?php echo $GLOBALS['basic']['moduleName'];?></th>
           <th><?php echo $GLOBALS['basic']['sortOrder'];?></th>
           <th><?php echo $GLOBALS['basic']['listPerPage'];?></th>
           <th><?php echo $GLOBALS['basic']['status'];?></th>
        </tr>
    </thead>
 
    <tfoot>
        <tr class="nodrop">
            <td colspan="5">
                <div class="bulk-actions align-left">
                    <select name="dropdown" id="groupTaskField">
                        <option value="toggleStatus"><?php echo $GLOBALS['basic']['toggleStatus'];?></option>
                    </select>
                    <a class="button" href="#" id="applySelected_btn"><?php echo $GLOBALS['basic']['applyTo'];?></a>										</div>

                <div class="clear"></div>									</td>
        </tr>
    </tfoot>
 
    <tbody>
<?php
	$fixedOrder = "sortOrder";
	foreach($modules as $module):
	$fixedOrder.= "|".$module->sortorder;
?>
        <tr id="<?php echo $module->id;?>" order="<?php echo $module->sortorder;?>">
            <td><input type="checkbox" class="bulkCheckbox" bulkId="<?php echo $module->id;?>" /></td>
            <td><input type="text" class="module_txtbox" maxlength="50" name="moduleName_<?php echo $module->id;?>" value="<?php echo $module->name;?>" realId="<?php echo $module->id;?>" /></td>
            <td class="sort-order"><?php echo $module->sortorder;?></td>
            <td><input type="text" class=" col-md-4 numericOnly inlineEditing" maxlength="3" name="perPage<?php echo $module->id;?>" id="perPage<?php echo $module->id;?>" value="<?php echo $module->perpage;?>" realId="<?php echo $module->id;?>" /> <img src="../images/apanel/save.gif" class="inlineSave" id="save<?php echo $module->id;?>" realImgId="<?php echo $module->id;?>" title="Save" alt="Save" /></td>
            <td>
            <?php	
			 	$statusImage = ($module->published == 1) ? "tick_circle.png" : "cross.png" ; 
				$statusText = ($module->published == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
			?>
               <!-- <div class="statusToggler noLink" status="<?php echo $module->published;?>" moduleId="<?php echo $module->id;?>" style="width:30px;text-align:center;" id="imgHolder_<?php echo $module->id;?>"><img src="<?php echo ADMIN_IMAGES.$statusImage;?>" alt="<?php echo $statusText;?>" title="<?php echo $statusText;?>" /></div>-->
                
                
                <?php	
                        $statusImage = ($module->published == 1) ? "bg-green" : "bg-red" ; 
                        $statusText = ($module->published == 1) ? $GLOBALS['basic']['clickUnpub'] : $GLOBALS['basic']['clickPub'] ; 
                    ?>                                             
                    <a href="javascript:void(0);" class="btn small <?php echo $statusImage;?> tooltip-button statusToggler" data-placement="top" title="<?php echo $statusText;?>" status="<?php echo $module->published;?>" id="imgHolder_<?php echo $module->id;?>" moduleId="<?php echo $module->id;?>">
                        <i class="glyph-icon icon-flag"></i>
                    </a>
            
            </td>
        </tr>
<?php endforeach; ?>
    </tbody>
</table>

<div id="final-order-list" style="display:none;"><?php echo $fixedOrder;?></div>
</div> <!-- end tab1 -->
</div> <!-- eND MAIN TABL -->

<?php
//include('../layouts/apanel/templating.php');

}
else 
{
	$profile = User::find_by_id(1);
?>
<script language="javascript">
$(document).ready(function(){
	$('#profileSettings_frm').passroids({ 
		main: '#password',
		verify: '#passwordConfirm',
		minimum: 6
	});
});
</script>
<div class="content-box-header">
    <h3><?php echo $GLOBALS['setts']['profileSet'];?></h3>
    <div class="clear"></div>
</div> <!-- End .content-box-header -->

<div class="content-box-content">

<div class="tab-content default-tab" id="tab1">	
<form action="" method="post" id="profileSettings_frm">

    <fieldset id="mainFieldset"> 
    <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
        <p>
            <label><?php echo $GLOBALS['setts']['yourName'];?></label>
                <input name="name" type="text" class="validate[required,length[0,50]] text-input small-input" id="name" value="<?php echo $profile->name;?>" maxlength="50" /> 
        </p>
        <p>
            <label><?php echo $GLOBALS['setts']['emailAddress'];?></label>
                <input name="email" type="text" class="text-input small-input emailOnly" id="email" maxlength="80" value="<?php echo $profile->email;?>" /> 
                <br /><small><?php echo $GLOBALS['setts']['emailDesc'];?></small>
        </p>
       <p>
            <label><?php echo $GLOBALS['setts']['address'];?></label>
            <textarea class="text-input textarea" id="textarea" name="address" rows="1"><?php echo $profile->address;?></textarea>
        </p>
        <p>
            <label><?php echo $GLOBALS['login']['username'];?></label>
                <input name="username" type="text" class="validate[required,length[0,50]] text-input small-input noSpaces" id="username" maxlength="50" value="<?php echo $profile->username;?>" /> 
                <br /><small><?php echo $GLOBALS['setts']['unameDesc'];?></small>
        </p>
        <p>
            <label><?php echo $GLOBALS['setts']['newPassword'];?></label>
                <input name="password" type="password" class="text-input small-input" id="password" maxlength="20" /> 
                <br /><small><?php echo $GLOBALS['setts']['newPassDesc'];?></small>
        </p>
        <p>
            <label><?php echo $GLOBALS['setts']['confirmPass'];?></label>
                <input name="passwordConfirm" type="password" class="validate[confirm[password]] text-input small-input" id="passwordConfirm" maxlength="20" /> 
                <br /><small><?php echo $GLOBALS['setts']['confirmDesc'];?></small>
        </p>

        
<p id="buttonsP">
            <input name="submit_btn" type="submit" class="button formButtons" id="submit_btn" value="<?php echo $GLOBALS['basic']['saveChanges'];?>" />
        </p>
       
    </fieldset>
    
    <div class="clear"></div><!-- End .clear -->
    
</form>
</div> <!-- end tab1 -->
</div> <!-- eND MAIN TABL -->
<?php
} 
?>

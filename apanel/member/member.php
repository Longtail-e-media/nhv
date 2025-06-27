<?php
$moduleTablename  = "tbl_member"; // Database table name
$moduleId 		  = 35;				// module id >>>>> tbl_modules
$moduleFoldername = ""; 
$gender = array('Male'=>'Male', 'Female'=>'Female', 'Other'=>'Other');
if(isset($_GET['page']) && $_GET['page'] == "member" && isset($_GET['mode']) && $_GET['mode']=="list"):	
?>
<h3>
List Member
</h3>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">    
    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
        <thead>
            <tr>
               <th class="text-center">S.No.</th>
               <th>Fullname</th>         
               <th>Contact No.</th>   
               <th>Email Address</th>
               
               <th>Approved</th>   
               <th class="text-center"><?php echo $GLOBALS['basic']['action'];?></th>
            </tr>
        </thead> 
            
        <tbody>
            <?php $records = Member::find_by_sql("SELECT * FROM ".$moduleTablename." ORDER BY sortorder DESC ");	
                foreach($records as $key=>$record): 
                    $fullname = $record->first_name.' '.$record->middle_name.' '.$record->last_name; ?>    
            <tr id="<?php echo $record->id;?>">
            	<td class="text-center"><?php echo $key+1;?></td>
                <td><div class="col-md-7">
                    <a href="javascript:void(0);" onClick="editRecord(<?php echo $record->id;?>);" class="loadingbar-demo" title="<?php echo $fullname;?>"><?php echo $fullname;?></a>
                    </div>
                </td>
                <td><?php echo $record->phoneno;?></td> 
                <td><?php echo $record->mailaddress;?></td> 
                
                <td class="text-center">
                    <?php $featureImage = ($record->login_status == 1) ? "bg-green" : "bg-red" ; 
                    $featlureText = ($record->login_status == 1) ? 'Un-approved' : 'Approved' ; ?>
                    <a href="javascript:void(0);" class="btn small <?php echo $featureImage;?> tooltip-button featureToggler" data-placement="top" title="<?php echo $featlureText;?>" status="<?php echo $record->login_status;?>" id="futimgHolder_<?php echo $record->id;?>" moduleId="<?php echo $record->id;?>">
                    <i class="glyph-icon icon-flag"></i>
                    </a>
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
</div>

<?php elseif(isset($_GET['mode']) && $_GET['mode'] == "addEdit"): 
if(isset($_GET['id']) && !empty($_GET['id'])):
	$memberId 	= addslashes($_REQUEST['id']);
	$memberInfo = Member::find_by_id($memberId);
	$status 	= ($memberInfo->status==1)?"checked":" ";
	$unstatus 	= ($memberInfo->status==0)?"checked":" ";
    $is_login   = ($memberInfo->login_status==1)?"checked":" ";
    $isntlogin  = ($memberInfo->login_status==0)?"checked":" ";
endif;	
    $users = User::get_all_user();
?>
<h3>
<?php echo (isset($_GET['id']))?'Edit Member':'Add Member';?>
<a class="loadingbar-demo btn medium bg-blue-alt float-right" href="javascript:void(0);" onClick="viewMemberlist();">
    <span class="glyph-icon icon-separator">
    	<i class="glyph-icon icon-arrow-circle-left"></i>
    </span>
    <span class="button-content"> Back </span>
</a>
</h3>
<script language="javascript">
$(document).ready(function(){
	$('#adminusersetting_frm').passroids({ 
		main: '#password',
		verify: '#passwordConfirm',
		minimum: 6
	});
});
</script>
<div class="my-msg"></div>
<div class="example-box">
    <div class="example-code">
    	<form action="" class="col-md-12 center-margin" id="member_frm">
            <div class="form-row">
                <h4>Personal Information</h4>
            </div> 
        	<div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Fullname :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <div class="col-md-4">
                        <input placeholder="First" class="col-md-12 validate[required,length[0,255]]" type="text" name="first_name" id="first_name" value="<?php echo !empty($memberInfo->first_name)?$memberInfo->first_name:"";?>">
                    </div>
                    <div class="col-md-4">
                        <input placeholder="Middle" class="col-md-12" type="text" name="middle_name" id="middle_name" value="<?php echo !empty($memberInfo->middle_name)?$memberInfo->middle_name:"";?>">
                    </div>
                    <div class="col-md-4">
                        <input placeholder="Last" class="col-md-12 validate[required,length[0,255]]" type="text" name="last_name" id="last_name" value="<?php echo !empty($memberInfo->last_name)?$memberInfo->last_name:"";?>">
                    </div>
                </div>                
            </div> 

             <div class="form-row menu-position">
                <div class="form-label col-md-2">
                    <label for="">
                        Gender :
                    </label>
                </div>                
                <div class="form-input col-md-3">
                    <select data-placeholder="None" class="validate[required]" id="gender" name="gender">
                        <option value="">Gender</option>
                        <?php foreach ($gender as $key => $val) {
                           $sel = (!empty($memberInfo->gender) and strtolower($memberInfo->gender)==strtolower($key))?'selected':'';
                           echo '<option value="'.$key.'" '.$sel.'>'.$val.'</option>' ;
                        }?>
                    </select>    
                </div>                
            </div>
           
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Date Of Birth :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Date Of Birth" class="col-md-4 datepicker" type="text" name="dob" id="dob" value="<?php echo !empty($memberInfo->dob)?$memberInfo->dob:"";?>">
                </div>                
            </div> 
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Email :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Email" class="col-md-6 validate[required,length[0,50]]" type="text" name="mailaddress" id="mailaddress" value="<?php echo !empty($memberInfo->mailaddress)?$memberInfo->mailaddress:"";?>">
                </div>                
            </div> 

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Contact :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Contact" class="col-md-6 validate[required,length[0,50]]" type="text" name="phoneno" id="phoneno" value="<?php echo !empty($memberInfo->phoneno)?$memberInfo->phoneno:"";?>">
                </div>                
            </div>

            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Address :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Address" class="col-md-6 validate[required,length[0,150]]" type="text" name="current_address" id="current_address" value="<?php echo !empty($memberInfo->current_address)?$memberInfo->current_address:"";?>">
                </div>                
            </div>


            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Password :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Password" class="col-md-6 <?php echo !empty($memberInfo)?'':'validate[required,length[0,50]]';?>" type="password" name="password" id="password">                       
                </div>           
            </div>                       
            <div class="form-row">
                <div class="form-label col-md-2">
                    <label for="">
                        Re-password :
                    </label>
                </div>                
                <div class="form-input col-md-8">
                    <input placeholder="Re-password" class="col-md-6 validate[equals[password]]" type="password" id="passwordConfirm">
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
            <input myaction='0' type="hidden" name="idValue" id="idValue" value="<?php echo !empty($memberInfo->id)?$memberInfo->id:0;?>" />
         </form>    
    </div>
</div>   

<?php endif; ?>
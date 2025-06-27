<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.user.php';
}
function getTableId(){
	return 'table_dnd';
}

/***************************************** Re ordering Users *******************************************/
$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"fnDrawCallback": function ( oSettings ) {
				/* Need to redo the counters if filtered or sorted */
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
			}
	});
});

/***************************************** USer Record delete *******************************************/
function recordDelete(Re){
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"User")?>');															
	$('.pText').html('Click on yes button to delete this user permanently.!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$.ajax({
			   type: "POST",
			   dataType:"JSON",
			   url:  getLocation(),
			   data: 'action=delete&id='+Re,
			   success: function(data){
				 var msg = eval(data);  
				 showMessage(msg.action,msg.message);
				 $('#'+Re).remove();
				 reStructureList(getTableId());
			   }
			});
		}else{
			Re = null;
		}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** Add new Users *******************************************/
function AddNewUsers()
{
	window.location.href="<?php echo ADMIN_URL?>user/addEdit";
}

/***************************************** View Users Lists *******************************************/
function viewuserslist()
{
	window.location.href="<?php echo ADMIN_URL?>user/list";
}

/***************************************** Edit User login Info *******************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>user/addEdit/"+Re;
}

function permission(Re)
{
	window.location.href="<?php echo ADMIN_URL?>user/permission/"+Re;
}

/***************************************** AddEdit login Info *******************************************/
$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#adminusersetting_frm').validationEngine({
		prettySelect : true,
		useSuffix: "_chosen",
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=addNewUser&" : "action=editNewUser&" ;
				var data = $('#adminusersetting_frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='warning'){
						   showMessage(msg.action,msg.message);
						   $('#btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						   showMessage(msg.action,msg.message);							   
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>user/list";},3000);
					   }
					   if(msg.action=='notice'){
						   showMessage(msg.action,msg.message);		   					   
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }			   					   
					   if(msg.action=='error'){
						   showMessage(msg.action,msg.message);
						   $('#buttonsP img').remove();
		 				   $('.formButtons').show();
						   return false;
					   }
				   }
				});
			return false;
			}
		}
	});

	// 
	jQuery('#permission_frm').validationEngine({
		prettySelect : true,
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = "action=userPermission&";
				var data = $('#permission_frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='warning'){
						   showMessage(msg.action,msg.message);
						   $('#btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						   showMessage(msg.action,msg.message);							   
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>user/list";},3000);
					   }
					   if(msg.action=='notice'){
						   showMessage(msg.action,msg.message);		   					   
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }			   					   
					   if(msg.action=='error'){
						   showMessage(msg.action,msg.message);
						   $('#buttonsP img').remove();
		 				   $('.formButtons').show();
						   return false;
					   }
				   }
				});
				return false;
			}
		}
	});
});

jQuery(document).on('click', 'a.check-all', function() {
	jQuery('input.mcheck').prop("checked", true);
});

jQuery(document).on('click', 'a.uncheck-all', function() {
	jQuery('input.mcheck').prop("checked", false);
});

jQuery(document).on('click', 'input.parent', function() {
	var _val = jQuery(this).val();
	if (jQuery(this).prop('checked')==true){ 
        jQuery('input.child-'+_val).prop('checked', true);
	}
	else {
		jQuery('input.child-'+_val).prop('checked', false);
	}
});
</script>
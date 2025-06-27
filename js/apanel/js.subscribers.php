<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.subscribers.php';
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
	})
});

/***************************************** Social Record delete *******************************************/
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

/***************************************** Add new Social link *******************************************/
function AddNewSocial()
{
	window.location.href="<?php echo ADMIN_URL?>subscribers/addEdit";
}

/***************************************** View Social link *******************************************/
function viewSociallist()
{
	window.location.href="<?php echo ADMIN_URL?>subscribers/list";
}

/***************************************** Edit Social link *******************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>subscribers/addEdit/"+Re;
}

/***************************************** AddEdit login Info *******************************************/
$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#subscribers_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				var data = $('#subscribers_frm').serialize();
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
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>subscribers/list";},3000);
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
	})
});

$(function(){
/*************************************** USer Social Status Toggler ******************************************/		
	$('.socailStatusToggle').on('click', function(){
		var Re 		= $(this).attr('rowId');
		var status 	= $(this).attr('status');		
		newStatus = (status == 1) ? 0 : 1;
		$.ajax({
		   type: "POST",
		   url:  getLocation(),
		   data: "action=toggleStatus&id="+Re,
		   success: function(msg){}
		});
		$(this).attr({'status':newStatus});
		if(status==1){
			$('#toggleImg'+Re).removeClass("icon-thumbs-up");
			$('#toggleImg'+Re).addClass("icon-thumbs-down");
		}else{
			$('#toggleImg'+Re).removeClass("icon-thumbs-down");
			$('#toggleImg'+Re).addClass("icon-thumbs-up");
		}
	});
});
</script>
<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.bookinginfo.php';
}

/***************************************** Re ordering Users *******************************************/
$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	})
});

/***************************************** Booking Record delete *******************************************/
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
		$( ".botTempo").unbind( "click" );
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** View Booking link *******************************************/
function viewBookinglist()
{
	window.location.href="<?php echo ADMIN_URL?>bookinginfo/list";
}

/***************************************** Edit Booking link *******************************************/
function viewRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>bookinginfo/view/"+Re;
}
</script>
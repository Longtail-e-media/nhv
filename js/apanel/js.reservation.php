<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.reservation.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.reservation.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

$(document).ready(function(){	
	$('.btn-submit').on('click',function(){
		var actVal = $(this).attr('btn-action');
		$('#idValue').attr('myaction',actVal);
	})

	// form submisstion actions		
	jQuery('#hotel_frm').validationEngine({		
		prettySelect : true,
		autoHidePrompt:true,
		useSuffix: "_chosen",
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;	
				/* By Me */
				for ( instance in CKEDITOR.instances ) 
				CKEDITOR.instances[instance].updateElement();	
				/* End By Me */				
				var data = $('#hotel_frm').serialize();
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
						   $('.btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						   showMessage(msg.action,msg.message);	
						   var actionId = $('#idValue').attr('myaction');
						   if(actionId==2)
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>reservation/list";},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>reservation/addEdit";},3000);						   	
						   if(actionId==0)
						   	setTimeout( function(){window.location.href="";},3000);
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

// Edit records
function editRecord(Re)
{
	$.ajax({
	   type: "POST",
	   dataType:"JSON",
	   url:  getLocation(),
	   data: 'action=editExistsRecord&id='+Re,
	   success: function(data){
		   var msg = eval(data);
		   $("#title").val(msg.title);
		   $("#idValue").val(msg.editId);		   
	   }
	});
}
		
// Deleting Record
function recordDelete(Re){
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Hotel")?>');															
	$('.pText').html('Click on yes button to delete this hotel permanently.!!');
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
				 Re='';
				 reStructureList(getTableId());
			   }
			});
		}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** Link Type Choose *******************************************/
function linkTypeSelect(Re){
	if(Re == 0) {		
		$('#linkPage_chosen').removeClass("hide");
		($('#linksrc').val() == 'http://www.') ? $('#linksrc').val('') : null ;
	} else {
		$('#linkPage_chosen').addClass("hide");
		($('#linksrc').val() == '') ? $('#linksrc').val("http://www.") : null ;
	}
}
$(document).ready(function(){	
	$('#linkPage').change(function(){
		$('#linksrc').val($(this).val());
	});
});

/***************************************** ViewLists *******************************************/
function viewHotellist()
{
	window.location.href="<?php echo ADMIN_URL?>reservation/list";
}

/***************************************** Add New*******************************************/
function AddNewHotel()
{
	window.location.href="<?php echo ADMIN_URL?>reservation/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>reservation/addEdit/"+Re;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){
		$('#previewUserimage'+Re).remove(); 
		$('#preview_Image').html('<input type="hidden" name="imageArrayname" value="" class="">');
	});
}

/******************************** Remove saved slideshow image ********************************/
function deleteSavedHotelimage(Re)
{
	$('.MsgTitle').html('Do you want to delete the record ?');															
	$('.pText').html('Clicking yes will be delete this record permanently. !!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$('#removeSavedimg'+Re).fadeOut(1000,function(){$('#removeSavedimg'+Re).remove(); $('.uploader'+Re).fadeIn(500);});
		}else{Re='';}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}
</script>
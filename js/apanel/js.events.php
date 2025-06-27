<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.events.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.events.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

/***************************************** Events Create Date *******************************************/
$(document).ready(function(){
	
	  $.datepicker.setDefaults({dateFormat: 'yy-mm-dd', firstDay: 1});
	  $('#event_stdate').datepicker({minDate: 0, changeMonth: true, changeYear: true, onSelect: function(selectedDate) {
			var minDate = $(this).datepicker('getDate');
			if (minDate) {
				  minDate.setDate(minDate.getDate() + 1);
			}
			$('#event_endate').datepicker('option', 'minDate', minDate || 1); // Date + 1 or tomorrow by default			
	  }});
	  $('#event_endate').datepicker({minDate: 1, changeMonth: true, changeYear: true, onSelect: function(selectedDate) {
			var maxDate = $(this).datepicker('getDate');
			if (maxDate) {
				  maxDate.setDate(maxDate.getDate() - 1);
			}
			$('#event_stdate').datepicker('option', 'maxDate', maxDate); // Date - 1
	  }});
});

/*************************************** Toggle AddEdit Form ********************************************/	
function toggleMetadata(){
	$( ".metadata" ).slideToggle("slow",function(){});
}

$(document).ready(function(){	
	$('.btn-submit').on('click',function(){
		var actVal = $(this).attr('btn-action');
		$('#idValue').attr('myaction',actVal);
	})		
	// form submisstion actions		
	jQuery('#events_frm').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();

				var data = $('#events_frm').serialize();
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
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>events/list";},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>events/addEdit";},3000);						   	
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"event")?>');															
	$('.pText').html('Click on yes button to delete this event permanently.!!');
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
		}else{ Re=null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** View Events Lists *******************************************/
function vieweventslist()
{
	window.location.href="<?php echo ADMIN_URL?>events/list";
}

/***************************************** Add New Events *******************************************/
function AddNewEvents()
{
	window.location.href="<?php echo ADMIN_URL?>events/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>events/addEdit/"+Re;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewimage'+Re).fadeOut(1000,function(){$('#previewimage'+Re).remove();});
}

/******************************** Remove User saved Package images ********************************/
function deleteSavedimage(Re)
{
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"image")?>');															
	$('.pText').html('Click on yes button to delete this image permanently.!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$('#removeSavedimg'+Re).fadeOut(1000,function(){$('#removeSavedimg'+Re).remove(); $('.uploader').fadeIn(500);});
		}else{Re='';}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}
function deleteSavedgalimage(Re)
{
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"image")?>');															
	$('.pText').html('Click on yes button to delete this image permanently.!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$('#removeSavedimg'+Re).fadeOut(1000,function(){$('#removeSavedimg'+Re).remove(); $('.uploader').fadeIn(500);});
		}else{Re='';}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}
</script>
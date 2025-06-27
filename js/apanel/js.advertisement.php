<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.advertisement.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.advertisement.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

$(document).ready(function(){		
	
	  $.datepicker.setDefaults({dateFormat: 'yy-mm-dd', firstDay: 1});
      $('#date_from').datepicker({minDate: 0, changeMonth: true, changeYear: true, onSelect: function(selectedDate) {
            var minDate = $(this).datepicker('getDate');
            if (minDate) {
                  minDate.setDate(minDate.getDate() + 1);
            }
            $('#date_to').datepicker('option', 'minDate', minDate || 1); // Date + 1 or tomorrow by default			
      }});
      $('#date_to').datepicker({minDate: 1, changeMonth: true, changeYear: true, onSelect: function(selectedDate) {
            var maxDate = $(this).datepicker('getDate');
            if (maxDate) {
                  maxDate.setDate(maxDate.getDate() - 1);
            }
            $('#date_from').datepicker('option', 'maxDate', maxDate); // Date - 1
      }});

	// form submisstion actions		
	jQuery('#advertisment_frm').validationEngine({
		prettySelect : true,
		useSuffix: "_chosen",
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;				
				for ( instance in CKEDITOR.instances ) 
				CKEDITOR.instances[instance].updateElement();	
				var data = $('#advertisment_frm').serialize();
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
						   var actionId = $('#idValue').attr('myaction');
						   if(actionId==2)
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>advertisement/list";},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>advertisement/addEdit";},3000);						   	
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"advertisement")?>');															
	$('.pText').html('Click on yes button to delete this advertisement permanently.!!');
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
		}else{ Re=null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** View Articles Lists *******************************************/
function viewadvertisementlist()
{
	window.location.href="<?php echo ADMIN_URL?>advertisement/list";
}

/***************************************** Add New Articles *******************************************/
function AddNewAdvertisement()
{
	window.location.href="<?php echo ADMIN_URL?>advertisement/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>advertisement/addEdit/"+Re;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){
		$('#previewUserimage'+Re).remove(); 
		$('#preview_Image').html('<input type="hidden" name="imageArrayname" value="" class="">');
	});
}

/******************************** Remove saved advertisment image ********************************/
function deleteSavedAdvertisementimage(Re)
{
	$('.MsgTitle').html('Do you want to delete the record ?');															
	$('.pText').html('Clicking yes will be delete this record permanently. !!!');
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

/******************************** Notification Mail Yes/No ********************************/
$(document).ready(function(){
	$('.mailradio').on('click',function(){
		var notVal = $(this).val();
		(notVal==1)?$('.mailsentbox').slideDown() : $('.mailsentbox').slideUp() ;
	})
})
</script>
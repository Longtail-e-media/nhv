<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.testimonial.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.testimonial.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

/***************************************** testimonial Create Date *******************************************/
//$(document).ready(function(){
//	$('#testimonial_date').datepicker({
//		changeMonth: true,
//		changeYear: true,
//		showButtonPanel: true,
//		dateFormat: 'yy-mm-dd'
//	});
//});

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
	jQuery('#testimonial_frm').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();

				var data = $('#testimonial_frm').serialize();
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
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>testimonial/list";},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>testimonial/addEdit";},3000);						   	
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"testimonial")?>');															
	$('.pText').html('Click on yes button to delete this testimonial permanently.!!');
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

/***************************************** View testimonials Lists *******************************************/
function viewtestimoniallist()
{
	window.location.href="<?php echo ADMIN_URL?>testimonial/list";
}

/***************************************** Add New testimonials *******************************************/
function AddNewtestimonial()
{
	window.location.href="<?php echo ADMIN_URL?>testimonial/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>testimonial/addEdit/"+Re;
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
function deleteSavetestimonialimage(Re)
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


/******************************** Choose Video link or Image ********************************/
$(document).ready(function(){
	$('.addtype').on('click',function(){
		var clkVal = $(this).val();
		if(clkVal==1){
			$('.videolink').slideUp();
			$('.add-image').slideDown();
		}else{
			$('.add-image').slideUp();
			$('.videolink').slideDown();
			
		} 
	})
})
</script>
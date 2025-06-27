<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.hotels.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.hotels.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

$(document).ready(function() {
	oTable = $('#subexample').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.hotels.php?action=subSort",
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
	jQuery('#hotels_frm').validationEngine({
		autoHidePrompt:true,
		promptPosition : "bottomLeft",
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
				var data = $('#hotels_frm').serialize();
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
						   setTimeout( function(){$('.my-msg').html('');},3000);
						   $('.btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						   showMessage(msg.action,msg.message);	
						   var actionId = $('#idValue').attr('myaction');
						   var actionlist = $('#parentId').val();
						   if(actionId==2)
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>hotels/list/"+actionlist;},3000);						   	
						   if(actionId==1)	
						   	setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>hotels/addEdit";},3000);						   	
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Hotels")?>');															
	$('.pText').html('Click on yes button to delete this hotels permanently.!!');
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
		}else{Re=null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}


// Deleting Record
function subrecordDelete(Re){
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Hotels")?>');															
	$('.pText').html('Click on yes button to delete this hotels permanently.!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$.ajax({
			   type: "POST",
			   dataType:"JSON",
			   url:  getLocation(),
			   data: 'action=deletesubhotels&id='+Re,
			   success: function(data){
				 var msg = eval(data);  
				 showMessage(msg.action,msg.message);
				 $('#'+Re).remove();
				 reStructureList(getTableId());
			   }
			});
		}else{Re=null;}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/***************************************** Link Type Choose *******************************************/
function linkTypeSelect(Re){
	if(Re == 0) {		
		$('#linkPage_chosen').removeClass("hide");
		($('#hotelsrc').val() == 'http://www.') ? $('#hotelsrc').val('') : null ;
	} else {
		$('#linkPage_chosen').addClass("hide");
		($('#hotelsrc').val() == '') ? $('#hotelsrc').val("http://www.") : null ;
	}
}
$(document).ready(function(){	
	$('#linkPage').change(function(){
		$('#hotelsrc').val($(this).val());
	});
});


/***************************************** View Hotels Lists *******************************************/
function viewHotelslist(Re)
{
	window.location.href="<?php echo ADMIN_URL?>hotels/list/"+Re;
}

/***************************************** Add New Hotels *******************************************/
function AddNewHotels()
{
	window.location.href="<?php echo ADMIN_URL?>hotels/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>hotels/addEdit/"+Re;
}



/***************************************** View Child Category Lists *******************************************/
function viewChildlist(Re)
{
	window.location.href="<?php echo ADMIN_URL?>hotels/list/"+Re;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){
		$('#previewUserimage'+Re).remove(); 		
	});
}

function viewsubimagelist(Re)
{
	window.location.href="<?php echo ADMIN_URL?>hotels/hotelsImageList/"+Re;
}


/******************************** Remove User saved Hotels images ********************************/
function deleteSavedHotelsimage(Re)
{
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"image")?>');															
	$('.pText').html('Click on yes button to delete this image permanently.!!');
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

$(document).on('click', '.bannerImg', function(){
	$('#preview_Image2').html('<input type="hidden" name="imageArrayname2" value="" />');
})
</script>
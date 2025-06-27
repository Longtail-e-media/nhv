<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.gallery.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.gallery.php?action=sort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

/*************************** Shorting Sub Image Gallery Postion *******************************/
$(document).ready(function() {
	oTable = $('#sub-example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.gallery.php?action=subSort",
		  fnSuccess: function(message) { 
					var msg = jQuery.parseJSON(message);
					showMessage(msg.action,msg.message);
			   }
		   });
});

$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#gallery_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				var data = $('#gallery_frm').serialize();
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
						   $('#btn-submit').removeAttr('disabled');						   			   
		 				   $('.formButtons').show();
						   return false
					   }
					   if(msg.action=='success'){
						   showMessage(msg.action,msg.message);							   
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>gallery/list";},3000);
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
/***************************************** View Gallery Lists *******************************************/
	jQuery('#subgallery_frm').validationEngine({
	autoHidePrompt:true,
	scroll: false,
	onValidationComplete: function(form, status){
		if(status==true){	
			$('#btn-submit').attr('disabled', 'true');
			var action = "action=addSubGalleryImage&";
			var data = $('#subgallery_frm').serialize();
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
					   setTimeout( function(){window.location.href=window.location.href;},3000);
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Gallery")?>');															
	$('.pText').html('Click on yes button to delete this gallery permanently.!!');
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

/***************************************** View Gallery Lists *******************************************/
function viewGallerylist()
{
	window.location.href="<?php echo ADMIN_URL?>gallery/list";
}

/***************************************** Add New Gallery *******************************************/
function AddNewGallery()
{
	window.location.href="<?php echo ADMIN_URL?>gallery/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>gallery/addEdit/"+Re;
}



/***************************************** View Articles Lists *******************************************/
function viewGalleryImageslist(Re)
{
	window.location.href="<?php echo ADMIN_URL?>gallery&mode=galleryimagelist/"+Re;
}

/***************************************** Add New Articles *******************************************/
function AddNewGalleryImage(Re)
{
	window.location.href="<?php echo ADMIN_URL?>gallery/addeditgalleryimage/"+Re;
}

/***************************************** Edit Gallery Images records *****************************************/
function editGalleryImageRecord(Re,Reg)
{
	window.location.href="<?php echo ADMIN_URL?>gallery/addeditgalleryimage/"+Re+"/"+Reg;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){$('#previewUserimage'+Re).remove();});
}

function viewsubimagelist(Re)
{
	window.location.href="<?php echo ADMIN_URL?>gallery/galleryimagelist/"+Re;
}

/******************************** Remove User saved Sub Gallery images ********************************/
function subrecordDelete(Re)
{
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"image")?>');															
	$('.pText').html('Click on yes button to delete this image permanently.!!');
	$('.divMessageBox').fadeIn();
	$('.MessageBoxContainer').fadeIn(1000);
	
	$(".botTempo").on("click",function(){						
		var popAct=$(this).attr("id");						
		if(popAct=='yes'){
			$.ajax({
			   type: "POST",
			   dataType:"JSON",
			   url:  getLocation(),
			   data: 'action=deleteSubimage&id='+Re,
			   success: function(data){
				 var msg = eval(data);  
				 if(msg.action=='success'){
					 $('#'+Re).remove();
				 	 reStructureList(getTableId());
				 }
			   }
			});
		}else{Re='';}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/******************************** Remove User saved Gallery images ********************************/
function deleteSavedGalleryimage(Re)
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

$(function(){
/*************************************** USer Image Status Toggler ******************************************/		
	$('.imageStatusToggle').on('click', function(){
		var Re 		= $(this).attr('rowId');
		var status 	= $(this).attr('status');		
		newStatus = (status == 1) ? 0 : 1;
		$.ajax({
		   type: "POST",
		   url:  getLocation(),
		   data: "action=toggleStatusSubimage&id="+Re,
		   success: function(msg){}
		});
		$(this).attr({'status':newStatus});
		if(status==1){
			$('#toggleImg'+Re).removeClass("icon-check-circle-o");
			$('#toggleImg'+Re).addClass("icon-clock-os-circle-o");
		}else{
			$('#toggleImg'+Re).removeClass("icon-clock-os-circle-o");
			$('#toggleImg'+Re).addClass("icon-check-circle-o");
		}
	});
});
</script>
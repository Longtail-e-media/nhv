<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.slideshow.php';
}
function getTableId(){
	return 'table_dnd';
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers"
	}).rowReordering({ 
		  sURL:"<?php echo BASE_URL;?>includes/controllers/ajax.slideshow.php?action=sort",
		  fnAlert: function(message) { 
						  alert(message);
				   }
		   });
});

/*************************** Shorting Sub Image Gallery Postion *******************************/
$(document).ready(function() {
	$(function(){
	$(".slideshow-sort").sortable({	
		//connectWith: ".video-sort",
		start: function(event, ui) {
				var start_pos = ui.item.index();
				ui.item.data('start_pos', start_pos);
			},
		update: function (event, ui) {
				//var start_pos = ui.item.data('start_pos');
				var id		  = ui.item.context.id;
				var end_pos   = ui.item.index();				
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: "action=sortSlideshow&id="+id+"&toPosition="+end_pos,
				   success: function(data){
					   	var msg = eval(data);
						showMessage(msg.action,msg.message);
					 }
				});
			}
		});
	});
});

$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#slideshow_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				//var action = ($('#idValue').val() == 0) ? "action=add&" : "action=edit&" ;
				var action = "action=add&";
				var data = $('#slideshow_frm').serialize();
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
						   setTimeout( function(){window.location.href="<?php echo ADMIN_URL?>slideshow/list";},3000);
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
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Slider image")?>');															
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
			   data: 'action=delete&id='+Re,
			   success: function(data){
				 var msg = eval(data);  
				 showMessage(msg.action,msg.message);
				 $('#'+Re).remove();
				 reStructureList(getTableId());
			   }
			});
		}
		$('.divMessageBox').fadeOut();
		$('.MessageBoxContainer').fadeOut(1000);
	});	
}

/******************************** Remove temp upload image ********************************/
function deleteTempImage(Re)
{
	$('#previewImage'+Re).fadeOut(1000,function(){$('#previewImage'+Re).remove();});
}


/******************************** Remove User saved Sub Gallery images ********************************/
function deleteImage(Re)
{
	$('.MsgTitle').html('<?php echo sprintf($GLOBALS['basic']['deleteRecord_'],"Slider image")?>');															
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
			   data: 'action=delete&id='+Re,
			   success: function(data){
				 var msg = eval(data);  
				 if(msg.action=='success'){
					 showMessage(msg.action,msg.message);
					 $('.removeSavedimg'+Re).fadeOut(1000,function(){$('.removeSavedimg'+Re).remove();});
				 }
			   }
			});
		}else{ Re = null;}
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
		   data: "action=toggleStatus&id="+Re,
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


/***************************************** View slideshow Lists *******************************************/
function viewSlideshowlist()
{
	window.location.href="<?php echo ADMIN_URL?>slideshow/list";
}

/***************************************** Add New slideshow *******************************************/
function AddNewSlideshow()
{
	window.location.href="<?php echo ADMIN_URL?>slideshow/addEdit";
}

/***************************************** Edit records *****************************************/
function editRecord(Re)
{
	window.location.href="<?php echo ADMIN_URL?>slideshow/addEdit/"+Re;
}


</script>
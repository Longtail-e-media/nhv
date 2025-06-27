<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.config.php';
}

$(document).ready(function(){		
	// form submisstion actions		
	jQuery('#location_frm').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action = ($('#idValue').val() == 0) ? "action=locationadd&" : "action=locationedit&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
				var data = $('#location_frm').serialize();
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

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){
		$('#previewUserimage'+Re).remove(); 
		$('#preview_Image').html('<input type="hidden" name="imageArrayname" value="" class="">');
	});
}

/******************************** Remove saved advertisment image ********************************/
function deleteSavedPreferenceimage(Re)
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


/******************************** Choose Video link or Image ********************************/
$(document).ready(function(){
	$('.addtype').on('click',function(){
		var clkVal = $(this).val();
		if(clkVal==1){
			$('.image-link').slideUp();
			$('.google-link').slideDown();
		}else{
			$('.google-link').slideUp();
			$('.image-link').slideDown();
			
		} 
	})
})
</script>
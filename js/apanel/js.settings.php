<script language="javascript">

function getLocation(){
	return '../includes/controllers/ajax.' + 'settings.php';
}
function getTableId(){
	return 'table_dnd';
}

<!-- FOR GENERAL SETTINGS SECTION -->
$(document).ready(function(){
	/*$('#generalSettings_frm').submit(function(){
	
		if($("#generalSettings_frm").validationEngine({returnIsValid:true})){
			
			queryString = 'action=general&' + prepareQuerystring(this);
			sendToDatabase(queryString, getLocation(), 'mainFieldset');
		} 
		return false;
	});*/
	
	
		// form submisstion actions		
	jQuery('#generalSettings_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('#btn-submit').attr('disabled', 'true');
				var action ="action=general&" ;
				for ( instance in CKEDITOR.instances )
                CKEDITOR.instances[instance].updateElement();
				var data = $('#generalSettings_frm').serialize();
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
						 setTimeout( function(){window.location.href="main.php?page=settings&mode=general";},3000);
					   }
					   if(msg.action=='notice'){
					  	 showMessage(msg.action,msg.message);		   					   
					   	 setTimeout( function(){window.location.href="main.php?page=settings&mode=general";},3000);
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
})

<!-- FOR PROFILE SETTINGS SECTION -->
$(document).ready(function(){
	$('#profileSettings_frm').submit(function(){
		// * start validating 
		if($("#profileSettings_frm").validationEngine({returnIsValid:true})){
			queryString = 'action=profile&' + prepareQuerystring(this);
			sendToDatabase(queryString, getLocation(), 'mainFieldset');
		} // ## ends validating
		return false;
	});
});

<!-- FOR SITE MODULE SECTION -->
$(document).ready(function(){

	// Inline Editing
	$('.inlineEditing').focus(function(){
		var id = $(this).attr("realId");
		$('#save'+id).show('slow');
	});
	$('.inlineSave').click(function(){
		var id = $(this).attr("realImgId");
		var value = $('#perPage'+id).val();
		$.ajax({
		   type: "POST",
		   url:  getLocation(),
		   data: "action=perPageSave&id=" + id + "&perpage=" + value,
		   success: function(msg){
			(msg == 4) ? null : showMessage(msg, 'mainFieldset');
		   }
		});
	});
	$('.inlineEditing').blur(function(){
		var id = $(this).attr("realId");
		$('#save'+id).hide(2000);
	});
	
	$('.module_txtbox').blur(function(){
		var id 	= $(this).attr('realId');
		var val = $(this).val();
		$.ajax({
		   type: "POST",
		   url:  getLocation(),
		   data: "action=module_name&id=" + id + "&name=" + val,
		   success: function(msg){
			(msg == 4) ? null : showMessage(msg, 'mainFieldset');
		   }
		});
	});
	
});
</script>
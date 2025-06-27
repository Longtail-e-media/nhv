<script language="javascript">

function getLocation(){
	return '<?php echo BASE_URL;?>includes/controllers/ajax.themes.php';
}

$(document).ready(function(){
	// Header section
	$(".clorval").spectrum({
	    showInput: true,
	    showPalette: true,
	    preferredFormat: "hex3",    
	    palette: [
	        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
	        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
	        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
	        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
	        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
	        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
	        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
	        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
	    ],
	    hide: function(color) {
	       	var kcolor = color.toHexString(); // #ff0000	       	
	       	$('input[name="bgcolor"]').val(kcolor);
	    }
	});

	// Action for Properties
	jQuery('.properties_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');
				var actype  = $(form).attr('frm-for');			
				var action = "action=action-properties&actype="+actype+"&";
				var data = $(form).serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);					   
					   if(msg.action=='success'){
					   		$('.btn-submit').removeAttr('disabled');
						   showMessage(msg.action,msg.message);						   
						   //setTimeout( function(){window.location.href="";},3000);	
					   }
				   }
				});
			return false;
			}
		}
	});

	// Action for JS Properties
	jQuery('.jsproperties_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');				
				var actype  = $(form).attr('frm-for');			
				var action = "action=action-jsproperties&actype="+actype+"&";
				var data = $(form).serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);					   
					   if(msg.action=='success'){
					   	   $('.btn-submit').removeAttr('disabled');
						   showMessage(msg.action,msg.message);							   					   
						   //setTimeout( function(){window.location.href="";},3000);	
					   }
				   }
				});
			return false;
			}
		}
	});

	// Action for CSS Properties
	jQuery('.cssproperties_frm').validationEngine({
		autoHidePrompt:true,
		scroll: false,
		onValidationComplete: function(form, status){
			if(status==true){					
				$('.btn-submit').attr('disabled', 'true');
				var actype  = $(form).attr('frm-for');							
				var action = "action=action-cssproperties&actype="+actype+"&";
				var data = $(form).serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  getLocation(),
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);					   
					   if(msg.action=='success'){
					   	   $('.btn-submit').removeAttr('disabled');
						   showMessage(msg.action,msg.message);						   
						   //setTimeout( function(){window.location.href="";},3000);	
					   }
				   }
				});
			return false;
			}
		}
	});

});

// Input section 
function changeresult(Rid){

	var ival = $("input[name='valnew"+Rid+"']").val();   	
   	var action = "action=editthemes&id="+Rid+"&keyval="+ival;		
	queryString = action;
    $.ajax({
	    type: "POST",
	    dataType:"JSON",
	    url:  getLocation(),
	    data: queryString,
	    success: function(data){
		    var msg = eval(data);			   
		    if(msg.action=='success'){
			   showMessage(msg.action,msg.message);							   
			   setTimeout( function(){window.location.href=window.location.href;},3000);
		    }
	    }
	});
	return false;
}

/******************************** Remove temp upload image ********************************/
function deleteTempimage(Re)
{
	$('#previewUserimage'+Re).fadeOut(1000,function(){
		$('#previewUserimage'+Re).remove(); 
		$('#preview_Image').html('<input type="hidden" name="imageArrayname" value="" class="">');
	});
}

/******************************** Remove saved Articles image ********************************/
function deletesvimage(Re)
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
</script>
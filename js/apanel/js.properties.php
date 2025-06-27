<script language="javascript">
/********** Slideshow Properties Setting ***********/
$(document).ready(function(){	
	// form submisstion actions	for menu properties	
	jQuery('#menu-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#menu-properties').serialize();
				queryString = "action=menu-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for articles properties	
	jQuery('#articles-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#articles-properties').serialize();
				queryString = "action=articles-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for slideshow properties	
	jQuery('#slideshow-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#slideshow-properties').serialize();
				queryString = "action=slideshow-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for offers properties	
	jQuery('#offers-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#offers-properties').serialize();
				queryString = "action=offers-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for gallery properties	
	jQuery('#gallery-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#gallery-properties').serialize();
				queryString = "action=gallery-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for news properties	
	jQuery('#news-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#news-properties').serialize();
				queryString = "action=news-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for products properties	
	jQuery('#products-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#products-properties').serialize();
				queryString = "action=products-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for advertisment properties	
	jQuery('#advertisment-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#advertisment-properties').serialize();
				queryString = "action=advertisment-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for social link properties	
	jQuery('#social-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#social-properties').serialize();
				queryString = "action=social-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for destination properties	
	jQuery('#destination-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#destination-properties').serialize();
				queryString = "action=destination-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for activities properties	
	jQuery('#activities-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#activities-properties').serialize();
				queryString = "action=activities-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for package properties	
	jQuery('#package-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#package-properties').serialize();
				queryString = "action=package-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})

	// form submisstion actions	for preference properties	
	jQuery('#preference-properties').validationEngine({
		autoHidePrompt:true,
		scroll: true,
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-submit').attr('disabled', 'true');			
				var data = $('#preference-properties').serialize();
				queryString = "action=preference-properties&"+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  '<?php echo BASE_URL;?>includes/controllers/ajax.properties.php',
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
						   setTimeout( function(){window.location.href=window.location.href;},3000);
					   }
				   }
				});
			return false;
			}
		}
	})
});
</script>
// JavaScript Document
var base_url = $('.base').attr('url');
$(function(){	
	$('#username').focus();
	/* For Login Section */
	jQuery('#login-frm').validationEngine({
		autoHidePrompt:true,
		promptPosition:"bottomLeft",
		scroll: false,
		'custom_error_messages': {
	        '#username': {
	            'required': {
	                'message': "Username is required !"
	            }
	        },
	        '#password': {
	            'required': {
	                'message': "Password is required !"
	            }
	        }
	    },
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-login').attr('disabled', 'true').html('Processing...');
				var action = "action=checkLogin&";
				var data = $('#login-frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  base_url+"includes/controllers/ajax.user.php",
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='success'){			   
					   		if(msg.pgaction==1){
					   			window.location.href= ""+base_url+"apanel/preference/list";
					   		}else{
					   			window.location.href= ""+base_url+"apanel/dashboard";
					   		}						   
					   }
					   if(msg.action=='unsuccess'){
					   		$(".infobox").slideDown();
							$('.display_message').html(msg.message);	
							$('.btn-login').removeAttr('disabled').html('logon');
							setTimeout( function(){$(".infobox").slideUp(); $("#login-frm")[0].reset();},3000);
					   }	
				   }
				});
			return false;
			}
		}
	})

	/* For Forget Password Section */
	jQuery('#forget-frm').validationEngine({
		autoHidePrompt:true,
		promptPosition:"bottomLeft",
		scroll: false,
		'custom_error_messages': {
	        '#mailaddress': {
	            'required': {
	                'message': "Email Address is required !"
	            }
	        }
	    },
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-forget').attr('disabled', 'true').html('Processing...');
				var action = "action=forgetuser_password&";
				var data = $('#forget-frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  base_url+"includes/controllers/ajax.user.php",
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='success'){			   
						   $(".infobox").slideDown();
							$('.display_message').html(msg.message);	
							$('.btn-forget').removeAttr('disabled').html('Recover Password');
							setTimeout( function(){$(".infobox").slideUp(); $("#forget-frm")[0].reset();},6000);
					   }
					   if(msg.action=='unsuccess'){
					   		$(".infobox").slideDown();
							$('.display_message').html(msg.message);	
							$('.btn-forget').removeAttr('disabled').html('Recover Password');
							setTimeout( function(){$(".infobox").slideUp(); $("#forget-frm")[0].reset();},6000);
					   }	
				   }
				});
			return false;
			}
		}
	})
	
	/* For Reset Password Section */
	jQuery('#reset-frm').validationEngine({
		autoHidePrompt:true,
		promptPosition:"bottomLeft",
		scroll: false,
		'custom_error_messages': {
	        '#mailaddress': {
	            'required': {
	                'message': "Email Address is required !"
	            }
	        }
	    },
		onValidationComplete: function(form, status){
			if(status==true){	
				$('.btn-reset').attr('disabled', 'true').html('Processing...');
				var action = "action=resetuser_password&";
				var data = $('#reset-frm').serialize();
				queryString = action+data;
				$.ajax({
				   type: "POST",
				   dataType:"JSON",
				   url:  base_url+"includes/controllers/ajax.user.php",
				   data: queryString,
				   success: function(data){
					   var msg = eval(data);
					   if(msg.action=='success'){			   
						   $(".infobox").slideDown();
							$('.display_message').html(msg.message);	
							$('.btn-forget').removeAttr('disabled').html('Recover Password');
							setTimeout( function(){$(".infobox").slideUp(); 
							window.location.href=base_url+'apanel/login'},6000);
					   }
					   if(msg.action=='unsuccess'){
					   		$(".infobox").slideDown();
							$('.display_message').html(msg.message);	
							$('.btn-forget').removeAttr('disabled').html('Recover Password');
							setTimeout( function(){$(".infobox").slideUp(); $("#forget-frm")[0].reset();},6000);
					   }	
				   }
				});
			return false;
			}
		}
	})
});
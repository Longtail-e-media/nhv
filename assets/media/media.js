jQuery(document).ready(function($) {
	var asset_path = $('.assetpath').attr('url');
	var video_url = jQuery(".video-url").val();
	var obj = jQuery(this);
	
	if(validate_url(video_url)) {
		/*obj.attr("disabled", "disabled");
		obj.prop('value', 'Loading...');
		obj.css('cursor', 'default');
		jQuery(".ajax_indi").show();
		var str = jQuery("#fb_expand").serialize();*/
		var urlt = $('.url_type').val();
		var str = "url="+video_url+"&url_type="+urlt;
		jQuery.ajax({
			type: "POST",
			url: asset_path+"media/media.php",
			data: str,
			cache: false,
			success: function(html){
				jQuery('.results').prepend(html);
				obj.attr("disabled", false);
				obj.prop('value', 'Post');
				obj.css('cursor', 'pointer');
				jQuery(".ajax_indi").hide();
				jQuery("#url").val('');
			}
		});
		
	} else {
		alert("Enter Youtube/Vimeo/Soundcloud/Metacafe/Dailymotion url");
		jQuery("#url").focus();
	}

	

	function validate_url(url) {
		var youtube = url.search("youtu");
		var vimeo = url.search("vimeo");
		var soundcloud = url.search("soundcloud");
		var metacafe = url.search("metacafe");
		var dailymotion = url.search("dailymotion");
		
	if((youtube != -1) || (vimeo != -1) || (soundcloud != -1) || (metacafe != -1) || (dailymotion != -1))
	  {
		  if(youtube != -1) { jQuery(".url_type").val('youtube'); }
		  if(vimeo != -1) { jQuery(".url_type").val('vimeo'); }
		  if(soundcloud != -1) { jQuery(".url_type").val('soundcloud'); }
		  if(metacafe != -1) { jQuery(".url_type").val('metacafe'); }
		  if(dailymotion != -1) { jQuery(".url_type").val('dailymotion'); }
		  return true;
	  } else {
		  return false;
	  }
	}
});
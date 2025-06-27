<?php
//get file contents via curl
function file_get_contents_curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $data = curl_exec($ch);
	$info = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	
	//checking mime types
	if(strstr($info,'text/html')) {
		curl_close($ch);
    	return $data;
	} else {
		return false;
	}
}

function check_url($value)
{
  $value = trim($value);
  if (get_magic_quotes_gpc()) 
  {
	$value = stripslashes($value);
  }
  $value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
  $value = strip_tags($value);
  $value = htmlspecialchars($value);
  return $value;
}

function get_youtube_code($url)
{
		$parse = parse_url($url);
		if(!empty($parse['query'])) {
		  preg_match("/v=([^&]+)/i", $url, $matches);
		  return $matches[1];
		} else {
		  //to get basename
		  $info = pathinfo($url);
		  return $info['basename'];
		}
}

function getHost($Address) 
{ 
   $parseUrl = parse_url(trim($Address)); 
   return trim($parseUrl['host'] ? $parseUrl['host'] : array_shift(explode('/', $parseUrl['path'], 2))); 
}

function get_youtube_thumbnail($url)
{
	$parse = parse_url($url);
	if(!empty($parse['query'])) {
	preg_match("/v=([^&]+)/i", $url, $matches);
	$id = $matches[1];
	} else {
	//to get basename
	$info = pathinfo($url);
	$id = $info['basename'];
	}	
	$img = "http://img.youtube.com/vi/$id/1.jpg";
	return $img;
}

function get_metacafe_thumbnail($id, $title, $size='large'){
    if($id && $title){
        if($size=='large'){
            return "http://s4.mcstatic.com/thumb/{$id}/0/6/videos/0/6/{$title}.jpg";    
        }elseif($size=='small'){
            return "http://s4.mcstatic.com/thumb/{$id}/0/4/directors_cut/0/1/{$title}.jpg";    
        }
    }
    return false;
}

function dailymotion_video_details($url)
{
	preg_match('~(?:www\.)?dailymotion\.(?:com|alice\.it)/(?:(?:[^"]*?)?video|swf)/([a-z0-9]{1,18})~imu', $url, $matches);
	if($matches) {
		$dailymotion = array();
		$dailymotion['id'] = $matches[1];
		$dailymotion['thumbnail'] = "http://www.dailymotion.com/thumbnail/160x120/video/".$matches[1];
		return $dailymotion;
	}
}

function metacafe_video_details($url)
{
	preg_match('|metacafe\.com/watch/([\w\-\_]+)(.*)|', $url, $matches);
	if($matches) {
		$metacafe = array();
		$metacafe['id'] = $matches[1];
		$metacafe['title'] = ltrim(rtrim($matches[2], '/'), '/');
		return $metacafe;
	}
}

//function is used to get vimeo link ID
function parse_vimeo($link)
{
        $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';
 
        preg_match($regexstr, $link, $matches);
        return $matches[1];
}

function get_vimeo_thumbnail($url)
{
	$id = parse_vimeo($url);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://vimeo.com/api/v2/video/$id.php");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = unserialize(curl_exec($ch));
	$output = $output[0]['thumbnail_medium'];
	curl_close($ch);
	return $output;
}


if(!empty($_POST['url']) && !empty($_POST['url_type'])) {
	$v_url = trim($_POST['url']);
	$v_type = trim($_POST['url_type']);
	
	$v_url = check_url($v_url);
	//pass url to fetch url content via curl
	$html = file_get_contents_curl($v_url);
	
	if($html) {
	//parsing begins here:
	$doc = new DOMDocument();
	@$doc->loadHTML($html);
	$nodes = $doc->getElementsByTagName('title');
	
	//get and display what you need:
	$title = $nodes->item(0)->nodeValue;
	$metas = $doc->getElementsByTagName('meta');
	
	for ($i = 0; $i < $metas->length; $i++)
	{
		$meta = $metas->item($i);
		if($meta->getAttribute('name') == 'description')
			$description = $meta->getAttribute('content');
	}
		
		switch($v_type)
		{
			case "youtube":
			$thumbnail = get_youtube_thumbnail($v_url);
			$class = "youtube";
			break;
			case "vimeo":
			$thumbnail = get_vimeo_thumbnail($v_url);
			$class = "vimeo";
			break;
			case "soundcloud":
			$thumbnail = "soundcloud.png";
			$class = "soundcloud";
			break;
			case "metacafe":
			$metacafe = metacafe_video_details($v_url);
			$thumbnail = get_metacafe_thumbnail($metacafe['id'], $metacafe['title']);
			$class = "metacafe";
			break;
			case "dailymotion":
			$daily_motion = dailymotion_video_details($v_url);
			$thumbnail = $daily_motion['thumbnail'];
			$class = "dailymotion";
			break;
		}
?>
    
    <div class="videos">
  <div class="expand-video"> <a class="<?php echo $class; ?>" href="<?php echo $v_url; ?>"><span></span> <img src="<?php echo $thumbnail; ?>" width="120" height="90" title="Play" alt="Play"/> </a> </div>
  <div class="details">
    <h6><?php echo $title; ?></h6>
    <p class="link"><?php echo getHost($v_url); ?></p>
    <p class="desc"><?php echo $description; ?></p>
  </div>
</div>

  <?php
	}
}
?>
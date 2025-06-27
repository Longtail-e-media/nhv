<?php
date_default_timezone_set("Asia/Kathmandu"); 
//changes dd/mm/yyyy to yyyy-mm-dd
function getDateFormat($date=""){
	if($date!=""){
		$newDate = explode("/",$date,3);
		if(count($newDate)==3){
			$date = $newDate[2]."-".$newDate[1]."-".$newDate[0];
		}
	}
	return $date;
}
//changes dd/mm/yyyy to yyyy-mm-dd
function getDisplayFormat($date=""){
	if($date!=""){
		$newDate = explode("-",$date,3);
		if(count($newDate)==3){
			$date = $newDate[2]."/".$newDate[1]."/".$newDate[0];
		}
	}
	return $date;
}

// Remove the  marked zeros from date.
function strip_zeros_from_date($marked_string=""){
	$no_zeros = str_replace('*0', '', $marked_string); 
	$cleaned_string = str_replace('*', '', $no_zeros); 
	return $cleaned_string;
}

// Redirect the page to specified location.
function redirect_to($location=NULL){
	if($location!=NULL):
		//header("Location: {$location}");
		echo "<script language='javascript'>window.location.href = '{$location}';</script>";
		exit;
	endif;
}

// Redirect the page to history back location.
function redirect_back($num=-1){
	echo("<script language='javascript'>history.back(".$num.");</script>");
	exit;
}

// Display the message if any.
function output_message($message=""){
	if(!empty($message)){
		return $message;
	} else {
		return "";
	}
}

//Autoload model file if not defined.
spl_autoload_register('autoload');
function autoload($class_name){
	$class_name = strtolower($class_name);
	$path = LIB_PATH.DS."modals".DS."class.{$class_name}.php";
	if(file_exists($path)){
		require_once($path);
	} else {
		die("<h3>The file class.{$class_name}.php could not be found.</h3>");
	}
}

// Include Layout Templates
function include_apanel_template($template=""){
	include(SITE_ROOT.DS."layouts".DS.'apanel'.DS.$template);
}
function include_layout_template($template=""){
	include(SITE_ROOT.DS."layouts".DS.$template);
}

function include_template($template=""){
	include(SITE_ROOT.DS."layouts".DS."frontend".DS.$template);
}

// Record actions in the log file.
function log_action($action, $userid=1,$useraction=0){
	global $db;
	$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
	$log = new Log();
	$log->action = $action;
	$log->registered = $timestamp;
	$log->userid = $userid;
	$log->user_action = $useraction;
	$log->ip_track = $_SERVER['REMOTE_ADDR'];
	$log->save();
}

function registered()
{
	return strftime("%Y-%m-%d %H:%M:%S", time());
}

function ACCESS(){
	return session_id();
}

// For session id`
function access_permission($id='', $agent='', $key=''){
	global $db;
	$sql 	= "SELECT id FROM tbl_users WHERE accesskey='$key' AND id='$id' LIMIT 1";
	$rec 	= $db->query($sql);
	$result = $db->num_rows($rec);

	$token = ACCESS();
	$sql = "UPDATE tbl_configs SET token='$token' WHERE id='1'";
	$db->query($sql);

	$access = Config::getField('token',true);
	
	/*if($access == $token){
		return 'true';
	}*/

	if($result>0 and $agent==$_SERVER['HTTP_USER_AGENT']){
		return 'true';
	}else{
		return 'false';
	}
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

//My new Row Re-ordering function
function datatableReordering($tableName='', $sortId='', $fieldName='', $parentField='', $parentId='', $type=0){
	global $db;
	/* Total Field Count */
	$sql = "SELECT id FROM ".$tableName;
	$total = $db->num_rows($db->query($sql));
	/* Re-ordering Processing */
	$tblField = !empty($fieldName)?$fieldName:'sortorder';
	$cond = (!empty($parentField) and !empty($parentId))?' AND '.$parentField.'='.$parentId:'';
	$myVal 	= explode(';', $sortId);
	foreach($myVal as $key=>$val){
		$newId  = $myVal[$key];
		$sort = ($type!=1)?$key:($total-$key);
		if(!empty($newId) and !empty($sortId)){
			$query = 'UPDATE '.$tableName.' SET '.$tblField.'='.$sort.' WHERE id='.$val.' '.$cond.';';
			$db->query($query);
		}
	}
}

// RECORD REORDER... START FROM 1 to ..
function reOrder($tableName="", $fieldName=""){
	global $db;
	if($tableName!=""){
		if($fieldName==""){$fieldName="sortorder";}
		$sql1 = "SET @i := 0;";
		$sql2 = "UPDATE {$tableName} SET {$fieldName} = (@i := @i+1 ) ORDER BY {$fieldName};";
		$db->query($sql1);
		$db->query($sql2);
	}
}

// RECORD REORDER... START FROM 1 to ..
function reOrderSub($tableName="", $fieldName="", $condField="", $cond=""){
	global $db;
	if($tableName!=""){
		if($fieldName==""){$fieldName="sortorder";}
		$sql1 = "SET @i := 0;";
		$sql2 = "UPDATE {$tableName} SET {$fieldName} = (@i := @i+1 ) WHERE {$condField}= {$cond} ORDER BY {$fieldName};";
		$db->query($sql1);
		$db->query($sql2);
	}
}

//DISPLAYS THE ADMIN PANEL ICONS
function getIcon($name=""){
	if($name!=""){
		echo "<img src='".BASE_URL."images/icons/{$name}' class='admin-icon' />";
	}
}

function uploadImage($field_name, $maxSize, $file_folder){
	
	$image		= trim($_FILES[$field_name]['name']);
	$imagesize	= $_FILES[$field_name]['size'];
	$maxfilesize= ($maxSize==0) ? 1000000 : $maxSize;
	
	$imgparts = explode(".", $_FILES[$field_name]['name']);
	$image	=	time().rand(1, 50000).".".$imgparts[1];//ADDING TIME BEFORE THE FILE NAME
	
	//LIMIT FILE SIZE
	if($imagesize>=$maxfilesize) {
		return "";
		exit();
	}
		
	if(!copy($_FILES[$field_name]['tmp_name'],"../{$file_folder}/".$image)) {
		return "";
	} else {
		return $image;
	}
}

function RecordCreated(){
	return date('Y-m-d');
}

function getFieldValueFromSession($fieldName=""){
	$return = "";
	if(isset($_SESSION[$fieldName]) && $_SESSION[$fieldName]!=""){
		$return = $_SESSION[$fieldName];
	}
	return $return;
}

//TAKE THE DATABASE BACKUP
function backup_tables($host,$user,$pass,$name,$tables = '*'){
	$return = "";
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*'){
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result)){
			$tables[] = $row[0];
		}
	} else {
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table){
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++){
			while($row = mysql_fetch_row($result)){
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++){
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	//save file
	$fileName = 'db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
	$handle = fopen('../backup/'.$fileName,'w+');
	fwrite($handle,$return);
	fclose($handle);
	return $fileName;
}

// Function for dealing with the subs when deleting a menu..
function delteMenuSubs($id) {
	global $db;
	$sql1 = "SELECT * FROM tbl_menu WHERE parentOf='".$id."'";
	$menuRec = Menu::find_by_sql($sql1);
	foreach($menuRec as $menuRow):
		delteMenuSubs($menuRow->id);
	endforeach;
	
	$db->query("DELETE FROM tbl_menu WHERE id='{$id}'");    
}

// Clear the images not stored in database
function clearImages($tablename="", $folder="", $field="image"){
	global $db;
	
	$DirHandle = @opendir("../images/".$folder."/") or die($folder." could not be opened.");
	
	while($filename = readdir($DirHandle)) {
		if($filename=="." || $filename==".." || $filename == ".htaccess") {continue;}
		
		$sql = $db->query("SELECT {$field} FROM {$tablename} WHERE {$field}='".$filename."'");
		$result = $db->num_rows($sql);
		
		if($result == 0){
			@unlink("../images/{$folder}/".$filename);
		}
	}
}

// Clear the images not stored in database
function JsonclearImages($tablename="", $folder="", $field="image"){
	global $db;
	
	$DirHandle = @opendir("../images/".$folder."/") or die($folder." could not be opened.");
	
	$FolderArr = $dbArr = array();

	while($filename = readdir($DirHandle)) {
		if($filename=="." || $filename==".." || $filename == ".htaccess") {continue;}		
		$FolderArr[] = $filename;
	}      	

	$sql = "SELECT {$field} FROM {$tablename}";
	//$result = Subpackage::find_by_sql($query);
	$query = $db->query($sql);
	while($row = $db->fetch_array($query)){
		$record = json_decode($row['image']);
		if($record){
			foreach($record as $imgName){
				$dbArr[] = $imgName;				
			}
		}
	}
	
	$final = array_diff($FolderArr,$dbArr);
	foreach($final as $k=>$v):
		@unlink("../images/{$folder}/".$v);
	endforeach;
}

function serclearImages($tablename = "", $folder = "", $field = "image")
{
    global $db;

    $DirHandle = @opendir("../images/" . $folder . "/") or die($folder . " could not be opened.");

    $FolderArr = $dbArr = array();

    while ($filename = readdir($DirHandle)) {
        if ($filename == "." || $filename == ".." || $filename == ".htaccess" || $filename == ".gitignore") {
            continue;
        }
        $FolderArr[] = $filename;
    }

    $sql = "SELECT {$field} FROM {$tablename}";
    //$result = Subpackage::find_by_sql($query);
    $query = $db->query($sql);
    while ($row = $db->fetch_array($query)) {
        $record = unserialize($row[$field]);
        if ($record) {
            foreach ($record as $imgName) {
                $dbArr[] = $imgName;
            }
        }
    }

    $final = array_diff($FolderArr, $dbArr);
    foreach ($final as $k => $v):
        @unlink("../images/{$folder}/" . $v);
    endforeach;
}

function isMobile() {
    return preg_match('/(android|iphone|ipad|ipod|blackberry|webos|windows phone|symbian|opera mini|iemobile|mobile|tablet|kindle|silk|playbook)/i', $_SERVER['HTTP_USER_AGENT']);
}

// For frontend templating
function template($filename, $vars, $current="orion")
{
	if(file_exists($filename))
	{
		$output = file_get_contents($filename);
		$output = preg_replace('/src="/', 	'src="'.BASE_URL.'template/'.$current.'/', $output);
		$output = preg_replace('/<link href="/', '<link rel="stylesheet" href="'.BASE_URL.'template/'.$current.'/', $output);
		foreach($vars as $key => $value):
			$output = preg_replace('/<jcms:'.$key.'\/>/', $value, $output);			
		endforeach;
		echo $output;
	} 
	else
	{
		echo "<h1>** Template Not Found **</h1>";
		echo "<br />{$filename} is missing.";
	}	
}

//UPLOADING TEMPLATES
function upload_template($field, $destination) {
	$src=$_FILES[$field]['tmp_name'];
	if(copy($src,"../../template/{$destination}")) {
		return $destination;
	} else {
		//phpalert("The TEMPLATE can\'t be uploaded.");
		return("");
	}
}

//Returns the JCMS default Sources script code..
function getScripts($filename) {
	$expFile 	= explode(".", $filename);
	$totaldot	= count($expFile);
	$return 	= '';
	
	if($totaldot >= 1)
	{
		$type = $expFile[$totaldot-1];
		switch($type){
			case "js":
				$return = "<script type=\"text/javascript\" src=\"".JS_PATH.$filename."\"></script>\n";
				break;
				
			case "css":
				$return = "<link rel=\"stylesheet\" href=\"".CSS_PATH.$filename."\" type=\"text/css\" media=\"screen\">\n";
				break;	
		}
	}
	return $return;
}

function getFrontCss($filename) {
	$expFile 	= explode(".", $filename);
	$totaldot	= count($expFile);
	$return 	= '';
	
	if($totaldot >= 1)
	{
		$type = $expFile[$totaldot-1];
		switch($type){
			case "css":
				$return = "<link rel=\"stylesheet\" href=\"".$filename."\" type=\"text/css\" media=\"screen\">\n";
				break;	
		}
	}
	return $return;
}

function getFrontJs($filename) {
	$expFile 	= explode(".", $filename);
	$totaldot	= count($expFile);
	$return 	= '';
	
	if($totaldot >= 1)
	{
		$type = $expFile[$totaldot-1];
		switch($type){
			case "js":
				$return = "<script type=\"text/javascript\" src=\"".$filename."\"></script>\n";
				break;
		}
	}
	return $return;
}

// returns the parts of the date .. 
// break date of format 2010-05-09 05:53:17 to  parts.. and pass as per required
function getMyDate($date="2010-05-09 05:53:17", $part=1){
	$myDate = explode(" ", $date, 2);
	return ($part==1) ? $myDate[$part-1] : $date;
}

// create a <a>,, </a> tag for the menu item requested.
function getMenuList($caption="", $link="", $type=0, $class="", $tags='', $drop='', $image=''){
	$classLink 	= ($class == '') ? '' : 'class="'.$class.'"';
	//$linkhref	= ($link == '') ? 'javascript:void(0)' : $link;
	$linkhref	= ($link == ''||$link == '#') ? $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] : $link;
	
	$escArray	= array(" ","@","!","#","$","%","^","&","*","(",")",",",".","\\","+","=");
	$captionStr = str_replace($escArray,"_",strtolower($caption));
	$id 		= "id_".$captionStr;	
	$idLink 	= ($id == '') ? '' : ' id="'.$id.'"';
	$linkType	= ($type == 0) ? '' : ' target="_blank"';
	$ndhtag 	= !empty($drop) ?'<b class="caret"></b>':'';
	//return "<a href=\"".BASE_URL.$linkhref."\" ".$classLink.$idLink.$linkType." ".$tags.">".$caption.$ndhtag."</a>";
// 	pr($image);
	if($link == ''|| $link == '#'){
		return "<a href='http://".$linkhref."#'>".$image.$caption.$ndhtag."</a>";
	} else if($type!=0) {
		return "<a href='".$linkhref."' '.$linkType.'>".$image.$caption.$ndhtag."</a>";
	}
	else{
		return "<a href=\"".BASE_URL.$linkhref."\" ".$classLink.$idLink.$linkType." ".$tags.">".$image.$caption.$ndhtag."</a>";
	}
}

function getResMenuList($caption="", $link="", $type=0, $class="",$dash=''){
	$classLink 	= ($class == '') ? '' : 'class="'.$class.'"';
	$linkhref	= ($link == '') ? 'javascript:void(0)' : $link;
	
	$escArray	= array(" ","@","!","#","$","%","^","&","*","(",")",",",".","\\","+","=");
	$captionStr = str_replace($escArray,"_",strtolower($caption));
	$id 		= "id_".$captionStr;
	
	$idLink 	= ($id == '') ? '' : ' id="'.$id.'"';
	$linkType	= ($type == 0) ? '' : ' target="_blank"';
	return "<a href=\"".$linkhref."\" ".$classLink.$idLink.$linkType.">".$dash.$caption."</a>";
}

// get me image with link provided.
function getImageWithLink($title='', $linksrc='', $image='', $path=IMAGE_PATH, $target=1, $width=0, $height=0){
	$splitSRC 	= explode("http://", $linksrc);
	$linkTarget = ($target == 1) 			? ' target="_blank" ' 	: '';
	$imgWidth 	= ($width == 0) 			? '' 					: ' width="'.$width.'"';
	$imgHeight 	= ($height == 0) 			? '' 					: ' height="'.$height.'"';
	$linksrc 	= (count($splitSRC) == 1) 	? 'http://'.$linksrc 	: $linksrc;
	$linkstart  = ($linksrc!='') 			? '<a href="'.$linksrc.'" '.$linkTarget.'>' : '' ;
	$linkend	= ($linksrc!='') 			? '</a>' 				: '' ;
	return $linkstart.'<img src="'.$path.$image.'" alt="'.$title.'" title="'.$title.'" '.$imgWidth.$imgHeight.' />'.$linkend;
}

// get me image with link provided. for fancybox
function getFancyImage($title='', $image='', $path=IMAGE_PATH){
	return "<a rel=\"group\" title=\"".$title."\" href=\"".$path.$image."\"><img src=\"".$path.$image."\" /></a>";
}

// get the percent share of the total
function getPercent($total=1, $share=0){
	$total = ($total == 0) ? 1 : $total;
	return ($share/$total)*100;
}

/*****************************************  Add by Amit  ****************************************/
function getYoutubeImage($e){
	//GET THE URL
	$url = $e;	
	$queryString = parse_url($url, PHP_URL_QUERY);	
	parse_str($queryString, $params);	
	$v = $params['v'];  
	
	// get video ID from $_GET 
	if (!isset($v)) {
	  die ('ERROR: Missing video ID');  
	} else {
	  $vid = $v;
	}

	// set video data feed URL
	$feedURL = 'http://gdata.youtube.com/feeds/api/videos/' . $v;

	// read feed into SimpleXML object
	@$entry = simplexml_load_file($feedURL);

	// parse video entry
	$video = parseVideoEntry($entry);
	
	$video_details = array("vTitle"=>$video->title,"vImg"=>$v,"vLength"=>$video->length);
	
	return $video_details;
} 

// function to parse a video <entry>
function parseVideoEntry($entry) {      
  $obj= new stdClass;

  // get nodes in media: namespace for media information
  $media = $entry->children('http://search.yahoo.com/mrss/');
  $obj->title = $media->group->title;
  $obj->description = $media->group->description;



  // get <yt:duration> node for video length
  $yt = $media->children('http://gdata.youtube.com/schemas/2007');
  $attrs = $yt->duration->attributes();
  $obj->length = $attrs['seconds']; 


  // return object to caller  
  return $obj;      
} 

//By Amit For youtube video play
function embedYoutube($text)
   {
     $search = '%     # Match any youtube URL in the wild.
    (?:https?://)?    # Optional scheme. Either http or https
    (?:www\.)?        # Optional www subdomain
    (?:               # Group host alternatives
      youtu\.be/      # Either youtu.be,
    | youtube\.com    # or youtube.com
      (?:             # Group path alternatives
        /embed/       # Either /embed/
      | /v/           # or /v/
      | /watch\?v=    # or /watch\?v=
      )               # End path alternatives.
    )                 # End host alternatives.
    ([\w\-]{10,12})   # Allow 10-12 for 11 char youtube id.
    \b                # Anchor end to word boundary.
    %x';

$replace = '<object width="550" height="350">
    <param name="movie" value="http://www.youtube.com/v/$1?fs=1"</param>
    <param name="allowFullScreen" value="true"></param>
    <param name="allowScriptAccess" value="always"></param>
    <embed src="http://www.youtube.com/v/$1?fs=1"
        type="application/x-shockwave-flash" allowscriptaccess="always" width="550" height="350">
    </embed>
    </object>';

return preg_replace($search, $replace, $text);
}


// get the site nav links for backend onlye.
function getSiteNavigationLinks($link="")
{
	$linkArray = array(
					"Homepage"				=> "home",
					"Feedback Form" 		=> "contact",
					"News Detail Page" 		=> "news",
					"Notice Detail Page" 	=> "notice",
					"Events"				=> "event",
					"Gallery Page"			=> "gallery",
					"Videos"				=> "video"
				 );
	
	// check if the module is available.
	if(Module::modulePublish(5) == 0){unset($linkArray['Gallery Page']);}	// news module >> module_id = 6
	if(Module::modulePublish(6) == 0){unset($linkArray['News Detail Page']);}	// news module >> module_id = 6
	if(Module::modulePublish(8) == 0){unset($linkArray['Notice Detail Page']);}	// notice module >> module_id = 8
	if(Module::modulePublish(7) == 0){unset($linkArray['Events']);}				// event module >> module_id = 7
	if(Module::modulePublish(9) == 0){unset($linkArray['Videos']);}				// video module >> module_id = 9
				 	
	foreach($linkArray as $key=>$val):
		$selected = ($link == $val) ? "selected='selected'" : '';
		echo "<option value=\"".$val."\" {$selected}>".$key."</option>";
	endforeach;
}

//For uinque code generate.
function codegenerate($mStretch, $iLength = 2)
{
	$sPrintfString = '%0' . (int)$iLength . 's';
	return sprintf($sPrintfString, $mStretch);
}

// Display file size 
function getFileFormattedSize($size=0){
	$formattedSize = $size;
	if($size > 0)
	{
		$formattedSize = $size.' B';
	}
	if($size > 1024)
	{
		$formattedSize = ceil($size/1024).' KB';
	}
	if($size > 1048576)
	{
		$formattedSize = ceil($size/1048576).' MB';
	}
	return $formattedSize;
}
//function by naresh
if(!function_exists("pr")){
	function pr($arr,$exit=true)
	{
	   echo "<pre>";
	   print_r($arr);
	   echo "</pre>";	
	  if($exit) die();
	}
}

if(!function_exists("randomKeys")){
	function randomKeys($length,$pattern=''){
		$i = "";
		$key     = "";
		$add     = "";
		$strLength  = 0;
	   if(empty($pattern)){
		$pattern  =  "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";   
	   }
	   $i = 0;
	   $strLength  =  strlen($pattern);
	   for($i=1;$i<=$length;$i++){
		   $add     =  $pattern[rand(0,$strLength)];
		   if(empty($add)){
		   $add     =  $pattern[rand(0,$strLength)];
		   $key   .= $add; 
		   }else{
			 $key   .= $add;   
		   }		  
	   }
	   return $key;
	}
}

function set_na($arg){
	return !empty($arg)?$arg:'N/A';
}

function PureUrl($title='', $linksrc='', $target=1,$text='Read More',$class=''){
	$splitSRC 	= explode("http://", $linksrc);
	$linkTarget = ($target == 1) 			? ' target="_blank" ' 	: '';	
	$linksrc 	= (count($splitSRC) == 1) 	? BASE_URL.$linksrc 	: $linksrc;
	$linkstart  = ($linksrc!='') 			? '<a href="'.$linksrc.'" '.$linkTarget.' class="'.$class.'">' : '' ;
	$linkend	= ($linksrc!='') 			? '</a>' : '' ;
	return $linkstart.$text.$linkend;
}

function videos_source($string) {
	$rules = array(
	    '#http://(www\.)?youtube\.com/watch\?v=([^ &\n]+)(&.*?(\n|\s))?#i' => '<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/$2"></param><embed src="http://www.youtube.com/v/$2" type="application/x-shockwave-flash" width="425" height="350"></embed></object>', 
	    '#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i' => '<object width="400" height="300"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="400" height="300"></embed></object>'
	);

	foreach ($rules as $link => $player)
		$string = preg_replace($link, $player, $string); 
	return $string;
}

function sanitize_title( $title ) {
    $friendlyURL = htmlentities($title, ENT_COMPAT, "UTF-8", false);
    $friendlyURL = preg_replace('/&([a-z]{1,2})(?:acute|lig|grave|ring|tilde|uml|cedil|caron);/i','\1',$friendlyURL);
    $friendlyURL = html_entity_decode($friendlyURL,ENT_COMPAT, "UTF-8");
    $friendlyURL = preg_replace('/[^a-z0-9-]+/i', '+', $friendlyURL);
    $friendlyURL = preg_replace('/-+/', '+', $friendlyURL);
    $friendlyURL = trim($friendlyURL, '+');
    $friendlyURL = strtolower($friendlyURL);
    return $friendlyURL;
}

function create_slug( $source )
{
    // return false if $source is empty
    if (!$source) { return false; } 
    // convert to lowercase
    $slug = strtolower( $source ); 
    // replace special characters with acceptable alternatives
    $slug = str_replace('&amp;','and',$slug); 
    // remove other special characters completely (e.g. percentages, apostrophes)
    $slug = preg_replace('/[%\'"``]/', '', $slug); 
    // replace all other non-alphanumeric characters with a hyphen
    $slug = preg_replace('/[^a-zA-Z0-9-]/','-',$slug); 
    // replace multiple hyphens with one
    $slug = preg_replace("/[-]+/", "-", $slug); 
    // remove un-needed hyphens from the start and end
    $slug = trim($slug, '-'); 
    return $slug;
}

// My new vido display source function
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
	$img = "http://img.youtube.com/vi/$id/0.jpg";
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

function getMyvideo($v_url='',$v_type=''){
	$v_url = check_url($v_url);
    $html = file_get_contents_curl($v_url);

    if($html){
    	//parsing begins here:
	    $doc = new DOMDocument();
	    @$doc->loadHTML($html);
	    $nodes = $doc->getElementsByTagName('title');
	    
	    //get and display what you need:
	    $title = $nodes->item(0)->nodeValue;
	    $metas = $doc->getElementsByTagName('meta');

	    for ($i = 0; $i < $metas->length; $i++){
	        $meta = $metas->item($i);
	        if($meta->getAttribute('name') == 'description')
	        $description = $meta->getAttribute('content');
    	}
    	$thumbnail='';
    	switch($v_type){
            case "youtube":
                $thumbnail = get_youtube_thumbnail($v_url);
                $class = "youtube";
            break;
            case "vimeo":
                $thumbnail = get_vimeo_thumbnail($v_url);
                $class = "vimeo";
            break;
            case "soundcloud":
                $thumbnail = IMAGE_PATH."apanel/soundcloud.png";
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

        $myArr = array("title"   	 => $title,
        			   "thumb_image" => $thumbnail,
        			   "url"     	 => $v_url,
        			   "host"   	 => getHost($v_url), 
        			   "content" 	 => $description,
        			   "class"		 => $class
        			   );
       return $myArr; 
       //return $thumbnail; ** only for thumbnail image **
    }   
}

function curPageURL(){

	$pageURL = 'http';
	if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

// New pagination Front End
function get_front_pagination($total = '', $per_page = '2', $page = '1', $url = '')
{
    $total = !empty($total) ? $total : '0';
    $adjacents = "2";
    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;

    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total / $per_page);
    $lpm1 = $lastpage - 1;

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<nav class=\"pager-wrappper mt-50\">
                            <ul class=\"pagination justify-content-center mb-0 pb-0\">
                                ";
        if ($page > 1)
            $pagination .= "<li><a href='" . $url . '/page/' . $prev . "' aria-label=\"Previous\">
                                <span aria-hidden=\"true\">&laquo;</span></a></li>";
        else
            $pagination .= "<li><a href='javascript:void(0);' aria-label=\"Previous\">
                                <span aria-hidden=\"true\">&laquo;</span></a></li>";
        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                else
                    $pagination .= "<li><a href='" . $url . '/page/' . $counter . "'>$counter</a></li>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
                $pagination .= "<li><a>...</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/' . $lpm1 . "'>$lpm1</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/' . $lastpage . "'>$lastpage</a></li>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<li><a href='" . $url . '/page/1' . "'>1</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/2' . "'>2</a></li>";
                $pagination .= "<li><a>...</a></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
                $pagination .= "<li><a>...</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/' . $lpm1 . "'>$lpm1</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/' . $lastpage . "'>$lastpage</a></li>";
            } else {
                $pagination .= "<li><a href='" . $url . '/page/1' . "'>1</a></li>";
                $pagination .= "<li><a href='" . $url . '/page/2' . "'>2</a></li>";
                $pagination .= "</li><a>...</a></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a href='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a href='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
            }
        }
        if ($page < $counter - 1)
            $pagination .= "<li><a href='" . $url . '/page/' . $next . "' aria-label=\"Next\">
                                <span aria-hidden=\"true\">&raquo;</span></a></li>";
        else
            $pagination .= "<li><a href='javascript:void(0);' aria-label=\"Next\">
                                <span aria-hidden=\"true\">&raquo;</span></a></li>";
        $pagination .= "</ul>
                            </nav>\n";
    }
    return $pagination;
}

function get_front_pagination_for_search($total = '', $per_page = '2', $page = '1', $url = '')
{
    $total = !empty($total) ? $total : '0';
    $adjacents = "2";
    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $per_page;

    $prev = $page - 1;
    $next = $page + 1;
    $lastpage = ceil($total / $per_page);
    $lpm1 = $lastpage - 1;

    $pagination = "";
    if ($lastpage > 1) {
        $pagination .= "<nav class=\"float-lg-right mt-10 mt-lg-0\">
                            <ul class=\"pagination justify-content-center justify-content-lg-left\">
                                ";
        if ($page > 1)
            $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $prev . "' aria-label=\"Previous\">
                                <span aria-hidden=\"true\">&laquo;</span></a></li>";
        else
            $pagination .= "<li><a class=\"gnav\" hreff='javascript:void(0);' aria-label=\"Previous\">
                                <span aria-hidden=\"true\">&laquo;</span></a></li>";
        if ($lastpage < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<li class='active'><a class=\"gnav\" hreff='javascript:void(0);'>$counter</a></li>";
                else
                    $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $counter . "'>$counter</a></li>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a class=\"gnav\" hreff='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
                $pagination .= "<li><span>...</span></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $lpm1 . "'>$lpm1</a></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $lastpage . "'>$lastpage</a></li>";
            } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/1' . "'>1</a></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/2' . "'>2</a></li>";
                $pagination .= "<li><span>...</span></li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a class=\"gnav\" hreff='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
                $pagination .= "<li><span>...</span></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $lpm1 . "'>$lpm1</a></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $lastpage . "'>$lastpage</a></li>";
            } else {
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/1' . "'>1</a></li>";
                $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/2' . "'>2</a></li>";
                $pagination .= "</li><span>...</span></li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a class=\"gnav\" hreff='javascript:void(0);'>$counter</a></li>";
                    else
                        $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $counter . "'>$counter</a></li>";
                }
            }
        }
        if ($page < $counter - 1)
            $pagination .= "<li><a class=\"gnav\" hreff='" . $url . '/page/' . $next . "' aria-label=\"Next\">
                                <span aria-hidden=\"true\">&raquo;</span></a></li>";
        else
            $pagination .= "<li><a class=\"gnav\" hreff='javascript:void(0);' aria-label=\"Next\">
                                <span aria-hidden=\"true\">&raquo;</span></a></li>";
        $pagination .= "</ul>
                            </nav>\n";
    }
    return $pagination;
}
?>
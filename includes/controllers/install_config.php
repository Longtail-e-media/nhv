<?php
if(isset($_POST['writenow'])) {
	echo 'Loading... Please wait.';
	$url	= $_POST['url'];
	$name	= $_POST['name'];
	$host	= $_POST['host'];
	$user	= $_POST['username'];
	$pass	= $_POST['password'];
	$create	= $_POST['create_db'];
	$root	= $_POST['root_folder'];

	$conn = @mysqli_connect($host,$user,$pass);
	if(!$conn):
		echo "<a href=\"../../index.php\">Try Again!</a> <br />";
		die("Database Connection Failed. ".mysqli_connect_error());
	endif;
	
	if($create==1) {
		//CREATE DATABASE QUERY GOES HERE!
		if(!mysqli_query($conn,"CREATE DATABASE {$name} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci")) {
			echo("<script language='javascript'>location.href='install_config.php?dbcreate=duplicate';</script>");
			die('<h1>UNABLE TO PROCESS FURTHUR</h1>');
		}
	}
	
	$filename = '../config.php';
	
	$somecontent = "<?php \n\n";
	$somecontent.= "\$online = (\$_SERVER['HTTP_HOST'] == \"localhost\" || \$_SERVER['HTTP_HOST'] == \"localhost:2020\" || \$_SERVER['HTTP_HOST'] == \"127.0.0.1\" || \$_SERVER['HTTP_HOST'] == \"192.168.2.220\") ? false : true;\n";
	$somecontent.= "defined('SITE_FOLDER') ? '' : define('SITE_FOLDER', '{$url}');\n";
	$somecontent.= "defined('SITE_STR')    ? '' : define('SITE_STR', '{$root}');\n\n";
	$somecontent.= "if(\$online){ // ONLINE SETUP\n\n";
	$somecontent.= "define('DB_SERVER',   '{$host}');\n";
	$somecontent.= "define('DB_USER', 	  '{$user}');\n";
	$somecontent.= "define('DB_PASS', 	  '{$pass}');\n";
	$somecontent.= "define('DB_NAME', 	  '{$name}');\n\n";
	$somecontent.= "} else { 	// LOCAL SETUP\n\n";
	$somecontent.= "define('DB_SERVER',   '{$host}');\n";
	$somecontent.= "define('DB_USER', 	  '{$user}');\n";
	$somecontent.= "define('DB_PASS', 	  '{$pass}');\n";
	$somecontent.= "define('DB_NAME', 	  '{$name}');\n\n";
	$somecontent.= "}\n\n";
	$somecontent.= "?>\n";
		
	if(is_writable($filename)) {
	
	   if (!$handle = fopen($filename, 'a')) {
			echo "Cannot open file ($filename)";
			exit;
	   }
	   // Write $somecontent to our opened file.
	   if (fwrite($handle, $somecontent) === FALSE) {
		   echo "Cannot write to file ($filename)";
		   exit;
	   }
	   fclose($handle);
	   echo("<script language='javascript'>window.location.href='install_db.php';</script>");
	
	} else {
	   echo "The file $filename is not available!<br>Contact System Administrator !<br>";
	   echo "<a href=\"../../index.php\">Try Again!</a>";
	}

} else {
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LONGTAIL-E-MEDIA | PARTNER IN PROMOTION</title>

<script language="javascript" src="../../js/jquery-1.8.2.min.js"></script>
<script language="javascript" src="../../js/jquery.alphanumeric.js"></script>
<script language="javascript">

function confirmation() {
	var urlcha	= document.getElementById('url').value;
	var namecha	= document.getElementById('name').value;
	var host	= document.getElementById('host').value;
	var username= document.getElementById('username').value;

	if(urlcha=='' || urlcha=='') {
		alert('Please specify your site\'s folder name.');
		document.getElementById('url').focus();
		return false;
	}
	
	if(namecha=='' || namecha=='db_' || namecha=='Enter Database Name') {
		document.getElementById('name').value = 'Enter Database Name';
		document.getElementById('name').select();
		return false;
	}

	if(host=='') {
		document.getElementById('host').value = 'localhost';
		document.getElementById('host').select();
		return false;
	}

	if(username=='') {
		document.getElementById('username').value = 'root';
		document.getElementById('username').select();
		return false;
	}
	
	if(confirm('Are you sure to make these changes?')) {
		return true;
	} else {
		return false;
	}
}

<?php
if(isset($_GET['dbcreate']) && $_GET['dbcreate']=='duplicate')
{
	echo "alert('Oops! The database name you selected already exists! Select another name for your database. ');";	
}
?>
</script>
<style type="text/css">
<!--
body {
	background: #fff;font-family:Trebuchet, Arial, Helvetica, sans-serif;color:#666;font-size:12px;
}
#container{margin:auto;width:980px;}
#s1,#s2{float:left;}
#s2{padding-top:50px;}
#s0{font-size:36px;font:Helvetica, "Trebuchet MS", Arial, Helvetica, sans-serif!important;font-weight:bold;text-align:center;text-shadow:2px 2px 2px #aaa;}
label{display:block;float:left;width:120px;background:#eee;padding:5px 10px;margin-right:5px;}
input[type="text"], input[type="password"]{width:250px;padding:4px 10px;color:#555;border:1px solid #ccc;border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;}
input[type="text"]:focus, input[type="password"]:focus{border-color:#09C;}
input[type="submit"]{background:#036;border:1px solid #ccc;font:11px Helvetica, Tahoma, Geneva, sans-serif;color:#fff;padding:2px 10px;cursor:pointer;margin-left:145px;border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;}
#copyright{text-align:right;padding-top:20px;font-size:11px;}
-->
</style>
</head>
<body>
<?php
	
	$folderwamp = explode('www', dirname(__FILE__));
	if(sizeof($folderwamp)>1){	
		$splitFolder= explode('\\', @$folderwamp[1]);
		$folder = @$splitFolder[count($splitFolder)-3];
	}

	$folderXampp = explode('htdocs', dirname(__FILE__));
	if(sizeof($folderXampp)>1){
		$splitFolder= explode('\\', @$folderXampp[1]);
		$folder = @$splitFolder[count($splitFolder)-3];
	}

	$root_folder = '';//$splitFolder[count($splitFolder)-4];
	$sep = '';
	for($i=(count($splitFolder)-1);$i>3;$i--)
	{
		$root_folder.= $sep.$splitFolder[count($splitFolder)-$i];
		$sep = '::';
	}
?>
<div id="container">
	<div id="s0">SYNHAWK VERSION 2.0 INSTALLATION</div>
	<div id="s1"><img src="../../images/apanel/logo.gif" title="SYNHAWK installation" width="550" /></div>
    <div id="s2">
    <form id="form1" name="form1" method="post" action="">
    <p>
    	<label>Site Folder Name</label>
        <?php echo $folder;?>
        <input name="url" type="hidden" id="url" maxlength="20" class="noSpaces" value="<?php echo $folder;?>" />
        <input name="root_folder" type="hidden" id="root_folder" value="<?php echo $root_folder;?>" />
    </p>
    <p>
    	<label>Database Name</label>
        <input name="name" type="text" id="name" value="db_<?php echo $folder;?>" maxlength="30" class="noSpaces" />
      	<input type="hidden" name="create_db" value="1" />
    </p>
    <p>
    	<label>Host Name</label>
        <input name="host" type="text" id="host" value="localhost" maxlength="30" class="noSpaces" />
    </p>
    <p>
    	<label>Username</label>
        <input name="username" type="text" id="username" value="root" maxlength="30" class="noSpaces" />
    </p>
    <p>
    	<label>Password</label>
        <input name="password" type="password" id="password" maxlength="30" class="noSpaces" />
  		<input type="hidden" name="writenow" id="writenow" value="1" />
    </p>
    <p>
    	<input type="submit" name="Submit" value="Apply Changes" id="Submit" onclick="return confirmation();"/>
    </p>
    </form>
    </div>
    <div style="clear:both;"></div>
    <div id="copyright">&copy; copyright <?php echo date('Y');?> synhawk version 2.0</div>
</div>

<script language="javascript">
$('.noSpaces').alphanumeric();
</script>
<?php } ?>
</body>
</html>
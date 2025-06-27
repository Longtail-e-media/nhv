<?php
$res=$msg='';
$target_dir = "images/review/";
$target_file = $target_dir . basename($_FILES["myfile"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["myfile"])) {
    $check = getimagesize($_FILES["myfile"]["tmp_name"]);
    if($check !== false) {
        $msg= "File is an valid - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg= "File is  invalid.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $msg= "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["myfile"]["size"] > 500000) {
    $msg= "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif"  && $imageFileType != "pdf"  && $imageFileType != "docx"  && $imageFileType != "txt"  ) {
    $msg= "Sorry, only JPG, JPEG, PDF, DOCX, TXT, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $msg= "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) {
        $res = basename( $_FILES["myfile"]["name"]);
        $msg= "The file ". basename( $_FILES["myfile"]["name"]). " has been uploaded.";
    } else {
        $msg= "Sorry, there was an error uploading your file.";
    }
}

echo json_encode(array('msg'=>$msg, 'filename'=>$res));

?>
<?php
require_once("includes/initialize.php");

if(!empty($_REQUEST)){
    $record                 = new NewsComment();
    $record->news_id        = $_REQUEST["blog_id"];
    $record->person_name    = $_REQUEST["name"];
    $record->person_email   = $_REQUEST["email"];
    $record->comment        = $_REQUEST["message"];
    $record->status         = 0;
    $record->sortorder      = NewsComment::find_maximum();

    $db->begin();
    if(!empty($_FILES)){
        $uploadDir = SITE_ROOT.'images/newscomment/';

        // Set the allowed file extensions
        $fileTypes = array('jpg','jpeg','png');

        $tempFile   = $_FILES['img']['tmp_name'];
        $filename   = $_FILES['img']['name'];

        // Validate the filetype
        $fileParts = pathinfo($filename);
        $fullname = str_replace(' ', '-', $_REQUEST["name"]);
        $filenames_space = $fullname.'-'.mt_rand(10,100).'-'.$filename;

        $filenames = preg_replace('/\s+/', '-', $filenames_space);

        $targetFile = $uploadDir . $filenames;
        if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
            // Save the file
            move_uploaded_file($tempFile, $targetFile);
            //Save to database
            $record->image = $filenames;
            if($record->save()){
                $db->commit();
                echo json_encode(array("action"=>"success","message"=>"Your comment has been successfully received."));
            }
        }else{
            $db->rollback();
            echo json_encode(array("action"=>"unsuccess","message"=>"Sorry! could not send your message."));
        }
    }else{
        $db->rollback();
        echo json_encode(array("action"=>"unsuccess","message"=>"Please upload valid image."));
    }
}else{
    echo json_encode(array("action"=>"unsuccess","message"=>"Sorry! could not send your message."));
}


?>
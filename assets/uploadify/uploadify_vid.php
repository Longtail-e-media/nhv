<?php
session_start();
$PROJECT = !empty($_POST['PROJECT']) ? "/" . $_POST['PROJECT'] . "/" : "/";
$targetFolder = $_POST['targetFolder'];

function randomkeys($length)
{
    $validCharacters = "1234567890abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
    $validCharNumber = strlen($validCharacters);

    $result = "";

    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }

    return $result;
}

if (!empty($_FILES)) {
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $PROJECT . $targetFolder;
    if (!file_exists($targetPath)) {
        mkdir($targetPath);
    }
    $targetFile = $_FILES['Filedata']['name'];

    //add bye me
    $targetFile = randomkeys(5) . "-" . $targetFile;

    // Validate the file type
    $blacklist = array("php", "exe");
    $fileTypes = array('mp4'); // File extensions
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    if (in_array($fileParts['extension'], $blacklist)) {
        die("Restricted File!");
    }
    if (in_array(strtolower($fileParts['extension']), $fileTypes)) {
        {
            move_uploaded_file($tempFile, $targetPath . $targetFile);
        }
        echo $targetFile;
    } else {
        echo 'Invalid file type.';
    }
}
?>
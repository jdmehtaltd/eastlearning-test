<?php
require('Validator.php');

$target_dir = "../uploads/";
$pure_filename = basename($_FILES["fileToUpload"]["name"]);
$file_size = $_FILES["fileToUpload"]["size"];
$target_file = $target_dir . $pure_filename;
$upload_ok = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $upload_ok = 0;
}

try{
    Validator::checkMaxSize($file_size);
}
catch(MaxFileSizeExceeded $ex)
{
    echo $ex->getMessage();
    $upload_ok = 0;
}

try {
    Validator::checkIfValidImageFormat($pure_filename);
}
catch (NotAllowedImageFormatException $ex) {
    echo $ex->getMessage();
    $upload_ok = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($upload_ok == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

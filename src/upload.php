<?php
require('Validator.php');

$target_dir = "../uploads/";
$base_filename = basename($_FILES["fileToUpload"]["name"]);
// this is the file stored temporarily on the server upon upload
$tmp_filename = $_FILES["fileToUpload"]["tmp_name"];
$size = $_FILES["fileToUpload"]["size"];
$mime_type_from_browser = $_FILES["fileToUpload"]["type"];
$target_filename = $target_dir . $base_filename;
$upload_ok = true;

// from the documentation here: https://www.php.net/manual/en/features.file-upload.post-method.php
if ($size == 0){
    echo 'No file was uploaded';
    $upload_ok = false;
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"]))
{
    try
    {
        Validator::checkIfRealImage($tmp_filename, $mime_type_from_browser);
    }
    catch (NotRealImageException $ex) {
        echo $ex->getMessage();
        $upload_ok = false;
    }
}

try{
    Validator::checkMaxSize($size);
}
catch(MaxFileSizeExceededException $ex)
{
    echo $ex->getMessage();
    $upload_ok = false;
}

try {
    Validator::checkIfValidImageFormat($base_filename);
}
catch (NotAllowedImageFormatException $ex) {
    echo $ex->getMessage();
    $upload_ok = false;
}

// Check if $uploadOk is set to 0 by an error
if ($upload_ok) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_filename)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

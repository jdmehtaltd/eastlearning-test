<?php
require('Validator.php');
require('Processor.php');

$target_dir = "../uploads/";
$base_filename = basename($_FILES["fileToUpload"]["name"]);
$file_extension = pathinfo($base_filename, PATHINFO_EXTENSION);
// this is the file stored temporarily on the server upon upload
$tmp_filename = $_FILES["fileToUpload"]["tmp_name"];
$size = $_FILES["fileToUpload"]["size"];
$mime_type_from_browser = $_FILES["fileToUpload"]["type"];
// a very simple way of generating secure URLs is to use a hash of the base filename. That would also ensure that
// re-uploads of the same file would result in an overwrite of the file, which you might have in mind.
// If you want to prevent overwrites completely, then a simple scheme could be to suffix the iso8601 to the base
// filename before hashing. At low volumes, that will approximate unique URLs because 2 uploads for the same filename
// are unlikely to collide (especially if we separate the uploads by username) at a microsecond granularity.
$target_filename = $base_filename . '-' . date('c');
echo "Target filename is $target_filename<br/>";
$target_hashed_filename = hash('ripemd160', $target_filename) . '.' . $file_extension;
$upload_ok = true;

// from the documentation here: https://www.php.net/manual/en/features.file-upload.post-method.php
if ($size == 0){
    echo 'No file was uploaded';
    $upload_ok = false;
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    try {
        Validator::checkIfRealImage($tmp_filename, $mime_type_from_browser);
    } catch (NotRealImageException $ex) {
        echo $ex->getMessage() . '<br/>';
        $upload_ok = false;
    }

    try {
        Validator::checkMaxSize($size);
    } catch (MaxFileSizeExceededException $ex) {
        echo $ex->getMessage() . '<br/>';
        $upload_ok = false;
    }

    try {
        Validator::checkIfValidImageFormat($base_filename);
    } catch (NotAllowedImageFormatException $ex) {
        echo $ex->getMessage() . '<br/>';
        $upload_ok = false;
    }

    try {
        Processor::resizeIfNeeded($tmp_filename);
    } catch (GetImageSizeException $ex) {
        echo $ex->getMessage() . '<br/>';
        $upload_ok = false;
    }

    // Check if $uploadOk is set to 0 by an error
    if (!$upload_ok) {
        echo "Sorry, your file was not uploaded.<br/>";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($tmp_filename, $target_dir . $target_hashed_filename)) {
            echo "The file $base_filename has been uploaded.<br/>";
            // sharing URL formed as per https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
            $sharing_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/uploads/$target_hashed_filename";
            echo "URL for sharing is: <a href=$sharing_url>$sharing_url</a><br/>";
        } else {
            echo "Sorry, there was an error uploading your file.<br/>";
        }
    }
}

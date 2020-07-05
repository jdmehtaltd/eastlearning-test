<?php declare(strict_types=1);

class NotAllowedImageFormatException extends Exception {}

class MaxFileSizeExceededException extends Exception {}

class NotRealImageException extends Exception {}

class Validator {
    public static array $validImageFormats = array(
        1 => 'jpg',
        2 => 'gif',
        3 => 'png',
        4 => 'jpeg',
    );

    public static int $maxSize = 200000; // 2MB

    public static function checkIfValidImageFormat(string $filename): void
    {
        $extension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
        if (!$extension)
        {
            throw new NotAllowedImageFormatException('Filename has no extension, so cannot determine image format');
        }
        elseif (!in_array($extension, Validator::$validImageFormats))
        {
            throw new NotAllowedImageFormatException("$extension is not a supported format");
        }
        else
        {
            return;
        }
    }

    public static function checkMaxSize(int $fileSizeFromBrowser): void
    {
        if ($fileSizeFromBrowser > Validator::$maxSize)
        {
            throw new MaxFileSizeExceededException("$fileSizeFromBrowser exceeds the maximum size allowed, " . Validator::$maxSize);
        }
        else
        {
            return;
        }
    }

    public static function checkIfRealImage(string $tmpFile, string $mimeTypeFromBrowser): void
    {
        $detectedMimeType = mime_content_type($tmpFile);
        if ($mimeTypeFromBrowser != $detectedMimeType){
            throw new NotRealImageException("Mime type from browser, $mimeTypeFromBrowser, not the same as detected mime type, $detectedMimeType");
        }
        $file_info = new finfo(FILEINFO_MIME_TYPE);
        $extracted_mime_type = $file_info->file($tmpFile);
        if ($extracted_mime_type != $mimeTypeFromBrowser)
        {
            throw new NotRealImageException("Mime type from browser, $mimeTypeFromBrowser, not the same as extracted mime type, $extracted_mime_type");
        }
        if (strpos($extracted_mime_type, 'image') === false) {
            throw new NotRealImageException("Mime type extracted for $tmpFile is not an image mime type");
        }
    }
}

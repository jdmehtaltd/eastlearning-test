<?php declare(strict_types=1);

class NotAllowedImageFormatException extends Exception {}

class MaxFileSizeExceededException extends Exception {}

class NotRealImageException extends Exception {}

class Validator {
    static array $validImageFormats = array(
        1 => 'jpg',
        2 => 'gif',
        3 => 'png',
        4 => 'jpeg',
    );

    static int $maxSize = 200000; // 2MB

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

    public static function checkMaxSize(int $fileSize): void
    {
        if ($fileSize > Validator::$maxSize)
        {
            throw new MaxFileSizeExceededException("$fileSize exceeds the maximum size allowed, " . Validator::$maxSize);
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
        $check = getimagesize($tmpFile);
        if($check !== false)
        {
            return;
        }
        else
        {
            throw new NotRealImageException("$tmpFile is not a real image file");
        }
    }
}

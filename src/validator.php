<?php declare(strict_types=1);

class NotAllowedImageFormatException extends Exception {}

class Validator {
    static array $validImageFormats = array(
        1 => 'jpg',
        2 => 'gif',
        3 => 'png',
        4 => 'jpeg',
    );

    public static function checkIfValidImageFormat(string $filename): void
    {
        $split_filename = explode('.', $filename);
        $extension = end($split_filename);
        if (!$extension){
            throw new NotAllowedImageFormatException('Filename has no extension, so cannot determine image format');
        }
        elseif (!in_array($extension, Validator::$validImageFormats)){
            throw new NotAllowedImageFormatException('$extension is not a supported format');
        }
        else{
            return;
        }
    }
}

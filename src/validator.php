<?php declare(strict_types=1);

class NotImageException extends Exception {}

class Validator {
    static array $validStringExtensions = array(
        1 => 'jpg',
        2 => 'gif'
    );

    public static function checkIfImage(string $filename): void
    {
        $split_filename = explode('.', $filename);
        $extension = end($split_filename);
        if (!$extension){
            throw new NotImageException('Filename has no extension');
        }
        elseif (!in_array($extension, Validator::$validStringExtensions)){
            throw new NotImageException('$extension is not a valid image extension');
        }
        else{
            return;
        }
    }
}

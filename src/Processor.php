<?php

class GetImageSizeException extends Exception {}

class Processor
{
    public static int $maxWidth = 800;
    public static int $maxHeight = 800;

    # TODO: violation of PSR-2 side effect rule, look at it later
    public static function resizeIfNeeded(string $tmpFile, $rename=false): bool
    {
        $check = getimagesize($tmpFile);
        $resized = false;
        if ($check !== false)
        {
            // do resizing business logic here
            list($width, $height, $type, $attr) = $check;
            if ($width > Processor::$maxWidth || $height > Processor::$maxHeight) {
                if ($type == IMG_JPG) {
                    $image = imagecreatefromjpeg($tmpFile);
                } else {
                    throw new GetImageSizeException("Unsupported image type of $tmpFile");
                }
                // preserving aspect ratio can be tricky
                if ($width >= $height) {
                    $scaled_image = imagescale($image, Processor::$maxWidth);
                }
                else {
                    $aspectRatio = $width/$height;
                    $newWidth = (int) floor(Processor::$maxHeight * $aspectRatio);
                    $scaled_image = imagescale($image, $newWidth);
                }
                if ($type == IMG_JPG) {
                    $path_parts = pathinfo($tmpFile);
                    $newName = $rename ? $path_parts['dirname'] . '/' . $path_parts['filename'] . '.resized.' . $path_parts['extension'] : $tmpFile;
                    $resized = imagejpeg($scaled_image, $newName);
                }
            }
            return $resized;
        }
        else
        {
            throw new GetImageSizeException("Could not get the size of the $tmpFile");
        }
    }
}
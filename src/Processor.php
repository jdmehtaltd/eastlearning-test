<?php

class GetImageSizeException extends Exception {}

class Processor
{
    public static int $maxWidth = 800;
    public static int $maxHeight = 800;

    # TODO: violation of PSR-2 side effect rule, look at it later
    public static function resizeIfNeeded(string $tmpFile): string
    {
        $check = getimagesize($tmpFile);
        $resized = false;
        if ($check !== false)
        {
            // do resizing business logic here
        }
        else
        {
            throw new GetImageSizeException("Could not get the size of the $tmpFile");
        }
        return $resized ? $tmpFile . '-resized' : $tmpFile;
    }
}
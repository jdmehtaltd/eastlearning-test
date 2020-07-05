<?php


use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testCheckIfValidImageFormat(): void
    {
        try
        {
            Validator::checkIfValidImageFormat('abc.jpg');
            Validator::checkIfValidImageFormat('abc.jpeg');
        }
        catch(NotAllowedImageFormatException $ex)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        try
        {
            Validator::checkIfValidImageFormat('abc.pdf');
        }
        catch (Exception $ex)
        {
           $this->assertInstanceOf(NotAllowedImageFormatException::class, $ex);
        }
    }

    public function testCheckMaxSize(): void
    {
        try
        {
            Validator::checkMaxSize(1); // 1 byte
        }
        catch(MaxFileSizeExceededException $ex)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        try
        {
            Validator::checkMaxSize(1000000000); // 1GB
        }
        catch(Exception $ex) {
            $this->assertInstanceOf(MaxFileSizeExceededException::class, $ex);
        }
    }

    public function testCheckIfRealImage(): void
    {
        try
        {
            Validator::checkIfRealImage('/app/tests/JPEG_compression_Example.jpg', 'image/jpeg');
        }
        catch(NotRealImageException $ex)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
            return;
        }
        try {
            Validator::checkIfRealImage('/app/tests/txtfile.txt', 'text/plain');
        }
        catch(Exception $ex)
        {
            $this->assertInstanceOf(NotRealImageException::class, $ex);
        }
    }
}

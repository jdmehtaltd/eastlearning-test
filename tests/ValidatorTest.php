<?php


use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testCheckIfValidImageFormatNoException(): void
    {
        try {
            Validator::checkIfValidImageFormat('abc.jpg');
            Validator::checkIfValidImageFormat('abc.jpeg');
        } catch (NotAllowedImageFormatException $ex) {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        # TODO: test success, is this the right way?
        $this->assertTrue(true);
    }

    public function testCheckIfValidImageFormatWithException(): void
    {
        try
        {
            Validator::checkIfValidImageFormat('abc.pdf');
        }
        catch (Exception $ex)
        {
           $this->assertInstanceOf(NotAllowedImageFormatException::class, $ex);
        }
    }

    public function testCheckMaxSizeNoException(): void
    {
        try {
            Validator::checkMaxSize(1); // 1 byte
        } catch (MaxFileSizeExceededException $ex) {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        # TODO: test success, is this the right way?
        $this->assertTrue(true);
    }

    public function testCheckMaxSizeWithException(): void
    {
        try
        {
            Validator::checkMaxSize(1000000000); // 1GB
        }
        catch(Exception $ex) {
            $this->assertInstanceOf(MaxFileSizeExceededException::class, $ex);
        }
    }

    public function testCheckIfRealImageNoException(): void
    {
        try {
            Validator::checkIfRealImage('/app/tests/JPEG_compression_Example.jpg', 'image/jpeg');
        } catch (NotRealImageException $ex) {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
            return;
        }
        # TODO: test success, is this the right way?
        $this->assertTrue(true);
    }

    public function testCheckIfRealImageWithException(): void
    {
        try {
            Validator::checkIfRealImage('/app/tests/txtfile.txt', 'text/plain');
        }
        catch(Exception $ex)
        {
            $this->assertInstanceOf(NotRealImageException::class, $ex);
        }
    }
}

<?php


use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testCheckIfValidImageFormat(): void
    {
        try
        {
            Validator::checkIfValidImageFormat('abc.jpg');
            Validator::checkIfValidImageFormat('abc.gif');
            Validator::checkIfValidImageFormat('abc.jpeg');
            Validator::checkIfValidImageFormat('abc.png');
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
        catch (Exception $possibleNotAllowedFormatEx)
        {
           $this->assertInstanceOf(NotAllowedImageFormatException::class, $possibleNotAllowedFormatEx);
        }
    }

    public function testCheckMaxSize(): void {
        try
        {
            Validator::checkMaxSize(1); // 1 byte
        }
        catch(MaxFileSizeExceeded $ex)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        try
        {
            Validator::checkMaxSize(1000000000); // 1GB
        }
        catch(Exception $possibleMaxFileSizeExceeded) {
            $this->assertInstanceOf(MaxFileSizeExceeded::class, $possibleMaxFileSizeExceeded);
        }
    }
}

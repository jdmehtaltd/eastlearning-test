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
}

<?php


use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testCheckIfImage(): void
    {
        try
        {
            Validator::checkIfImage('abc.jpg');
            Validator::checkIfImage('abc.gif');
            Validator::checkIfImage('abc.jpeg');
            Validator::checkIfImage('abc.png');
        }
        catch(NotAllowedImageFormatException $ex)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        try
        {
            Validator::checkIfImage('abc.pdf');
        }
        catch (Exception $possibleNotAllowedFormatEx)
        {
           $this->assertInstanceOf(NotAllowedImageFormatException::class, $possibleNotAllowedFormatEx);
        }
    }
}

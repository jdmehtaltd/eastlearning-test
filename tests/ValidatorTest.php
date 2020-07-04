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
        }
        catch(NotAllowedImageFormatException $nie)
        {
            # TODO: simulating test failure, look for something like fail() method
            $this->assertTrue(null);
        }
        try
        {
            Validator::checkIfImage('abc.pdf');
        }
        catch (Exception $possible_nie)
        {
           $this->assertInstanceOf(NotAllowedImageFormatException::class, $possible_nie);
        }
    }
}

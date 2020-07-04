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
        catch(NotImageException $nie)
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
           $this->assertInstanceOf(NotImageException::class, $possible_nie);
        }
    }
}

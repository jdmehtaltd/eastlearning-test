<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;

class TestClassTest extends TestCase
{
    public function testGetHello(): void
    {
        $test_obj = new TestClass();
        $this->assertEquals('hello', $test_obj->getHello());
    }
}

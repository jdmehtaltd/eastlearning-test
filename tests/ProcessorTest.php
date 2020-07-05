<?php

use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    public function testResizeIfNeeded()
    {
        try {
            Processor::resizeIfNeeded('/app/tests/txtfile.txt');
        }
        catch (Exception $ex)
        {
            $this->assertInstanceOf(GetImageSizeException::class, $ex);
        }

        // file not to be resized
        $resized = Processor::resizeIfNeeded('/app/tests/small-image.jpg', true);
        $this->assertFalse($resized);

        // wide image to be resized
        $resized = Processor::resizeIfNeeded('/app/tests/wide-image.jpg', true);
        $this->assertTrue($resized);

        // tall image to be resized
        $resized = Processor::resizeIfNeeded('/app/tests/tall-image.jpg', true);
        $this->assertTrue($resized);
    }
}

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
        $oldFileName = '/app/tests/JPEG_compression_Example.jpg';
        $newFileName = Processor::resizeIfNeeded($oldFileName);
        $this->assertEquals($oldFileName, $newFileName);

        // wide image to be resized
        $oldFileName = '/app/tests/wide-image.png';
        $newFileName = Processor::resizeIfNeeded($oldFileName);
        $this->assertEquals($oldFileName . '-resized', $newFileName);

        // tall image to be resized
        $oldFileName = '/app/tests/tall-image.png';
        $newFileName = Processor::resizeIfNeeded($oldFileName);
        $this->assertEquals($oldFileName . '-resized', $newFileName);
    }
}

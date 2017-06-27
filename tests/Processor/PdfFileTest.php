<?php

namespace Poppler\Tests\Processor;

use Poppler\Exception\FileNotFoundException;
use Poppler\Processor\PdfFile;
use Poppler\Tests\TestCase;

class PdfFileTest extends TestCase
{
    private $tempDir;

    public function setUp()
    {
        $this->tempDir = sys_get_temp_dir();
    }

    public function testConstructor()
    {
        $pdfInfo = $this->createPdfinfo();
        $pdfToText = $this->createPdftotext();
        $pdfToHtml = $this->createPdftohtml();

        $pdfInfo->command([self::TESTFILE])
            ->willReturn('testInfo: testInfo');

        $pdfToText->command(['-nopgbrk', self::TESTFILE, '-'])
            ->willReturn('testText');

        $pdfToHtml->command([self::TESTFILE, $this->tempDir])
            ->willReturn('testHtml');

        $pdfFile = new PdfFile(
            $pdfInfo->reveal(),
            $pdfToText->reveal(),
            $pdfToHtml->reveal()
        );

        $this->assertInstanceOf(PdfFile::class, $pdfFile);

        return $pdfFile;
    }

    /**
     * @depends testConstructor
     */
    public function testGetInfoFromInvalid(PdfFile $pdfFile)
    {
        $this->expectException(FileNotFoundException::class);

        $pdfFile->getInfo('/path/to/nowhere');
    }

    /**
     * @depends testConstructor
     */
    public function testGetInfo(PdfFile $pdfFile)
    {
        $info = $pdfFile->getInfo(self::TESTFILE);

        $this->assertNotEmpty($info);
    }

    /**
     * @depends testConstructor
     */
    public function testToTextFromInvalid(PdfFile $pdfFile)
    {
        $this->expectException(FileNotFoundException::class);

        $pdfFile->toText('/path/to/nowhere');
    }

    /**
     * @depends testConstructor
     */
    public function testToText(PdfFile $pdfFile)
    {
        $text = $pdfFile->toText(self::TESTFILE);

        $this->assertNotEmpty($text);
    }

    /**
     * @depends testConstructor
     */
    public function testToHtmlFromInvalid(PdfFile $pdfFile)
    {
        $this->expectException(FileNotFoundException::class);

        $pdfFile->toHtml('/path/to/nowhere', $this->tempDir);
    }

    /**
     * @depends testConstructor
     */
    public function testToHtml(PdfFile $pdfFile)
    {
        $html = $pdfFile->toHtml(self::TESTFILE, $this->tempDir);

        $this->assertNotEmpty($html);
    }
}

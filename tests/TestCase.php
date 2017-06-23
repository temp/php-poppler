<?php

namespace Poppler\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Poppler\Driver\Pdfinfo;
use Poppler\Driver\Pdftohtml;
use Poppler\Driver\Pdftotext;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;

abstract class TestCase extends BaseTestCase
{
    const TESTFILE = __DIR__.'/fixture/file.pdf';

    /**
     * @return LoggerInterface|ObjectProphecy
     */
    protected function createLogger()
    {
        return $this->prophesize(LoggerInterface::class);
    }

    /**
     * @return Pdfinfo|ObjectProphecy
     */
    protected function createPdfinfo()
    {
        return $this->prophesize(Pdfinfo::class);
    }

    /**
     * @return Pdftotext|ObjectProphecy
     */
    protected function createPdftotext()
    {
        return $this->prophesize(Pdftotext::class);
    }

    /**
     * @return Pdftohtml|ObjectProphecy
     */
    protected function createPdftohtml()
    {
        return $this->prophesize(Pdftohtml::class);
    }
}
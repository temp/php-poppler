<?php

namespace Poppler\Tests\Driver;

use Alchemy\BinaryDriver\Configuration;
use Poppler\Driver\Pdftohtml;
use Poppler\Exception\ExecutableNotFoundException;
use Poppler\Tests\TestCase;
use Symfony\Component\Process\ExecutableFinder;

class PdftohtmlTest extends TestCase
{
    public function setUp()
    {
        $executableFinder = new ExecutableFinder();
        $found = false;
        foreach (array('pdftohtml') as $name) {
            if (null !== $executableFinder->find($name)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->markTestSkipped('pdftohtml not found');
        }
    }

    public function testCreate()
    {
        $logger = $this->createLogger();

        $pdftohtml = Pdftohtml::create($logger->reveal(), array());

        $this->assertInstanceOf(Pdftohtml::class, $pdftohtml);
        $this->assertEquals($logger->reveal(), $pdftohtml->getProcessRunner()->getLogger());
    }

    public function testCreateWithConfig()
    {
        $conf = new Configuration();

        $pdftohtml = Pdftohtml::create($this->createLogger()->reveal(), $conf);

        $this->assertEquals($conf, $pdftohtml->getConfiguration());
    }

    public function testCreateFailureThrowsAnException()
    {
        $this->expectException(ExecutableNotFoundException::class);

        Pdftohtml::create($this->createLogger()->reveal(), array('pdftohtml.binaries' => '/path/to/nowhere'));
    }
}

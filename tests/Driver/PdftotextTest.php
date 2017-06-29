<?php

namespace Poppler\Tests\Driver;

use Alchemy\BinaryDriver\Configuration;
use Poppler\Driver\Pdftotext;
use Poppler\Exception\ExecutableNotFoundException;
use Poppler\Tests\TestCase;
use Symfony\Component\Process\ExecutableFinder;

class PdftotextTest extends TestCase
{
    public function setUp()
    {
        $executableFinder = new ExecutableFinder();
        $found = false;
        foreach (['pdftotext'] as $name) {
            if (null !== $executableFinder->find($name)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->markTestSkipped('pdftotext not found');
        }
    }

    public function testCreate()
    {
        $logger = $this->createLogger();

        $pdftotext = Pdftotext::create($logger->reveal(), []);

        $this->assertInstanceOf(Pdftotext::class, $pdftotext);
        $this->assertEquals($logger->reveal(), $pdftotext->getProcessRunner()->getLogger());
    }

    public function testCreateWithConfig()
    {
        $conf = new Configuration();

        $pdftotext = Pdftotext::create($this->createLogger()->reveal(), $conf);

        $this->assertEquals($conf, $pdftotext->getConfiguration());
    }

    public function testCreateFailureThrowsAnException()
    {
        $this->expectException(ExecutableNotFoundException::class);

        Pdftotext::create($this->createLogger()->reveal(), ['pdftotext.binaries' => '/path/to/nowhere']);
    }
}

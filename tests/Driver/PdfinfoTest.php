<?php

namespace Poppler\Tests\Driver;

use Alchemy\BinaryDriver\Configuration;
use Poppler\Driver\Pdfinfo;
use Poppler\Exception\ExecutableNotFoundException;
use Poppler\Tests\TestCase;
use Symfony\Component\Process\ExecutableFinder;

class PdfinfoTest extends TestCase
{
    public function setUp()
    {
        $executableFinder = new ExecutableFinder();
        $found = false;
        foreach (array('pdfinfo') as $name) {
            if (null !== $executableFinder->find($name)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->markTestSkipped('pdfinfo not found');
        }
    }

    public function testCreate()
    {
        $logger = $this->createLogger();

        $pdfinfo = Pdfinfo::create($logger->reveal(), array());

        $this->assertInstanceOf(Pdfinfo::class, $pdfinfo);
        $this->assertEquals($logger->reveal(), $pdfinfo->getProcessRunner()->getLogger());
    }

    public function testCreateWithConfig()
    {
        $conf = new Configuration();

        $pdfinfo = Pdfinfo::create($this->createLogger()->reveal(), $conf);

        $this->assertEquals($conf, $pdfinfo->getConfiguration());
    }

    public function testCreateFailureThrowsAnException()
    {
        $this->expectException(ExecutableNotFoundException::class);

        Pdfinfo::create($this->createLogger()->reveal(), array('pdfinfo.binaries' => '/path/to/nowhere'));
    }
}
<?php

declare(strict_types = 1);

/*
 * This file is part of php-poppler.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Poppler\Driver;

use Alchemy\BinaryDriver\AbstractBinary;
use Alchemy\BinaryDriver\Configuration;
use Alchemy\BinaryDriver\ConfigurationInterface;
use Alchemy\BinaryDriver\Exception\ExecutableNotFoundException as BinaryDriverExecutableNotFound;
use Poppler\Exception\ExecutableNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * pdftohtml binary driver.
 */
class Pdftohtml extends AbstractBinary
{
    /**
     * @var bool
     */
    private $isAvailable;

    public function getName(): string
    {
        return 'pdftohtml';
    }

    public function options(): PdftohtmlOptions
    {
        return new PdftohtmlOptions();
    }

    /**
     * Creates an Pdftohtml driver.
     *
     * @param LoggerInterface       $logger
     * @param mixed]||Configuration $configuration
     *
     * @return Pdftohtml
     */
    public static function create(LoggerInterface $logger = null, $configuration = []): Pdftohtml
    {
        if (!$configuration instanceof ConfigurationInterface) {
            $configuration = new Configuration($configuration);
        }

        $binaries = $configuration->get('pdftohtml.binaries', 'pdftohtml');

        if (!$configuration->has('timeout')) {
            $configuration->set('timeout', 60);
        }

        try {
            return static::load($binaries, $logger, $configuration);
        } catch (BinaryDriverExecutableNotFound $e) {
            throw new ExecutableNotFoundException('Unable to load pdftohtml', $e->getCode(), $e);
        }
    }

    /**
     * Check availability.
     */
    public function isAvailable(): bool
    {
        if (null === $this->isAvailable) {
            $output = $this->command('-v');

            if ($output) {
                $version = 'unknown';
                if (preg_match('/^pdftohtml version (.+)/', $output, $match)) {
                    $version = $match[1];
                }

                $this->isAvailable = true;

                $this->getProcessRunner()->getLogger()->info("pdftohtml is available, version $version");
            } else {
                $this->isAvailable = false;

                $this->getProcessRunner()->getLogger()->warning('pdftohtml is not available');
            }
        }

        return $this->isAvailable;
    }
}

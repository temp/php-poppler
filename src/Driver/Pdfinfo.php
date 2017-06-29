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
 * pdfinfo binary driver.
 */
class Pdfinfo extends AbstractBinary
{
    /**
     * @var bool
     */
    private $isAvailable;

    public function getName(): string
    {
        return 'pdfinfo';
    }

    /**
     * Creates an Pdfinfo driver.
     *
     * @param LoggerInterface       $logger
     * @param mixed[]|Configuration $configuration
     *
     * @return Pdfinfo
     */
    public static function create(LoggerInterface $logger = null, $configuration = []): Pdfinfo
    {
        if (!$configuration instanceof ConfigurationInterface) {
            $configuration = new Configuration($configuration);
        }

        $binaries = $configuration->get('pdfinfo.binaries', 'pdfinfo');

        if (!$configuration->has('timeout')) {
            $configuration->set('timeout', 60);
        }

        try {
            return static::load($binaries, $logger, $configuration);
        } catch (BinaryDriverExecutableNotFound $e) {
            throw new ExecutableNotFoundException('Unable to load pdfinfo', $e->getCode(), $e);
        }
    }

    public function isAvailable(): bool
    {
        if (null === $this->isAvailable) {
            $output = $this->command('-v');

            if ($output) {
                $version = 'unknown';
                if (preg_match('/^pdfinfo version (.+)/', $output, $match)) {
                    $version = $match[1];
                }

                $this->isAvailable = true;

                $this->getProcessRunner()->getLogger()->info("pdfinfo is available, version $version");
            } else {
                $this->isAvailable = false;

                $this->getProcessRunner()->getLogger()->warning('pdfinfo is not available');
            }
        }

        return $this->isAvailable;
    }
}

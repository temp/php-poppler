<?php

declare (strict_types = 1);

/*
 * This file is part of php-poppler.
 *
 * (c) Stephan Wentz <stephan@wentz.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Poppler\Driver;

/**
 * pdftohtml options.
 */
class PdftohtmlOptions
{
    private $options = array();

    public function setOption(string $key, ?string $value = null): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set -f
     * first page to convert
     */
    public function first(int $page): self
    {
        return $this->setOption('-f', (string) $page);
    }

    /**
     * Set -l
     * last page to convert
     */
    public function last(int $page): self
    {
        return $this->setOption('-l', (string) $page);
    }

    /**
     * Set -opw
     * owner password (for encrypted files)
     */
    public function ownerPassword(string $ownerPassword): self
    {
        return $this->setOption('-opw', $ownerPassword);
    }

    /**
     * Set -upw
     * user password (for encrypted files)
     */
    public function userPassword(string $userPassword): self
    {
        return $this->setOption('upw', $userPassword);
    }

    /**
     * Set -q
     * don't print any messages or errors
     */
    public function quiet(): self
    {
        return $this->setOption('quiet');
    }
}

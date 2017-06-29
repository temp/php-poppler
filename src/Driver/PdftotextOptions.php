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

/**
 * pdftotext options.
 */
class PdftotextOptions
{
    /**
     * @var array
     */
    private $options = [];

    public function setOption(string $key, ?string $value = null): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set -f
     * first page to convert.
     */
    public function first(int $page): self
    {
        return $this->setOption('-f', (string) $page);
    }

    /**
     * Set -l
     * last page to convert.
     */
    public function last(int $page): self
    {
        return $this->setOption('-l', (string) $page);
    }

    /**
     * Set -r <resolution>
     * resolution, in DPI (default is 72).
     */
    public function resolution(int $resolution): self
    {
        return $this->setOption('-r', (string) $resolution);
    }

    /**
     * Set -x
     * x-coordinate of the crop area top left corner.
     */
    public function xCoordinate(int $xCoordinate): self
    {
        return $this->setOption('-x', (string) $xCoordinate);
    }

    /**
     * Set -y
     * y-coordinate of the crop area top left corner.
     */
    public function yCoordinate(int $yCoordinate): self
    {
        return $this->setOption('-y', (string) $yCoordinate);
    }

    /**
     * Set -W
     * width of crop area in pixels (default is 0).
     */
    public function width(int $width): self
    {
        return $this->setOption('-W', (string) $width);
    }

    /**
     * Set -H
     * hidth of crop area in pixels (default is 0).
     */
    public function height(int $height): self
    {
        return $this->setOption('-H', (string) $height);
    }

    /**
     * Set -layout
     * maintain original physical layout.
     */
    public function layout(): self
    {
        return $this->setOption('layout');
    }

    /**
     * Set -fixed
     * assume fixed-pitch (or tabular) text.
     */
    public function fixed(string $fp): self
    {
        return $this->setOption('-fixed', $fp);
    }

    /**
     * Set -raw
     * keep strings in content stream order.
     */
    public function raw(): self
    {
        return $this->setOption('-raw');
    }

    /**
     * Set -htmlmeta
     * generate a simple HTML file, including the meta information.
     */
    public function htmlMeta(): self
    {
        return $this->setOption('-htmlmeta');
    }

    /**
     * Set --enc <value>
     * output text encoding name.
     */
    public function encoding(string $value): self
    {
        return $this->setOption('-enc', $value);
    }

    /**
     * Set -eol
     * output end-of-line convention (unix, dos, or mac).
     */
    public function eol(string $eol): self
    {
        if (!in_array($eol, ['unix', 'dos', 'mac'])) {
            throw new \InvalidArgumentException('eol has to be one of unix, dos or mac.');
        }

        return $this->setOption('-eol', $eol);
    }

    /**
     * Set -nopgbrk
     * don't insert page breaks between pages.
     */
    public function noPageBreak(): self
    {
        return $this->setOption('-nopgbrk');
    }

    /**
     * Set -bbox
     * output bounding box for each word and page size to html. Sets -htmlmeta.
     */
    public function boundingBox(): self
    {
        return $this->setOption('-bbox');
    }

    /**
     * Set -opw
     * owner password (for encrypted files).
     */
    public function ownerPassword(string $ownerPassword): self
    {
        return $this->setOption('-opw', $ownerPassword);
    }

    /**
     * Set -upw
     * user password (for encrypted files).
     */
    public function userPassword(string $userPassword): self
    {
        return $this->setOption('upw', $userPassword);
    }

    /**
     * Set -q
     * don't print any messages or errors.
     */
    public function quiet(): self
    {
        return $this->setOption('quiet');
    }
}

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

namespace Poppler\Processor;

use Poppler\Driver\Pdfinfo;
use Poppler\Driver\Pdftohtml;
use Poppler\Driver\Pdftotext;
use Poppler\Exception\FileNotFoundException;

/**
 * PDF file.
 */
class PdfFile
{
    private $pdfinfo;

    private $pdftotext;

    private $pdftohtml;

    public function __construct(Pdfinfo $pdfinfo, Pdftotext $pdftotext, Pdftohtml $pdftohtml)
    {
        $this->pdfinfo = $pdfinfo;
        $this->pdftotext = $pdftotext;
        $this->pdftohtml = $pdftohtml;
    }

    public function toText(string $inputFile, string $toEncoding = 'UTF-8'): string
    {
        if (!file_exists($inputFile)) {
            throw new FileNotFoundException("File $inputFile not found.");
        }

        $output = $this->pdftotext->command(['-nopgbrk', $inputFile, '-']);
        $fromEncoding = mb_detect_encoding($output);
        if ($fromEncoding) {
            return mb_convert_encoding($output, $toEncoding, $fromEncoding);
        }

        return mb_convert_encoding($output, $toEncoding);
    }

    public function toHtml(string $inputFile, string $outputFile): string
    {
        if (!file_exists($inputFile)) {
            throw new FileNotFoundException("File $inputFile not found.");
        }

        $output = $this->pdftohtml->command([$inputFile, $outputFile]);

        return $output;
    }

    public function getInfo(string $inputFile): array
    {
        if (!file_exists($inputFile)) {
            throw new FileNotFoundException("File $inputFile not found.");
        }

        $args = [$inputFile];

        $output = $this->pdfinfo->command($args);

        if (!$output) {
            return [];
        }

        $info = [];
        foreach (explode(PHP_EOL, $output) as $line) {
            if (strpos($line, ': ') === false) {
                continue;
            }
            $parts = explode(': ', $line);
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            if (preg_match('/^\w{3} \w{3} \d\d \d\d:\d\d:\d\d \d\d\d\d/', $value, $match)) {
                $date = new \DateTimeImmutable($value);
                $value = $date->format('c');
            }
            $info[$key] = $value;
        }

        return $info;
    }
}

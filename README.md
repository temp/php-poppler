# PHP Poppler

[![Build Status](https://secure.travis-ci.org/php-poppler/php-poppler.png?branch=master)](http://travis-ci.org/php-poppler/php-poppler)

PHP-Poppler is a tiny lib which helps you to use Poppler tools http://poppler.freedesktop.org/

Poppler is published under the GPLv2 license and is described as "Poppler is a PDF rendering library based on the xpdf-3.0 code base."

## Installation

It is recommended to install PHP-Poppler through
[Composer](http://getcomposer.org) :

```json
{
    "require": {
        "php-poppler/php-poppler": "^2.0"
    }
}
```

## Main API usage:

```php
$file = new Poppler\Processor\PdfFile(...);

// Get pdf info
var_dump($file->getInfo('test.pdf'));

// Get text content of pdf
echo $file->toText('test.pdf');

// Transform to html
$file->toHtml('test.pdf', '/path/for/html');
```

## License

PHP-Poppler is released under MIT License http://opensource.org/licenses/MIT

See LICENSE file for more information

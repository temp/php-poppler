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

namespace Poppler\Exception;

/**
 * Poppler invalid argument exception.
 */
class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
}

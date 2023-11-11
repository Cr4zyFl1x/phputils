<?php
/**
 * PHPUtils - IOException.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file IOException.php
 * @date 10.11.2023 23:36
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtils\IO\Exception;

use Exception;
use Throwable;

/**
 * Signals that an I/O exception of some sort has occurred. This class is the general class of exceptions produced by failed or interrupted I/O operations.
 * @author Florian J. Kleine-Vorholt
 */
class IOException extends Exception
{
    /**
     * @inheritDoc
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
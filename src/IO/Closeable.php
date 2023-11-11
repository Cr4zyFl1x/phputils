<?php
/**
 * PHPUtils - Closeable.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file Closeable.php
 * @date 10.11.2023 23:38
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtils\IO;

use Cr4zyFl1x\PHPUtils\IO\Exception\IOException;

/**
 * A Closeable is a source or destination of data that can be closed. The close method is invoked to release resources that the object is holding (such as open files).
 * @author Florian J. Kleine-Vorholt
 */
interface Closeable
{
    /**
     * Closes this resource
     * @throws IOException if this resource cannot be closed
     */
    public function close(): void;
}
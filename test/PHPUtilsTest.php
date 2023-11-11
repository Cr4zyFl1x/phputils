<?php
/**
 * PHPUtils - PHPUtilsTest.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file PHPUtilsTest.php
 * @date 11.11.2023 22:34
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtilsTest;

use Cr4zyFl1x\PHPUtils\IO\Exception\IOException;
use Cr4zyFl1x\PHPUtils\Util\RecursiveFileSystemUtils;

class PHPUtilsTest
{

    const TEST_DIRECTORY = __DIR__ . "/../php.test";


    static function setUp(): void
    {
        mkdir(self::TEST_DIRECTORY);
    }


    /**
     * @throws IOException
     */
    static function tearDown(): void
    {
        if (!RecursiveFileSystemUtils::deleteDirectory(self::TEST_DIRECTORY)) {
            throw new IOException("PHPTest Error!");
        }
    }
}
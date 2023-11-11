<?php
/**
 * PHPUtils - RecursiveFileSystemUtilsTest.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file RecursiveFileSystemUtilsTest.php
 * @date 11.11.2023 22:25
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtilsTest\Util;

use Cr4zyFl1x\PHPUtils\IO\Exception\IOException;
use Cr4zyFl1x\PHPUtilsTest\PHPUtilsTest;
use PHPUnit\Framework\TestCase;

class RecursiveFileSystemUtilsTest extends TestCase
{

    protected function setUp(): void
    {
        PHPUtilsTest::setUp();
    }

    /**
     * @throws IOException
     */
    protected function tearDown(): void
    {
        PHPUtilsTest::tearDown();
    }

    public function testDeleteDirectory()
    {

    }

    public function testChmod()
    {

    }
}

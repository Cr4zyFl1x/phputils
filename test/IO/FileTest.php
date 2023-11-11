<?php
/**
 * PHPUtils - FileTest.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file FileTest.php
 * @date 11.11.2023 22:23
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtilsTest\IO;

use Cr4zyFl1x\PHPUtils\IO\Exception\FileNotFoundException;
use Cr4zyFl1x\PHPUtils\IO\Exception\IOException;
use Cr4zyFl1x\PHPUtils\IO\File;
use Cr4zyFl1x\PHPUtilsTest\PHPUtilsTest;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertFalse;

class FileTest extends TestCase
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


    public function testMkdirs()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d");
        self::assertTrue($file->mkdirs());
        self::assertFalse($file->mkdirs());
        self::assertTrue(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d"));
    }


    public function testGetAbsolutePath()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d/a");
        self::assertTrue($file->mkdirs());
        self::assertNotNull($file->getAbsolutePath());
        self::assertStringEndsWith(realpath(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d/a"), $file->getAbsolutePath());
    }


    public function testMkdir()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/x/");
        self::assertTrue($file->mkdir());
        self::assertTrue(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/x/"));

        $file2 = new File(PHPUtilsTest::TEST_DIRECTORY . "/x/a/y");
        assertFalse($file2->mkdir());
    }


    public function testDelete()
    {
        $directory = new File(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d/x");
        self::assertTrue($directory->mkdirs());
        self::assertTrue(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d/x"));
        self::assertTrue($directory->delete());
        self::assertFalse(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/a/b/c/d/x"));

        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/myfile.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue(is_file(PHPUtilsTest::TEST_DIRECTORY . "/myfile.txt"));
        self::assertTrue($file->delete());
        self::assertFalse(is_file(PHPUtilsTest::TEST_DIRECTORY . "/myfile.txt"));
    }


    public function testExists()
    {
        $directory = new File(PHPUtilsTest::TEST_DIRECTORY . "/c/a/g/h");
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/testfile.txt");
        self::assertTrue($directory->mkdirs());
        self::assertTrue($file->createNewFile());
        self::assertTrue($directory->exists());
        self::assertTrue($file->exists());
    }


    public function testIsDirectory()
    {
        $directory = new File(PHPUtilsTest::TEST_DIRECTORY . "/j/k/l");
        self::assertTrue($directory->mkdirs());
        self::assertTrue(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/j/k/l"));
        self::assertTrue($directory->isDirectory());
        self::assertFalse($directory->isFile());
    }


    /**
     * @throws FileNotFoundException
     * @throws IOException
     */
    public function testClose()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/resourceClose.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue($file->isFile());
        self::assertNotNull($file->getResource("w+"));
        $file->close();
    }


    /**
     * @throws FileNotFoundException
     * @throws IOException
     */
    public function testGetResource()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/resource.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue($file->isFile());
        self::assertNotNull($file->getResource("r"));
        self::expectException(IOException::class);
        $file->getResource("w+");
        $file->close();
    }


    public function testIsFile()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/isFile.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue($file->isFile());
        self::assertTrue(is_file(PHPUtilsTest::TEST_DIRECTORY . "/isFile.txt"));
        self::assertFalse(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/isFile.txt"));
    }

    public function testCreateNewFile()
    {
        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/createFile.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue($file->isFile());
        self::assertFalse($file->createNewFile());
        self::assertTrue(is_file(PHPUtilsTest::TEST_DIRECTORY . "/createFile.txt"));
        self::assertFalse(is_dir(PHPUtilsTest::TEST_DIRECTORY . "/createFile.txt"));
    }

    public function testLength()
    {
        $this->markTestIncomplete("Complete later ...");

        $file = new File(PHPUtilsTest::TEST_DIRECTORY . "/lengthTest.txt");
        self::assertTrue($file->createNewFile());
        self::assertTrue($file->isFile());

        $res = $file->getResource("w");
        self::assertNotFalse(fputs($res, "HelloHelloHelloHelloHelloHelloHelloHello"));
        $file->close();

        print_r($file->length());

        self::assertEquals(5, $file->length());
    }
}

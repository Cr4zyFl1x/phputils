<?php
/**
 * PHPUtils - FileSystemUtils.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * @file FileSystemUtils.php
 * @date 10.11.2023 23:23
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtils\Util;

use DirectoryIterator;

/**
 * Static utils for working with directories and files
 * @author Florian J. Kleine-Vorholt
 */
class RecursiveFileSystemUtils
{

    /**
     * Deletes a directory  and the files in it recursively.
     * @param string $dirPath Path to the directory
     * @param bool $verbose Should detailed output printed to STDOUT?
     * @return bool true, if the directory was deleted successfully
     */
    public static function deleteDirectory(string $dirPath, bool $verbose = false): bool
    {
        $dir_handle = null;
        if (is_dir($dirPath))
            $dir_handle = opendir($dirPath);

        if (!$dir_handle)
            return false;

        if ($verbose)
            print "Deleting directory: " . $dirPath . PHP_EOL;

        while($file = readdir($dir_handle)) {

            if ($file != "." && $file != "..") {
                if (!is_dir($dirPath."/".$file)) {

                    if ($verbose)
                        print "Deleting file: " . $dirPath."/".$file . PHP_EOL;

                    unlink($dirPath."/".$file);
                }
                else
                    self::deleteDirectory($dirPath . '/' . $file);
            }
        }
        closedir($dir_handle);
        rmdir($dirPath);
        return true;
    }


    /**
     * Changes the permissions of files inside a folder recursively to a defined value
     * @param string $path Path to the directory containing the files or folders with files
     * @param int $permissions Permissions to set (Default: 0777)
     * @param bool $verbose Should detailed output printed to STDOUT?
     */
    public static function chmod(string $path, int $permissions = 0777, bool $verbose = false): void
    {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $item) {
            if ($verbose)
                print "Changing file: " . $item->getPathname() . PHP_EOL;
            chmod($item->getPathname(), $permissions);
            if ($item->isDir() && !$item->isDot()) {
                self::chmod($item->getPathname(), $permissions);
            }
        }
    }
}
<?php
/**
 * PHPUtils - File.php
 * Copyright (c) 2023 Kleine-Vorholt.NET
 *
 * For used third-party software see THIRD-PARTY
 * file at '_misc/THIRD-PARTY'
 *
 * @file File.php
 * @date 10.11.2023 23:23
 *
 * @copyright (c) the author(s)
 * @author Kleine-Vorholt.NET <florian@kleine-vorholt.net> (2023–)
 * @license CC 4.0 http://creativecommons.org/licenses/by-nc-nd/4.0/
 *
 */

namespace Cr4zyFl1x\PHPUtils\IO;

use Cr4zyFl1x\PHPUtils\IO\Exception\FileNotFoundException;
use Cr4zyFl1x\PHPUtils\IO\Exception\IOException;
use Cr4zyFl1x\PHPUtils\Util\RecursiveFileSystemUtils;

/**
 * An abstract representation of file and directory pathnames.
 * @author Florian J. Kleine-Vorholt
 */
class File implements Closeable
{

    /**
     * @var string
     */
    private string $path;


    /**
     * @var resource
     */
    private $handle;


    /**
     * Creates a new File instance.
     * @param string $filepath A filepath string
     */
    public function __construct(string $filepath)
    {
        $this->path = $filepath;
        if ($this->exists())
            $this->path = $this->getAbsolutePath();
    }


    /**
     * Tests whether a file or a directory exists on the abstract pathname.
     * @return bool true, if a file or directory exists; false otherwise
     */
    public final function exists(): bool
    {
        return file_exists($this->path);
    }


    /**
     * Tests whether the file denoted by this abstract pathname is a directory.
     * @return bool true if and only if the file denoted by this abstract pathname exists and is a directory; false otherwise
     */
    public final function isDirectory(): bool
    {
        return is_dir($this->path);
    }


    /**
     * Tests whether the file denoted by this abstract pathname is a normal file.
     * @return bool true if and only if the file denoted by this abstract pathname exists and is a normal file; false otherwise
     */
    public final function isFile(): bool
    {
        return is_file($this->path);
    }


    /**
     * Atomically creates a new, empty file named by this abstract pathname if and only if a file with this name does not yet exist.
     * @return bool true if the named file does not exist and was successfully created; false if the named file already exists
     */
    public final function createNewFile(): bool
    {
        if ($this->isFile())
            return false;
        $fh = fopen($this->path, "w");
        if (!$fh)
            return false;
        fclose($fh);
        return true;
    }


    /**
     * Creates the directory named by this abstract pathname, including any necessary but nonexistent parent directories.
     * @return bool true if successful
     */
    public final function mkdirs(): bool
    {
        return mkdir($this->path, 0777, true);
    }


    /**
     * Creates the directory named by this abstract pathname.
     * @return bool true if successful
     */
    public final function mkdir(): bool
    {
        return mkdir($this->path, 0777, false);
    }


    /**
     * Returns the absolute pathname string of this abstract pathname.
     * @return string|null Absolute pathname if file exists. Otherwise <tt>null</tt>
     */
    public final function getAbsolutePath(): ?string
    {
        return $this->exists() ? realpath($this->path) : null;
    }


    /**
     * Opens file and returns the handle of the resource.
     * @param string $mode <p>
     *  The mode parameter specifies the type of access
     *  you require to the stream. It may be any of the following:
     *  <table>
     *  A list of possible modes
     *  <tr valign="top">
     *  <td>mode</td>
     *  <td>Description</td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'r'</td>
     *  <td>
     *  Open for reading only; place the file pointer at the
     *  beginning of the file.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'r+'</td>
     *  <td>
     *  Open for reading and writing; place the file pointer at
     *  the beginning of the file.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'w'</td>
     *  <td>
     *  Open for writing only; place the file pointer at the
     *  beginning of the file and truncate the file to zero length.
     *  If the file does not exist, attempt to create it.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'w+'</td>
     *  <td>
     *  Open for reading and writing; place the file pointer at
     *  the beginning of the file and truncate the file to zero
     *  length. If the file does not exist, attempt to create it.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'a'</td>
     *  <td>
     *  Open for writing only; place the file pointer at the end of
     *  the file. If the file does not exist, attempt to create it.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'a+'</td>
     *  <td>
     *  Open for reading and writing; place the file pointer at
     *  the end of the file. If the file does not exist, attempt to
     *  create it.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'x'</td>
     *  <td>
     *  Create and open for writing only; place the file pointer at the
     *  beginning of the file. If the file already exists, the
     *  fopen call will fail by returning false and
     *  generating an error of level E_WARNING. If
     *  the file does not exist, attempt to create it. This is equivalent
     *  to specifying O_EXCL|O_CREAT flags for the
     *  underlying open(2) system call.
     *  </td>
     *  </tr>
     *  <tr valign="top">
     *  <td>'x+'</td>
     *  <td>
     *  Create and open for reading and writing; place the file pointer at
     *  the beginning of the file. If the file already exists, the
     *  fopen call will fail by returning false and
     *  generating an error of level E_WARNING. If
     *  the file does not exist, attempt to create it. This is equivalent
     *  to specifying O_EXCL|O_CREAT flags for the
     *  underlying open(2) system call.
     *  </td>
     *  </tr>
     *  </table>
     *  </p>
     *  <p>
     *  Different operating system families have different line-ending
     *  conventions. When you write a text file and want to insert a line
     *  break, you need to use the correct line-ending character(s) for your
     *  operating system. Unix based systems use \n as the
     *  line ending character, Windows based systems use \r\n
     *  as the line ending characters and Macintosh based systems use
     *  \r as the line ending character.
     *  </p>
     *  <p>
     *  If you use the wrong line ending characters when writing your files, you
     *  might find that other applications that open those files will "look
     *  funny".
     *  </p>
     *  <p>
     *  Windows offers a text-mode translation flag ('t')
     *  which will transparently translate \n to
     *  \r\n when working with the file. In contrast, you
     *  can also use 'b' to force binary mode, which will not
     *  translate your data. To use these flags, specify either
     *  'b' or 't' as the last character
     *  of the mode parameter.
     *  </p>
     *  <p>
     *  The default translation mode depends on the SAPI and version of PHP that
     *  you are using, so you are encouraged to always specify the appropriate
     *  flag for portability reasons. You should use the 't'
     *  mode if you are working with plain-text files and you use
     *  \n to delimit your line endings in your script, but
     *  expect your files to be readable with applications such as notepad. You
     *  should use the 'b' in all other cases.
     *  </p>
     *  <p>
     *  If you do not specify the 'b' flag when working with binary files, you
     *  may experience strange problems with your data, including broken image
     *  files and strange problems with \r\n characters.
     *  </p>
     *  <p>
     *  For portability, it is strongly recommended that you always
     *  use the 'b' flag when opening files with fopen.
     *  </p>
     *  <p>
     *  Again, for portability, it is also strongly recommended that
     *  you re-write code that uses or relies upon the 't'
     *  mode so that it uses the correct line endings and
     *  'b' mode instead.
     *  </p>
     * @return resource a file pointer resource on success
     * @throws FileNotFoundException if the file could not be found
     * @throws IOException on file system errors
     */
    public final function getResource(string $mode)
    {
        if (!$this->isFile())
            throw new FileNotFoundException("Cannot create resource handle for file. File does not exist!");
        if (isset($this->handle))
            throw new IOException("File already opened and locked! Try closing it first!");
        $this->handle = fopen($this->path, $mode);
        if (!$this->handle)
            throw new IOException("Error creating resource handle!");
        return $this->handle;
    }


    /**
     * @inheritDoc
     * @throws IOException on file system access error or the file cannot be closed
     */
    public function close(): void
    {
        if ($this->handle == null)
            return;

        $fcl = fclose($this->handle);
        $this->handle = null;
        if (!$fcl)
            throw new IOException("An error occurred accessing the file system!");
    }


    /**
     * Returns the length of the file denoted by this abstract pathname.
     * @return int The length, in bytes, of the file denoted by this abstract pathname, or <tt>-1</tt> if the file does not exist.
     */
    public final function length(): int
    {
        if (!$this->isFile())
            return -1;
        return filesize($this->path);
    }


    /**
     * Deletes the file or directory denoted by this abstract pathname.
     * @return bool true if deleted successfully
     */
    public final function delete(): bool
    {
        if (!$this->exists())
            return false;
        if (isset($this->handle)) {
            try {
                $this->close();
            } catch (IOException) {
                return false;
            }
        }
        return $this->isDirectory() ? RecursiveFileSystemUtils::deleteDirectory($this->path, false) : unlink($this->path);
    }
}
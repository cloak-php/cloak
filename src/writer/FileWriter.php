<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\writer;

use SplFileObject;

/**
 * Class FileWriter
 * @package cloak\writer
 */
class FileWriter implements WriterInterface
{

    /**
     * @var \SplFileObject
     */
    private $file;
    private $writeSize = 0;


    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $directoryPath = dirname($filePath);

        if (file_exists($directoryPath) === false) {
            throw new DirectoryNotFoundException("$directoryPath directory not found");
        }

        if (is_writable($directoryPath) === false) {
            throw new DirectoryNotWritableException("Can not write to the directory $directoryPath");
        }

        $this->file = new SplFileObject($filePath, 'w');
    }

    /**
     * @param string $text
     */
    public function writeText($text)
    {
        $this->write($text);
    }

    /**
     * @param string $text
     */
    public function writeLine($text)
    {
        $this->writeText($text . PHP_EOL);
    }

    /**
     * Write a blank line
     */
    public function writeEOL()
    {
        $this->write(PHP_EOL);
    }

    private function write($text)
    {
        $writeBytes = $this->file->fwrite($text);
        $this->writeSize += $writeBytes;
    }

    /**
     * @return int
     */
    public function getWriteSize()
    {
        return $this->writeSize;
    }

}

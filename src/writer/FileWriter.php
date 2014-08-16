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
class FileWriter
{

    /**
     * @var \SplFileObject
     */
    private $file;

    /**
     * @param AdapterInterface $adapterInterface
     */
    public function __construct($filePath)
    {
        $this->file = new SplFileObject($filePath, 'w');
    }

    /**
     * @param string $text
     */
    public function writeText($text)
    {
        $this->file->fwrite($text);
    }

    /**
     * @param string $text
     */
    public function writeLine($text)
    {
        $this->file->fwrite($text . PHP_EOL);
    }

    /**
     * @return int
     */
    public function getWriteSize()
    {
        return $this->file->getSize();
    }

}

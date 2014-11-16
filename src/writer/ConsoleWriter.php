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

use Zend\Console\Console;


/**
 * Class ConsoleWriter
 * @package cloak\writer
 */
class ConsoleWriter implements ConsoleWriterInterface
{

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    private $console;


    public function __construct()
    {
        $this->console = Console::getInstance();
    }

    /**
     * @{inheritDoc}
     */
    public function writeText($text, $color = null, $bgColor = null)
    {
        $this->console->writeText($text, $color, $bgColor);
    }

    /**
     * @{inheritDoc}
     */
    public function writeLine($text = "", $color = null, $bgColor = null)
    {
        $this->console->writeLine($text, $color, $bgColor);
    }

    /**
     * @{inheritDoc}
     */
    public function writeEOL()
    {
        $this->console->writeLine('');
    }

}

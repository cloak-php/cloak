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
use Zend\Console\Adapter\AdapterInterface;

/**
 * Class ConsoleWriter
 * @package cloak\writer
 */
class ConsoleWriter
{

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    private $console;

    /**
     * @param AdapterInterface $adapterInterface
     */
    public function __construct(AdapterInterface $adapterInterface = null)
    {
        $this->console = $adapterInterface ?: Console::getInstance();
    }

    /**
     * Alias for write()
     *
     * @param string $text
     * @param null|int $color
     * @param null|int $bgColor
     * @return void
     */
    public function writeText($text, $color = null, $bgColor = null)
    {
        $this->console->writeText($text, $color, $bgColor);
    }

    /**
     * Write a single line of text to console and advance cursor to the next line.
     * If the text is longer than console width it will be truncated.
     *
     * @param string                   $text
     * @param null|int $color
     * @param null|int $bgColor
     * @return void
     */
    public function writeLine($text = "", $color = null, $bgColor = null)
    {
        $this->console->writeLine($text, $color, $bgColor);
    }

    public function writeEOL()
    {
        $this->console->writeLine('');
    }

}

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


/**
 * Class AbstractConsoleWriter
 * @package cloak\writer
 */
abstract class AbstractConsoleWriter implements StdoutWriter
{

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    protected $console;


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

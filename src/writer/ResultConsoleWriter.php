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

use cloak\value\Coverage;
use cloak\result\CoverageResultInterface;
use Zend\Console\Console;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface as Color;


/**
 * Class ResultConsoleWriter
 * @package cloak\writer
 */
class ResultConsoleWriter implements ResultConsoleWriterInterface
{

    /**
     * @var \Zend\Console\Adapter\AdapterInterface
     */
    private $console;

    /**
     * @var \cloak\value\Coverage
     */
    private $highLowerBound;

    /**
     * @var \cloak\value\Coverage
     */
    private $lowUpperBound;


    /**
     * @param AdapterInterface $adapterInterface
     */
    public function __construct($highLowerBound, $lowUpperBound)
    {
        $this->console = Console::getInstance();
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
    }

    /**
     * @{inheritDoc}
     */
    public function writeResult(CoverageResultInterface $result)
    {
        $text = sprintf('%6.2f%%', $result->getCodeCoverage()->value());

        if ($result->isCoverageGreaterEqual($this->highLowerBound)) {
            $this->console->writeText($text, Color::GREEN);
        } else if ($result->isCoverageLessThan($this->lowUpperBound)) {
            $this->console->writeText($text, Color::YELLOW);
        } else {
            $this->console->writeText($text, Color::NORMAL);
        }
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

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

use cloak\value\CoverageBound;
use cloak\result\CoverageResultInterface;
use Zend\Console\Console;
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
     * @var CoverageBound
     */
    private $coverageBound;


    /**
     * @param CoverageBound $coverageBound
     */
    public function __construct(CoverageBound $coverageBound)
    {
        $this->console = Console::getInstance();
        $this->coverageBound = $coverageBound;
    }

    /**
     * @{inheritDoc}
     */
    public function writeResult(CoverageResultInterface $result)
    {
        $text = sprintf('%6.2f%%', $result->getCodeCoverage()->value());

        if ($result->isCoverageGreaterEqual($this->coverageBound->getHighCoverageBound())) {
            $this->console->writeText($text, Color::GREEN);
        } else if ($result->isCoverageLessThan($this->coverageBound->getLowCoverageBound())) {
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

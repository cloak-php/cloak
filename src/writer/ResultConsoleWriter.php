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
class ResultConsoleWriter extends AbstractConsoleWriter implements ResultConsoleWriterInterface
{

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
        $coverage = $result->getCodeCoverage();
        $coverageText = $coverage->formattedValue();

        if ($this->coverageBound->isHighBoundGreaterThan($coverage)) {
            $this->console->writeText($coverageText, Color::GREEN);
        } else if ($this->coverageBound->isLowBoundLessThan($coverage)) {
            $this->console->writeText($coverageText, Color::YELLOW);
        } else {
            $this->console->writeText($coverageText, Color::NORMAL);
        }
    }

}

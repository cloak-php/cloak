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
        if ($result->isCoverageGreaterEqual($this->coverageBound->getHighCoverageBound())) {
            $this->writeVeryGoodMessage($result);
        } else if ($result->isCoverageLessThan($this->coverageBound->getLowCoverageBound())) {
            $this->writeWarningMessage($result);
        } else {
            $this->writeNormalMessage($result);
        }
    }

    /**
     * @param CoverageResultInterface $result
     */
    private function writeVeryGoodMessage(CoverageResultInterface $result)
    {
        $text = sprintf('%6.2f%%', $result->getCodeCoverage()->value());
        $this->console->writeText($text, Color::GREEN);
    }

    /**
     * @param CoverageResultInterface $result
     */
    private function writeWarningMessage(CoverageResultInterface $result)
    {
        $text = sprintf('%6.2f%%', $result->getCodeCoverage()->value());
        $this->console->writeText($text, Color::YELLOW);
    }

    /**
     * @param CoverageResultInterface $result
     */
    private function writeNormalMessage(CoverageResultInterface $result)
    {
        $text = sprintf('%6.2f%%', $result->getCodeCoverage()->value());
        $this->console->writeText($text, Color::NORMAL);
    }

}

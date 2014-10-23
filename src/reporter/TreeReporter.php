<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use cloak\Result;
use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use cloak\value\Coverage;
use cloak\CoverageResultInterface;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;
use cloak\CoverageResultVisitorInterface;


/**
 * Class TreeReporter
 * @package cloak\reporter
 */
class TreeReporter implements ReporterInterface, CoverageResultVisitorInterface
{

    use Reportable;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;
    const IDENT_SIZE = 2;

    /**
     * @var \cloak\writer\ConsoleWriter
     */
    private $console;

    /**
     * @var \cloak\value\Coverage
     */
    private $lowUpperBound;

    /**
     * @var \cloak\value\Coverage
     */
    private $highLowerBound;

    /**
     * @var int
     */
    private $indent;

    /**
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->console = new ConsoleWriter();
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
        $this->indent = 0;
    }


    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $result = $event->getResult();

        $this->writeHeader($result);
        $this->writeChildResults($result);
        $this->writeTotalCoverage($event->getResult());
    }

    /**
     * @param CoverageResultInterface $result
     */
    public function visit(CoverageResultInterface $result)
    {
        $this->writeResult($result);
    }

    /**
     * @param CoverageResultInterface $result
     */
    protected function writeHeader(CoverageResultInterface $result)
    {
        $header = sprintf('%s code coverage', $result->getName());
        $this->console->writeLine($header, Color::CYAN);
    }

    /**
     * @param CoverageResultInterface $result
     */
    protected function writeResult(CoverageResultInterface $result)
    {
        $this->writeCoverageResult($result);
        $this->indent++;
        $this->writeChildResults($result);
        $this->indent--;
    }

    /**
     * @param CoverageResultInterface $result
     */
    protected function writeChildResults(CoverageResultInterface $result)
    {
        $childResults = $result->getChildResults();

        foreach ($childResults as $childResult) {
            $this->visit($childResult);
        }
    }

    protected function writeCoverageResult(CoverageResultInterface $result)
    {
        $size = $this->indent * $this->indent;
        $indent = str_pad('', $size, ' ');
        $this->console->writeText($indent);

        $this->writeCoverage($result);

        $this->console->writeText(' ');
        $this->console->writeText($result->getName());
        $this->console->writeEOL();
    }

    /**
     * @param CoverageResultInterface $result
     */
    protected function writeCoverage(CoverageResultInterface $result)
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
     * @param Result $result
     */
    protected function writeTotalCoverage(Result $result)
    {
        $this->console->writeText(PHP_EOL);
        $this->console->writeText('Code Coverage:');
        $this->writeCoverage($result);
        $this->console->writeText(PHP_EOL);
    }

}

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
use cloak\event\InitEvent;
use cloak\event\StopEvent;
use cloak\value\CoverageBounds;
use cloak\result\CoverageResultInterface;
use cloak\result\CoverageResultVisitorInterface;
use cloak\writer\ResultConsoleWriter;
use Zend\Console\ColorInterface as Color;


/**
 * Class TreeReporter
 * @package cloak\reporter
 */
class TreeReporter
    implements ReporterInterface, StopEventListener, CoverageResultVisitorInterface
{

    use Reportable;

    const IDENT_SIZE = 2;

    /**
     * @var \cloak\writer\ResultConsoleWriter
     */
    private $console;


    /**
     * @var int
     */
    private $indent;


    /**
     * @param float $satisfactory
     * @param float $critical
     */
    public function __construct(
        $satisfactory = self::DEFAULT_HIGH_BOUND,
        $critical = self::DEFAULT_LOW_BOUND
    )
    {
        $bounds = new CoverageBounds($critical, $satisfactory);
        $this->console = new ResultConsoleWriter($bounds);
        $this->indent = 0;
    }

    /**
     * @param \cloak\event\InitEvent $event
     */
    public function onInit(InitEvent $event)
    {
    }


    /**
     * @param \cloak\event\StopEvent $event
     */
    public function onStop(StopEvent $event)
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
        $this->console->writeResult($result);
        $this->console->writeText(' ');
        $this->console->writeText($result->getName());
        $this->console->writeEOL();
    }

    /**
     * @param Result $result
     */
    protected function writeTotalCoverage(Result $result)
    {
        $this->console->writeText(PHP_EOL);
        $this->console->writeText('Code Coverage:');
        $this->console->writeResult($result);
        $this->console->writeText(PHP_EOL);
    }

}

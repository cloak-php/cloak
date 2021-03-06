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

use cloak\AnalyzedCoverageResult;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\result\CoverageResultNode;
use cloak\result\CoverageResultVisitor;
use cloak\writer\ResultConsoleWriter;
use Zend\Console\ColorInterface as Color;
use PHPExtra\EventManager\EventManager;


/**
 * Class TreeReporter
 * @package cloak\reporter
 */
class TreeReporter
    implements Reporter, InitializeEventListener, AnalyzeStopEventListener, CoverageResultVisitor
{

    const IDENT_SIZE = 2;

    /**
     * @var \cloak\writer\ResultConsoleWriter
     */
    private $console;


    /**
     * @var int
     */
    private $indent;


    public function __construct()
    {
        $this->indent = 0;
    }

    /**
     * @param \cloak\event\InitializeEvent $event
     */
    public function onInitialize(InitializeEvent $event)
    {
        $coverageBounds = $event->getCoverageBounds();
        $this->console = new ResultConsoleWriter($coverageBounds);
    }

    /**
     * @param \cloak\event\AnalyzeStopEvent $event
     */
    public function onAnalyzeStop(AnalyzeStopEvent $event)
    {
        $result = $event->getResult();

        $this->writeHeader($result);
        $this->writeChildResults($result);
        $this->writeTotalCoverage($event->getResult());
    }

    /**
     * @param CoverageResultNode $result
     */
    public function visit(CoverageResultNode $result)
    {
        $this->writeResult($result);
    }

    /**
     * @param CoverageResultNode $result
     */
    protected function writeHeader(CoverageResultNode $result)
    {
        $header = sprintf('%s code coverage', $result->getName());
        $this->console->writeLine($header, Color::CYAN);
    }

    /**
     * @param CoverageResultNode $result
     */
    protected function writeResult(CoverageResultNode $result)
    {
        $this->writeCoverageResult($result);
        $this->indent++;
        $this->writeChildResults($result);
        $this->indent--;
    }

    /**
     * @param CoverageResultNode $result
     */
    protected function writeChildResults(CoverageResultNode $result)
    {
        $childResults = $result->getChildResults();

        foreach ($childResults as $childResult) {
            $this->visit($childResult);
        }
    }

    protected function writeCoverageResult(CoverageResultNode $result)
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
     * @param AnalyzedCoverageResult $result
     */
    protected function writeTotalCoverage(AnalyzedCoverageResult $result)
    {
        $this->console->writeText(PHP_EOL);
        $this->console->writeText('Code Coverage: ');
        $this->console->writeResult($result);
        $this->console->writeText(PHP_EOL);
    }

    /**
     * @param EventManager $eventManager
     */
    public function registerTo(EventManager $eventManager)
    {
        $eventManager->add($this);
    }

}

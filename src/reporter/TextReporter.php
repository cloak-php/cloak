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
use cloak\result\FileResult;
use cloak\writer\ResultConsoleWriter;
use PHPExtra\EventManager\EventManagerInterface;


/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter
    implements Reporter, InitializeEventListener, AnalyzeStopEventListener
{


    /**
     * @var \cloak\writer\ResultConsoleWriter
     */
    private $console;


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
        $this->reportResult($event->getResult());
    }

    /**
     * @param AnalyzedCoverageResult $result
     */
    public function reportResult(AnalyzedCoverageResult $result)
    {
        $files = $result->getFiles()->getIterator();

        foreach ($files as $file) {
            $this->reportFile($file);
        }

        $this->writeTotalCoverage($result);
    }

    /**
     * @param \cloak\result\FileResult $file
     */
    protected function reportFile(FileResult $file)
    {
        $currentDirectory = getcwd();

        $filePathReport = $file->getRelativePath($currentDirectory);

        $this->console->writeResult($file);
        $this->console->writeText(' ');
        $this->console->writeText(sprintf("(%2d/%2d)",
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        ));
        $this->console->writeText(' ');
        $this->console->writeText($filePathReport);

        $this->console->writeText(PHP_EOL);
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
     * @param EventManagerInterface $eventManager
     */
    public function registerTo(EventManagerInterface $eventManager)
    {
        $eventManager->addListener($this);
    }

}

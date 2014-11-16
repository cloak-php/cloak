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
use cloak\result\FileResult;
use cloak\value\Coverage;
use cloak\result\CoverageResultInterface;
use cloak\writer\ConsoleWriter;
use Zend\Console\ColorInterface as Color;


/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter implements ReporterInterface
{

    use Reportable;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;

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
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->console = new ConsoleWriter($highLowerBound, $lowUpperBound);
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
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
        $this->reportResult($event->getResult());
    }

    /**
     * @param Result $result
     */
    public function reportResult(Result $result)
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

        $this->writeCoverage($file);
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
     * @param Result $result
     */
    protected function writeTotalCoverage(Result $result)
    {
        $this->console->writeText(PHP_EOL);
        $this->console->writeText('Code Coverage:');
        $this->writeCoverage($result);
        $this->console->writeText(PHP_EOL);
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

}

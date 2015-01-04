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
use cloak\event\StopEventInterface;
use cloak\result\FileResult;
use cloak\value\CoverageBound;
use cloak\writer\ResultConsoleWriter;


/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter implements ReporterInterface
{

    use Reportable;


    /**
     * @var \cloak\writer\ResultConsoleWriter
     */
    private $console;



    /**
     * @param float $satisfactory
     * @param float $critical
     */
    public function __construct(
        $satisfactory = self::DEFAULT_HIGH_BOUND,
        $critical = self::DEFAULT_LOW_BOUND
    )
    {
        $bounds = new CoverageBound($critical, $satisfactory);
        $this->console = new ResultConsoleWriter($bounds);
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

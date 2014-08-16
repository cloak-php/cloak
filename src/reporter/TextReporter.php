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
use cloak\result\File;
use cloak\value\Coverage;
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

    const PAD_CHARACTER = '.';
    const PAD_CHARACTER_LENGTH = 70;

    /**
     * @var \cloak\writer\ConsoleWriter
     */
    private $console;

    /**
     * @var \cloak\result\Coverage
     */
    private $lowUpperBound;

    /**
     * @var \cloak\result\Coverage
     */
    private $highLowerBound;


    /**
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->console = new ConsoleWriter();
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
    }

    /**
     * @param \cloak\event\StartEventInterface $event
     */
    public function onStart(StartEventInterface $event)
    {
        $startAt = $event->getSendAt()->format('j F Y \a\t H:i');
        $this->console->writeLine(str_pad("", static::PAD_CHARACTER_LENGTH, "-"));
        $this->console->writeLine("Start at: " . $startAt);
        $this->console->writeLine(str_pad("", static::PAD_CHARACTER_LENGTH, "-"));
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
    }

    /**
     * @param \cloak\result\File $file
     */
    protected function reportFile(File $file)
    {
        $currentDirectory = getcwd();

        $filePathReport = $file->getRelativePath($currentDirectory) . ' ';
        $filePathReport = str_pad($filePathReport, static::PAD_CHARACTER_LENGTH, static::PAD_CHARACTER);

        $this->console->writeText($filePathReport);
        $this->writeCoverage($file);
        $this->console->writeText(sprintf("(%2d/%2d)",
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        ));

        $this->console->writeText(PHP_EOL);
    }

    /**
     * @param \cloak\result\File $file
     */
    protected function writeCoverage(File $file)
    {
        $text = sprintf(' %6.2f%% ', $file->getCodeCoverage()->value());

        if ($file->isCoverageGreaterEqual($this->highLowerBound)) {
            $this->console->writeText($text, Color::GREEN);
        } else if ($file->isCoverageLessThan($this->lowUpperBound)) {
            $this->console->writeText($text, Color::YELLOW);
        } else {
            $this->console->writeText($text, Color::NORMAL);
        }
    }

}

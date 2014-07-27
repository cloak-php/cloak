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
use cloak\result\File;
use cloak\result\Coverage;
use cloak\event\StopEventInterface;
use Colors\Color;

/**
 * Class TextReporter
 * @package cloak\reporter
 */
class TextReporter implements ReporterInterface
{

    use Reportable;

    const PAD_CHARACTER = '.';
    const PAD_CHARACTER_LENGTH = 70;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;

    private $lowUpperBound;
    private $highLowerBound;

    /**
     * @param float $highLowerBound
     * @param float $lowUpperBound
     */
    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->lowUpperBound = new Coverage($lowUpperBound);
        $this->highLowerBound = new Coverage($highLowerBound);
    }

    /**
     * @param \cloak\event\StopEventInterface $event
     */
    public function onStop(StopEventInterface $event)
    {
        $files = $event->getResult()->getFiles();
        $files->map(function(File $file) {
            echo $this->reportFrom($file) . PHP_EOL;
        });
    }

    /**
     * @param \cloak\result\File $file
     * @return string
     */
    protected function reportFrom(File $file)
    {

        $currentDirectory = getcwd();

        $filePathReport = $file->getRelativePath($currentDirectory) . ' ';
        $filePathReport = str_pad($filePathReport, static::PAD_CHARACTER_LENGTH, static::PAD_CHARACTER);

        $coverage = $this->coverageReportFrom($file);

        $result = sprintf("%s %s (%2d/%2d)",
            $filePathReport,
            $coverage,
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        );

        return $result;
    }

    /**
     * @param \cloak\result\File $file
     * @return string
     */
    protected function coverageReportFrom(File $file)
    {

        $color = new Color(sprintf('%6.2f%%', $file->getCodeCoverage()->valueOf()));

        if ($file->isCoverageGreaterEqual($this->highLowerBound)) {
            $color->green();
        } else if ($file->isCoverageLessThan($this->lowUpperBound)) {
            $color->yellow();
        }

        return $color;

    }

}

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\report\factory;

use cloak\Result;
use cloak\result\File;
use cloak\result\Coverage;
use cloak\report\TextReport;
use Colors\Color;


/**
 * Class TextReportFactory
 * @package cloak\report\factory
 */
class TextReportFactory implements ReportFactoryInterface
{

    const PAD_CHARACTER = '.';
    const PAD_CHARACTER_LENGTH = 70;

    /**
     * @var \cloak\result\Coverage
     */
    private $lowUpperBound;

    /**
     * @var \cloak\result\Coverage
     */
    private $highLowerBound;

    /**
     * @param \cloak\result\Coverage $highLowerBound
     * @param \cloak\result\Coverage $lowUpperBound
     */
    public function __construct(Coverage $highLowerBound, Coverage $lowUpperBound)
    {
        $this->lowUpperBound = $lowUpperBound;
        $this->highLowerBound = $highLowerBound;
    }

    /**
     * @param Result $result
     * @return \cloak\report\ReportInterface
     */
    public function createFromResult(Result $result)
    {
        $files = $result->getFiles();
        $lines = $files->map(function(File $file) {
            return $this->reportFrom($file);
        })->all();

        $content = implode(PHP_EOL, $lines) . PHP_EOL;

        return new TextReport($content);
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

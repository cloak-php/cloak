<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer\Reporter;

use CodeAnalyzer\Result;
use CodeAnalyzer\Result\File;
use Colors\Color;

class TextReporter {

    const PAD_CHARACTER = '.';
    const PAD_CHARACTER_LENGTH = 70;

    const DEFAULT_LOW_BOUND = 35.0;
    const DEFAULT_HIGH_BOUND = 70.0;

    private $lowUpperBound;
    private $highLowerBound;

    public function __construct($highLowerBound = self::DEFAULT_HIGH_BOUND, $lowUpperBound = self::DEFAULT_LOW_BOUND)
    {
        $this->lowUpperBound = (float) $lowUpperBound;
        $this->highLowerBound = (float) $highLowerBound;
    }

    public function stop(Result $result)
    {
        $files = $result->getFiles();
        $files->map(function(File $file) {
            echo $this->reportFrom($file) . PHP_EOL;
        });
    }

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

    protected function coverageReportFrom(File $file)
    {

        $color = new Color(sprintf('%6.2f%%', (float) $file->getCodeCoverage()));
        $color->setForceStyle(true);

        if ($file->isCoverageGreaterThan($this->highLowerBound)) {
            $color->green();
        } else if ($file->isCoverageLowerThan($this->lowUpperBound)) {
            $color->yellow();
        }
        return $color;

    }

}

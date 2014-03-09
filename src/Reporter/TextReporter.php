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

class TextReporter {

    const PAD_CHARACTER = '.';
    const PAD_CHARACTER_LENGTH = 70;

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

        $result = sprintf('%s %0.2f%% (%d/%d)',
            $filePathReport,
            $file->getCodeCoverage(),
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        );

        return $result;
    }

}

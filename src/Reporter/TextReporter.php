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

    public function stop(Result $result)
    {
        $files = $result->getFiles();

        foreach ($files as $file) {
            $result = $this->reportFrom($file);
            echo $result . PHP_EOL;
        }
    }

    protected function reportFrom(File $file)
    {

        $currentDirectory = getcwd();
        $result = sprintf("%s > %0.2f%% (%d/%d)",
            $file->getRelativePath($currentDirectory),
            $file->getCodeCoverage(),
            $file->getExecutedLineCount(),
            $file->getExecutableLineCount()
        );

        return $result;
    }

}

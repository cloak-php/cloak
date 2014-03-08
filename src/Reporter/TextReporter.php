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

class TextReporter {

    public function stop(Result $result)
    {
        $currentDirectory = getcwd();
        $files = $result->getFiles();

        foreach ($files as $file) {
            $result = sprintf("%s > %0.2f%% (%d/%d)",
                $file->getRelativePath($currentDirectory),
                $file->getCodeCoverage(),
                $file->getExecutedLineCount(),
                $file->getExecutableLineCount()
            );
            echo $result . PHP_EOL;
        }
    }

}

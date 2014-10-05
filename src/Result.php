<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use cloak\value\Coverage;
use cloak\result\FileResult;
use cloak\result\collection\LineResultCollection;
use cloak\result\collection\NamedResultCollection;
use cloak\driver\Result as AnalyzeResult;


/**
 * Class Result
 * @package cloak
 */
class Result implements CoverageResultInterface
{

    /**
     * @var NamedResultCollection
     */
    private $fileResults;


    /**
     * @param File[] $files
     */
    public function __construct($files = [])
    {
        $this->fileResults = new NamedResultCollection($files);
    }


    /**
     * @param driver\Result $result
     * @return Result
     */
    public static function fromAnalyzeResult(AnalyzeResult $result)
    {
        $files = static::parseResult($result);
        return new self($files);
    }

    /**
     * @param driver\Result $result
     * @return array
     */
    public static function parseResult(AnalyzeResult $result)
    {
        $files = [];
        $fileResults = $result->getFiles();

        foreach ($fileResults as $fileResult) {
            $path = $fileResult->getPath();
            $lineResults = LineResultCollection::from( $fileResult->getLineResults() );

            $file = new FileResult($path, $lineResults);
            $files[] = $file;
        }

        return $files;
    }

    /**
     * @return NamedResultCollection
     */
    public function getFiles()
    {
        $fileResults = $this->fileResults->toArray();
        return new NamedResultCollection($fileResults);
    }

    /**
     * @return int
     */
    public function getLineCount()
    {
        $totalLineCount = 0;

        foreach ($this->fileResults as $fileResult) {
            $totalLineCount += $fileResult->getLineCount();
        }

        return $totalLineCount;
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        $totalLineCount = 0;

        foreach ($this->fileResults as $fileResult) {
            $totalLineCount += $fileResult->getDeadLineCount();
        }

        return $totalLineCount;
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        $totalLineCount = 0;

        foreach ($this->fileResults as $fileResult) {
            $totalLineCount += $fileResult->getExecutedLineCount();
        }

        return $totalLineCount;
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        $totalLineCount = 0;

        foreach ($this->fileResults as $fileResult) {
            $totalLineCount += $fileResult->getUnusedLineCount();
        }

        return $totalLineCount;
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        $totalLineCount = 0;

        foreach ($this->fileResults as $fileResult) {
            $totalLineCount += $fileResult->getExecutableLineCount();
        }

        return $totalLineCount;
    }

    /**
     * @return Coverage
     */
    public function getCodeCoverage()
    {
        $executedLineCount = $this->getExecutedLineCount();
        $executableLineCount = $this->getExecutableLineCount();
        $realCoverage = ($executedLineCount / $executableLineCount) * 100;

        $coverage = (float) round($realCoverage, 2);

        return new Coverage($coverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->getCodeCoverage()->lessThan($coverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->getCodeCoverage()->greaterEqual($coverage);
    }

}

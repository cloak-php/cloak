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
use cloak\result\CoverageResultNode;
use cloak\result\CoverageResultVisitor;
use cloak\result\collection\LineResultCollection;
use cloak\result\collection\CoverageResultCollection;
use cloak\analyzer\AnalyzedResult;


/**
 * Class AnalyzedCoverageResult
 * @package cloak
 */
class AnalyzedCoverageResult implements CoverageResultNode
{

    /**
     * @var result\CoverageResultNodeCollection
     */
    private $fileResults;


    /**
     * @param FileResult[] $files
     */
    public function __construct($files = [])
    {
        $this->fileResults = new CoverageResultCollection($files);
    }


    /**
     * @param \cloak\analyzer\AnalyzedResult $result
     * @return AnalyzedCoverageResult
     */
    public static function fromAnalyzeResult(AnalyzedResult $result)
    {
        $files = static::parseResult($result);
        return new self($files);
    }

    /**
     * @param \cloak\analyzer\AnalyzedResult $result
     * @return array
     */
    public static function parseResult(AnalyzedResult $result)
    {
        $files = [];
        $fileResults = $result->getFiles();

        foreach ($fileResults as $fileResult) {
            $path = $fileResult->getPath();
            $lineResults = LineResultCollection::from( $fileResult->getLineResults() );

            $file = new FileResult($path, $lineResults);
            $files[$path] = $file;
        }

        return $files;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Package';
    }

    /**
     * @return \cloak\result\CoverageResultNodeCollection
     */
    public function getFiles()
    {
        $fileResults = $this->fileResults->toArray();
        return new CoverageResultCollection($fileResults);
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
        return Coverage::fromLineResult($this);
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

    /**
     * @return bool
     */
    public function hasChildResults()
    {
        return $this->fileResults->isEmpty() === false;
    }

    /**
     * @return result\CoverageResultNodeCollection
     */
    public function getChildResults()
    {
        return $this->getFiles();
    }

    /**
     * @param CoverageResultVisitor $visitor
     */
    public function accept(CoverageResultVisitor $visitor)
    {
        $visitor->visit($this);
    }

}

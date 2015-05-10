<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result\collection;

use cloak\Collection;
use cloak\collection\ElementStackable;
use cloak\value\Coverage;
use cloak\value\LineRange;
use cloak\result\LineResult;
use cloak\result\CodeCoverageResult;
use cloak\result\LineResultSelectable;
use cloak\result\LineCountResult;
use cloak\reflection\Reflection;
use PhpCollection\Sequence;


/**
 * Class LineResultCollection
 * @package cloak\result\collection
 */
class LineResultCollection implements CodeCoverageResult, LineResultSelectable, LineCountResult, Collection
{

    use ElementStackable;

    /**
     * @param array $lines
     */
    public function __construct(array $lines = [])
    {
        $this->collection = new Sequence($lines);
    }

    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->collection->count();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        $lines = $this->selectLines(function(LineResult $line) {
            return $line->isDead();
        });
        return $lines->count();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        $lines = $this->selectLines(function(LineResult $line) {
            return $line->isUnused();
        });
        return $lines->count();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        $lines = $this->selectLines(function(LineResult $line) {
            return $line->isExecuted();
        });
        return $lines->count();
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        return $this->getUnusedLineCount() + $this->getExecutedLineCount();
    }

    /**
     * @return Coverage The value of code coverage
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
     * @param LineRange $lineRange
     * @return LineResultCollection
     */
    public function selectRange(LineRange $lineRange)
    {
        $lines = $this->selectLines(function(LineResult $line) use ($lineRange) {
            $lineNumber = $line->getLineNumber();
            return $lineRange->contains($lineNumber);
        });

        return new self($lines->all());
    }

    /**
     * @param Reflection $reflection
     * @return LineResultCollection
     */
    public function selectByReflection(Reflection $reflection)
    {
        $lineRange = $reflection->getLineRange();
        return $this->selectRange($lineRange);
    }

    /**
     * @param array $analyzeResults
     * @return LineResultCollection
     */
    public static function from(array $analyzeResults)
    {
        $results = [];

        foreach ($analyzeResults as $lineNumber => $analyzeResult) {
            $results[] = new LineResult($lineNumber, $analyzeResult);
        }

        return new self($results);
    }

    /**
     * @param callable $filter
     * @return \PhpCollection\AbstractSequence
     */
    public function selectLines(\Closure $filter)
    {
        $lines = $this->collection->filter($filter);
        return $lines;
    }

}

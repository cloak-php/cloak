<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result;

use cloak\value\Coverage;
use cloak\value\LineRange;
use PhpCollection\Sequence;

/***
 * Class LineSet
 * @package cloak\result
 */
class LineSet
{

    /**
     * @var \PhpCollection\Sequence
     */
    private $lines;

    /**
     * @param Sequence $lines
     */
    public function __construct(Sequence $lines)
    {
        $this->lines = $lines;
    }

    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->lines->count();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
            return $line->isDead();
        });
        return $lines->count();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
            return $line->isUnused();
        });
        return $lines->count();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        $lines = $this->selectLines(function(Line $line) {
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
        $value = (float) $this->getExecutedLineCount() / $this->getExecutableLineCount() * 100;

        return new Coverage($value);
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
     * @return LineSet
     */
    public function selectRange(LineRange $lineRange)
    {
        $lines = $this->selectLines(function(Line $line) use ($lineRange) {
            $lineNumber = $line->getLineNumber();
            return $lineRange->contains($lineNumber);
        });

        return new self($lines);
    }

    /**
     * @return null|Line
     */
    public function first()
    {
        $line = $this->lines->first();
        $line = $line->isDefined() ? $line->get() : null;
        return $line;
    }

    /**
     * @return null|Line
     */
    public function last()
    {
        $line = $this->lines->last();
        $line = $line->isDefined() ? $line->get() : null;
        return $line;
    }

    /**
     * @param callable $filter
     * @return \PhpCollection\AbstractSequence
     */
    protected function selectLines(\Closure $filter)
    {
        $lines = $this->lines->filter($filter);
        return $lines;
    }

}

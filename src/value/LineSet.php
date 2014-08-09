<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\value;

use PhpCollection\Sequence;
use cloak\result\Line;

/***
 * Class LineSet
 * @package cloak\value
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
     * @param callable $filter
     * @return \PhpCollection\AbstractSequence
     */
    protected function selectLines(\Closure $filter)
    {
        $lines = $this->lines->filter($filter);
        return $lines;
    }

}

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


/**
 * Trait CoverageResult
 * @package cloak\result
 */
trait CoverageResult
{

    /**
     * @var LineResultCollectionInterface
     */
    protected $lineResults;


    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->lineResults->getLineCount();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        return $this->lineResults->getDeadLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->lineResults->getUnusedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->lineResults->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        return $this->lineResults->getExecutableLineCount();
    }

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage()
    {
        return $this->lineResults->getCodeCoverage();
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->lineResults->isCoverageLessThan($coverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->lineResults->isCoverageGreaterEqual($coverage);
    }

    /**
     * @param CoverageResultVisitor $visitor
     */
    public function accept(CoverageResultVisitor $visitor)
    {
        $visitor->visit($this);
    }

}

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

use cloak\value\LineRange;
use cloak\CoverageResultInterface;
use cloak\value\Coverage;
use Zend\Code\Reflection\ClassReflection;

/**
 * Class ClassResult
 * @package cloak\result
 */
class ClassResult implements CoverageResultInterface
{

    /**
     * @var ClassReflection
     */
    private $classReflection;

    /**
     * @var LineSet
     */
    private $classLineResults;


    /**
     * @param ClassReflection $classReflection
     * @param LineSet $classLineResults
     */
    public function __construct(ClassReflection $classReflection, LineSetInterface $classLineResults)
    {
        $lineRange = new LineRange(
            $classReflection->getStartLine(),
            $classReflection->getEndLine()
        );
        $rangeResults = $classLineResults->selectRange($lineRange);

        $this->classReflection = $classReflection;
        $this->classLineResults = $rangeResults;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->classReflection->getName();
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->classReflection->getNamespaceName();
    }


    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->classLineResults->getLineCount();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        return $this->classLineResults->getDeadLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->classLineResults->getUnusedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->classLineResults->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        return $this->classLineResults->getExecutableLineCount();
    }

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage()
    {
        return $this->classLineResults->getCodeCoverage();
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->classLineResults->isCoverageLessThan($coverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->classLineResults->isCoverageGreaterEqual($coverage);
    }

}

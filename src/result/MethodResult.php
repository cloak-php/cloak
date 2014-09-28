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
use cloak\NamedCoverageResultInterface;
use cloak\value\Coverage;
use Zend\Code\Reflection\MethodReflection;

/**
 * Class MethodResult
 * @package cloak\result
 */
class MethodResult implements NamedCoverageResultInterface
{

    /**
     * @var MethodReflection
     */
    private $methodReflection;

    /**
     * @var LineSet
     */
    private $methodLineResults;


    /**
     * @param MethodReflection $classReflection
     * @param LineSetInterface $methodLineResults
     */
    public function __construct(MethodReflection $methodReflection, LineSetInterface $methodLineResults)
    {
        $lineRange = new LineRange(
            $methodReflection->getStartLine(),
            $methodReflection->getEndLine()
        );
        $rangeResults = $methodLineResults->selectRange($lineRange);

        $this->methodReflection = $methodReflection;
        $this->methodLineResults = $rangeResults;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->methodReflection->getName();
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        $declaringClass = $this->methodReflection->getDeclaringClass();
        return $declaringClass->getNamespaceName();
    }

    /**
     * @return int
     */
    public function getLineCount()
    {
        return $this->methodLineResults->getLineCount();
    }

    /**
     * @return int
     */
    public function getDeadLineCount()
    {
        return $this->methodLineResults->getDeadLineCount();
    }

    /**
     * @return int
     */
    public function getUnusedLineCount()
    {
        return $this->methodLineResults->getUnusedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutedLineCount()
    {
        return $this->methodLineResults->getExecutedLineCount();
    }

    /**
     * @return int
     */
    public function getExecutableLineCount()
    {
        return $this->methodLineResults->getExecutableLineCount();
    }

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage()
    {
        return $this->methodLineResults->getCodeCoverage();
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageLessThan(Coverage $coverage)
    {
        return $this->methodLineResults->isCoverageLessThan($coverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageGreaterEqual(Coverage $coverage)
    {
        return $this->methodLineResults->isCoverageGreaterEqual($coverage);
    }

}

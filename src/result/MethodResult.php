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
use cloak\reflection\MethodReflection;


/**
 * Class MethodResult
 * @package cloak\result
 */
final class MethodResult implements NamedCoverageResultInterface
{

    use CoverageResult;

    /**
     * @var MethodReflection
     */
    private $reflection;


    /**
     * @param MethodReflection $classReflection
     * @param LineSetInterface $methodLineResults
     */
    public function __construct(MethodReflection $methodReflection, LineSetInterface $methodLineResults)
    {
        $rangeResults = $methodReflection->resolveLineResults($methodLineResults);
        $this->reflection = $methodReflection;
        $this->lineResults = $rangeResults;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflection->getName();
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->reflection->getNamespaceName();
    }

}

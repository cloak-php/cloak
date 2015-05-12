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

use cloak\result\collection\CoverageResultCollection;
use cloak\reflection\ClassReflection;


/**
 * Class AbstractTypeResult
 * @package cloak\result
 */
abstract class AbstractTypeResult
{

    use CoverageResult;

    /**
     * @var ClassReflection
     */
    private $reflection;


    /**
     * @param ClassReflection $reflection
     * @param LineResultSelectable $selector
     */
    public function __construct(ClassReflection $reflection, LineResultSelectable $selector)
    {
        $this->reflection = $reflection;
        $this->lineResults = $selector->selectByReflection($this->reflection);
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

    /**
     * @return \cloak\result\CoverageResultNodeCollection
     */
    public function getMethodResults()
    {
        $results = new CoverageResultCollection();
        $methods = $this->reflection->getMethods();

        foreach ($methods as $method) {
            $methodResult = new MethodResult($method, $this->lineResults);
            $results->add($methodResult);
        }

        return $results;
    }

    /**
     * @return bool
     */
    public function hasChildResults()
    {
        $methods = $this->reflection->getMethods();
        return $methods->isEmpty() === false;
    }

    /**
     * @return CoverageResultNodeCollection
     */
    public function getChildResults()
    {
        return $this->getMethodResults();
    }

}

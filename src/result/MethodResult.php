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

use cloak\reflection\MethodReflection;
use cloak\result\collection\CoverageResultCollection;


/**
 * Class MethodResult
 * @package cloak\result
 */
final class MethodResult implements CoverageResultInterface
{

    use CoverageResult;

    /**
     * @var MethodReflection
     */
    private $reflection;


    /**
     * @param MethodReflection $reflection
     * @param LineResultSelectable $selector
     */
    public function __construct(MethodReflection $reflection, LineResultSelectable $selector)
    {
        $this->reflection = $reflection;
        $this->lineResults = $selector->selectByReflection($reflection);
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
     * @return bool
     */
    public function hasChildResults()
    {
        return false;
    }

    /**
     * @return CoverageResultCollectionInterface
     */
    public function getChildResults()
    {
        return new CoverageResultCollection();
    }

}

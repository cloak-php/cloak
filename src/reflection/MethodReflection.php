<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reflection;

use cloak\value\LineRange;
use cloak\result\LineResultCollectionInterface;
use cloak\result\MethodResult;
use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;


/**
 * Class MethodReflection
 * @package cloak\reflection
 */
class MethodReflection implements ReflectionInterface
{

    /**
     * @var \Zend\Code\Reflection\MethodReflection
     */
    private $reflection;


    /**
     * @param $class
     * @param null $name
     */
    public function __construct($class, $name = null)
    {
        $this->reflection = new ZendMethodReflection($class, $name);
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
        $declaringClass = $this->reflection->getDeclaringClass();
        return $declaringClass->getNamespaceName();
    }

    /**
     * @return LineRange
     */
    public function getLineRange()
    {
        $startLine = $this->reflection->getStartLine();
        $endLine = $this->reflection->getEndLine();

        return new LineRange($startLine, $endLine);
    }

    /**
     * @param LineResultCollectionInterface $lineResults
     * @return MethodResult
     */
    public function assembleBy(LineResultCollectionInterface $lineResults)
    {
        return new MethodResult($this, $lineResults);
    }

}

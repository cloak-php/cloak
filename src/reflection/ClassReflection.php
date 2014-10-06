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

use cloak\reflection\collection\ReflectionCollection;
use cloak\value\LineRange;
use cloak\result\LineResultCollectionInterface;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;
use cloak\result\AbstractTypeResultInterface;
use PhpCollection\Sequence;
use Zend\Code\Reflection\ClassReflection as ZendClassReflection;
use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;


/**
 * Class ClassReflection
 * @package cloak\reflection
 */
class ClassReflection implements ReflectionInterface
{

    /**
     * @var \Zend\Code\Reflection\ClassReflection
     */
    private $reflection;


    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->reflection = new ZendClassReflection($className);
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
    public function isTrait()
    {
        return $this->reflection->isTrait();
    }

    /**
     * @return bool
     */
    public function isClass()
    {
        return $this->isTrait() === false;
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
     * @return ReflectionCollection
     */
    public function getMethods()
    {
        $methods = $this->reflection->getMethods();

        $reflections = new Sequence($methods);
        $reflections = $reflections->map(function(ZendMethodReflection $reflection) {
            $class = $reflection->getDeclaringClass()->getName();
            $methodName = $reflection->getName();

            return new MethodReflection($class, $methodName);
        });

        return new ReflectionCollection( $reflections->all() );
    }

    /**
     * @param LineResultCollectionInterface $lineResults
     * @return AbstractTypeResultInterface
     */
    public function assembleBy(LineResultCollectionInterface $lineResults)
    {

        if ($this->isClass()) {
            $result = new ClassResult($this, $lineResults);
        } else {
            $result = new TraitResult($this, $lineResults);
        }

        return $result;
    }

}

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
use PhpCollection\Map;
use Zend\Code\Reflection\ClassReflection as ZendClassReflection;
use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;
use \AppendIterator;
use \ArrayIterator;


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
        $filter = ZendMethodReflection::IS_PUBLIC;
        $methods = $this->reflection->getMethods($filter);

        $reflections = new Sequence($methods);
        $reflections = $reflections->filter(function(ZendMethodReflection $reflection) {
            return $reflection->isUserDefined();
        })->map(function(ZendMethodReflection $reflection) {
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

    /**
     * @return ReflectionCollection
     */
    public function getTraitMethods()
    {
        $reflectionMethods = new AppendIterator;
        $traits = $this->reflection->getTraits();

        foreach ($traits as $trait) {
            $methods = $trait->getMethods(ZendMethodReflection::IS_PUBLIC);
            $reflectionMethods->append(new ArrayIterator($methods));
        }

        $reflections = new ReflectionCollection();

        foreach ($reflectionMethods as $reflectionMethod) {
            $method = new MethodReflection($reflectionMethod->getName());
            $reflections->add($method);
        }

        return $reflections;
    }

    /**
     * @return ReflectionCollection
     */
    public function getTraitAliasMethods()
    {
        $reflectionMethods = [];
        $traitAliasMethods = $this->reflection->getTraitAliases();

        foreach ($traitAliasMethods as $aliasName => $originalName) {
            $reflectionMethods[] = new MethodReflection($originalName);
        }

        return new ReflectionCollection($reflectionMethods);
    }

}

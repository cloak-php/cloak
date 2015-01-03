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
use Zend\Code\Reflection\ClassReflection as ZendClassReflection;
use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;
use \AppendIterator;
use \ArrayIterator;
use \Iterator;


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
    public function getIdentityName()
    {
        $template = '%s\\%s';
        $assembleContent = sprintf(
            $template,
            $this->getNamespaceName(),
            $this->getName()
        );

        return $assembleContent;
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
        $className = $this->reflection->getName();
        $reflection = new \ReflectionClass($className);
        $reflectionMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $selector = new MethodSelector($reflectionMethods);
        $result = $selector->excludeNative()
            ->excludeInherited($className)
            ->excludeTraitMethods($className)
            ->toCollection();

        return $result;
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
        $traitMethods = $this->getTraitAllMethods();
        $traitMethods->merge($this->getTraitAliasMethods());

        return $traitMethods;
    }

    /**
     * @return ReflectionCollection
     */
    public function getTraitAliasMethods()
    {
        $reflectionMethods = [];
        $traitAliasMethods = $this->reflection->getTraitAliases();

        foreach ($traitAliasMethods as $aliasName => $originalName) {
            list($className, $methodName) =  explode('::', $originalName);
            $reflectionMethods[] = new MethodReflection($className, $methodName);
        }

        return new ReflectionCollection($reflectionMethods);
    }

    /**
     * @return ReflectionCollection
     */
    private function getTraitAllMethods()
    {
        $reflectionMethods = new AppendIterator;
        $traits = $this->reflection->getTraits();

        foreach ($traits as $trait) {
            $methods = $trait->getMethods(ZendMethodReflection::IS_PUBLIC);
            $reflectionMethods->append(new ArrayIterator($methods));
        }

        return $this->createCollectionFromIterator($reflectionMethods);
    }

    /**
     * @param Iterator $methods
     * @return ReflectionCollection
     */
    private function createCollectionFromIterator(Iterator $methods)
    {
        $reflections = new ReflectionCollection();

        foreach ($methods as $method) {
            $methodName = $method->getName();
            $className = $method->getDeclaringClass()->getName();

            $reflection = new MethodReflection($className, $methodName);
            $reflections->add($reflection);
        }

        return $reflections;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getIdentityName();
    }

}

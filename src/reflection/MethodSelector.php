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
use PhpCollection\Map;
use \ReflectionMethod;
use \ReflectionClass;
use PhpCollection\Sequence;


/**
 * Class MethodSelector
 * @package cloak\reflection
 */
class MethodSelector
{

    /**
     * @var Sequence
     */
    private $reflections;


    /**
     * @param MethodReflection[] $reflections
     */
    public function __construct(array $reflections)
    {
        $this->reflections = new Sequence($reflections);
    }

    /**
     * @return MethodSelector
     */
    public function excludeNative()
    {
        $callback = function(ReflectionMethod $reflection) {
            return $reflection->isUserDefined();
        };
        $reflections = $this->reflections->filter($callback);

        return new self( $reflections->all() );
    }

    /**
     * @param string $class
     */
    public function excludeInherited($class)
    {
        $callback = function(ReflectionMethod $reflection) use ($class) {
            $declaringClass = $reflection->getDeclaringClass();
            return $declaringClass->isSubclassOf($class);
        };

        $reflections = $this->reflections->filter($callback);

        return new self( $reflections->all() );
    }

    /**
     * @param $class
     * @return MethodSelector
     */
    public function excludeTraitMethods($class)
    {
        $dictionary = $this->getTraitMethods($class);

        $callback = function(ReflectionMethod $reflection) use ($dictionary) {
            $name = $reflection->getName();
            return $dictionary->containsKey($name) === false;
        };

        $reflections = $this->reflections->filter($callback);

        return new self( $reflections->all() );
    }


    /**
     * @param $class
     * @return Map
     */
    private function getTraitMethods($class)
    {
        $traitMethods = $this->getTraitMethodsFromClass($class);

        $reflectionClass = new ReflectionClass($class);
        $traitAliasMethods = $reflectionClass->getTraitAliases();

        foreach ($traitAliasMethods as $aliasName => $originalName) {
            list($className, $methodName) = explode('::', $originalName);
            $traitMethods->remove($methodName);
            $traitMethods->set($aliasName, $reflectionClass->getMethod($aliasName));
        }

        return $traitMethods;
    }

    /**
     * @param $class
     * @return Map
     */
    private function getTraitMethodsFromClass($class)
    {
        $result = new Map();
        $reflectionClass = new ReflectionClass($class);

        foreach ($reflectionClass->getTraits() as $trait) {
            $methods = $this->getMethodsFromTrait($trait);
            $result->addMap($methods);
        }

        return $result;
    }

    /**
     * @param ReflectionClass $trait
     * @return Map
     */
    private function getMethodsFromTrait($trait)
    {
        $result = new Map();
        $methods = $trait->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $name = $method->getName();
            $result->set($name, $method);
        }

        return $result;
    }

    /**
     * @return ReflectionCollection
     */
    public function toCollection()
    {
        $methods = $this->reflections->map(function(ReflectionMethod $method) {
            $className = $method->getDeclaringClass()->getName();
            $methodName = $method->getName();

            return new MethodReflection($className, $methodName);
        });

        return new ReflectionCollection( $methods->all() );
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->reflections->count();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->reflections->isEmpty();
    }

}

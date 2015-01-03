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

    public function excludeTraitMethods($class)
    {
        return $this->excludeTraitAliasMethods($class);
    }


    private function excludeTraitAliasMethods($class)
    {
        $reflectionClass = new ReflectionClass($class);
        $traitAliases = $reflectionClass->getTraitAliases();

        $dictionary = new Map($traitAliases);

        $callback = function(ReflectionMethod $reflection) use ($dictionary) {
            $name = $reflection->getName();
            return $dictionary->containsKey($name) === false;
        };

        $reflections = $this->reflections->filter($callback);

        return new self( $reflections->all() );
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

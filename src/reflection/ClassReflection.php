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
     * @return ReflectionCollection
     */
    public function getMethods()
    {
        $methods = $this->reflection->getMethods();

        $reflections = new Sequence($methods);
        $reflections->map(function(ZendMethodReflection $reflection) {
            $class = $reflection->getDeclaringClass()->getName();
            $methodName = $reflection->getName();

            return new MethodReflection($class, $methodName);
        });

        return new ReflectionCollection($reflections);
    }

}

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

use Zend\Code\Reflection\MethodReflection as ZendMethodReflection;
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
     * @param ZendMethodReflection[] $reflections
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
        $callback = function(ZendMethodReflection $reflection) {
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
        $callback = function(ZendMethodReflection $reflection) use ($class) {
            $declaringClassName = $reflection->getDeclaringClass()->getName();
            return $declaringClassName !== $class;
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

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

}

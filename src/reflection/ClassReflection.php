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

use Zend\Code\Reflection\ClassReflection as ZendClassReflection;

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

    public function getMethods()
    {
    }

}

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

use Zend\Code\Reflection\FileReflection as ZendFileReflection;

/**
 * Class FileReflection
 * @package cloak\reflection
 */
class FileReflection implements ReflectionInterface
{

    /**
     * @var \Zend\Code\Reflection\FileReflection
     */
    private $reflection;


    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->reflection = new ZendFileReflection($filename, true);
    }

    public function getClasses()
    {
    }

    public function getTraits()
    {
    }

}

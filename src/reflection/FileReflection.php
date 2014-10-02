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

use PhpCollection\Sequence;
use cloak\reflection\collection\ReflectionCollection;
use Zend\Code\Reflection\ClassReflection as ZendClassReflection;
use Zend\Code\Reflection\FileReflection as ZendFileReflection;
use Closure;


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

    /**
     * @return ReflectionCollection
     */
    public function getClasses()
    {
        return $this->selectClassReflections(function(ZendClassReflection $reflection) {
            return $reflection->isTrait() === false;
        });
    }

    /**
     * @return ReflectionCollection
     */
    public function getTraits()
    {
        return $this->selectClassReflections(function(ZendClassReflection $reflection) {
            return $reflection->isTrait();
        });
    }

    /**
     * @param callable $filter
     * @return ReflectionCollection
     */
    private function selectClassReflections(Closure $filter)
    {
        $classes = $this->reflection->getClasses();

        $reflections = new Sequence($classes);
        $reflections->filter($filter)
            ->map(function(ZendClassReflection $reflection) {
                return new ClassReflection($reflection);
            });

        return new ReflectionCollection($reflections);
    }

}

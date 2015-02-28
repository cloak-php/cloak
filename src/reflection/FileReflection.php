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
use cloak\result\FileResult;
use cloak\result\LineResultSelectable;
use PhpCollection\Sequence;
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
     * @var LineRange
     */
    private $lineRange;


    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->reflection = new ZendFileReflection($filename, true);

        $content = $this->reflection->getContents(); //$fileReflection->getEndLine() return null....
        $totalLineCount = substr_count(trim($content), PHP_EOL) + 1;

        $this->lineRange = new LineRange(1, $totalLineCount);
    }

    /**
     * @return string
     */
    public function getIdentityName()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->reflection->getFileName();
    }

    /**
     * @return ReflectionCollection
     */
    public function getClasses()
    {
        return $this->selectClassReflections(function(ZendClassReflection $reflection) {
            return $reflection->isTrait();
        });
    }

    /**
     * @return ReflectionCollection
     */
    public function getTraits()
    {
        return $this->selectClassReflections(function(ZendClassReflection $reflection) {
            return $reflection->isTrait() === false;
        });
    }

    /**
     * @return LineRange
     */
    public function getLineRange()
    {
        return $this->lineRange;
    }

    /**
     * @param callable $filter
     * @return ReflectionCollection
     */
    private function selectClassReflections(Closure $filter)
    {
        $classes = $this->reflection->getClasses();

        $excludeInterface = function(ZendClassReflection $reflection) {
            return $reflection->isInterface() === false;
        };

        $createClassReflection = function(ZendClassReflection $reflection) {
            return new ClassReflection($reflection->getName());
        };

        $reflections = new Sequence($classes);
        $reflections = $reflections->filter($filter)
            ->filter($excludeInterface)
            ->map($createClassReflection);

        return new ReflectionCollection( $reflections->all() );
    }

    /**
     * {@inheritdoc}
     */
    public function assembleBy(LineResultSelectable $selector)
    {
        return new FileResult($this->getName(), $selector);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getIdentityName();
    }

}

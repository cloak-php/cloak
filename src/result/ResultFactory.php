<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result;

use cloak\result\collection\NamedResultCollection;
use Zend\Code\Reflection\ClassReflection;
use Zend\Code\Reflection\FileReflection;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;
use \Closure;
use \CallbackFilterIterator;
use \ArrayIterator;


/**
 * Class ResultFactory
 * @package cloak\result
 */
class ResultFactory
{

    /**
     * @var FileReflection
     */
    private $fileReflection;


    /**
     * @param FileReflection $fileReflection
     */
    public function __construct(FileReflection $fileReflection)
    {
        $this->fileReflection = $fileReflection;
    }

    /**
     * @param LineSetInterface $lineCoverages
     * @return NamedResultCollection
     */
    public function createClassResults(LineSetInterface $lineCoverages)
    {
        $reflections = $this->selectClassReflections(function(ClassReflection $class) {
            return $class->isTrait() === false;
        });

        $classResults = new NamedResultCollection();

        foreach ($reflections as $reflection) {
            $classResult = new ClassResult($reflection, $lineCoverages);
            $classResults->add($classResult);
        }

        return $classResults;
    }

    /**
     * @param LineSetInterface $lineCoverages
     * @return NamedResultCollection
     */
    public function createTraitResults(LineSetInterface $lineCoverages)
    {
        $reflections = $this->selectClassReflections(function(ClassReflection $class) {
            return $class->isTrait();
        });

        $traitResults = new NamedResultCollection();

        foreach ($reflections as $reflection) {
            $traitResult = new TraitResult($reflection, $lineCoverages);
            $traitResults->add($traitResult);
        }

        return $traitResults;
    }

    /**
     * @param Closure $filter
     * @return CallbackFilterIterator
     */
    private function selectClassReflections(Closure $filter)
    {
        $classReflections = $this->fileReflection->getClasses();
        $iterator = new ArrayIterator($classReflections);

        return new CallbackFilterIterator($iterator, $filter);
    }

}

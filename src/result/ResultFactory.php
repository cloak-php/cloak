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
use cloak\reflection\FileReflection;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;


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
        $classResults = new NamedResultCollection();
        $reflections = $this->fileReflection->getClasses();

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
        $traitResults = new NamedResultCollection();
        $reflections = $this->fileReflection->getTraits();

        foreach ($reflections as $reflection) {
            $traitResult = new TraitResult($reflection, $lineCoverages);
            $traitResults->add($traitResult);
        }

        return $traitResults;
    }

}

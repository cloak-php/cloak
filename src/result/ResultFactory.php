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

use cloak\result\collection\CoverageResultCollection;
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
     * @param LineResultCollectionInterface $lineCoverages
     * @return CoverageResultCollection
     */
    public function createClassResults(LineResultCollectionInterface $lineCoverages)
    {
        $reflections = $this->fileReflection->getClasses();
        return $reflections->assembleBy($lineCoverages);
    }

    /**
     * @param LineResultCollectionInterface $lineCoverages
     * @return CoverageResultCollection
     */
    public function createTraitResults(LineResultCollectionInterface $lineCoverages)
    {
        $reflections = $this->fileReflection->getTraits();
        return $reflections->assembleBy($lineCoverages);
    }

}

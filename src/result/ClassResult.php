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

use cloak\value\LineRange;
use Zend\Code\Reflection\ClassReflection;

/**
 * Class ClassResult
 * @package cloak\result
 */
class ClassResult
{

    /**
     * @var ClassReflection
     */
    private $classReflection;

    /**
     * @var LineSet
     */
    private $classLineResults;


    /**
     * @param ClassReflection $classReflection
     * @param LineSet $classLineResults
     */
    public function __construct(ClassReflection $classReflection, LineSet $classLineResults)
    {
        $lineRange = new LineRange(
            $classReflection->getStartLine(),
            $classReflection->getEndLine()
        );
        $rangeResults = $classLineResults->selectRange($lineRange);

        $this->classReflection = $classReflection;
        $this->classLineResults = $rangeResults;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->classReflection->getName();
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->classReflection->getNamespaceName();
    }

}

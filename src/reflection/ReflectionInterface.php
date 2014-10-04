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

use cloak\value\LineRange;
use cloak\result\LineSetInterface;
use cloak\result\NamedCoverageResultInterface;


/**
 * Interface ReflectionInterface
 * @package cloak\reflection
 */
interface ReflectionInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return LineRange
     */
    public function getLineRange();

    /**
     * @param LineSetInterface $lineResults
     * @return NamedCoverageResultInterface
     */
    public function assembleBy(LineSetInterface $lineResults);

}

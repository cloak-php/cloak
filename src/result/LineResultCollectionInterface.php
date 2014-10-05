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

use cloak\CoverageResultInterface;
use cloak\value\LineRange;
use cloak\reflection\ReflectionInterface;
use \Iterator;


/**
 * Interface LineResultCollectionInterface
 * @package cloak\result
 */
interface LineResultCollectionInterface extends CoverageResultInterface, Iterator
{

    /**
     * @param LineRange $lineRange
     * @return LineSet
     */
    public function selectRange(LineRange $lineRange);

    /**
     * @param ReflectionInterface $reflection
     * @return LineResultCollectionInterface
     */
    public function resolveLineResults(ReflectionInterface $reflection);

}

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

use cloak\reflection\ReflectionInterface;


/**
 * Interface LineResultResolverInterface
 * @package cloak\result
 */
interface LineResultResolverInterface
{

    /**
     * @param ReflectionInterface $reflection
     * @return LineResultCollectionInterface
     */
    public function resolveLineResults(ReflectionInterface $reflection);

}

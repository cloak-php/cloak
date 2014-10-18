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

use cloak\CollectionInterface as CommonCollectionInterface;
use cloak\CoverageResultInterface;

/**
 * Interface NamedResultCollectionInterface
 * @package cloak\result
 */
interface NamedResultCollectionInterface extends CommonCollectionInterface
{

    /**
     * @param \cloak\result\CoverageResultInterface $result
     */
    public function add(CoverageResultInterface $result);

    /**
     * @param NamedResultCollectionInterface $results
     * @return NamedResultCollectionInterface
     */
    public function merge(NamedResultCollectionInterface $results);

}

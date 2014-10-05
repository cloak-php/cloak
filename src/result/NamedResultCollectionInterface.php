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

/**
 * Interface NamedResultCollectionInterface
 * @package cloak\result
 */
interface NamedResultCollectionInterface extends CommonCollectionInterface
{

    /**
     * @param \cloak\result\NamedCoverageResultInterface $result
     */
    public function add(NamedCoverageResultInterface $result);

    /**
     * @param NamedResultCollectionInterface $results
     * @return NamedResultCollectionInterface
     */
    public function merge(NamedResultCollectionInterface $results);

}

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
 * Interface CoverageResultCollectionInterface
 * @package cloak\result
 */
interface CoverageResultCollectionInterface extends CommonCollectionInterface
{

    /**
     * @param \cloak\result\CoverageResultInterface $result
     */
    public function add(CoverageResultInterface $result);

    /**
     * @param CoverageResultCollectionInterface $results
     * @return CoverageResultCollectionInterface
     */
    public function merge(CoverageResultCollectionInterface $results);

}

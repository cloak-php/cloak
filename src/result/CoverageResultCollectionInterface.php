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
use cloak\value\Coverage;


/**
 * Interface CoverageResultCollectionInterface
 * @package cloak\result
 */
interface CoverageResultCollectionInterface extends CommonCollectionInterface
{

    /**
     * @param \cloak\result\CoverageResultNode $result
     */
    public function add(CoverageResultNode $result);

    /**
     * @param CoverageResultCollectionInterface $results
     * @return CoverageResultCollectionInterface
     */
    public function merge(CoverageResultCollectionInterface $results);

    /**
     * @param CoverageResultCollectionInterface $excludeResults
     * @return CoverageResultCollectionInterface
     */
    public function exclude(CoverageResultCollectionInterface $excludeResults);

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollectionInterface
     */
    public function selectByCoverageLessThan(Coverage $coverage);

    /**
     * @param Coverage $coverage
     * @return CoverageResultCollectionInterface
     */
    public function selectByCoverageGreaterEqual(Coverage $coverage);

}

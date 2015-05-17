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

use cloak\Collection;
use cloak\value\Coverage;


/**
 * Interface CoverageResultNodeCollection
 * @package cloak\result
 */
interface CoverageResultNodeCollection extends Collection
{

    /**
     * @param \cloak\result\CoverageResultNode $result
     */
    public function add(CoverageResultNode $result);

    /**
     * @param CoverageResultNodeCollection $results
     * @return CoverageResultNodeCollection
     */
    public function merge(CoverageResultNodeCollection $results);

    /**
     * @param CoverageResultNodeCollection $excludeResults
     * @return CoverageResultNodeCollection
     */
    public function exclude(CoverageResultNodeCollection $excludeResults);

    /**
     * @param Coverage $coverage
     * @return CoverageResultNodeCollection
     */
    public function selectByCoverageLessThan(Coverage $coverage);

    /**
     * @param Coverage $coverage
     * @return CoverageResultNodeCollection
     */
    public function selectByCoverageGreaterEqual(Coverage $coverage);

}

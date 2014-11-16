<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\value;

/**
 * Class CoverageBound
 * @package cloak\value
 */
class CoverageBound
{

    /**
     * @var Coverage
     */
    private $highCoverageBound;

    /**
     * @var Coverage
     */
    private $lowCoverageBound;


    /**
     * @param float $lowCoverageBound
     * @param float $highCoverageBound
     */
    public function __construct($lowCoverageBound, $highCoverageBound)
    {
        $this->lowCoverageBound = new Coverage($lowCoverageBound);
        $this->highCoverageBound = new Coverage($highCoverageBound);
    }

    /**
     * @return Coverage
     */
    public function getLowCoverageBound()
    {
        return $this->lowCoverageBound;
    }

    /**
     * @return Coverage
     */
    public function getHighCoverageBound()
    {
        return $this->highCoverageBound;
    }

    public function isHighBoundGreaterThan(Coverage $coverage)
    {
        return $coverage->greaterEqual($this->getHighCoverageBound());
    }

    public function isLowBoundLessThan(Coverage $coverage)
    {
        return $coverage->lessThan($this->getLowCoverageBound());
    }

}

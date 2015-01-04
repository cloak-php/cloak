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
    private $satisfactoryCoverage;

    /**
     * @var Coverage
     */
    private $criticalCoverage;


    /**
     * @param float $critical
     * @param float $satisfactory
     */
    public function __construct($critical, $satisfactory)
    {
        $this->criticalCoverage = new Coverage($critical);
        $this->satisfactoryCoverage = new Coverage($satisfactory);
    }

    /**
     * @return Coverage
     */
    public function getCriticalCoverage()
    {
        return $this->criticalCoverage;
    }

    /**
     * @return Coverage
     */
    public function getSatisfactoryCoverage()
    {
        return $this->satisfactoryCoverage;
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isSatisfactory(Coverage $coverage)
    {
        $satisfactoryCoverage = $this->getSatisfactoryCoverage();
        return $coverage->greaterEqual($satisfactoryCoverage);
    }

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCritical(Coverage $coverage)
    {
        $criticalCoverage = $this->getCriticalCoverage();
        return $coverage->lessThan($criticalCoverage);
    }

}

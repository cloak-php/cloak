<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\result\specification;

use cloak\result\SpecificationInterface;
use cloak\result\CoverageResultInterface;


/**
 * Class Critical
 * @package cloak\result\specification
 */
class Critical extends CoverageSpecification implements SpecificationInterface
{

    /**
     * {@inheritdoc}
     */
    public function match(CoverageResultInterface $coverageResult)
    {
        return $coverageResult->isCoverageLessThan($this->coverage);
    }

}
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


use cloak\value\Coverage;
use cloak\result\SpecificationInterface;


/**
 * Class CoverageSpecification
 * @package cloak\result\specification
 */
abstract class CoverageSpecification implements SpecificationInterface
{

    /**
     * @var Coverage
     */
    protected $coverage;


    /**
     * @param float $value
     */
    public function __construct($value)
    {
        $this->coverage = new Coverage($value);
    }

    /**
     * @param Coverage $coverage
     * @return \cloak\result\specification\SpecificationInterface
     */
    public static function createFromCoverage(Coverage $coverage)
    {
        $value = $coverage->value();
        return new static($value);
    }

}

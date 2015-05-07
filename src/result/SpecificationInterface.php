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


/**
 * Interface SpecificationInterface
 * @package cloak\result
 */
interface SpecificationInterface
{

    /**
     * @param CoverageResultNode $coverageResult
     * @return bool
     */
    public function match(CoverageResultNode $coverageResult);

}

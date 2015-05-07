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

use cloak\value\Coverage;

/**
 * Interface CodeCoverageResult
 * @package cloak
 */
interface CodeCoverageResult
{

    /**
     * @return Coverage The value of code coverage
     */
    public function getCodeCoverage();

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageLessThan(Coverage $coverage);

    /**
     * @param Coverage $coverage
     * @return bool
     */
    public function isCoverageGreaterEqual(Coverage $coverage);

}

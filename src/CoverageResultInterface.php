<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use cloak\value\Coverage;

/***
 * Class CoverageResultInterface
 * @package cloak\result
 */
interface CoverageResultInterface
{

    /**
     * @return int
     */
    public function getLineCount();

    /**
     * @return int
     */
    public function getDeadLineCount();

    /**
     * @return int
     */
    public function getUnusedLineCount();

    /**
     * @return int
     */
    public function getExecutedLineCount();

    /**
     * @return int
     */
    public function getExecutableLineCount();

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

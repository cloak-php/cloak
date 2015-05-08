<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\writer;

use cloak\result\CoverageResultNode;

/**
 * Interface ResultWriter
 * @package cloak\writer
 */
interface ResultWriter extends StdoutWriter
{

    /**
     * @param CoverageResultNode $result
     */
    public function writeResult(CoverageResultNode $result);

}

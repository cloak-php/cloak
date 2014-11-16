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

use cloak\result\CoverageResultInterface;

/**
 * Interface ConsoleWriter
 * @package cloak\writer
 */
interface ConsoleWriterInterface extends WriterInterface
{

    /**
     * @param CoverageResultInterface $result
     */
    public function writeResult(CoverageResultInterface $result);

}

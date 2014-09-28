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

use cloak\CoverageResultInterface;

/**
 * Interface NamedCoverageResultInterface
 * @package cloak\result
 */
interface NamedCoverageResultInterface extends CoverageResultInterface
{

    /**
     * @return string
     */
    public function getName();

}

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\report\factory;

use cloak\Result;

/**
 * Interface ReportFactoryInterface
 * @package cloak\report\factory
 */
interface ReportFactoryInterface
{

    /**
     * @param Result $result
     * @return \cloak\report\ReportInterface
     */
    public function createFromResult(Result $result);

}

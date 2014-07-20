<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

/**
 * Interface DriverDetectorInterface
 * @package cloak
 */
interface DriverDetectorInterface
{

    /**
     * @return \cloak\driver\DriverInterface
     * @throws \cloak\DriverNotFoundException
     */
    public function detect();

}

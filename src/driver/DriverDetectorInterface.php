<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\driver;

/**
 * Interface DriverDetectorInterface
 * @package cloak\driver
 */
interface DriverDetectorInterface
{

    /**
     * @return \cloak\driver\DriverInterface
     * @throws \cloak\driver\DriverNotFoundException
     */
    public function detect();

}

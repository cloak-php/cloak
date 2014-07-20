<?php

/**
 * This file is part of easy-coverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage\driver;

interface DriverInterface
{

    /**
     * @return void
     */
    public function start();

    /**
     * @return void
     */
    public function stop();

    /**
     * @return boolean
     */
    public function isStarted();

    /**
     * @return array
     */
    public function getResult();

}

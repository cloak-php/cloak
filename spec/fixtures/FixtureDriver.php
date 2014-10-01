<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\spec\driver;

use cloak\driver\DriverInterface;
use cloak\driver\DriverNotAvailableException;

class FixtureDriver implements DriverInterface
{

    public function __construct()
    {
        throw new DriverNotAvailableException();
    }

    public function start()
    {
    }

    public function stop()
    {
    }

    public function isStarted()
    {
    }

    public function getAnalyzeResult()
    {
    }

}

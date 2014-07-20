<?php

namespace easycoverage\Spec\Driver;

use easycoverage\Driver\DriverInterface;
use easycoverage\Driver\DriverNotAvailableException;

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

    public function getResult()
    {
    }

}

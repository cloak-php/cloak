<?php

namespace easycoverage\spec\driver;

use easycoverage\driver\DriverInterface;
use easycoverage\driver\DriverNotAvailableException;

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

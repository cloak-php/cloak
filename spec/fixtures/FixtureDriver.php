<?php

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

    public function getResult()
    {
    }

}

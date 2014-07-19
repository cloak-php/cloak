<?php

namespace CodeAnalyzer\Spec\Driver;

use CodeAnalyzer\Driver\DriverInterface;
use CodeAnalyzer\Driver\DriverNotAvailableException;

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

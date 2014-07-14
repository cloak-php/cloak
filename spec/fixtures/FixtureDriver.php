<?php

namespace CodeAnalyzer\Spec\Driver;

use CodeAnalyzer\Driver\DriverInterface;
use Exception;

class FixtureDriver implements DriverInterface
{

    public function __construct()
    {
        throw new Exception();
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

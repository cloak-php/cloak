<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer;

use CodeAnalyzer\Driver\DriverInterface;
use CodeAnalyzer\Driver\XdebugDriver;

class Analyzer
{

    protected static $configuration = null;

    protected $driver = null;
    protected $analyzeResult = null;

    public function __construct(DriverInterface $driver = null)
    {
        $this->driver = ($driver === null) ? new XdebugDriver() : $driver;
    }

    public static function configure(\Closure $configurator)
    {
        if (static::$configuration === null) {
            static::$configuration = new Configuration;
        }
        $configurator(static::$configuration);
    }

    public function start()
    {
        $this->driver->start();
    }

    public function stop()
    {
        $this->driver->stop();

        $configuration = static::$configuration;
        $analyzeResult = $this->driver->getResult();

        $this->analyzeResult = $configuration->apply( Result::from($analyzeResult) );
    }

    public function isStarted()
    {
        return $this->driver->isStarted();
    }

    public function getResult()
    {
        return $this->analyzeResult;
    }

}

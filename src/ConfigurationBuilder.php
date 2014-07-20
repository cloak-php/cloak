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

use cloak\driver\DriverInterface;
use cloak\reporter\ReporterInterface;

/**
 * Class ConfigurationBuilder
 * @package cloak
 */
class ConfigurationBuilder
{

    private $driver = null;
    private $reporter = null;
    private $includeFiles = array();
    private $excludeFiles = array();

    public function driver(DriverInterface $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    public function reporter(ReporterInterface $reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

    public function includeFile(\Closure $filter)
    {
        $this->includeFiles[] = $filter;
        return $this;
    }

    public function excludeFile(\Closure $filter)
    {
        $this->excludeFiles[] = $filter;
        return $this;
    }

    public function includeFiles(array $filters)
    {
        foreach ($filters as $filter) {
            $this->includeFile($filter);
        }
        return $this;
    }

    public function excludeFiles(array $filters)
    {
        foreach ($filters as $filter) {
            $this->excludeFile($filter);
        }
        return $this;
    }

    protected function detectDriver()
    {
        if ($this->driver instanceof DriverInterface) {
            return;
        }

        $driverDetector = new DriverDetector([
            '\cloak\driver\XdebugDriver',
            '\cloak\driver\HHVMDriver'
        ]);
        $driver = $driverDetector->detect();

        $this->driver = $driver;
    }

    public function build()
    {
        $this->detectDriver();

        $values = [
            'driver' => $this->driver,
            'reporter' => $this->reporter,
            'includeFiles' => $this->includeFiles,
            'excludeFiles' => $this->excludeFiles
        ];

        return new Configuration($values);
    }

    public function __set($name, $value)
    {
        return call_user_func_array(array($this, $name), [$value]);
    }

    public function __get($name)
    {
        return $this->$name;
    }

}

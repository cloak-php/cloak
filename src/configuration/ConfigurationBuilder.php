<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration;

use cloak\Configuration;
use cloak\driver\DriverDetector;
use cloak\driver\DriverInterface;
use cloak\reporter\ReporterInterface;


/**
 * Class ConfigurationBuilder
 * @package cloak\configuration
 */
class ConfigurationBuilder
{

    private $driver;
    private $reporter;
    private $includeFiles;
    private $excludeFiles;

    public function __construct()
    {
        $this->includeFiles = [];
        $this->excludeFiles = [];
    }

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

    /**
     * @param string $pattern
     * @return $this
     */
    public function includeFile($pattern)
    {
        $this->includeFiles[] = $pattern;
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function excludeFile($pattern)
    {
        $this->excludeFiles[] = $pattern;
        return $this;
    }

    /**
     * @param string[] $patterns
     * @return $this
     */
    public function includeFiles(array $patterns)
    {
        foreach ($patterns as $pattern) {
            $this->includeFile($pattern);
        }
        return $this;
    }

    /**
     * @param string[] $patterns
     * @return $this
     */
    public function excludeFiles(array $patterns)
    {
        foreach ($patterns as $pattern) {
            $this->excludeFile($pattern);
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

    public function __get($name)
    {
        return $this->$name;
    }

}

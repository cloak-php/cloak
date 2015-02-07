<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use cloak\Result;
use cloak\driver\Result as AnalyzeResult;
use cloak\driver\XdebugDriver;
use \InvalidArgumentException;

/**
 * Class Configuration
 * @package cloak
 * @property-read \cloak\driver\DriverInterface $driver
 * @property-read \cloak\reporter\ReporterInterface $reporter
 * @property-read \Closure[] $includeFiles
 * @property-read \Closure[] $excludeFiles
 */
class Configuration
{

    /**
     * @var \cloak\driver\DriverInterface
     */
    private $driver;

    /**
     * @var \cloak\reporter\ReporterInterface
     */
    private $reporter;

    /**
     * @var \Closure[]
     */
    private $includeFiles = [];

    /**
     * @var \Closure[]
     */
    private $excludeFiles = [];


    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) === false) {
                throw new InvalidArgumentException("Property that does not exist {$key}");
            }
            $this->$key = $value;
        }
    }

    /**
     * @return XdebugDriver|null
     */
    public function getDriver()
    {
        $this->driver = $this->driver ? $this->driver : new XdebugDriver();
        return $this->driver;
    }

    /**
     * @return reporter\ReporterInterface
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @return \Closure[]
     */
    public function getIncludeFiles()
    {
        return $this->includeFiles;
    }

    /**
     * @return \Closure[]
     */
    public function getExcludeFiles()
    {
        return $this->excludeFiles;
    }

    /**
     * @param \cloak\driver\Result $result
     * @return \cloak\driver\Result
     */
    public function applyTo(AnalyzeResult $result)
    {
        return $result->includeFiles($this->includeFiles)
            ->excludeFiles($this->excludeFiles);
    }

}

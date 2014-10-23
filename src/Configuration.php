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
     * @var array
     */
    private $includeFiles = [];

    /**
     * @var array
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
    protected function getDriver()
    {
        $this->driver = $this->driver ? $this->driver : new XdebugDriver();
        return $this->driver;
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

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $getter = 'get' . ucwords($name);

        if (method_exists($this, $getter) === true) {
            return $this->$getter();
        }
        return $this->$name;
    }

}

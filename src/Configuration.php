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

use cloak\Result;
use cloak\driver\XdebugDriver;

/**
 * Class Configuration
 * @package cloak
 */
class Configuration
{

    private $driver = null;
    private $reporter = null;
    private $includeFiles = array();
    private $excludeFiles = array();

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) === false) {
                continue;
            }
            $this->$key = $value;
        }
    }

    protected function getDriver()
    {
        if ($this->driver === null) {
            $this->driver = new XdebugDriver();
        }
        return $this->driver;
    }

    public function apply(Result $result)
    {

        return $result->includeFiles($this->includeFiles)
            ->excludeFiles($this->excludeFiles);

    }

    public function __get($name)
    {
        $getter = 'get' . ucwords($name);

        if (method_exists($this, $getter) === true) {
            return $this->$getter();
        }
        return $this->$name;
    }

}

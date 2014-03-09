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

use CodeAnalyzer\Result;

class Configuration
{

    private $driver = null;
    private $reporter = null;
    private $includeFiles = array();
    private $excludeFiles = array();

    public function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) === false) {
                continue;
            }
            $this->$key = $value;
        }
    }

    public function apply(Result $result)
    {

        return $result->includeFiles($this->includeFiles)
            ->excludeFiles($this->excludeFiles);

    }

    public function __get($name)
    {
        return $this->$name;
    }

}

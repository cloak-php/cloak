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

use CodeAnalyzer\Configuration;

class ConfigurationBuilder
{

    private $includeFiles = array();
    private $excludeFiles = array();

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

    public function build()
    {
        $values = array(
            'includeFiles' => $this->includeFiles,
            'excludeFiles' => $this->excludeFiles
        );

        return new Configuration($values);
    }

    public function __set($name, $value)
    {
        return call_user_method(array($this, $name), $value);
    }

    public function __get($name)
    {
        return $this->$name;
    }

}

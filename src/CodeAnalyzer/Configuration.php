<?php

namespace CodeAnalyzer;

class Configuration
{

    private $collect = null;
    private $includeFiles = array();
    private $excludeFiles = array();

    public function __construct()
    {
        $this->collect = XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE;
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

    public function __get($name)
    {
        return $this->$name;
    }

}

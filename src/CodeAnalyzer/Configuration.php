<?php

namespace CodeAnalyzer;

use CodeAnalyzer\Result;

class Configuration
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

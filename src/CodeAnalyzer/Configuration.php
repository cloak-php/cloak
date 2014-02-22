<?php

namespace CodeAnalyzer;

class Configuration
{

    private $collect = null;

    public function __construct()
    {
        $this->collect = XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE;
    }

    public function collect($collect = null)
    {
        if (is_null($collect)) {
            return $this->collect;
        }
        return $this;
    }

    public function includeFile(\Closure $filter)
    {
        return $this;
    }

    public function excludeFile(\Closure $filter)
    {
        return $this;
    }

}

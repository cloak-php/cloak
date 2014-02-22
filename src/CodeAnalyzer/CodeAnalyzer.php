<?php

namespace CodeAnalyzer;

class CodeAnalyzer
{

    protected static $configuration;

    public static function getConfiguration()
    {
        if (static::$configuration === null) {
            static::$configuration = new Configuration;
        }
        return static::$configuration;
    }

    public static function configure(\Closure $configurator)
    {
        $configurator(static::getConfiguration());
    }

}

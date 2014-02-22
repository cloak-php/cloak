<?php

namespace CodeAnalyzer;

class CodeAnalyzer
{

    protected static $configuration = null;

    protected $started = false;

    public static function configure(\Closure $configurator)
    {
        if (static::$configuration === null) {
            static::$configuration = new Configuration;
        }
        $configurator(static::$configuration);
    }

    public function start()
    {
        \xdebug_start_code_coverage();
        $this->started = true;
    }

    public function stop()
    {
        \xdebug_stop_code_coverage();
        $this->started = false;
    }

    public function isStarted()
    {
        return $this->started;
    }

}

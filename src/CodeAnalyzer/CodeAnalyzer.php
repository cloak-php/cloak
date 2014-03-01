<?php

namespace CodeAnalyzer;

class CodeAnalyzer
{

    protected static $configuration = null;

    protected $started = false;
    protected $analyzeResult = null;

    public static function configure(\Closure $configurator)
    {
        if (static::$configuration === null) {
            static::$configuration = new Configuration;
        }
        $configurator(static::$configuration);
    }

    public function start()
    {
        xdebug_start_code_coverage();
        $this->started = true;
    }

    public function stop()
    {
        $result = xdebug_get_code_coverage();
        $this->analyzeResult = Result::from($result);

        xdebug_stop_code_coverage();

        $this->started = false;
    }

    public function isStarted()
    {
        return $this->started;
    }

    public function getResult()
    {
        return $this->analyzeResult;
    }

}

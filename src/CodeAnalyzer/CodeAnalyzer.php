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
        xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);
        $this->started = true;
    }

    public function stop()
    {
        $result = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();

        $configuration = static::$configuration;

        //FIXME Would like to have in Configration a method to apply a filter
        //ex) $configuration->applyTo(Result);
        $this->analyzeResult = Result::from($result)
            ->includeFiles($configuration->includeFiles)
            ->excludeFiles($configuration->excludeFiles);

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

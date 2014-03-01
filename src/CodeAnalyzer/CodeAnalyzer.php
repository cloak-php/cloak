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

        $configuration = static::$configuration;
        $includeFiles = $configuration->includeFile();
        $excludeFiles = $configuration->excludeFile();

        $this->analyzeResult = Result::from($result);

        if (is_null($includeFiles) === false) {
            foreach ($includeFiles as $filter) {
                $this->analyzeResult = $this->analyzeResult->includeFile($filter);
            }
        }

        if (is_null($excludeFiles) === false) {
            foreach ($excludeFiles as $filter) {
                $this->analyzeResult = $this->analyzeResult->excludeFile($filter);
            }
        }

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

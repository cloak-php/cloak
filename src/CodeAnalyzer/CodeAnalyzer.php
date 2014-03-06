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
        $configuration = static::$configuration;
        xdebug_start_code_coverage($configuration->collect);
        $this->started = true;
    }

    public function stop()
    {
        $result = xdebug_get_code_coverage();
        xdebug_stop_code_coverage();

        $configuration = static::$configuration;
        $includeFiles = $configuration->includeFiles;
        $excludeFiles = $configuration->excludeFiles;

        $this->analyzeResult = Result::from($result);

        if (empty($includeFiles) === false) {
            $this->analyzeResult = $this->analyzeResult->includeFiles($includeFiles);
        }

        if (empty($excludeFiles) === false) {
            foreach ($excludeFiles as $filter) {
                $this->analyzeResult = $this->analyzeResult->excludeFile($filter);
            }
        }

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

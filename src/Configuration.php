<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak;

use cloak\Result;
use cloak\driver\Result as AnalyzeResult;
use cloak\driver\result\FileResult;
use cloak\driver\XdebugDriver;
use \InvalidArgumentException;


/**
 * Class Configuration
 * @package cloak
 */
class Configuration
{

    /**
     * @var \cloak\driver\DriverInterface
     */
    private $driver;

    /**
     * @var \cloak\reporter\ReporterInterface
     */
    private $reporter;

    /**
     * @var string[]
     */
    private $includeFiles = [];

    /**
     * @var string[]
     */
    private $excludeFiles = [];

    /**
     * @var \cloak\value\CoverageBounds
     */
    private $coverageBounds;

    /**
     * @var string
     */
    private $reportDirectory;


    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            if (property_exists($this, $key) === false) {
                throw new InvalidArgumentException("Property that does not exist {$key}");
            }
            $this->$key = $value;
        }
    }

    /**
     * @return XdebugDriver|null
     */
    public function getDriver()
    {
        $this->driver = $this->driver ? $this->driver : new XdebugDriver();
        return $this->driver;
    }

    /**
     * @return reporter\ReporterInterface
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @return string[]
     */
    public function getIncludeFiles()
    {
        return $this->includeFiles;
    }

    /**
     * @return string[]
     */
    public function getExcludeFiles()
    {
        return $this->excludeFiles;
    }

    /**
     * @return value\CoverageBounds
     */
    public function getCoverageBounds()
    {
        return $this->coverageBounds;
    }

    /**
     * @return string
     */
    public function getReportDirectory()
    {
        return $this->reportDirectory;
    }

    /**
     * @param \cloak\driver\Result $result
     * @return \cloak\driver\Result
     */
    public function applyTo(AnalyzeResult $result)
    {
        $includeCallback = $this->createCallback($this->includeFiles);
        $excludeCallback = $this->createCallback($this->excludeFiles);

        return $result->includeFile($includeCallback)
            ->excludeFile($excludeCallback);
    }


    /**
     * @param string[] $patterns
     * @return callable
     */
    private function createCallback(array $patterns)
    {
        $filterCallback = function (FileResult $file) use ($patterns) {
            return $file->matchPaths($patterns);
        };

        return $filterCallback;
    }

}

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\configuration;

use cloak\AnalyzerConfiguration;
use cloak\value\CoverageBounds;
use cloak\analyzer\Analyzer;
use cloak\analyzer\AnalyzeDriver;
use cloak\analyzer\AdapterResolver;
use cloak\reporter\Reporter;


/**
 * Class ConfigurationBuilder
 * @package cloak\configuration
 */
class ConfigurationBuilder
{

    /**
     * @var \cloak\analyzer\AnalyzeDriver
     */
    private $driver;

    /**
     * @var \cloak\reporter\Reporter
     */
    private $reporter;

    /**
     * @var string[]
     */
    private $includeFiles;

    /**
     * @var string[]
     */
    private $excludeFiles;

    /**
     * @var \cloak\value\CoverageBounds
     */
    private $coverageBounds;

    /**
     * @var string
     */
    private $reportDirectory;


    public function __construct()
    {
        $this->includeFiles = [];
        $this->excludeFiles = [];
    }

    /**
     * @param AnalyzeDriver $driver
     * @return $this
     */
    public function driver(AnalyzeDriver $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @param Reporter $reporter
     * @return $this
     */
    public function reporter(Reporter $reporter)
    {
        $this->reporter = $reporter;
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function includeFile($pattern)
    {
        $this->includeFiles[] = $pattern;
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function excludeFile($pattern)
    {
        $this->excludeFiles[] = $pattern;
        return $this;
    }

    /**
     * @param string[] $patterns
     * @return $this
     */
    public function includeFiles(array $patterns)
    {
        foreach ($patterns as $pattern) {
            $this->includeFile($pattern);
        }
        return $this;
    }

    /**
     * @param string[] $patterns
     * @return $this
     */
    public function excludeFiles(array $patterns)
    {
        foreach ($patterns as $pattern) {
            $this->excludeFile($pattern);
        }
        return $this;
    }

    /**
     * @param string $directoryPath
     * @return $this
     */
    public function reportDirectory($directoryPath)
    {
        $this->reportDirectory = $directoryPath;
        return $this;
    }

    /**
     * @param float $critical
     * @param float $satisfactory
     * @return $this
     */
    public function coverageBounds($critical, $satisfactory)
    {
        $this->coverageBounds = new CoverageBounds($critical, $satisfactory);
        return $this;
    }

    protected function detectDriver()
    {
        if ($this->driver instanceof AnalyzeDriver) {
            return;
        }

        $resolver = new AdapterResolver([
            '\cloak\analyzer\adapter\XdebugAdapter',
            '\cloak\analyzer\adapter\HHVMAdapter'
        ]);
        $adapter = $resolver->resolve();

        $this->driver = new Analyzer($adapter);
    }

    /**
     * @return AnalyzeDriver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return Reporter
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
     * @return CoverageBounds
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
     * @return AnalyzerConfiguration
     */
    public function build()
    {
        $this->detectDriver();

        $values = [
            'driver' => $this->driver,
            'reporter' => $this->reporter,
            'includeFiles' => $this->includeFiles,
            'excludeFiles' => $this->excludeFiles,
            'coverageBounds' => $this->coverageBounds,
            'reportDirectory' => $this->reportDirectory
        ];

        return new AnalyzerConfiguration($values);
    }

}

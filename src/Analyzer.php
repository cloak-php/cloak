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

use cloak\ProvidesLifeCycleNotifier;

/**
 * Class Analyzer
 * @package cloak
 */
class Analyzer implements AnalyzeLifeCycleNotifierAwareInterface, AnalyzeLifeCycleInterface
{

    use ProvidesLifeCycleNotifier;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Result
     */
    protected $analyzeResult;


    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->init($configuration);
    }

    /**
     * @param \Closure $configurator
     * @return Analyzer
     */
    public static function factory(\Closure $configurator)
    {
        $builder = new ConfigurationBuilder();
        $configurator($builder);
        $configuration = $builder->build();

        return new Analyzer($configuration);
    }

    public function start()
    {
        $this->driver()->start();
    }

    public function stop()
    {
        $this->driver()->stop();
        $this->getLifeCycleNotifier()->stop( $this->getResult() );
    }

    /**
     * @return bool
     */
    public function isStarted()
    {
        return $this->driver()->isStarted();
    }

    /**
     * @return Result
     */
    public function getResult()
    {
        $analyzeResult = $this->driver()->getResult();
        return $this->configuration->apply( Result::from($analyzeResult) );
    }

    /**
     * @return \cloak\driver\DriverInterface
     */
    protected function driver()
    {
        return $this->configuration->driver;
    }

    /**
     * @param Configuration $configuration
     */
    protected function init(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->setLifeCycleNotifier( new AnalyzeLifeCycleNotifier($configuration->reporter) );
    }

}

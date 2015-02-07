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

use cloak\configuration\ConfigurationBuilder;


/**
 * Class Analyzer
 * @package cloak
 */
class Analyzer implements AnalyzeLifeCycleNotifierAwareInterface, AnalyzerInterface
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

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->getLifeCycleNotifier()->notifyStart();
        $this->getDriver()->start();
    }

    /**
     * {@inheritdoc}
     */
    public function stop()
    {
        $this->getDriver()->stop();
        $this->getLifeCycleNotifier()->notifyStop( $this->getResult() );
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->getDriver()->isStarted();
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        $analyzeResult = $this->getDriver()->getAnalyzeResult();
        $analyzeResult = $this->configuration->applyTo($analyzeResult);
        return Result::fromAnalyzeResult($analyzeResult);
    }

    /**
     * @return \cloak\driver\DriverInterface
     */
    protected function getDriver()
    {
        return $this->configuration->getDriver();
    }

    /**
     * @param Configuration $configuration
     */
    protected function init(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $reporter = $configuration->getReporter();
        $this->setLifeCycleNotifier( new AnalyzeLifeCycleNotifier($reporter) );
    }

}

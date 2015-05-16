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


/**
 * Class CoverageAnalyzer
 * @package cloak
 */
class CoverageAnalyzer implements AnalyzeLifeCycleNotifierAware, ReportableAnalyzer
{

    use ProvidesLifeCycleNotifier;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var Result
     */
    protected $analyzeResult;


    /**
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->init($config);
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
        $analyzeResult = $this->config->applyTo($analyzeResult);
        return Result::fromAnalyzeResult($analyzeResult);
    }

    /**
     * @return \cloak\analyzer\AnalyzeDriver
     */
    protected function getDriver()
    {
        $driver = $this->config->getDriver();
        return $driver;
    }

    /**
     * @param Configuration $config
     */
    protected function init(Configuration $config)
    {
        $this->config = $config;
        $reporter = $config->getReporter();
        $this->setLifeCycleNotifier( new AnalyzeLifeCycleNotifier($reporter) );
        $this->getLifeCycleNotifier()->notifyInitialize($this->config);
    }

}

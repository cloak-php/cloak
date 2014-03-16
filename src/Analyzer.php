<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer;

use CodeAnalyzer\Driver\DriverInterface,
    CodeAnalyzer\Driver\XdebugDriver,
    CodeAnalyzer\ConfigurationBuilder,
    CodeAnalyzer\Configuration,
    CodeAnalyzer\Notifier,
    CodeAnalyzer\NotifierAwareInterface,
    CodeAnalyzer\ProvidesNotifier;

class Analyzer implements NotifierAwareInterface
{

    use ProvidesNotifier;

    protected $configuration = null;
    protected $analyzeResult = null;

    public function __construct(Configuration $configuration)
    {
        $this->init($configuration);
    }

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
        $this->getNotifier()->stop( $this->getResult() );
    }

    public function isStarted()
    {
        return $this->driver()->isStarted();
    }

    public function getResult()
    {
        $analyzeResult = $this->driver()->getResult();
        return  $this->configuration->apply( Result::from($analyzeResult) );
    }

    protected function driver()
    {
        return $this->configuration->driver;
    }

    protected function init(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->setNotifier( new Notifier($configuration->reporter) );
    }

}

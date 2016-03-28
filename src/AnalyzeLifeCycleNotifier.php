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

use cloak\AnalyzedCoverageResult;
use cloak\AnalyzerConfiguration;
use cloak\Reporter\Reporter;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use PHPExtra\EventManager\EventManager;


/**
 * Class AnalyzeLifeCycleNotifier
 * @package cloak
 */
class AnalyzeLifeCycleNotifier implements LifeCycleNotifier
{

    /**
     * @var \PHPExtra\EventManager\EventManager
     */
    private $manager;

    /**
     * @param Reporter $reporter
     */
    public function __construct(Reporter $reporter = null)
    {
        $eventManager = new EventManager();
        $eventManager->setThrowExceptions(true);

        $this->setEventManager($eventManager);

        if ($reporter === null) {
            return;
        }

        $reporter->registerTo( $this->getEventManager() );
    }

    public function setEventManager(EventManager $manager)
    {
        $this->manager = $manager;
    }

    public function getEventManager()
    {
        return $this->manager;
    }

    public function notifyInitialize(AnalyzerConfiguration $configuration)
    {
        $event = new InitializeEvent($configuration);
        $this->getEventManager()->emit($event);
    }

    public function notifyStart()
    {
        $event = new AnalyzeStartEvent();
        $this->getEventManager()->emit($event);
    }

    /**
     * @param AnalyzedCoverageResult $result
     */
    public function notifyStop(AnalyzedCoverageResult $result)
    {
        $event = new AnalyzeStopEvent($result);
        $this->getEventManager()->emit($event);
    }

}

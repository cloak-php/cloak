<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace cloak\reporter;

use cloak\Result;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\event\FinalizeEvent;
use PHPExtra\EventManager\EventManager;
use PHPExtra\EventManager\EventManagerInterface;


/**
 * Class CompositeReporter
 * @package cloak\reporter
 */
class CompositeReporter implements Reporter, CompositeListener
{


    /**
     * @var \PHPExtra\EventManager\EventManager
     */
    private $eventManager;


    /**
     * @param array $reporters
     */
    public function __construct(array $reporters)
    {
        $eventManager = new EventManager();
        $eventManager->setThrowExceptions(true);

        foreach ($reporters as $reporter) {
            $eventManager->addListener($reporter);
        }
        $this->eventManager = $eventManager;
    }

    /**
     * @param InitializeEvent $event
     */
    public function onInitialize(InitializeEvent $event)
    {
        $this->eventManager->trigger($event);
    }

    /**
     * @param AnalyzeStartEvent $event
     */
    public function onAnalyzeStart(AnalyzeStartEvent $event)
    {
        $this->eventManager->trigger($event);
    }

    /**
     * @param AnalyzeStopEvent $event
     */
    public function onAnalyzeStop(AnalyzeStopEvent $event)
    {
        $this->eventManager->trigger($event);
    }

    /**
     * @param FinalizeEvent $event
     */
    public function onFinalize(FinalizeEvent $event)
    {
        $this->eventManager->trigger($event);
    }

    /**
     * @param EventManagerInterface $eventManager
     */
    public function registerTo(EventManagerInterface $eventManager)
    {
        $eventManager->addListener($this);
    }

}

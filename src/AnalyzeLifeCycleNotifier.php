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
use cloak\Configuration;
use cloak\Reporter\Reporter;
use cloak\event\InitEvent;
use cloak\event\StartEvent;
use cloak\event\StopEvent;
use PHPExtra\EventManager\EventManager;
use PHPExtra\EventManager\EventManagerAwareInterface;


/**
 * Class AnalyzeLifeCycleNotifier
 * @package cloak
 */
class AnalyzeLifeCycleNotifier implements AnalyzeLifeCycleNotifierInterface, EventManagerAwareInterface
{

    /**
     * @var \PHPExtra\EventManager\EventManagerInterface
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

    public function notifyInit(Configuration $configuration)
    {
        $event = new InitEvent($configuration);
        $this->getEventManager()->trigger($event);
    }

    public function notifyStart()
    {
        $event = new StartEvent();
        $this->getEventManager()->trigger($event);
    }

    /**
     * @param Result $result
     */
    public function notifyStop(Result $result)
    {
        $event = new StopEvent($result);
        $this->getEventManager()->trigger($event);
    }

}

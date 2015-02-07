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
use cloak\Reporter\ReporterInterface;
use cloak\event\InitEvent;
use cloak\event\StartEvent;
use cloak\event\StopEvent;
use PHPExtra\EventManager\EventManager;


/**
 * Class AnalyzeLifeCycleNotifier
 * @package cloak
 */
class AnalyzeLifeCycleNotifier implements AnalyzeLifeCycleNotifierInterface
{

    /**
     * @var \PHPExtra\EventManager\EventManagerInterface
     */
    private $manager;

    /**
     * @param ReporterInterface $reporter
     */
    public function __construct(ReporterInterface $reporter = null)
    {
        $this->setEventManager(new EventManager());

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

    public function notifyInit()
    {
        $event = new InitEvent();
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

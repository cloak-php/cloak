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

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Trait Reportable
 * @package cloak\reporter
 */
trait Reportable
{

    use ListenerAggregateTrait;

    /**
     * @var array
     */
    private $acceptLifeCycleEvents = [
        'stop' => 'onStop'
    ];


    /**
     * @return array
     */
    protected function getAcceptLifeCycleEvents()
    {
        return $this->acceptLifeCycleEvents;
    }

    /**
     * @param \Zend\EventManager\EventManagerInterface $eventManager
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $events = $this->getAcceptLifeCycleEvents();

        foreach ($events as $event => $method) {
            if (method_exists($this, $method) === false) {
                continue;
            }
            $this->listeners[] = $eventManager->attach($event, array($this, $method));
        }
    }

}

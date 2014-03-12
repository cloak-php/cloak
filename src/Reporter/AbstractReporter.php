<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CodeAnalyzer\Reporter;

use Zend\EventManager\EventManagerInterface;


abstract class AbstractReporter implements ReporterInterface
{

    protected $eventListeners = array();

    public function attach(EventManagerInterface $eventManager)
    {
        $events = array(
            'stop' => 'onStop'
        );

        foreach ($events as $event => $method) {
            if (method_exists($this, $method) === false) {
                continue;
            }
            $this->eventListeners[] = $eventManager->attach($event, array($this, $method));
        }
    }

    public function detach(EventManagerInterface $eventManager)
    {
        foreach ($this->eventListeners as $listener) {
            $eventManager->detach($listener);
        }
    }

}

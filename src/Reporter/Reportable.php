<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easycoverage\Reporter;

use Zend\EventManager\EventManagerInterface,
    Zend\EventManager\ListenerAggregateTrait;

trait Reportable
{

    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $eventManager)
    {
        $events = [
            'stop' => 'onStop'
        ];

        foreach ($events as $event => $method) {
            if (method_exists($this, $method) === false) {
                continue;
            }
            $this->listeners[] = $eventManager->attach($event, array($this, $method));
        }
    }

}

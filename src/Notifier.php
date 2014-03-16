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

use CodeAnalyzer\Event,
    CodeAnalyzer\Result,
    CodeAnalyzer\Reporter\ReporterInterface,
    Zend\EventManager\EventManagerAwareTrait;

//TODO setReporter / getReporter
class Notifier implements NotifierInterface
{

    use EventManagerAwareTrait;

    public function __construct(ReporterInterface $reporter = null)
    {
        if ($reporter === null) { 
            return;
        }
        $reporter->attach( $this->getEventManager() );
    }

    public function stop(Result $result)
    {
        $event = new Event(Event::STOP, $this, [ 'result' => $result ]);
        $this->getEventManager()->trigger($event);
    }

}

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\AnalyzeStartEvent;
use cloak\reporter\Reportable;
use cloak\reporter\Reporter;
use cloak\reporter\AnalyzeStartEventListener;
use PHPExtra\EventManager\EventManager;



class ExampleReporter implements Reporter, AnalyzeStartEventListener
{
    use Reportable;

    private $startEvent;

    public function onStart(AnalyzeStartEvent $event)
    {
        $this->startEvent = $event;
    }

    public function getStartEvent()
    {
        return $this->startEvent;
    }

}

describe(Reportable::class, function() {
    describe('#registerTo', function() {
        beforeEach(function() {
            $this->startEvent = new AnalyzeStartEvent();

            $this->eventManager = new EventManager();
            $this->reporter = new ExampleReporter();
            $this->reporter->registerTo($this->eventManager);

            $this->eventManager->trigger($this->startEvent);
        });
        it('attach events', function() {
            expect($this->reporter->getStartEvent())->toBe($this->startEvent);
        });
    });
});

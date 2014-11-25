<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\StartEventInterface;
use cloak\event\StopEventInterface;
use cloak\reporter\Reportable;
use cloak\reporter\ReporterInterface;
use PHPExtra\EventManager\EventManager;
use \Mockery;


class HaveMethodCloakReporter implements ReporterInterface
{
    use Reportable;

    private $startEvent;
    private $stopEvent;

    public function onStart(StartEventInterface $event)
    {
        $this->startEvent = $event;
    }
    public function onStop(StopEventInterface $event) {
        $this->stopEvent = $event;
    }
    public function getStartEvent()
    {
        return $this->startEvent;
    }
    public function getStopEvent()
    {
        return $this->stopEvent;
    }
}

describe('Reportable', function() {
    describe('#attach', function() {
        beforeEach(function() {
            $this->startEvent = Mockery::mock('\cloak\event\StartEventInterface');
            $this->startEvent->shouldReceive('getSendAt')->never();

            $this->stopEvent = Mockery::mock('\cloak\event\StopEventInterface');
            $this->stopEvent->shouldReceive('getSendAt')->never();
            $this->stopEvent->shouldReceive('getResult')->never();

            $this->reporter = new HaveMethodCloakReporter();
            $this->eventManager = new EventManager();
            $this->eventManager->addListener($this->reporter);
            $this->eventManager->trigger($this->startEvent);
            $this->eventManager->trigger($this->stopEvent);
        });
        it('should attach start event', function() {
            expect($this->reporter->getStartEvent())->toEqual($this->startEvent);
        });
        it('should attach stop event', function() {
            expect($this->reporter->getStopEvent())->toEqual($this->stopEvent);
        });
        it('check mock object expectations', function() {
            Mockery::close();
        });
    });
});

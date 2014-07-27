<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\event\StopEventInterface;
use cloak\reporter\Reportable;
use cloak\reporter\ReporterInterface;
use Zend\EventManager\EventManager;
use Mockery as Mock;

class HaveMethodCloakReporter implements ReporterInterface
{
    use Reportable;

    public function onStop(StopEventInterface $event) {}
}

class HaveNotMethodCloakReporter
{
    use Reportable;
}

describe('Reportable', function() {

    describe('#attach', function() {
        context('when have recive event method', function() {
            $this->reporter = Mock::mock('HaveMethodCloakReporter');
            $this->reporter->makePartial();
            $this->reporter->shouldReceive('onStop')->once();

            before(function() {
                $this->eventManager = new EventManager();
                $this->eventManager->attach($this->reporter);
            });
            after(function() {
                Mock::close();
            });
            it('should attach events', function() {
                $events = $this->eventManager->getEvents();
                expect($events)->toEqual(array('stop'));
            });
        });
        context('when have not recive event method', function() {
            $this->reporter = Mock::mock('HaveNotMethodCloakReporter');
            $this->reporter->makePartial();

            before(function() {
                $this->eventManager = new EventManager();
                $this->eventManager->attach($this->reporter);
            });
            after(function() {
                Mock::close();
            });
            it('should not attach events', function() {
                $events = $this->eventManager->getEvents();
                expect($events)->toBeEmpty();
            });
        });
    });

    describe('#detach', function() {
        $this->reporter = Mock::mock('HaveMethodCloakReporter');
        $this->reporter->makePartial();
        $this->reporter->shouldReceive('onStop')->once();

        before(function() {
            $this->eventManager = new EventManager();
            $this->eventManager->attach($this->reporter);
            $this->eventManager->detach($this->reporter);
        });
        after(function() {
            Mock::close();
        });
        it('should detach events', function() {
            $events = $this->eventManager->getEvents();
            expect($events)->toEqual(array());
        });
    });

});

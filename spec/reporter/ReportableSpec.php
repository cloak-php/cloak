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
use Zend\EventManager\EventManager;
use Zend\EventManager\ListenerAggregateInterface;
use \Mockery;

class HaveMethodCloakReporter implements ReporterInterface
{
    use Reportable;

    public function onStart(StartEventInterface $event) {}
    public function onStop(StopEventInterface $event) {}
}

class HaveNotMethodCloakReporter implements ListenerAggregateInterface
{
    use Reportable;
    public function onStop(StopEventInterface $event) {}
}

describe('Reportable', function() {

    describe('#attach', function() {
        context('when have recive event method', function() {
            before(function() {
                $this->verify = function() {
                    Mockery::close();
                };

                $this->reporter = Mockery::mock('HaveMethodCloakReporter');
                $this->reporter->makePartial();
                $this->reporter->shouldReceive('onStart')->never();
                $this->reporter->shouldReceive('onStop')->never();

                $this->eventManager = new EventManager();
                $this->eventManager->attach($this->reporter);
                $this->events = $this->eventManager->getEvents();
            });

            it('should attach events', function() {
                expect($this->events)->toEqual(array('start', 'stop'));
            });
            it('check mock object expectations', function() {
                call_user_func($this->verify);
            });
        });
        context('when have not recive event method', function() {
            before(function() {
                $this->verify = function() {
                    Mockery::close();
                };

                $this->reporter = Mockery::mock('HaveNotMethodCloakReporter');
                $this->reporter->makePartial();
                $this->reporter->shouldReceive('onStop')->never();

                $this->eventManager = new EventManager();
                $this->eventManager->attach($this->reporter);
                $this->events = $this->eventManager->getEvents();
            });
            it('should not attach events', function() {
                expect($this->events)->toEqual(['stop']);
            });
            it('check mock object expectations', function() {
                call_user_func($this->verify);
            });
        });
    });

    describe('#detach', function() {
        before(function() {
            $this->verify = function() {
                Mockery::close();
            };

            $this->reporter = Mockery::mock('HaveMethodCloakReporter');
            $this->reporter->makePartial();
            $this->reporter->shouldReceive('onStop')->never();

            $this->eventManager = new EventManager();
            $this->eventManager->attach($this->reporter);
            $this->eventManager->detach($this->reporter);

            $this->events = $this->eventManager->getEvents();
        });
        it('should detach events', function() {
            expect($this->events)->toBeEmpty();
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

});

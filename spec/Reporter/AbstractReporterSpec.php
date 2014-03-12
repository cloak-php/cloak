<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Reporter\AbstractReporter;
use Zend\EventManager\EventManager;
use Zend\EventManager\Event;
use Mockery as Mock;

describe('AbstractReporter', function() {

    describe('#attach', function() {
        before(function() {
            $this->reporter = Mock::mock('CodeAnalyzer\Reporter\AbstractReporter');
            $this->reporter->makePartial();
            $this->reporter->shouldReceive('onStop')->once();

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

    describe('#detach', function() {
        before(function() {
            $this->reporter = Mock::mock('CodeAnalyzer\Reporter\AbstractReporter');
            $this->reporter->makePartial();
            $this->reporter->shouldReceive('onStop')->once();

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

<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use easycoverage\EventInterface,
    easycoverage\Reporter\Reportable,
    easycoverage\Reporter\ReporterInterface,
    Zend\EventManager\EventManager,
    Mockery as Mock;

class easycoverageReporter implements ReporterInterface
{

    use Reportable;

    public function onStop(EventInterface $event)
    {
    }

}

describe('Reportable', function() {

    describe('#attach', function() {
        $this->reporter = Mock::mock('easycoverageReporter');
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

    describe('#detach', function() {
        $this->reporter = Mock::mock('easycoverageReporter');
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

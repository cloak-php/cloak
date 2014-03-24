<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\EventInterface,
    CodeAnalyzer\Reporter\Reportable,
    CodeAnalyzer\Reporter\ReporterInterface,
    Zend\EventManager\EventManager,
    Mockery as Mock;

class CodeAnalyzerReporter implements ReporterInterface
{

    use Reportable;

    public function onStop(EventInterface $event)
    {
    }

}

describe('Reportable', function() {

    describe('#attach', function() {
        before(function() {
            $this->reporter = Mock::mock('CodeAnalyzerReporter');
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
            $this->reporter = Mock::mock('CodeAnalyzerReporter');
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

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\Result;
use PhpCollection\Sequence;
use cloak\reporter\CompositeReporter;
use cloak\spec\reporter\ReporterFixture;
use \Prophecy\Prophet;


describe('CompositeReporter', function() {

    beforeEach(function() {
        $this->prophet = new Prophet;
    });

    describe('onStart', function() {
        beforeEach(function() {
            $startEvent = $this->prophet->prophesize('cloak\event\StartEventInterface');
            $startEvent->getSendAt()->shouldNotBeCalled();

            $this->startEvent = $startEvent->reveal();

            $this->reporter1 = new ReporterFixture('fixture1', 'fixture reporter1');
            $this->reporter2 = new ReporterFixture('fixture2', 'fixture reporter2');

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);
            $this->reporter->onStart($this->startEvent);
        });
        afterEach(function() {
            $this->prophet->checkPredictions();
        });
        it('notify the event to the children of the reporter', function() {
            $firstReporterEvent = $this->reporter1->getStartEvent();
            $secondReporterEvent = $this->reporter2->getStartEvent();

            expect($firstReporterEvent)->toEqual($secondReporterEvent);
        });
    });

    describe('onStop', function() {
        beforeEach(function() {
            $this->result = new Result(new Sequence());

            $stopEvent = $this->prophet->prophesize('cloak\event\StopEventInterface');
            $stopEvent->getSendAt()->shouldNotBeCalled();
            $stopEvent->getResult()->shouldNotBeCalled();

            $this->stopEvent = $stopEvent->reveal();

            $reporter1 = $this->prophet->prophesize('cloak\reporter\ReporterInterface');
            $reporter1->onStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize('cloak\reporter\ReporterInterface');
            $reporter2->onStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter2 = $reporter2->reveal();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);
            $this->reporter->onStop($this->stopEvent);
        });
        it('notify the event to the children of the reporter', function() {
            $this->prophet->checkPredictions();
        });
    });

});

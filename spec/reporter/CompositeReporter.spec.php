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
use cloak\event\StartEvent;
use cloak\event\StopEvent;
use PhpCollection\Sequence;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ReporterInterface;
use cloak\reporter\StartEventListener;
use cloak\reporter\StopEventListener;
use \Prophecy\Prophet;


describe(CompositeReporter::class, function() {

    beforeEach(function() {
        $this->prophet = new Prophet;
    });

    describe('#onStart', function() {
        beforeEach(function() {
            $this->startEvent = new StartEvent();

            $reporter1 = $this->prophet->prophesize(ReporterInterface::class);
            $reporter1->willImplement(StartEventListener::class);
            $reporter1->onStart($this->startEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize(ReporterInterface::class);
            $reporter2->willImplement(StartEventListener::class);
            $reporter2->onStart($this->startEvent)->shouldBeCalledTimes(1);

            $this->reporter2 = $reporter2->reveal();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);
            $this->reporter->onStart($this->startEvent);
        });
        it('notify the event to the children of the reporter', function() {
            $this->prophet->checkPredictions();
        });
    });

    describe('onStop', function() {
        beforeEach(function() {
            $this->result = new Result(new Sequence());
            $this->stopEvent = new StopEvent($this->result);

            $reporter1 = $this->prophet->prophesize(ReporterInterface::class);
            $reporter1->willImplement(StopEventListener::class);
            $reporter1->onStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize(ReporterInterface::class);
            $reporter2->willImplement(StopEventListener::class);
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

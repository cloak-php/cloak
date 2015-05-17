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
use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use PhpCollection\Sequence;
use cloak\reporter\CompositeReporter;
use cloak\reporter\Reporter;
use cloak\reporter\AnalyzeStartEventListener;
use cloak\reporter\AnalyzeStopEventListener;
use \Prophecy\Prophet;


describe(CompositeReporter::class, function() {

    beforeEach(function() {
        $this->prophet = new Prophet;
    });

    describe('#onAnalyzeStart', function() {
        beforeEach(function() {
            $this->startEvent = new AnalyzeStartEvent();

            $reporter1 = $this->prophet->prophesize(Reporter::class);
            $reporter1->willImplement(AnalyzeStartEventListener::class);
            $reporter1->onAnalyzeStart($this->startEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize(Reporter::class);
            $reporter2->willImplement(AnalyzeStartEventListener::class);
            $reporter2->onAnalyzeStart($this->startEvent)->shouldBeCalledTimes(1);

            $this->reporter2 = $reporter2->reveal();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);
            $this->reporter->onAnalyzeStart($this->startEvent);
        });
        it('notify the event to the children of the reporter', function() {
            $this->prophet->checkPredictions();
        });
    });

    describe('onStop', function() {
        beforeEach(function() {
            $this->result = new Result(new Sequence());
            $this->stopEvent = new AnalyzeStopEvent($this->result);

            $reporter1 = $this->prophet->prophesize(Reporter::class);
            $reporter1->willImplement(AnalyzeStopEventListener::class);
            $reporter1->onStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize(Reporter::class);
            $reporter2->willImplement(AnalyzeStopEventListener::class);
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

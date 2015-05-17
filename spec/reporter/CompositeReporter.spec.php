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
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\event\FinalizeEvent;
use PhpCollection\Sequence;
use cloak\reporter\CompositeReporter;
use cloak\reporter\Reporter;
use cloak\reporter\InitializeEventListener;
use cloak\reporter\AnalyzeStartEventListener;
use cloak\reporter\AnalyzeStopEventListener;
use cloak\reporter\FinalizeEventListener;
use cloak\value\CoverageBounds;
use cloak\Configuration;
use \Prophecy\Prophet;


describe(CompositeReporter::class, function() {

    beforeEach(function() {
        $this->prophet = new Prophet;
    });

    describe('#onInitialize', function() {
        beforeEach(function() {
            $config = new Configuration([
                'coverageBounds' => new CoverageBounds(35.0, 70.0)
            ]);
            $this->initializeEvent = new InitializeEvent($config);

            $reporter = $this->prophet->prophesize(Reporter::class);
            $reporter->willImplement(InitializeEventListener::class);
            $reporter->onInitialize($this->initializeEvent)->shouldBeCalledTimes(1);

            $this->reporter = new CompositeReporter([ $reporter->reveal() ]);
        });
        it('notify the initialize event to the children of the reporter', function() {
            $this->reporter->onInitialize($this->initializeEvent);
            $this->prophet->checkPredictions();
        });
    });

    describe('#onFinalize', function() {
        beforeEach(function() {
            $this->finalizeEvent = new FinalizeEvent();

            $reporter = $this->prophet->prophesize(Reporter::class);
            $reporter->willImplement(FinalizeEventListener::class);
            $reporter->onFinalize($this->finalizeEvent)->shouldBeCalledTimes(1);

            $this->reporter = new CompositeReporter([ $reporter->reveal() ]);
        });
        it('notify the finalize event to the children of the reporter', function() {
            $this->reporter->onFinalize($this->finalizeEvent);
            $this->prophet->checkPredictions();
        });
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

    describe('onAnalyzeStop', function() {
        beforeEach(function() {
            $this->result = new Result(new Sequence());
            $this->stopEvent = new AnalyzeStopEvent($this->result);

            $reporter1 = $this->prophet->prophesize(Reporter::class);
            $reporter1->willImplement(AnalyzeStopEventListener::class);
            $reporter1->onAnalyzeStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter1 = $reporter1->reveal();

            $reporter2 = $this->prophet->prophesize(Reporter::class);
            $reporter2->willImplement(AnalyzeStopEventListener::class);
            $reporter2->onAnalyzeStop($this->stopEvent)->shouldBeCalledTimes(1);

            $this->reporter2 = $reporter2->reveal();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);
            $this->reporter->onAnalyzeStop($this->stopEvent);
        });
        it('notify the event to the children of the reporter', function() {
            $this->prophet->checkPredictions();
        });
    });

});

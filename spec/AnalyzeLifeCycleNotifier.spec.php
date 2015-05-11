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
use cloak\Configuration;
use cloak\result\LineResult;
use cloak\AnalyzeLifeCycleNotifier;
use cloak\analyzer\AnalyzedResult;
use cloak\event\InitEvent;
use cloak\event\StopEvent;
use cloak\event\StartEvent;
use PHPExtra\EventManager\EventManagerInterface;
use cloak\reporter\InitEventListener;
use cloak\reporter\StartEventListener;
use cloak\reporter\StopEventListener;
use cloak\reporter\Reporter;
use Prophecy\Prophet;
use Prophecy\Argument;


describe(AnalyzeLifeCycleNotifier::class, function() {

    describe('#notifyInit', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $reporter = $this->prophet->prophesize('Reporter');
            $reporter->willImplement(InitEventListener::class);
            $reporter->willImplement(Reporter::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onInit(Argument::type(InitEvent::class))->shouldBeCalled();

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporterMock);
            $this->progessNotifier->notifyInit(new Configuration([]));
        });
        it('should notify the reporter that it has init', function() {
            $this->prophet->checkPredictions();
        });
    });


    describe('#notifyStart', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $reporter = $this->prophet->prophesize('Reporter');
            $reporter->willImplement(Reporter::class);
            $reporter->willImplement(StartEventListener::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onStart(Argument::type(StartEvent::class))->shouldBeCalled();
            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporterMock);
            $this->progessNotifier->notifyStart();
        });

        it('should notify the reporter that it has started', function() {
            $this->prophet->checkPredictions();
        });
    });

    describe('#notifyStop', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/fixtures/src/';
            $coverageResults = [
                $rootDirectory . 'foo.php' => array( 1 => LineResult::EXECUTED )
            ];

            $analyzeResult = AnalyzedResult::fromArray($coverageResults);
            $this->result = Result::fromAnalyzeResult($analyzeResult);


            $this->prophet = new Prophet();

            $reporter = $this->prophet->prophesize('Reporter');
            $reporter->willImplement(StopEventListener::class);
            $reporter->willImplement(Reporter::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onStop(Argument::that(function(StopEvent $event) {
                $result = $event->getResult();
                expect(count($result->getFiles()))->toEqual(1);
                return true;
            }))->shouldBeCalled();

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporterMock);
            $this->progessNotifier->notifyStop($this->result);
        });
        it('should notify the reporter that it has stoped', function() {
            $this->prophet->checkPredictions();
        });
    });
});

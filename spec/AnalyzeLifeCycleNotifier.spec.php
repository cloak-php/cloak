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
use cloak\AnalyzeLifeCycleNotifier;
use cloak\analyzer\AnalyzedResult;
use cloak\analyzer\result\LineResult;
use cloak\event\InitializeEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\event\AnalyzeStartEvent;
use PHPExtra\EventManager\EventManagerInterface;
use cloak\reporter\InitializeEventListener;
use cloak\reporter\AnalyzeStartEventListener;
use cloak\reporter\AnalyzeStopEventListener;
use cloak\reporter\Reporter;
use Prophecy\Prophet;
use Prophecy\Argument;


describe(AnalyzeLifeCycleNotifier::class, function() {

    describe('#notifyInitialize', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $reporter = $this->prophet->prophesize('Reporter');
            $reporter->willImplement(InitializeEventListener::class);
            $reporter->willImplement(Reporter::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onInitialize(Argument::type(InitializeEvent::class))->shouldBeCalled();

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporterMock);
            $this->progessNotifier->notifyInitialize(new Configuration([]));
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
            $reporter->willImplement(AnalyzeStartEventListener::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onAnalyzeStart(Argument::type(AnalyzeStartEvent::class))->shouldBeCalled();
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
            $reporter->willImplement(AnalyzeStopEventListener::class);
            $reporter->willImplement(Reporter::class);

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onStop(Argument::that(function(AnalyzeStopEvent $event) {
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

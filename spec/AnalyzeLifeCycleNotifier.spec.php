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
use cloak\result\LineResult;
use cloak\AnalyzeLifeCycleNotifier;
use cloak\driver\Result as AnalyzeResult;
use cloak\spec\reporter\ReporterFixture;
use cloak\event\InitEvent;
use PHPExtra\EventManager\EventManagerInterface;
use PHPExtra\EventManager\EventManager;
use \Mockery;
use Prophecy\Prophet;
use Prophecy\Argument;


describe('AnalyzeLifeCycleNotifier', function() {

    describe('#notifyInit', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $reporter = $this->prophet->prophesize('Reporter');
            $reporter->willImplement('cloak\reporter\Initializable');
            $reporter->willImplement('cloak\reporter\ReporterInterface');

            $reporterMock = $reporter->reveal();

            $reporter->registerTo(Argument::that(function(EventManagerInterface $em) use($reporterMock) {
                $em->addListener($reporterMock);
                return true;
            }))->shouldBeCalled();

            $reporter->onInit(Argument::type('\cloak\event\InitEvent'))->shouldBeCalled();
            $reporter->onStop()->shouldNotBeCalled();

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporterMock);
            $this->progessNotifier->notifyInit();
        });
        it('should notify the reporter that it has init', function() {
            $this->prophet->checkPredictions();
        });
    });


    describe('#notifyStart', function() {
        beforeEach(function() {
            $this->reporter = new ReporterFixture('fixture', 'fixture reporter');

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($this->reporter);
            $this->progessNotifier->notifyStart();
        });

        it('should notify the reporter that it has started', function() {
            $event = $this->reporter->getStartEvent();
            expect($event)->toBeAnInstanceOf('cloak\event\StartEventInterface');
        });
    });

    describe('#notifyStop', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/fixtures/src/';
            $coverageResults = [
                $rootDirectory . 'foo.php' => array( 1 => LineResult::EXECUTED )
            ];

            $analyzeResult = AnalyzeResult::fromArray($coverageResults);
            $this->result = Result::fromAnalyzeResult($analyzeResult);

            $subject = $this->subject = new \stdClass();
            $reporter = $this->reporter = Mockery::mock('cloak\reporter\ReporterInterface');

            $reporter->shouldReceive('registerTo')->once()->with(
                Mockery::on(function(EventManager $eventManager) use ($reporter) {
                    $eventManager->addListener($reporter);
                    return true;
                })
            );

            $reporter->shouldReceive('onStop')->once()->with(
                Mockery::on(function($event) use($subject) {
                    $subject->event = $event;
                    return true;
                })
            );

            $this->progessNotifier = new AnalyzeLifeCycleNotifier($reporter);
            $this->progessNotifier->notifyStop($this->result);
        });
        it('should notify the reporter that it has stopped', function() {
            $event = $this->subject->event;
            expect($event)->toBeAnInstanceOf('cloak\event\StopEventInterface');
        });
        it('should include the results', function() {
            $result = $this->subject->event->getResult();
            expect($result)->toEqual($this->result);
            expect(count($result->getFiles()))->toEqual(1);
        });
        it('check mock object expectations', function() {
            Mockery::close();
        });
    });

});

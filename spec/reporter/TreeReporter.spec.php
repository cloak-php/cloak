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
use cloak\reporter\TreeReporter;
use cloak\driver\Result as AnalyzeResult;
use cloak\event\StopEvent;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;
use \Mockery;


describe('TreeReporter', function() {

    describe('onStart', function() {
        beforeEach(function() {
            $this->verify = function() {
                Mockery::close();
            };
            $this->event = Mockery::mock('cloak\event\StartEventInterface');
            $this->event->shouldReceive('getSendAt')->never();

            $this->reporter = new TreeReporter();
        });
        it('does not output anything', function() {
            expect(function() {
                $this->reporter->onStart($this->event);
            })->toPrint('');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('onStop', function() {
        beforeEach(function() {
            $sourceFile1 = realpath(__DIR__ . '/../fixtures/report/src/Example1.php');
            $sourceFile2 = realpath(__DIR__ . '/../fixtures/report/src/Example2.php');
            $expectResultFile = __DIR__ . '/../fixtures/report/tree_report.log';

            $coverages = [
                $sourceFile1 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::EXECUTED
                ],
                $sourceFile2 => [
                    13 => LineResult::EXECUTED,
                    18 => LineResult::UNUSED
                ]
            ];

            $analyzeResult = AnalyzeResult::fromArray($coverages);
            $this->stopEvent = new StopEvent(Result::fromAnalyzeResult($analyzeResult));
            $this->expectResult = file_get_contents($expectResultFile);

            $this->reporter = new TreeReporter();
        });
        it('does not output anything', function() {
            expect(function() {
                $this->reporter->onStop($this->stopEvent);
            })->toPrint($this->expectResult);
        });
    });

});

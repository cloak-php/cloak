<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\AnalyzedCoverageResult;
use cloak\analyzer\AnalyzedResult;
use cloak\event\AnalyzeStartEvent;
use cloak\event\AnalyzeStopEvent;
use cloak\reporter\ProcessingTimeReporter;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;

describe(ProcessingTimeReporter::class, function() {

    describe('onStart', function() {
        beforeEach(function() {
            $this->reporter = new ProcessingTimeReporter();

            $this->dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2014-07-01 12:00:00');
            $this->startEvent = new AnalyzeStartEvent($this->dateTime);

            $console = Console::getInstance();
            $colorDateTime = $console->colorize('1 July 2014 at 12:00', Color::CYAN);

            $this->output = "\nCode Coverage Started: $colorDateTime\n";
        });
        it('output start datetime', function() {
            expect(function() {
                $this->reporter->onAnalyzeStart($this->startEvent);
            })->toPrint($this->output);
        });
    });

    describe('onStop', function() {
        beforeEach(function() {
            $this->reporter = new ProcessingTimeReporter();

            $this->dateTime = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2014-07-01 12:00:00');
            $this->startEvent = new AnalyzeStartEvent();

            $analyzeResult = AnalyzedResult::fromArray([]);
            $this->result = AnalyzedCoverageResult::fromAnalyzeResult($analyzeResult);

            $this->stopEvent = new AnalyzeStopEvent($this->result);
            $this->reporter->onAnalyzeStart($this->startEvent);
        });
        it('output running time', function() {
            ob_start();
            $this->reporter->onAnalyzeStop($this->stopEvent);
            $output = ob_get_clean();

            expect($output)->toMatch('/Code Coverage Finished in (.+) seconds/');
        });
    });

});

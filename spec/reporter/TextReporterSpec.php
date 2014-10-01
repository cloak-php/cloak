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
use cloak\result\Line;
use cloak\reporter\TextReporter;
use cloak\driver\Result as AnalyzeResult;
use cloak\event\StopEvent;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;
use \Mockery;


describe('TextReporter', function() {

    describe('onStart', function() {
        before(function() {
            $this->verify = function() {
                Mockery::close();
            };
            $this->event = Mockery::mock('cloak\event\StartEventInterface');
            $this->event->shouldReceive('getSendAt')->never();

            $this->reporter = new TextReporter();
        });
        it('output start datetime', function() {
            expect(function() {
                $this->reporter->onStart($this->event);
            })->toPrint('');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('onStop', function() {
        before(function() {
            $this->console = Console::getInstance();

            $coverages = [
                realpath(__DIR__ . '/../../src/driver/XdebugDriver.php') => [
                    1 => Line::EXECUTED,
                    2 => Line::EXECUTED,
                    3 => Line::UNUSED
                ],
                realpath(__DIR__ . '/../../src/result/Line.php') => [
                    1 => Line::EXECUTED,
                    2 => Line::EXECUTED,
                    3 => Line::EXECUTED,
                    4 => Line::EXECUTED,
                    5 => Line::EXECUTED,
                    6 => Line::EXECUTED,
                    7 => Line::EXECUTED,
                    8 => Line::UNUSED,
                    9 => Line::UNUSED,
                    10 => Line::UNUSED
                ],
                realpath(__DIR__ . '/../../src/result/File.php') => [
                    1 => Line::EXECUTED,
                    2 => Line::EXECUTED,
                    3 => Line::UNUSED,
                    4 => Line::UNUSED,
                    5 => Line::UNUSED,
                    6 => Line::UNUSED,
                    7 => Line::UNUSED
                ]
            ];

            $analyzeResult = AnalyzeResult::fromArray($coverages);

            $this->stopEvent = new StopEvent(null, [
                'result' => Result::fromAnalyzeResult($analyzeResult)
            ]);

            $totalCoverage = sprintf('%6.2f%%', 55.00);
            $this->totalCoverage = $this->console->colorize($totalCoverage, Color::NORMAL);

            $highCoverage = sprintf('%6.2f%%', (float) 70);
            $this->high = $this->console->colorize($highCoverage, Color::GREEN) . ' ';

            $lowCoverage = sprintf('%6.2f%%', (float) 28.57);
            $this->low = $this->console->colorize($lowCoverage, Color::YELLOW) . ' ';

            $normalCoverage = sprintf('%6.2f%%', (float) 66.67);
            $this->normal = $this->console->colorize($normalCoverage, Color::NORMAL) . ' ';

            $this->reporter = new TextReporter();
        });
        it('output coverage', function() {
            $output  = "";
            $output .= $this->normal . "( 2/ 3) src/driver/XdebugDriver.php" . PHP_EOL;
            $output .= $this->high . "( 7/10) src/result/Line.php" . PHP_EOL;
            $output .= $this->low . "( 2/ 7) src/result/File.php" . PHP_EOL;
            $output .= PHP_EOL . "Code Coverage:" . $this->totalCoverage . PHP_EOL;

            expect(function() {
                $this->reporter->onStop($this->stopEvent);
            })->toPrint($output);
        });
    });
});

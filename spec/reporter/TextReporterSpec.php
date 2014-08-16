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
use cloak\event\StopEvent;
use Zend\Console\Console;
use Zend\Console\ColorInterface as Color;
use \Mockery;
use \DateTime;


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

            $this->stopEvent = new StopEvent(null, [
                'result' => Result::from($coverages)
            ]);

            $totalCoverage = sprintf('%6.2f%%', 55.00);
            $this->totalCoverage = $this->console->colorize($totalCoverage, Color::NORMAL);

            $highCoverage = sprintf('%6.2f%%', (float) 70);
            $this->high = ' ' . $this->console->colorize($highCoverage, Color::GREEN) . ' ';

            $lowCoverage = sprintf('%6.2f%%', (float) 28.57);
            $this->low = ' ' . $this->console->colorize($lowCoverage, Color::YELLOW) . ' ';

            $normalCoverage = sprintf('%6.2f%%', (float) 66.67);
            $this->normal = ' ' . $this->console->colorize($normalCoverage, Color::NORMAL) . ' ';

            $this->reporter = new TextReporter();
        });
        it('should output coverage', function() {
            $output  = "";
            $output .= "Total code coverage:" . $this->totalCoverage . PHP_EOL;
            $output .= PHP_EOL;
            $output .= "src/driver/XdebugDriver.php .........................................." . $this->normal . "( 2/ 3)" . PHP_EOL;
            $output .= "src/result/Line.php .................................................." . $this->high . "( 7/10)" . PHP_EOL;
            $output .= "src/result/File.php .................................................." . $this->low . "( 2/ 7)" . PHP_EOL;

            expect(function() {
                $this->reporter->onStop($this->stopEvent);
            })->toPrint($output);
        });

    });

});

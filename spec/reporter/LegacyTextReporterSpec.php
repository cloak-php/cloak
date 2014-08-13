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
use PhpCollection\Sequence;
use cloak\reporter\LegacyTextReporter;
use \Mockery;
use \DateTime;

describe('LegacyTextReporter', function() {

    describe('onStart', function() {
        before(function() {
            $this->verify = function() {
                Mockery::close();
            };

            $this->dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-01 12:00:00');

            $this->event = Mockery::mock('cloak\event\StartEventInterface');
            $this->event->shouldReceive('getSendAt')->andReturn( $this->dateTime );

            $this->factory = Mockery::mock('cloak\report\factory\ReportFactoryInterface');
            $this->factory->shouldReceive('createFromResult')->never();

            $this->reporter = new LegacyTextReporter($this->factory);
        });
        it('output start datetime', function() {
            $output  = str_pad("", 70, "-") . "\n";
            $output .= "Start at: 1 July 2014 at 12:00\n";
            $output .= str_pad("", 70, "-") . "\n";

            expect(function() {
                $this->reporter->onStart($this->event);
            })->toPrint($output);
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('onStop', function() {
        before(function() {
            $this->verify = function() {
                Mockery::close();
            };

            $this->result = new Result(new Sequence());

            $this->event = Mockery::mock('cloak\event\StopEventInterface');
            $this->event->shouldReceive('getResult')->once()->andReturn($this->result);

            $this->report = Mockery::mock('cloak\report\ReportInterface');
            $this->report->shouldReceive('output')->once()->andReturnUsing(function() {
                echo 'content';
            });

            $this->factory = Mockery::mock('cloak\report\factory\ReportFactoryInterface');
            $this->factory->shouldReceive('createFromResult')->once()
                ->with(Mockery::mustBe($this->result))->andReturn($this->report);

            $this->reporter = new LegacyTextReporter($this->factory);
        });
        it('should output coverage', function() {
            expect(function() {
                $this->reporter->onStop($this->event);
            })->toPrint('content');
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

});

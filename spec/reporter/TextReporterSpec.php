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
use cloak\reporter\TextReporter;
use \Mockery;

describe('TextReporter', function() {

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

            $this->reporter = new TextReporter($this->factory);
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

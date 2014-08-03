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
use cloak\reporter\CompositeReporter;
use \Mockery;

describe('CompositeReporter', function() {

    describe('onStart', function() {
        before(function() {
            $this->startEvent = Mockery::mock('cloak\event\StartEventInterface');

            $this->reporter1 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter1->shouldReceive('onStart')->once();
            $this->reporter1->shouldReceive('onStop')->never();

            $this->reporter2 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter2->shouldReceive('onStart')->once();
            $this->reporter2->shouldReceive('onStop')->never();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);

            $this->verify = function() {
                Mockery::close();
            };
        });
        it('notify the start event', function() {
            $this->reporter->onStart($this->startEvent);
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

    describe('onStop', function() {
        before(function() {
            $this->result = new Result(new Sequence());

            $this->stopEvent = Mockery::mock('cloak\event\StopEventInterface');

            $this->reporter1 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter1->shouldReceive('onStart')->never();
            $this->reporter1->shouldReceive('onStop')->once();

            $this->reporter2 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter2->shouldReceive('onStart')->never();
            $this->reporter2->shouldReceive('onStop')->once();

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);

            $this->verify = function() {
                Mockery::close();
            };
        });
        it('notify the stop event', function() {
            $this->reporter->onStop($this->stopEvent);
        });
        it('check mock object expectations', function() {
            call_user_func($this->verify);
        });
    });

});

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
            $this->reporter1->shouldReceive('onStart')->times(1);
            $this->reporter1->shouldReceive('onStop')->times(0);

            $this->reporter2 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter2->shouldReceive('onStart')->times(1);
            $this->reporter2->shouldReceive('onStop')->times(0);

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);

            $this->verify = function() {
                Mockery::close();
            };
        });
        it('notify the start event', function() {
            $this->reporter->onStart($this->startEvent);
            call_user_func($this->verify);
        });
    });

    describe('onStop', function() {
        before(function() {
            $this->result = new Result(new Sequence());

            $this->stopEvent = Mockery::mock('cloak\event\StopEventInterface');

            $this->reporter1 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter1->shouldReceive('onStart')->times(0);
            $this->reporter1->shouldReceive('onStop')->times(1);

            $this->reporter2 = Mockery::mock('cloak\reporter\ReporterInterface');
            $this->reporter2->shouldReceive('onStart')->times(0);
            $this->reporter2->shouldReceive('onStop')->times(1);

            $this->reporter = new CompositeReporter([ $this->reporter1, $this->reporter2 ]);

            $this->verify = function() {
                Mockery::close();
            };
        });

        it('notify the stop event', function() {
            $this->reporter->onStop($this->stopEvent);
            call_user_func($this->verify);
        });
    });

});

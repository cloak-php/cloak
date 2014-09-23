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
use cloak\reporter\ProcessingTimeReporter;
use \Mockery;


describe('ProcessingTimeReporter', function() {

    describe('onStart', function() {
        before(function() {
            $this->reporter = new ProcessingTimeReporter();

            $this->dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-01 12:00:00');

            $this->startEvent = Mockery::mock('cloak\event\StartEventInterface');
            $this->startEvent->shouldReceive('getSendAt')->andReturn( $this->dateTime );
        });
        it('output start datetime', function() {
            $output = "\nCode Coverage Started: 1 July 2014 at 12:00\n";

            expect(function() {
                $this->reporter->onStart($this->startEvent);
            })->toPrint($output);
        });
        it('check mock object expectations', function() {
            Mockery::close();
        });
    });

    describe('onStop', function() {
        before(function() {
            $this->reporter = new ProcessingTimeReporter();

            $this->dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2014-07-01 12:00:00');

            $this->startEvent = Mockery::mock('cloak\event\StartEventInterface');
            $this->startEvent->shouldReceive('getSendAt')->andReturn( $this->dateTime );

            $this->stopEvent = Mockery::mock('cloak\event\StopEventInterface');

            $this->reporter->onStart($this->startEvent);
        });
        it('output running time', function() {
            ob_start();
            $this->reporter->onStop($this->stopEvent);
            $output = ob_get_clean();

            expect($output)->toMatch('/Code Coverage Finished in (.+) seconds/');
        });
        it('check mock object expectations', function() {
            Mockery::close();
        });
    });

});

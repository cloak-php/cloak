<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use \Mockery;

describe('AbstractDriver', function() {

    describe('#isStarted', function() {
        before(function() {
            $this->driver = Mockery::mock('cloak\driver\AbstractDriver')->makePartial();
            $this->driver->shouldReceive('start');
            $this->driver->shouldReceive('stop');
        });
        after(function() {
            Mockery::close();
        });
        context('when after instantiation', function() {
            it('should return false', function() {
                expect($this->driver->isStarted())->toBeFalse();
            });
        });
    });

    describe('#getResult', function() {
        before(function() {
            $this->driver = Mockery::mock('cloak\driver\AbstractDriver')->makePartial();
            $this->driver->shouldReceive('start');
            $this->driver->shouldReceive('stop');
        });
        after(function() {
            Mockery::close();
        });
        context('when after instantiation', function() {
            it('should return array', function() {
                expect($this->driver->getResult())->toBeAn('array');
            });
        });
    });

});

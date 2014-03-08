<?php

use CodeAnalyzer\Driver\XdebugDriver;

describe('XdebugDriver', function() {

    describe('#start', function() {
        before(function() {
            $this->driver = new XdebugDriver();
            $this->driver->start();
        });
        it('should analyze start', function() {
            expect($this->driver->getResult())->toBeNull();
            expect($this->driver->isStarted())->toBeTrue();
        });
    });

    describe('#stop', function() {
        before(function() {
            $this->driver = new XdebugDriver();
            $this->driver->start();
            $this->driver->stop();
        });
        it('should analyze stop', function() {
            expect($this->driver->getResult())->toBeAn('array');
            expect($this->driver->isStarted())->toBeFalse();
        });
    });

});

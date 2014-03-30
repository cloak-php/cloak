<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\Driver\XdebugDriver;

describe('XdebugDriver', function() {

    describe('#start', function() {
        $this->driver = new XdebugDriver();

        before(function() {
            $this->driver->start();
        });
        it('should analyze start', function() {
            expect($this->driver->getResult())->toBeNull();
            expect($this->driver->isStarted())->toBeTrue();
        });
    });

    describe('#stop', function() {
        $this->driver = new XdebugDriver();

        before(function() {
            $this->driver->start();
            $this->driver->stop();
        });
        it('should analyze stop', function() {
            expect($this->driver->getResult())->toBeAn('array');
            expect($this->driver->isStarted())->toBeFalse();
        });
    });

});

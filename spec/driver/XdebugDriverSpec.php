<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\XdebugDriver;

describe('XdebugDriver', function() {

    describe('#start', function() {
        $this->driver = new XdebugDriver();

        before(function() {
            $this->driver->start();
        });
        it('report of coverage has not been collected', function() {
            $result = $this->driver->getAnalyzeResult();
            expect($result->isEmpty())->toBeTrue();
        });
        it('started the analysis', function() {
            expect($this->driver->isStarted())->toBeTrue();
        });
    });

    describe('#stop', function() {
        $this->driver = new XdebugDriver();

        before(function() {
            $this->driver->start();
            $this->driver->stop();
        });
        it('report of coverage is being collected', function() {
            expect($this->driver->getAnalyzeResult())->toBeAnInstanceOf('cloak\driver\Result');
        });
        it('stoped the analysis', function() {
            expect($this->driver->isStarted())->toBeFalse();
        });
    });

});

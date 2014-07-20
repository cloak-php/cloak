<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\DriverDetector;

describe('DriverDetector', function() {

    describe('#detect', function() {
        context('when enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'cloak\driver\XdebugDriver'
                ]);
            });
            it('should return driver instance', function() {
                $driver = $this->detector->detect();
                expect($driver)->toBeAnInstanceOf('cloak\driver\DriverInterface');
            });
        });
        context('when not enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'cloak\spec\driver\FixtureDriver'
                ]);
            });
            it('should throw cloak\DriverNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow('cloak\DriverNotFoundException');
            });
        });
    });

});

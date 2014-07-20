<?php

/**
 * This file is part of easycoverage.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use easycoverage\DriverDetector;

describe('DriverDetector', function() {

    describe('#detect', function() {
        context('when enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'easycoverage\driver\XdebugDriver'
                ]);
            });
            it('should return driver instance', function() {
                $driver = $this->detector->detect();
                expect($driver)->toBeAnInstanceOf('easycoverage\driver\DriverInterface');
            });
        });
        context('when not enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'easycoverage\spec\driver\FixtureDriver'
                ]);
            });
            it('should throw easycoverage\DriverNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow('easycoverage\DriverNotFoundException');
            });
        });
    });

});

<?php

/**
 * This file is part of CodeAnalyzer.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use CodeAnalyzer\DriverDetector;

describe('DriverDetector', function() {

    describe('#detect', function() {
        context('when enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'CodeAnalyzer\Driver\XdebugDriver'
                ]);
            });
            it('should return driver instance', function() {
                $driver = $this->detector->detect();
                expect($driver)->toBeAnInstanceOf('CodeAnalyzer\Driver\DriverInterface');
            });
        });
        context('when not enabled', function() {
            before(function() {
                $this->detector = new DriverDetector([
                    'CodeAnalyzer\Spec\Driver\FixtureDriver'
                ]);
            });
            it('should throw CodeAnalyzer\DriverNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow('CodeAnalyzer\DriverNotFoundException');
            });
        });
    });

});

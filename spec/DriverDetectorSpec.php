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
        before(function() {
            $this->detector = new DriverDetector();
        });
        context('xdebug enabled', function() {
            it('should return xdebug driver instance', function() {
                $driver = $this->detector->detect();
                expect($driver)->toBeAnInstanceOf('CodeAnalyzer\Driver\XdebugDriver');
            });
        });
    });

});

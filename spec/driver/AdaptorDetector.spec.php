<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\AdaptorDetector;
use cloak\driver\Adaptor;
use cloak\driver\adaptor\AdaptorNotFoundException;
use cloak\spec\driver\adaptor\EnableFixtureAdaptor;
use cloak\spec\driver\adaptor\FixtureAdaptor;


describe(AdaptorDetector::class, function() {

    describe('#detect', function() {
        context('when enabled', function() {
            beforeEach(function() {
                $this->detector = new AdaptorDetector([
                    EnableFixtureAdaptor::class
                ]);
            });
            it('return adaptor instance', function() {
                $adaptor = $this->detector->detect();
                expect($adaptor)->toBeAnInstanceOf(Adaptor::class);
            });
        });
        context('when not enabled', function() {
            beforeEach(function() {
                $this->detector = new AdaptorDetector([
                    FixtureAdaptor::class
                ]);
            });
            it('throw cloak\driver\adaptor\AdaptorNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow(AdaptorNotFoundException::class);
            });
        });
    });

});

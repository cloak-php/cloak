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


describe('AdaptorDetector', function() {

    describe('#detect', function() {
        context('when enabled', function() {
            beforeEach(function() {
                $this->detector = new AdaptorDetector([
                    'cloak\driver\adaptor\XdebugAdaptor'
                ]);
            });
            it('return adaptor instance', function() {
                $adaptor = $this->detector->detect();
                expect($adaptor)->toBeAnInstanceOf('cloak\driver\AdaptorInterface');
            });
        });
        context('when not enabled', function() {
            beforeEach(function() {
                $this->detector = new AdaptorDetector([
                    'cloak\spec\driver\adaptor\FixtureAdaptor'
                ]);
            });
            it('throw cloak\driver\adaptor\AdaptorNotFoundException', function() {
                expect(function() {
                    $this->detector->detect();
                })->toThrow('cloak\driver\adaptor\AdaptorNotFoundException');
            });
        });
    });

});

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\adaptor\XdebugAdaptor;


describe(XdebugAdaptor::class, function() {
    describe('#stop', function() {
        beforeEach(function() {
            $this->adaptor = new XdebugAdaptor();
            $this->adaptor->start();
            $this->results = $this->adaptor->stop();
        });
        it('report of coverage is being collected', function() {
            expect($this->results)->toBeAn('array');
        });
    });
});

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\value\LineRange;

describe('LineRange', function() {

    before(function() {
        $this->range = new LineRange(1, 3);
    });

    describe('#getStartLineNumber', function() {
        it('return start line number', function() {
            expect($this->range->getStartLineNumber())->toEqual(1);
        });
    });

    describe('#getEndLineNumber', function() {
        it('return end line number', function() {
            expect($this->range->getEndLineNumber())->toEqual(3);
        });
    });

});

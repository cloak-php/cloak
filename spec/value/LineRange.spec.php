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
use cloak\value\LessThanLineNumberException;
use cloak\value\UnexpectedLineNumberException;


describe(LineRange::class, function() {

    beforeEach(function() {
        $this->range = new LineRange(2, 3);
    });

    describe('#__construct', function() {
        context('when invalid renge', function() {
            it('throw cloak\value\LessThanLineNumberException', function() {
                expect(function() {
                    new LineRange(5, 4);
                })->toThrow(LessThanLineNumberException::class);
            });
        });
        context('when start line number less than 1', function() {
            it('throw cloak\value\UnexpectedLineNumberException', function() {
                expect(function() {
                    new LineRange(0, 4);
                })->toThrow(UnexpectedLineNumberException::class);
            });
        });
        context('when end line number less than 1', function() {
            it('throw cloak\value\UnexpectedLineNumberException', function() {
                expect(function() {
                    new LineRange(1, 0);
                })->toThrow(UnexpectedLineNumberException::class);
            });
        });
    });

    describe('#getStartLineNumber', function() {
        it('return start line number', function() {
            expect($this->range->getStartLineNumber())->toEqual(2);
        });
    });

    describe('#getEndLineNumber', function() {
        it('return end line number', function() {
            expect($this->range->getEndLineNumber())->toEqual(3);
        });
    });

    describe('#contains', function() {
        context('when less than start line number', function() {
            it('return false', function() {
                expect($this->range->contains(1))->toBeFalse();
            });
        });
        context('when contains', function() {
            it('return true', function() {
                expect($this->range->contains(2))->toBeTrue();
            });
        });
        context('when greater than start line number', function() {
            it('return false', function() {
                expect($this->range->contains(4))->toBeFalse();
            });
        });
    });

});

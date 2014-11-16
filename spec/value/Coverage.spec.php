<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\value\Coverage;

describe('Coverage', function() {

    describe('#equals', function() {
        context('when same value', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(10);
                expect($v1->equals($v2))->toBeTrue();
            });
        });
        context('when not same value', function() {
            it('return false', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(11);
                expect($v1->equals($v2))->toBeFalse();
            });
        });
    });

    describe('#lessEquals', function() {
        context('when same value', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(10);
                expect($v1->lessEquals($v2))->toBeTrue();
            });
        });
        context('when less than to 11', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(11);
                expect($v1->lessEquals($v2))->toBeTrue();
            });
        });
    });

    describe('#lessThan', function() {
        context('when same value', function() {
            it('return false', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(10);
                expect($v1->lessThan($v2))->toBeFalse();
            });
        });
        context('when less than to 11', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(11);
                expect($v1->lessThan($v2))->toBeTrue();
            });
        });
    });

    describe('#greaterEqual', function() {
        context('when same value', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(10);
                expect($v1->greaterEqual($v2))->toBeTrue();
            });
        });
        context('when greater than to 10', function() {
            it('return true', function() {
                $v1 = new Coverage(11);
                $v2 = new Coverage(10);
                expect($v1->greaterEqual($v2))->toBeTrue();
            });
        });
    });

    describe('#greaterThan', function() {
        context('when same value', function() {
            it('return true', function() {
                $v1 = new Coverage(10);
                $v2 = new Coverage(10);
                expect($v1->greaterThan($v2))->toBeFalse();
            });
        });
        context('when greater than to 10', function() {
            it('return true', function() {
                $v1 = new Coverage(11);
                $v2 = new Coverage(10);
                expect($v1->greaterThan($v2))->toBeTrue();
            });
        });
    });

    describe('#value', function() {
        it('return float value', function() {
            $v = new Coverage(11);
            expect( is_float($v->value() ))->toBeTrue();
        });
    });

    describe('#formattedValue', function() {
        it('return formatted string value', function() {
            $v = new Coverage(11);
            expect( $v->formattedValue() )->toEqual(' 11.00%');
        });
    });

    describe('#__toString', function() {
        it('return string value', function() {
            $v = new Coverage(11);
            expect( $v->__toString() )->toBeA('string');
        });
    });

});

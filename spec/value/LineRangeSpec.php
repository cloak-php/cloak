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
use cloak\result\Line;

describe('LineRange', function() {

    before(function() {
        $this->range = new LineRange(2, 3);
    });

    describe('#__construct', function() {
        context('when invalid renge', function() {
            it('throw \InvalidArgumentException', function() {
                expect(function() {
                    (new LineRange(5, 4));
                })->toThrow('\InvalidArgumentException');
            });
        });
        context('when start line number less than 1', function() {
            it('throw \InvalidArgumentException', function() {
                expect(function() {
                    (new LineRange(0, 4));
                })->toThrow('\InvalidArgumentException');
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
            before(function() {
                $this->line = new Line(1, Line::EXECUTED);
            });
            it('return false', function() {
                expect($this->range->contains($this->line))->toBeFalse();
            });
        });
        context('when contains', function() {
            before(function() {
                $this->line = new Line(2, Line::EXECUTED);
            });
            it('return true', function() {
                expect($this->range->contains($this->line))->toBeTrue();
            });
        });
        context('when greater than start line number', function() {
            before(function() {
                $this->line = new Line(4, Line::EXECUTED);
            });
            it('return false', function() {
                expect($this->range->contains($this->line))->toBeFalse();
            });
        });
    });

});

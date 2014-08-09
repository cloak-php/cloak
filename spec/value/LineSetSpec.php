<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\value\LineSet;
use cloak\value\Coverage;
use cloak\result\Line;
use PhpCollection\Sequence;


describe('LineSet', function() {

    describe('#getCodeCoverage', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::UNUSED),
                new Line(2, Line::EXECUTED)
            ]));
        });
        it('should return the value of code coverage', function() {
            expect($this->lineSet->getCodeCoverage()->valueOf())->toBe(50.00);
        });
    });

    describe('#getDeadLineCount', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::DEAD),
                new Line(2, Line::UNUSED)
            ]));
        });
        it('should return total number of lines is dead', function() {
            expect($this->lineSet->getDeadLineCount())->toBe(1);
        });
    });

    describe('#getUnusedLineCount', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::DEAD),
                new Line(2, Line::UNUSED)
            ]));
        });
        it('should return total number of lines is unused', function() {
            expect($this->lineSet->getUnusedLineCount())->toBe(1);
        });
    });

    describe('#getExecutedLineCount', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::DEAD),
                new Line(2, Line::EXECUTED)
            ]));
        });
        it('return total number of lines is executed', function() {
            expect($this->lineSet->getExecutedLineCount())->toBe(1);
        });
    });

    describe('#getExecutableLineCount', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::DEAD),
                new Line(2, Line::UNUSED),
                new Line(3, Line::EXECUTED)
            ]));
        });
        it('return total number of lines is excutalbe', function() {
            expect($this->lineSet->getExecutableLineCount())->toBe(2);
        });
    });

    describe('#isCoverageLessThan', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::UNUSED),
                new Line(2, Line::EXECUTED)
            ]));
        });
        context('when less than 51% of coverage', function() {
            it('return true', function() {
                $coverage = new Coverage(51);
                expect($this->lineSet->isCoverageLessThan($coverage))->toBeTrue();
            });
        });
        context('when greater than 50% of coverage', function() {
            it('return false', function() {
                $coverage = new Coverage(50);
                expect($this->lineSet->isCoverageLessThan($coverage))->toBeFalse();
            });
        });
    });

    describe('#isCoverageGreaterEqual', function() {
        before(function() {
            $this->lineSet = new LineSet(new Sequence([
                new Line(1, Line::UNUSED),
                new Line(2, Line::EXECUTED)
            ]));
        });
        context('when less than 51% of coverage', function() {
            it('return false', function() {
                $coverage = new Coverage(51);
                expect($this->lineSet->isCoverageGreaterEqual($coverage))->toBeFalse();
            });
        });
        context('when greater than 50% of coverage', function() {
            it('return true', function() {
                $coverage = new Coverage(50);
                expect($this->lineSet->isCoverageGreaterEqual($coverage))->toBeTrue();
            });
        });
    });

    describe('#selectRange', function() {
    });

});

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
use cloak\value\LineRange;
use cloak\result\LineResult;
use cloak\result\collection\LineResultCollection;


describe('LineResultCollection', function() {

    describe('#getCodeCoverage', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::UNUSED),
                new LineResult(2, LineResult::EXECUTED)
            ]);
        });
        it('should return the value of code coverage', function() {
            expect($this->lineSet->getCodeCoverage()->value())->toEqual(50.00);
        });
    });

    describe('#getDeadLineCount', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::DEAD),
                new LineResult(2, LineResult::UNUSED)
            ]);
        });
        it('should return total number of lines is dead', function() {
            expect($this->lineSet->getDeadLineCount())->toEqual(1);
        });
    });

    describe('#getUnusedLineCount', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::DEAD),
                new LineResult(2, LineResult::UNUSED)
            ]);
        });
        it('should return total number of lines is unused', function() {
            expect($this->lineSet->getUnusedLineCount())->toEqual(1);
        });
    });

    describe('#getExecutedLineCount', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::DEAD),
                new LineResult(2, LineResult::EXECUTED)
            ]);
        });
        it('return total number of lines is executed', function() {
            expect($this->lineSet->getExecutedLineCount())->toEqual(1);
        });
    });

    describe('#getExecutableLineCount', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::DEAD),
                new LineResult(2, LineResult::UNUSED),
                new LineResult(3, LineResult::EXECUTED)
            ]);
        });
        it('return total number of lines is excutalbe', function() {
            expect($this->lineSet->getExecutableLineCount())->toEqual(2);
        });
    });

    describe('#isCoverageLessThan', function() {
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::UNUSED),
                new LineResult(2, LineResult::EXECUTED)
            ]);
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
        beforeEach(function() {
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::UNUSED),
                new LineResult(2, LineResult::EXECUTED)
            ]);
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
        beforeEach(function() {
            $this->range = new LineRange(2, 4);
            $this->lineSet = new LineResultCollection([
                new LineResult(1, LineResult::UNUSED),
                new LineResult(2, LineResult::EXECUTED),
                new LineResult(3, LineResult::EXECUTED),
                new LineResult(4, LineResult::EXECUTED),
                new LineResult(5, LineResult::EXECUTED),
            ]);

            $this->newLineSet = $this->lineSet->selectRange($this->range);

            $this->firstLine = $this->newLineSet->first();
            $this->lastLine = $this->newLineSet->last();
        });
        it('return first line', function() {
            expect($this->firstLine->getLineNumber())->toEqual(2);
        });
        it('return last line', function() {
            expect($this->lastLine->getLineNumber())->toEqual(4);
        });
    });

});

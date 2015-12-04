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
use cloak\spec\result\FixtureCoverageResult;
use cloak\result\CoverageResult;
use cloak\analyzer\result\LineResult;
use cloak\result\collection\LineResultCollection;

describe(CoverageResult::class, function() {
    describe('#getLineCount', function() {
        beforeEach(function() {
            $this->lines = new LineResultCollection([
                new LineResult(5, LineResult::EXECUTED),
                new LineResult(6, LineResult::EXECUTED)
            ]);
            $this->result = new FixtureCoverageResult( $this->lines );
        });
        it('returns the line count', function() {
            expect($this->result->getLineCount())->toBe(2);
        });
    });
    describe('#getDeadLineCount', function() {
        beforeEach(function() {
            $this->lines = new LineResultCollection([
                new LineResult(5, LineResult::DEAD),
                new LineResult(6, LineResult::EXECUTED)
            ]);
            $this->result = new FixtureCoverageResult( $this->lines );
        });
        it('returns the deat line count', function() {
            expect($this->result->getDeadLineCount())->toBe(1);
        });
    });
    describe('#getUnusedLineCount', function() {
        beforeEach(function() {
            $this->lines = new LineResultCollection([
                new LineResult(5, LineResult::DEAD),
                new LineResult(6, LineResult::UNUSED)
            ]);
            $this->result = new FixtureCoverageResult( $this->lines );
        });
        it('returns the unused line count', function() {
            expect($this->result->getUnusedLineCount())->toBe(1);
        });
    });
    describe('#getExecutedLineCount', function() {
        beforeEach(function() {
            $this->lines = new LineResultCollection([
                new LineResult(5, LineResult::DEAD),
                new LineResult(6, LineResult::EXECUTED)
            ]);
            $this->result = new FixtureCoverageResult( $this->lines );
        });
        it('returns the executed line count', function() {
            expect($this->result->getExecutedLineCount())->toBe(1);
        });
    });

    describe('#getCodeCoverage', function() {
        beforeEach(function() {
            $this->lines = new LineResultCollection([
                new LineResult(5, LineResult::DEAD),
                new LineResult(6, LineResult::EXECUTED)
            ]);
            $this->result = new FixtureCoverageResult( $this->lines );
        });
        it('returns the code coverage value', function() {
            expect($this->result->getCodeCoverage()->value())->toBe(100.0);
        });
    });

    describe('#isCoverageLessThan', function() {
        context('when coverage < 51', function () {
            beforeEach(function() {
                $this->coverage = new Coverage(51);
                $this->lines = new LineResultCollection([
                    new LineResult(5, LineResult::UNUSED),
                    new LineResult(6, LineResult::EXECUTED)
                ]);
                $this->result = new FixtureCoverageResult( $this->lines );
            });
            it('returns true', function() {
                $result = $this->result->isCoverageLessThan($this->coverage);
                expect($result)->toBeTrue();
            });
        });
    });

    describe('#isCoverageGreaterEqual', function() {
        context('when coverage < 51', function () {
            beforeEach(function() {
                $this->coverage = new Coverage(51);
                $this->lines = new LineResultCollection([
                    new LineResult(5, LineResult::UNUSED),
                    new LineResult(6, LineResult::EXECUTED)
                ]);
                $this->result = new FixtureCoverageResult( $this->lines );
            });
            it('returns false', function() {
                $result = $this->result->isCoverageGreaterEqual($this->coverage);
                expect($result)->toBeFalse();
            });
        });
    });

});

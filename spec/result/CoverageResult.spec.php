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
use cloak\result\collection\LineResultCollection;
use cloak\result\CoverageResult;
use Prophecy\Prophet;


describe(CoverageResult::class, function() {
    describe('#getLineCount', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->getLineCount()->willReturn(10);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#getLineCount', function() {
            expect($this->result->getLineCount())->toBe(10);
        });
    });

    describe('#getDeadLineCount', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->getDeadLineCount()->willReturn(10);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#getDeadLineCount', function() {
            expect($this->result->getDeadLineCount())->toBe(10);
        });
    });

    describe('#getUnusedLineCount', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->getUnusedLineCount()->willReturn(10);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#getUnusedLineCount', function() {
            expect($this->result->getUnusedLineCount())->toBe(10);
        });
    });

    describe('#getExecutedLineCount', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->getExecutedLineCount()->willReturn(10);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#getExecutedLineCount', function() {
            expect($this->result->getExecutedLineCount())->toBe(10);
        });
    });

    describe('#getCodeCoverage', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->getCodeCoverage()->willReturn(100);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#getCodeCoverage', function() {
            expect($this->result->getCodeCoverage())->toBe(100);
        });
    });

    describe('#isCoverageLessThan', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();
            $this->coverage = new Coverage(51);

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->isCoverageLessThan($this->coverage)->willReturn(true);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#isCoverageLessThan', function() {
            $result = $this->result->isCoverageLessThan($this->coverage);
            expect($result)->toBeTrue();
        });
    });

    describe('#isCoverageGreaterEqual', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();
            $this->coverage = new Coverage(51);

            $lineResult = $this->prophet->prophesize(LineResultCollection::class);
            $lineResult->isCoverageGreaterEqual($this->coverage)
                ->willReturn(false);

            $this->result = new FixtureCoverageResult( $lineResult->reveal() );
        });
        it('delegate to LineResultCollectionInterface#isCoverageGreaterEqual', function() {
            $result = $this->result->isCoverageGreaterEqual($this->coverage);
            expect($result)->toBeFalse();
        });
    });

});

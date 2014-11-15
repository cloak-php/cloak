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
use \Mockery;


describe('CoverageResult', function() {
    describe('#getLineCount', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('getLineCount')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->getLineCount();
        });
        it('delegate to LineResultCollectionInterface#getLineCount', function() {
            Mockery::close();
        });
    });

    describe('#getDeadLineCount', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('getDeadLineCount')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->getDeadLineCount();
        });
        it('delegate to LineResultCollectionInterface#getDeadLineCount', function() {
            Mockery::close();
        });
    });

    describe('#getUnusedLineCount', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('getUnusedLineCount')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->getUnusedLineCount();
        });
        it('delegate to LineResultCollectionInterface#getUnusedLineCount', function() {
            Mockery::close();
        });
    });

    describe('#getExecutedLineCount', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('getExecutedLineCount')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->getExecutedLineCount();
        });
        it('delegate to LineResultCollectionInterface#getExecutedLineCount', function() {
            Mockery::close();
        });
    });

    describe('#getCodeCoverage', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('getCodeCoverage')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->getCodeCoverage();
        });
        it('delegate to LineResultCollectionInterface#getCodeCoverage', function() {
            Mockery::close();
        });
    });

    describe('#isCoverageLessThan', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('isCoverageLessThan')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->isCoverageLessThan(new Coverage(51));
        });
        it('delegate to LineResultCollectionInterface#isCoverageLessThan', function() {
            Mockery::close();
        });
    });

    describe('#isCoverageGreaterEqual', function() {
        beforeEach(function() {
            $lineResult = Mockery::mock('\cloak\result\LineResultCollectionInterface');
            $lineResult->shouldReceive('isCoverageGreaterEqual')->once();

            $result = new FixtureCoverageResult($lineResult);
            $result->isCoverageGreaterEqual(new Coverage(51));
        });
        it('delegate to LineResultCollectionInterface#isCoverageGreaterEqual', function() {
            Mockery::close();
        });
    });

});

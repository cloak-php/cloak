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
use cloak\value\CoverageBound;

describe('CoverageBound', function() {
    beforeEach(function() {
        $this->coverageBound = new CoverageBound(30.0, 75.0);
    });
    describe('#getCriticalCoverage', function() {
        beforeEach(function() {
            $this->coverage = $this->coverageBound->getCriticalCoverage();
        });
        it('return low coverage bound', function() {
            expect($this->coverage->value())->toEqual(30.0);
        });
    });
    describe('#getSatisfactoryCoverage', function() {
        beforeEach(function() {
            $this->coverage = $this->coverageBound->getSatisfactoryCoverage();
        });
        it('return high coverage bound', function() {
            expect($this->coverage->value())->toEqual(75.0);
        });
    });
    describe('#isSatisfactory', function() {
        context('when less than', function() {
            beforeEach(function() {
                $this->returnValue = $this->coverageBound->isSatisfactory(new Coverage(74.0));
            });
            it('return false', function() {
                expect($this->returnValue)->toBeFalse();
            });
        });
        context('when greater equal than', function() {
            beforeEach(function() {
                $this->returnValue = $this->coverageBound->isSatisfactory(new Coverage(75.0));
            });
            it('return true', function() {
                expect($this->returnValue)->toBeTrue();
            });
        });
    });
    describe('#isCritical', function() {
        context('when greater than', function() {
            beforeEach(function() {
                $this->returnValue = $this->coverageBound->isCritical(new Coverage(31.0));
            });
            it('return false', function() {
                expect($this->returnValue)->toBeFalse();
            });
        });
        context('when equal', function() {
            beforeEach(function() {
                $this->returnValue = $this->coverageBound->isCritical(new Coverage(30.0));
            });
            it('return false', function() {
                expect($this->returnValue)->toBeFalse();
            });
        });
        context('when less than', function() {
            beforeEach(function() {
                $this->returnValue = $this->coverageBound->isCritical(new Coverage(29.0));
            });
            it('return true', function() {
                expect($this->returnValue)->toBeTrue();
            });
        });
    });
});

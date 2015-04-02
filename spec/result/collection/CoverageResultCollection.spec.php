<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\collection\CoverageResultCollection;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;
use cloak\result\collection\LineResultCollection;
use cloak\result\LineResult;
use cloak\value\Coverage;
use cloak\reflection\ClassReflection;


describe('CoverageResultCollection', function() {

    describe('#add', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(12, LineResult::EXECUTED),
                new LineResult(17, LineResult::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');

            $this->results = new CoverageResultCollection();
            $this->results->add(new ClassResult($classReflection, $lineSet));
        });
        it('add coverage result', function() {
            expect($this->results->count())->toEqual(1);
        });
    });
    describe('#merge', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(12, LineResult::EXECUTED),
                new LineResult(17, LineResult::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');

            $result1 = new CoverageResultCollection();
            $result1->add(new ClassResult($classReflection, $lineSet));

            $lineSet = new LineResultCollection([
                new LineResult(11, LineResult::EXECUTED)
            ]);
            $traitReflection = new ClassReflection('Example\\ExampleTrait');

            $result2 = new CoverageResultCollection();
            $result2->add(new TraitResult($traitReflection, $lineSet));

            $this->result = $result1->merge($result2);
        });
        it('merge coverage result', function() {
            expect($this->result->count())->toEqual(2);
        });
    });

    describe('#exclude', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(29, LineResult::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');
            $classResult = new ClassResult($classReflection, $lineSet);

            $originalResult = new CoverageResultCollection();
            $originalResult->add($classResult);

            $excludeResult = new CoverageResultCollection();
            $excludeResult->add($classResult);

            $this->result = $originalResult->exclude($excludeResult);
        });
        it('return excluded new collection', function() {
            expect($this->result->isEmpty())->toBeTrue();
        });
    });

    describe('#selectByCoverageLessThan', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(24, LineResult::EXECUTED),
                new LineResult(29, LineResult::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');
            $classResult = new ClassResult($classReflection, $lineSet);

            $result = new CoverageResultCollection();
            $result->add($classResult);

            $this->result = $result;
        });
        context('when have lower result', function() {
            it('return select new collection', function() {
                $selectResult = $this->result->selectByCoverageLessThan(new Coverage(51.0));
                expect($selectResult->count())->toEqual(1);
            });
        });
        context('when have not lower result', function() {
            it('return empty collection', function() {
                $selectResult = $this->result->selectByCoverageLessThan(new Coverage(50.0));
                expect($selectResult->isEmpty())->toBeTrue();
            });
        });
    });

    describe('#selectByCoverageGreaterEqual', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(24, LineResult::EXECUTED),
                new LineResult(29, LineResult::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');
            $classResult = new ClassResult($classReflection, $lineSet);

            $result = new CoverageResultCollection();
            $result->add($classResult);

            $this->result = $result;
        });
        context('when have higher result', function() {
            it('return select new collection', function() {
                $selectResult = $this->result->selectByCoverageGreaterEqual(new Coverage(50.0));
                expect($selectResult->count())->toEqual(1);
            });
        });
        context('when have not higher result', function() {
            it('return empty collection', function() {
                $selectResult = $this->result->selectByCoverageGreaterEqual(new Coverage(51.0));
                expect($selectResult->isEmpty())->toBeTrue();
            });
        });
    });

});

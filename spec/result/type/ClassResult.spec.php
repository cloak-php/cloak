<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\type\ClassResult;
use cloak\result\collection\LineResultCollection;
use cloak\result\LineResult;
use cloak\reflection\ClassReflection;
use cloak\result\collection\CoverageResultCollection;
use Example\Example;


describe(ClassResult::class, function() {
    beforeEach(function() {
        $lineSet = new LineResultCollection([
            new LineResult(24, LineResult::EXECUTED),
            new LineResult(29, LineResult::UNUSED)
        ]);
        $classReflection = new ClassReflection(Example::class);

        $this->result = new ClassResult($classReflection, $lineSet);
    });
    describe('getName', function() {
        it('return class name', function() {
            expect($this->result->getName())->toEqual(Example::class);
        });
    });
    describe('getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->result->getNamespaceName())->toEqual('Example');
        });
    });
    describe('getMethodResults', function() {
        beforeEach(function() {
            $this->methodResults = $this->result->getMethodResults();
        });
        it('return cloak\result\collection\CoverageResultCollection instance', function() {
            expect($this->methodResults)->toBeAnInstanceOf(CoverageResultCollection::class);
        });
        context('when all results', function() {
            it('return results', function() {
                expect(count($this->methodResults))->toEqual(2);
            });
        });
    });

});

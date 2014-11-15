<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\ResultFactory;
use cloak\result\collection\LineResultCollection;
use cloak\result\LineResult;
use cloak\reflection\FileReflection;


describe('ResultFactory', function() {
    beforeEach(function() {
        $filePath = __DIR__ . '/../fixtures/src/foo.php';
        $reflection = new FileReflection($filePath);

        $this->factory = new ResultFactory($reflection);
    });
    describe('createClassResults', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(12, LineResult::EXECUTED)
            ]);
            $this->results = $this->factory->createClassResults($lineSet);
        });
        it('return \cloak\result\collection\CoverageResultCollection', function() {
            expect($this->results)->toBeAnInstanceOf('\cloak\result\collection\CoverageResultCollection');
        });
        it('ClassResult only not included in the results', function() {
            expect(count($this->results))->toEqual(1);
        });
    });
    describe('createTraitResults', function() {
        beforeEach(function() {
            $lineSet = new LineResultCollection([
                new LineResult(12, LineResult::EXECUTED)
            ]);
            $this->results = $this->factory->createTraitResults($lineSet);
        });
        it('return \cloak\result\collection\CoverageResultCollection', function() {
            expect($this->results)->toBeAnInstanceOf('\cloak\result\collection\CoverageResultCollection');
        });
        it('TraitResult only not included in the results', function() {
            expect(count($this->results))->toEqual(1);
        });
    });
});

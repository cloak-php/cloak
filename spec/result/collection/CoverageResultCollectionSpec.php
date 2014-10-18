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
use cloak\reflection\ClassReflection;


describe('CoverageResultCollection', function() {

    describe('#add', function() {
        before(function() {
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
        before(function() {
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

});

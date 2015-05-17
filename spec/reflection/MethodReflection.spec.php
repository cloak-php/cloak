<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\reflection\MethodReflection;
use cloak\result\collection\LineResultCollection;
use cloak\analyzer\result\LineResult;
use cloak\result\LineResultSelectable;
use cloak\result\MethodResult;
use \Prophecy\Prophet;


describe(MethodReflection::class, function() {
    beforeEach(function() {
        $this->reflection = new MethodReflection('Example\Example', 'getValue');
    });
    describe('#convertToResult', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $results = new LineResultCollection([
                new LineResult(29, LineResult::UNUSED)
            ]);

            $selector = $this->prophet->prophesize(LineResultSelectable::class);
            $selector->selectByReflection($this->reflection)
                ->willReturn($results);

            $this->result = $this->reflection->convertToResult($selector->reveal());
        });
        it('return cloak\result\MethodResult', function() {
            expect($this->result)->toBeAnInstanceOf(MethodResult::class);
        });
        context('when line 29 unused', function() {
            it('have unused line result', function() {
                expect($this->result->getUnusedLineCount())->toEqual(1);
            });
            it('have not executed line result', function() {
                expect($this->result->getExecutedLineCount())->toEqual(0);
            });
        });
    });
});

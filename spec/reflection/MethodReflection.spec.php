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
use cloak\result\LineResult;


describe('MethodReflection', function() {
    beforeEach(function() {
        $this->reflection = new MethodReflection('Example\Example', 'getValue');
    });
    describe('#convertToResult', function() {
        beforeEach(function() {
            $result = $this->reflection->convertToResult(new LineResultCollection([
                new LineResult(29, LineResult::UNUSED)
            ]));
            $this->result = $result;
        });
        it('return cloak\result\MethodResult', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\MethodResult');
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

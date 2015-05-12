<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\MethodResult;
use cloak\result\collection\LineResultCollection;
use cloak\analyzer\result\LineResult;
use cloak\reflection\MethodReflection;


describe(MethodResult::class, function() {
    beforeEach(function() {
        $lineSet = new LineResultCollection([
            new LineResult(12, LineResult::EXECUTED)
        ]);
        $methodReflection = new MethodReflection('Example\\Example', '__construct');
        $this->result = new MethodResult($methodReflection, $lineSet);
    });
    describe('getName', function() {
        it('return method name', function() {
            expect($this->result->getName())->toEqual('__construct');
        });
    });
    describe('getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->result->getNamespaceName())->toEqual('Example');
        });
    });

});

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
use cloak\result\LineSet;

describe('MethodReflection', function() {
    describe('assembleBy', function() {
        before(function() {
            $reflection = new MethodReflection('Example\Example', 'getValue');
            $this->result = $reflection->assembleBy(new LineSet());
        });
        it('return cloak\result\MethodResult', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\MethodResult');
        });
    });
});

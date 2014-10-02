<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\reflection\ClassReflection;

describe('ClassReflection', function() {

    describe('#getMethods', function() {
        before(function() {
            $reflection = new ClassReflection('Example\Example');
            $this->result = $reflection->getMethods();
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\reflection\collection\ReflectionCollection');
        });
        it('return a collection of classes', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });

});

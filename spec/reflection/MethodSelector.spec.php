<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\reflection\MethodSelector;


describe('MethodSelector', function() {
    beforeEach(function() {
        $this->parentClass = 'cloak\spec\reflection\FixtureTargetClass';
        $this->subClass = 'cloak\spec\reflection\FixtureTargetSubClass';

        $reflection = new ReflectionClass($this->subClass);
        $classMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        $this->selector = new MethodSelector($classMethods);
    });
    describe('#excludeNative', function() {
        it('return filter result', function() {
            $selector = $this->selector->excludeNative();
            expect($selector->count())->toBe(4);
        });
    });
    describe('#excludeInherited', function() {
        it('return filter result', function() {
            $selector = $this->selector->excludeInherited($this->parentClass);
            expect($selector->count())->toBe(1);
        });
    });
    describe('#excludeTraitMethods', function() {
        beforeEach(function() {
            $this->class = 'cloak\spec\reflection\FixtureTargetClass';

            $reflection = new ReflectionClass($this->class);
            $classMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            $this->selector = new MethodSelector($classMethods);
        });
        it('return filter result', function() {
            $selector = $this->selector->excludeTraitMethods($this->class);
            expect($selector->count())->toBe(1);
        });
    });
    describe('#toCollection', function() {
        beforeEach(function() {
            $this->class = 'cloak\spec\reflection\FixtureTargetClass';

            $reflection = new ReflectionClass($this->class);
            $classMethods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);

            $this->selector = new MethodSelector($classMethods);
            $this->collection = $this->selector->toCollection();
        });
        it('return cloak\reflection\collection\ReflectionCollection instance', function() {
            expect($this->collection->count())->toBe(2);
            expect($this->collection)->toBeAnInstanceOf('cloak\reflection\collection\ReflectionCollection');
        });
    });
});

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
use cloak\reflection\collection\ReflectionCollection;
use \Mockery;


describe('ReflectionCollection', function() {
    describe('assembleBy', function() {
        beforeEach(function() {
            $this->mock = Mockery::mock('cloak\result\LineSetInterface');
            $this->mock->shouldReceive('resolveLineResults')->once();

            $this->classReflection = new ReflectionCollection();
            $this->classReflection->add(new ClassReflection('Example\Example'));
            $this->result = $this->classReflection->assembleBy($this->mock);
        });
        it('return cloak\result\collection\CoverageResultCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\collection\CoverageResultCollection');
        });
        it('converted to results', function() {
            Mockery::close();
        });
    });
});

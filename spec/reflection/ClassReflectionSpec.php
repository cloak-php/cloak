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
use cloak\result\LineSet;
use cloak\result\Line;

describe('ClassReflection', function() {
    before(function() {
        $this->reflection = new ClassReflection('Example\Example');
    });
    describe('#getMethods', function() {
        before(function() {
            $this->result = $this->reflection->getMethods();
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\reflection\collection\ReflectionCollection');
        });
        it('return a collection of classes', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });
    describe('assembleBy', function() {
        before(function() {
            $result = $this->reflection->assembleBy(new LineSet([
                new Line(24, Line::EXECUTED),
                new Line(29, Line::UNUSED)
            ]));
            $this->result = $result;
        });
        describe('assemble result', function() {
            it('return cloak\result\type\ClassResult', function() {
                expect($this->result)->toBeAnInstanceOf('cloak\result\type\ClassResult');
            });
            it('have unused line result', function() {
                expect($this->result->getUnusedLineCount())->toBe(1);
            });
            it('have executed line result', function() {
                expect($this->result->getExecutedLineCount())->toBe(1);
            });
        });
    });

});

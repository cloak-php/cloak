<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\reflection\FileReflection;
use cloak\reflection\ClassReflection;
use cloak\result\collection\LineResultCollection;
use cloak\result\LineResult;


describe('FileReflection', function() {

    before(function() {
        $filePath = __DIR__ . '/../fixtures/src/foo.php';
        $this->reflection = new FileReflection($filePath);
    });

    describe('#getClasses', function() {
        before(function() {
            $result = $this->reflection->getClasses();
            $result = $result->filter(function(ClassReflection $reflection) {
                return $reflection->isTrait();
            });
            $this->result = $result;
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\reflection\collection\ReflectionCollection');
        });
        it('return a collection of classes', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });

    describe('#getTraits', function() {
        before(function() {
            $result = $this->reflection->getTraits();
            $result = $result->filter(function(ClassReflection $reflection) {
                return $reflection->isClass();
            });
            $this->result = $result;
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\reflection\collection\ReflectionCollection');
        });
        it('return a collection of tratis', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });

    describe('#assembleBy', function() {
        before(function() {
            $result = $this->reflection->assembleBy(new LineResultCollection([
                new LineResult(11, LineResult::UNUSED)
            ]));
            $this->result = $result;
        });
        it('return cloak\result\FileResult', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\FileResult');
        });
        context('when line 11 unused', function() {
            it('have unused line result', function() {
                expect($this->result->getUnusedLineCount())->toBe(1);
            });
            it('have not executed line result', function() {
                expect($this->result->getExecutedLineCount())->toBe(0);
            });
        });
    });
});

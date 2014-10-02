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


describe('FileReflection', function() {

    describe('#getClasses', function() {
        before(function() {
            $filePath = __DIR__ . '/../fixtures/src/foo.php';
            $reflection = new FileReflection($filePath);

            $result = $reflection->getClasses();
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
            $filePath = __DIR__ . '/../fixtures/src/foo.php';
            $reflection = new FileReflection($filePath);

            $result = $reflection->getTraits();
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

});

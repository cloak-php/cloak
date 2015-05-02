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
use cloak\reflection\collection\ReflectionCollection;
use cloak\result\LineResultSelectable;
use cloak\result\FileResult;
use \Prophecy\Prophet;


describe(FileReflection::class, function() {

    beforeEach(function() {
        $filePath = __DIR__ . '/../fixtures/src/foo.php';
        $this->reflection = new FileReflection($filePath);
    });

    describe('#getClasses', function() {
        beforeEach(function() {
            $result = $this->reflection->getClasses();
            $result = $result->filter(function(ClassReflection $reflection) {
                return $reflection->isTrait();
            });
            $this->result = $result;
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf(ReflectionCollection::class);
        });
        it('return a collection of classes', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });

    describe('#getTraits', function() {
        beforeEach(function() {
            $result = $this->reflection->getTraits();
            $result = $result->filter(function(ClassReflection $reflection) {
                return $reflection->isClass();
            });
            $this->result = $result;
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf(ReflectionCollection::class);
        });
        it('return a collection of tratis', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });

    describe('#convertToResult', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $results = new LineResultCollection([
                new LineResult(11, LineResult::UNUSED)
            ]);

            $selector = $this->prophet->prophesize(LineResultSelectable::class);
            $selector->selectByReflection($this->reflection)
                ->willReturn($results);

            $this->result = $this->reflection->convertToResult($selector->reveal());
        });
        it('return cloak\result\FileResult', function() {
            expect($this->result)->toBeAnInstanceOf(FileResult::class);
        });
        context('when line 11 unused', function() {
            it('have unused line result', function() {
                expect($this->result->getUnusedLineCount())->toEqual(1);
            });
            it('have not executed line result', function() {
                expect($this->result->getExecutedLineCount())->toEqual(0);
            });
        });
    });
});

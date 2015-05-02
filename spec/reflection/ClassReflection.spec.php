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
use cloak\result\collection\LineResultCollection;
use cloak\reflection\collection\ReflectionCollection;
use cloak\result\LineResultSelectable;
use cloak\result\LineResult;
use cloak\result\type\ClassResult;
use cloak\result\type\TraitResult;
use Example\Example;
use Example\ExampleTrait;
use \Prophecy\Prophet;


describe(ClassReflection::class, function() {
    beforeEach(function() {
        $this->classReflection = new ClassReflection(Example::class);
        $this->traitReflection = new ClassReflection(ExampleTrait::class);
    });
    describe('#getName', function() {
        it('return class name', function() {
            expect($this->classReflection->getName())->toEqual(Example::class);
        });
    });
    describe('#getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->classReflection->getNamespaceName())->toEqual('Example');
        });
    });
    describe('#isTrait', function() {
        context('when class', function() {
            it('return flase', function() {
                expect($this->classReflection->isTrait())->toBeFalse();
            });
        });
        context('when trait', function() {
            it('return true', function() {
                expect($this->traitReflection->isTrait())->toBeTrue();
            });
        });
    });
    describe('#isClass', function() {
        context('when class', function() {
            it('return true', function() {
            expect($this->classReflection->isClass())->toBeTrue();
            });
        });
        context('when trait', function() {
            it('return false', function() {
                expect($this->traitReflection->isClass())->toBeFalse();
            });
        });
    });
    describe('#getMethods', function() {
        beforeEach(function() {
            $this->result = $this->classReflection->getMethods();
        });
        it('return cloak\reflection\collection\ReflectionCollection', function() {
            expect($this->result)->toBeAnInstanceOf(ReflectionCollection::class);
        });
        it('return a collection of classes', function() {
            expect($this->result->isEmpty())->toBeFalse();
        });
    });
    describe('#convertToResult', function() {
        context('when class reflection', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $results = new LineResultCollection([
                    new LineResult(29, LineResult::UNUSED)
                ]);

                $selector = $this->prophet->prophesize(LineResultSelectable::class);
                $selector->selectByReflection($this->classReflection)
                    ->willReturn($results);

                $result = $this->classReflection->convertToResult($selector->reveal());
                $this->result = $result;
            });
            it('return cloak\result\type\ClassResult', function() {
                expect($this->result)->toBeAnInstanceOf(ClassResult::class);
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
        context('when trait reflection', function() {
            beforeEach(function() {
                $this->prophet = new Prophet();

                $results = new LineResultCollection([
                    new LineResult(11, LineResult::UNUSED)
                ]);

                $selector = $this->prophet->prophesize(LineResultSelectable::class);
                $selector->selectByReflection($this->traitReflection)
                    ->willReturn($results);

                $result = $this->traitReflection->convertToResult($selector->reveal());
                $this->result = $result;
            });
            it('return cloak\result\type\TraitResult', function() {
                expect($this->result)->toBeAnInstanceOf(TraitResult::class);
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
});

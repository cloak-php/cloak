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
use cloak\result\collection\LineResultCollection;
use Prophecy\Prophet;
use Prophecy\Argument;


describe('ReflectionCollection', function() {
    describe('#convertToResult', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $this->reflection = new ClassReflection('Example\Example');

            $this->collection = new ReflectionCollection();
            $this->collection->add($this->reflection);

            $selector = $this->prophet->prophesize('\cloak\result\LineResultSelectable');
            $selector->selectByReflection($this->reflection)
                ->willReturn(new LineResultCollection());

            $this->result = $this->collection->convertToResult( $selector->reveal() );
        });
        it('return cloak\result\collection\CoverageResultCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\collection\CoverageResultCollection');
            expect($this->result->count())->toBe(1);
        });
    });
});

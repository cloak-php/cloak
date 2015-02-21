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
    describe('assembleBy', function() {
        beforeEach(function() {
            $this->prophet = new Prophet();

            $lineSetMock = $this->prophet->prophesize('cloak\result\LineResultCollectionInterface');
            $lineSetMock->resolveLineResults(Argument::type('cloak\reflection\ClassReflection'))
                ->willReturn(new LineResultCollection());


            $lineSetMock->selectRange()->shouldNotBeCalled();
            $lineSetMock->getCodeCoverage()->shouldNotBeCalled();
            $lineSetMock->isCoverageLessThan()->shouldNotBeCalled();
            $lineSetMock->isCoverageGreaterEqual()->shouldNotBeCalled();
            $lineSetMock->getLineCount()->shouldNotBeCalled();
            $lineSetMock->getDeadLineCount()->shouldNotBeCalled();
            $lineSetMock->getUnusedLineCount()->shouldNotBeCalled();
            $lineSetMock->getExecutedLineCount()->shouldNotBeCalled();
            $lineSetMock->getExecutableLineCount()->shouldNotBeCalled();
            $lineSetMock->first()->shouldNotBeCalled();
            $lineSetMock->last()->shouldNotBeCalled();
            $lineSetMock->isEmpty()->shouldNotBeCalled();
            $lineSetMock->toArray()->shouldNotBeCalled();

            $this->classReflection = new ReflectionCollection();
            $this->classReflection->add(new ClassReflection('Example\Example'));
            $this->result = $this->classReflection->assembleBy( $lineSetMock->reveal() );
        });
        it('return cloak\result\collection\CoverageResultCollection', function() {
            expect($this->result)->toBeAnInstanceOf('cloak\result\collection\CoverageResultCollection');
        });
    });
});

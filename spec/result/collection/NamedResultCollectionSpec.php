<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\collection\NamedResultCollection;
use cloak\result\ClassResult;
use cloak\result\LineSet;
use cloak\result\Line;
use Zend\Code\Reflection\ClassReflection;

describe('ClassResultCollection', function() {
    describe('#add', function() {
        before(function() {
            $lineSet = new LineSet([
                new Line(12, Line::EXECUTED),
                new Line(17, Line::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');

            $this->results = new NamedResultCollection();
            $this->results->add(new ClassResult($classReflection, $lineSet));
        });
        it('add coverage result', function() {
            expect($this->results->count())->toEqual(1);
        });
    });
    describe('#getIterator', function() {
        before(function() {
            $lineSet = new LineSet([
                new Line(12, Line::EXECUTED),
                new Line(17, Line::UNUSED)
            ]);
            $classReflection = new ClassReflection('Example\\Example');

            $this->results = new NamedResultCollection();
            $this->results->add(new ClassResult($classReflection, $lineSet));
        });
        it('return ArrayIterator instance', function() {
            expect($this->results->getIterator())->toBeAnInstanceOf('ArrayIterator');
        });
    });
});

<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\ClassResult;
use cloak\result\LineSet;
use cloak\result\Line;
use Zend\Code\Reflection\ClassReflection;

describe('ClassResult', function() {
    before(function() {
        $lineSet = new LineSet([
            new Line(12, Line::EXECUTED),
            new Line(17, Line::UNUSED)
        ]);
        $classReflection = new ClassReflection('Example\\Example');

        $this->result = new ClassResult($classReflection, $lineSet);
    });
    describe('getMethodResults', function() {
        it('return method code coverage results');
    });
    describe('getName', function() {
        it('return class name', function() {
            expect($this->result->getName())->toEqual('Example\\Example');
        });
    });
    describe('getNamespaceName', function() {
        it('return namespace name', function() {
            expect($this->result->getNamespaceName())->toEqual('Example');
        });
    });
});

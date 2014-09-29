<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\result\ResultFactory;
use cloak\result\LineSet;
use cloak\result\Line;
use Zend\Code\Reflection\FileReflection;

describe('ResultFactory', function() {
    before(function() {
        $filePath = __DIR__ . '/../fixtures/src/foo.php';
        $reflection = new FileReflection($filePath);

        $this->factory = new ResultFactory($reflection);
    });
    describe('createClassResults', function() {
        before(function() {
            $lineSet = new LineSet([
                new Line(12, Line::EXECUTED)
            ]);
            $this->results = $this->factory->createClassResults($lineSet);
        });
        it('return \cloak\result\collection\NamedResultCollection', function() {
            expect($this->results)->toBeAnInstanceOf('\cloak\result\collection\NamedResultCollection');
        });
        it('ClassResult only not included in the results', function() {
            expect(count($this->results))->toEqual(1);
        });
    });
    describe('createTraitResults', function() {
        before(function() {
            $lineSet = new LineSet([
                new Line(12, Line::EXECUTED)
            ]);
            $this->results = $this->factory->createTraitResults($lineSet);
        });
        it('return \cloak\result\collection\NamedResultCollection', function() {
            expect($this->results)->toBeAnInstanceOf('\cloak\result\collection\NamedResultCollection');
        });
        it('TraitResult only not included in the results', function() {
            expect(count($this->results))->toEqual(1);
        });
    });
});

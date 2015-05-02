<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\Result;
use cloak\driver\result\FileResult;
use cloak\result\LineResult;


describe(Result::class, function() {
    beforeEach(function() {
        $this->rootDirectory = __DIR__ . '/../fixtures/src/';
        $this->fixtureFilePath = $this->rootDirectory . 'foo.php';
    });

    describe('#fromArray', function() {
        beforeEach(function() {
            $results = [
                $this->fixtureFilePath => [
                    1 => LineResult::EXECUTED
                ]
            ];
            $this->returnValue = Result::fromArray($results);
        });
        it('return cloak\driver\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf(Result::class);
        });
    });

    describe('#addFile', function() {
        beforeEach(function() {
            $this->result = new Result();
            $this->result->addFile(new FileResult($this->fixtureFilePath));
        });
        it('add file', function() {
            expect($this->result->getFileCount())->toEqual(1);
        });
    });

    describe('#isEmpty', function() {
        context('when empty', function() {
            beforeEach(function() {
                $this->result = new Result();
            });
            it('return true', function() {
                expect($this->result->isEmpty())->toBeTrue();
            });
        });
        context('when not empty', function() {
            beforeEach(function() {
                $this->result = new Result();
                $this->result->addFile(new FileResult($this->fixtureFilePath));
            });
            it('return false', function() {
                expect($this->result->isEmpty())->toBeFalse();
            });
        });
    });

});

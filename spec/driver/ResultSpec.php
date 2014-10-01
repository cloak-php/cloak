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
use cloak\driver\result\File;
use cloak\result\Line;


describe('Result', function() {
    before(function() {
        $this->rootDirectory = __DIR__ . '/../fixtures/src/';
        $this->fixtureFilePath = $this->rootDirectory . 'foo.php';
    });

    describe('#from', function() {
        before(function() {
            $results = [
                $this->fixtureFilePath => [
                    1 => Line::EXECUTED
                ]
            ];
            $this->returnValue = Result::fromArray($results);
        });
        it('return cloak\driver\Result instance', function() {
            expect($this->returnValue)->toBeAnInstanceOf('cloak\driver\Result');
        });
    });

    describe('#addFile', function() {
        before(function() {
            $this->result = new Result();
            $this->result->addFile(new File($this->fixtureFilePath));
        });
        it('add file', function() {
            expect(count($this->result))->toEqual(1);
        });
    });
});

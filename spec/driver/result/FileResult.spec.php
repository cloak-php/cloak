<?php

/**
 * This file is part of cloak.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use cloak\driver\result\FileResult;
use cloak\driver\result\FileNotFoundException;

describe(FileResult::class, function() {
    describe('#__construct', function() {
        context('when file not found', function() {
            it('throw cloak\driver\result\FileNotFoundException', function() {
                expect(function() {
                    new FileResult(__DIR__ . '/not_found.php');
                })->toThrow(FileNotFoundException::class);
            });
        });
        context('when not the path of the file', function() {
            it('cloak\driver\result\FileNotFoundException', function() {
                expect(function() {
                    new FileResult('systemlib.phpxml');
                })->toThrow(FileNotFoundException::class);
            });
        });
    });
    describe('#matchPath', function() {
        beforeEach(function() {
            $rootDirectory = __DIR__ . '/../../fixtures/src/';

            $filePath = $rootDirectory . 'foo.php';
            $this->file = new FileResult($filePath);
        });
        context('when match', function() {
            it('return true', function() {
                expect($this->file->matchPath('/fixtures'))->toBeTrue();
            });
        });
        context('when unmatch', function() {
            it('return false', function() {
                expect($this->file->matchPath('/bar'))->toBeFalse();
            });
        });
    });
});
